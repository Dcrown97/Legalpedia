@extends('layouts.admin.judgements')

@section('title')
    <title>Subject Matter Index - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }

        .modal-content {
            height: 300px !important;
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
                            Subject Matter Index
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-5 col-xl-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">Add new Subject Matter Index</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('store.sbj')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Subject Matter Index
                                </label>
                                <input type="text" name="subject_matter_index" class="form-control">
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
            <div class="col-12 col-lg-7 col-xl-7">
                <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                    <div class="card-header">
                        <h4>All Subject Matter Indices</h4>
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
                                <h4>{{number_format($subject_count)}} records</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($subject_matter_indices)
                            <ul class="list-group list-group-lg list-group-flush list my-n4">
                                @foreach($subject_matter_indices as $subject_matter_index)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h4 class="mb-1 item-name">
                                                    <i class="fe fe-file mr-3"></i>{{$subject_matter_index->subject_matter_index}}
                                                </h4>
                                            </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a style="cursor: pointer" data-bs-toggle="modal" onclick="showEditSubjectModal('{{$subject_matter_index->subject_matter_index}}', '{{$subject_matter_index->id}}')" class="dropdown-item">
                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                    </a>
                                                    <form action="/admin/judgements/subject-matter-index/{{$subject_matter_index->id}}" method="POST">
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
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Edit Subject Matter Index</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y">
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <div class="container">
                            <div class="stepper-nav justify-content-center">
                            <form action="{{route('update.sbj')}}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('patch') }}
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Subject Matter Index
                                        </label>
                                        <input type="hidden" name="subject_id" id="subject-id" class="form-control">
                                        <input type="text" name="subject_matter_index" id="subject-input" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                            <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
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
            if(!confirm("Are you sure you want to delete this court?"))
            event.preventDefault();
        }
        function showEditSubjectModal(subject, id){

            document.getElementById("subject-input").value = subject;
            document.getElementById("subject-id").value = id;
            $('#editSubjectModal').modal('show')

        }

    </script>
@endsection
