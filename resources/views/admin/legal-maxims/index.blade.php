@extends('layouts.admin')

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
                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                            <i class="fe fe-plus"></i> Add Maxims
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
                    <h4 class="card-header-title">Maxims</h4>
                    <ul class="list-pagination pagination pagination-tabs card-pagination">
                        <li class="page-item">
                            <a class="page-link ps-4 pe-0" href="#!">
                                Showing {{ $maxims->firstItem() }}–{{ $maxims->lastItem() }} of {{ $maxims->total() }} results
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
                    @if($maxims)
                        <ul id="table_data" class="list-group table_data list-group-lg list-group-flush list my-n4">
                            @foreach($maxims as $maxim)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <a data-toggle="collapse" href="#multiCollapse{{$maxim->id}}" role="button" aria-expanded="false" aria-controls="multiCollapse{{$maxim->id}}">
                                                <h4 class="mb-1 name">
                                                    <span class="mr-2 text-color">{{Str::limit($maxim->title, 1, '')}}</span><span class="text-gray">{{$maxim->title}}</span>
                                                    <div class="">
                                                        <div class="collapse multi-collapse" id="multiCollapse{{$maxim->id}}">
                                                            <div class="mt-2 p-3">{!! $maxim->content !!}</div>
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
                        {{$maxims->links()}}
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
                                            Maxim Title
                                        </label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Maxim Version No.
                                        </label>
                                        <input type="number" name="version_no" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Maxim Content
                                        </label>
                                        <small class="form-text text-muted">
                                            This is the body of the maxim
                                        </small>
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
