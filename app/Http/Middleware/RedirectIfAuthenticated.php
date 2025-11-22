<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika user sudah login dan mengakses halaman landing page atau root
                // redirect ke admin dashboard
                if ($request->is('/') || $request->is('home')) {
                    return redirect()->route('admin.dashboard');
                }

                // Jika user sudah login dan mengakses halaman login/register
                // redirect ke admin dashboard
                if ($request->is('login') || $request->is('register')) {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}
