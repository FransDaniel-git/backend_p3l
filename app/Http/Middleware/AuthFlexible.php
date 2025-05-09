<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthFlexible
{
    public function handle($request, Closure $next)
    {
        // Log user details for debugging
        Log::info('Auth status check', ['user' => Auth::user()]);

        if (Auth::guard('api')->check()) {
            Auth::shouldUse('api');
            Log::info('Authenticated with API guard');
        } elseif (Auth::guard('web')->check()) {
            Auth::shouldUse('web');
            Log::info('Authenticated with Web guard');
        } else {
            Log::error('Unauthenticated request');
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return $next($request);
    }
}
