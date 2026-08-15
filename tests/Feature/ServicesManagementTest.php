<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ServicesManagementTest extends TestCase
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
            '2026_07_11_000003_create_appointments_table.php',
            '2026_07_17_000006_create_announcements_table.php',
            '2026_07_17_000007_add_announcement_permissions.php',
            '2026_07_17_000008_simplify_announcements.php',
            '2026_07_18_000009_add_frontend_details_to_services_table.php',
            '2026_07_18_000010_create_doctors_and_faqs_tables.php',
            '2026_07_28_000014_create_uploaded_images_table.php',
            '2026_08_14_000015_add_scanning_service.php',
            '2026_08_14_000016_update_general_consultation_image.php',
            '2026_08_14_000017_update_physiotherapy_image.php',
            '2026_08_14_000018_update_laboratory_image.php',
            '2026_08_15_000019_update_obstetrics_gynaecology_image.php',
        ] as $migrationFile) {
            $migration = require database_path('migrations/'.$migrationFile);
            $migration->up();
        }
    }

    public function test_active_services_are_limited_on_the_homepage_and_all_render_on_the_services_page(): void
    {
        Service::create([
            'name' => 'Nutrition Therapy',
            'description' => 'Personalized nutrition support for patients and families.',
            'included_items' => ['Nutrition assessment', 'Personalized meal guidance'],
            'needs_treated' => 'Diet-related health concerns and nutrition support.',
            'items_to_bring' => ['Recent test results', 'Current medicine list'],
            'appointment_details' => 'Appointments are preferred.',
            'duration_minutes' => 45,
            'fee' => 15000,
            'display_order' => 7,
            'status' => 'Active',
        ]);

        Service::create([
            'name' => 'Hidden Internal Service',
            'description' => 'This service must not be public.',
            'included_items' => ['Internal item'],
            'needs_treated' => 'Internal needs.',
            'items_to_bring' => ['Internal item'],
            'appointment_details' => 'Internal appointment information.',
            'duration_minutes' => 30,
            'fee' => 0,
            'display_order' => 7,
            'status' => 'Inactive',
        ]);

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Nutrition Therapy')
            ->assertSee('Scanning')
            ->assertSee('imgs/services/_MG_2064.jpg', false)
            ->assertSee('imgs/services/_MG_2068.jpg', false)
            ->assertSee('imgs/services/_MG_2134.jpg', false)
            ->assertSee('imgs/services/obstetrics&amp;gynaecology.jpg', false)
            ->assertSee('imgs/services/physiotherapy picture.jpeg', false)
            ->assertSee('Nutrition assessment')
            ->assertSee('No Image Uploaded')
            ->assertDontSee('Hidden Internal Service');

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('featuredServices', fn ($services) => $services->count() === 6)
            ->assertViewHas('services', fn ($services) => $services->count() === 7)
            ->assertSee('Scanning')
            ->assertSee('Nutrition Therapy')
            ->assertDontSee('Personalized nutrition support for patients and families.')
            ->assertDontSee('Hidden Internal Service');
    }

    public function test_authorised_staff_can_add_edit_remove_an_image_and_delete_a_service(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        foreach (['add service', 'list services', 'update service', 'delete service'] as $permissionName) {
            $user->givePermissionTo(Permission::findOrCreate($permissionName));
        }

        $response = $this
            ->actingAs($user)
            ->post(route('admin.services.store'), $this->servicePayload());

        $response->assertRedirect(route('admin.services.index'));

        $service = Service::where('name', 'Diet and Nutrition')->firstOrFail();

        $this->assertNull($service->image_path);
        $this->assertSame(
            ['Nutrition assessment', 'Meal planning support'],
            $service->included_items
        );

        $imagePayload = $this->servicePayload([
            'image' => UploadedFile::fake()->image('nutrition.jpg', 900, 600),
            'display_order' => 1,
        ]);

        $this
            ->put(route('admin.services.update', $service), $imagePayload)
            ->assertRedirect(route('admin.services.index'));

        $service->refresh();

        $this->assertNotNull($service->image_path);
        $this->assertDatabaseHas('uploaded_images', [
            'path' => $service->image_path,
            'mime_type' => 'image/jpeg',
        ]);
        Storage::disk('public')->assertMissing($service->image_path);

        $oldImagePath = $service->image_path;
        $imageUrl = route('public.media', ['path' => $oldImagePath], false);

        $this->get(route('services'))
            ->assertOk()
            ->assertSee($imageUrl, false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($imageUrl, false);

        $this->get($imageUrl)
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg');

        $this
            ->put(route('admin.services.update', $service), $this->servicePayload([
                'remove_image' => '1',
            ]))
            ->assertRedirect(route('admin.services.index'));

        $service->refresh();

        $this->assertNull($service->image_path);
        $this->assertDatabaseMissing('uploaded_images', ['path' => $oldImagePath]);
        Storage::disk('public')->assertMissing($oldImagePath);

        $this
            ->delete(route('admin.services.destroy', $service))
            ->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    private function servicePayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Diet and Nutrition',
            'description' => 'Professional nutrition assessment and practical dietary guidance.',
            'included_items' => "Nutrition assessment\nMeal planning support",
            'needs_treated' => 'Diet-related concerns, weight support, and nutrition planning.',
            'items_to_bring' => "Recent test results\nCurrent medicine list",
            'appointment_details' => 'Appointments are preferred so enough consultation time can be reserved.',
            'duration_minutes' => 45,
            'fee' => 15000,
            'display_order' => 7,
            'status' => 'Active',
        ], $overrides);
    }
}
