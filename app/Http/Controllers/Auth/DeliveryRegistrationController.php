<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class DeliveryRegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.delivery.delivery-register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'delivery_boy',
            'phone' => 13333,
            'address' => 'addres',
            'is_active' => false, // Still keeping this false as they need admin approval
        ]);

        // Log the delivery boy in
        // auth()->login($user);
        Auth::login($user);

        // Redirect to delivery dashboard
        return redirect()->route('delivery.dashboard')
            ->with('status', 'Welcome! Please note that some features may be limited until admin approval.');
        // return redirect(route('dashboard', absolute: false));
    }

}
