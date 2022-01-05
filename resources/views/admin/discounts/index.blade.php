@extends('layouts.admin.discount')

@section('title')
    <title>Discount - Legalpedia</title>
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
                        Manage Discount
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                        <i class="fe fe-plus"></i> Add Discount
                    </a>
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
                    <form>
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                        <input class="form-control list-search" type="search" placeholder="Search">
                        <span class="input-group-text">
                            <i class="fe fe-search"></i>
                        </span>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <?php $discount_no = 1; ?>
                    @if(count($discounts) > 0)
                        <table class="table table-sm table-nowrap card-table">
                            <thead>
                                <tr>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Name</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Validity Start Date</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Validity End Date</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Discount Code</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Amount of usgae</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Percentage</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Package</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach($discounts as $discount)
                                    <tr>
                                        <td class="orders-order">{{$discount_no}}</td>
                                        <?php $discount_no++; ?>
                                        <td class="orders-date">{{$discount->name}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($discount->validity_start_date)->toFormattedDateString()}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($discount->validity_end_date)->toFormattedDateString()}}</td>
                                        <td class="orders-total">{{$discount->discount_code}}</td>
                                        <td class="orders-total">{{$discount->usage}}</td>
                                        <td class="orders-total">{{$discount->percentage}}%</td>
                                        <td class="orders-total"><a href="{{route('sub.pack', $discount->slug)}}" target="_blank">{{$discount->package}}</a></td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#!" class="dropdown-item">
                                                        <i class="mdi mdi-pencil mr-2"></i>Edit
                                                    </a>
                                                    <a href="#!" class="dropdown-item">
                                                        <i class="fe fe-trash mr-2"></i>Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center mt-4 text-muted">
                            <h1>No record found</h1>
                        </div>
                    @endif
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
                <div class="fs-1 fw-boldest">Create Discount</div>
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
                            <form action="{{route('store.discount')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Name
                                    </label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Validity Start Date
                                            </label>
                                            <input type="text" name="validity_start_date" class="form-control" data-flatpickr>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Validity End Date
                                            </label>
                                            <input type="text" name="validity_end_date" class="form-control" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Discount Code
                                            </label>
                                            <input type="text" name="discount_code" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Amount of Usage
                                            </label>
                                            <input type="number" name="usage" min="1" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Percentage (%)
                                            </label>
                                            <input type="number" name="percentage" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Package
                                            </label>
                                            <input type="hidden" name="slug" class="form-control">
                                            <select name="package" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                <option value="">Select Package</option>
                                                @foreach($packages as $package)
                                                    <option value="{{$package->name}}">{{$package->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-plus"></i> Create Discount</span>
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
        if(!confirm("Are you sure you want to delete this discount?"))
        event.preventDefault();
    }
</script>
@endsection
