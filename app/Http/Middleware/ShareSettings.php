<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShareSettings
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $settings = Setting::getAll();
            View::share('settings', $settings);
        } catch (\Exception $e) {
            \Log::error('Failed to load settings: ' . $e->getMessage());
            View::share('settings', []);
        }

        return $next($request);
    }
}
