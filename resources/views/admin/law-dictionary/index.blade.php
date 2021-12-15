@extends('layouts.admin')

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
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add Words
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
                <div class="card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title">Words</h4>
                        <ul class="list-pagination pagination pagination-tabs card-pagination">
                            <li class="page-item">
                                <a class="page-link ps-4 pe-0" href="#!">
                                    Showing {{ $words->firstItem() }}–{{ $words->lastItem() }} of {{ $words->total() }} results
                                </a>
                            </li>
                        </ul>
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
                                                    <h4 class="mb-1 name">
                                                        <span class="recent-link">
                                                            <span class="mr-2 text-color">{{Str::limit($word->title, 1, '')}}</span>{{$word->title}}
                                                        </span>
                                                        <div class="">
                                                            <div class="collapse multi-collapse" id="multiCollapse{{$word->id}}">
                                                                <div class="mt-2 p-3">{!! $word->content !!}</div>
                                                            </div>
                                                        </div>
                                                    </h4>
                                                </a>
                                            </div>
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
                    <div class="card-footer d-flex justify-content-center">
                        <div class="m-2">
                            {{$words->links()}}
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
                                        {{-- <small class="form-text text-muted">
                                            This is the body of the maxim
                                        </small> --}}
                                        <textarea name="content" rows="5" placeholder="Enter content"></textarea>
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
