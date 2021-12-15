@extends('layouts.admin')

@section('title')
    <title>Laws of Federation - Legalpedia</title>
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
                            Laws of Federation
                        </h1>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn text-white btn-primary text0-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add Laws
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
                <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                    <div class="card-header">
                        <h4 class="card-header-title">Laws</h4>
                        <form class="me-3 w-20">
                            <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                <option value="">Select </option>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}">{{$category->category}}</option>
                                @endforeach
                            </select>
                        </form>
                        <a href="#!" class="btn text-white btn-sm btn-primary p-2"><i class="mdi mdi-filter"></i> Filter</a>
                    </div>
                    <div class="card-header">
                      <div class="row align-items-center">
                        <div class="col">
                          <form>
                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                              <input class="form-control list-search" type="search" placeholder="Search">
                              <span class="input-group-text">
                                <i class="fe fe-search"></i>
                              </span>
                            </div>
                          </form>
                        </div>
                        <div class="col-auto me-n3">
                            <h4>{{$fed_count}} records</h4>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                        @if($feds)
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                @foreach($feds as $fed)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{route('show.fed', $fed->id)}}" class="avatar text-color avatar-lg">
                                                    <i class="fe fe-file"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <a href="{{route('show.fed', $fed->id)}}">{{$fed->Title}}</a>
                                                </h4>
                                                <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$fed->category}}</span></p>
                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fe fe-more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="{{route('edit.fed', $fed->id)}}" class="dropdown-item">
                                                            <i class="mdi mdi-pencil mr-2"></i> Edit
                                                        </a>
                                                        <form action="/admin/laws-of-federation/{{$fed->id}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                                <i class="fe fe-trash mr-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="text-center">
                                <h1>No record found</h1>
                            </div>
                        @endif
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
                    <div class="fs-1 fw-boldest">Add Law of Federation</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('store.fed')}}" method="POST">
                                @csrf
                                <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel" aria-labelledby="wizardTabOne">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Create new Law</h1>
                                            <p class="mb-5 text-muted">Add federation laws, parts and sections</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Title
                                        </label>
                                        <input type="text" name="Title" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Law No.
                                                </label>
                                                <input type="number" name="LawNo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Law Date.
                                                </label>
                                                <input type="date" name="LawDate" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Description
                                        </label>
                                        <textarea name="Descr" rows="5" placeholder="Enter description"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="category" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="area_of_law" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->AreaOfLaw}}">{{$area_of_law->AreaOfLaw}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Subsidiary Legislation
                                        </label>
                                        <textarea name="SubsidiaryLegislation" rows="5" placeholder=""></textarea>
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <button class="btn btn-white" type="reset">Cancel</button>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 1 of 3</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepTwo">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel" aria-labelledby="wizardTabTwo">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Next, add a Part Header</h1>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Part Title
                                        </label>
                                        {{-- <input type="hidden" name="LawId"> --}}
                                        <input type="text" name="PartHeader" class="form-control">
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <a class="btn btn-white" data-toggle="wizard" href="#wizardStepOne">Back</a>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 2 of 3</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepThree">Next <i class="mdi mdi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wizardStepThree" role="tabpanel" aria-labelledby="wizardTabThree">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Now create Section</h1>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Section Header
                                        </label>
                                        <input type="hidden" name="LawId">
                                        <input type="hidden" name="PartId">
                                        <input type="text" name="SectionHeader" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Section Body
                                        </label>
                                        <textarea name="SectionBody" rows="5"></textarea>
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <a class="btn btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 3 of 3</h6>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                                <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
