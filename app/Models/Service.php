<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'fee',
        'status',
        'image_path',
        'included_items',
        'needs_treated',
        'items_to_bring',
        'appointment_details',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'fee' => 'decimal:2',
            'included_items' => 'array',
            'items_to_bring' => 'array',
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

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
