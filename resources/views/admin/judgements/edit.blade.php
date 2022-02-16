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
                                        Court.
                                    </label>
                                    <select name="court_id" id="selected-court" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <?php $court = App\Models\Court::where('id', $judgement_summary->court_id)->first(); ?>
                                        <option value="{{$judgement_summary->court_id}}" selected>{{$court->court}}</option>
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
                                            <input type="text" name="lp_citation" id="lp_cite" value="{{$judgement_summary->lp_citation}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Judgement Date.
                                            </label>
                                            {{-- @php
                                                // $judgement_date = (\Carbon\Carbon::parse($judgement_summary->judgement_date)->format('D')) .(  \Carbon\Carbon::parse($judgement_summary->judgement_date)->toFormattedDateString());
                                                $date = \Carbon\Carbon::parse($judgement_summary->judgement_date);
                                                $judg_date = $date->isoFormat('dddd Do MMMM YYYY');
                                                // dd()
                                            @endphp
                                            {{$judg_date}} --}}
                                            <input type="text" name="judgement_date" class="form-control" value="{{$judgement_summary->judgement_date}}" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Holden At
                                    </label>
                                    @php
                                        $holden = App\Models\Holden::where('id', $judgement_summary ? $judgement_summary->holden_at_id : '')->first();
                                    @endphp
                                    <input type="text" name="holden_at" class="form-control" placeholder="Holden at Abuja" value="{{$holden ? $holden->holden_at : ''}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party A Type
                                    </label>
                                    <select name="party_a_type" class="form-select" data-choices='{"searchEnabled": true}'>
                                        @php
                                            $party_a = App\Models\PartyAType::where('id', $judgement_summary ? $judgement_summary->party_a_type_id : '')->first();
                                        @endphp
                                        <option value="{{$party_a ? $party_a->id : ''}}" selected>{{$party_a ? $party_a->party_a_type : 'Select Part A Type'}}</option>
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
                                        @php
                                            $party_b = App\Models\PartyBType::where('id', $judgement_summary ? $judgement_summary->party_b_type_id : '')->first();
                                        @endphp
                                        <option value="{{$party_b ? $party_b->id : ''}}" selected>{{$party_b ? $party_b->party_b_type : 'Select Part B Type'}}</option>
                                        @foreach($party_b_types as $party_b_type)
                                            <option value="{{$party_b_type->id}}">{{$party_b_type->party_b_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Summary of Facts
                                    </label>
                                    <textarea name="summary_of_facts" rows="5" class="form-control" placeholder="Enter summary">{{$judgement_summary->summary_of_facts}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Held
                                    </label>
                                    <textarea name="held" rows="5" class="form-control" placeholder="Enter Held">{{$judgement_summary->held}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Issues
                                    </label>
                                    <textarea name="issues" rows="5" class="form-control" placeholder="Enter Issues">{{$judgement_summary->issues}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Cases Cited
                                    </label>
                                    <textarea name="cases_cited" rows="5" class="form-control" placeholder="Enter Cases Cited">{{$judgement_summary->cases_cited}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Statutes Cited
                                    </label>
                                    <textarea name="statutes_cited" rows="5" class="form-control" placeholder="Enter Statutes Cited">{{$judgement_summary->statutes_cited}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Other Citations
                                    </label>
                                    <textarea name="other_citations" rows="5" class="form-control" placeholder="Enter Citations">{{$judgement_summary->other_citations}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Area of Law
                                    </label>
                                    <textarea name="area_of_law" rows="5" class="form-control" placeholder="Enter Area of Law">{{$judgement_summary->area_of_law}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <option value="{{$judgement_summary ? $judgement_summary->category : ''}}" selected>{{$judgement_summary ? $judgement_summary->category : 'Select Category'}}</option>
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
                                @php
                                    $judg_principles = App\Models\JudgementPrinciple::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->get();
                                    $principle_count = $judg_principles->count();
                                @endphp
                                @if($judg_principles)
                                    @php
                                        $principle_no = 1;
                                    @endphp
                                    @foreach($judg_principles as $judg_principle)
                                        @php
                                            $principle = App\Models\Principle::where('id', $judg_principle ? $judg_principle->principle_id : '')->first();
                                        @endphp
                                        <div class="add_more">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    {{$principle_no}}. Subject Matter Index
                                                    @php
                                                        $principle_no++;
                                                    @endphp
                                                </label>
                                                @php
                                                    $subject = App\Models\SubjectMatterIndex::where('id', $principle ? $principle->subject_matter_index_id : '')->first();
                                                @endphp
                                                <select name="subject[{{$judg_principle->id}}][]" class="form-select" data-choices='{"searchEnabled": true}'>
                                                    <option value="{{$principle ?  $principle->subject_matter_index_id : ''}}">{{$subject ? $subject->subject_matter_index : ''}}</option>
                                                    @foreach($subject_matters as $subject_matter)
                                                        <option value="{{$subject_matter->id}}">{{$subject_matter->subject_matter_index}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Principles
                                                </label>
                                                <textarea name="subject[{{$judg_principle->id}}][]" rows="5" class="form-control" placeholder="Enter Principle">{{$principle ? $principle->principle : ''}}</textarea>
                                            </div>
                                            <div class="form-roup mb-4">
                                                <div class="justify-content-end">
                                                    <input type="hidden" name="principle_id" value="{{$principle ? $principle->id : ''}}">
                                                    <input type="hidden" name="judg_principle_id" value="{{$judg_principle ? $judg_principle->id : ''}}">
                                                    <button type="submit" name="remove_principle" class="text-color custom-button"><i class="mdi mdi-close"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div id="add_sub"></div>
                                <div class="justify-content-end">
                                    <a type="button" id="more_subs" class="text-color" onclick="addSubs()"><i class="mdi mdi-plus"></i> Add Subject matter and principle</a>
                                </div>
                                <hr class="my-5">
                                @php
                                    $judg_corams = App\Models\JudgementCoram::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->get();
                                    $coram_count = $judg_corams->count();
                                @endphp
                                @if($judg_corams)
                                    @php
                                        $coram_no = 1;
                                    @endphp
                                    @foreach($judg_corams as $coram)
                                        <div class="add_more">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    {{$coram_no}}. Coram
                                                    @php
                                                        $coram_no++;
                                                    @endphp
                                                </label>
                                                <input type="hidden" name="coram[{{$judgement_summary->id}}][]" class="form-control" value="{{$coram->id}}">
                                                @php
                                                    $main_coram = App\Models\Coram::where('id', $coram->coram_id)->first();
                                                @endphp
                                                <input type="text" name="coram[{{$judgement_summary->id}}][]" class="form-control" value="{{$main_coram ? $main_coram->name : ''}}">
                                            </div>
                                            <div class="form-roup mb-4">
                                                <div class="justify-content-end">
                                                    <input type="hidden" name="judg_coram_id" value="{{$coram->id}}">
                                                    <input type="hidden" name="coram_id" value="{{$main_coram ? $main_coram->id : ''}}">
                                                    <button type="submit" name="remove_coram" class="text-color custom-button"><i class="mdi mdi-close"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div id="add_field"></div>
                                <div class="justify-content-end">
                                    <a type="button" id="more_fields" class="text-color" onclick="addFields()"><i class="mdi mdi-plus"></i> Add Coram</a>
                                </div>
                                <hr class="my-5">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party A Names
                                    </label>
                                    @php
                                        $party_a_name = App\Models\JudgementPartyA::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first();
                                    @endphp
                                    <input type="hidden" name="party_a_name_id" value="{{$party_a_name ? $party_a_name->id : null}}">
                                    <textarea name="party_a_names" rows="5" class="form-control" placeholder="Enter names">{{$party_a_name ? $party_a_name->party_a_names : ''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Party B Names
                                    </label>
                                    @php
                                        $party_b_name = App\Models\JudgementPartyB::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first();
                                    @endphp
                                    <input type="hidden" name="party_b_name_id" value="{{$party_b_name ? $party_b_name->id : null}}">
                                    <textarea name="party_b_names" rows="5" class="form-control" placeholder="Enter names">{{$party_b_name ? $party_b_name->party_b_names : ''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Councel
                                    </label>
                                    @php
                                        $counsel = App\Models\JudgementCounsel::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first();
                                    @endphp
                                    <input type="hidden" name="counsel_id" value="{{$counsel ? $counsel->id : null}}">
                                    <textarea name="counsels" rows="5" class="form-control" placeholder="Enter Councel">{{$counsel ? $counsel->counsels : ''}}</textarea>
                                </div>
                                <hr class="my-5">
                                <div class="nav row align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-white" data-toggle="wizard" href="#wizardStepOne">Back</a>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 2 of 4</h6>
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
                                @php
                                    $ratios = App\Models\SummaryRatio::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->get();
                                    $ratio_count = $ratios->count();
                                @endphp
                                @if($ratios)
                                    @php
                                        $ratio_no = 1;
                                    @endphp
                                    @foreach($ratios as $ratio)
                                        <div class="add_more">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    {{$ratio_no}}. Ratio Header
                                                    @php
                                                        $ratio_no++;
                                                    @endphp
                                                </label>
                                                <input type="text" name="ratio[{{$ratio->id}}][]" class="form-control" value="{{$ratio->heading}}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Ratio Body
                                                </label>
                                                <input type="hidden" name="ratio_id" value="{{$ratio->id}}">
                                                <textarea name="ratio[{{$ratio->id}}][]" rows="5" class="form-control">{{$ratio->body}}</textarea>
                                            </div>
                                            <div class="form-roup mb-4">
                                                <div class="justify-content-end">
                                                    <input type="hidden" name="ratio_id" value="{{$ratio->id}}">
                                                    <button type="submit" name="remove_ratio" class="text-color custom-button"><i class="mdi mdi-close"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
                                            Judgement
                                        </label>
                                        @php
                                            $judgement = App\Models\Judgement::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first();
                                        @endphp
                                        <input type="hidden" name="judgement_id" value="{{$judgement ? $judgement->id : null}}">
                                        <textarea name="judgement" rows="5" class="form-control" placeholder="">{{$judgement ? $judgement->judgement : ''}}</textarea>
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
        function initMCEall(){
            tinymce.init({
                mode: "textareas",
                plugins: 'autolink lists link image'
            });
        }
        <?php $judg_principle = App\Models\JudgementPrinciple::where('suit_no', $judgement_summary ? $judgement_summary->suit_no : '')->first(); ?>
        <?php $principle = App\Models\Principle::where('id', $judg_principle ? $judg_principle->principle_id : '')->orderBy('id', 'DESC')->first(); ?>
        <?php $last_principle = App\Models\Principle::orderBy('id', 'DESC')->first(); ?>
        var subject_id = {{$principle ? $principle->id : $last_principle->id}};
        var subject_no = {{$principle_count}};
        function addSubs() {
            subject_no++;
            var objTo = document.getElementById('add_sub')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + subject_no +
            '.  Subject Matter Index</label><select name="new_subject['+ subject_id +'][]" class="form-select" data-choices="{"searchEnabled": true}"><option value="">Select Subject Matter Index</option>@foreach($subject_matters as $subject_matter)<option value="{{$subject_matter->id}}">{{$subject_matter->subject_matter_index}}</option>@endforeach</select></div><div class="form-group"><label class="form-label mb-1">Principles</label><textarea name="new_subject['+ subject_id +'][]" rows="5" class="form-control" placeholder="Enter Principle"></textarea></div>';
            objTo.appendChild(divcreate);
            initMCEall();
        }

        <?php $coram = App\Models\JudgementCoram::where('suit_no', $judgement_summary->suit_no)->orderBy('id', 'DESC')->first(); ?>
        <?php $last_coram = App\Models\JudgementCoram::orderBy('id', 'DESC')->first(); ?>
        var coram_no = {{$coram_count}};
        var coram_id = {{$coram ? $coram->id : $last_coram->id}};
        function addFields() {
            coram_no++;
            var objTo = document.getElementById('add_field')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + coram_no +
            '. Coram</label><input type="text" name="new_coram['+ coram_id +'][]" class="form-control"></div>';
            objTo.appendChild(divcreate);
            initMCEall();
        }

        <?php $ratio = App\Models\SummaryRatio::where('suit_no', $judgement_summary->suit_no)->orderBy('id', 'DESC')->first(); ?>
        <?php $last_ratio = App\Models\SummaryRatio::orderBy('id', 'DESC')->first(); ?>
        var ratio_no = {{$ratio_count}};
        var ratio_id = {{$ratio ? $ratio->id : $last_ratio->id}};
        function addRatio() {
            ratio_no++;
            var objTo = document.getElementById('add_ratio')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + ratio_no +
            '. Ratio Header</label><input type="text" name="new_ratio['+ ratio_id +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Ratio Body</label> <textarea class="form-control" name="new_ratio['+ ratio_id +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
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
