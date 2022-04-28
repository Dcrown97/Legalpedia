<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Package;
use App\Models\Transaction;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\SortedMiddleware;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request) {
        if(Auth::user()->role->name == 'Admin') {
            // $users = User::orderBy('created_at', 'DESC')->get();
            // $user_count = $users->count();
            $roles = Role::orderBy('name', 'ASC')->get();
            // return view('admin.customers.index', compact('users', 'user_count', 'roles'));




            $packages = Package::orderBy('name', 'ASC')->get();

            if($request->has('fetch_user')) {
                $user = User::query();
                if($request->filled('end_date')) {
                    $start_date = Carbon::parse($request->start_date)->toDateTimeString();
                    $end_date = Carbon::parse($request->end_date)->toDateTimeString();
                    $users = $user->whereBetween('active_date', [$start_date, $end_date])->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                }
                if( $request->filled('status')) {
                    $users = $user->where('status', $request->status)->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                }
                if( $request->filled('package')) {
                    $package = Package::where('name', $request->package)->first();
                    $users = $user->where('package_id', $package->id)->orderBy('active_date', 'DESC')->simplePaginate(10)->withQueryString();
                }

                $user_count = $user->count();
                $active_user_count = $user->where('status', 'active')->count();
                $inactive_user_count = $user->where('status', '!=', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = $request->status;
                $selected_package = [];
                $selected_package['package'] = $request->package;
                $selected_start_date = [];
                $selected_start_date['last_seen_start_date'] = '';
                $selected_end_date = [];
                $selected_end_date['last_seen_end_date'] = '';
                return view('admin.customers.index', compact('users', 'roles', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package', 'selected_start_date', 'selected_end_date'));
            }
            if($request->search_customer) {
                $search = $request->search_customer;
                $user = User::query();
                $users = $user->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('surname', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('phone', 'LIKE', '%'.$search.'%')
                ->orderBy('name', 'ASC')
                ->simplePaginate(10)
                ->withQueryString();

                $user_count = $user->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('surname', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('phone', 'LIKE', '%'.$search.'%')
                ->orderBy('name', 'ASC')
                ->count();
                $active_user_count = $users->where('status', 'active')->count();
                $inactive_user_count = $users->where('status', '!=', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = '';
                $selected_package = [];
                $selected_package['package'] = '';
                $selected_start_date = [];
                $selected_start_date['last_seen_start_date'] = '';
                $selected_end_date = [];
                $selected_end_date['last_seen_end_date'] = '';
                return view('admin.customers.index', compact('users', 'roles', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package', 'selected_start_date', 'selected_end_date'));
            }
            if(isset($request->last_seen_start_date) && isset($request->last_seen_end_date) ) {
                $user = User::query();
                $start_date = Carbon::parse($request->last_seen_start_date)->addDays(1);
                $end_date = Carbon::parse($request->last_seen_end_date)->addDays(1);
                $user_count = $user->whereBetween('last_seen', [$start_date, $end_date])->count();
                $users = $user->whereBetween('last_seen', [$start_date, $end_date])->orderBy('last_seen', 'DESC')->simplePaginate(10)->withPath(url()->current())->withQueryString();

                $selected_start_date = [];
                $selected_start_date['last_seen_start_date'] = $request->last_seen_start_date;
                $selected_end_date = [];
                $selected_end_date['last_seen_end_date'] = $request->last_seen_end_date;

                $active_user_count = $user->where('status', 'active')->count();
                $inactive_user_count = $user->where('status', '!=', 'active')->count();
                $selected_status = [];
                $selected_status['status'] = '';
                $selected_package = [];
                $selected_package['package'] = '';
                return view('admin.customers.index', compact('users', 'roles', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package', 'selected_start_date', 'selected_end_date'));

            }
            $users = User::orderBy('created_at', 'DESC')->simplePaginate(10)->withQueryString();
            $user_count =  User::count();
            $active_user_count = $users->where('status', 'active')->count();
            $inactive_user_count = $users->where('status', '!=', 'active')->count();

            $selected_start_date = [];
            $selected_start_date['last_seen_start_date'] = '';
            $selected_end_date = [];
            $selected_end_date['last_seen_end_date'] = '';

            $selected_status = [];
            $selected_status['status'] = '';
            $selected_package = [];
            $selected_package['package'] = '';
            return view('admin.customers.index', compact('users', 'roles', 'user_count', 'active_user_count', 'inactive_user_count', 'packages', 'selected_status', 'selected_package', 'selected_start_date', 'selected_end_date'));
        }
        return back();
    }

    public function indexDatables() {
        $users = User::orderBy('name', 'ASC')->get();
        $user_count = $users->count();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('admin.customers.custom', compact('users', 'user_count', 'roles'));
    }

    public function userTable(Request $request) {
        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.customers.custom');
    }

    public function customerDataSource(Request $request) {

        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));

        $filter = $search['value'];

        $sortColumns = array(
            0 => 'name',
            1 => 'email',
            2 => 'phone',
            3 => 'dob',
        );

        $query = User::query();

        if (!empty($filter)) {
            $query->where('name', 'like', '%'.$filter.'%');
        }

        $recordsTotal = $query->count();

        $sortColumnName = $sortColumns[$order[0]];
        // dd($order);

        // dd($sortColumnName);

        $query->orderBy($sortColumnName, 'asc')
                ->take($length)
                ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );

        $users = $query->get();

        foreach ($users as $user) {

            $json['data'][] = [
                $user->name,
                $user->email,
                $user->phone,
                $user->dob,
                view('admin.customers.custom', ['user' => $user])->render(),
            ];
        }

        return $json;
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
    }

    public function edit($id) {
        $user = User::where('id', Auth::user()->id)->first();
        $states = State::orderBy('name', 'ASC')->get();
        $countries = Country::orderBy('name', 'ASC')->get();
        $package = Package::where('id', $user->package_id)->first();
        $transactions = Transaction::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
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
