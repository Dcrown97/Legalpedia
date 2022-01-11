@extends('layouts.admin.laws-of-federation')

@section('title')
    <title>{{$fed->title}} - Legalpedia</title>
@endsection

@section('content')
    <style>
        .custom-button {
            background: none !important;
            border: none !important;
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/laws-of-federation')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Edit Law
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
                        <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.fed', $fed->id)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel" aria-labelledby="wizardTabOne">
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <h1 class="mb-3">Edit Law</h1>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Title
                                    </label>
                                    <input type="text" name="title" class="form-control" value="{{$fed->title}}">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Law No.
                                            </label>
                                            <input type="text" name="law_no" class="form-control" value="{{$fed->law_no}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Law Date.
                                            </label>
                                            <input type="date" name="law_date" class="form-control" value="{{$fed->law_date}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Description
                                    </label>
                                    <textarea name="description" rows="5" class="form-control" placeholder="Enter description">{{$fed->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select name="category" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                        <option value="{{$fed->category}}" selected>{{$fed->category}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->category}}">{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Area of Law
                                    </label>
                                    <textarea name="area_of_law" rows="5" class="form-control" placeholder="Enter area(s) of Law">{{$fed->area_of_law}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Subsidiary Legislation
                                    </label>
                                    <textarea name="subsidiary_legislation" rows="5" class="form-control" placeholder="">{{$fed->subsidiary_legislation}}</textarea>
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
                                        <h1 class="mb-3">Federation Part</h1>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Part Title
                                    </label>
                                    <?php $fed_part = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->first(); ?>
                                    <input type="hidden" name="law_of_federation_id" value="{{$fed->id}}">
                                    <input type="hidden" name="law_of_fed_part_id" value="{{$fed_part->id}}">
                                    <input type="text" name="part_header" class="form-control" value="{{$fed_part ? $fed_part->part_header : ''}}">
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
                                        <h1 class="mb-3">Federation Section</h1>
                                    </div>
                                </div>
                                @if($fed_sections)
                                    <?php $fed_section_no = 1 ;?>
                                    @foreach($fed_sections as $fed_section)
                                        <div class="add_more">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    {{$fed_section_no}} Section Header
                                                    <?php $fed_section_no++; ?>
                                                </label>
                                                <input type="hidden" name="section[{{$fed_section->id}}][]" value="{{$fed_section->law_of_federation_id}}">
                                                <input type="hidden" name="section[{{$fed_section->id}}][]" value="{{$fed_section->law_of_fed_part_id}}">
                                                <input type="text" name="section[{{$fed_section->id}}][]" class="form-control" value="{{$fed_section->section_header}}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Section Body
                                                </label>
                                                <textarea name="section[{{$fed_section->id}}][]" rows="5" class="form-control">{{$fed_section->section_body}}</textarea>
                                            </div>
                                            <div class="form-roup mb-4">
                                                <div class="justify-content-end">
                                                    <input type="hidden" name="fed_section_id" value="{{$fed_section->id}}">
                                                    <button type="submit" name="remove_section" class="text-color custom-button"><i class="mdi mdi-close"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <hr class="my-5">
                                <div id="add_field"></div>
                                <div class="justify-content-end">
                                    <a type="button" id="more_fields" class="text-color" onclick="addFields()"><i class="mdi mdi-plus"></i> Add Section</a>
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
                                        <h1 class="mb-3">Add Schedule</h1>
                                    </div>
                                </div>
                                @if($fed_scheds)
                                    <?php $fed_sched_no = 1 ;?>
                                    @foreach($fed_scheds as $fed_sched)
                                        <div class="add_more">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    {{$fed_sched_no}} Schedule Header
                                                    <?php $fed_sched_no++; ?>
                                                </label>
                                                <input type="hidden" name="sched[{{$fed_sched->id}}][]" value="{{$fed_sched->law_of_federation_id}}">
                                                <input type="text" name="sched[{{$fed_sched->id}}][]" class="form-control" value="{{$fed_sched->sched_header}}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Schedule Body
                                                </label>
                                                <textarea name="sched[{{$fed_sched->id}}][]" class="form-control" rows="5">{{$fed_sched->sched_body}}</textarea>
                                            </div>
                                            <div class="form-roup mb-4">
                                                <div class="justify-content-end">
                                                    <input type="hidden" name="fed_sched_id" value="{{$fed_sched->id}}">
                                                    <button type="submit" name="remove_sched" class="text-color custom-button"><i class="mdi mdi-close"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <hr class="my-5">
                                <div id="add_sched"></div>
                                <div class="justify-content-end">
                                    <a type="button" id="more_scheds" class="text-color" onclick="addScheds()"><i class="mdi mdi-plus"></i> Add Schedule</a>
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
        <?php $fed_section = App\Models\LawOfFedSection::where('law_of_federation_id', $fed->id)->orderBy('id', 'DESC')->first(); ?>
        <?php $last_section = App\Models\LawOfFedSection::orderBy('id', 'DESC')->first(); ?>
        <?php $fed_part = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->orderBy('id', 'DESC')->first(); ?>
        var section_no = {{$fed_section_count}};
        var section_id = {{$fed_section ? $fed_section->id : $last_section->id}};
        function addFields() {
            section_no++;
            section_id++;
            var objTo = document.getElementById('add_field')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + section_no +
            '. Section Header</label><input type="hidden" name="new_section['+ section_id +'][]" value="{{$fed->id}}"><input type="hidden" name="new_section['+ section_id +'][]" value="{{$fed_section ? $fed_section->law_of_fed_part_id : $fed_part->id}}"><input type="text" name="new_section['+ section_id +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="new_section['+ section_id +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
        }

        <?php $fed_sched = App\Models\LawOfFedSched::where('law_of_federation_id', $fed->id)->orderBy('id', 'DESC')->first(); ?>
        <?php $last_sched = App\Models\LawOfFedSched::orderBy('id', 'DESC')->first(); ?>
        var sched_no = {{$fed_sched_count}};
        var sched_id = {{$fed_sched ? $fed_sched->id : $last_sched->id }};
        function addScheds() {
            sched_no++;
            sched_id++;
            var objTo = document.getElementById('add_sched')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + sched_no +
            '. Schedule Header</label><input type="hidden" name="new_sched['+ sched_id +'][]" value="{{$fed->id}}"><input type="text" name="new_sched['+ sched_id +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Schedule Body</label> <textarea class="form-control" name="new_sched['+ sched_id +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
        }

        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this law of federation?"))
            event.preventDefault();

        }
    </script>
@endsection
