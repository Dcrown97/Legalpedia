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
                    <div class="col-auto">
                        <a href="#" class="btn text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button">
                            <i class="fe fe-plus"></i> Add Forms
                        </a>
                        <a href="#" class="custom-button text-color ml-3" style="border-bottom: 1px dotted !important" data-bs-toggle="modal" data-bs-target="#send_report" id="kt_toolbar_primary_button">
                            <i class="fe fe-info"></i> Send a report?
                        </a>
                    </div>
                    @include('elements.notifications')
                </div>
                @if(Auth::user()->role->name == 'Admin')
                    <div class="row align-items-end justify-content-end mt-4 p-3">
                        <form action="{{route('admin.forms')}}" method="GET" class="me-3 d-flex">
                            <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}" {{ $category->category == $selected_category['category'] ? 'selected' : '' }}>{{$category->category}}</option>
                                @endforeach
                            </select>
                            <button type="submit" name="fetch_form" onclick="this.classList.toggle('button--loading')" class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                                <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                            </button>
                            <a href="{{url('admin/forms-and-precedents')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                            </a>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <a href="{{url('admin/forms-and-precedents')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                            </a>
                        </div>
                    </div>
                    @else
                    @if($categories->form_cat)
                        <div class="row align-items-end justify-content-end mt-4 p-3">
                            <form action="{{route('admin.forms')}}" method="GET" class="me-3 d-flex">
                                @php
                                    $all_categories = json_decode($categories->form_cat);
                                @endphp
                                <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                    @foreach($all_categories as $category)
                                        @php
                                            $main_category = App\Models\Category::where('category', $category)->first();
                                        @endphp
                                        <option value="{{$main_category->category}}" {{ $main_category->category == $selected_category['category'] ? 'selected' : '' }}>{{$main_category->category}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" name="fetch_form" onclick="this.classList.toggle('button--loading')" class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                                    <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                </button>
                                <a href="{{url('admin/forms-and-precedents')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                                    <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                </a>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <a href="{{url('admin/forms-and-precedents')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                                    <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="container-fluid mt-51">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="legal-tab" data-toggle="tab" href="#legal" role="tab" aria-controls="legal" aria-selected="true">
                            Legalpedia Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="public-tab" data-toggle="tab" href="#public" role="tab" aria-controls="public" aria-selected="false">
                            Public Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="my-tab" data-toggle="tab" href="#my" role="tab" aria-controls="my" aria-selected="false">
                            My Forms
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
                    <div class="tab-pane fade show active" id="legal" role="tabpanel" aria-labelledby="legal-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Forms</h4>
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
                                        <h4>{{number_format($form_count)}} records</h4>
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
                    <div class="tab-pane fade" id="public" role="tabpanel" aria-labelledby="public-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Public Forms</h4>
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
                                        <h4>{{number_format($public_form_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($public_forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($public_forms as $form)
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
                    <div class="tab-pane fade" id="my" role="tabpanel" aria-labelledby="my-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">My Forms</h4>
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
                                    {{-- <div class="col-auto me-n3">
                                        <h4>{{number_format($my_form_count)}} records</h4>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($my_forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($my_forms as $form)
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
                                                    @if($form->user_id == Auth::user()->id)
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
        </div>
    </div>

    @if(Auth::user()->role->name == 'Admin')
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
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                            <input type="text" name="title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Content
                                            </label>
                                            <textarea name="content" rows="5" class="form-control" placeholder="Enter content"></textarea>
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
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Author
                                            </label>
                                            @if(Auth::user()->role->name == 'Admin')
                                                <input type="text" name="author" class="form-control" value="Legalpedia" readonly>
                                                @else
                                                <input type="text" name="author" class="form-control" value="{{Auth::user()->name}}" readonly>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Make Form public or private
                                            </label>
                                            @if(Auth::user()->role->name == 'Admin')
                                                <input type="hidden" name="form_type" value="legalpedia">
                                                @else
                                                <input type="hidden" name="form_type" value="user">
                                            @endif
                                            <select name="display_type" class="form-select">
                                                <option value="Public">Make Public</option>
                                                <option value="Private">Keep Private</option>
                                            </select>
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
        @else
        @if($categories->form_cat)
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
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                <input type="text" name="title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Content
                                                </label>
                                                <textarea name="content" rows="5" class="form-control" placeholder="Enter content"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $all_categories = json_decode($categories->form_cat);
                                                @endphp
                                                <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($all_categories as $category)
                                                        @php
                                                            $main_category = App\Models\Category::where('category', $category)->first();
                                                        @endphp
                                                        <option value="{{$main_category->category}}">{{$main_category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Author
                                                </label>
                                                @if(Auth::user()->role->name == 'Admin')
                                                    <input type="text" name="author" class="form-control" value="Legalpedia" readonly>
                                                    @else
                                                    <input type="text" name="author" class="form-control" value="{{Auth::user()->name}}" readonly>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Make Form public or private
                                                </label>
                                                @if(Auth::user()->role->name == 'Admin')
                                                    <input type="hidden" name="form_type" value="legalpedia">
                                                    @else
                                                    <input type="hidden" name="form_type" value="user">
                                                @endif
                                                <select name="display_type" class="form-select">
                                                    <option value="Public">Make Public</option>
                                                    <option value="Private">Keep Private</option>
                                                </select>
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
        @endif
    @endif
    <script>
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this precedent?"))
            event.preventDefault();
        }
    </script>
@endsection
