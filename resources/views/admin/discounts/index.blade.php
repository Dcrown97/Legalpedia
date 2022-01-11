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
                @include('elements.notifications')
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
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Amount of usage</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Amount used</a></th>
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
                                        <td class="orders-product">{{$discount->name}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($discount->validity_start_date)->toFormattedDateString()}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($discount->validity_end_date)->toFormattedDateString()}}</td>
                                        <td class="orders-total">{{$discount->discount_code}}</td>
                                        <td class="orders-total">{{$discount->usage}}</td>
                                        @if($discount->used)
                                            <td class="orders-total">{{$discount->used}}/{{$discount->usage}}</td>
                                            @else
                                            <td class="orders-total">0/{{$discount->usage}}</td>
                                        @endif
                                        <td class="orders-total">{{$discount->percentage}}%</td>
                                        <td class="orders-total"><a href="{{route('sub.pack', $discount->slug)}}" target="_blank">{{$discount->package}}</a></td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a style="cursor: pointer" data-bs-toggle="modal" onclick="showEditDiscountModal('{{$discount->name}}', '{{$discount->validity_start_date}}', '{{$discount->validity_end_date}}', '{{$discount->discount_code}}', '{{$discount->usage}}', '{{$discount->percentage}}', '{{$discount->package}}', '{{$discount->id}}')" class="dropdown-item">
                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                    </a>
                                                    <form action="/admin/discount/{{$discount->id}}" method="POST">
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
                                                <small class="text-muted ml-4">
                                                    <a onclick="genCode(6)" class="custom-button cursor text-color"> Generate coupon</a>
                                                </small>
                                            </label>
                                            <input type="text" name="discount_code" id="code" class="form-control">
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
<div class="modal fade" id="editDiscountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-9">
        <div class="modal-content rounded">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Edit Discount</div>
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
                            <form action="{{route('update.discount')}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Name
                                    </label>
                                    <input type="text" name="name" id="name-input" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Validity Start Date
                                            </label>
                                            <input type="text" name="validity_start_date" id="start-input" class="form-control" data-flatpickr>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Validity End Date
                                            </label>
                                            <input type="text" name="validity_end_date" id="end-input" class="form-control" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Discount Code
                                                <small class="text-muted ml-4">
                                                    <a onclick="regenCode(6)" class="custom-button cursor text-color"> Generate coupon</a>
                                                </small>
                                            </label>
                                            <input type="text" name="discount_code" id="new-code" class="form-control code-input">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Amount of Usage
                                            </label>
                                            <input type="number" name="usage" id="usage-input" min="1" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Percentage (%)
                                            </label>
                                            <input type="number" name="percentage" id="percent-input" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Package
                                            </label>
                                            <input type="hidden" name="slug" class="form-control">
                                            <input type="hidden" id="discount-id" name="discount-id" class="form-control">
                                            <select name="package" id="package-input" class="form-select" data-choices='{"searchEnabled": true}'>
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
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save Discount</span>
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
    // function genCode() {
    //     document.getElementById('code').value = '{{$discount_code}}';
    // }
    // function regenCode() {
    //     document.getElementById('new-code').value = '{{$discount_code}}';
    // }

    function genCode(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        document.getElementById('code').value = result;

    }

    function regenCode(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        document.getElementById('new-code').value = result;

    }

    function showEditDiscountModal(name, start, end, code, usage, percent, package_name, discount_id){
        document.getElementById("name-input").value = name;
        document.getElementById("start-input").value = start;
        document.getElementById("end-input").value = end;
        document.querySelector(".code-input").value = code;
        document.getElementById("usage-input").value = usage;
        document.getElementById("percent-input").value = percent;
        // alert(package_name);
        // var select = document.getElementById("package-input");
        // var opt = document.createElement('option');
        // opt.value = package_name;
        // opt.innerHTML = package_name;
        // select.appendChild(opt);

        $('#package-input').append($('<option>', {
            value: 1,
            text: 'Option Text'
        }));

        document.getElementById("discount-id").value = discount_id;
        $('#editDiscountModal').modal('show')
    }
</script>
@endsection
