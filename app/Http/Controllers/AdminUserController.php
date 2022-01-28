<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Package;
use App\Models\Transaction;
use App\Exports\UsersExport;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        if(Auth::user()->role->name == 'Admin') {
            $users = User::orderBy('name', 'ASC')->get();
            $user_count = $users->count();
            $roles = Role::orderBy('name', 'ASC')->get();
            return view('admin.customers.index', compact('users', 'user_count', 'roles'));
        }
        return back();
    }

    public function show($id) {
        if(Auth::user()->role->name == 'Admin') {
            $user = User::findOrFail($id);
            return view('admin.customers.show', compact('user'));
        }
        return back();
    }

    public function userProfile($id) {
        $user = User::findOrFail($id);
        return view('admin.customers.profile', compact('user'));
        return back();
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

        // dd($request->all());
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
        if(!$request->email_display) {
            $input['email_display'] = $request->email_display;
        }
        if(!$request->phone_display) {
            $input['phone_display'] = $request->phone_display;
        }
        if(!$request->dob_display) {
            $input['dob_display'] = $request->dob_display;
        }
        if(!$request->ctb_display) {
            $input['ctb_display'] = $request->ctb_display;
        }
        if(!$request->social_display) {
            $input['social_display'] = $request->social_display;
        }
        if(!$request->web_display) {
            $input['web_display'] = $request->web_display;
        }

        $user->update($input);


        return back()->with('success', 'Profile updated');

    }
    public function updateRole(Request $request) {
        $input = [
            'role_id' => $request->role_id
        ];
        DB::table('users')->where('id', $request->user_id)->update($input);
        return back()->with('success', 'Customer Role changed');
    }
    public function deleteCustomer($id){
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Customer deleted');
    }

    public function exportCustomer() {
        return Excel::download(new UsersExport, 'Legalpedia-customers.xlsx');
    }
}
