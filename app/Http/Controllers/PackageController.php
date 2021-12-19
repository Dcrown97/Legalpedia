<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function sub_pack() {
        return view('sub');
    }

    public function subPack($slug) {
        $package = Package::where('slug', $slug)->first();
        return view('subscription', compact('package'));
    }
}
