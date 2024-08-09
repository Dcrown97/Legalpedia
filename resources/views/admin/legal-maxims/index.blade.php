@extends('layouts.admin.legal-maxims')

@section('title')
    <title>Legal Maxims - Legalpedia</title>
@endsection

@section('content')
    <style>
        .hidden {
            display: none;
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
                            Legal Maxims
                        </h1>
                    </div>
                    <div class="col-auto">
                        @if(Auth::user()->role->name == 'Admin')
                            <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Maxims
                            </a>
                        @endif
                        <a href="#" class="custom-button text-color ml-3" style="border-bottom: 1px dotted !important" data-bs-toggle="modal" data-bs-target="#send_report" id="kt_toolbar_primary_button">
                            <i class="fe fe-info"></i> Send a report?
                        </a>
                    </div>
                    @include('elements.notifications')
                </div>
                @if(Auth::user()->role->name == 'Admin')
                    <div class="row align-items-end justify-content-end mt-4 p-3">
                        <form action="{{route('admin.legal-maxims')}}" method="GET" class="me-3 d-flex">
                            <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{ $category->category == $selected_category['category'] ? 'selected' : '' }}>{{$category->category}}</option>
                                @endforeach
                            </select>
                            <button type="submit" name="fetch_category" onclick="this.classList.toggle('button--loading')" class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                                <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                            </button>
                            <a href="{{url('admin/legal-maxims')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                            </a>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <a href="{{url('admin/legal-maxims')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                            </a>
                        </div>
                    </div>
                    @else
                    @if($categories->maxim_cat)
                        <div class="row align-items-end justify-content-end mt-4 p-3">
                            <form action="{{route('admin.legal-maxims')}}" method="GET" class="me-3 d-flex">
                                @php
                                    $all_categories = json_decode($categories->maxim_cat);
                                @endphp
                                <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                    @foreach($all_categories as $category)
                                        @php
                                            $main_category = App\Models\Category::where('category', $category)->first();
                                        @endphp
                                        <option value="{{$main_category->category}}" {{ $main_category->category == $selected_category['category'] ? 'selected' : '' }}>{{$main_category->category}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" name="fetch_category" onclick="this.classList.toggle('button--loading')" class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                                    <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                </button>
                                <a href="{{url('admin/legal-maxims')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                                    <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                </a>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <a href="{{url('admin/legal-maxims')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
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
                <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                    <div class="card-header">
                        <h4 class="card-header-title">Maxims</h4>
                    <h4>{{number_format($maxim_count)}} records</h4>
                    </div>
                    <div class="card-header">
                        <form>
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                            <input class="form-control list-search" type="search" placeholder="Search maxims">
                            <div class="input-group-text">
                                <span class="fe fe-search"></span>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card-body">
                        @if(count($maxims) > 0)
                            <ul id="table_data" class="list-group table_data list-group-lg list-group-flush list my-n4">
                                @foreach($maxims as $maxim)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a data-toggle="collapse" href="#multiCollapse{{$maxim->id}}" role="button" aria-expanded="false" aria-controls="multiCollapse{{$maxim->id}}">
                                                    <h4 class="mb-1 item-name">
                                                        <span class="mr-2 text-color">{{Str::limit($maxim->title, 1, '')}}</span><span class="text-gray">{{$maxim->title}}</span>
                                                    </h4>
                                                </a>
                                                <div class="">
                                                    <div class="collapse multi-collapse" id="multiCollapse{{$maxim->id}}">
                                                        <div class="mt-2 p-3" style="line-height: 25px; font-weight: 400">
                                                            <p>{!! $maxim->content !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(Auth::user()->role->name == 'Admin')
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{route('edit.maxim', $maxim->id)}}" class="dropdown-item">
                                                                <i class="mdi mdi-pencil mr-2"></i> Edit
                                                            </a>
                                                            <form action="/admin/legal-maxims/{{$maxim->id}}" method="POST">
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
                                <h3 class="text-muted"><i class="fe fe-file"></i> No records found</h3>
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
    @if(Auth::user()->role->name == 'Admin')
        <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen p-9">
                <div class="modal-content rounded">
                    <div class="modal-header">
                        <div class="fs-1 fw-boldest">Add new Maxim</div>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-2x">
                                <i class="mdi mdi-close"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y m-5">
                        <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                            <div class="container">
                                <div class="stepper-nav justify-content-center">
                                    <form action="{{route('store.maxim')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Maxim
                                            </label>
                                            <input type="text" name="title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Meaning
                                            </label>
                                            <textarea name="content" id="summernote" rows="5" class="form-control" placeholder="Enter content"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Category
                                            </label>
                                            <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->category}}">{{$category->category}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="form-label mb-1">
                                                Area of Law
                                            </label>
                                            <textarea name="area_of_law" class="form-control" placeholder="Enter area(s) of law"></textarea>
                                        </div> --}}
                                        <div class="form-group">
                                            <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                                <span class="button__text"><i class="mdi mdi-plus"></i> Add</span>
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
    @endif
    <script>

         $(function() {

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

        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this maxim?"))
            event.preventDefault();
        }

        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_maxim(page);
            });

            function fetch_maxim(page) {
                $.ajax({
                    url: "/admin/legal-maxims/p?page=" + page,
                    success: function(maxims) {
                        $('#table_data').html(maxims);
                    }
                });
            }
        });
    </script>
@endsection
