@extends('layouts.admin')

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
                            <td class="orders-total">08127131208</td>
                            <td class="orders-total">07/11/2020</td>
                            <td class="orders-total">Land Law</td>
                            <td class="orders-total">Referees</td>
                            <td class="orders-total">2018</td>
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
                            <td class="orders-total">08127131208</td>
                            <td class="orders-total">07/11/2020</td>
                            <td class="orders-total">Land Law</td>
                            <td class="orders-total">Referees</td>
                            <td class="orders-total">2018</td>
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
                <!-- Pagination -->
                <div class="row g-0">

                    <!-- Pagination (prev) -->
                    <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                      <li class="page-item">
                        <a class="page-link" href="#">
                          <i class="fe fe-arrow-left me-1"></i> Prev
                        </a>
                      </li>
                    </ul>

                    <!-- Pagination -->
                    <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>

                    <!-- Pagination (next) -->
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
