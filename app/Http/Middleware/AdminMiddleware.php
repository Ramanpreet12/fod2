<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::check() && Auth::user()->role === 'admin') {
        //     return $next($request);
        // }

        // abort(403, 'Unauthorized access.');

        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
         // Check if it's an API request
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. This endpoint is only accessible to administrators.',
            ], 403);
        }
        
        abort(403, 'This section is only accessible to administrators.');
    }
}