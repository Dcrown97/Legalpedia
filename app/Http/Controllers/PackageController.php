<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Notifications\ExpiredPackage;
use App\Notifications\LastRenewalNotice;
use App\Notifications\FirstRenewalNotice;
use App\Notifications\SecondRenewalNotice;

class PackageController extends Controller
{
    public function sub_pack() {
        return view('sub');
    }

    public function subPack($slug) {
        $package = Package::where('slug', $slug)->first();
        return view('subscription', compact('package'));
    }



    ///////////////////////////////////////send expiry emails for packages//////////////////////////////////
    public function expiredPackage() {
        $users = User::get();
        foreach($users as $user) {
            if(isset($user->package_id) && $user->expiry_date > now()) {
                $package = Package::where('id', $user->package_id)->first();

                $date = Carbon::now();
                $get_date = strtotime($date);
                $first_notice_date = strtotime("+14 day", $get_date); /// add 14 days notice
                $second_notice_date = strtotime("+7 day", $get_date); /// add 7 days notice
                $last_notice_date = strtotime("+1 day", $get_date); /// add 1 day notice
                $exact_first_date = date('M d, Y', $first_notice_date);
                $exact_second_date = date('M d, Y', $second_notice_date);
                $exact_last_date = date('M d, Y', $last_notice_date);
                $expiry_date = Carbon::parse($user->expiry_date)->toFormattedDateString();

                if($exact_first_date == $expiry_date) {
                    $user->notify(new FirstRenewalNotice($user, $package));
                }
                if($exact_second_date == $expiry_date) {
                    $user->notify(new SecondRenewalNotice($user, $package));
                }
                if($exact_last_date == $expiry_date) {
                    $user->notify(new LastRenewalNotice($user, $package));
                }
            }
            if(isset($user->package_id) && $user->expiry_date < now()) {
                if($user->status == 'active') {
                    $user->notify(new ExpiredPackage($user, $package));
                    $user->status = 'inactive';
                    $user->save();
                }
            }
        }

        // return 'Ran';
    }

}
