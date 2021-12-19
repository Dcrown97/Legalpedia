@extends('layouts.admin')

@section('title')
    <title>Dashboard - Legalpedia</title>
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
                        @if(Auth::user()->role->name == 'Admin')
                            Welcome, Admin
                            @else
                            Welcome, {{Str::words(Auth::user()->name, 1)}}
                        @endif
                    </h1>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/judgements')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Judgements
                                    </h6>
                                    <span class="h2 mb-0">
                                        <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt=" Latest Judgments">
                                        <span>Latest Judgments</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/laws-of-federation')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                Laws
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Laws of Federation"> Laws of Federation
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/rules-of-court')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                Rules
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="State Rules of Court"> Rules of Court
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/state-rules-of-court')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                State Rules
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="State rules of court"> State Rules of Court
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/forms-and-precedences')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Forms
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt="Forms & Precedences"> Forms & Precedences
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/legal-articles')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Legal Articles
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Laws of Federation"> Legal Articles
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/law-dictionary')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Law Dictionary
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="State Rules of Court"> Law Dictionary
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-6 col-xl">
                <a href="{{url('admin/legal-maxims')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-3">
                                    Maxims
                                </h6>
                                <span class="h2 mb-0">
                                    <img class="h-4 w-4 mr-1" src="{{asset('assets/images/gavel.png')}}" alt="Forms and Precedents"> Legal Maxims
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
            {{-- <div class="row">
                <div class="col-12 col-lg-6 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col-md-3">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Resources
                                    </h6>
                                    <span class="h2 mb-0">
                                        <img class="h-4 w-4 mr-1" src="{{asset('assets/images/balance.png')}}" alt=" Latest Judgments"> Resources
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
      </div>


    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-fullscreen p-9">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <div class="fs-1 fw-boldest">Create Project</div>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y m-5">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Nav-->
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
                            <!--end::Nav-->
                            <!--begin::Form-->
                            <form class="mx-auto w-100 mw-600px pt-15 pb-10" novalidate="novalidate" id="kt_modal_create_project_form">
                                <!--begin::Type-->
                                <div class="current" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-7 pb-lg-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Project Type</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check out
                                            <a href="#" class="link-primary fw-bolder">FAQ Page</a></div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-15" data-kt-buttons="true">
                                            <!--begin::Option-->
                                            <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 mb-6 active">
                                                <!--begin::Input-->
                                                <input class="btn-check" type="radio" checked="checked" name="project_type" value="1" />
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <span class="d-flex">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                                                    <span class="svg-icon svg-icon-3hx">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="black" />
                                                            <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <span class="ms-4">
                                                        <span class="fs-3 fw-boldest text-gray-900 mb-2 d-block">Personal Project</span>
                                                        <span class="fw-bold fs-4 text-gray-400">If you need more info, please check it out</span>
                                                    </span>
                                                    <!--end::Info-->
                                                </span>
                                                <!--end::Label-->
                                            </label>
                                            <!--end::Option-->
                                            <!--begin::Option-->
                                            <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6">
                                                <!--begin::Input-->
                                                <input class="btn-check" type="radio" name="project_type" value="2" />
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <span class="d-flex">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <span class="svg-icon svg-icon-3hx">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                                                            <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                                                            <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                                                            <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <span class="ms-4">
                                                        <span class="fs-3 fw-boldest text-gray-900 mb-2 d-block">Team Project</span>
                                                        <span class="fw-bold fs-4 text-gray-400">Create corporate account to manage users</span>
                                                    </span>
                                                    <!--end::Info-->
                                                </span>
                                                <!--end::Label-->
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-element="type-next">
                                                <span class="indicator-label">Project Settings</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Type-->
                                <!--begin::Settings-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Project Settings</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check
                                            <a href="#" class="link-primary">Project Guidelines</a></div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="kt_modal_create_project_settings_logo">
                                                <!--begin::Message-->
                                                <div class="dz-message needsclick">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/files/fil010.svg-->
                                                    <span class="svg-icon svg-icon-3hx svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 12.6L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L8 12.6H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V12.6H16Z" fill="black" />
                                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="dfs-3 fw-boldest text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                        <span class="fw-bold fs-4 text-gray-400">Upload up to 10 files</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Customer</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select..." name="settings_customer">
                                                <option></option>
                                                <option value="1">Keenthemes</option>
                                                <option value="2">Craft</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Project Name</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify project name"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder="Enter Project Name" value="StockPro Mobile App" name="settings_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Project Description</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-solid" rows="3" placeholder="Enter Project Description" name="settings_description">Experience share market at your fingertips with TICK PRO stock investment mobile trading app</textarea>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">Release Date</label>
                                            <!--end::Label-->
                                            <!--begin::Wrapper-->
                                            <div class="position-relative d-flex align-items-center">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black" />
                                                        <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black" />
                                                        <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-solid ps-12" placeholder="Pick date rage" name="settings_release_date" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-15">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="required fs-6 fw-bold">Notifications</label>
                                                    <div class="fs-7 fw-bold text-gray-400">Allow Notifications by Phone or Email</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Checkboxes-->
                                                <div class="d-flex">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-10">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input h-20px w-20px" type="checkbox" value="email" name="settings_notifications[]" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label fw-bold">Email</span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input h-20px w-20px" type="checkbox" value="phone" checked="checked" name="settings_notifications[]" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label fw-bold">Phone</span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Checkbox-->
                                                </div>
                                                <!--end::Checkboxes-->
                                            </div>
                                            <!--begin::Wrapper-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-stack">
                                            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="settings-previous">Project Type</button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-element="settings-next">
                                                <span class="indicator-label">Budget</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Settings-->
                                <!--begin::Budget-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Budget</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check
                                            <a href="#" class="link-primary">Project Guidelines</a></div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Setup Budget</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="&lt;div class='p-4 rounded bg-light'&gt; &lt;div class='d-flex flex-stack text-muted mb-4'&gt; &lt;i class='fas fa-university fs-3 me-3'&gt;&lt;/i&gt; &lt;div class='fw-bold'&gt;INCBANK **** 1245 STATEMENT&lt;/div&gt; &lt;/div&gt; &lt;div class='d-flex flex-stack fw-bold text-gray-600'&gt; &lt;div&gt;Amount&lt;/div&gt; &lt;div&gt;Transaction&lt;/div&gt; &lt;/div&gt; &lt;div class='separator separator-dashed my-2'&gt;&lt;/div&gt; &lt;div class='d-flex flex-stack text-dark fw-bolder mb-2'&gt; &lt;div&gt;USD345.00&lt;/div&gt; &lt;div&gt;KEENTHEMES*&lt;/div&gt; &lt;/div&gt; &lt;div class='d-flex flex-stack text-muted mb-2'&gt; &lt;div&gt;USD75.00&lt;/div&gt; &lt;div&gt;Hosting fee&lt;/div&gt; &lt;/div&gt; &lt;div class='d-flex flex-stack text-muted'&gt; &lt;div&gt;USD3,950.00&lt;/div&gt; &lt;div&gt;Payrol&lt;/div&gt; &lt;/div&gt; &lt;/div&gt;"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Dialer-->
                                            <div class="position-relative w-lg-250px" id="kt_modal_create_project_budget_setup" data-kt-dialer="true" data-kt-dialer-min="50" data-kt-dialer-max="50000" data-kt-dialer-step="100" data-kt-dialer-prefix="$" data-kt-dialer-decimals="2">
                                                <!--begin::Decrease control-->
                                                <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black" />
                                                            <rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Decrease control-->
                                                <!--begin::Input control-->
                                                <input type="text" class="form-control form-control-solid border-0 ps-12" data-kt-dialer-control="input" placeholder="Amount" name="budget_setup" readonly="readonly" value="$50" />
                                                <!--end::Input control-->
                                                <!--begin::Increase control-->
                                                <button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black" />
                                                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="black" />
                                                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Increase control-->
                                            </div>
                                            <!--end::Dialer-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Budget Usage</label>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default active d-flex text-start p-6" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="budget_usage" value="1" checked="checked" />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-boldest text-gray-800 mb-2 d-block">Precise Usage</span>
                                                            <span class="fw-bold fs-7 text-gray-600">Withdraw money to your bank account per transaction under $50,000 budget</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="budget_usage" value="2" />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-boldest text-gray-800 mb-2 d-block">Extreme Usage</span>
                                                            <span class="fw-bold fs-7 text-gray-600">Withdraw money to your bank account per transaction under $50,000 budget</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-15">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="fs-6 fw-bold">Allow Changes in Budget</label>
                                                    <div class="fs-7 fw-bold text-gray-400">If you need more info, please check budget planning</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" name="budget_allow" checked="checked" />
                                                    <span class="form-check-label fw-bold text-gray-400">Allowed</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-stack">
                                            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="budget-previous">Project Settings</button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-element="budget-next">
                                                <span class="indicator-label">Build Team</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Budget-->
                                <!--begin::Team-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Build a Team</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check
                                            <a href="#" class="link-primary">Project Guidelines</a></div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="mb-8">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Invite Teammates</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder="Add project memnbers by name or email.." name="invite_teammates" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-8">
                                            <!--begin::Label-->
                                            <div class="fs-6 fw-bold mb-2">Team Members</div>
                                            <!--end::Label-->
                                            <!--begin::Users-->
                                            <div class="mh-300px scroll-y me-n7 pe-7">
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-1.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Emma Smith</a>
                                                            <div class="fw-bold text-gray-400">e.smith@kpmg.com.au</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2" selected="selected">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-danger text-danger fw-bold">M</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Melody Macy</a>
                                                            <div class="fw-bold text-gray-400">melody@altbox.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1" selected="selected">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-26.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Max Smith</a>
                                                            <div class="fw-bold text-gray-400">max@kt.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-4.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Sean Bean</a>
                                                            <div class="fw-bold text-gray-400">sean@dellito.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2" selected="selected">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-15.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Brian Cox</a>
                                                            <div class="fw-bold text-gray-400">brian@exchange.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-warning text-warning fw-bold">M</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
                                                            <div class="fw-bold text-gray-400">mikaela@pexcom.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2" selected="selected">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-8.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Francis Mitcham</a>
                                                            <div class="fw-bold text-gray-400">f.mitcham@kpmg.com.au</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-danger text-danger fw-bold">O</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
                                                            <div class="fw-bold text-gray-400">olivia@corpmail.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2" selected="selected">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-primary text-primary fw-bold">N</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Neil Owen</a>
                                                            <div class="fw-bold text-gray-400">owen.neil@gmail.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1" selected="selected">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-6.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
                                                            <div class="fw-bold text-gray-400">dam@consilting.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-danger text-danger fw-bold">E</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Emma Bold</a>
                                                            <div class="fw-bold text-gray-400">emma@intenso.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2" selected="selected">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-7.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Ana Crown</a>
                                                            <div class="fw-bold text-gray-400">ana.cf@limtel.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1" selected="selected">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-info text-info fw-bold">A</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Robert Doe</a>
                                                            <div class="fw-bold text-gray-400">robert@benko.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-17.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">John Miller</a>
                                                            <div class="fw-bold text-gray-400">miller@mapple.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <span class="symbol-label bg-light-success text-success fw-bold">L</span>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
                                                            <div class="fw-bold text-gray-400">lucy.m@fentech.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2" selected="selected">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-10.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Ethan Wilder</a>
                                                            <div class="fw-bold text-gray-400">ethan@loop.com.au</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1" selected="selected">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::User-->
                                                <div class="d-flex flex-stack py-4">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img alt="Pic" src="../../assets/media/avatars/150-4.jpg" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Sean Bean</a>
                                                            <div class="fw-bold text-gray-400">sean@dellito.com</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                            <option value="1">Guest</option>
                                                            <option value="2">Owner</option>
                                                            <option value="3" selected="selected">Can Edit</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                            </div>
                                            <!--end::Users-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Notice-->
                                        <div class="d-flex flex-stack mb-15">
                                            <!--begin::Label-->
                                            <div class="me-5 fw-bold">
                                                <label class="fs-6">Adding Users by Team Members</label>
                                                <div class="fs-7 text-gray-400">If you need more info, please check budget planning</div>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="" checked="checked" />
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Notice-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-stack">
                                            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="team-previous">Budget</button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-element="team-next">
                                                <span class="indicator-label">Set Target</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Team-->
                                <!--begin::Targets-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Set First Target</h1>
                                            <!--end::Title-->
                                            <!--begin::Title-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check
                                            <a href="#" class="link-primary">Project Guidelines</a></div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <label class="fs-6 fw-bold mb-2">Target Title</label>
                                            <input type="text" class="form-control form-control-solid" placeholder="Enter Target Title" name="Project Launch" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row g-9 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <label class="required fs-6 fw-bold mb-2">Assign</label>
                                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a Team Member" name="target_assign">
                                                    <option></option>
                                                    <option value="1">Karina Clark</option>
                                                    <option value="2" selected="selected">Robert Doe</option>
                                                    <option value="3">Niel Owen</option>
                                                    <option value="4">Olivia Wild</option>
                                                    <option value="5">Sean Bean</option>
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <label class="required fs-6 fw-bold mb-2">Due Date</label>
                                                <div class="position-relative d-flex align-items-center">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                                    <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black" />
                                                            <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black" />
                                                            <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Datepicker-->
                                                    <input class="form-control form-control-solid ps-12" placeholder="Pick date range" name="target_due_date" />
                                                    <!--end::Datepicker-->
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <label class="fs-6 fw-bold mb-2">Target Details</label>
                                            <textarea class="form-control form-control-solid" rows="2" name="target_details" placeholder="Type Target Details">Experience share market at your fingertips with TICK PRO stock investment mobile trading app</textarea>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <label class="required fs-6 fw-bold mb-2">Tags</label>
                                            <input class="form-control form-control-solid" value="Important, Urgent" name="target_tags" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="fs-6 fw-bold">Allow Changes in Budget</label>
                                                    <div class="fs-7 fw-bold text-gray-400">If you need more info, please check budget planning</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" name="target_allow" checked="checked" />
                                                    <span class="form-check-label fw-bold text-gray-400">Allowed</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-15">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="fs-6 fw-bold">Notifications</label>
                                                    <div class="fs-7 fw-bold text-gray-400">Allow Notifications by Phone or Email</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Checkboxes-->
                                                <div class="d-flex">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-10">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input h-20px w-20px" type="checkbox" value="email" name="target_notifications[]" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label fw-bold">Email</span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input h-20px w-20px" type="checkbox" value="phone" checked="checked" name="target_notifications[]" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label fw-bold">Phone</span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Checkbox-->
                                                </div>
                                                <!--end::Checkboxes-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-stack">
                                            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="targets-previous">Build a Team</button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-element="targets-next">
                                                <span class="indicator-label">Upload Files</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Targets-->
                                <!--begin::Files-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Upload Files</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check
                                            <a href="#" class="link-primary">Project Guidelines</a></div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="kt_modal_create_project_files_upload">
                                                <!--begin::Message-->
                                                <div class="dz-message needsclick">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/files/fil010.svg-->
                                                    <span class="svg-icon svg-icon-3hx svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 12.6L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L8 12.6H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V12.6H16Z" fill="black" />
                                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="dfs-3 fw-boldest text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                        <span class="fw-bold fs-4 text-gray-400">Upload up to 10 files</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-8">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Uploaded File</label>
                                            <!--End::Label-->
                                            <!--begin::Files-->
                                            <div class="mh-300px scroll-y me-n7 pe-7">
                                                <!--begin::File-->
                                                <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px">
                                                            <img src="https://preview.keenthemes.com/craft/assets/media/svg/files/pdf.svg" alt="icon" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-6">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Avionica Technical Requirements</a>
                                                            <div class="fw-bold text-gray-400">230kb</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--begin::Menu-->
                                                    <div class="min-w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Edit">
                                                            <option></option>
                                                            <option value="1">Remove</option>
                                                            <option value="2">Modify</option>
                                                            <option value="3">Select</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::File-->
                                                <!--begin::File-->
                                                <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px">
                                                            <img src="https://preview.keenthemes.com/craft/assets/media/svg/files/doc.svg" alt="icon" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-6">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">9 Degree CURD draftplan</a>
                                                            <div class="fw-bold text-gray-400">3.6mb</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--begin::Menu-->
                                                    <div class="min-w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Edit">
                                                            <option></option>
                                                            <option value="1">Remove</option>
                                                            <option value="2">Modify</option>
                                                            <option value="3">Select</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::File-->
                                                <!--begin::File-->
                                                <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px">
                                                            <img src="https://preview.keenthemes.com/craft/assets/media/svg/files/css.svg" alt="icon" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-6">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">User CRUD Styles</a>
                                                            <div class="fw-bold text-gray-400">85kb</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--begin::Menu-->
                                                    <div class="min-w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Edit">
                                                            <option></option>
                                                            <option value="1">Remove</option>
                                                            <option value="2">Modify</option>
                                                            <option value="3">Select</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::File-->
                                                <!--begin::File-->
                                                <div class="d-flex flex-stack py-4 border border-top-0 border-left-0 border-right-0 border-dashed">
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px">
                                                            <img src="https://preview.keenthemes.com/craft/assets/media/svg/files/ai.svg" alt="icon" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-6">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Craft Initial Logo</a>
                                                            <div class="fw-bold text-gray-400">40kb</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--begin::Menu-->
                                                    <div class="min-w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Edit">
                                                            <option></option>
                                                            <option value="1">Remove</option>
                                                            <option value="2">Modify</option>
                                                            <option value="3">Select</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::File-->
                                                <!--begin::File-->
                                                <div class="d-flex flex-stack py-4">
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-35px">
                                                            <img src="https://preview.keenthemes.com/craft/assets/media/svg/files/tif.svg" alt="icon" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Details-->
                                                        <div class="ms-6">
                                                            <a href="#" class="fs-5 fw-boldest text-gray-900 text-hover-primary mb-2">Tower Hill Bilboard</a>
                                                            <div class="fw-bold text-gray-400">27mb</div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--begin::Menu-->
                                                    <div class="min-w-100px">
                                                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Edit">
                                                            <option></option>
                                                            <option value="1">Remove</option>
                                                            <option value="2">Modify</option>
                                                            <option value="3">Select</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::File-->
                                            </div>
                                            <!--end::Files-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="fs-6 fw-bold">Allow Changes in Budget</label>
                                                    <div class="fs-7 fw-bold text-gray-400">If you need more info, please check budget planning</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" name="target_allow" checked="checked" />
                                                    <span class="form-check-label fw-bold text-gray-400">Allowed</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-stack">
                                            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="files-previous">Set First Target</button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-element="files-next">
                                                <span class="indicator-label">Complete</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Files-->
                                <!--begin::Complete-->
                                <div data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-12 text-center">
                                            <!--begin::Title-->
                                            <h1 class="fw-boldest text-dark">Project Created!</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-400 fw-bold fs-4">If you need more info, please check how to create project</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-center pb-20">
                                            <button type="button" class="btn btn-lg btn-light me-3" data-kt-element="complete-start">Create New Project</button>
                                            <a href="https://preview.keenthemes.com/craft/pages/projects/project.html" class="btn btn-lg btn-primary">View Project</a>
                                        </div>
                                        <!--end::Actions-->
                                        <!--begin::Illustration-->
                                        <div class="text-center px-5">
                                            <img src="../../assets/media/illustrations/sigma-1/19.png" alt="" class="mw-100 mh-300px" />
                                        </div>
                                        <!--end::Illustration-->
                                    </div>
                                </div>
                                <!--end::Complete-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--begin::Container-->
                    </div>
                    <!--end::Stepper-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

@endsection
