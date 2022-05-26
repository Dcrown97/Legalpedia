<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PasswordResetService;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $passwordResetService;

    public function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
    }

    public function forgotPasswordPost(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);

        return $this->passwordResetService->forgotPassword($request->email);
    }

    public function passwordReset(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->with('error1', 'Access revoked');
        }

        return view('auth.passwords.passwordReset');
    }

    public function passwordResetPost(PasswordResetRequest $request)
    {
        return $this->passwordResetService->resetPassword($request->validated(), $request['id']);
    }
}


