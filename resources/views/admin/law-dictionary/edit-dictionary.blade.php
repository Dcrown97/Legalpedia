@extends('layouts.admin.law-dictionary')

@section('title')
    <title>{{$word->title}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/law-dictionary')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            {{$word->title}}
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
                        <form action="{{route('update.dictionary', $word->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Word
                                </label>
                                <input type="text" name="title" class="form-control" value="{{$word->title}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Meaning
                                </label>
                                <textarea name="content" rows="5" class="form-control" placeholder="Enter description">{{$word->content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Category
                                </label>
                                <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                    <option value="{{$word->category}}" selected>{{$word->category}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-label mb-1">
                                    Area of Law
                                </label>
                                <textarea name="area_of_law" class="form-control" rows="5" placeholder="Enter area(s) of law">{{$word->area_of_law}}</textarea>
                            </div> --}}
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
