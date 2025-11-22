<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Track route access
            $route = $request->route();
            $routeName = $route ? $route->getName() : 'unknown';
            $method = $request->method();
            $url = $request->fullUrl();
            $ip = $request->ip();
            $userAgent = $request->userAgent();

            // Log activity
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'route' => $routeName,
                    'method' => $method,
                    'url' => $url,
                    'ip' => $ip,
                    'user_agent' => $userAgent,
                    'referer' => $request->header('referer'),
                    'timestamp' => now(),
                    'session_id' => session()->getId(),
                ])
                ->log('page_visit');
        }

        return $next($request);
    }
}
