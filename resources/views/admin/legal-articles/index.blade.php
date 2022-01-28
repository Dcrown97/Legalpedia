@extends('layouts.admin.legal-articles')

@section('title')
    <title>Legal Articles - Legalpedia</title>
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
                            Legal Articles
                        </h1>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add Article
                        </a>
                    </div>
                    @include('elements.notifications')
                </div>
                <div class="row align-items-end justify-content-end mt-4 p-3">
                    <form action="{{route('admin.articles')}}" method="GET" class="me-3 d-flex">
                        <select name="category" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                            @foreach($categories as $category)
                                <option value="{{$category->category}}" {{ $category->category == $selected_category['category'] ? 'selected' : '' }}>{{$category->category}}</option>
                            @endforeach
                        </select>
                        <button type="submit" name="fetch_category" onclick="this.classList.toggle('button--loading')" class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                            <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                        </button>
                        <a href="{{url('admin/legal-articles')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                            <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                        </a>
                    </form>
                </div>
                <div class="row">
                    <div class="col-3">
                        <a href="{{url('admin/legal-articles')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                            <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                        </a>
                    </div>
                </div>
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
                            Legalpedia Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">
                            Public Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="my-tab" data-toggle="tab" href="#my" role="tab" aria-controls="my" aria-selected="false">
                            My Articles
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
                                <h4 class="card-header-title">Legalpedia Articles</h4>
                                <h4>{{number_format($article_count)}} records</h4>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search titles">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                @if(count($articles) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($articles as $article)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-3"></i><a href="{{route('show.article', $article->id)}}">{{$article->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.article', $article->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/legal-articles/{{$article->id}}" method="POST">
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
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLists">
                            <div class="card-header">
                                <h4 class="card-header-title">Public Articles</h4>
                                <h4>{{number_format($public_article_count)}} records</h4>
                            </div>
                            <div class="card-header">
                                <form>
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search titles">
                                    <div class="input-group-text">
                                    <span class="fe fe-search"></span>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-body">
                                @if(count($public_articles) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($public_articles as $article)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-3"></i><a href="{{route('show.article', $article->id)}}">{{$article->title}}</a>
                                                        </h4>
                                                    </div>
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
                    <div class="tab-pane fade" id="my" role="tabpanel" aria-labelledby="my-tab">
                        <div data-list='{"valueNames": ["name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLis">
                            <div class="" data-list='{"valueNames": ["name"], "listClass": "listAlias", "page": 12, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                                <div class="row mb-4">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-lg input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="text" placeholder="Search articles" style="height: 50px">
                                                <div class="input-group-text">
                                                    <span class="fe fe-search"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row list">
                                    @if(count($my_articles) > 0)
                                        @foreach ($my_articles as $article)
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{route('show.article', $article->id)}}" class="avatar avatar-lg avatar-4by3">
                                                                    <img src="{{$article->photo}}" alt="{{$article->title}}" class="avatar-img rounded">
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1 name">
                                                                    <a href="{{route('show.article', $article->id)}}">{{$article->title}}</a>
                                                                </h4>
                                                                <p class="card-text small text-muted">
                                                                    Created {{\Carbon\Carbon::parse($article->created_at)->toFormattedDateString()}}
                                                                </p>
                                                            </div>
                                                            @if(Auth::user()->id == $article->user_id)
                                                                <div class="col-auto">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fe fe-more-vertical"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <a href="{{route('edit.article', $article->id)}}" class="dropdown-item">
                                                                                <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                            </a>
                                                                            <form action="/admin/legal-articles/{{$article->id}}" method="POST">
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
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @else
                                        <div class="text-center mt-8 mb-8">
                                            <h3 class="text-muted"><i class="fe fe-users"></i> You have no articles</h3>
                                            <div class="col-auto mt-2">
                                                <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                                    <i class="fe fe-plus"></i> Create article
                                                </a>
                                            </div>
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
    </div>
    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Add new Article</div>
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
                                <form action="{{route('store.article')}}" method="POST" enctype="multipart/form-data">
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
                                            Description
                                        </label>
                                        <textarea class="description form-control" name="description" rows="5" placeholder="Enter content"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Content
                                        </label>
                                        <small class="form-text text-muted">
                                            This is the body of the article
                                        </small>
                                        <textarea class="description form-control" name="content" rows="5" placeholder="Enter content"></textarea>
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
                                        <textarea class="description form-control" name="area_of_law" rows="5" placeholder="Enter area(s) of Law"></textarea>
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Author
                                        </label>
                                        @if(Auth::user()->role->name == 'Admin')
                                            <input type="text" name="authur" class="form-control" value="Legalpedia" readonly>
                                            @else
                                            <input type="text" name="authur" class="form-control" value="{{Auth::user()->name}}" readonly>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            References
                                        </label>
                                        <textarea class="description form-control" name="references" rows="5" placeholder="References"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Cover image
                                        </label>
                                        <label for="actual-btn" style="cursor: pointer" class="w-100 p-6 w-full text-center px-4 py-6 bg-white rounded-md border border-blue cursor-pointer hover:bg-purple-600 dark:bg-gray-700 hover:text-white text-gray-600 dark:text-gray-200 ease-linear transition-all duration-150">
                                            <i class="mdi mdi-cloud-upload icon-size"></i>
                                            <span class="mt-2 text-base text-lg leading-normal">Select an image (1200 x 600p)</span>
                                            <input type="file" name="photo" id="actual-btn" class="hidden"><br>
                                            <h2 class="text-lg" id="file-chosen">No file chosen</h2>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Link
                                        </label>
                                        <input type="text" name="link" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Make article public or private
                                        </label>
                                        @if(Auth::user()->role->name == 'Admin')
                                            <input type="hidden" name="article_type" value="legalpedia">
                                            @else
                                            <input type="hidden" name="article_type" value="user">
                                        @endif
                                        <select name="display_type" class="form-select">
                                            <option value="Public">Make Public</option>
                                            <option value="Private">Keep Private</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary w-100 text-white">
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
            if(!confirm("Are you sure you want to delete this article?"))
            event.preventDefault();
        }
        const actualBtn = document.getElementById('actual-btn');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function(){
            fileChosen.textContent = this.files[0].name
        })
    </script>
@endsection
