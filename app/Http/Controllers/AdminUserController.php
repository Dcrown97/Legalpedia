<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Package;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        $users = User::orderBy('name', 'ASC')->get();
        $user_count = $users->count();
        return view('admin.customers.index', compact('users', 'user_count'));
    }

    public function show($id) {
        $user = User::findOrFail($id);
        return view('admin.customers.show', compact('user'));
    }

    public function edit($id) {
        $user = User::where('id', Auth::user()->id)->first();
        $states = State::orderBy('name', 'ASC')->get();
        $countries = Country::orderBy('name', 'ASC')->get();
        $package = Package::where('id', $user->package_id)->first();
        $transactions = Transaction::where('user_id', $user->id)->get();
        return view('admin.customers.edit', compact('user', 'states', 'countries', 'package', 'transactions'));
    }

    public function update(Request $request) {
        $user = User::findOrFail(Auth::user()->id);

        if(trim($request->password) == '') {
            $input = $request->except('password');
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }
        if($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $path = $file->store('media', 'public', $name);
            $input['photo'] = $path;
        }
        // $file = $request->file('photo');
        // $path = $file->store('media', 'public');
        // $input['photo'] = $path;
        // dd($input);
        $user->update($input);


        return back()->with('success', 'Profile updated');

    }
    public function deleteCustomer($id){
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Customer deleted');
    }
}
