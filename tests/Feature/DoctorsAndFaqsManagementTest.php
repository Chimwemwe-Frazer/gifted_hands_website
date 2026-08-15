<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DoctorsAndFaqsManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        DB::purge();
        DB::reconnect();

        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_04_02_065725_create_permission_tables.php',
            '2026_07_11_000002_create_services_table.php',
            '2026_07_17_000006_create_announcements_table.php',
            '2026_07_17_000007_add_announcement_permissions.php',
            '2026_07_17_000008_simplify_announcements.php',
            '2026_07_18_000009_add_frontend_details_to_services_table.php',
            '2026_07_18_000010_create_doctors_and_faqs_tables.php',
            '2026_07_18_000011_add_doctor_and_faq_permissions.php',
            '2026_07_28_000014_create_uploaded_images_table.php',
            '2026_08_15_000020_replace_obstetrics_doctor_with_allan_faiti.php',
        ] as $migrationFile) {
            $migration = require database_path('migrations/'.$migrationFile);
            $migration->up();
        }
    }

    public function test_authorised_staff_can_manage_doctors_with_an_optional_image(): void
    {
        Storage::fake('public');
        $user = $this->authorisedUser([
            'add doctor',
            'list doctors',
            'update doctor',
            'delete doctor',
        ]);

        $this
            ->actingAs($user)
            ->post(route('admin.doctors.store'), $this->doctorPayload())
            ->assertRedirect(route('admin.doctors.index'));

        $doctor = Doctor::where('name', 'Dr. Alice Tembo')->firstOrFail();

        $this->assertNull($doctor->image_path);
        $this->assertSame(['English', 'Chichewa'], $doctor->languages);

        $this->get(route('doctors'))
            ->assertOk()
            ->assertViewHas('doctors', fn ($doctors) => $doctors->count() === 4)
            ->assertSee('Dr. Alice Tembo')
            ->assertSee('Dr Allan Faiti')
            ->assertSee('Clinical Associate Obstetrics and Gynaecology')
            ->assertSee('Dr. Daniel Kamanga')
            ->assertSee('Languages:')
            ->assertDontSee('MBBS, MMED Obstetrics &amp; Gynaecology', false)
            ->assertDontSee('Dr. Phiri supports women')
            ->assertSee('No Image Uploaded');

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('doctors', fn ($doctors) => $doctors->count() === 3)
            ->assertSee('Dr. Alice Tembo')
            ->assertSee('Languages:')
            ->assertDontSee('MBBS, Diploma in Family Medicine')
            ->assertDontSee('Dr. Daniel Kamanga');

        $this
            ->actingAs($user)
            ->put(route('admin.doctors.update', $doctor), $this->doctorPayload([
                'image' => UploadedFile::fake()->image('alice.jpg', 900, 900),
            ]))
            ->assertRedirect(route('admin.doctors.index'));

        $doctor->refresh();
        $this->assertNotNull($doctor->image_path);
        $this->assertDatabaseHas('uploaded_images', [
            'path' => $doctor->image_path,
            'mime_type' => 'image/jpeg',
        ]);
        Storage::disk('public')->assertMissing($doctor->image_path);

        $imagePath = $doctor->image_path;
        $imageUrl = route('public.media', ['path' => $imagePath], false);

        $this->get(route('doctors'))
            ->assertOk()
            ->assertSee($imageUrl, false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($imageUrl, false);

        $this->get($imageUrl)
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg');

        $this
            ->actingAs($user)
            ->delete(route('admin.doctors.destroy', $doctor))
            ->assertRedirect(route('admin.doctors.index'));

        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
        $this->assertDatabaseMissing('uploaded_images', ['path' => $imagePath]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    public function test_authorised_staff_can_manage_faqs_and_feature_them_on_the_homepage(): void
    {
        $user = $this->authorisedUser([
            'add faq',
            'list faqs',
            'update faq',
            'delete faq',
        ]);

        $this
            ->actingAs($user)
            ->post(route('admin.faqs.store'), $this->faqPayload())
            ->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::where('question', 'Are weekend appointments available?')->firstOrFail();

        $this->assertTrue($faq->show_on_home);

        $this->get(route('faqs'))
            ->assertOk()
            ->assertSee('Are weekend appointments available?')
            ->assertSee('Weekend availability should be confirmed with the clinic before travelling.');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Are weekend appointments available?')
            ->assertSee('Please call ahead to confirm weekend availability.');

        $this
            ->actingAs($user)
            ->put(route('admin.faqs.update', $faq), $this->faqPayload([
                'brief_answer' => 'Call the clinic to confirm weekend opening times.',
                'show_on_home' => null,
            ]))
            ->assertRedirect(route('admin.faqs.index'));

        $faq->refresh();
        $this->assertFalse($faq->show_on_home);
        $this->assertSame('Call the clinic to confirm weekend opening times.', $faq->brief_answer);

        $this
            ->actingAs($user)
            ->delete(route('admin.faqs.destroy', $faq))
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    public function test_homepage_displays_only_the_four_most_recent_pinned_active_faqs(): void
    {
        Faq::query()->update(['show_on_home' => false]);

        $recentFaqs = collect();

        foreach (range(1, 5) as $index) {
            $faq = Faq::create([
                'question' => "Recently added FAQ {$index}",
                'brief_answer' => "Brief answer {$index}",
                'full_answer' => "Full answer {$index}",
                'show_on_home' => $index <= Faq::HOMEPAGE_LIMIT,
                'status' => 'Active',
                'display_order' => 100 + $index,
            ]);

            $faq->forceFill([
                'created_at' => now()->addMinutes($index),
            ])->saveQuietly();

            $recentFaqs->push($faq);
        }

        $expectedHomepageIds = $recentFaqs
            ->where('show_on_home', true)
            ->sortByDesc('created_at')
            ->pluck('id')
            ->values()
            ->all();

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('faqs', fn ($faqs) => $faqs->pluck('id')->all() === $expectedHomepageIds)
            ->assertDontSee('Recently added FAQ 5');

        $this->get(route('faqs'))
            ->assertOk()
            ->assertViewHas('faqs', fn ($faqs) => $recentFaqs->pluck('id')->diff($faqs->pluck('id'))->isEmpty())
            ->assertSee('Recently added FAQ 5');
    }

    public function test_admin_cannot_pin_more_than_four_faqs_to_the_homepage(): void
    {
        $user = $this->authorisedUser(['add faq']);

        Faq::query()->update(['show_on_home' => false]);
        Faq::query()
            ->orderBy('id')
            ->take(Faq::HOMEPAGE_LIMIT)
            ->update(['show_on_home' => true]);

        $this
            ->actingAs($user)
            ->post(route('admin.faqs.store'), $this->faqPayload([
                'question' => 'Can a fifth FAQ be pinned?',
            ]))
            ->assertSessionHasErrors('show_on_home');

        $this->assertDatabaseMissing('faqs', [
            'question' => 'Can a fifth FAQ be pinned?',
        ]);
    }

    private function authorisedUser(array $permissions): User
    {
        $user = User::factory()->create();

        foreach ($permissions as $permissionName) {
            $user->givePermissionTo(Permission::findOrCreate($permissionName));
        }

        return $user;
    }

    private function doctorPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Dr. Alice Tembo',
            'specialization' => 'Family Medicine',
            'qualification' => 'MBBS, Diploma in Family Medicine',
            'experience' => '8 years',
            'bio' => 'Dr. Tembo provides family-focused consultations and ongoing care.',
            'languages' => "English\nChichewa",
            'status' => 'Active',
            'display_order' => 1,
        ], $overrides);
    }

    private function faqPayload(array $overrides = []): array
    {
        return array_merge([
            'question' => 'Are weekend appointments available?',
            'brief_answer' => 'Please call ahead to confirm weekend availability.',
            'full_answer' => 'Weekend availability should be confirmed with the clinic before travelling.',
            'show_on_home' => '1',
            'status' => 'Active',
            'display_order' => 1,
        ], $overrides);
    }
}
