@extends('layouts.admin.license')

@section('title')
    <title>License - Legalpedia</title>
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
                        Manage License
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"]}'>
                <div class="card-header">

                <!-- Search -->
                <form>
                    <div class="input-group input-group-flush input-group-merge input-group-reverse">
                    <input class="form-control list-search" type="search" placeholder="Search">
                    <span class="input-group-text">
                        <i class="fe fe-search"></i>
                    </span>
                    </div>
                </form>
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
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Package</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Licensed Days</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Updated Licnsed Days</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Unlock Date</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                        {{-- <th colspan="2"><a href="#" class="text-muted list-sort" data-sort="orders-method">Payment method</a></th> --}}
                    </tr>
                    </thead>
                    <tbody class="list">
                        <tr>
                            <td>
                                <div class="form-check mb-n2">
                                    <input class="form-check-input list-checkbox" type="checkbox" name="ordersSelect" id="ordersSelectOne">
                                    <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                </div>
                            </td>
                            <td class="orders-order">1</td>
                            <td class="orders-product">
                                <div class="avatar avatar-sm avatar-online mr-2">
                                    <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                                </div>
                                <span>Emmanuel Edidiong</span>
                            </td>
                            <td class="orders-date">akpanemmanueledidiong99@gmail.com</td>
                            <td class="orders-total">Premium package</td>
                            <td class="orders-total">365</td>
                            <td class="orders-total">365</td>
                            <td class="orders-total">07/11/2020</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#!" class="dropdown-item">
                                        Action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Another action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Something else here
                                    </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check mb-n2">
                                    <input class="form-check-input list-checkbox" type="checkbox" name="ordersSelect" id="ordersSelectOne">
                                    <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                </div>
                            </td>
                            <td class="orders-order">1</td>
                            <td class="orders-product">
                                <div class="avatar avatar-sm avatar-online mr-2">
                                    <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                                </div>
                                <span>Emmanuel Edidiong</span>
                            </td>
                            <td class="orders-date">akpanemmanueledidiong99@gmail.com</td>
                            <td class="orders-total">Premium package</td>
                            <td class="orders-total">365</td>
                            <td class="orders-total">365</td>
                            <td class="orders-total">07/11/2020</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#!" class="dropdown-item">
                                        Action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Another action
                                    </a>
                                    <a href="#!" class="dropdown-item">
                                        Something else here
                                    </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
