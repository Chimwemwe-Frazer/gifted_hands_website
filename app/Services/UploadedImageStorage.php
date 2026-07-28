<?php

namespace App\Services;

use App\Models\UploadedImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class UploadedImageStorage
{
    private const ALLOWED_DIRECTORIES = [
        'announcements',
        'doctors',
        'services',
    ];

    public function store(UploadedFile $file, string $directory): string
    {
        if (! in_array($directory, self::ALLOWED_DIRECTORIES, true)) {
            throw new InvalidArgumentException('The image directory is not managed by the public website.');
        }

        $contents = $file->getContent();
        $mimeType = (string) $file->getMimeType();
        $extension = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => throw new InvalidArgumentException('The uploaded file is not a supported image.'),
        };

        if ($contents === '') {
            throw new RuntimeException('The uploaded image is empty.');
        }

        $path = $directory.'/'.Str::uuid().'.'.$extension;

        UploadedImage::create([
            'path' => $path,
            'mime_type' => $mimeType,
            'size' => strlen($contents),
            'contents' => base64_encode($contents),
        ]);

        return $path;
    }

    public function delete(?string $path): void
    {
        if (! $path || str_starts_with($path, 'imgs/')) {
            return;
        }

        UploadedImage::query()
            ->where('path', $path)
            ->delete();

        // Remove legacy filesystem uploads when they still exist.
        Storage::disk('public')->delete($path);
    }
}
