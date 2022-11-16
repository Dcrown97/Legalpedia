<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
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
        // dd($request->getRequestUri());
        if (strpos($request->getRequestUri(), 'api')) { 
            $request->headers->set('Accept', 'application/json');
        };
        return $next($request);
    }
}
