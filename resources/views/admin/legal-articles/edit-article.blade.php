@extends('layouts.admin.legal-articles')

@section('title')
    <title>Edit Article - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/legal-articles')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Edit {{$article->title}}
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
                        <form action="{{route('update.article', $article->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Title
                                </label>
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="text" name="title" class="form-control" value="{{$article->title}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Description
                                </label>
                                <textarea class="description form-control" name="description" rows="5" placeholder="Enter content">{{$article->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Content
                                </label>
                                <small class="form-text text-muted">
                                    This is the body of the article
                                </small>
                                <textarea class="description form-control" name="content" rows="5" placeholder="Enter content">{{$article->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Category
                                </label>
                                <select name="category" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="{{$article->category}}">{{$article->category}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Area of Law
                                </label>
                                <textarea class="description form-control" name="area_of_law" rows="5" placeholder="Enter area(s) of Law">{{$article->area_of_law}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Authur
                                </label>
                                <input type="text" name="authur" class="form-control" value="{{$article->authur}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    References
                                </label>
                                <textarea class="description form-control" name="references" rows="5" placeholder="References">{{$article->references}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Cover image
                                </label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url({{$article->photo}})">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Link
                                </label>
                                <input type="text" name="link" class="form-control" value="{{$article->link}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Make article Public
                                </label>
                                @if(Auth::user()->role->name == 'Admin')
                                    <input type="hidden" name="article_type" value="legalpedia">
                                    @else
                                    <input type="hidden" name="article_type" value="user">
                                @endif
                                <select name="display_type" class="form-select">
                                    <option value="{{$article->display_type}}" selected>{{$article->display_type}}</option>
                                    <option value="Public">Make Public</option>
                                    <option value="Private">Keep Private</option>
                                </select>
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
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

    </script>
@endsection
