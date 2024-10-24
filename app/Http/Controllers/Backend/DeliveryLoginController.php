<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DeliveryLoginController extends Controller
{
    // public function showLoginForm()
    // {
    //     return view('auth.delivery.login');
    // }

    // public function login(Request $request)
    // {
    //     return parent::login($request, 'delivery');
    // }

    // protected function authenticated(Request $request, $user)
    // {
    //     if (!$user->is_approved) {
    //         auth()->guard('delivery')->logout();
    //         return redirect()->route('delivery.login')
    //             ->with('error', 'Your account is pending approval.');
    //     }
    //     return redirect()->route('delivery.dashboard');
    // }

    public function showLoginForm()
    {
        return view('delivery.auth.login');
    }

    public function showRegistrationForm()
    {
        return view('delivery.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:delivery_boys'],
            'password' => ['required', 'min:8', 'confirmed'],
            'phone' => ['required', 'string'],
            'vehicle_type' => ['required', 'string'],
            'vehicle_number' => ['required', 'string'],
        ]);

        $deliveryBoy = DeliveryBoy::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_number' => $validated['vehicle_number'],
        ]);

        return redirect()->route('delivery.login')
            ->with('status', 'Registration successful. Please wait for admin approval.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('delivery')->attempt($credentials)) {
            $deliveryBoy = Auth::guard('delivery')->user();
            if ($deliveryBoy->status !== 'approved') {
                Auth::guard('delivery')->logout();
                return back()->withErrors(['email' => 'Account pending approval.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('/delivery/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('delivery')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('delivery.login');
    }
}
