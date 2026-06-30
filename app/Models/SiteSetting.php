<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Fetch a setting value by "group.key" with a cached lookup.
     */
    public static function get(string $group, string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return static::all()->groupBy('group')->map(
                fn ($items) => $items->pluck('value', 'key')
            );
        });

        return data_get($settings, "{$group}.{$key}", $default);
    }

    protected static function booted(): void
    {
        $flush = fn () => Cache::forget('site_settings');
        static::saved($flush);
        static::deleted($flush);
    }
}
