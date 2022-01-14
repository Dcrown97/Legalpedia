<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LicensedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()) {
            $user = Auth::user();
            if(!empty($user->license_code)) {

                // $expiresAt = now()->addMinutes(15); /* keep logged in user for 15 min */
                if (isset($_SESSION["name"])) {
                    // only if user is logged in perform this check
                    if ((time() - $_SESSION['last_login_timestamp']) > 100) {
                        $logged_user = DB::table('sessions')->where('user_id', Auth::user()->id)->first();
                        $logged_user->delete();
                        Auth::logout();
                        return redirect('/login');
                    } else {
                      $_SESSION['last_login_timestamp'] = time();
                      
                    }
                }
            }

        }
        return $next($request);
    }
}
