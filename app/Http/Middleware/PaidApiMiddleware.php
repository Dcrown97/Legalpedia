<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PaidApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $token = auth()->user()->api_access_token;

        // Check if the token exists in your database or configuration
        $validToken = $request->api_key;

        if ($token !== $validToken) {
            return response()->json(['error' => 'Access Denied'], 401);
        }

        return $next($request);
    }
}
