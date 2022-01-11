@extends('layouts.admin.laws-of-federation')

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
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="#" class="btn text-white btn-primary text0-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Laws
                            </a>
                        </div>
                    @endif
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
                        <form action="{{route('admin.laws-of-federation')}}" method="GET" class="me-3 d-flex">
                            <select name="category" class="form-select form-control-flush mr-8" data-choices='{"searchEnabled": true}'>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{ $category->category == $selected_category['category'] ? 'selected' : '' }}>{{$category->category}}</option>
                                @endforeach
                            </select>
                            <button type="submit" name="fetch_fed" onclick="this.classList.toggle('button--loading')" class="btn ml-3 button_load text-white btn-sm btn-primary p-2">
                                <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                            </button>
                        </form>
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
                        @if(count($feds) > 0)
                            <ul class="list-group list-group-lg list-group-flush list my-n4"  id="fed_data">
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
                                                    <a href="{{route('show.fed', $fed->id)}}">{{$fed->title}}</a>
                                                </h4>
                                                <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$fed->category}}</span></p>
                                                <p class="card-text text-muted small mb-1">Law no: <span class="text-color">{{$fed->law_no}}</span></p>
                                            </div>
                                            @if(Auth::user()->role->name == 'Admin')
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
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="text-center">
                                <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
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
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Law No.
                                                </label>
                                                <input type="text" name="law_no" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Law Date.
                                                </label>
                                                <input type="date" name="law_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Description
                                        </label>
                                        <textarea name="description" class="form-control" rows="5" placeholder="Enter description"></textarea>
                                    </div>
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
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Area of Law
                                        </label>
                                        <textarea name="area_of_law" class="form-control" rows="5" placeholder="Enter area(s) of Law"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Subsidiary Legislation
                                        </label>
                                        <textarea name="subsidiary_legislation" class="form-control" rows="5" placeholder=""></textarea>
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
                                        <input type="hidden" name="law_of_federation_id">
                                        <input type="hidden" name="law_of_fed_part_id">
                                        <input type="text" name="part_header" class="form-control">
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
                                    <div class="add_more">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                1. Section Header
                                            </label>
                                            <input type="text" name="section[0][]" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Section Body
                                            </label>
                                            <textarea class="form-control" name="section[0][]" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <hr class="my-5">
                                    <div id="add_field"></div>
                                    <div class="justify-content-end">
                                        <a type="button" id="more_fields" class="text-color" onclick="addFields()"><i class="mdi mdi-plus"></i> Add Section</a>
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <a class="btn btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 3 of 4</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepFour">Next <i class="mdi mdi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wizardStepFour" role="tabpanel" aria-labelledby="wizardTabFour">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Add Schedule</h1>
                                        </div>
                                    </div>
                                    <div class="add_more">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                1. Schedule Header
                                            </label>
                                            <input type="text" name="sched[0][]" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Schedule Body
                                            </label>
                                            <textarea class="form-control" name="sched[0][]" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <hr class="my-5">
                                    <div id="add_sched"></div>
                                    <div class="justify-content-end">
                                        <a type="button" id="more_scheds" class="text-color" onclick="addScheds()"><i class="mdi mdi-plus"></i> Add Schedule</a>
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <a class="btn btn-white" data-toggle="wizard" href="#wizardStepThree">Back</a>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 4 of 4</h6>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                                <span class="button__text"><i class="mdi mdi-plus"></i> Create</span>
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
    <script>
        var section_no = 1;
        function addFields() {
            section_no++;
            var objTo = document.getElementById('add_field')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + section_no +
            '. Section Header</label><input type="text" name="section['+ section_no +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="section['+ section_no +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
        }

        var sched_no = 1;
        function addScheds() {
            sched_no++;
            var objTo = document.getElementById('add_sched')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + sched_no +
            '. Schedule Header</label><input type="text" name="sched['+ sched_no +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Schedule Body</label> <textarea class="form-control" name="sched['+ sched_no +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
        }

        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this law of federation?"))
            event.preventDefault();

        }
    </script>
@endsection

