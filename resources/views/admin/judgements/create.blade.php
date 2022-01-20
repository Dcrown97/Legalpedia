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
                                        Court.
                                    </label>
                                    <select name="court_id" class="form-select" id="selected-court" data-choices='{"searchEnabled": true}'>
                                        @foreach($courts as $court)
                                            <option value="{{$court->id}}">{{$court->court}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                <div class="row">
                                                    <div class="col">
                                                        <span>
                                                            Lp Citation
                                                        </span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <small class="text-muted">
                                                            <a onclick="genCode(5)" class="custom-button cursor text-color"> Generate Citation Number</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </label>
                                            <input type="text" name="lp_citation" id="lp_cite" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Judgement Date.
                                            </label>
                                            <input type="text" name="judgement_date" class="form-control" placeholder="<?php echo date('Y-m-d');?>" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Holden At
                                    </label>
                                    <input type="text" name="holden_at" class="form-control" placeholder="Holden at Abuja">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party A Type
                                    </label>
                                    <select name="party_a_type" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <option value="">Select Party A Type</option>
                                        @foreach($party_a_types as $party_a_type)
                                            <option value="{{$party_a_type->id}}">{{$party_a_type->party_a_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party B Type
                                    </label>
                                    <select name="party_b_type" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <option value="">Select Party B Type</option>
                                        @foreach($party_b_types as $party_b_type)
                                            <option value="{{$party_b_type->id}}">{{$party_b_type->party_b_type}}</option>
                                        @endforeach
                                    </select>
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
                                    <textarea name="area_of_law" rows="5" class="form-control" placeholder="Enter Area(s) of Law"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
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
                                        <h6 class="text-uppercase text-muted mb-0">Step 1 of 4</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepTwo">Continue</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel" aria-labelledby="wizardTabTwo">
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <h1 class="mb-3">Subject Matter Index, Principles, Corams, Counsels and Party names</h1>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Subject Matter Index
                                    </label>
                                    <select name="subject_matter_index" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <option value="">Select Subject Matter Index</option>
                                        @foreach($subject_matters as $subject_matter)
                                            <option value="{{$subject_matter->id}}">{{$subject_matter->subject_matter_index}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Principles
                                    </label>
                                    <textarea name="principle" rows="5" class="form-control" placeholder="Enter Principle"></textarea>
                                </div>
                                <hr class="my-5">
                                <div class="add_more">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            1. Coram
                                        </label>
                                        <input type="text" name="coram[0][]" class="form-control">
                                    </div>
                                </div>
                                <div id="add_field"></div>
                                <div class="justify-content-end">
                                    <a type="button" id="more_fields" class="text-color" onclick="addFields()"><i class="mdi mdi-plus"></i> Add Coram</a>
                                </div>
                                <hr class="my-5">
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
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Counsels
                                    </label>
                                    <textarea name="counsels" rows="5" class="form-control" placeholder="Enter names"></textarea>
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
                                        <h1 class="mb-3">Judgement Ratios</h1>
                                    </div>
                                </div>
                                <div class="add_more">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            1. Ratio Header
                                        </label>
                                        <input type="text" name="ratio[0][]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Ratio Body
                                        </label>
                                        <textarea name="ratio[0][]" rows="5" class="form-control"></textarea>
                                    </div>

                                </div>
                                <div id="add_ratio"></div>
                                <div class="justify-content-end">
                                    <a type="button" id="more_ratio" class="text-color" onclick="addRatio()"><i class="mdi mdi-plus"></i> Add Ratio</a>
                                </div>
                                <hr class="my-5">
                                <div class="nav row align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 3 of 4</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepFour">Next <i class="mdi mdi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="wizardStepFour" role="tabpanel" aria-labelledby="wizardTabFour">
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
                                        <a class="btn btn-white" data-toggle="wizard" href="#wizardStepThree">Back</a>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 4 of 4</h6>
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
            '. Coram</label><input type="text" name="coram['+ coram_no +'][]" class="form-control"></div>';
            objTo.appendChild(divcreate);
        }

        var ratio_no = 1;
        function addRatio() {
            ratio_no++;
            var objTo = document.getElementById('add_ratio')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + ratio_no +
            '. Ratio Header</label><input type="text" name="ratio['+ ratio_no +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Ratio Body</label> <textarea class="form-control" name="ratio['+ ratio_no +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
        }

        function genCode(length) {
            var result = '';
            var characters = '0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $(document).ready(function () {
                toggleFields();
                $("#selected-court").change(function () {
                    toggleFields();
                });

            });
            function toggleFields() {
                var court =  $("#selected-court option:selected").text();
                if(court == 'In the Court of Appeal') {
                    var court_abbr = 'CA';
                }else
                if(court == 'In the Federal High Court') {
                    var court_abbr = 'FHC';
                }
                if(court == 'In the Investments and Securities Tribunal') {
                    var court_abbr = 'IST';
                }else
                if(court == 'In the National Industrial Court of Nigeria') {
                    var court_abbr = 'NIC';
                }else
                if(court == 'In the Sharia Court') {
                    var court_abbr = 'SC';
                }else
                if(court == 'In the Supreme Court of Nigeria') {
                    var court_abbr = 'SC';
                }
                var lp_citation = "(<?php echo date('Y-m') ?>) Legalpedia " + result +" ("+ court_abbr +")";
                document.getElementById('lp_cite').value = lp_citation;
            }
        }
    </script>
@endsection
