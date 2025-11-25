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
        Cache::forget('landing_page_v5');
        Cache::forget('about_page_v4');
        Cache::forget('blog_sidebar_v3');
        Cache::forget('donations_stats_v3');
    }
}