@extends('layouts.admin.forms-and-precedents')

@section('title')
    <title>{{ $form->title }} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{ url('admin/forms-and-precedents') }}" class="text-color mb-4"><i
                                class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            {{ $form->title }}
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body p-5">
                        <form action="{{ route('update.form', $form->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Title
                                </label>
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="text" name="title" class="form-control" value="{{ $form->title }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Content
                                </label>
                                <textarea name="content" id="summernote3" class="description form-control" rows="5"
                                    placeholder="Enter description">{{ $form->content }}</textarea>
                            </div>
                            @if (Auth::user()->role->name == 'Admin')
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <option value="{{ $form->category }}">{{ $form->category }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                @if ($categories->form_cat)
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Category
                                        </label>
                                        @php
                                            $all_categories = json_decode($categories->form_cat);
                                        @endphp
                                        <select name="category" class="form-select mr-8"
                                            data-choices='{"searchEnabled": true}'>
                                            <option value="{{ $form->category }}">{{ $form->category }}</option>
                                            @foreach ($all_categories as $category)
                                                @php
                                                    $main_category = App\Models\Category::where(
                                                        'category',
                                                        $category,
                                                    )->first();
                                                @endphp
                                                <option value="{{ $main_category->category }}">
                                                    {{ $main_category->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endif
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Author
                                </label>
                                @if (Auth::user()->role->name == 'Admin')
                                    <input type="text" name="author" class="form-control" value="Legalpedia" readonly>
                                @else
                                    <input type="text" name="author" class="form-control" value="{{ $form->author }}"
                                        readonly>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Make Form public or private
                                </label>
                                @if (Auth::user()->role->name == 'Admin')
                                    <input type="hidden" name="form_type" value="legalpedia">
                                @else
                                    <input type="hidden" name="form_type" value="user">
                                @endif
                                <select name="display_type" class="form-select">
                                    <option value="{{ $form->display_type }}" selected>{{ $form->display_type }}</option>
                                    <option value="Public">Make Public</option>
                                    <option value="Private">Keep Private</option>
                                </select>
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
