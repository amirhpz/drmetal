<?php

namespace App\Models;

use App\Support\PersianNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MetalPrice extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'price',
        'unit',
        'currency',
        'change_amount',
        'change_percent',
        'direction',
        'source',
        'provider',
        'last_updated_at',
        'is_stale',
        'is_active',
        'sort_order',
        'raw_payload',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:4',
            'change_amount' => 'decimal:4',
            'change_percent' => 'decimal:4',
            'last_updated_at' => 'datetime',
            'is_stale' => 'boolean',
            'is_active' => 'boolean',
            'raw_payload' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function isUp(): bool
    {
        return $this->direction === 'up';
    }

    public function isDown(): bool
    {
        return $this->direction === 'down';
    }

    public function isNeutral(): bool
    {
        return $this->direction === 'neutral';
    }

    public function formattedPrice(): string
    {
        $decimals = $this->currency === 'IRT' || $this->unit === 'تومان' ? 0 : 2;

        return PersianNumber::digits(number_format((float) $this->price, $decimals));
    }

    public function formattedChangePercent(): string
    {
        $value = $this->change_percent === null ? 0 : (float) $this->change_percent;
        $prefix = $value > 0 ? '+' : '';

        return PersianNumber::digits($prefix.number_format($value, 2)).'%';
    }
}
