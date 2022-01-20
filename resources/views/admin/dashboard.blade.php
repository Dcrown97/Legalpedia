@extends('layouts.admin')

@section('title')
    <title>Dashboard - Legalpedia</title>
@endsection

@section('content')
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
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
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
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i class="mdi mdi-message mr-2 text-green-0"></i><strong>Welcome back {{Str::words(Auth::user()->name, 1, '')}}</strong> You can access thousands of records of recent and old Judgments, Laws, Rules, Articles and so much more!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="row">
            <div class="col-12 col-xl-4">
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
            <div class="col-12 col-xl-4">
                <a href="{{url('admin/teams')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Legalpedia Teams
                                    </h6>
                                    <span class="h2 mb-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="">
                                                    <img src="{{asset('assets/images/conversation.png')}}" alt="Legalpedia Teams" class="card-img-top h-90">
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
            <div class="col-12 col-xl-4">
                <a href="{{url('admin/articles')}}" class="link_item">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-3">
                                        Legalpedia Articles
                                    </h6>
                                    <span class="h2 mb-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="">
                                                    <img src="{{asset('assets/images/file.png')}}" alt="Legalpedia resources" class="card-img-top h-90">
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
                           My Notes
                        </h4>
                        <a class="small" href="{{url('admin/judgements')}}">View all</a>
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
                                                    <a href="{{route('show.judgement', $judgement->id)}}">
                                                        @php
                                                            $note->comment = json_decode($note->comment);
                                                        @endphp
                                                        @foreach ($note->comment as $comment_type)
                                                            {{ucwords(strtolower($comment_type->value))}}
                                                        @endforeach
                                                    </a>
                                                </h5>
                                                <p class="small text-gray-700 mb-0">
                                                    @php
                                                        $note->content = json_decode($note->content);
                                                    @endphp
                                                    {{Str::words(ucwords(strtolower($note->content->selector[0]->exact)), 20)}}
                                                </p>
                                                <p class="card-text small text-muted">
                                                    {{$note->created_at->diffForHumans()}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="text-center my-4">
                                    <p class="text-muted"><i class="fe fe-file"></i> You have no recent notes</p>
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
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1">
                                                    {{$activity->name}}
                                                </h5>
                                                <p class="small text-gray-700 mb-0">
                                                    {{$activity->description}}
                                                </p>
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

@endsection
