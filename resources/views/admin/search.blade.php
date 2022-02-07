@extends('layouts.admin.judgements')

@section('title')
    <title>Search results - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }
        .icon-1.active:after {
            display: none;
        }
        .notify-1 {
            position: absolute;
            margin: -25px 0 0 0px;
            background: transparent;
            border-radius: 100%;
            padding: 5px 10px;
            color: #EC6959 !important;
            font-size: 14px;
        }
        @media screen and (min-width: 200px) and (max-width: 767px) {
            .hide-mobile {
                display: none;
            }
        }
        .button_load {
        position: relative;
    }

    .button__text {
        transition: all 0.2s;
    }

    .button--loading1 {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, 0.9) !important;
        z-index: 999;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        transition: all .5s ease;
    }
    .button--loading1:hover {
        background: rgba(255, 255, 255, 0.9) !important;
    }

    .button--loading1 .button__text {
        visibility: hidden;
        opacity: 0;
    }

    .button--loading1::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 3px solid transparent;
        border-top-color: #EC6959;
        border-radius: 50%;
        background: transparent !important;
        animation: button-loading-spinner 1s ease infinite;
    }
    .button--loading1 .btn-primary::after {
        background: rgba(255, 255, 255, 0.9) !important;
    }
    .button--loading1 .btn-primary {
        background: rgba(255, 255, 255, 0.9) !important;
    }

    @keyframes button-loading-spinner {
        from {
            transform: rotate(0turn);
        }

        to {
            transform: rotate(1turn);
        }
    }
    .custom-button {
        background: none !important;
        border: none !important;
        box-shadow: none;
    }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <h1 class="header-title">
                            Search results: <span class="text-muted">"{{$search}}"</span>
                        </h1>
                    </div>
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="getjudg-tab" data-toggle="tab" href="#getjudg" role="tab" aria-controls="getjudg" aria-selected="true">
                            @if($query_case_count < 1)
                                Judgements
                                @else
                                <span class="icon-1 active">
                                    <small class="notify-1">{{number_format($query_case_count)}}</small>
                                    Judgements
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="law-tab" data-toggle="tab" href="#law" role="tab" aria-controls="law" aria-selected="false">
                            @if($query_law_count < 1)
                                Laws of Federation
                                @else
                                <span class="icon-1 active">
                                    <small class="notify-1">{{number_format($query_law_count)}}</small>
                                    Laws of Federation
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rule-tab" data-toggle="tab" href="#rule" role="tab" aria-controls="legal" aria-selected="false">
                            @if($query_rule_count < 1)
                                Rules
                                @else
                                <span class="icon-1 active">
                                    <small class="notify-1">{{number_format($query_rule_count)}}</small>
                                    Rules
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="legal" aria-selected="false">
                            @if($query_form_count < 1)
                                Forms and Precedents
                                @else
                                <span class="icon-1 active">
                                    <small class="notify-1">{{number_format($query_form_count)}}</small>
                                    Forms and Precendents
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="article-tab" data-toggle="tab" href="#article" role="tab" aria-controls="article" aria-selected="false">
                            @if($query_article_count < 1)
                                Articles
                                @else
                                <span class="icon-1 active">
                                    <small class="notify-1">{{number_format($query_article_count)}}</small>
                                    Articles
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="note-tab" data-toggle="tab" href="#note" role="tab" aria-controls="note" aria-selected="false">
                            @if($query_note_count < 1)
                                Public Notes
                                @else
                                <span class="icon-1 active">
                                    <small class="notify-1">{{number_format($query_note_count)}}</small>
                                    Public Notes
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="wizardSteps">
                    <div class="tab-pane fade show active" id="getjudg" role="tabpanel" aria-labelledby="getjudg-tab">
                        <div class="card" data-list='{"valueNames": ["item-name", "item-name1"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Judgements</h4>
                                @if($second_search == '')
                                    <form action="{{route('search')}}" method="GET">
                                        <input type="hidden" name="more_result" value="{{$search}}">
                                        <button id="search-btn" class="custom-button text-color" onclick="this.classList.toggle('button--loading1')">
                                            <span class="button__text">More results <i class="mdi mdi-chevron-right"></i></span>
                                        </button>
                                    </form>
                                @endif
                                <span>
                                    {{$query_case['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search title" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query_case_count)}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(count($query_case['search']) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @if($query_case['table'] == 'ratio')
                                            @foreach($query_case['search'] as $case)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                                $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$case->heading}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-2 item-name">
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$case->heading}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($case->body, 100) !!}
                                                            </p>
                                                            <p class="card-text mb-1 text-color">
                                                                {{$court ? $court->court : ''}}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-1 item-name1">
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            @elseif($query_case['table'] == 'sum')
                                            @foreach($query_case['search'] as $case)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                                $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name">
                                                                {!! Str::words($judgement_summary ? $judgement_summary->summary_of_facts : '', 100) !!}
                                                            </p>
                                                            <p class="card-text mb-1 text-color">
                                                                {{$court ? $court->court : ''}}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name1">
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            @elseif($query_case['table'] == 'judgement')
                                            @foreach($query_case['search'] as $case)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                                $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                                $judgement = App\Models\Judgement::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first();

                                                            @endphp
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name">
                                                                {!! Str::words($judgement ? $judgement->judgement : '', 100) !!}
                                                            </p>
                                                            <p class="card-text mb-1 text-color">
                                                                {{$court ? $court->court : ''}}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name1">
                                                                <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    @else
                                    <div class="text-center my-4">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                        @if($first_search !== '')
                                            <div class="col-auto mt-2">
                                                <form action="{{route('search')}}" method="GET">
                                                    <input type="hidden" name="more_result" value="{{$search}}">
                                                    <button id="search-btn" class="btn btn-primary text-white" onclick="this.classList.toggle('button--loading1')">
                                                        <span class="button__text"><i class="fe fe-search"></i> Advanced search</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="my-4 justify-content-center text-center">
                                    {{$query_case['search']->links()}}
                                </div>
                            </div>
                            {{-- <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="law" role="tabpanel" aria-labelledby="law-tab">
                        <div class="card" data-list='{"valueNames": ["item-name2", "item-name3"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLis">
                            <div class="card-header">
                                <h4 class="card-header-title">Law of Federation</h4>
                                <span>
                                    {{$query_law['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search title" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query_law_count)}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($query_law['search']) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @if($query_law['table'] == 'sec')
                                            @foreach($query_law['search'] as $section)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                // $section = App\Models\LawOfFedSection::where('law_of_federation_id', $sched->law_of_federation_id)->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $section->law_of_federation_id)->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$section ? $section->section_header : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-color">{{$section ? $section->section_header : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($section ? $section->section_body : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            {{-- @foreach($query_law['search'] as $section)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $sched = App\Models\LawOfFedSched::where('law_of_federation_id', $section ? $section->law_of_federation_id : '')->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $section ? $section->law_of_federation_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$sched ? $sched->sched_header : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-color">{{$sched ? $sched->sched_header : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($sched ? $sched->sched_body : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            @foreach($query_law['search'] as $section)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $fed = App\Models\LawOfFederation::where('id', $section ? $section->law_of_federation_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$fed ? $fed->title : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-color">{{$fed ? $fed->title : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($fed ? $fed->description : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach --}}
                                            @elseif($query_law['table'] == 'sched')
                                            {{-- @foreach($query_law['search'] as $sched)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $section = App\Models\LawOfFedSection::where('law_of_federation_id', $sched->law_of_federation_id)->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $sched->law_of_federation_id)->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$section ? $section->section_header : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}" class="text-color">{{$section ? $section->section_header : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($section ? $section->section_body : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach --}}
                                            @foreach($query_law['search'] as $sched)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                // $sched = App\Models\LawOfFedSched::where('law_of_federation_id', $section ? $section->law_of_federation_id : '')->first();
                                                                $fed = App\Models\LawOfFederation::where('id', $sched ? $sched->law_of_federation_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$sched ? $sched->sched_header : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}" class="text-color">{{$sched ? $sched->sched_header : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($sched ? $sched->sched_body : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            {{-- @foreach($query_law['search'] as $sched)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $fed = App\Models\LawOfFederation::where('id', $sched ? $sched->law_of_federation_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$fed ? $fed->title : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}" class="text-color">{{$fed ? $fed->title : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($fed ? $fed->description : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $sched ? $sched->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach --}}
                                            @elseif($query_law['table'] == 'lfn')
                                            {{-- @foreach($query_law['search'] as $fed)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $section = App\Models\LawOfFedSection::where('law_of_federation_id', $fed ? $fed->id : '')->first();
                                                                // $fed = App\Models\LawOfFederation::where('id', $sched->law_of_federation_id)->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $fed ? $fed->id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$section ? $section->section_header : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-color">{{$section ? $section->section_header : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($section ? $section->section_body : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            @foreach($query_law['search'] as $fed)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            @php
                                                                $sched = App\Models\LawOfFedSched::where('law_of_federation_id', $fed ? $fed->id : '')->first();
                                                                // $fed = App\Models\LawOfFederation::where('id', $sched ? $sched->law_of_federation_id : '')->first();
                                                            @endphp
                                                            <a href="{{route('show.fed', $fed ? $fed->id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$sched ? $sched->sched_header : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-color">{{$sched ? $sched->sched_header : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($sched ? $sched->sched_body : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach --}}
                                            @foreach($query_law['search'] as $fed)
                                                <li class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto hide-mobile">
                                                            {{-- @php
                                                                $fed = App\Models\LawOfFederation::where('id', $sched ? $sched->law_of_federation_id : '')->first();
                                                            @endphp --}}
                                                            <a href="{{route('show.fed', $fed ? $fed->id : '')}}">
                                                                <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$fed ? $fed->title : ''}}" class="card-img-top w-8 h-8">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p class="card-text mb-4 item-name2">
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-color">{{$fed ? $fed->title : ''}}</a>
                                                            </p>
                                                            <p class="card-text mb-4">
                                                                {!! Str::words($fed ? $fed->description : '', 100) !!}
                                                            </p>
                                                            <p class="card-text small mb-3 text-muted">
                                                                {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                            </p>
                                                            <h4 class="mb-2 item-name3">
                                                                <a href="{{route('show.fed', $fed ? $fed->id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    @else
                                    <div class="text-center my-4">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="my-4 justify-content-center text-center">
                                    {{$query_law['search']->links()}}
                                </div>
                            </div>
                            {{-- <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rule" role="tabpanel" aria-labelledby="rule-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsL">
                            <div class="card-header">
                                <h4 class="card-header-title">Rules</h4>
                                <span>
                                    {{$query_rule['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query_rule_count)}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($query_rule['search']) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query_rule['search'] as $rule)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        <a href="{{route('show.rule', $rule->id)}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$rule ? $rule->title : ''}}" class="card-img-top w-8 h-8">
                                                        </a>
                                                        {{-- <i class="fe fe-file"></i> --}}
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.rule', $rule->id)}}">{{$rule ? $rule->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text text-color mb-4">
                                                            {{ucwords(strtolower($rule ? $rule->name : ''))}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                <div class="text-center">
                                    <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                </div>
                            @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="my-4 justify-content-center text-center">
                                    {{$query_rule['search']->links()}}
                                </div>
                            </div>
                            {{-- <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLi">
                            <div class="card-header">
                                <h4 class="card-header-title">Forms and Precedents</h4>
                                <span>
                                    {{$query_form['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search title">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query_form_count)}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($query_form['search']) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query_form['search'] as $form)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        <a href="{{route('show.form', $form->id)}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$form ? $form->title : ''}}" class="card-img-top w-8 h-8">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <p class="card-text mb-4 item-name">
                                                            {!! Str::words($form ? $form->content : '', 50) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$form ? $form->category : ''}}
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.form', $form->id)}}" class="text-primary">{{$form ? $form->title : ''}}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center my-4">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="my-4 justify-content-center text-center">
                                    {{$query_form['search']->links()}}
                                </div>
                            </div>
                            {{-- <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLi">
                            <div class="card-header">
                                <h4 class="card-header-title">Articles</h4>
                                <span>
                                    {{$query_article['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query_article_count)}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($query_article['search']) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query_article['search'] as $article)
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
                                                        <p class="card-text mb-4 item-name">
                                                            {!! Str::words($article ? $article->content : '', 50) !!}
                                                        </p>
                                                        <p class="small text-color mb-2">
                                                            @php
                                                                $user = App\Models\User::where('id', $article->user_id)->first();
                                                            @endphp
                                                            @if($article->article_type == 'legalpedia')
                                                                By Legalpedia
                                                                @else
                                                                <a href="{{route('user.profile', $user->id)}}" class="text-color">By {{$user->name}}</a>
                                                            @endif
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.article', $article->id)}}" class="text-primary">{{$article ? $article->title : ''}}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center my-4">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="my-4 justify-content-center text-center">
                                    {{$query_article['search']->links()}}
                                </div>
                            </div>
                            {{-- <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="note" role="tabpanel" aria-labelledby="note-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsL">
                            <div class="card-header">
                                <h4 class="card-header-title">
                                    Public Notes
                                </h4>
                                <span>
                                    {{$query_note['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query_note_count)}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($query_note['search']) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query_note['search'] as $note)
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
                                                            {{ucwords(strtolower($note->content->selector[0]->exact))}}
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
                                    <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                </div>
                            @endif
                            </div>
                            <div class="row align-items-center">
                                <div class="my-4 justify-content-center text-center">
                                    {{$query_note['search']->links()}}
                                </div>
                            </div>
                            {{-- <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        Next <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteYearFunction() {
            if(!confirm("Are you sure you want to delete this Judgement?"))
            event.preventDefault();
        }
        function deleteSubjectFunction() {
            if(!confirm("Are you sure you want to delete this Judgement?"))
            event.preventDefault();
        }
        function deleteLegalFunction() {
            if(!confirm("Are you sure you want to delete this Judgement?"))
            event.preventDefault();
        }
    </script>
@endsection
