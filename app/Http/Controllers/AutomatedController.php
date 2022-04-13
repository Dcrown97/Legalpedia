<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Notifications\BirthdayMessage;

class AutomatedController extends Controller
{
    ///////////////////////////////////////send birthday messages to users//////////////////////////////////
    public function birthdayMessage() {
        $users = User::where('dob','<>', null)->get();
        $message = Message::where('type', 'automated')->where('receipient_type', 'dob')->orderBy('created_at', 'DESC')->first();
        if($message) {
            foreach($users as $user) {
                $date = Carbon::now();
                $get_date = strtotime($date);
                $now = date('M d', $get_date);
                $dob = strtotime($user->dob);
                $user_dob = date('M d', $dob);
                if($user_dob == $now) {
                    $user->notify(new BirthdayMessage($user, $message));
                }
            }
            info(['birthday_message_success' => now()->toDayDateTimeString()]);
            return 'Ran successfully';
        }
        info(['birthday_message_error' => now()->toDayDateTimeString()]);
        return 'Couldn\'t run';

    }
}
