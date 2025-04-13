<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthCheck
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
        // Retrieve headers from the request
        $header = $request->header();

        // Check if the 'x-api-key' header is present and has the correct value
        if (isset($header['x-api-key']) && $header['x-api-key'][0] == '_@@mot4ai-secu2023re@@_') {
            // Check if the user is authenticated as an admin
            $auth = auth()->guard('admin')->user();
            if ($auth == null) {
                // Continue with the request if not logged in
                return $next($request);
            }

            // Return a JSON response if the admin is already logged in
            return response()->json(['status' => 1000, 'msg' => 'You are already logged in!']);
        }

        // Return a JSON response for an invalid API key
        return response()->json(['status' => 1000, 'error' => ['error' => ['Invalid API key.']]]);
    }
}
