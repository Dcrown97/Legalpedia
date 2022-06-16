<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\SendDefaultEmailNotification;
use App\Notifications\PasswordResetSuccessNotification;

class PasswordResetService {

    public $passwordReset;

    public function __construct()
    {
        $this->passwordReset = new PasswordReset;
    }

    public function forgotPassword(string $email)
    {

        if(!$user = User::whereEmail($email)->first()){
            return back()->with('error1', 'User not found');
        }

        $this->passwordReset->where('user_id', $user->id)->update(['expiry'=> now()]);

        $expiry = now()->addMinutes(5);
        $passwordReset =  $this->passwordReset->create([
            'user_id' => $user->id,
            'email' => $email,
            'token' => Str::random(40),
            'expiry' => $expiry,
            'has_reset' => 0
        ]);


        $url = URL::temporarySignedRoute(
            'password.reset', $expiry, ['token' => $passwordReset->token, 'id' => $user->id]
        );

        // $user->notify(new ForgotPasswordNotification($user, $passwordReset, $url));

        $explodedMail =  $user->email;
        $subject = 'Reset Password';
        $newContent =  [
            'user' => $user->name,
            'passwordReset' => $passwordReset,
            'url' => $url,
        ];
        $content = view("emails.forgotPassword", $newContent)->render();
        tribearcSendMail($subject, $content, $explodedMail);

        return back()->with('success', 'We have sent a password reset link to your email');

    }



    public function resetPassword(array $data, string $userId)
    {

        if(!$user = User::find($userId)){
            return redirect()->route('login')->with('error1', 'An error occured, we can not verify this user');
        }

        if(!$passwordReset =  $this->passwordReset->where('token', $data['token'])->first()){
            return back()->with('error1', 'Invalid password reset link code');
        }


        if(Carbon::parse($passwordReset->expiry)->isPast()){
            return back()->with('error1', 'Password reset link expired');
        }

        $user->password = bcrypt($data['password']);

        if(!$user->save()){
            return back()->with('error1', 'Unable to change password, please try again');
        }

        $this->passwordReset->where('user_id', $userId)->where('token', $data['token'])->update(['has_reset' => 1, 'expiry' => now()->subMinute(3)]);

        // $user->notify(new PasswordResetSuccessNotification($user));

        $explodedMail =  $user->email;
        $subject = 'Password Reset Successful';
        $newContent =  [
            'user' => $user->name
        ];
        $content = view("emails.passwordResetSuccess", $newContent)->render();
        tribearcSendMail($subject, $content, $explodedMail);


        return redirect()->route('login')->with('success', 'Password reset successful login with your new password');

    }

}
