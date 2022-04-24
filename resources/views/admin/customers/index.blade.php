    @extends('layouts.admin.customers')

    @section('title')
        <title>Customers - Legalpedia</title>
    @endsection

    @section('content')
    <style>
        .modal-content {
            width: 100% !important;
            height: auto !important;
        }
        .custom-form {
            border-radius: 4px !important;
            height: inherit;
            width: 100% !important;
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <h6 class="header-pretitle">
                        </h6>
                        <h1 class="header-title">
                            Manage Customers
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-end justify-content-end mt-4 p-3">
            <form action="{{route('admin.customers')}}" method="GET" class="me-3">
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Subscribers
                            </label>
                            <select name="status" class="form-select mr-8">
                                <option value="active">Active</option>
                                <option value="inactive">Not Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                Package
                            </label>
                            <select name="package" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                <option value="">All</option>
                                @foreach($packages as $package)
                                    <option value="{{$package->name}}" {{ $package->name == $selected_package['package'] ? 'selected' : '' }}>{{$package->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                From
                            </label>
                            <input type="text" id="start_date" name="start_date" class="form-control custom-form w-8" placeholder="<?php echo date('Y-m-d');?>" data-flatpickr>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl">
                        <div class="form-group">
                            <label class="form-label mb-1">
                                To
                            </label>
                            <input type="text" id="end_date" name="end_date" class="form-control custom-form w-8" placeholder="<?php echo date('Y-m-d');?>" data-flatpickr>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-auto">
                        <button type="submit" name="fetch_user" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-sm btn-primary p-2">
                            <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                        </button>
                        <a href="{{url('admin/customers')}}" onclick="this.classList.toggle('button--loading')" class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
                            <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                    <div class="card-header">
                        {{-- <form>
                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                            <input class="form-control list-search" type="search" placeholder="Search">
                            <span class="input-group-text">
                                <i class="fe fe-search"></i>
                            </span>
                            </div>
                        </form> --}}
                        <form action="{{route('admin.customers')}}" method="GET" class="w-100">
                            <div class="input-group input-group-flush input-group-merge input-group-reverse w-100">
                                <button id="search-btn" class="btn button_load text-white btn-sm btn-primary p-2 px-3" onclick="this.classList.toggle('button--loading')">
                                    <span class="button__text">Search</span>
                                </button>
                                <input class="form-control list-search" type="text" name="search_customer" id="search-customer" placeholder="Search">
                                <span class="input-group-text">
                                    <i class="fe fe-search"></i>
                                </span>
                            </div>
                        </form>
                        <div class="col-auto">
                            <h4>{{number_format($user_count)}} customers</h4>
                        </div>
                        <div class="col-auto">
                            <form action="{{route('export.customer')}}" method="post">
                                @csrf
                                <button type="submit" id="exportBtn" class="btn btn-primary text-white">
                                    <i class="mdi mdi-download"></i> Export
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-nowrap card-table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check mb-n2">
                                            <input class="form-check-input list-checkbox-all" name="ordersSelect" id="ordersSelectAll" type="checkbox">
                                            <label class="form-check-label" for="ordersSelectAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-order">Last Seen</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Customer</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Email</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Phone</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Date of Birth</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Referees</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Year of CTB</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Active Date</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Expiry Date</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Status</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Role</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                                </tr>
                            </thead>
                            @php
                                $user_no = 1
                            @endphp
                            @if($users)
                                <tbody class="list">
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="form-check mb-n2">
                                                    <input class="form-check-input list-checkbox" type="checkbox" name="ordersSelect" id="ordersSelectOne">
                                                    <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td class="orders-order">{{$user_no}}</td>
                                            @php
                                                $user_no++
                                            @endphp
                                            <td class="orders-order">
                                                @if($user->last_seen !== NULL)
                                                    {{\Carbon\Carbon::parse($user->last_seen)->toFormattedDateString()}} {{\Carbon\Carbon::parse($user->last_seen)->format('H:i:s')}} 
                                                @else
                                                    {{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}} {{\Carbon\Carbon::parse($user->created_at)->format('H:i:s')}}
                                                @endif
                                            </td>
                                            <td class="orders-product">
                                                <div class="avatar avatar-sm avatar-online mr-2">
                                                    @if($user->photo)
                                                        <a href="{{route('user.profile', $user->id)}}">
                                                            <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                        </a>
                                                        @else
                                                        <div class="initials">
                                                            <a href="{{route('user.profile', $user->id)}}" class="text-white"><span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span></a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span><a href="{{route('user.profile', $user->id)}}">{{$user->name}} {{$user->surname}}</a></span>
                                            </td>
                                            <td class="orders-date">{{$user->email}}</td>
                                            <td class="orders-total">{{$user->phone}}</td>
                                            <td class="orders-total">
                                                @if($user->last_seen !== NULL)
                                                    {{\Carbon\Carbon::parse($user->dob)->toFormattedDateString()}}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="orders-total">{{$user->referrer}}</td>
                                            <td class="orders-total">{{$user->call_to_bar_year}}</td>
                                            @php
                                                $package = App\Models\Package::where('id', $user->package_id)->first();
                                            @endphp
                                            <td class="orders-total">{{$package ? $package->name : ''}}</td>
                                            <td class="orders-total">{{\Carbon\Carbon::parse($user->active_date)->toFormattedDateString()}}</td>
                                            <td class="orders-total">{{\Carbon\Carbon::parse($user->expiry_date)->toFormattedDateString()}}</td>
                                            @if($user->status == 'active')
                                                <td class="orders-status">
                                                    <div class="badge bg-success-soft">
                                                        Active
                                                    </div>
                                                </td>
                                                @else
                                                <td class="orders-status">
                                                    <div class="badge bg-secondary-soft">
                                                        Inactive
                                                    </div>
                                                </td>
                                            @endif
                                            @if($user->role->name == 'Admin')
                                                <td class="orders-status">
                                                    <div class="badge bg-success-soft">
                                                        Admin
                                                    </div>
                                                </td>
                                                @else
                                                <td class="orders-status">
                                                    <div class="badge bg-warning-soft">
                                                        Customer
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fe fe-more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="{{route('user.profile', $user->id)}}" style="cursor: pointer" class="dropdown-item">
                                                            <i class="mdi mdi-eye mr-2"></i> View Profile
                                                        </a>
                                                        <a style="cursor: pointer" data-bs-toggle="modal" onclick="showEditUserRole('{{$user->name}}', '{{$user->id}}')" class="dropdown-item">
                                                            <i class="mdi mdi-pencil mr-2"></i> Edit Role
                                                        </a>
                                                        <form action="/admin/customers/{{$user->id}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                                <i class="fe fe-trash mr-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @else
                                <div class="text-center">
                                    <h1>No record found</h1>
                                </div>
                            @endif
                        </table>
                    </div>
                    <div class="row align-items-center">
                        <div class="my-4 justify-content-center text-center">
                            {{$users->links()}}
                        </div>
                    </div>
                    {{-- <div class="row g-0">
                        <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                        <li class="page-item">
                            <a class="page-link" href="#">
                            <i class="fe fe-arrow-left me-1"></i> Prev
                            </a>
                        </li>
                        </ul>
                        <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                        <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="#">
                            Next <i class="fe fe-arrow-right ms-1"></i>
                            </a>
                        </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUserRole" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Change Customer Role</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                        <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.role')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        {{-- Category Name --}}
                                    </label>
                                    <select name="role_id" class="form-select">
                                        {{-- <option value="{{$user->role_id}}">{{$user->role->name}}</option> --}}
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="user_id" id="user-name">
                                <input type="hidden" name="user_id" id="user-id">
                                {{-- <input type="hidden" name="user_role" id="user-role"> --}}
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save changes</span>
                                </button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this user?"))
            event.preventDefault();
        }
        function showEditUserRole(name, id){
            document.getElementById("user-name").value = name;
            // document.getElementById("user-role").value = role;
            document.getElementById("user-id").value = id;
            $('#editUserRole').modal('show')

        }
    </script>
    @endsection
