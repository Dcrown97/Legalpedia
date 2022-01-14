@extends('layouts.admin.subscriptions')

@section('title')
    <title>Transactions - Legalpedia</title>
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
    .show-mobile {
        display: none;
    }
    @media screen and (min-width: 200px) and (max-width: 767px) {
        .hide-mobile {
            display: none;
        }
        .show-mobile {
            display: inline;
        }
    }

</style>
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <h6 class="header-pretitle">
                    </h6>
                    <h1 class="header-title">
                        Transaction History
                    </h1>
                </div>
                @include('elements.notifications')
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">
                                Gross Transactions
                            </h6>
                            <span class="h1 mb-0">
                                ₦{{number_format($gross_amount, 2)}}
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 text-color mb-0">
                                <i class="mdi mdi-cash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">
                                Net Payout
                            </h6>
                            <span class="h1 mb-0">
                                ₦{{number_format($net_amount, 2)}}
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 text-color mb-0">
                                <i class="mdi mdi-cash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">
                                Discounted Sum
                            </h6>
                            <span class="h1 mb-0">
                                ₦{{number_format($discounted_sum, 2)}}
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="h2 text-color mb-0">
                                <i class="mdi mdi-cash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gx-0">
                        <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">
                                Packages Bought
                            </h6>
                            <span class="h1 mb-0">
                                {{$bought_package}}
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="chart chart-sparkline">
                                <canvas class="chart-canvas" id="sparklineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row align-items-end justify-content-end mt-4 p-3">
        <form action="{{route('admin.transaction')}}" method="GET" class="me-3">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl">
                    <div class="form-group">
                        <label class="form-label mb-1">
                            Payment Status
                        </label>
                        <select name="status" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl">
                    <div class="form-group">
                        <label class="form-label mb-1">
                            Package
                        </label>
                        <select name="package" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
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
                    <button type="submit" name="fetch_transaction" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-sm btn-primary p-2">
                        <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                    </button>
                    <a href="{{url('admin/transactions')}}" onclick="this.classList.toggle('button--loading')" class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
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
                    <form>
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                            <input class="form-control list-search" type="search" placeholder="Search">
                            <span class="input-group-text">
                                <i class="fe fe-search"></i>
                            </span>
                        </div>
                    </form>
                    <div class="col-auto">
                        <h4>{{number_format($transaction_count)}} transactions</h4>
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
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Name</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Email</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Payment Reference</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Amount</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Discounted Price</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Payment Status</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Payment Date</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package Status</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package Expiry Date</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                            </tr>
                        </thead>
                        @php
                            $transaction_no = 1
                        @endphp
                        @if($transactions)
                            <tbody class="list">
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <div class="form-check mb-n2">
                                                <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArry[]" id="ordersSelectOne" value="{{$transaction->id}}">
                                                <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="orders-order">{{$transaction_no}}</td>
                                        @php
                                            $transaction_no++
                                        @endphp
                                        <td class="orders-product">
                                            <span>{{$transaction->name}}</span>
                                        </td>
                                        <td class="orders-product">{{$transaction->email}}</td>
                                        <td class="orders-date">{{$transaction->reference}}</td>
                                        <td class="orders-date">₦{{number_format($transaction->amount, 2)}}</td>
                                        <td class="orders-date">₦{{number_format($transaction->discounted_price, 2)}}</td>
                                        <td class="orders-date">{{$transaction->package}}</td>
                                        <td class="orders-date">{{$transaction->status}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}</td>
                                        @if($transaction->status == 'paid')
                                            <td class="orders-status">
                                                <div class="badge bg-success-soft">
                                                    Active
                                                </div>
                                            </td>
                                            @php
                                                $package_expiry = App\Models\Package::where('id', $transaction->package_id)->first();
                                                $date = $package_expiry->recur_date;
                                                $transaction_date = \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString();
                                                $get_date = strtotime($transaction_date);
                                                $added_date = strtotime("+$date day", $get_date);
                                                $expiry_date = date('M d, Y', $added_date);
                                            @endphp
                                            <td class="orders-date">{{$expiry_date}}</td>
                                            @else
                                            <td class="orders-status">
                                                <div class="badge bg-secondary-soft">
                                                    Not Active
                                                </div>
                                            </td>
                                            <td class="orders-date">--</td>
                                        @endif
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a style="cursor: pointer" data-bs-toggle="modal" onclick="showEditTransactionModal('{{$transaction->status}}', '{{$transaction->name}}', '{{$transaction->email}}', '{{$transaction->reference}}', '{{$transaction->id}}')" class="dropdown-item">
                                                        <i class="mdi mdi-pencil mr-2"></i> Edit transaction
                                                    </a>
                                                    <form action="/admin/transactions/{{$transaction->id}}" method="POST">
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
<div class="modal fade" id="editTransactionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Update Transaction</div>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-2x">
                        <i class="mdi mdi-close"></i>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y">
                <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                    <div class="container">
                        <div class="stepper-nav justify-content-center">
                            <form action="{{route('update.transaction')}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <h4>Name: <span id="name-input"></span></h4>
                                    <h4>Email: <span id="email-input"></span></h4>
                                    <h4>Payment Reference: <span id="ref-input"></span></h4>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Payment Status
                                    </label>
                                    <input type="hidden" id="transaction-id" name="transaction_id">
                                    <select name="status" id="status-input" class="form-select">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                    </button>
                                </div>
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
        if(!confirm("Are you sure you want to delete this transaction?"))
        event.preventDefault();
    }
    function showEditTransactionModal(status, name, email, ref, id){

        document.getElementById("status-input").value = status;
        document.getElementById("name-input").innerHTML = name;
        document.getElementById("email-input").innerHTML = email;
        document.getElementById("ref-input").innerHTML = ref;
        document.getElementById("transaction-id").value = id;
        $('#editTransactionModal').modal('show')
    }

    // $(function() {
    //     $('input[name="start_date"]').daterangepicker({
    //         singleDatePicker: true,
    //         showDropdowns: true,
    //         minYear: 2020,
    //         maxYear: parseInt(moment().format('YYYY'),10)
    //     });
    //     $('input[name="end_date"]').daterangepicker({
    //         singleDatePicker: true,
    //         showDropdowns: true,
    //         minYear: 1901,
    //         maxYear: parseInt(moment().format('YYYY'),10)
    //     });
    // });
</script>
@endsection
