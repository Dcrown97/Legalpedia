@extends('layouts.admin')

@section('title')
    <title>Subscription Packages- Legalpedia</title>
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
                        Manage Subscription Packages
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                        <i class="fe fe-plus"></i> Add Packages
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

                <!-- Search -->
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
                <table class="table table-sm table-nowrap card-table">
                    <thead>
                    <tr>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Name</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Price</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Date Created</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Package Link</a></th>
                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                        {{-- <th colspan="2"><a href="#" class="text-muted list-sort" data-sort="orders-method">Payment method</a></th> --}}
                    </tr>
                    </thead>
                    <tbody class="list">
                        <tr>
                            <td class="orders-order">1</td>
                            <td class="orders-date">LegalPedia Package</td>
                            <td class="orders-total">₦20,000</td>
                            <td class="orders-total">07/11/2020</td>
                            <td class="orders-total"><a href="#!">http://www.google.com/package-link</a></td>
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
                        <tr>
                            <td class="orders-order">2</td>
                            <td class="orders-date">LegalPedia Package</td>
                            <td class="orders-total">₦20,000</td>
                            <td class="orders-total">07/11/2020</td>
                            <td class="orders-total"><a href="#!">http://www.google.com/package-link</a></td>
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
                    </tbody>
                </table>
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
                            <!--begin::Step 1-->
                            <div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Project Type</h3>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Project Settings</h3>
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Budget</h3>
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Build A Team</h3>
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Set First Target</h3>
                            </div>
                            <!--end::Step 5-->
                            <!--begin::Step 6-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Upload Files</h3>
                            </div>
                            <!--end::Step 6-->
                            <!--begin::Step 7-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Completed</h3>
                            </div>
                            <!--end::Step 7-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
