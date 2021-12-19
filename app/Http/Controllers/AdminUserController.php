<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        $users = User::orderBy('name', 'ASC')->get();
        return view('admin.customers.index', compact('users'));
    }

    public function show($id) {
        $user = User::findOrFail($id);
        return view('admin.customers.show', compact('user'));
    }

    public function edit($id) {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.customers.edit', compact('user'));
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
            // $file->store('images', $name);
            $path = $file->store('media', 'public', $name);
            $input['photo'] = $path;
        }
        $user->update($input);

        return back()->with('success', 'Profile updated');

    }
}
