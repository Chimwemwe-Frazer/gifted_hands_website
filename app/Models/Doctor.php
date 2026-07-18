<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

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
        if (! $this->image_path) {
            return null;
        }

        return str_starts_with($this->image_path, 'imgs/')
            ? asset($this->image_path)
            : asset('storage/'.$this->image_path);
    }
}
