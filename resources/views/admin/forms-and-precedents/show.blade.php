@extends('layouts.admin.forms-and-precedents')

@section('title')
    <title>{{$form->title}} - Legalpedia</title>
@endsection

@section('content')
<style>
    .modal-content {
        width: 100% !important;
        height: auto !important;
    }
</style>
<style>html {scroll-behavior: smooth;}</style>
    @php
        if (isset(request()->search) && !empty(request()->search)) {
            $searchData = request()->search;
        } elseif(isset(request()->year_result) && !empty(request()->year_result)) {
            $searchData = request()->year_result;
        } elseif(isset(request()->more_result) && !empty(request()->more_result)) {
            $searchData = request()->more_result;
        } else {
            $searchData = "";
        }
    @endphp
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end mb-4">
                    <div class="col">
                        <a href="{{url('admin/forms-and-precedents')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                    </div>
                    @php
                        $main_form = App\Models\FormsPrecedence::where('id', $form->id)->where('user_id', Auth::user()->id)->first();
                    @endphp
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('edit.form', $form->id)}}" class="btn text-white btn-primary">
                                <i class="mdi mdi-pencil"></i> Edit Form
                            </a>
                        </div>
                        @else
                        @if($main_form)
                            <div class="col-auto">
                                <a href="{{route('edit.form', $form->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Form
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="row align-items-end">
                    <div class="col">
                        <h1 class="header-title">
                            {!! highlightText($form->title, $searchData) !!}
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
                    <div class="card-header">
                        <h3 class="header-title">
                            @if($form->form_type == 'legalpedia')
                                @if($form->authur == null)
                                    <a href="{{route('user.profile', $form->user_id ? $form->user_id : '')}}"> By Legalpedia</a>
                                @else
                                    <a href="{{route('user.profile', $form->user_id ? $form->user_id : '')}}">By {{$form->author}} </a>
                                @endif
                            @else
                                <a href="{{route('user.profile', $form->user_id ? $form->user_id : '')}}"> By {{$form->author}}</a>
                            @endif
                        </h3>
                        @if(Auth::user()->role->name == 'Admin')
                            <span class="mr-4"><a href="#" data-bs-target="#rate" data-bs-toggle="modal"><i class="mdi mdi-star"></i> <i class="mdi mdi-star"></i> Rate this Form</a></span>
                        @elseif(Auth::user()->id !== $form->user_id)
                            <span class="mr-4"><a href="#" data-bs-target="#rate" data-bs-toggle="modal"><i class="mdi mdi-star"></i> <i class="mdi mdi-star"></i> Rate this Form</a></span>
                        @endif                        
                        <small class="text-muted">
                            Posted: <span class="text-color">{{\Carbon\Carbon::parse($form->created_at)->toFormattedDateString()}}</span>
                        </small>
                        @php
                            $subscribed_package = App\Models\Package::where('id', Auth::user()->package_id)->first();
                        @endphp
                        @if(Auth::user()->role->name == 'Admin')
                            <div class="col-auto">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-share-variant"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a data-bs-toggle="modal" data-bs-target="#share_form" id="kt_toolbar_primary_button" class="cursor dropdown-item">
                                            <i class="fe fe-users mr-2"></i> Share to teams
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text={{route('forms', $form->id)}}" target="_blank" class="dropdown-item">
                                            <i class="mdi mdi-whatsapp mr-2"></i> Share to Whatsapp
                                        </a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('forms', $form->id)}}" target="_blank" class="dropdown-item">
                                            <i class="mdi mdi-facebook mr-2"></i> Share to Facebook
                                        </a>
                                        <a class="dropdown-item d-flex">
                                            <i class="fe fe-paperclip mr-2"></i><input type="button" class="custom-button dropdown-item" id="hide-copy" value="Copy Link" onclick="Copy();" style="margin-left: -20px; margin-top: -8px;">
                                            <span class="text-color" id="show-status" style="display: none;">Link copied!</span>
                                        </a>
                                        <span><input type="text" style="position: absolute; opacity: 0;" id="paste-box"></span>
                                        @if(Auth::user()->id == $form->user_id)
                                            <form action="/admin/forms-and-precedents/{{$form->id}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                    <i class="fe fe-trash mr-2"></i>Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            @if($subscribed_package->share)
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-share-variant"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a data-bs-toggle="modal" data-bs-target="#share_form" id="kt_toolbar_primary_button" class="cursor dropdown-item">
                                                <i class="fe fe-users mr-2"></i> Share to teams
                                            </a>
                                            <a href="https://api.whatsapp.com/send?text={{route('forms', $form->id)}}" target="_blank" class="dropdown-item">
                                                <i class="mdi mdi-whatsapp mr-2"></i> Share to Whatsapp
                                            </a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{route('forms', $form->id)}}" target="_blank" class="dropdown-item">
                                                <i class="mdi mdi-facebook mr-2"></i> Share to Facebook
                                            </a>
                                            <a class="dropdown-item d-flex">
                                                <i class="fe fe-paperclip mr-2"></i><input type="button" class="custom-button dropdown-item" id="hide-copy" value="Copy Link" onclick="Copy();" style="margin-left: -20px; margin-top: -8px;">
                                                <span class="text-color" id="show-status" style="display: none;">Link copied!</span>
                                            </a>
                                            <span><input type="text" style="position: absolute; opacity: 0;" id="paste-box"></span>
                                            @if(Auth::user()->id == $form->user_id)
                                                <form action="/admin/forms-and-precedents/{{$form->id}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                        <i class="fe fe-trash mr-2"></i>Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="card-body p-5" id="content">
                        <h3>{!! highlightText($form->title, $searchData) !!}</h3>
                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$form->category}}</span></p>
                        <p>By: <a href="{{route('user.profile', $form->user_id ? $form->user_id : '')}}">{{$form->author}}</a></p>
                        <div class="row">
                            <div class="col">
                                @if ($rating_count > 0)
                                    <a href="#reviews"><small>{{number_format($rating_count)}} . {{getRating($rating)}} </small></a>
                                @else
                                    <small class="text-muted">No rating</small> 
                                @endif
                                <br>
                                @php
                                    $like_count = App\Models\Like::where('form_precedence_id', $form->id)->where('like', 1)->count();
                                @endphp
                                <span id="like-div">
                                    <small id="like-no" class="text-color">{{$like_count}} </small> 
                                    @if($like_count < 2)
                                        like
                                    @else
                                        likes
                                    @endif
                                </span>
                            </div>
                            <div class="col-auto">
                                <form id="like-form" class="mr-4">
                                    <input type="hidden" name="user_id" id="user-id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="form_precedence_id" id="form-id" value="{{$form->id}}">
                                    <input type="hidden" name="type" value="form">
                                    @php
                                        $likes = App\Models\Like::where('form_precedence_id', $form->id)->get();
                                        $user_has_liked = App\Models\Like::where('form_precedence_id', $form->id)->where('user_id', Auth::user()->id)->where('like', 1)->first();
                                        $user_has_unliked = App\Models\Like::where('form_precedence_id', $form->id)->where('user_id', Auth::user()->id)->where('like', 0)->first();
                                        $user_has_not_liked = App\Models\Like::where('form_precedence_id', $form->id)->first();
                                    @endphp
                                    @if(count($likes) > 0)
                                        @if($user_has_liked)
                                            <h1 class="cursor-pointer"><i class="mdi unlike mdi-heart font-md text-red" id="unlike-btn" onclick="unLike()"></i></h1>
                                            <h1 class="cursor-pointer"><i class="mdi like mdi-heart-outline font-md" style="display: none" id="like-btn" onclick="like()"></i></h1>
                                        @elseif($user_has_unliked)
                                            <h1 class="cursor-pointer"><i class="mdi like mdi-heart-outline font-md" id="like-btn" onclick="like()"></i></h1>
                                            <h1 class="cursor-pointer"><i class="mdi unlike mdi-heart font-md text-red" style="display: none" id="unlike-btn" onclick="unLike()"></i></h1>
                                        @elseif($user_has_not_liked)
                                            <h1 class="cursor-pointer"><i class="mdi like mdi-heart-outline font-md" id="like-btn" onclick="like()"></i></h1>
                                            <h1 class="cursor-pointer"><i class="mdi unlike mdi-heart font-md text-red" style="display: none" id="unlike-btn" onclick="unLike()"></i></h1>
                                        @endif
                                    @else
                                        <h1 class="cursor-pointer"><i class="mdi like mdi-heart-outline font-md" id="like-btn" onclick="like()"></i></h1>
                                        <h1 class="cursor-pointer"><i class="mdi unlike mdi-heart font-md text-red" style="display: none" id="unlike-btn" onclick="unLike()"></i></h1>
                                    @endif
                                </form>
                                
                            </div>
                        </div>
                        <p id="{{returnHighlightText($form->content, $searchData) == true ? 'form' : '' }}">{!! highlightText($form->content, $searchData) !!}</p>
                    </div>
                    <div class="px-5 border-top-xs">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{route('rate.form')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Add a comment
                                        </label>
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="type" value="form">
                                        <input type="hidden" name="review_type" value="comment">
                                        <input type="hidden" name="reference_id" value="{{$form->id}}">
                                        <textarea name="review" id="comment-input" class="form-control"></textarea>
                                        <div class="mt-4">
                                            <button type="submit" disabled id="commentBtn" class="btn button_load text-white btn-primary" onclick="this.classList.toggle('button--loading')">
                                                <div class="button__text"><i class="fa fa-paper-plane"></i> Comment</div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-5" id="reviews"> 
                        <div class="row align-items-center">
                            <div class="col">
                                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment" aria-selected="true">
                                            Comments
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">
                                            Reviews
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-5">
                        <div class="row align-items-center">
                            <div class="tab-content" id="wizardSteps">
                                <div class="tab-pane fade show active" id="comment" role="tabpanel" aria-labelledby="comment-tab">
                                    @if(count($comments) > 0)
                                        @foreach($comments as $comment)
                                            <div class="mb-3">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-sm">
                                                            <?php $user = App\Models\User::where('id', $comment->user_id)->first(); ?>
                                                            @if($user->photo)
                                                                <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                @else
                                                                <div class="initials">
                                                                    <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                                </div>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="col ms-n2">
                                                        <h4 class="mb-1">
                                                            <a href="{{route('user.profile', $user->id)}}">
                                                                {{$user->name}}
                                                            </a>
                                                        </h4>
                                                    <p class="card-text small text-muted">
                                                        <span class="fe fe-clock"></span>
                                                            {{\Carbon\Carbon::parse($comment->created_at)->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-4">
                                                {!! $comment->review !!}
                                            </p>
                                            <hr class="my-4">
                                        @endforeach
                                    @else
                                        <div class="mt-3 mb-3">
                                            <div class="row align-items-center text-center">
                                                <h4 class="text-muted"><i class="mdi mdi-file-outline"></i> No comment</h4>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="comment-tab">
                                    @if(count($reviews) > 0)
                                        @foreach($reviews as $review)
                                            <div class="mb-3">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-sm">
                                                            <?php $user = App\Models\User::where('id', $review->user_id)->first(); ?>
                                                            @if($user->photo)
                                                                <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                @else
                                                                <div class="initials">
                                                                    <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                                </div>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="col ms-n2">
                                                        <h4 class="mb-1">
                                                            <a href="{{route('user.profile', $user->id)}}">
                                                                {{$user->name}}
                                                            </a>
                                                        </h4>
                                                        <p class="card-text small text-muted">
                                                            {{getRating($review->rating)}} . {{\Carbon\Carbon::parse($review->created_at)->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-4">
                                                {!! $review->review !!}
                                            </p>
                                            <hr class="my-4">
                                        @endforeach
                                    @else
                                        <div class="mt-3 mb-3">
                                            <div class="row align-items-center text-center">
                                                <h4 class="text-muted"><i class="mdi mdi-file-outline"></i> No review</h4>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="share_form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Share Form to teams
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('share.form', $form->id)}}" method="POST">
                        @csrf
                        <div class="card-header">
                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                <input class="form-control list-search" type="search" placeholder="Search">
                                <div class="input-group-text">
                                <span class="fe fe-search"></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check mb-n2">
                                    <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="ordersSelectAll" type="checkbox">
                                    <label class="form-check-label" for="ordersSelectAll">&nbsp;</label> All Teams
                                </div>
                            </div>
                            <div class="col-auto me-n3">
                                <input type="hidden" name="team_id">
                                <button type="submit" name="share_all" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-share-variant-outline"></i> Share</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my-n3">
                                @if(count($teams) > 0)
                                    @foreach($teams as $team)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-1">
                                                    <div class="form-check mb-n2">
                                                        <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArray[]" id="ordersSelectOne" value="{{$team->team_id}}">
                                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <?php $my_team = App\Models\Team::where('id', $team->team_id)->first(); ?>
                                                    <a href="{{route('show.team', $team->team_id)}}" class="avatar avatar-lg">
                                                        <img src="{{$my_team->photo}}" class="avatar-img rounded-circle w-2 h-2" alt="{{$my_team->name}}">
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{route('show.team', $team->team_id)}}">{{$my_team->name}}</a>
                                                    </h4>
                                                    <?php $team_member_count = App\Models\UserTeam::where('approve_request', 1)->where('team_id', $team->team_id)->count(); ?>
                                                    <small class="text-muted">
                                                        {{$team_member_count}} members
                                                    </small>
                                                </div>
                                                <div class="col-3">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <input type="hidden" name="team_id" value="{{$team->team_id}}">
                                                    <input type="hidden" name="form_precedence_id" value="{{$form->id}}">
                                                    <?php $link = route('show.form', $form->id);
                                                        $form_data = [$form->title, $form->content, $link] ;
                                                    ?>
                                                    <input type="hidden" name="comment_body" value="{{ json_encode([$form->title, $form->content, $link]) }}">
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @else
                                    <div class="text-center mt-8 mb-8">
                                        <h3 class="text-muted"><i class="fe fe-users"></i> You have no teams</h3>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Rate this Form
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group justify-content-center">
                                    <div class="d-flex p-2 text-center justify-content-center">
                                        <div class="mr-3">
                                            <a href="#!" class="cursor-pointer" id="first-star-icon" onclick="first()">
                                                <i class="mdi mdi-star-outline font-50"></i>
                                            </a><br>
                                        </div>
                                        <div class="mr-3">
                                            <a href="#!" class="cursor-pointer" id="second-star-icon" onclick="second()">
                                                <i class="mdi mdi-star-outline font-50"></i>
                                            </a><br>
                                        </div>
                                        <div class="mr-3">
                                            <a href="#!" class="cursor-pointer" id="third-star-icon" onclick="third()">
                                                <i class="mdi mdi-star-outline font-50"></i>
                                            </a><br>
                                        </div>
                                        <div class="mr-3">
                                            <a href="#!" class="cursor-pointer" id="fourth-star-icon" onclick="fourth()">
                                                <i class="mdi mdi-star-outline font-50"></i>
                                            </a><br>
                                        </div>
                                        <div class="">
                                            <a href="#!" class="cursor-pointer" id="fifth-star-icon" onclick="fifth();">
                                                <i class="mdi mdi-star-outline font-50"></i>
                                            </a><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <form action="{{route('rate.form', $form->id)}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Your review
                                        </label>
                                        <input type="hidden" name="rating" id="rating">
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="type" value="form">
                                        <input type="hidden" name="review_type" value="rating">
                                        <input type="hidden" name="reference_id" value="{{$form->id}}">
                                        <textarea name="review" id="review-input" class="form-control"></textarea>
                                        <div class="mt-4">
                                            <button type="submit" disabled id="reviewBtn" class="btn button_load text-white w-100 btn-primary" onclick="this.classList.toggle('button--loading')">
                                                <div class="button__text"><i class="fa fa-paper-plane"></i> Send Review</div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="cursor" data-bs-toggle="modal" data-bs-target="#view_notes" id="kt_toolbar_primary_button">
        <div class="note">
            <span class="icon"><i class="mdi mdi-file-document-multiple-outline"></i></span>
        </div>
    </a>

    <div class="modal fade" id="view_notes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Your current notes
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-header">
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                            <input class="form-control list-search" type="search" placeholder="Search">
                            <div class="input-group-text">
                                <span class="fe fe-search"></span>
                            </div>
                        </div>
                        <div class="col-auto me-n3">
                            <a href="{{url('admin/notes')}}" class="btn text-white btn-primary">
                                View all <i class="mdi arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush list my-n3">
                            @if(count($notes) > 0)
                                @foreach($notes as $note)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1 name">
                                                    @php
                                                        $note->comment = json_decode($note->comment);
                                                    @endphp
                                                    @foreach ($note->comment as $comment_type)
                                                        {{ucwords(strtolower($comment_type->value))}}
                                                    @endforeach
                                                </h5>
                                                @php
                                                    $note->content = json_decode($note->content);
                                                @endphp
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm" style="visibility: hidden">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="small text-gray-700 mb-0">
                                                    {{Str::words(ucwords(strtolower($note->content->selector[0]->exact)), 20)}}
                                                </p>
                                                <p class="card-text small text-muted">
                                                    {{$note->created_at->diffForHumans()}}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                @else
                                <div class="text-center my-4">
                                    <h3 class="text-muted"><i class="fe fe-file"></i> No notes</h3>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="save_public" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="fs-1 fw-boldest">Make your notes public or private</h5>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row text-center justify-content-center mt-2 mb-5">
                            <div class="col-3">
                                <a class="cursor-pointer publicText">
                                    <div id="public" class="note12">
                                        <span class="icon-1">
                                            <i class="mdi mdi-account-group"></i>
                                        </span>
                                    </div>
                                    <span class="t-1">
                                        Public
                                    </span>
                                </a>
                            </div>
                            <div class="col-3">
                                <a id="copy-text" class="cursor-pointer copiedText">
                                    <div id="copy" class="note12">
                                        <span class="icon-1">
                                            <i class="mdi mdi-content-copy"></i>
                                        </span>
                                    </div>
                                    <span class="t-1" id="hide-copy1">
                                        Copy
                                    </span>
                                    <span class="t-1 text-color" id="show-copy" style="display: none">
                                        copied!
                                    </span>
                                </a>
                            </div>
                            <div class="col-3">
                                <a class="cursor-pointer shareText">
                                    <div id="share" class="note12">
                                        <span class="icon-1">
                                            <i class="mdi mdi-share-variant-outline"></i>
                                        </span>
                                    </div>
                                    <span class="t-1">
                                        Share
                                    </span>
                                </a>
                            </div>
                            <div class="col-3">
                                <a class="cursor-pointer printText">
                                    <div id="print" class="note12">
                                        <span class="icon-1">
                                            <img src="{{asset('assets/images/printing-text-1.png')}}" alt="">
                                        </span>
                                    </div>
                                    <span class="t-1">
                                        Print
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="row justify-content-center" id="main">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.anote')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Make notes searchable by saving to public</p>
                                        <input type="text" id="input" style="opacity: 0; position: absolute">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="display" class="form-select">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>
                                <input type="hidden" name="note_id" id="note-id">
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save Note</span>
                                </button>
                            </form>
                          </div>
                        </div>
                        <div class="row justify-content-center" id="shareToTeam" style="display: none">
                            <div data-list='{"valueNames": ["name"]}'>
                                <div class="card-header">
                                    <h4 class="card-header-title" id="exampleModalCenterTitle">
                                        Share Note to teams
                                    </h4>
                                </div>
                                <form action="{{route('share.anote')}}" method="POST">
                                    @csrf
                                    <div class="card-header">
                                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                            <input class="form-control list-search" type="search" placeholder="Search">
                                            <div class="input-group-text">
                                            <span class="fe fe-search"></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-check mb-n2">
                                                <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="orders" type="checkbox">
                                                <label class="form-check-label" for="orders">&nbsp;</label> All Teams
                                            </div>
                                        </div>
                                        <div class="col-auto me-n3">
                                            <input type="hidden" name="anote_id" id="anote-id">
                                            <input type="hidden" name="comment_body" id="anote-content">
                                            <button type="submit" name="share_all" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                                <span class="button__text"><i class="mdi mdi-share-variant-outline"></i> Share</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush list my-n3">
                                            @if(count($teams) > 0)
                                                @foreach($teams as $team)
                                                    <li class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-1">
                                                                <div class="form-check mb-n2">
                                                                    <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArray[]" id="ordersSelectOnes" value="{{$team->team_id}}">
                                                                    <label class="form-check-label" for="ordersSelect">&nbsp;</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <?php $my_team = App\Models\Team::where('id', $team->team_id)->first(); ?>
                                                                <a href="{{route('show.team', $team->team_id)}}" class="avatar avatar-lg">
                                                                    <img src="{{$my_team->photo}}" class="avatar-img rounded-circle w-2 h-2" alt="{{$my_team->name}}">
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <h4 class="mb-1 name">
                                                                    <a href="{{route('show.team', $team->team_id)}}">{{$my_team->name}}</a>
                                                                </h4>
                                                                <?php $team_member_count = App\Models\UserTeam::where('approve_request', 1)->where('team_id', $team->team_id)->count(); ?>
                                                                <small class="text-muted">
                                                                    {{$team_member_count}} members
                                                                </small>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                                <input type="hidden" name="team_id" value="{{$team->team_id}}">
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                @else
                                                <div class="text-center mt-8 mb-8">
                                                    <h3 class="text-muted"><i class="fe fe-users"></i> You have no teams</h3>
                                                </div>
                                            @endif
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row justify-content-center" id="printNote" style="display: none">
                            <div class="col-12">
                                <div class="card-header">
                                    <h4 class="card-header-title" id="exampleModalCenterTitle">
                                        Print note
                                    </h4>
                                    <a class="cursor-pointer btn btn-primary text-white printNow" onclick="printContent('printTag')">Print</a>
                                </div>
                                <div class="card-body">
                                    <div id="printTag"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printContent(elem)
        {
            var mywindow = window.open('', 'PRINT', 'height=800,width=1200');

            mywindow.document.write('<html><head><title>' + document.title  + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title  + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }
        
        (function() {
        // Intialize Recogito
        var r = Recogito.init({
          content: 'content', // Element id or DOM node to attach to
          locale: 'auto',
      	  widgets: [
            { widget: 'COMMENT' },
            { widget: 'TAG', vocabulary: [ 'Place', 'Person', 'Event', 'Organization', 'Animal' ] }
          ],
          relationVocabulary: [ 'isRelated', 'isPartOf', 'isSameAs ']
        });

        // r.loadAnnotations('annotations.w3c.json');
        var jid = {{$form->id}};

        r.on('selectAnnotation', function(annote) {
          console.log(annote);
        });

        r.on('createAnnotation', function(annote) {
            var userId = "{{Auth::user()->id}}";
            var contentId = "{{$form ? $form->id : ''}}";
            var resource_type = "form";
            $.ajax({
                type: 'POST',
                url: "/admin/annotations",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: userId,
                    note_id: annote.id,
                    content_id: contentId,
                    content_type: annote.type,
                    content: annote.target,
                    comment: annote.body,
                    resource_type: resource_type,
                },
                success: function (response) {
                    console.log(response);
                    document.getElementById('note-id').value = annote.id;
                    document.getElementById('anote-id').value = response.anote.id;
                    document.getElementById('anote-content').value = response.anote.selector[0].exact;
                    document.getElementById('printTag').innerHTML = response.anote.selector[0].exact;
                    $('#save_public').modal('show');

                    $('.copiedText').click(function() {
                        var Url = document.getElementById("input");
                        Url.value =  response.anote.selector[0].exact;
                        Url.focus();
                        Url.select();
                        document.execCommand("Copy");
                        document.getElementById('hide-copy1').style.display = 'none';
                        document.getElementById('show-copy').style.display = 'initial';
                    });
                    $('.shareText').click(function() {
                        $('#main').hide();
                        $('#shareToTeam').show();
                        $('#printNote').hide();
                    });
                    $('.printText').click(function() {
                        $('#main').hide();
                        $('#shareToTeam').hide();
                        $('#printNote').show();
                    });
                    $('.publicText').click(function() {
                        $('#main').show();
                        $('#shareToTeam').hide();
                        $('#printNote').hide();
                    });
                }

            });

        });

        r.on('updateAnnotation', function(annotation, previous) {
          console.log('updated', previous, 'with', annotation);
        });

      })();
    </script>

    <script>
        const reviewBtn = document.getElementById('reviewBtn')
        const commentBtn = document.getElementById('commentBtn')

        const review = document.getElementById('review-input')
        const comment = document.getElementById('comment-input')

        const checkEnableButton = () => {
            reviewBtn.disabled = !(
                review.value
            )
        }
        const checkCommentButton = () => {
            commentBtn.disabled = !(
                comment.value
            )
        }
        comment.addEventListener('change', checkCommentButton)
        review.addEventListener('change', checkEnableButton)

        function first() {
            document.getElementById("first-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("second-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            document.getElementById("third-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            document.getElementById("fourth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            document.getElementById("fifth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            $('#rating').val('1')
        }
        function second() {
            document.getElementById("first-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("second-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("third-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            document.getElementById("fourth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            document.getElementById("fifth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            $('#rating').val('2')
        }
        function third() {
            document.getElementById("first-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("second-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("third-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("fourth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            document.getElementById("fifth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            $('#rating').val('3')
        }
        function fourth() {
            document.getElementById("first-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("second-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("third-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("fourth-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("fifth-star-icon").innerHTML = '<i class="mdi mdi-star-outline font-50"></i>'
            $('#rating').val('4')
        }
        function fifth() {
            document.getElementById("first-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("second-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("third-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("fourth-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            document.getElementById("fifth-star-icon").innerHTML = '<i class="mdi mdi-star text-yellow font-50"></i>'
            $('#rating').val('5')
        }
    </script>

    <script>

        function Copy()
        {
            var Url = document.getElementById("paste-box");
            // Url.value = window.location.href;
            Url.value = "{{route('forms', $form->id)}}";
            Url.focus();
            Url.select();
            document.execCommand("Copy");

            document.getElementById('hide-copy').style.display = 'none';
            document.getElementById('show-status').style.display = 'block';
        }

        // liking team post function
        function like() {
            document.getElementById('unlike-btn').style.display = 'block';
            document.getElementById('unlike-btn').style.marginTop = '-19px';
            document.getElementById('like-btn').style.display = 'none';
            if( document.getElementById('like-div').style.display = 'none') {
                document.getElementById('like-div').style.display = 'block';
                noOfLikes = document.getElementById('like-no').innerHTML;
                document.getElementById('like-no').innerHTML = parseInt(noOfLikes) + 1;
            } else {
                noOfLikes = document.getElementById('like-no').innerHTML;
                document.getElementById('like-no').innerHTML = parseInt(noOfLikes) + 1;
            }

            let user_id = '{{Auth::user()->id}}';
            let form_precedence_id = '{{$form->id}}';
            let type = 'form';
            let like = 1;

            $.ajax({
                type:'POST',
                url: "{{ url('/admin/forms-and-precedents/like')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    user_id:user_id,
                    form_precedence_id:form_precedence_id,
                    type:type,
                    like:like,
                },
                success:function(data){
                    $("#like-form")[0].reset();
                    console.log(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // unliking team post function
        function unLike() {
            document.getElementById('like-btn').style.display = 'block';
            // document.getElementById(likeBtn).style.marginTop = '-18px';
            document.getElementById('unlike-btn').style.display = 'none';
            noOfLikes = document.getElementById('like-no').innerHTML;
            document.getElementById('like-no').innerHTML = parseInt(noOfLikes) - 1;

            let user_id = '{{Auth::user()->id}}';
            let form_precedence_id = '{{$form->id}}';
            let type = 'form';
            let like = 0;

            $.ajax({
                type:'POST',
                url: "{{ url('/admin/forms-and-precedents/like')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    user_id:user_id,
                    form_precedence_id:form_precedence_id,
                    type:type,
                    like:like,
                },
                success:function(data){
                    $("#like-form")[0].reset();
                    console.log(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

    </script>
    <script>
        var formId = {{$form->id}};
        $(document).ready(function () {
            fetchAnote();
        });
        function fetchAnote() {
            $.ajax({
                type: 'GET',
                url: "/admin/forms-and-precedents/fetch-annotations/" + formId,
                success: function (response) {
                    console.log(response);
                    var array = response.anotes;
                    var objTo = document.getElementById('content');
                    $.each(array, function(key, element) {
                        var co = JSON.parse(element.content)
                        selectAndHighlightRange(objTo, co.selector[1].start, co.selector[1].end);
                    });
                }
            });
        }
        function getTextNodesIn(node) {
            var textNodes = [];
            if (node.nodeType == 3) {
                textNodes.push(node);
            } else {
                var children = node.childNodes;
                for (var i = 0, len = children.length; i < len; ++i) {
                    textNodes.push.apply(textNodes, getTextNodesIn(children[i]));
                }
            }
            return textNodes;
        }

        function setSelectionRange(el, start, end) {
            if (document.createRange && window.getSelection) {
                var range = document.createRange();
                range.selectNodeContents(el);
                var textNodes = getTextNodesIn(el);
                var foundStart = false;
                var charCount = 0, endCharCount;

                for (var i = 0, textNode; textNode = textNodes[i++]; ) {
                    endCharCount = charCount + textNode.length;
                    if (!foundStart && start >= charCount && (start < endCharCount || (start == endCharCount && i <= textNodes.length))) {
                        range.setStart(textNode, start - charCount);
                        foundStart = true;
                    }
                    if (foundStart && end <= endCharCount) {
                        range.setEnd(textNode, end - charCount);
                        break;
                    }
                    charCount = endCharCount;
                }

                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            } else if (document.selection && document.body.createTextRange) {
                var textRange = document.body.createTextRange();
                textRange.moveToElementText(el);
                textRange.collapse(true);
                textRange.moveEnd("character", end);
                textRange.moveStart("character", start);
                textRange.select();
            }
        }

        function makeEditableAndHighlight(colour) {
            sel = window.getSelection();
            if (sel.rangeCount && sel.getRangeAt) {
                range = sel.getRangeAt(0);
            }
            document.designMode = "on";
            if (range) {
                sel.removeAllRanges();
                sel.addRange(range);
            }
            // Use HiliteColor since some browsers apply BackColor to the whole block
            if (!document.execCommand("HiliteColor", false, colour)) {
                document.execCommand("BackColor", false, colour);
            }
            document.designMode = "off";
        }

        function highlight(colour) {
            var range, sel;
            if (window.getSelection) {
                // IE9 and non-IE
                try {
                    if (!document.execCommand("BackColor", false, colour)) {
                        makeEditableAndHighlight(colour);
                    }
                } catch (ex) {
                    makeEditableAndHighlight(colour)
                }
            } else if (document.selection && document.selection.createRange) {
                // IE <= 8 case
                range = document.selection.createRange();
                range.execCommand("BackColor", false, colour);
            }
        }

        function selectAndHighlightRange(id, start, end) {
            setSelectionRange(document.getElementById("content"), start, end);
            highlight("#ffa50033");
        }
    </script>
@endsection
