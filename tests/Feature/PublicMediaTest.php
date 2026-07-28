<?php

namespace Tests\Feature;

use App\Services\UploadedImageStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicMediaTest extends TestCase
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

        $migration = require database_path('migrations/2026_07_28_000014_create_uploaded_images_table.php');
        $migration->up();
    }

    public function test_staff_uploaded_images_stream_from_persistent_storage(): void
    {
        $image = UploadedFile::fake()->image('clinic-notice.jpg', 1200, 800);
        $expectedContents = $image->getContent();
        $path = app(UploadedImageStorage::class)->store($image, 'announcements');

        $response = $this->get(route('public.media', ['path' => $path], false));

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg')
            ->assertHeader('Content-Length', (string) strlen($expectedContents))
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        $this->assertSame($expectedContents, $response->getContent());
        $this->assertDatabaseHas('uploaded_images', [
            'path' => $path,
            'size' => strlen($expectedContents),
        ]);
    }

    public function test_legacy_public_disk_images_still_stream(): void
    {
        Storage::fake('public');

        $path = UploadedFile::fake()
            ->image('clinic-notice.jpg', 1200, 800)
            ->store('announcements', 'public');

        $response = $this->get(route('public.media', ['path' => $path], false));

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg')
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        $this->assertStringContainsString(
            'public',
            $response->headers->get('Cache-Control') ?? ''
        );
    }

    public function test_public_media_rejects_unmanaged_or_unsafe_paths(): void
    {
        Storage::fake('public');

        UploadedFile::fake()
            ->image('internal.jpg', 800, 500)
            ->store('private', 'public');

        Storage::disk('public')->put('announcements/readme.txt', 'not an image');

        $this->get('/media/private/internal.jpg')->assertNotFound();
        $this->get('/media/announcements/readme.txt')->assertNotFound();
    }
}
