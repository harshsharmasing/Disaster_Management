<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checklist extends Model
{
    protected $fillable = [
        'user_id', 'title', 'disaster_type', 'items',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completionPercent(): int
    {
        $items = $this->items ?? [];
        if (empty($items)) return 0;
        $checked = count(array_filter($items, fn($i) => $i['checked'] ?? false));
        return (int) round(($checked / count($items)) * 100);
    }
}
