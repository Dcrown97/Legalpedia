@extends('layouts.admin.rules-of-court')

@section('title')
    <title>Rules of Court - Legalpedia</title>
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
                            Rules of Court
                        </h1>
                    </div>
                    {{-- <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button">New Project</a> --}}
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add Rules
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
                <ul class="nav nav-tabs nav-overflow header-tabs">
                    <li class="nav-item">
                    <a href="profile-posts.html" class="nav-link active">
                        Orders
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="profile-groups.html" class="nav-link">
                        Parts
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="profile-projects.html" class="nav-link">
                        Schedules
                    </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile-projects.html" class="nav-link">
                            Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile-projects.html" class="nav-link">
                            Portrate Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile-projects.html" class="nav-link">
                            Civil Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile-projects.html" class="nav-link">
                            Appendix
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
            <div class="card" data-list='{"valueNames": ["name"]}'>
              <div class="card-header">
                <h4 class="card-header-title">Orders</h4>
                <form class="">
                  <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                    <option value="">ADMIRALTY JURISDICTION PROCEDURE RULES</option>
                    <option value="asc">COURT OF APPEAL RULES</option>
                    <option value="desc">FEDERAL HIGH COURT RULES</option>
                    <option value="desc">FUNDAMENTAL RIGHTS ENFORCEMENT PROCEDURE RULES 2009</option>
                    <option value="desc">MAGISTRATES COURTS (CIVIL PROCEDURE) RULES LAGOS STATE</option>
                    <option value="desc">MAGISTRATES COURTS OF RIVERS STATE (CIVIL PROCEDURE) RULES, 2007</option>
                    <option value="desc">NATIONAL INDUSTRIAL COURT RULES 2017</option>
                    <option value="desc">SECURITIES AND EXCHANGE COMMISSION RULES</option>
                    <option value="desc">SUPREME COURT RULES</option>
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
                      <div class="col">
                        <h4 class="mb-1 name">
                            <i class="fe fe-file mr-1"></i><a href="#!">ORDER 01 - FORMS AND COMMENCEMENT OF ACTION</a>
                        </h4>
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
                      <div class="col">
                        <h4 class="mb-1 name">
                            <i class="fe fe-file mr-1"></i><a href="#!">ORDER 02 - EFFECT OF NON-COMPLIANCE</a>
                        </h4>
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
