<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Get the route name from the current request
        $path = Request::route()->getName();

        // Check if the admin is authenticated
        if (Auth::guard('admin')->check()) {
            // If authenticated and accessing the login route, redirect to the admin dashboard
            if ($path == 'lvs.auth') {
                return redirect()->route('lvs.home.any', 'dashboard');
            } else {
                // Continue with the request for other routes
                return $next($request);
            }
        } else {
            // If not authenticated and accessing the login route, continue with the request
            if ($path == 'lvs.auth') {
                return $next($request);
            } else {
                // If not authenticated and accessing other routes, redirect to the admin login page
                return redirect()->route('lvs.auth', 'login');
            }
        }
    }
}
