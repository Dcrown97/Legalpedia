@extends('layouts.admin.judgements')

@section('title')
    <title>Search results - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }
        @media screen and (min-width: 200px) and (max-width: 767px) {
            .hide-mobile {
                display: none;
            }
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
                        <a class="nav-link active" id="judg-tab" data-toggle="tab" href="#judg" role="tab" aria-controls="judg" aria-selected="true">
                            Judgements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="law-tab" data-toggle="tab" href="#law" role="tab" aria-controls="law" aria-selected="false">
                            Laws of Federation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rule-tab" data-toggle="tab" href="#rule" role="tab" aria-controls="legal" aria-selected="false">
                            Rules
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="legal" aria-selected="false">
                            Forms and Precedents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="article-tab" data-toggle="tab" href="#article" role="tab" aria-controls="article" aria-selected="false">
                            Articles
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
                    <div class="tab-pane fade show active" id="judg" role="tabpanel" aria-labelledby="judg-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Judgements</h4>
                                <span>
                                    {{$query['search']->links()}}
                                </span>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($query['count'])}} results found</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($query['search'])
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $case)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$case->heading}}" class="card-img-top">
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
                                                        <h4 class="mb-1 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        @foreach($query['search'] as $case)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top">
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
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        @foreach($query['search'] as $case)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                            $judgement = App\Models\Judgement::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first();

                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top">
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
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-primary">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
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
                                    {{$query['search']->links()}}
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
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLis">
                            <div class="card-header">
                                <h4 class="card-header-title">Law of Federation</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        {{-- <h4>{{number_format($query_law['count'])}} results found</h4> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($query_law['search'])
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query_law['search'] as $section)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            // $section = App\Models\LawOfedSection::where('law_of_federation_id', $sched->law_of_federation_id)->first();
                                                            $fed = App\Models\LawOfFederation::where('id', $section->law_of_federation_id)->first();
                                                        @endphp
                                                        <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}">
                                                            <img src="{{asset('assets/images/gavel.png')}}" alt="{{$section ? $section->section_header : ''}}" class="card-img-top w-4 h-8">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <p class="card-text mb-4 item-name">
                                                            <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-color">{{$section ? $section->section_header : ''}}</a>
                                                        </p>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($section ? $section->section_body : '', 100) !!}
                                                        </p>
                                                        <p class="card-text small mb-3 text-muted">
                                                            {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->format('D')}}  {{\Carbon\Carbon::parse($fed ? $fed->law_date : '')->toFormattedDateString()}}
                                                        </p>
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.fed', $section ? $section->law_of_federation_id : '')}}" class="text-primary">{{$fed ? $fed->title : ''}}</a>
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
                                    {{$query['search']->links()}}
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
                    {{-- <div class="tab-pane fade" id="rule" role="tabpanel" aria-labelledby="rule-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLi">
                            <div class="card-header">
                                <h4 class="card-header-title">Year Index</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        @if($query['table'] == 'ratio')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                            @elseif($query['table'] == 'judgement_summary')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                            @elseif($query['table'] == 'judgement')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($query['table'] == 'ratio')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $case)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$case->heading}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-1">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">{{$case->heading}}</a>
                                                        </p>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($case->body, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif($query['table'] == 'judgement_summary')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $judgement_summary)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary->title}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($judgement_summary->summary_of_facts, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif($query['table'] == 'judgement')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $judgement)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $judgement ? $judgement->suit_no : '')->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($judgement->judgement, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
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
                            <div class="row g-0">
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
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLi">
                            <div class="card-header">
                                <h4 class="card-header-title">Year Index</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        @if($query['table'] == 'ratio')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                            @elseif($query['table'] == 'judgement_summary')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                            @elseif($query['table'] == 'judgement')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($query['table'] == 'ratio')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $case)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$case->heading}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-1">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">{{$case->heading}}</a>
                                                        </p>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($case->body, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif($query['table'] == 'judgement_summary')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $judgement_summary)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary->title}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($judgement_summary->summary_of_facts, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif($query['table'] == 'judgement')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $judgement)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $judgement ? $judgement->suit_no : '')->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($judgement->judgement, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
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
                            <div class="row g-0">
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
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLi">
                            <div class="card-header">
                                <h4 class="card-header-title">Year Index</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        @if($query['table'] == 'ratio')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                            @elseif($query['table'] == 'judgement_summary')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                            @elseif($query['table'] == 'judgement')
                                            <h4>{{number_format($query['search']->count())}} results found</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($query['table'] == 'ratio')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $case)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $case->suit_no)->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$case->heading}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-1">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">{{$case->heading}}</a>
                                                        </p>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($case->body, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif($query['table'] == 'judgement_summary')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $judgement_summary)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary->title}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($judgement_summary->summary_of_facts, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @elseif($query['table'] == 'judgement')
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($query['search'] as $judgement)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto hide-mobile">
                                                        @php
                                                            $judgement_summary = App\Models\JudgementSummary::where('suit_no', $judgement ? $judgement->suit_no : '')->first();
                                                            $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first();
                                                        @endphp
                                                        <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}">
                                                            <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_summary ? $judgement_summary->title : ''}}" class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-2 item-name">
                                                            <a href="{{route('show.judgement', $judgement_summary ? $judgement_summary->id : '')}}" class="text-color">{{$judgement_summary ? $judgement_summary->title : ''}}</a>
                                                        </h4>
                                                        <p class="card-text mb-4">
                                                            {!! Str::words($judgement->judgement, 100) !!}
                                                        </p>
                                                        <p class="card-text mb-1 text-color">
                                                            {{$court ? $court->court : ''}}
                                                        </p>
                                                        <p class="card-text small mb-1 text-muted">
                                                            {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary ? $judgement_summary->judgement_date : '')->toFormattedDateString()}}
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
                            <div class="row g-0">
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
                            </div>
                        </div>
                    </div> --}}
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
