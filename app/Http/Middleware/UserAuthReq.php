<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthReq
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Continue with the request for authenticated users
            return $next($request);
        } else {
            // Store the current URL in the session for redirection after login
            session()->put('mt_session_url', url()->current());

            // Redirect unauthenticated users to the front login page
            return redirect()->route('front.login');
        }
    }
}
