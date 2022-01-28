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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                    <div class="card-header">
                        <form>
                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                            <input class="form-control list-search" type="search" placeholder="Search">
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
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Customer</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Email</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Phone</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Date of Birth</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Area of Practice</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Referees</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Year of CTB</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Status</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Role</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                                    {{-- <th colspan="2"><a href="#" class="text-muted list-sort" data-sort="orders-method">Payment method</a></th> --}}
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
                                            <td class="orders-product">
                                                <div class="avatar avatar-sm avatar-online mr-2">
                                                    @if($user->photo)
                                                        <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                        @else
                                                        <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                    @endif
                                                </div>
                                                <span>{{$user->name}}</span>
                                            </td>
                                            <td class="orders-date">{{$user->email}}</td>
                                            <td class="orders-total">{{$user->pone}}</td>
                                            <td class="orders-total">{{\Carbon\Carbon::parse($user->dob)->toFormattedDateString()}}</td>
                                            <td class="orders-total">{!! $user->area_of_practice !!}</td>
                                            <td class="orders-total">{{$user->referrer}}</td>
                                            <td class="orders-total">{{$user->call_to_bar_year}}</td>
                                            <td class="orders-status">
                                                <div class="badge bg-success-soft">
                                                    Active
                                                </div>
                                            </td>
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
                                                        <a href="{{route('show.customer', $user->id)}}" style="cursor: pointer" class="dropdown-item">
                                                            <i class="mdi mdi-eye mr-2"></i> View Details
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
                    <div class="row g-0">
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
                    </div>
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
