@extends('layouts.admin.judgements')

@section('title')
    <title>Edit Judgement - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/judgements')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Edit Judgement
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
                        <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.judgement', $judgement_summary->id)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
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
                                    <input type="text" name="title" value="{{$judgement_summary->title}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Judgement Suit Number
                                    </label>
                                    <input type="text" name="suit_no" value="{{$judgement_summary->suit_no}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Lp Citation
                                    </label>
                                    <input type="text" name="lp_citation" value="{{$judgement_summary->lp_citation}}" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Court.
                                            </label>
                                            <select name="court_id" class="form-select form-control-flush mr-4" data-choices='{"searchEnabled": true}'>
                                                <?php $court = App\Models\Court::where('id', $judgement_summary->court_id)->first(); ?>
                                                <option value="{{$judgement_summary->court_id}}" selected>{{$court->court}}</option>
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
                                            <input type="text" name="judgement_date" class="form-control" value="{{$judgement_summary->judgement_date}}" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Summary of Facts
                                    </label>
                                    <textarea name="summary_of_facts" rows="5" placeholder="Enter summary">{{$judgement_summary->summary_of_facts}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Held
                                    </label>
                                    <textarea name="held" rows="5" placeholder="Enter Held">{{$judgement_summary->held}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Issues
                                    </label>
                                    <textarea name="issues" rows="5" placeholder="Enter Issues">{{$judgement_summary->issues}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Cases Cited
                                    </label>
                                    <textarea name="cases_cited" rows="5" placeholder="Enter Cases Cited">{{$judgement_summary->cases_cited}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Statutes Cited
                                    </label>
                                    <textarea name="statutes_cited" rows="5" placeholder="Enter Statutes Cited">{{$judgement_summary->statutes_cited}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Other Citations
                                    </label>
                                    <textarea name="other_citations" rows="5" placeholder="Enter Citations">{{$judgement_summary->other_citations}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Area of Law
                                    </label>
                                    <input type="text" name="area_of_law" class="form-control">
                                    <textarea name="area_of_law" rows="5" placeholder="Enter Area of Law">{{$judgement_summary->area_of_law}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select name="category" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                        <option value="{{$judgement_summary->category}}" selected>{{$judgement_summary->category}}</option>
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
                                    <input type="hidden" name="suit_no">
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
@endsection
