@extends('layouts.admin.judgements')

@section('title')
    <title>Create new Judgement - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/judgements')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Create new Judgement
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
                    <div class="card-body p-5">
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
                                        Judgement Suit Number
                                    </label>
                                    <input type="text" name="suit_no" class="form-control">
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
                                            <input type="text" name="judgement_date" class="form-control" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Summary of Facts
                                    </label>
                                    <textarea name="summary_of_facts" rows="5" class="form-control" placeholder="Enter summary"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Held
                                    </label>
                                    <textarea name="held" rows="5" class="form-control" placeholder="Enter Held"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Issues
                                    </label>
                                    <textarea name="issues" rows="5" class="form-control" placeholder="Enter Issues"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Cases Cited
                                    </label>
                                    <textarea name="cases_cited" rows="5" class="form-control" placeholder="Enter Cases Cited"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Statutes Cited
                                    </label>
                                    <textarea name="statutes_cited" rows="5" class="form-control" placeholder="Enter Statutes Cited"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Other Citations
                                    </label>
                                    <textarea name="other_citations" rows="5" class="form-control" placeholder="Enter Citations"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Area of Law
                                    </label>
                                    <textarea name="area_of_law" rows="5" class="form-control" placeholder="Enter Area of Law"></textarea>
                                </div>
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
                                    <input type="hidden" name="judgement_coram_suit_no">
                                    {{-- <input type="hidden" name="law_of_fed_part_id"> --}}
                                    {{-- <input type="text" name="name" class="form-control"> --}}
                                    <textarea name="name" rows="5" class="form-control" placeholder="Enter Corams"></textarea>
                                </div>
                                {{-- <hr class="my-5"> --}}
                                {{-- <div id="add_field"></div>
                                <div class="justify-content-end my-5">
                                    <a type="button" id="more_fields" class="text-color" onclick="addFields()"><i class="mdi mdi-plus"></i> Add Coram</a>
                                </div> --}}
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Counsels
                                    </label>
                                    <textarea name="counsels" rows="5" class="form-control" placeholder="Enter Counsels"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party A Names
                                    </label>
                                    <textarea name="party_a_names" rows="5" class="form-control" placeholder="Enter names"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party B Names
                                    </label>
                                    <textarea name="party_b_names" rows="5" class="form-control" placeholder="Enter names"></textarea>
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
                                        <textarea name="judgement" class="form-control" rows="5" placeholder=""></textarea>
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
    <script>
        var coram_no = 1;
        function addFields() {
            coram_no++;
            var objTo = document.getElementById('add_field')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + coram_no +
            '. Coram</label><input type="text" name="name" class="form-control"></div>';
            objTo.appendChild(divcreate);
        }
    </script>
@endsection
