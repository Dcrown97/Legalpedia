@extends('layouts.admin.forms-and-precedents')

@section('title')
    <title>{{$form->title}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/forms-and-precedents')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            {{$form->title}}
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
                        <form action="{{route('update.form', $form->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Title
                                </label>
                                <input type="text" name="title" class="form-control" value="{{$form->title}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Version No.
                                </label>
                                <input type="number" name="version_no" class="form-control" value="{{$form->version_no}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Content
                                </label>
                                <textarea name="content" class="form-control" rows="5" placeholder="Enter description">{{$form->content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Category
                                </label>
                                <select name="category" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="{{$form->category}}" selected>{{$form->category}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Area of Law
                                </label>
                                <select name="area_of_law" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                    <option value="{{$form->area_of_law}}" selected>{{$form->area_of_law}}</option>
                                    @foreach($area_of_laws as $area_of_law)
                                        <option value="{{$area_of_law->id}}">{{$area_of_law->AreaOfLaw}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Author
                                </label>
                                <input type="text" name="author" class="form-control" value="{{$form->author}}">
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
