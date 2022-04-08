<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{

    public function register(Request $request){
        $result=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'role_id'=>$request->role_id,
            'password'=>Hash::make($request->password),
        ]);
        return $result;
    }



}
