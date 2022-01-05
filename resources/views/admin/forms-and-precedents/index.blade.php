@extends('layouts.admin.forms-and-precedents')

@section('title')
    <title>Forms and Precedents - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }
        @media screen and (min-width: 280px) and (max-width: 767px) {
            .hide-mobile {
                display: none;
            }
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
                            Forms and Precedents
                        </h1>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="#" class="btn text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Forms
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
                        <h4 class="card-header-title">Forms</h4>
                        <form action="{{route('admin.forms')}}" method="GET" class="me-3 d-flex">
                            <select name="category" class="form-select form-control-flush mr-8" data-choices='{"searchEnabled": true}'>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{ $category->category == $selected_category['category'] ? 'selected' : '' }}>{{$category->category}}</option>
                                @endforeach
                            </select>
                            <button type="submit" name="fetch_form" onclick="this.classList.toggle('button--loading')" class="btn ml-3 button_load text-white btn-sm btn-primary p-2">
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
                                <h4>{{$form_count}} records</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($forms) > 0)
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                @foreach($forms as $form)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{route('show.form', $form->id)}}" class="avatar text-color avatar-lg">
                                                    <i class="fe fe-file"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <a href="{{route('show.form', $form->id)}}">{{$form->title}}</a>
                                                </h4>
                                                <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$form->category}}</span></p>
                                            </div>
                                            @if(Auth::user()->role->name == 'Admin')
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{route('edit.form', $form->id)}}" class="dropdown-item">
                                                                <i class="mdi mdi-pencil mr-2"></i> Edit
                                                            </a>
                                                            <form action="/admin/forms-and-precedents/{{$form->id}}" method="POST">
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
                    <div class="row g-0">
                        <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                            <li class="page-item">
                                <a class="page-link" href="#">
                                <i class="fe fe-arrow-left me-1"></i> Prev
                                </a>
                            </li>
                        </ul>
                        <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="fs-1 fw-boldest">Add new Form and Precedent</div>
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
                                <form action="{{route('store.form')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Title
                                        </label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Version No.
                                        </label>
                                        <input type="number" name="version_no" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Content
                                        </label>
                                        <textarea name="content" rows="5" placeholder="Enter content"></textarea>
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
                                        <select name="area_of_law" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                            <option value="">Select Area of Law</option>
                                            @foreach($area_of_laws as $area_of_law)
                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Author
                                        </label>
                                        <input type="text" name="author" class="form-control">
                                    </div>
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
    <script>
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this precedence?"))
            event.preventDefault();
        }
    </script>
@endsection
