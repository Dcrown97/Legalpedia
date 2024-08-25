<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invite;
use App\Notifications\TeamInvite;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;


class InviteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except('registration_view');
        // $this->middleware('auth')
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function sendInvite(Request $request, $id)
    {
        $user = Auth::user();
        $team = Team::where('user_id', Auth::user()->id)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ]);
        $validator->after(function ($validator) use ($request) {
            if (Invite::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'There exists an invite with this email!');
            }
        });
        if ($validator->fails()) {
            return redirect(route('show.team', $team->id))
                ->withErrors($validator)
                ->withInput();
        }
        do {
            $token = Str::random(15);
        } while (Invite::where('token', $token)->first());
        $data = Invite::create([
            'token' => $token,
            'email' => $request->input('email'),
            'team_id' => $request->team_id
        ]);
        $url = URL::temporarySignedRoute(

            'registration',
            now()->addMinutes(300),
            ['token' => $token]
        );

        // Notification::route('mail', $request->input('email'))->notify(new TeamInvite($url, $user));
        $explodedMail =  $data->email;
        $subject = 'You have been Invited';
        $newContent =  [
            'user' => $user->name,
            'url' => $url
        ];
        $content = view("emails.teamInvite", $newContent)->render();
        zohoSendMail($subject, $content, $explodedMail);

        return redirect()->back()->with('success', 'Your Invite has been sent');
    }

    public function registration_view($token)
    {
        $invite = Invite::where('token', $token)->first();
        return view('auth.invite.register', ['invite' => $invite]);
    }
}
