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
                    <div class="col-auto">
                        @if (Auth::user()->role->name == 'Admin')
                            <a href="#" class="btn text-white btn-primary text0-white" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button"
                                class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Laws
                            </a>
                        @endif
                        <a href="#" class="custom-button text-color ml-3" style="border-bottom: 1px dotted !important"
                            data-bs-toggle="modal" data-bs-target="#send_report" id="kt_toolbar_primary_button">
                            <i class="fe fe-info"></i> Send a report?
                        </a>
                    </div>
                    @include('elements.notifications')
                </div>
                @if (Auth::user()->role->name == 'Admin')
                    <div class="row align-items-end justify-content-end mt-4 p-3">
                        <form action="{{ route('admin.laws-of-federation') }}" method="GET" class="me-3 d-flex">
                            <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category }}"
                                        {{ $category->category == $selected_category['category'] ? 'selected' : '' }}>
                                        {{ $category->category }}</option>
                                @endforeach
                            </select>
                            <button type="submit" name="fetch_fed" onclick="this.classList.toggle('button--loading')"
                                class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                                <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                            </button>
                            <a href="{{ url('admin/laws-of-federation') }}"
                                onclick="this.classList.toggle('button--loading')"
                                class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                            </a>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <a href="{{ url('admin/laws-of-federation') }}"
                                onclick="this.classList.toggle('button--loading')"
                                class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                            </a>
                        </div>
                    </div>
                @else
                    @if ($categories->lfn_cat)
                        <div class="row align-items-end justify-content-end mt-4 p-3">
                            <form action="{{ route('admin.laws-of-federation') }}" method="GET" class="me-3 d-flex">
                                @php
                                    $all_categories = json_decode($categories->lfn_cat);
                                @endphp
                                <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                    @foreach ($all_categories as $category)
                                        @php
                                            $main_category = App\Models\Category::where('category', $category)->first();
                                        @endphp
                                        <option value="{{ $main_category->category }}"
                                            {{ $main_category->category == $selected_category['category'] ? 'selected' : '' }}>
                                            {{ $main_category->category }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" name="fetch_fed" onclick="this.classList.toggle('button--loading')"
                                    class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                                    <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                </button>
                                <a href="{{ url('admin/laws-of-federation') }}"
                                    onclick="this.classList.toggle('button--loading')"
                                    class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                                    <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                </a>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <a href="{{ url('admin/laws-of-federation') }}"
                                    onclick="this.classList.toggle('button--loading')"
                                    class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                                    <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card"
                    data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                    id="contactsList">
                    <div class="card-header">
                        <h4 class="card-header-title">Laws</h4>
                    </div>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <form>
                                    <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                        <input class="form-control list-search" type="search" placeholder="Search titles">
                                        <span class="input-group-text">
                                            <i class="fe fe-search"></i>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto me-n3">
                                <h4>{{ $fed_count }} records</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($feds) > 0)
                            <ul class="list-group list-group-lg list-group-flush list my-n4" id="fed_data">
                                @foreach ($feds as $fed)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{ route('show.fed', $fed->id) }}"
                                                    class="avatar text-color avatar-lg">
                                                    <img src="{{ asset('assets/images/nigerian-coat-of-arms.png') }}"
                                                        alt="{{ $fed->title }}" class="card-img-top">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <a href="{{ route('show.fed', $fed->id) }}">{{ $fed->title }}</a>
                                                </h4>
                                                <p class="card-text text-muted small mb-1">Category: <span
                                                        class="text-color">{{ $fed->category }}</span></p>
                                                <p class="card-text text-muted small mb-1">Law no: <span
                                                        class="text-color">{{ $fed->law_no }}</span></p>
                                            </div>
                                            @if (Auth::user()->role->name == 'Admin')
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-ellipses dropdown-toggle"
                                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('edit.fed', $fed->id) }}"
                                                                class="dropdown-item">
                                                                <i class="mdi mdi-pencil mr-2"></i> Edit
                                                            </a>
                                                            <form action="/admin/laws-of-federation/{{ $fed->id }}"
                                                                method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit" name="submit"
                                                                    onclick="return deleteFunction();"
                                                                    class="dropdown-item">
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
    @if (Auth::user()->role->name == 'Admin')
        <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-fullscreen p-9">
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
                                    <form class="tab-content pb-4" id="wizardSteps" action="{{ route('store.fed') }}"
                                        method="POST">
                                        @csrf
                                        <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel"
                                            aria-labelledby="wizardTabOne">
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
                                                <textarea name="description" id="summernote" class="form-control" rows="5" placeholder="Enter description"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="category" class="form-select"
                                                    data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->category }}">
                                                            {{ $category->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="form-group">
                                            <label class="form-label mb-1">
                                                Area of Law
                                            </label>
                                            <textarea name="area_of_law" class="form-control" rows="5" placeholder="Enter area(s) of Law"></textarea>
                                        </div> --}}
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Subsidiary Legislation
                                                </label>
                                                <textarea name="subsidiary_legislation" id="summernote1" class="form-control" rows="5" placeholder=""></textarea>
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
                                                    <a class="btn text-white btn-primary" data-toggle="wizard"
                                                        href="#wizardStepTwo">Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel"
                                            aria-labelledby="wizardTabTwo">
                                            <div class="row justify-content-center">
                                                <div class="text-center">
                                                    <h1 class="mb-3">Next, add Parts and Sections</h1>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    1. Part Title
                                                </label>
                                                <input type="text" name="part_header[0][]" class="form-control">
                                            </div>
                                            <hr class="my-5">
                                            <div class="add_more">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        1. Section Header
                                                    </label>
                                                    <input type="text" name="part_header[0][10][0][]"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Section Body
                                                    </label>
                                                    <textarea class="form-control" name="part_header[0][10][0][]" id="summernote3" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <hr class="my-5">
                                            <div id="add_field1"></div>
                                            <div class="justify-content-end">
                                                <a type="button" id="more_fields1" class="text-color"
                                                    onclick="addFields('add_field1')"><i class="mdi mdi-plus"></i> Add
                                                    Section</a>
                                            </div>
                                            <hr class="my-5">
                                            <div id="add_part"></div>
                                            <div class="justify-content-end mb-5">
                                                <a type="button" id="more_part" class="text-color"
                                                    onclick="addPart()"><i class="mdi mdi-plus"></i> Add Part</a>
                                            </div>
                                            <div class="nav row align-items-center">
                                                <div class="col-auto">
                                                    <a class="btn btn-white" data-toggle="wizard"
                                                        href="#wizardStepOne">Back</a>
                                                </div>
                                                <div class="col text-center">
                                                    <h6 class="text-uppercase text-muted mb-0">Step 2 of 3</h6>
                                                </div>
                                                <div class="col-auto">
                                                    <a class="btn text-white btn-primary" data-toggle="wizard"
                                                        href="#wizardStepThree">Next <i
                                                            class="mdi mdi-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="wizardStepThree" role="tabpanel"
                                            aria-labelledby="wizardTabThree">
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
                                                    <textarea class="form-control" name="sched[0][]" id="summernote2" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <hr class="my-5">
                                            <div id="add_sched"></div>
                                            <div class="justify-content-end mb-5">
                                                <a type="button" id="more_scheds" class="text-color"
                                                    onclick="addScheds()"><i class="mdi mdi-plus"></i> Add Schedule</a>
                                            </div>
                                            <div class="nav row align-items-center">
                                                <div class="col-auto">
                                                    <a class="btn btn-white" data-toggle="wizard"
                                                        href="#wizardStepTwo">Back</a>
                                                </div>
                                                <div class="col text-center">
                                                    <h6 class="text-uppercase text-muted mb-0">Step 3 of 3</h6>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" name="submit"
                                                        onclick="this.classList.toggle('button--loading')"
                                                        class="button_load btn btn-primary text-white">
                                                        <span class="button__text"><i class="mdi mdi-plus"></i>
                                                            Create</span>
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
    @endif

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function initMCEall() {
            tinymce.init({
                mode: "textareas",
                plugins: 'autolink lists link image'
            });
        }

        $(function() {
            // Summernote

            // Summernote initialization
            const summernoteIds = [
                '#summernote', '#summernote1', '#summernote2', '#summernote3',
                '#summernote4', '#summernote5', '#summernote6', '#summernote7',
                '#summernote8', '#summernote9', '#summernote0', '#summernote11'
            ];

            summernoteIds.forEach(id => {
                $(id).summernote({
                    // placeholder: 'Enter description here...',
                    tabsize: 2,
                    height: 200,
                    width: 650,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ],
                    popover: {
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']]
                        ]
                    }
                });
            });
        })

        var section_no = 0;
        var section_number = 1;
        var secSummernote = 3;

        // Function to initialize Summernote on a specific element
        function initSummernoteOnElement(elementId) {
            $('#' + elementId).summernote({
                tabsize: 2,
                height: 200,
                width: 650,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                ],
                popover: {
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                }
            });
        }

        // Initialize the first Summernote
        initSummernoteOnElement('summernote3');

        function addFields(addField) {
            section_no++; // section array
            section_number++; // section numbering
            no = 0; // part array
            secSummernote++;
            var newSecTextAreaId = 'summernote' + secSummernote;
            console.log(newSecTextAreaId, 'first')
            var objTo = document.getElementById(addField)
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + section_number +
                '. Section Header</label><input type="text" name="part_header[' + no + '][10][' + section_no +
                '][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="part_header[' +
                no + '][10][' + section_no + '][]" rows="5" id="' + newSecTextAreaId +
                '"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initSummernoteOnElement(newSecTextAreaId);
            initMCEall();
        }

        // Function to initialize Summernote on a specific element
        function initSummernoteOnElement(elementId) {
            $('#' + elementId).summernote({
                 tabsize: 2,
                    height: 200,
                    width: 650,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ],
                    popover: {
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']]
                        ]
                    }
            });
        }

        // Initialize the first Summernote
        initSummernoteOnElement('summernote101');

        function addPart() {
            part_no++;
            newPartSummernote++;
            var newPartTextAreaId = 'summernote' + newPartSummernote;
            var objTo = document.getElementById('add_part')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + part_no +
                '. Part Title</label><input type="text" name="part_header[' + part_no +
                '][]" class="form-control"></div><hr class="my-5"><div class="form-group"><label class="form-label mb-1">' +
                section_noss + '. Section Header</label><input type="text" name="part_header[' + part_no + '][10][' +
                section_nos +
                '][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="part_header[' +
                part_no + '][10][' + section_nos + '][]" rows="5" id="' + newPartTextAreaId +
                '"></textarea></div><hr class="my-5"><div id="add_field' +
                part_no + '"></div><input type="hidden" id="secton-no' + part_no + '" value="' + section_noss +
                '"><input type="hidden" id="secton-id' + part_no + '" value="' + section_nos +
                '"><div class="justify-content-end"><a type="button" id="more_fields' + part_no +
                '" class="text-color" onclick="addFieldss(`add_field' + part_no + '`, `secton-id' + part_no + '`, `' +
            part_no + '`, `secton-no' + part_no +
            '`)"><i class="mdi mdi-plus"></i>Add Section</a></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initSummernoteOnElement(newPartTextAreaId);
            initMCEall();
        }

        function initSummernoteOnElement(elementId) {
            $('#' + elementId).summernote({
                tabsize: 2,
                    height: 200,
                    width: 650,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ],
                    popover: {
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']]
                        ]
                    }
            });
        }

        // Initialize the first Summernote
        initSummernoteOnElement('summernote151');

        function addFieldss(addField, section_id, partNo, section_no) {
            sectionId = document.getElementById(section_id).value;
            sectionNo = document.getElementById(section_no).value;
            sectionId++;
            sectionNo++;
            document.getElementById(section_id).value = sectionId;
            document.getElementById(section_no).value = sectionNo;
            newPartSecSummernote++;
            var newPartSecTextAreaId = 'summernote' + newPartSecSummernote;
            var objTo = document.getElementById(addField)
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + sectionNo +
                '. Section Header</label><input type="text" name="part_header[' + partNo + '][10][' + sectionId +
                '][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="part_header[' +
                partNo + '][10][' + sectionId + '][]" rows="5" id="' + newPartSecTextAreaId +
                '"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initSummernoteOnElement(newPartSecTextAreaId);
            initMCEall();
        }

        function initSummernoteOnElement(elementId) {
            $('#' + elementId).summernote({
                tabsize: 2,
                    height: 200,
                    width: 650,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ],
                    popover: {
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']]
                        ]
                    }
            });
        }

        // Initialize the first Summernote
        initSummernoteOnElement('summernote2');

        function addScheds() {
            sched_no++;
            newSchedsSummernote++;
            var newSchedsTextAreaId = 'summernote' + newSchedsSummernote;
            var objTo = document.getElementById('add_sched')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + sched_no +
                '. Schedule Header</label><input type="text" name="sched[' + sched_no +
                '][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Schedule Body</label> <textarea class="form-control" name="sched[' +
                sched_no + '][]" rows="5" id="' + newSchedsTextAreaId + '"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initSummernoteOnElement(newSchedsTextAreaId);
            initMCEall();
        }

        function deleteFunction() {
            if (!confirm("Are you sure you want to delete this law of federation?"))
                event.preventDefault();

        }
    </script>
@endsection
