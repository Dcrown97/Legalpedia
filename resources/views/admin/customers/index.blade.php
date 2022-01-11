@extends('layouts.admin.customers')

@section('title')
    <title>Customers - Legalpedia</title>
@endsection

@section('content')

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
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="mdi mdi-download"></i> Export
                        </a>
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
                                        <td class="orders-total">{{$user->bio}}</td>
                                        <td class="orders-total">{{$user->referral_link}}</td>
                                        <td class="orders-total">{{$user->call_to_bar_year}}</td>
                                        <td class="orders-status">
                                            <div class="badge bg-success-soft">
                                                Active
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{route('show.customer', $user->id)}}" style="cursor: pointer" class="dropdown-item">
                                                        <i class="mdi mdi-eye mr-2"></i> View Details
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
<div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-9">
        <div class="modal-content rounded">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Create Project</div>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-2x">
                        <i class="mdi mdi-close"></i>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y m-5">
                <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                    <div class="container">
                        <div class="stepper-nav justify-content-center py-2">
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
</script>
@endsection
