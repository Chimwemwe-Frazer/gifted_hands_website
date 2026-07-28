<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'mime_type',
        'size',
        'contents',
    ];

    protected $hidden = [
        'contents',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }
}
