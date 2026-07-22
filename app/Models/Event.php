<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'image',
        'location', 'starts_at', 'ends_at', 'is_featured', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at'   => 'datetime',
            'ends_at'     => 'datetime',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
