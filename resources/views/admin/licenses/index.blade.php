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
                        Manage Licenses
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                        <i class="fe fe-plus"></i> Add License
                    </a>
                </div>
                {{-- @include('elements.notifications') --}}
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
                    <?php $license_no = 1; ?>
                    @if(count($licenses) > 0)
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
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">License Name</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">License Organization</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">License Email</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Package</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Licensed Days</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">License Code</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Active Users</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">License generated</a></th>
                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                                @foreach($licenses as $license)
                                    <tr>
                                        <td>
                                            <div class="form-check mb-n2">
                                                <input class="form-check-input list-checkbox" type="checkbox" name="ordersSelect" id="ordersSelectOne">
                                                <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="orders-order">{{$license_no}}</td>
                                        <?php $license_no++ ; ?>
                                        <td class="orders-product">
                                            {{$license->license_name}}
                                        </td>
                                        <td class="orders-product">{{$license->licensed_organisation}}</td>
                                        <td class="orders-product">{{$license->licensed_email}}</td>
                                        <td class="orders-total">{{$license->package}}</td>
                                        <td class="orders-total">{{$license->license_days}}</td>
                                        <td class="orders-total">{{$license->license_code}}</td>
                                        <td class="orders-total">{{$license->active_users}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($license->created_at)->toFormattedDateString()}}</td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a style="cursor: pointer" data-bs-toggle="modal" onclick="showEditLicenseModal('{{$license->license_name}}', '{{$license->licensed_organisation}}', '{{$license->licensed_email}}', '{{$license->package}}', '{{$license->license_days}}', '{{$license->license_code}}', '{{$license->active_users}}', '{{$license->id}}')" class="dropdown-item">
                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                    </a>
                                                    <form action="/admin/licenses/{{$license->id}}" method="POST">
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
                        <div class="text-center mt-8 mb-8">
                            <h3 class="text-muted"><i class="fe fe-unlock"></i> No License found</h3>
                            <div class="col-auto mt-2">
                                <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                    <i class="fe fe-plus"></i> Create License
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-9">
        <div class="modal-content rounded">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Create License</div>
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
                            <form action="{{route('store.license')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        License Name
                                    </label>
                                    <input type="text" name="license_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        License Organization
                                    </label>
                                    <input type="text" name="licensed_organisation" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        License Email
                                    </label>
                                    <input type="email" name="licensed_email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Package
                                    </label>
                                    <select name="package_id" class="form-select" id="select-package" data-choices='{"searchEnabled": true}'>
                                        <option value="">Select Package</option>
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}">{{$package->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="package" id="package-name">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                License Days
                                            </label>
                                            <input type="number" name="license_days" min="1" class="form-control" placeholder="365">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Active users
                                            </label>
                                            <input type="number" name="active_users" min="1" class="form-control" placeholder="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <span>
                                                    License Code
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <a onclick="genCode(8)" class="custom-button cursor text-color"> Generate license code</a>
                                                </small>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="text" name="license_code" id="code" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-plus"></i> Create License</span>
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
<div class="modal fade" id="editLicenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-9">
        <div class="modal-content rounded">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Update License</div>
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
                            <form action="{{route('update.license')}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        License Name
                                    </label>
                                    <input type="text" name="license_name" id="license-name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        License Organization
                                    </label>
                                    <input type="text" name="license_organisation" id="license-organisation" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        License Email
                                    </label>
                                    <input type="email" name="licensed_email" id="license-email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Package
                                    </label>
                                    <select name="package" id="package-input" class="form-select" data-choices='{"searchEnabled": true}'>

                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                License Days
                                            </label>
                                            <input type="number" name="license_days" min="1" id="license-days" class="form-control" placeholder="365">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Active users
                                            </label>
                                            <input type="number" name="active_users" min="1" id="active-users" class="form-control" placeholder="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <span>
                                                    License Code
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <a onclick="regenCode(8)" class="custom-button cursor text-color"> Generate license code</a>
                                                </small>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="hidden" name="license_id" id="license-id">
                                    <input type="text" name="license_code" id="new-code" class="form-control code-input">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                        <span class="button__text"><i class="mdi mdi-plus"></i> Create License</span>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function deleteFunction() {
        if(!confirm("Are you sure you want to delete this license?"))
        event.preventDefault();
    }
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

    function showEditLicenseModal(name, org, email, package_name, days, code, active, id){
        document.getElementById("license-name").value = name;
        document.getElementById("license-oragnisation").value = org;
        document.getElementById("license-email").value = email;

        $('#package-input').append($('<option>', {
            value: package_name,
            text: package_name
        }));

        // document.getElementById("package-input").value = package_name;
        document.getElementById("license-days").value = days;
        document.querySelector(".code-input").value = code;
        document.getElementById("active-users").value = active;
        document.getElementById("license-id").value = id;
        $('#editLicenseModal').modal('show')

    }

    $(document).ready(function () {
        toggleFields();
        $("#select-package").change(function () {
            toggleFields();
        });

    });

    function toggleFields() {
        document.getElementById('package-name').value =  $("#select-package option:selected").text();
    }


</script>
@endsection
