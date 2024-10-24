<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function login(Request $request, $guard = null)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();
            return $this->authenticated($request, Auth::guard($guard)->user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        // Override in child controllers
        return redirect()->intended('/');
    }

    public function logout($guard = null)
    {
        Auth::guard($guard)->logout();
        return redirect('/');
    }
}
