<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LicensedUserSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\Store;

class LicensedUser
{
    protected $session;
    protected $timeout = 1200;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

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
                $license = LicensedUserSession::where('user_id', $user->id)->first();
                if($license) {



                    $is_logged_in = $request->path() != '/logout';

                    if(!session('last_active')) {
                        $this->session->put('last_active', time());
                    } elseif(time() - $this->session->get('last_active') > $this->timeout) {

                        $this->session->forget('last_active');

                        $cookie = cookie('intend', $is_logged_in ? url()->current() : 'admin/dashboard');

                        $logged_out_user = LicensedUserSession::where('id', $license->id)->first();
                        $logged_out_user->delete();

                        Auth::logout();
                    }

                    $is_logged_in ? $this->session->put('last_active', time()) : $this->session->forget('last_active');

                    return $next($request);
                }
            }
            return $next($request);
        }
        // return redirect('/login');
        return $next($request);

    }
}
