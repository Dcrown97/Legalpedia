<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\session;
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
            if(!empty($user->license_code)) {
                $_SESSION['name'] =  $user->name;
                $_SESSION['key'] =  $user->name;
                $_SESSION['last_login_timestamp'] = time();
            }
        }

        // { //check if the user is logged in or not
        //     $user = Auth::user();
        //   //  $login = Session::where('user_id', Auth::id())->count();
        //   $login = DB::table('sessions')->where('user_id', Auth::id())->count();
        //    // dd($login);
        //     if ($user->isBasic())
        //     {
        //         if ($login > 0)
        //         {
        //             Auth::logout();
        //             session()->flash('logout', "You are Logged in on other devices");
        //             return redirect('login');
        //         }

        //         return redirect(route('welcome'));
        //     }

        //     elseif ($user->isCouple())
        //     {
        //         if ($login > 1)
        //         {
        //             Auth::logout();
        //             session()->flash('logout', "You are Logged in on other devices");
        //             return redirect('login');
        //         }

        //         return redirect(route('welcome'));
        //     }

        //     elseif ($user->isFamily())
        //     {
        //         if ($login > 5)
        //         {
        //             Auth::logout();
        //             session()->flash('logout', "You are Logged in on other devices");
        //             return redirect('login');
        //         }

        //         return redirect(route('welcome'));

        //         }
        //     }

        //     else
        //     {
        //         return redirect(route('welcome'));
        // }

    }
}
