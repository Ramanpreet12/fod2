<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

// class RestaurantMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {

//         if (Auth::check() && Auth::user()->role === 'restaurant_owner') {
//             return $next($request);
//         }

//         if ($request->expectsJson() || $request->is('api/*')) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Unauthorized. Restaurant access only.',
//             ], 403);
//         }

//         abort(403, 'This section is only accessible to restaurant owners.');
//     }
// }

class RestaurantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in using restaurant guard
        if (!Auth::guard('restaurant')->check()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please login as restaurant owner.',
                ], 401);
            }

            // Store intended URL if it's not the login page itself
            if (!$request->is('restaurant/login')) {
                session()->put('url.intended', url()->current());
            }

            return redirect()->route('restaurant.login')
                ->with('error', 'Please login as restaurant owner to access this section.');
        }

        // Check if logged in user has restaurant_owner role
        if (Auth::guard('restaurant')->user()->role !== 'restaurant_owner') {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Restaurant access only.',
                ], 403);
            }

            Auth::guard('restaurant')->logout();
            return redirect()->route('restaurant.login')
                ->with('error', 'This section is only accessible to restaurant owners.');
        }

        return $next($request);
    }
}
