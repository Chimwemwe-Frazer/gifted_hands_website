<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicMediaTest extends TestCase
{
    public function test_staff_uploaded_images_stream_from_the_public_disk(): void
    {
        Storage::fake('public');

        $path = UploadedFile::fake()
            ->image('clinic-notice.jpg', 1200, 800)
            ->store('announcements', 'public');

        $response = $this->get(route('public.media', ['path' => $path]));

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
