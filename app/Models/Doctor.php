<?php

namespace App\Models;

use App\Models\Concerns\HasPublicImageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    use HasPublicImageUrl;

    protected $fillable = [
        'name',
        'specialization',
        'qualification',
        'experience',
        'bio',
        'languages',
        'image_path',
        'status',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'languages' => 'array',
            'display_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'Active');
    }

    public function scopeDisplayOrder(Builder $query): Builder
    {
        return $query
            ->orderBy('display_order')
            ->orderBy('name');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->publicImageUrl($this->image_path);
    }
}
