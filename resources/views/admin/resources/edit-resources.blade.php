@extends('layouts.admin.resources')

@section('title')
    <title>{{ $resource->Title }} - Legalpedia</title>
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
                        <a href="{{ url('admin/resources') }}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i>
                            Back</a>
                        <h1 class="header-title">
                            {{ $resource->Title }}
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body p-5">
                        <form action="{{ route('update.resource', $resource->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Resource Title
                                </label>
                                <input type="text" name="title" class="form-control" value="{{ $resource->title }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Resource Link
                                </label>
                                <input type="text" name="url" class="form-control" value="{{ $resource->url }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Category
                                </label>
                                <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                    <option value="{{ $resource->category }}" selected>{{ $resource->category }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Resource Content
                                </label>
                                <small class="form-text text-muted">
                                    This is the body of the resource
                                </small>
                                <textarea name="description" id="summernote" rows="5" class="form-control" placeholder="Enter description">{{ $resource->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')"
                                    class="button_load btn btn-primary text-white">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    // width: 650,
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
    </script>
@endsection
