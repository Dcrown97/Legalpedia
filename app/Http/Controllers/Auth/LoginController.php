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

    public function Authenticated (Request $request, User $user)
    {

        if(Auth::check()) {

            $user = Auth::user();

            Session::put('join', 1);
            Session::put('welcome', 1);

            if(!empty($user->license_code)) {
                $license = LicensedUserSession::where('user_id', $user->id)->first();

                if($license) {
                    $license_count = $license->count();
                    $licensed_users = License::where('license_code', $user->license_code)->first();
                    $allowed_users = $licensed_users->active_users + 1;
                    if($license_count < $allowed_users) {
                        // $license->increment('session_no');
                        LicensedUserSession::create([
                            'license_id' => $license->id,
                            'user_id' => $user->id,
                            'session_no' => time(),
                        ]);

                    } if($license_count >= $allowed_users) {

                        foreach($license as $login) {
                            // dd($login);
                            if ($login->session_no < time() - 300) {
                                $logged_out_user = LicensedUserSession::where('id', $login->id)->orderBy('session_no', 'ASC')->first();
                                $logged_out_user->delete();
                                $request->session()->flush();
                                Auth::logout();
                                Session::flash('error', 'Time expired');
                                return redirect('/login')->withErrors('Time expired');
                            }
                        }
                        Auth::logout();
                        Session::flash('error', 'Maximmum number of users reached');
                        return redirect('/login')->withErrors('Maximmum number of users reached');
                    }
                } else {
                    $license = License::where('license_code', $user->license_code)->first();
                    LicensedUserSession::create([
                        'license_id' => $license->id,
                        'user_id' => $user->id,
                        'session_no' => time(),
                    ]);

                    return redirect()->intended();

                }
            }


            Auth::logoutOtherDevices($request->password);

            return redirect()->intended();
        }
    }

}
