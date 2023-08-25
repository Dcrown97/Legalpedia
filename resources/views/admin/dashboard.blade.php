@extends('layouts.admin')

@section('title')
    <title>Dashboard - Legalpedia</title>
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('assets/css/stories.css')}}">
    <style>
        .alert-primary {
            background-color: #E3EDFF !important;
            border-color: #E3EDFF !important;
            color: #767676 !important;
        }
        .text-green-0{
            color: #32E017;
        }
        .text-4xl {
            font-size: 30px;
        }
        .typeahead {
            background: #fff;
            position: absolute;
            width: 100%;
            /* padding: 20px; */
        }
        .typeahead li {
            padding: 10px;
            border-bottom: 1px solid #f5f5f5;
        }
        .h-90 {
            height: 90px;
        }
        .modal-content {
            width: 100% !important;
            height: auto !important;
        }
        .backg {
            background: url("{{asset('assets/images/frame2.svg')}}");
            position: absolute;
            /* top: 183px; */
            /* left: 80px; */
            height: 222px;
            width: 261px;
        }

        .backg2 {
            background: url("{{asset('assets/images/frame1.svg')}}");
            position: absolute;
            top: 183px;
            left: 1174px;
            height: 222px;
            width: 260px;
        }
        @media(max-width: 1433px) {

            .backg,
            .backg2 {
                display: none !important;
            }
        }
        .w-300 {
            width: 300px;
        }
        .custom-container {
            margin-bottom: 20px;
            padding: 0 !important;
        }
        .story-container .content {
            text-align: left !important;
        }

        .carousel-cell {
            width: 33.33%;
            left: 0px;
            top: 2rem;
            margin-right: 2rem;
            margin-bottom: 4rem;
        }
        .custom-cell {
            width: 32.1% !important;
            left: 7rem !important;
            margin-bottom: 4rem;
        }
        .flickity-viewport {
            height: 190px !important;
            margin-top: -2rem !important;
        }
        .flickity-slider {
            margin-left: -27rem;
        }
        .flickity-page-dots {
            display: none;
        }
        .show-mobile {
            display: none;
        }
        @media screen and (min-width: 250px) and (max-width: 1200px) {
            .show-mobile {
                display: initial;
            }
            .hide-mobile {
                display: none;
            }
            .carousel-cell {
                width: inherit !important;
            }
            .flickity-slider {
                margin-left: 0;
            }
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="row" style="justify-content: space-between;">
                        <div class="col">
                            <h6 class="header-pretitle">
                            </h6>
                            <h1 class="header-title">
                                @if(Auth::user()->role->name == 'Admin')
                                    Hi, Admin
                                    @else
                                    Hi, {{Str::words(Auth::user()->name, 1, '')}}
                                @endif
                            </h1>
                        </div>
                        <div class="col-sm-2">
                            <a href="{{route('admin.ai')}}" class="btn button_load text-white btn-sm btn-primary p-2 px-3">
                                <span class="button__text">LegalpediaLens</span>
                            </a>
                        </div>
                    </div>
                    
                    
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if($pop_message)
            <a href="" data-bs-toggle="modal" data-bs-target="#popModal" id="kt_toolbar_primary_button">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-message mr-2 text-green-0"></i><strong>Welcome back {{Str::words(Auth::user()->name, 1, '')}}</strong> {!! strip_tags(Str::words($pop_message->body, 20)) !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </a>
        @endif
        @if(isset($featured_team) && isset($featured_user) && isset($featured_article) && isset($featured_form) && isset($featured_note))
            <div class="row hide-mobile">
                <div class="carousel" data-flickity='{ "autoPlay": true }'>
                    <div class="carousel-cell">
                        @php
                            $user = App\Models\User::where('id', $featured_user->reference_id)->first();
                        @endphp
                        <a href="{{route('user.profile', $user->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Lawyer
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm avatar-online">
                                                            @if($user->photo)
                                                                <a href="{{route('user.profile', $user->id)}}">
                                                                    <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                </a>
                                                                @else
                                                                <div class="initials">
                                                                    <a href="{{route('user.profile', $user->id)}}" class="text-white"><span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span></a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($user->name, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('reference_id', $featured_user->reference_id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('reference_id', $user->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('user.profile', $user->id)}}"><i class="mdi mdi-arrow-right"></i> View Profile</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="carousel-cell">
                        @php
                            $article = App\Models\Article::where('id', $featured_article->reference_id)->first();
                        @endphp
                        <a href="{{route('show.article', $article->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Article
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('show.article', $article->id)}}">
                                                                <img src="{{$article->photo}}" class="avatar-img rounded-circle" alt="{{$article->title}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($article->title, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.article', $article->id)}}"><i class="mdi mdi-arrow-right"></i> View Article</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="carousel-cell">
                        @php
                            $team = App\Models\Team::where('id', $featured_team->reference_id)->first();
                        @endphp
                        <a href="{{route('show.team', $team->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Team
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('show.team', $team->id)}}">
                                                                <img src="{{$team->photo}}" class="avatar-img rounded-circle" alt="{{$team->name}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($team->name, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.team', $team->id)}}"><i class="mdi mdi-arrow-right"></i> View Team</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="carousel-cell">
                        @php
                            $note = App\Models\Annotation::where('id', $featured_note->reference_id)->first();
                        @endphp
                        <a href="{{route('admin.notes')}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Note
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('admin.notes')}}" class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1">
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        </h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('reference_id', $note->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('reference_id', $note->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('admin.notes')}}"><i class="mdi mdi-arrow-right"></i> View Note</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="carousel-cell">
                        @php
                            $form = App\Models\FormsPrecedence::where('id', $featured_form->reference_id)->first();
                        @endphp
                        <a href="{{route('show.form', $form->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Form
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('show.form', $form->id)}}" class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($form->title, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.form', $form->id)}}"><i class="mdi mdi-arrow-right"></i> View Form</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row show-mobile">
                <div class="carousel" data-flickity='{ "autoPlay": true }'>
                    <div class="carousel-cell">
                        <div class="col-12">
                            @php
                                $user = App\Models\User::where('id', $featured_user->reference_id)->first();
                            @endphp
                            <a href="{{route('user.profile', $user->id)}}" class="link_item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center gx-0">
                                            <div class="col">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    Featured Lawyer
                                                </h6>
                                                <span class="h2 mb-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar avatar-sm avatar-online">
                                                                @if($user->photo)
                                                                    <a href="{{route('user.profile', $user->id)}}">
                                                                        <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                    </a>
                                                                    @else
                                                                    <div class="initials">
                                                                        <a href="{{route('user.profile', $user->id)}}" class="text-white"><span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span></a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h4>{{Str::words($user->name, 3)}}</h4>
                                                            @php
                                                                $rating_count = App\Models\FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('reference_id', $featured_user->reference_id)->count();
                                                                $rating = App\Models\FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('reference_id', $user->id)->max('rating');
                                                            @endphp
                                                            @if ($rating_count > 0)
                                                                <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                            @else
                                                                <small class="text-muted">No rating</small>
                                                            @endif
                                                        </div>
                                                        <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('user.profile', $user->id)}}"><i class="mdi mdi-arrow-right"></i> View Profile</a>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="carousel-cell">
                        <div class="col-12">
                            @php
                                $article = App\Models\Article::where('id', $featured_article->reference_id)->first();
                            @endphp
                            <a href="{{route('show.article', $article->id)}}" class="link_item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center gx-0">
                                            <div class="col">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    Featured Article
                                                </h6>
                                                <span class="h2 mb-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar avatar-sm">
                                                                <a href="{{route('show.article', $article->id)}}">
                                                                    <img src="{{$article->photo}}" class="avatar-img rounded-circle" alt="{{$article->title}}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h4>{{Str::words($article->title, 3)}}</h4>
                                                            @php
                                                                $rating_count = App\Models\FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
                                                                $rating = App\Models\FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
                                                            @endphp
                                                            @if ($rating_count > 0)
                                                                <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                            @else
                                                                <small class="text-muted">No rating</small>
                                                            @endif
                                                        </div>
                                                        <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.article', $article->id)}}"><i class="mdi mdi-arrow-right"></i> View Article</a>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="carousel-cell">
                        <div class="col-12">
                            @php
                                $team = App\Models\Team::where('id', $featured_team->reference_id)->first();
                            @endphp
                            <a href="{{route('show.team', $team->id)}}" class="link_item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center gx-0">
                                            <div class="col">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    Featured Team
                                                </h6>
                                                <span class="h2 mb-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar avatar-sm">
                                                                <a href="{{route('show.team', $team->id)}}">
                                                                    <img src="{{$team->photo}}" class="avatar-img rounded-circle" alt="{{$team->name}}">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h4>{{Str::words($team->name, 3)}}</h4>
                                                            @php
                                                                $rating_count = App\Models\FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->count();
                                                                $rating = App\Models\FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->max('rating');
                                                            @endphp
                                                            @if ($rating_count > 0)
                                                                <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                            @else
                                                                <small class="text-muted">No rating</small>
                                                            @endif
                                                        </div>
                                                        <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.team', $team->id)}}"><i class="mdi mdi-arrow-right"></i> View Team</a>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="carousel-cell">
                        <div class="col-12">
                            @php
                                $note = App\Models\Annotation::where('id', $featured_note->reference_id)->first();
                            @endphp
                            <a href="{{route('admin.notes')}}" class="link_item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center gx-0">
                                            <div class="col">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    Featured Note
                                                </h6>
                                                <span class="h2 mb-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar avatar-sm">
                                                                <a href="{{route('admin.notes')}}" class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                    <i class="fe fe-file"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h4 class="mb-1">
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
                                                                                {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                                {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                                {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                                {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                                {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                                {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
                                                                            @endforeach
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                            </h4>
                                                            @php
                                                                $rating_count = App\Models\FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('reference_id', $note->id)->count();
                                                                $rating = App\Models\FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('reference_id', $note->id)->max('rating');
                                                            @endphp
                                                            @if ($rating_count > 0)
                                                                <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                            @else
                                                                <small class="text-muted">No rating</small>
                                                            @endif
                                                        </div>
                                                        <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('admin.notes')}}"><i class="mdi mdi-arrow-right"></i> View Note</a>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="carousel-cell">
                        <div class="col-12">
                            @php
                                $form = App\Models\FormsPrecedence::where('id', $featured_form->reference_id)->first();
                            @endphp
                            <a href="{{route('show.form', $form->id)}}" class="link_item">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center gx-0">
                                            <div class="col">
                                                <h6 class="text-uppercase text-muted mb-3">
                                                    Featured Form
                                                </h6>
                                                <span class="h2 mb-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar avatar-sm">
                                                                <a href="{{route('show.form', $form->id)}}" class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                    <i class="fe fe-file"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h4>{{Str::words($form->title, 3)}}</h4>
                                                            @php
                                                                $rating_count = App\Models\FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
                                                                $rating = App\Models\FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');
                                                            @endphp
                                                            @if ($rating_count > 0)
                                                                <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                            @else
                                                                <small class="text-muted">No rating</small>
                                                            @endif
                                                        </div>
                                                        <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.form', $form->id)}}"><i class="mdi mdi-arrow-right"></i> View Form</a>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="custom-container w-100">
                <div class="story-container" style="grid-auto-columns: unset;">
                    <div class="content w-300">
                        @php
                            $team = App\Models\Team::where('id', $featured_team->reference_id)->first();
                        @endphp
                        <a href="{{route('show.team', $team->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Team
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('show.team', $team->id)}}">
                                                                <img src="{{$team->photo}}" class="avatar-img rounded-circle" alt="{{$team->name}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($team->name, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'team')->where('review_type', 'rating')->where('reference_id', $team->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.team', $team->id)}}"><i class="mdi mdi-arrow-right"></i> View Team</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content w-300">
                        @php
                            $user = App\Models\User::where('id', $featured_user->reference_id)->first();
                        @endphp
                        <a href="{{route('user.profile', $user->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured User
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm avatar-online">
                                                            @if($user->photo)
                                                                <a href="{{route('user.profile', $user->id)}}">
                                                                    <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                </a>
                                                                @else
                                                                <div class="initials">
                                                                    <a href="{{route('user.profile', $user->id)}}" class="text-white"><span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span></a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($user->name, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('reference_id', $featured_user->reference_id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'user')->where('review_type', 'rating')->where('reference_id', $user->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('user.profile', $user->id)}}"><i class="mdi mdi-arrow-right"></i> View User</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content w-300">
                        @php
                            $article = App\Models\Article::where('id', $featured_article->reference_id)->first();
                        @endphp
                        <a href="{{route('show.team', $team->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Article
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('show.article', $article->id)}}">
                                                                <img src="{{$article->photo}}" class="avatar-img rounded-circle" alt="{{$article->title}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($article->title, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'article')->where('review_type', 'rating')->where('reference_id', $article->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.article', $article->id)}}"><i class="mdi mdi-arrow-right"></i> View Article</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content w-300">
                        @php
                            $form = App\Models\FormsPrecedence::where('id', $featured_form->reference_id)->first();
                        @endphp
                        <a href="{{route('show.form', $form->id)}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Form
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('show.form', $form->id)}}" class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4>{{Str::words($form->title, 3)}}</h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'form')->where('review_type', 'rating')->where('reference_id', $form->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('show.form', $form->id)}}"><i class="mdi mdi-arrow-right"></i> View Form</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="content w-300">
                        @php
                            $note = App\Models\Annotation::where('id', $featured_note->reference_id)->first();
                        @endphp
                        <a href="{{route('admin.notes')}}" class="link_item">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-3">
                                                Featured Note
                                            </h6>
                                            <span class="h2 mb-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-sm">
                                                            <a href="{{route('admin.notes')}}" class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                                <i class="fe fe-file"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1">
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
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
                                                                            {{ucwords(strtolower(Str::words($comment_type->value, 3)))}}
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        </h4>
                                                        @php
                                                            $rating_count = App\Models\FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('reference_id', $note->id)->count();
                                                            $rating = App\Models\FeaturedContent::where('type', 'note')->where('review_type', 'rating')->where('reference_id', $note->id)->max('rating');
                                                        @endphp
                                                        @if ($rating_count > 0)
                                                            <small>{{number_format($rating_count)}} . {{getRating($rating)}} </small>
                                                        @else
                                                            <small class="text-muted">No rating</small>
                                                        @endif
                                                    </div>
                                                    <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{route('admin.notes')}}"><i class="mdi mdi-arrow-right"></i> View Note</a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
        @endif
        <div class="row">
            <div class="col-12 col-xl-3">
                <a href="{{url('admin/judgements')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        AI Assistant
                                    </h6>
                                    <span class="h2 mb-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{url('admin/ai-assistant')}}">
                                                    <img src="{{asset('assets/images/ai.jpg')}}" alt="LegalpediaLens" class="card-img-top h-90">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <span class="text-3xl">LegalpediaLens</span>
                                            </div>
                                            <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{url('admin/ai-assistant')}}"><i class="mdi mdi-arrow-right"></i> AI Assistant</a>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-xl-3">
                <a href="{{url('admin/judgements')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Legalpedia Resources
                                    </h6>
                                    <span class="h2 mb-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{url('admin/judgements')}}">
                                                    <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="Legalpedia resources" class="card-img-top h-90">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <span class="text-4xl">{{number_format($all_count)}}</span> <span class="text-muted">Resources</span>
                                            </div>
                                            <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{url('admin/judgements')}}"><i class="mdi mdi-arrow-right"></i> View Judgements</a>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-xl-3">
                <a href="{{url('admin/teams')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Teams
                                    </h6>
                                    <span class="h2 mb-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="">
                                                    <img src="{{asset('assets/images/conversation.png')}}" alt="Teams" class="card-img-top h-90">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <span class="text-4xl"> {{number_format($team_count)}}</span> <span class="text-muted">Teams created</span>
                                            </div>
                                            <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{url('admin/teams')}}"><i class="mdi mdi-arrow-right"></i> Create Teams</a>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-xl-3">
                <a href="{{url('admin/articles')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Articles
                                    </h6>
                                    <span class="h2 mb-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="">
                                                    <img src="{{asset('assets/images/file.png')}}" alt="Articles" class="card-img-top h-90">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <span class="text-4xl"> {{number_format($article_count)}}</span> <span class="text-muted">Articles</span>
                                            </div>
                                            <a class="small justify-content-end text-right align-items-end text-color" style="float: right" href="{{url('admin/legal-articles')}}"><i class="mdi mdi-arrow-right"></i> Publish an Article</a>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Latest Judgements
                        </h4>
                        <a class="small" href="{{url('admin/judgements')}}">View all</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush list-group-activity my-n3">
                            @if(count($latest_judgements) > 0)
                                @foreach ($latest_judgements as $judgement)
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-bell"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1">
                                                    <a href="{{route('show.judgement', $judgement->id)}}">
                                                        {{ucwords(strtolower($judgement->title))}}
                                                    </a>
                                                </h5>
                                                <p class="small text-gray-700 mb-0">
                                                    {!! Str::words($judgement->summary_of_facts, 10) !!}
                                                </p>
                                                <p class="card-text text-color small mb-1">
                                                    <?php $court = App\Models\Court::where('id', $judgement->court_id)->first();?>
                                                    @if($court)
                                                        {{$court->court}}
                                                        @else
                                                        In the Court of Appeal
                                                    @endif
                                                </p>
                                                <p class="card-text small text-muted">
                                                    {{\Carbon\Carbon::parse($judgement->judgement_date)->format('D')}}  {{\Carbon\Carbon::parse($judgement->judgement_date)->toFormattedDateString()}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="text-center my-4">
                                    <p class="text-muted"><i class="fe fe-file"></i> No recent Judgement found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">
                           My Recent Notes
                        </h4>
                        <a class="small" href="{{url('admin/notes')}}">View all</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush list-group-activity my-n3">
                            @if(count($notes) > 0)
                                @foreach ($notes as $note)
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1">
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
                                                </h5>
                                                @php
                                                    $note->content = json_decode($note->content);
                                                @endphp
                                            </div>
                                            @if($note->display == 'public')
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        @if($note->content)
                                                            <a data-bs-toggle="modal" onclick='showTeamModal("{{$note->content->selector[0]->exact}}", "{{$note->id}}")' class="dropdown-ellipses dropdown-toggle small cursor" style="font-size: .95rem">
                                                                <i class="mdi mdi-share-variant"></i> share
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
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
                                                    @if($note->content)
                                                        {{Str::words(ucwords(strtolower($note->content->selector[0]->exact)), 20)}}
                                                    @endif
                                                </p>
                                                <p class="card-text small text-muted">
                                                    {{$note->created_at->diffForHumans()}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @elseif(count($notes) < 1)
                                @foreach($admin_notes as $note)
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1">
                                                    <a href="{{url('admin/notes')}}">
                                                        {{$note->comment}}
                                                    </a>
                                                </h4>
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
                                                    {{Str::words(ucwords(strtolower($note->content)), 20)}}
                                                </p>
                                                {{-- <p class="card-text small text-muted">
                                                    {{$note->created_at->diffForHumans()}}
                                                </p> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="text-center">
                                    <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">
                           Recent Activities
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush list-group-activity my-n3">
                            @if(count($recent_activities) > 0)
                                @foreach ($recent_activities as $activity)
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-bell"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                @if($activity->type == 'note')
                                                    <h5 class="mb-1">
                                                        {{$activity->name}}
                                                    </h5>
                                                    <p class="small text-gray-700 mb-0">
                                                        @php
                                                            $active = is_array($activity->description) ? json_decode($activity->description) : $activity->description;
                                                            // $final = is_array($active) ? $active->content->selector[0]->exact : $active;
                                                            // dd(json_decode($active));
                                                            $fin = json_decode($active);
                                                            // dd($fin->selector[0]->exact);
                                                        @endphp
                                                        @if(isset($fin->selector[0]->exact))
                                                            {{Str::words(ucwords(strtolower($fin->selector[0]->exact)), 20)}}
                                                        @endif
                                                    </p>
                                                    @else
                                                    <h5 class="mb-1">
                                                        {{$activity->name}}
                                                    </h5>
                                                    <p class="small text-gray-700 mb-0">
                                                        {{Str::words($activity->description, 20)}}
                                                    </p>
                                                @endif
                                                <p class="card-text small text-muted">
                                                    {{$activity->created_at->diffForHumans()}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="text-center my-4">
                                    <p class="text-muted"><i class="fe fe-file"></i> No recent activity</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Share Note to teams
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="ordersSelectAll" type="checkbox">
                                    <label class="form-check-label" for="ordersSelectAll">&nbsp;</label> All Teams
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
    <div class="modal fade" id="popModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="background: linear-gradient(0deg, rgba(255,255,255,1)15%, rgba(255,240,240,1) 40%);">
                    <div class="backg"></div>
                    <div class="modal-card card" style="background: none !important;">
                        <div class="card-header" style="border-bottom: none">
                            <span class="text-center text-success"></span>
                            <img src="{{asset('assets/images/waving-hand.png')}}" alt="..." class="w-8 h-8">
                        </div>
                        <div class="card-body">
                            <h1 class="text-color text-center">{{$pop_message ? $pop_message->subject : 'Welcome to Legalpedia'}}</h1>
                            {{-- <p class="small text-color">You can access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!</p> --}}
                            <p class="">{!! $pop_message ? $pop_message->body : 'You can access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!' !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // var t = '';
        // function gText(e) {
        //     t = (document.all) ? document.selection.createRange().text : document.getSelection();

        //     document.getElementById('input').value = t;
        // }

        // document.onmouseup = gText;
        // if (!document.all) document.captureEvents(Event.MOUSEUP);

        $(document ).ready(function() {
            @if(Session::has('welcome') && Session::get('welcome') == 1)
                $('#popModal').modal('show');
                {{Session::forget('welcome')}};
            @endif
        });
        function showTeamModal(content, id){
            document.getElementById("anote-content").value = content;
            document.getElementById("anote-id").value = id;
            $('#teamModal').modal('show')
        }
    </script>
    <!-- Script to Activate the Carousel -->
    <script>
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })
    </script>
@endsection
