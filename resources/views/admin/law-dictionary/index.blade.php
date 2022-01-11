@extends('layouts.admin.law-dictionary')

@section('title')
    <title>Law Dictionary - Legalpedia</title>
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
                            Law Dictionary
                        </h1>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Words
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
                        <h4 class="card-header-title">Words</h4>
                        <h4>{{$word_count}} records</h4>
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
                        @if($words)
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                @foreach($words as $word)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a data-toggle="collapse" href="#multiCollapse{{$word->id}}" role="button" aria-expanded="false" aria-controls="multiCollapse{{$word->id}}">
                                                    <h4 class="mb-1 item-name">
                                                        <span class="recent-link">
                                                            <span class="mr-2 text-color">{{Str::limit($word->title, 1, '')}}</span>{{$word->title}}
                                                        </span>
                                                    </h4>
                                                </a>
                                                <div class="">
                                                    <div class="collapse multi-collapse" id="multiCollapse{{$word->id}}">
                                                        <div class="mt-2 p-3" style="line-height: 25px; font-weight: 400">
                                                            <p>{!! $word->content !!}</p>
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
                                                            <a href="{{route('edit.dictionary', $word->id)}}" class="dropdown-item">
                                                                <i class="mdi mdi-pencil mr-2"></i> Edit
                                                            </a>
                                                            <form action="/admin/law-dictionary/{{$word->id}}" method="POST">
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
                    <div class="fs-1 fw-boldest">Add new Word</div>
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
                                <form action="{{route('store.dictionary')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Word
                                        </label>
                                        <input type="text" name="title" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Meaning
                                        </label>
                                        <textarea name="content" rows="5" class="form-control" placeholder="Enter content"></textarea>
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
                                        <textarea name="area_of_law" class="form-control" rows="5" placeholder="Enter area(s) of law"></textarea>
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
            if(!confirm("Are you sure you want to delete this maxim?"))
            event.preventDefault();
        }
    </script>
@endsection
