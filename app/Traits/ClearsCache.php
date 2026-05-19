<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsCache
{
    public static function bootClearsCache()
    {
        static::created(function () {
            self::clearLandingCache();
        });

        static::updated(function () {
            self::clearLandingCache();
        });

        static::deleted(function () {
            self::clearLandingCache();
        });
    }

    protected static function clearLandingCache(): void
    {
        Cache::flush();
    }
}