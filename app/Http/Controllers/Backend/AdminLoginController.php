<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{
    // public function showLoginForm()
    // {
    //     return view('auth.admin.login');
    // }

    // public function login(Request $request)
    // {
    //     return parent::login($request);
    // }

    // protected function authenticated(Request $request, $user)
    // {
    //     if ($user->role !== 'admin') {
    //         auth()->logout();
    //         return back()->withErrors(['email' => 'You are not authorized.']);
    //     }
    //     return redirect()->route('admin.dashboard');
    // }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized access.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
