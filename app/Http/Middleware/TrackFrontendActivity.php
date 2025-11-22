<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;
use Jenssegers\Agent\Agent;

class TrackFrontendActivity
{
    public function handle(Request $request, Closure $next)
    {
        // Skip tracking untuk routes admin, API, dan asset requests
        if (
            $request->is('admin/*') ||
            $request->is('api/*') ||
            $request->is('storage/*') ||
            $request->is('_debugbar/*') ||
            $request->ajax() ||
            $request->wantsJson()
        ) {
            return $next($request);
        }

        try {
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());

            // Detect device type
            if ($agent->isMobile()) {
                $deviceType = 'Mobile';
            } elseif ($agent->isTablet()) {
                $deviceType = 'Tablet';
            } else {
                $deviceType = 'Desktop';
            }

            // Detect browser
            $browser = $agent->browser();

            // Get or create session ID
            $sessionId = $request->session()->getId();

            // Determine page type based on route
            $pageType = $this->getPageType($request);

            // Log the activity
            activity('frontend')
                ->causedBy(auth()->user()) // null if guest
                ->withProperties([
                    'url' => $request->fullUrl(),
                    'path' => $request->path(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referer' => $request->header('referer'),
                    'device_type' => $deviceType,
                    'browser' => $browser,
                    'platform' => $agent->platform(),
                    'session_id' => $sessionId,
                    'page_type' => $pageType,
                    'route' => $request->route() ? $request->route()->getName() : 'unknown',
                ])
                ->log('Page viewed');

            // Update session last activity
            $request->session()->put('last_activity', now());
        } catch (\Exception $e) {
            // Log error but don't break the application
            Log::error('Activity tracking error: ' . $e->getMessage());
        }

        return $next($request);
    }

    /**
     * Determine page type based on request
     */
    private function getPageType(Request $request): string
    {
        $path = $request->path();
        $routeName = $request->route() ? $request->route()->getName() : '';

        // Home page
        if ($path === '/' || $routeName === 'home') {
            return 'home';
        }

        // Blog/Articles
        if (str_contains($path, 'posts') || str_contains($path, 'blog') || str_contains($routeName, 'posts')) {
            return 'blog';
        }

        // Programs
        if (str_contains($path, 'programs') || str_contains($routeName, 'programs')) {
            return 'programs';
        }

        // Donations
        if (str_contains($path, 'donations') || str_contains($routeName, 'donations')) {
            return 'donations';
        }

        // Gallery
        if (str_contains($path, 'gallery') || str_contains($routeName, 'gallery')) {
            return 'gallery';
        }

        // Schedules
        if (str_contains($path, 'schedules') || str_contains($routeName, 'schedules')) {
            return 'schedules';
        }

        // Staff/About
        if (str_contains($path, 'staff') || str_contains($path, 'about') || str_contains($routeName, 'staff')) {
            return 'about';
        }

        // Contact
        if (str_contains($path, 'contact') || str_contains($routeName, 'contact')) {
            return 'contact';
        }

        // Pages
        if (str_contains($path, 'pages') || str_contains($routeName, 'pages')) {
            return 'page';
        }

        return 'other';
    }
}
