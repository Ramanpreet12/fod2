<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    // public function adminRegister(){
    //     return view('admin.register');
    // }
    // public function adminRegistration(Request $request){

    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => 'customer',
    //         'phone' => 13333,
    //         'address' => 'addres',
    //         'is_active' => true,
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect()->intended('/admin/dashboard');
    // }

   
        public function login(Request $request)
        {
            // If already logged in as admin, redirect to dashboard
            if (Auth::check() && Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
    
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
                ], [
                    'email.required' => 'Email is required',
                    'password.required' => 'Password is required'
                ]);
    
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput($request->except('password'));
                }
    
                // Attempt to authenticate using default guard
                if (Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                    'role' => 'admin' // Add role check in the authentication attempt
                ], $request->filled('remember'))) {
                    
                    $request->session()->regenerate();
    
                    // Handle remember me cookies if needed
                    // adding 3600 (seconds) means the cookies will expire in 1 hour. After this time, the cookies will no longer be available.
                    if ($request->filled('remember')) {
                        setcookie('email', $request->email, time() + 3600);
                        setcookie('password', $request->password, time() + 3600);
                    } else {
                        setcookie('email', '', time() - 3600);
                        setcookie('password', '', time() - 3600);
                    }
    
                    return redirect()->intended(route('admin.dashboard'))
                        ->with('success', 'Admin logged in successfully');
                }
    
                return redirect()->back()
                    ->with('error', 'Invalid email or password')
                    ->withInput($request->except('password'));
            }
    
            return view('admin.login');
        }
    

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function profile()
    {
        return 'profile';
    }
   

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect()->intended(route('admin.login'))
                        ->with('success', 'Admin logout in successfully');
    }

}
