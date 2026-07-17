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
            'image_alt' => 'Clinic staff preparing for community outreach',
            'image_position' => 'right',
            'status' => 'Published',
            'published_at' => now(),
        ]);

        $this->get(route('announcements'))
            ->assertOk()
            ->assertSee('Weekend Schedule Update')
            ->assertSee('New Outreach Programme')
            ->assertSee('Join our community health outreach programme this month.')
            ->assertSee('storage/announcements/outreach.jpg', false)
            ->assertSee('md:order-2', false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('New Outreach Programme')
            ->assertSee('storage/announcements/outreach.jpg', false);
    }

    public function test_it_does_not_display_draft_or_future_announcements_publicly(): void
    {
        Announcement::create([
            'category' => 'Internal',
            'title' => 'Unpublished Draft',
            'message' => 'This message is not ready for visitors.',
            'image_position' => 'left',
            'status' => 'Draft',
        ]);

        Announcement::create([
            'category' => 'Scheduled',
            'title' => 'Future Announcement',
            'message' => 'This message should appear tomorrow.',
            'image_position' => 'left',
            'status' => 'Published',
            'published_at' => now()->addDay(),
        ]);

        $this->get(route('announcements'))
            ->assertOk()
            ->assertDontSee('Unpublished Draft')
            ->assertDontSee('Future Announcement');
    }

    public function test_an_authorised_staff_member_can_publish_an_announcement_with_an_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $permission = Permission::findOrCreate('add announcement');
        $user->givePermissionTo($permission);

        $response = $this
            ->actingAs($user)
            ->post(route('admin.announcements.store'), [
                'category' => 'Services',
                'title' => 'New Service Available',
                'message' => 'A new clinic service is now available to visitors.',
                'image' => UploadedFile::fake()->image('service.jpg', 800, 500),
                'image_alt' => 'The new clinic service area',
                'image_position' => 'right',
                'status' => 'Published',
            ]);

        $response->assertRedirect(route('admin.announcements.index'));

        $announcement = Announcement::where('title', 'New Service Available')->firstOrFail();

        $this->assertSame('right', $announcement->image_position);
        $this->assertNotNull($announcement->published_at);
        $this->assertNotNull($announcement->image_path);
        Storage::disk('public')->assertExists($announcement->image_path);
    }
}
