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
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('judge.create')}}" class="btn text-white btn-primary" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Judgement
                            </a>
                            {{-- <a href="{{route('create.judgement')}}" class="btn text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add Judgement
                            </a> --}}
                        </div>
                    @endif
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
                        <a class="nav-link active" href="{{route('admin.judgement')}}">
                            Year Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('judgement.sbj-matter')}}">
                            Subject Matter Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{route('judgement.citation')}}">
                            Legalpedia Citation Index
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
                    <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                        <div class="card-header">
                            <h4 class="card-header-title">Year Index</h4>
                            <div class="row align-items-end justify-content-end">
                                <form action="{{route('admin.judgement')}}" method="GET" class="me-3 d-flex">
                                    <select name="id" class="form-select form-control-flush mr-4" data-choices='{"searchEnabled": true}'>
                                        @foreach($courts as $court)
                                            <option value="{{$court->id}}" {{ $court->id == $selected_court['court_id'] ? 'selected' : '' }}>{{$court->court}}</option>
                                        @endforeach
                                    </select>
                                    <span class="ml-4"></span>
                                    <?php $years = range(1960, strftime("%Y", time())); ?>
                                    <select name="year" class="form-select form-control-flush mr-4" data-choices='{"searchEnabled": true}'>
                                        @foreach($years as $year)
                                            <option value="{{$year}}" {{ $year == $selected_year['judgement_date'] ? 'selected' : '' }}>{{$year}}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" name="fetch_year" onclick="this.classList.toggle('button--loading')" class="ml-3 btn button_load text-white btn-sm btn-primary p-2">
                                        <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                    </button>
                                    <a href="{{url('admin/judgements')}}" onclick="this.classList.toggle('button--loading')" class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
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
                                            <input class="form-control list-search" type="search" placeholder="Search">
                                            <span class="input-group-text">
                                                <i class="fe fe-search"></i>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto me-n3">
                                    <h4>{{$judgement_count}} records</h4>
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
                                                    <a href="#!" class="avatar text-color avatar-lg">
                                                        <i class="fe fe-file"></i>
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <h4 class="mb-1 item-name">
                                                        <a href="{{route('show.judgement', $judgement_summary->id)}}">{{$judgement_summary->title}}</a>
                                                    </h4>
                                                    <p class="card-text text-color small mb-1">
                                                        <?php $court = App\Models\Court::where('id', $judgement_summary->court_id)->first();?>
                                                        @if($court)
                                                            {{$court->court}}
                                                            @else
                                                            In the Court of Appeal
                                                        @endif
                                                    </p>
                                                    <p class="card-text small text-muted">
                                                        {{\Carbon\Carbon::parse($judgement_summary->judgement_date)->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary->judgement_date)->toFormattedDateString()}}
                                                    </p>
                                                </div>
                                                @if(Auth::user()->role->name == 'Admin')
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="{{route('edit.judgement', $judgement_summary->id)}}" class="dropdown-item">
                                                                    <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                </a>
                                                                <form action="/admin/judgements/{{$judgement_summary->id}}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" name="submit" onclick="return deleteYearFunction();" class="dropdown-item">
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Create Judgement</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('store.judgement')}}" method="POST">
                                @csrf
                                <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel" aria-labelledby="wizardTabOne">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Judgement Summary</h1>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Judgement title
                                        </label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Lp Citation
                                        </label>
                                        <input type="text" name="lp_citation" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Court.
                                                </label>
                                                <select name="court_id" class="form-select form-control-flush mr-4" data-choices='{"searchEnabled": true}'>
                                                    @foreach($courts as $court)
                                                        <option value="{{$court->id}}">{{$court->court}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Judgement Date.
                                                </label>
                                                <input type="text" name="law_no" class="form-control" data-flatpickr>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Summary of Facts
                                        </label>
                                        <textarea name="summary_of_facts" rows="5" placeholder="Enter summary"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Held
                                        </label>
                                        <textarea name="held" rows="5" placeholder="Enter Held"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Issues
                                        </label>
                                        <textarea name="issues" rows="5" placeholder="Enter Issues"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Cases Cited
                                        </label>
                                        <textarea name="cases_cited" rows="5" placeholder="Enter Cases Cited"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Statuses Cited
                                        </label>
                                        <textarea name="statuses_cited" rows="5" placeholder="Enter Statuses Cited"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="category" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="area_of_law" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <button class="btn btn-white" type="reset">Cancel</button>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 1 of 3</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepTwo">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel" aria-labelledby="wizardTabTwo">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Corams, Counsels and Party</h1>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Corams
                                        </label>
                                        <input type="hidden" name="law_of_federation_id">
                                        <input type="hidden" name="law_of_fed_part_id">
                                        <textarea name="name" rows="5" placeholder="Enter Corams"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Counsels
                                        </label>
                                        <textarea name="counsels" rows="5" placeholder="Enter Counsels"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Party A Names
                                        </label>
                                        <textarea name="party_a_names" rows="5" placeholder="Enter names"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Party B Names
                                        </label>
                                        <textarea name="party_b_names" rows="5" placeholder="Enter names"></textarea>
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <a class="btn btn-white" data-toggle="wizard" href="#wizardStepOne">Back</a>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 2 of 3</h6>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepThree">Next <i class="mdi mdi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wizardStepThree" role="tabpanel" aria-labelledby="wizardTabThree">
                                    <div class="row justify-content-center">
                                        <div class="text-center">
                                            <h1 class="mb-3">Full Judgement</h1>
                                        </div>
                                    </div>
                                    <div class="add_more">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Add full Judgement
                                            </label>
                                            <textarea name="judgement" rows="5" placeholder=""></textarea>
                                        </div>
                                    </div>
                                    <hr class="my-5">
                                    <div class="nav row align-items-center">
                                        <div class="col-auto">
                                            <a class="btn btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>
                                        </div>
                                        <div class="col text-center">
                                            <h6 class="text-uppercase text-muted mb-0">Step 3 of 3</h6>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                                <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                            </button>
                                        </div>
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
