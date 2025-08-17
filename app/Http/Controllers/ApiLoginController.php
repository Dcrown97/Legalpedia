<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{

    public function login(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. Please try again']);
        }

        // $userToken = auth()->user()->createToken('API Token')->accessToken;
        $userToken = $request->user()->createToken('API Token')->plainTextToken;
        // dd($userToken);
        $user = User::where('id', Auth::user()->id)->with('package')->first();
        $messages = Message::where('type', 'in-app')
            ->orderBy('created_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();
        $message_count = $messages->count();

        return response(['user' => $user, 'messages' => $messages, 'message_count' => $message_count, 'token' => $userToken]);

        // if(Auth::attempt([
        //      'email' => $request->email,
        //      'password' => $request->password
        // ])) {
        //     $user = Auth::user();
        //     $userToken = [];
        //     $userToken['token'] = $user->createToken('API Token')->accessToken;
        //     $userToken['name'] = $user->name;
        //     return response()->json($userToken, 200);
        // }else{
        //     return response(['errors' => 'Unauthorized Access'], 203);
        // }
    }

    public function logout(Request $request)
    {
        // dd($request->user()->token());
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
