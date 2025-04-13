<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthReqCheck
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

            // If authenticated, add the admin user to the request data
            if ($auth != null) {
                $request->request->add(['sessionUser' => $auth]);
                return $next($request);
            }

            // Return a JSON response for an unauthorized request
            return response()->json(['status' => 1000, 'error' => ['error' => ['Invalid Request!']]], 401);
        }

        // Return a JSON response for an invalid API key
        return response()->json(['status' => 1000, 'error' => ['error' => ['Invalid API key.']]], 401);
    }
}
