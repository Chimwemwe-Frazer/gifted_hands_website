<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'brief_answer',
        'full_answer',
        'show_on_home',
        'status',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'show_on_home' => 'boolean',
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
            ->orderBy('question');
    }
}
