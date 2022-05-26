@extends('layouts.admin.customers')

@section('title')
    <title>User Profile - Legalpedia</title>
@endsection

@section('content')
@php
    $rated_user = App\Models\User::where('id', $user->id)->first();
@endphp
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <h6 class="header-pretitle">
                    </h6>
                    <h1 class="header-title">
                        User Profile
                    </h1>
                </div>
            </div>
        </div>
        @include('elements.notifications')
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-xl-4 col-12">
            <div class="card mb-4">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="text-center">
                            <div class="avatar custom-width">
                                @if($user->photo)
                                    <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                    @else
                                    <div class="initials custom-width">
                                        <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                    </div>
                                @endif
                            </div>
                            <h2 class="mb-4 mt-4">
                                {{$user->name}} {{$user->surname}}
                            </h2>
                            <span class="mb-4">
                                @if ($rating_count > 0)
                                    <a href="#reviews"><small>{{number_format($rating_count)}} . {{getRating($rating)}} </small></a>
                                @else
                                    <small class="text-muted">No rating</small> 
                                @endif
                            </span>
                            @if(Auth::user()->role->name == 'Admin')
                                <span class="mb-4 ml-2">
                                    <a href="#" data-bs-target="#rate" data-bs-toggle="modal"><i class="mdi mdi-star"></i> <i class="mdi mdi-star"></i> Rate this User</a></span>
                                </span>
                            @elseif(Auth::user()->id !== $user->id)
                                <span class="mb-4 ml-2">
                                    <a href="#" data-bs-target="#rate" data-bs-toggle="modal"><i class="mdi mdi-star"></i> <i class="mdi mdi-star"></i> Rate this User</a></span>
                                </span>
                            @endif
                            <a href="{{url('team-chats/'. $user->id)}}" class="btn text-white w-100 btn-primary mt-4">
                                <i class="fa fa-paper-plane mr-2"></i> Send a message
                            </a>
                            {{-- <div class="mt-4">
                                @if(Auth::user()->role->name == 'Admin')
                                    @if($user->featured == 1)
                                        <form action="{{route('feature.customer', $user->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="featured" value="0">
                                            <button type="submit" name="remove_featured" class="btn-custom-2">
                                                <span class="mr-4" data-bs-toggle="tooltip" title="Remove featured"><i class="mdi mdi-star font-xl text-warning"></i></span>
                                            </button>
                                        </form>
                                    @elseif($user->featured == 0)
                                        <form action="{{route('feature.customer', $user->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="featured" value="1">
                                            <button type="submit" name="make_featured" class="btn-custom-1">
                                                <span class="mr-4" data-bs-toggle="tooltip" title="Make featured"><i class="mdi mdi-star font-xl"></i></span>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-auto mb-2">
                            <h2 class="mb-3">
                                {{$user->name}}'s Profile
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Email Address
                                </small>
                                <h4 class="mb-1">
                                    @if($user->email_display)
                                        {{$user->email}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Bio
                                </small>
                                <h4 class="mb-1">
                                    {!! $user->bio !!}
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Date of Birth
                                </small>
                                <h4 class="mb-1">
                                    @if($user->dob_display)
                                        {{\Carbon\Carbon::parse($user->dob)->toFormattedDateString()}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    phone
                                </small>
                                <h4 class="mb-1">
                                    @if($user->phone_display)
                                        {{$user->phone}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Year of Call to bar
                                </small>
                                <h4 class="mb-1">
                                    @if($user->ctb_display)
                                        {{$user->call_to_bar_year}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Social platforms
                                </small>
                                @if($user->social_display)
                                    <h4 class="mb-2">
                                        <a href="https://facebook.com/{{$user->facebook}}" class="text-color">
                                            <i class="mdi mdi-facebook"></i> {{$user->facebook}}
                                        </a>
                                    </h4>
                                    <h4 class="mb-2">
                                        <a href="https://instagram.com/{{$user->instagram}}" class="text-color">
                                            <i class="mdi mdi-instagram"></i> {{$user->instagram}}
                                        </a>
                                    </h4>
                                    <h4 class="mb-1">
                                        <a href="https://twitter.com/{{$user->twitter}}" class="text-color">
                                            <i class="mdi mdi-twitter"></i> {{$user->twitter}}
                                        </a>
                                    </h4>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Website Link
                                </small>
                                <h4 class="mb-1">
                                    @if($user->web_display)
                                        <a href="https://{{$user->web_link}}" class="text-color">
                                            <i class="fe fe-globe"></i> {{$user->web_link}}
                                        </a>
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-8 col-12">
            <div class="card">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col">
                            <ul class="nav nav-tabs nav-overflow header-tabs" style="border-bottom: 1px solid #dee2e6">
                                <li class="nav-item">
                                    <a class="nav-link active" id="team-tab" data-toggle="tab" href="#team" role="tab" aria-controls="team" aria-selected="true">
                                        Recent Team posts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="article-tab" data-toggle="tab" href="#article" role="tab" aria-controls="article" aria-selected="false">
                                        Recent Articles
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="false">
                                        Recent Forms
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="note-tab" data-toggle="tab" href="#note" role="tab" aria-controls="note" aria-selected="false">
                                        Recent Notes
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
                    <div class="row">
                        <div class="tab-content" id="wizardSteps">
                            <div class="tab-pane fade show active" id="team" role="tabpanel" aria-labelledby="team-tab">
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
                                                    @if($comment->created_at < $comment->updated_at)
                                                            Edited {{\Carbon\Carbon::parse($comment->updated_at)->toFormattedDateString()}}
                                                            @else
                                                            Posted {{\Carbon\Carbon::parse($comment->created_at)->toFormattedDateString()}}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mb-4">
                                            @if($comment->article_id)
                                                @php
                                                    $body = json_decode($comment->comment_body)
                                                @endphp
                                                <p>{!! $body[0] !!}</p>
                                                <p>{!! $body[1] !!}</p>
                                                <p><a href="{{$body[2]}}" class="text-color"><u>View full article <i class="fe fe-arrow-right"></i></u></a></p>
                                            @elseif($comment->form_precedence_id)
                                                @php
                                                    $body = json_decode($comment->comment_body)
                                                @endphp
                                                <p>{!! $body[0] !!}</p>
                                                <p>{!! $body[1] !!}</p>
                                                <p><a href="{{$body[2]}}" class="text-color"><u>View full form <i class="fe fe-arrow-right"></i></u></a></p>
                                            @else
                                                {!! $comment->comment_body !!}
                                            @endif
                                        </p>
                                        @foreach($comment->comment_replies as $comment_reply)
                                            <div class="comment mt-4 mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-sm">
                                                            <?php $user = App\Models\User::where('id', $comment_reply->user_id)->first(); ?>
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
                                                        <div class="comment-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="comment-title">
                                                                        <a href="{{route('user.profile', $user->id)}}">
                                                                            {{$user->name}}
                                                                        </a>
                                                                    </h5>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <time class="comment-time">
                                                                        {{\Carbon\Carbon::parse($comment_reply->created_at)->toFormattedDateString()}}
                                                                    </time>
                                                                </div>
                                                            </div>
                                                            <p class="comment-text">
                                                                {{$comment_reply->comment_reply_body}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <hr class="my-4">
                                    @endforeach
                                @else
                                    <div class="mt-3 mb-3">
                                        <div class="row align-items-center text-center">
                                            <h4 class="text-muted"><i class="mdi mdi-file-outline"></i> No post created</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                                @if(count($articles) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($articles as $article)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a href="{{route('show.article', $article->id)}}" class="avatar avatar-lg avatar-4by3">
                                                            <img src="{{$article->photo}}" alt="{{$article->title}}" class="avatar-img rounded">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <a href="{{route('show.article', $article->id)}}">{{$article->title}}</a>
                                                        </h4>
                                                        <p class="card-text small text-muted">
                                                            Created {{\Carbon\Carbon::parse($article->created_at)->toFormattedDateString()}}
                                                        </p>
                                                        <p class="card-text small text-color">
                                                            @if($article->authur == 'Legalpedia')
                                                                <a href="{{route('user.profile', $article->user_id)}}" class="text-color">By {{$article->authur}}</a>
                                                            @else
                                                                <a href="{{route('user.profile', $article->user_id)}}" class="text-color">By {{$article->authur}}</a>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No article posted</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
                                @if(count($forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($forms as $form)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a href="{{route('show.form', $form->id)}}" class="avatar text-color avatar-lg">
                                                            <i class="fe fe-file"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <a href="{{route('show.form', $form->id)}}">{{$form->title}}</a>
                                                        </h4>
                                                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$form->category}}</span></p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No Form created</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="note" role="tabpanel" aria-labelledby="note-tab">
                                @if(count($notes) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
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
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            @php
                                                                $judgement_summary = App\Models\JudgementSummary::where('suit_no', 'LIKE', '%'.$note->content_id.'%')->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $note->content_id)->first();
                                                                $rule = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $state_rule = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $form = App\Models\Rule::where('id', $note->content_id)->first();
                                                                $article = App\Models\Rule::where('id', $note->content_id)->first();
                                                            @endphp
                                                            @if($note->resource_type == 'judgement')
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'fed')
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'rule')
                                                                <a href="{{route('show.rule', $rule ? $rule->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{route('show.state-rule', $state_rule ? $state_rule->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'form')
                                                                <a href="{{route('show.form', $form ? $form->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                                @elseif($note->resource_type == 'article')
                                                                <a href="{{route('show.article', $article ? $article->id : '')}}">
                                                                    @php
                                                                        $note->comment = json_decode($note->comment);
                                                                    @endphp
                                                                    @if($note->comment)
                                                                        @foreach ($note->comment as $comment_type)
                                                                            {{ucwords(strtolower($comment_type->value))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        </h4>
                                                        <p class="small text-gray-700 mb-2">
                                                            @php
                                                                $note->content = json_decode($note->content);
                                                            @endphp
                                                            @if($note->content)
                                                                {{ucwords(strtolower($note->content->selector[0]->exact))}}
                                                            @endif
                                                        </p>
                                                        {{-- <p class="small text-color mb-1">
                                                            @php
                                                                $user = App\Models\User::where('id', $note->user_id)->first();
                                                            @endphp
                                                            <a href="{{route('user.profile', $user->id)}}" class="text-color">By {{$user->name}}</a>
                                                        </p> --}}
                                                        <p class="card-text small text-muted">
                                                            {{$note->created_at->diffForHumans()}}
                                                        </p>
                                                        <p class="card-text small text-color">
                                                            @php
                                                                $note_user = App\Models\User::where('id', $note->user_id)->first();
                                                            @endphp
                                                            By <a href="{{route('user.profile', $note->user_id)}}" class="text-color">{{$note_user->name}} {{$note_user->surname}}</a>
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            @if($note->resource_type == 'judgement')
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">
                                                                    {{$judgement_summary ? $judgement_summary->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'fed')
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-primary">
                                                                    {{$fed ? $fed->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'rule')
                                                                <a href="{{route('show.rule', $rule ? $rule->id : '')}}" class="text-primary">
                                                                    {{$rule ? $rule->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'state-rule')
                                                                <a href="{{route('show.state-rule', $state_rule ? $state_rule->id : '')}}" class="text-primary">
                                                                    {{$state_rule ? $state_rule->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'form')
                                                                <a href="{{route('show.form', $form ? $form->id : '')}}" class="text-primary">
                                                                    {{$form ? $form->title : ''}}
                                                                </a>
                                                                @elseif($note->resource_type == 'article')
                                                                <a href="{{route('show.article', $article ? $article->id : '')}}" class="text-primary">
                                                                    {{$article ? $article->title : ''}}
                                                                </a>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No note created</h3>
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

<div class="modal fade" id="rate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="height: auto !important">
            <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                <div class="card-header">
                    <h4 class="card-header-title" id="exampleModalCenterTitle">
                        Rate this User
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
                            <form action="{{route('rate.user')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Your review
                                    </label>
                                    <input type="hidden" name="rating" id="rating">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="type" value="user">
                                    <input type="hidden" name="review_type" value="rating">
                                    <input type="hidden" name="reference_id" value="{{$rated_user->id}}">
                                    <textarea name="review" id="review-input" class="form-control"></textarea>
                                    <div class="mt-4">
                                        <button type="submit" disabled id="reviewBtn" class="btn button_load text-white w-100 btn-primary" onclick="this.classList.toggle('button--loading')">
                                            <div class="button__text"> Send Review</div>
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

<script>
    const reviewBtn = document.getElementById('reviewBtn')
    const review = document.getElementById('review-input')

    const checkEnableButton = () => {
        reviewBtn.disabled = !(
            review.value
        )
    }
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
@endsection
