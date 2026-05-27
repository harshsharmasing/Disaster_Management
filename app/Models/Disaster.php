<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'type', 'severity', 'description',
        'what_to_do', 'what_not_to_do', 'region', 'is_active',
        'views', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'views' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Route model binding by slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Scope: only active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: filter by type
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // Color for severity badge
    public function severityColor(): string
    {
        return match ($this->severity) {
            'critical' => 'red',
            'high'     => 'orange',
            'medium'   => 'yellow',
            'low'      => 'green',
        };
    }

    // Icon for disaster type
    public function typeIcon(): string
    {
        return match ($this->type) {
            'flood'     => '🌊',
            'earthquake'=> '🏚️',
            'cyclone'   => '🌀',
            'fire'      => '🔥',
            'landslide' => '⛰️',
            'pandemic'  => '🦠',
            default     => '⚠️',
        };
    }
}
