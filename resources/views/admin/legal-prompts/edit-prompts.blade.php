@extends('layouts.admin.legal-prompts')

@section('title')
    <title>{{ $prompt->title }} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{ url('admin/legal-prompts') }}" class="text-color mb-4"><i
                                class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            {{ $prompt->prompt }}
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="row">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body p-5">
                        <form action="{{ route('update.prompt', $prompt->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Prompt
                                </label>
                                <input type="text" name="prompt" class="form-control" value="{{ $prompt->prompt }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Description
                                </label>
                                <textarea name="description" id="summernote" rows="5" class="form-control" placeholder="Enter description">{{ $prompt->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Category
                                </label>
                                <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                    <option value="{{ $prompt->category }}" selected>{{ $prompt->category }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-label mb-1">
                                    Area of Law
                                </label>
                                <textarea name="area_of_law" class="form-control" placeholder="Enter area(s) of law">{{$prompt->area_of_law}}</textarea>
                            </div> --}}
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
