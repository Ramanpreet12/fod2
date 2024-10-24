<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckDeliveryAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('delivery')->check()) {
            return redirect()->route('delivery.login');
        }

        $deliveryBoy = Auth::guard('delivery')->user();
        if (!$deliveryBoy->is_approved) {
            Auth::guard('delivery')->logout();
            return redirect()->route('delivery.login')
                ->with('error', 'Your account is pending approval.');
        }

        return $next($request);
    }
}
