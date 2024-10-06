<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\License;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LicensedUserSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        // $this->redirectTo = url()->previous();
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function Authenticated(Request $request, User $user)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors('User is not authenticated');
        }

        $user = Auth::user();
        $time = time();

        // Store session variables
        Session::put([
            'join' => 1,
            'welcome' => 1,
            'who' => $time
        ]);

        // Check if the user has a license code
        if (!empty($user->license_code)) {
            // Retrieve license details for the organization
            $license = License::where('license_code', $user->license_code)->first();

            if ($license) {
                // Get the count of active user sessions for this license
                $active_sessions_count = LicensedUserSession::where('license_id', $license->id)->count();
                $allowed_users = $license->active_users;

                // dd($allowed_users);

                // Check if the number of active sessions exceeds the allowed users
                if ($active_sessions_count >= $allowed_users) {
                    // Kick out the first logged-in user (the one with the earliest session)
                    $this->kickOutFirstUser($license->id);
                }

                // Now allow the new user to create a session
                $this->createNewSession($user->id, $license->id, $time);
                return redirect()->intended();
            }
        }

        // Logout other devices if no license code is provided
        Auth::logoutOtherDevices($request['password']);

        return redirect()->intended();
    }

    protected function createNewSession($user_id, $license_id, $session_no)
    {
        LicensedUserSession::create([
            'license_id' => $license_id,
            'user_id' => $user_id,
            'session_no' => $session_no
        ]);
    }

    protected function kickOutFirstUser($license_id)
    {
        // Find the first logged-in user by the session time (the earliest session)
        $first_logged_user = LicensedUserSession::where('license_id', $license_id)
            ->orderBy('session_no', 'ASC') // Order by the earliest session
            ->first();

        if ($first_logged_user) {
            // Notify the first user that they are being logged out
            $first_logged_user->delete(); // Delete the session, effectively logging them out
            Session::flash('error', 'You have been logged out because the maximum number of users has been reached.');
        }
    }
}
