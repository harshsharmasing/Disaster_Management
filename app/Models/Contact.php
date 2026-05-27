<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'type', 'phone', 'city', 'state', 'is_available',
    ];

    protected function casts(): array
    {
        return ['is_available' => 'boolean'];
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeInCity($query, string $city)
    {
        return $query->whereRaw('LOWER(city) = ?', [strtolower($city)]);
    }

    public function typeColor(): string
    {
        return match ($this->type) {
            'hospital' => 'red',
            'police'   => 'blue',
            'fire'     => 'orange',
            'ngo'      => 'green',
            'helpline' => 'purple',
            default    => 'gray',
        };
    }
}
