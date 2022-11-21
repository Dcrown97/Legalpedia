@extends('layouts.admin.judgements')

@section('title')
    <title>Judgements - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
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
                            Judgement
                        </h1>
                    </div>
                    <div class="col-auto">
                        @if (Auth::user()->role->name == 'Admin')
                            <a href="{{ route('judge.create') }}" class="btn text-white btn-primary mr-3">
                                <i class="fe fe-plus"></i> Add Judgement
                            </a>
                        @endif
                        <a href="#" class="custom-button text-color" style="border-bottom: 1px dotted !important"
                            data-bs-toggle="modal" data-bs-target="#send_report" id="kt_toolbar_primary_button">
                            <i class="fe fe-info"></i> Send a report?
                        </a>
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
                            <a class="nav-link active" href="{{ route('admin.judgement') }}">
                                Year Index
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('judgement.sbj-matter') }}">
                                Subject Matter Index
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('judgement.citation') }}">
                                Legalpedia Citation Index
                            </a>
                        </li>
                        @if (Auth::user()->role->name == 'Admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('judgement.no-summary') }}">
                                    Cases without Summary
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role->name == 'Admin')
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="wizardSteps">
                        <div class="card"
                            data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                            id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Year Index</h4>
                                <div class="row align-items-end justify-content-end">
                                    <form action="{{ route('admin.judgement') }}" method="GET" class="me-3 d-flex">
                                        <select name="id" class="form-select form-control-flush mr-4"
                                            data-choices='{"searchEnabled": true}'>
                                            <option value="">All Courts</option>
                                            @foreach ($courts as $court)
                                                <option value="{{ $court->id }}"
                                                    {{ $court->id == $selected_court['court_id'] ? 'selected' : '' }}>
                                                    {{ $court->court }}</option>
                                            @endforeach
                                        </select>
                                        <span class="ml-4"></span>
                                        <?php $years = range(1960, strftime('%Y', time())); ?>
                                        <select name="year" class="form-select form-control-flush mr-4"
                                            data-choices='{"searchEnabled": true}'>
                                            <option value="">All Years</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    {{ $year == $selected_year['judgement_date'] ? 'selected' : '' }}>
                                                    {{ $year }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" onclick="this.classList.toggle('button--loading')"
                                            class="ml-3 btn button_load text-white btn-sm btn-primary p-2">
                                            <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                        </button>
                                        <a href="{{ url('admin/judgements') }}"
                                            onclick="this.classList.toggle('button--loading')"
                                            class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
                                            <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form action="{{ route('admin.judgement') }}" method="GET" class="d-flex">
                                            <div
                                                class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <button id="search-btn"
                                                    class="btn button_load text-white btn-sm btn-primary p-2 px-3"
                                                    onclick="this.classList.toggle('button--loading')">
                                                    <span class="button__text">Search</span>
                                                </button>
                                                <input class="form-control list-search" type="text" name="search_case"
                                                    id="search-case" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{ number_format($judgement_count) }} records</h4>
                                    </div>
                                    <div class="col-auto">
                                        {{ $judgement_summaries->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (count($judgement_summaries) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach ($judgement_summaries as $judgement_summary)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a class="avatar text-color avatar-lg">
                                                            <img src="{{ asset('assets/images/nigerian-coat-of-arms.png') }}"
                                                                alt="{{ $judgement_summary->title }}"
                                                                class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <a
                                                                href="{{ route('show.judgement', $judgement_summary->id) }}">{{ $judgement_summary->title }}</a>
                                                        </h4>
                                                        <p class="card-text text-color small mb-1">
                                                            <?php $court = App\Models\Court::where('id', $judgement_summary ? $judgement_summary->court_id : '')->first(); ?>
                                                            {{ $court ? $court->court : '' }}
                                                        </p>
                                                        <p class="card-text small text-muted">
                                                            {{ \Carbon\Carbon::parse($judgement_summary->judgement_date)->format('D') }}
                                                            {{ \Carbon\Carbon::parse($judgement_summary->judgement_date)->toFormattedDateString() }}
                                                        </p>
                                                    </div>
                                                    @if (Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#"
                                                                    class="dropdown-ellipses dropdown-toggle"
                                                                    role="button" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{ route('edit.judgement', $judgement_summary->id) }}"
                                                                        class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form
                                                                        action="/admin/judgements/{{ $judgement_summary->id }}"
                                                                        method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit"
                                                                            onclick="return deleteYearFunction();"
                                                                            class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                    {{-- {{$judgement_summaries->appends(request()->all())->links()}} --}}
                                    {{ $judgement_summaries->links() }}
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
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="wizardSteps">
                        <div class="card"
                            data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'
                            id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Year Index</h4>
                                @if ($courts->judgement_feature)
                                    <div class="row align-items-end justify-content-end">
                                        <form action="{{ route('admin.judgement') }}" method="GET"
                                            class="me-3 d-flex">
                                            @php
                                                $all_courts = json_decode($courts->judg_court);
                                            @endphp
                                            @if ($all_courts)
                                                <select name="id" class="form-select form-control-flush mr-4"
                                                    data-choices='{"searchEnabled": true}'>
                                                    <option value="">All Courts</option>
                                                    @foreach ($all_courts as $court)
                                                        @php
                                                            $main_court = App\Models\Court::where('court', $court)->first();
                                                        @endphp
                                                        <option value="{{ $main_court->id }}"
                                                            {{ $main_court->id == $selected_court['court_id'] ? 'selected' : '' }}>
                                                            {{ $court }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            <span class="ml-4"></span>
                                            @php
                                                $single_year = $years->judg_single_year;
                                                $year_range = range($years->judg_start_year, $years->judg_end_year);
                                            @endphp
                                            @if ($years->judg_start_year && $years->judg_end_year)
                                                <select name="year" class="form-select form-control-flush mr-4"
                                                    data-choices='{"searchEnabled": true}'>
                                                    <option value="">All Years</option>
                                                    @foreach ($year_range as $year)
                                                        <option value="{{ $year }}"
                                                            {{ $year == $selected_year['judgement_date'] ? 'selected' : '' }}>
                                                            {{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif($single_year)
                                                <select name="year" class="form-select form-control-flush mr-4"
                                                    data-choices='{"searchEnabled": true}'>
                                                    <option value="">All Years</option>
                                                    @foreach ($single as $year)
                                                        <option value="{{ $year }}"
                                                            {{ $year == $selected_year['judgement_date'] ? 'selected' : '' }}>
                                                            {{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            <button type="submit" onclick="this.classList.toggle('button--loading')"
                                                class="ml-3 btn button_load text-white btn-sm btn-primary p-2">
                                                <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                            </button>
                                            <a href="{{ url('admin/judgements') }}"
                                                onclick="this.classList.toggle('button--loading')"
                                                class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
                                                <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                            </a>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form action="{{ route('admin.judgement') }}" method="GET" class="d-flex">
                                            <div
                                                class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <button id="search-btn"
                                                    class="btn button_load text-white btn-sm btn-primary p-2 px-3"
                                                    onclick="this.classList.toggle('button--loading')">
                                                    <span class="button__text">Search</span>
                                                </button>
                                                <input class="form-control list-search" type="text" name="search_case"
                                                    id="search-case" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- <div class="col-auto me-n3">
                                        <h4>{{number_format($judgement_count)}} records</h4>
                                    </div> --}}
                                    <div class="col-auto">
                                        {{ $judgement_summaries->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (count($judgement_summaries) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach ($judgement_summaries as $judgement_summary)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a class="avatar text-color avatar-lg">
                                                            <img src="{{ asset('assets/images/nigerian-coat-of-arms.png') }}"
                                                                alt="{{ $judgement_summary->title }}"
                                                                class="card-img-top">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <a
                                                                href="{{ route('show.judgement', $judgement_summary->id) }}">{{ $judgement_summary->title }}</a>
                                                        </h4>
                                                        <p class="card-text text-color small mb-1">
                                                            <?php $court = App\Models\Court::where('id', $judgement_summary->court_id)->first(); ?>
                                                            @if ($court)
                                                                {{ $court->court }}
                                                            @else
                                                                In the Court of Appeal
                                                            @endif
                                                        </p>
                                                        <p class="card-text small text-muted">
                                                            {{ \Carbon\Carbon::parse($judgement_summary->judgement_date)->format('D') }}
                                                            {{ \Carbon\Carbon::parse($judgement_summary->judgement_date)->toFormattedDateString() }}
                                                        </p>
                                                    </div>
                                                    @if (Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#"
                                                                    class="dropdown-ellipses dropdown-toggle"
                                                                    role="button" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{ route('edit.judgement', $judgement_summary->id) }}"
                                                                        class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form
                                                                        action="/admin/judgements/{{ $judgement_summary->id }}"
                                                                        method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit"
                                                                            onclick="return deleteYearFunction();"
                                                                            class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                    {{ $judgement_summaries->links() }}
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
    @endif
    <script>
        function deleteYearFunction() {
            if (!confirm("Are you sure you want to delete this Judgement?"))
                event.preventDefault();
        }

        function deleteSubjectFunction() {
            if (!confirm("Are you sure you want to delete this Judgement?"))
                event.preventDefault();
        }

        function deleteLegalFunction() {
            if (!confirm("Are you sure you want to delete this Judgement?"))
                event.preventDefault();
        }
    </script>
@endsection
