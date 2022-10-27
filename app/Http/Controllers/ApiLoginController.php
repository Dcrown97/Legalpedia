<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
{

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. 
            Please try again']);
        }

        $userToken = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $userToken]);
    }
}
