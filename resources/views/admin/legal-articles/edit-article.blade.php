@extends('layouts.admin')

@section('title')
    <title>{{$article->title}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/legal-articles')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            {{$article->title}}
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
                        <form action="{{route('update.article', $article->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Article Title
                                </label>
                                <input type="text" name="title" class="form-control" value="{{$article->title}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Version No.
                                </label>
                                <input type="number" name="version_no" class="form-control" value="{{$article->version_no}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Content
                                </label>
                                <textarea name="content" rows="5" placeholder="Enter description">{{$article->content}}</textarea>
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
@endsection
