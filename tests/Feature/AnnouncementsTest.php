<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AnnouncementsTest extends TestCase
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
        ] as $migrationFile) {
            $migration = require database_path('migrations/'.$migrationFile);
            $migration->up();
        }
    }

    public function test_it_renders_text_only_and_image_announcements_using_their_intended_layouts(): void
    {
        Announcement::create([
            'category' => 'Community',
            'title' => 'New Outreach Programme',
            'message' => 'Join our community health outreach programme this month.',
            'image_path' => 'announcements/outreach.jpg',
            'published_at' => now(),
        ]);

        $this->get(route('announcements'))
            ->assertOk()
            ->assertSee('Weekend Schedule Update')
            ->assertSee('New Outreach Programme')
            ->assertSee('Join our community health outreach programme this month.')
            ->assertSee('storage/announcements/outreach.jpg', false)
            ->assertSee('alt="New Outreach Programme"', false)
            ->assertSee('Posted Today');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('New Outreach Programme')
            ->assertSee('storage/announcements/outreach.jpg', false);
    }

    public function test_it_does_not_display_future_announcements_publicly(): void
    {
        Announcement::create([
            'category' => 'Scheduled',
            'title' => 'Future Announcement',
            'message' => 'This message should appear tomorrow.',
            'published_at' => now()->addDay(),
        ]);

        $this->get(route('announcements'))
            ->assertOk()
            ->assertDontSee('Future Announcement');
    }

    public function test_public_announcements_show_relative_posted_days(): void
    {
        $this->travelTo(now()->startOfDay()->addHours(12));

        foreach ([
            ['Posted Today Notice', now()],
            ['Posted Yesterday Notice', now()->subDay()],
            ['Posted Five Days Ago Notice', now()->subDays(5)],
        ] as [$title, $publishedAt]) {
            Announcement::create([
                'category' => 'Updates',
                'title' => $title,
                'message' => 'Relative date label test.',
                'published_at' => $publishedAt,
            ]);
        }

        $this->get(route('announcements'))
            ->assertOk()
            ->assertSee('class="text-xs font-medium text-green-600">Posted Today', false)
            ->assertSee('class="text-xs font-medium text-green-600">Posted Yesterday', false)
            ->assertSee('class="text-xs font-medium text-gray-400">Posted 5 days ago', false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('class="text-xs font-medium text-green-600">Posted Today', false)
            ->assertSee('class="text-xs font-medium text-green-600">Posted Yesterday', false)
            ->assertSee('class="text-xs font-medium text-gray-400">Posted 5 days ago', false);

        $this->travelBack();
    }

    public function test_an_authorised_staff_member_can_publish_an_announcement_with_an_image_at_the_current_time(): void
    {
        Storage::fake('public');
        $this->travelTo(now()->startOfSecond());

        $user = User::factory()->create();
        $permission = Permission::findOrCreate('add announcement');
        $user->givePermissionTo($permission);
        $expectedCreationTime = now();

        $response = $this
            ->actingAs($user)
            ->post(route('admin.announcements.store'), [
                'category' => 'Services',
                'title' => 'New Service Available',
                'message' => 'A new clinic service is now available to visitors.',
                'image' => UploadedFile::fake()->image('service.jpg', 800, 500),
                'published_at' => now()->subYear()->toDateTimeString(),
                'status' => 'Draft',
            ]);

        $response->assertRedirect(route('admin.announcements.index'));

        $announcement = Announcement::where('title', 'New Service Available')->firstOrFail();

        $this->assertNotNull($announcement->published_at);
        $this->assertSame($expectedCreationTime->toDateTimeString(), $announcement->published_at->toDateTimeString());
        $this->assertNotNull($announcement->image_path);
        Storage::disk('public')->assertExists($announcement->image_path);
        $this->travelBack();
    }
}
