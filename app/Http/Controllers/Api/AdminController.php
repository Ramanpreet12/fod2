<?php

namespace App\Http\Controllers\Api;

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
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Check if the user is already logged in as admin
        // if (Auth::check() && Auth::user()->role === 'admin') {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Already logged in',
        //         'redirect_url' => route('admin.dashboard')
        //     ]);
        // }

        // if ($request->isMethod('post')) {
        //     // Validation rules
        //     $validator = Validator::make($request->all(), [
        //         'email' => 'required|email',
        //         'password' => 'required'
        //     ], [
        //         'email.required' => 'Email is required',
        //         'password.required' => 'Password is required'
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json([
        //             'success' => false,
        //             'errors' => $validator->errors()
        //         ], 422); // Validation error response with 422 status code
        //     }

        //     // Attempt to authenticate
        //     if (Auth::attempt([
        //         'email' => $request->email,
        //         'password' => $request->password,
        //         'role' => 'admin'
        //     ])) {

        //         // $request->session()->regenerate();

        //         return response()->json([
        //             'success' => true,
        //             'message' => 'Admin logged in successfully',
        //             'redirect_url' => route('admin.dashboard')
        //         ]);
        //     }

        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Invalid email or password'
        //     ], 401); // Unauthorized response
        // }

        // return response()->json([
        //     'success' => false,
        //     'message' => 'Method not allowed'
        // ], 405); // Method not allowed response

        try {
            $validated = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Revoke previous tokens
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Admin Login successful',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    // 'redirect_url' => route('admin.dashboard')
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Admin Login failed',
                'errors' => $e->errors()
            ], 422);
        }

    }


    public function dashboard()
    {
        return 'Admi boy';
    }
    public function profile()
    {
        return 'Admin profile';
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Admin Successfully logged out'
        ]);
    }
}
