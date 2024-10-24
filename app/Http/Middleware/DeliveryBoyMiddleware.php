<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DeliveryBoyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    // DeliveryBoyMiddleware.php
// public function handle(Request $request, Closure $next): Response
// {

//     if (Auth::check() && Auth::user()->role === 'delivery_boy') {
//         return $next($request);
//     }

//             // Check if it's an API request (either expects JSON or using sanctum guard)

//     if ($request->expectsJson() || $request->is('api/*')) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Unauthorized. This endpoint is only accessible to delivery personnel.',
//         ], 403);
//     }

//     abort(403, 'This section is only accessible to delivery personnel.');
// }

public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('delivery')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return redirect()->route('delivery.login');
        }

        $deliveryBoy = Auth::guard('delivery')->user();
        if ($deliveryBoy->status !== 'approved') {
            Auth::guard('delivery')->logout();
            return redirect()->route('delivery.login')
                ->with('error', 'Your account is pending approval.');
        }

        return $next($request);
    }

}
