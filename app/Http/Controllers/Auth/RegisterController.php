<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\Invite;
use App\Models\UserTeam;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\WelcomeOnboard;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $role = Role::where('name','Customer')->first();
        if(!$role){
            return back()->withErrors('Role Customer not found please contact admin');
        }
        if(Invite::where('token', $data['token'])->first() !==null) {
            $invite = Invite::where('token', $data['token'])->first();

            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'role_id' => $role->id,
                'phone' => $data['phone'],
                // 'referrer' => $data['referrer'],
                'dob' => $data['dob'],
                'call_to_bar_year' => $data['call_to_bar_year'],
                'password' => Hash::make($data['password']),
            ]);

            UserTeam::create([
                'token' => $data['token'],
                'user_id' => $user->id,
                'team_id' => $data['team_id'],
                'send_request' => $data['send_request'],
                'approve_request' => $data['approve_request'],
            ]);

            $role = Role::where('name','Admin')->first();
            $admin_user = User::where('role_id', $role->id)->first();
            $team = Team::where('user_id', $admin_user->id)->first();
            if($team) {
                UserTeam::create([
                    'user_id' => $user->id,
                    'team_id' => $team ? $team->id : NULL,
                    'send_request' => 1,
                    'approve_request' => 1,
                ]);
            }

            $user->notify(new WelcomeOnboard($user));

            return $user;

        } else {
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'role_id' => $role->id,
                'phone' => $data['phone'],
                // 'referrer' => $data['referrer'],
                'dob' => $data['dob'],
                'call_to_bar_year' => $data['call_to_bar_year'],
                'password' => Hash::make($data['password']),
            ]);

            $role = Role::where('name','Admin')->first();
            $admin_user = User::where('role_id', $role->id)->first();
            $team = Team::where('user_id', $admin_user->id)->first();
            if($team) {
                UserTeam::create([
                    'user_id' => $user->id,
                    'team_id' => $team ? $team->id : NULL,
                    'send_request' => 1,
                    'approve_request' => 1,
                ]);
            }


            $user->notify(new WelcomeOnboard($user));

            return $user;
        }
    }
}
