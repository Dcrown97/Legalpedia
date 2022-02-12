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
                        @if(Auth::user()->role->name == 'Admin')
                            <a href="{{route('judge.create')}}" class="btn text-white btn-primary mr-3">
                                <i class="fe fe-plus"></i> Add Judgement
                            </a>
                        @endif
                        <a href="#" class="custom-button text-color" style="border-bottom: 1px dotted !important" data-bs-toggle="modal" data-bs-target="#send_report" id="kt_toolbar_primary_button">
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
                        <a class="nav-link" href="{{route('admin.judgement')}}">
                            Year Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('judgement.sbj-matter')}}">
                            Subject Matter Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{route('judgement.citation')}}">
                            Legalpedia Citation Index
                        </a>
                    </li>
                    @if(Auth::user()->role->name == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link"  href="{{route('judgement.no-summary')}}">
                                Cases without Summary
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="wizardSteps">
                    <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                        <div class="card-header">
                            <h4 class="card-header-title">Subject Matter Index</h4>
                            <div class="row align-items-end justify-content-end">
                                <form action="{{route('judgement.sbj-matter')}}" method="GET" class="me-3 d-flex">
                                    <select name="subject_matter_index" class="form-select form-control-flush mr-4" data-choices='{"searchEnabled": true}'>
                                        <option value="">All Subject Matter</option>
                                        @foreach($subject_matter_indices as $subject_matter_index)
                                            <option value="{{$subject_matter_index->subject_matter_index}}" {{ $subject_matter_index->subject_matter_index == $selected_subject_matter['subject_matter_index'] ? 'selected' : '' }}>{{$subject_matter_index->subject_matter_index}}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" onclick="this.classList.toggle('button--loading')" class="ml-3 btn button_load text-white btn-sm btn-primary p-2">
                                        <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                    </button>
                                    <a href="{{url('admin/judgements/subject-matter')}}" onclick="this.classList.toggle('button--loading')" class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
                                        <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                    </a>
                                </form>
                            </div>
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
                                @if(Auth::user()->role->name == 'Admin')
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($judgement_count)}} records</h4>
                                    </div>
                                @endif
                                <div class="col-auto">
                                    {{$judgement_summaries->links()}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($judgement_summaries) > 0)
                                <ul class="list-group list-group-lg list-group-flush list my-n4">
                                    @foreach($judgement_summaries as $judgement_summary)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    @php
                                                        $judgement_sum  = App\Models\JudgementSummary::where('suit_no', $judgement_summary->suit_no)->first();
                                                    @endphp
                                                    <a class="avatar text-color avatar-lg">
                                                        <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" alt="{{$judgement_sum ? $judgement_sum->title : ''}}" class="card-img-top">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <h4 class="mb-1 item-name">
                                                        <a href="{{route('show.judgement', $judgement_sum ? $judgement_sum->id : '')}}">{{$judgement_sum ? $judgement_sum->title : ''}}</a>
                                                    </h4>
                                                    <p class="card-text text-color small mb-1">
                                                        @php
                                                            $judg_principle = App\Models\JudgementPrinciple::where('suit_no', $judgement_summary->suit_no)->first();
                                                            $principle = App\Models\Principle::where('id', $judg_principle->principle_id)->first();
                                                            $sbj = App\Models\SubjectMatterIndex::where('id', $principle ? $principle->subject_matter_index_id : '')->first();
                                                        @endphp
                                                        {{$sbj ? $sbj->subject_matter_index : ''}}
                                                    </p>
                                                    <p class="card-text small text-muted">
                                                        {{\Carbon\Carbon::parse($judgement_sum ? $judgement_sum->judgement_date : '')->format('D')}}  {{\Carbon\Carbon::parse($judgement_sum ? $judgement_sum->judgement_date : '')->toFormattedDateString()}}
                                                    </p>
                                                </div>
                                                @if(Auth::user()->role->name == 'Admin')
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="{{route('edit.judgement', $judgement_sum ? $judgement_sum->id : '')}}" class="dropdown-item">
                                                                    <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                </a>
                                                                <form action="/admin/judgements/{{$judgement_sum ? $judgement_sum->id : ''}}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" name="submit" onclick="return deleteSubjectFunction();" class="dropdown-item">
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
                                {{$judgement_summaries->links()}}
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
