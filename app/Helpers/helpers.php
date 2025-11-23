<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Log;



if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $allSettings = null;

        if ($allSettings === null) {
            try {
                $allSettings = Setting::getAll();
            } catch (\Exception $e) {
                \Log::error("Failed to get settings: " . $e->getMessage());
                $allSettings = [];
            }
        }

        return $allSettings[$key] ?? $default;
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        return setting('_all_');
    }
}
