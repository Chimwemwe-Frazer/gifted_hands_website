<?php

namespace App\Models\Concerns;

trait HasPublicImageUrl
{
    protected function publicImageUrl(?string $imagePath): ?string
    {
        if (! $imagePath) {
            return null;
        }

        $imagePath = ltrim(str_replace('\\', '/', $imagePath), '/');

        return str_starts_with($imagePath, 'imgs/')
            ? asset($imagePath)
            : route('public.media', ['path' => $imagePath], false);
    }
}
