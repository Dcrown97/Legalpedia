@extends('layouts.subscription')

@section('title')
<title>{{$form->title}}</title>
@endsection

@section('content-1')
<div class="text-center container cont">
    <div class="container">
        <h4>{{$form->title}}</h4>
    </div>
</div>
@endsection

@section('content-2')
<style>
    .card {
        word-wrap: break-word;
        background-clip: border-box;
        background-color: #fff;
        border: 1px solid #edf2f9;
        border-radius: .5rem;
        display: flex;
        flex-direction: column;
        min-width: 0;
        position: relative;

        border-color: #edf2f9;
        box-shadow: 0 0.75rem 1.5rem rgb(18 38 63 / 3%);
        margin-bottom: 1.5rem;
    }
    .custom-text {
        color: #999 !important;
        font-weight: 400;
        /* line-height: 25px; */
    }
    .text-muted {
        opacity: 1;
        color: #95aac9!important;
    }
    .text-color {
        color: #EC6959 !important;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-10">
            <div class="">
                <div class="card p-4 custom-text">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="package text-muted">Author: <span class="text-color">{{$form->author}}</span></h3>
                            </div>
                            <div class="col-auto d-flex">
                                <small class="text-muted mr-4">
                                    Posted: <span class="text-color">{{\Carbon\Carbon::parse($form->created_at)->toFormattedDateString()}}</span>
                                </small>
                                <a href="https://api.whatsapp.com/send?text={{route('forms', $form->id)}}" target="_blank" class="mr-2 text-color">
                                    <i class="mdi mdi-whatsapp mr-2"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{route('forms', $form->id)}}" target="_blank" class="text-color">
                                    <i class="mdi mdi-facebook mr-2"></i>
                                </a>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h5>{{$form->title}}</h5>
                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$form->category}}</span></p>
                        <p>By: <a href="{{route('user.profile', $form->user_id)}}">{{$form->author}}</a></p>
                        <p>{!! $form->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
