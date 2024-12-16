<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
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
        if (Auth::check()) {
            // User is authenticated, proceed with the request
            return $next($request);
        }

        // For unauthenticated users, redirect to the login page with an error message
        if (!$request->expectsJson()) {
            return redirect()->route('login')->with('error', 'You must log in to access this page.');
        }

        // If the request expects JSON (e.g., an API), return a 401 Unauthorized response
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
