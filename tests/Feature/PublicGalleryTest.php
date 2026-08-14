<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublicGalleryTest extends TestCase
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

    public function test_homepage_shows_three_gallery_items_and_gallery_page_shows_all_items(): void
    {
        $homepage = $this->get(route('home'));

        $homepage->assertOk();
        $this->assertSame(3, substr_count($homepage->getContent(), 'data-gallery-item'));
        $homepage
            ->assertSee('imgs/_MG_2080.jpg', false)
            ->assertSee('imgs/consultation room.jpeg', false)
            ->assertSee('imgs/services/physiotherapy picture.jpeg', false);

        $galleryPage = $this->get(route('gallery'));

        $galleryPage->assertOk();
        $this->assertSame(9, substr_count($galleryPage->getContent(), 'data-gallery-item'));
        $galleryPage
            ->assertSee('Clinic moments gallery')
            ->assertSee('imgs/medical team one.jpeg', false)
            ->assertSee('imgs/_MG_2080.jpg', false)
            ->assertSee('imgs/consultation room.jpeg', false)
            ->assertSee('imgs/services/_MG_2134.jpg', false)
            ->assertSee('imgs/Medical team home page.jpeg', false)
            ->assertSee('imgs/medical team two.jpeg', false)
            ->assertSee('imgs/medical team three.jpeg', false)
            ->assertSee('imgs/medical team four.jpeg', false)
            ->assertSee('imgs/services/physiotherapy picture.jpeg', false)
            ->assertDontSee('Clinic Exterior');
    }
}
