<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        return Setting::getAll();
    }
}