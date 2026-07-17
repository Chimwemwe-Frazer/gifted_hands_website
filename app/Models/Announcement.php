<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'message',
        'image_path',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? asset('storage/'.$this->image_path)
            : null;
    }

    public function getPostedLabelAttribute(): string
    {
        if (! $this->published_at) {
            return 'Posted today';
        }

        $publishedDate = $this->published_at->copy()->startOfDay();
        $today = today();

        if ($publishedDate->equalTo($today)) {
            return 'Posted today';
        }

        if ($publishedDate->equalTo($today->copy()->subDay())) {
            return 'Posted yesterday';
        }

        $days = (int) abs($publishedDate->diffInDays($today));

        return "Posted {$days} days ago";
    }
}
