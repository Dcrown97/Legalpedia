@extends('layouts.admin.legal-maxims')

@section('title')
    <title>{{$maxim->title}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">

                    <div class="col">
                        <a href="{{url('admin/legal-maxims')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            {{$maxim->title}}
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
                        <form action="{{route('update.maxim', $maxim->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Maxim Title
                                </label>
                                <input type="text" name="title" class="form-control" value="{{$maxim->title}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Maxim Version No.
                                </label>
                                <input type="number" name="version_no" class="form-control" value="{{$maxim->version_no}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Maxim Content
                                </label>
                                <small class="form-text text-muted">
                                    This is the body of the maxim
                                </small>
                                <textarea name="content" rows="5" placeholder="Enter description">{{$maxim->content}}</textarea>
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
