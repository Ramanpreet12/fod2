<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantLoginController extends Controller
{
    // public function showLoginForm()
    // {
    //     return view('auth.restaurant.login');
    // }

    // public function login(Request $request)
    // {
    //     return parent::login($request, 'restaurant');
    // }

    // protected function authenticated(Request $request, $user)
    // {
    //     return redirect()->route('restaurant.dashboard');
    // }


    public function showLoginForm()
    {
        return view('restaurant.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('restaurant')->attempt($credentials)) {
            $restaurant = Auth::guard('restaurant')->user();
            if ($restaurant->status !== 'active') {
                Auth::guard('restaurant')->logout();
                return back()->withErrors(['email' => 'Restaurant account is not active.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('/restaurant/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('restaurant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('restaurant.login');
    }

}
