<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class CustomerController extends Controller
{
    
    public function dashboard(Request $request)
    {
        return new UserResource($request->user());
    }
    public function profile(Request $request)
    {
        return 'customerprofile';
    }
}
