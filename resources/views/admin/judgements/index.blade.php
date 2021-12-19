@extends('layouts.admin.judgements')

@section('title')
    <title>Judgements - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
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
                            Judgement
                        </h1>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add Judgement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">
                            Year Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="subject-tab" data-toggle="tab" href="#subject" role="tab" aria-controls="subject" aria-selected="false">
                            Subject Matter Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="legal-tab" data-toggle="tab" href="#legal" role="tab" aria-controls="legal" aria-selected="false">
                            Legalpedia Citation index
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="wizardSteps">
                    <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="year-tab">
                        <div class="card" data-list='{"valueNames": ["name"]}'>
                            <div class="card-header">
                                <h4 class="card-header-title">Year Index</h4>
                                <form class="">
                                    <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="">Select Court</option>
                                    <option value="asc">Federal High Court</option>
                                    <option value="asc">Sharia Court</option>
                                    <option value="desc">Supreme Court of Nigeria</option>
                                    <option value="desc">Investments and Securities Tribunal</option>
                                    <option value="desc">Court of Appeal</option>
                                    </select>
                                </form>
                                <form class="me-3">
                                <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="">Select Year range</option>
                                    <option value="asc">1960 - 1969</option>
                                    <option value="desc">1970 - 1979</option>
                                    <option value="desc">1980 - 1989</option>
                                    <option value="desc">1990 - 1999</option>
                                    <option value="desc">2000 - 2009</option>
                                </select>
                                </form>
                                <a href="#!" class="btn btn-sm btn-primary p-2"><i class="mdi mdi-filter"></i> Filter</a>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="#!" class="avatar text-color avatar-lg">
                                        <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name">
                                        <a href="#!">EMMANUEL ORSAR AKURA (SUING BY HIS ATTORNEY, JOHN AKOUGH) V. OKECHUKWU NWABOLUE AKPOM</a>
                                        </h4>
                                        <p class="card-text text-color small mb-1">
                                        In Court of Appeal
                                        </p>
                                        <p class="card-text small text-muted">
                                            Tuesday, Janueary 3, 2018
                                        </p>
                                    </div>
                                    <div class="col-auto">
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
                                    </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="#!" class="avatar text-color avatar-lg">
                                        <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name">
                                        <a href="#!">EMMANUEL ORSAR AKURA (SUING BY HIS ATTORNEY, JOHN AKOUGH) V. OKECHUKWU NWABOLUE AKPOM</a>
                                        </h4>
                                        <p class="card-text text-color small mb-1">
                                        In Court of Appeal
                                        </p>
                                        <p class="card-text small text-muted">
                                            Tuesday, Janueary 3, 2018
                                        </p>
                                    </div>
                                    <div class="col-auto">
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
                                    </div>
                                    </div>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
                        <div class="card" data-list='{"valueNames": ["name"]}'>
                            <div class="card-header">
                                <h4 class="card-header-title">Subject Matter Index</h4>
                                <form class="">
                                    <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="">Select Court</option>
                                    <option value="asc">Federal High Court</option>
                                    <option value="asc">Sharia Court</option>
                                    <option value="desc">Supreme Court of Nigeria</option>
                                    <option value="desc">Investments and Securities Tribunal</option>
                                    <option value="desc">Court of Appeal</option>
                                    </select>
                                </form>
                                <form class="me-3">
                                <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="">Select Year range</option>
                                    <option value="asc">1960 - 1969</option>
                                    <option value="desc">1970 - 1979</option>
                                    <option value="desc">1980 - 1989</option>
                                    <option value="desc">1990 - 1999</option>
                                    <option value="desc">2000 - 2009</option>
                                </select>
                                </form>
                                <a href="#!" class="btn btn-sm btn-primary p-2"><i class="mdi mdi-filter"></i> Filter</a>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="#!" class="avatar text-color avatar-lg">
                                        <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name">
                                        <a href="#!">EMMANUEL ORSAR AKURA (SUING BY HIS ATTORNEY, JOHN AKOUGH) V. OKECHUKWU NWABOLUE AKPOM</a>
                                        </h4>
                                        <p class="card-text text-color small mb-1">
                                        In Court of Appeal
                                        </p>
                                        <p class="card-text small text-muted">
                                            Tuesday, Janueary 3, 2018
                                        </p>
                                    </div>
                                    <div class="col-auto">
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
                                    </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="#!" class="avatar text-color avatar-lg">
                                        <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name">
                                        <a href="#!">EMMANUEL ORSAR AKURA (SUING BY HIS ATTORNEY, JOHN AKOUGH) V. OKECHUKWU NWABOLUE AKPOM</a>
                                        </h4>
                                        <p class="card-text text-color small mb-1">
                                        In Court of Appeal
                                        </p>
                                        <p class="card-text small text-muted">
                                            Tuesday, Janueary 3, 2018
                                        </p>
                                    </div>
                                    <div class="col-auto">
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
                                    </div>
                                    </div>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="legal" role="tabpanel" aria-labelledby="legal-tab">
                        <div class="card" data-list='{"valueNames": ["name"]}'>
                            <div class="card-header">
                                <h4 class="card-header-title">Legalpedia Citation index</h4>
                                <form class="">
                                    <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="">Select Court</option>
                                    <option value="asc">Federal High Court</option>
                                    <option value="asc">Sharia Court</option>
                                    <option value="desc">Supreme Court of Nigeria</option>
                                    <option value="desc">Investments and Securities Tribunal</option>
                                    <option value="desc">Court of Appeal</option>
                                    </select>
                                </form>
                                <form class="me-3">
                                <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="">Select Year range</option>
                                    <option value="asc">1960 - 1969</option>
                                    <option value="desc">1970 - 1979</option>
                                    <option value="desc">1980 - 1989</option>
                                    <option value="desc">1990 - 1999</option>
                                    <option value="desc">2000 - 2009</option>
                                </select>
                                </form>
                                <a href="#!" class="btn btn-sm btn-primary p-2"><i class="mdi mdi-filter"></i> Filter</a>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="#!" class="avatar text-color avatar-lg">
                                        <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name">
                                        <a href="#!">EMMANUEL ORSAR AKURA (SUING BY HIS ATTORNEY, JOHN AKOUGH) V. OKECHUKWU NWABOLUE AKPOM</a>
                                        </h4>
                                        <p class="card-text text-color small mb-1">
                                        In Court of Appeal
                                        </p>
                                        <p class="card-text small text-muted">
                                            Tuesday, Janueary 3, 2018
                                        </p>
                                    </div>
                                    <div class="col-auto">
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
                                    </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="#!" class="avatar text-color avatar-lg">
                                        <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name">
                                        <a href="#!">EMMANUEL ORSAR AKURA (SUING BY HIS ATTORNEY, JOHN AKOUGH) V. OKECHUKWU NWABOLUE AKPOM</a>
                                        </h4>
                                        <p class="card-text text-color small mb-1">
                                        In Court of Appeal
                                        </p>
                                        <p class="card-text small text-muted">
                                            Tuesday, Janueary 3, 2018
                                        </p>
                                    </div>
                                    <div class="col-auto">
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
                                    </div>
                                    </div>
                                </li>
                                </ul>
                            </div>
                        </div>
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
