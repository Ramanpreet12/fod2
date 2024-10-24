<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function showDeliveryRegistration(Request $request){
       
        if ($request->isMethod('post')) {
        }else{

            return view('admin.delivery.register');
        }
    }

    public function dashboard(){
        return 'delivery';
    }
    public function profile(){
        return 'profile';
    }
}
