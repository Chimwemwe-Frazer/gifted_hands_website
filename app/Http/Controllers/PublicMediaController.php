<?php

namespace App\Http\Controllers;

use App\Models\UploadedImage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicMediaController extends Controller
{
    private const ALLOWED_DIRECTORIES = [
        'announcements',
        'doctors',
        'services',
    ];

    public function __invoke(string $path): Response|StreamedResponse
    {
        $path = $this->normalizedPath($path);

        if (! $this->isAllowedPath($path)) {
            return $this->missingImageResponse();
        }

        $uploadedImage = UploadedImage::query()
            ->where('path', $path)
            ->first();

        if ($uploadedImage) {
            $contents = base64_decode($uploadedImage->contents, true);

            if ($contents === false || strlen($contents) !== $uploadedImage->size) {
                return $this->missingImageResponse();
            }

            return response($contents, 200, $this->imageHeaders(
                $uploadedImage->mime_type,
                $uploadedImage->size,
            ));
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return $this->missingImageResponse();
        }

        $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';

        if (! str_starts_with($mimeType, 'image/')) {
            return $this->missingImageResponse();
        }

        return $disk->response($path, null, $this->imageHeaders(
            $mimeType,
            $disk->size($path),
        ));
    }

    private function normalizedPath(string $path): string
    {
        return ltrim(str_replace('\\', '/', $path), '/');
    }

    private function isAllowedPath(string $path): bool
    {
        if ($path === '' || str_contains($path, '..')) {
            return false;
        }

        if (! preg_match('/\.(jpe?g|png|webp)$/i', $path)) {
            return false;
        }

        [$directory] = explode('/', $path, 2);

        return in_array($directory, self::ALLOWED_DIRECTORIES, true);
    }

    private function missingImageResponse(): Response
    {
        return response()
            ->noContent(404)
            ->header('Cache-Control', 'no-store')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    /**
     * @return array<string, string|int>
     */
    private function imageHeaders(string $mimeType, int $size): array
    {
        return [
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Content-Length' => $size,
            'Content-Type' => $mimeType,
            'X-Content-Type-Options' => 'nosniff',
        ];
    }
}
