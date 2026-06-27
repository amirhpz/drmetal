<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("site_setting.{$key}", function () use ($key, $default): mixed {
            return static::query()->where('key', $key)->value('value') ?? $default;
        });
    }

    public static function getGroup(string $group): array
    {
        return Cache::rememberForever("site_settings.group.{$group}", function () use ($group): array {
            return static::query()
                ->where('group', $group)
                ->pluck('value', 'key')
                ->all();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn (): bool => Cache::flush());
        static::deleted(fn (): bool => Cache::flush());
    }
}
