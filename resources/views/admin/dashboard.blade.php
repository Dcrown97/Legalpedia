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
            <div class="col-12 col-xl-4">
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
@endsection
