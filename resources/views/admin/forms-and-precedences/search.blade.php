@extends('layouts.admin.forms-and-precedences')

@section('title')
    <title>Search results - Legalpedia</title>
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
                        <a href="{{url('admin/forms-and-precedences')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Search results for Forms and Precedences
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        @if($forms->isNotEmpty())
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
                                                <h4 class="mb-1 name">
                                                    <a href="{{route('show.form', $form->id)}}">{{$form->title}}</a>
                                                </h4>
                                                <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$form->category}}</span></p>
                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fe fe-more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="{{route('edit.form', $form->id)}}" class="dropdown-item">
                                                            <i class="mdi mdi-pencil mr-2"></i> Edit
                                                        </a>
                                                        <form action="/admin/forms-and-precedences/{{$form->id}}" method="POST">
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
