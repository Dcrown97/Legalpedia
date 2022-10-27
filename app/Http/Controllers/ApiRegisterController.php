<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\UserTeam;
use Illuminate\Http\Request;

class ApiRegisterController extends Controller
{
    //
    public function register(Request $request)
    {

        // $data = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'surname' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);

        $data = $request->all();

        // dd($data);

        $role = Role::where('name', 'Customer')->first();
        if (!$role) {
            return back()->withErrors('Role Customer not found please contact admin');
        }
        $sendToken = isset($data['token']) ? $data['token'] : "";
        if (Invite::where('token', $sendToken)->first() !== null) {
            // dd('user with invite');
            $invite = Invite::where('token', $data['token'])->first();
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'role_id' => $role->id,
                'phone' => $data['phone'],
                // 'referrer' => $data['referrer'],
                'dob' => $data['dob'],
                'area_of_practice' => $data['area_of_practice'],
                'nba_branch' => $data['nba_branch'],
                'password' => bcrypt($request->password)
            ]);

            UserTeam::create([
                'token' => $data['token'],
                'user_id' => $user->id,
                'team_id' => $data['team_id'],
                'send_request' => $data['send_request'],
                'approve_request' => $data['approve_request'],
            ]);

            $userToken = $user->createToken('API Token')->accessToken;

            // $role = Role::where('name','Admin')->first();
            // $admin_user = User::where('role_id', $role->id)->first();
            $team = Team::where('main_team', 'main')->first(); // create a column in teams table and tag it main legalpedia team
            if ($team) {
                UserTeam::create([
                    'user_id' => $user->id,
                    'team_id' => $team ? $team->id : NULL,
                    'send_request' => 1,
                    'approve_request' => 1,
                ]);
            }

            // $user->notify(new WelcomeOnboard($user));
            $explodedMail =  $user->email;
            $subject = 'Welcome Onboard!';
            $newContent =  [
                'user' => $user->name
            ];
            $content = view("emails.welcomeOnboard", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);

            return response(['user' => $user, 'token' => $userToken]);
        } else {
            // dd('user without invite');
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'role_id' => $role->id,
                'phone' => $data['phone'],
                // 'referrer' => $data['referrer'],
                'dob' => $data['dob'],
                'area_of_practice' => $data['area_of_practice'],
                'nba_branch' => $data['nba_branch'],
                'password' => bcrypt($request->password)
            ]);

            $userToken = $user->createToken('API Token')->accessToken;

            // $role = Role::where('name','Admin')->first();
            // $admin_user = User::where('role_id', $role->id)->first();
            $team = Team::where('main_team', 'main')->first(); // create a column in teams table and tag it main legalpedia team
            if ($team) {
                UserTeam::create([
                    'user_id' => $user->id,
                    'team_id' => $team ? $team->id : NULL,
                    'send_request' => 1,
                    'approve_request' => 1,
                ]);
            }


            // $user->notify(new WelcomeOnboard($user));
            $explodedMail =  $user->email;
            $subject = 'Welcome Onboard!';
            $newContent =  [
                'user' => $user->name
            ];
            $content = view("emails.welcomeOnboard", $newContent)->render();
            tribearcSendMail($subject, $content, $explodedMail);
            return response(['user' => $user, 'token' => $userToken]);
        }
    }
}
