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
        // dd('this');
        // dd(date("m/d/Y h:i:s A T", time()), (date("m/d/Y h:i:s A T", time() - 300)));
        if (Auth::check()) {
            

            $user = Auth::user();
            $time = time();
            Session::put('join', 1);
            Session::put('welcome', 1);
            Session::put('who',$time);

            if (!empty($user->license_code)) {
                // dd("has license");
                // $license = LicensedUserSession::where('user_id', $user->id)->first();
                $license = LicensedUserSession::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
                $license_count = LicensedUserSession::where('user_id', $user->id)->count();

                if ($license) {
                    $licensed_users = License::where('license_code', $user->license_code)->first();
                    $allowed_users = $licensed_users->active_users;
                    // dd($license_count, $allowed_users);
                    if ($license_count < $allowed_users) {
                        // $license->increment('session_no');
                        LicensedUserSession::create([
                            'license_id' => $license->license_id+1,
                            'user_id' => $user->id,
                            'session_no' => $time,
                        ]);

                        return;
                    } else {
                        $logged_out_user = LicensedUserSession::where('user_id', Auth::user()->id)->orderBy('session_no', 'ASC')->first();
                        $to_logout = $logged_out_user->session_no;
                        $me = Session::get('who');
                        // dd($logged_out_user, $me, $me == $to_logout);
                        if($me == $to_logout){
                            // dd('here');
                            $logged_out_user->delete();
                            Auth::logout();
                            Session::flash('error', 'Maximmum number of users reached');
                            return redirect('/login')->withErrors('Maximmum number of users reached');
                        }else{
                            LicensedUserSession::create([
                                'license_id' => $license->license_id + 1,
                                'user_id' => $user->id,
                                'session_no' => $time,
                            ]);
                            $logged_out_user->delete();
                        }

                    }
                    // if ($license_count >= $allowed_users) {

                    // foreach ($license as $login) {
                    //     if ($login->session_no < time() - 300) {
                    //         $logged_out_user = LicensedUserSession::where('id', $login->id)->orderBy('session_no', 'ASC')->first();
                    //         $logged_out_user->delete();
                    //         $request->session()->flush();
                    //         Auth::logout();
                    //         Session::flash('error', 'Time expired');
                    //         return redirect('/login')->withErrors('Time expired');
                    //     }else{
                    //         dd('sfsdvgfhj');
                    //     }
                    // }
                    // Auth::logout();
                    // Session::flash('error', 'Maximmum number of users reached');
                    // return redirect('/login')->withErrors('Maximmum number of users reached');
                    // }
                } else {
                    $license = License::where('license_code', $user->license_code)->first();
                    LicensedUserSession::create([
                        'license_id' => $license->id,
                        'user_id' => $user->id,
                        'session_no' => $time,
                    ]);

                    return redirect()->intended();
                }
            }

            // Auth::logoutOtherDevices($request['password']);

            return redirect()->intended();
        }
    }
}
