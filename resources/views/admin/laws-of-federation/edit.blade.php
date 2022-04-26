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
        .cursor-pointer {
            cursor: pointer;
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
                                    <textarea name="description" rows="5" class="form-control custom-textarea" placeholder="Enter description">{{$fed->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select name="category" class="form-select" data-choices='{"searchEnabled": true}'>
                                        <option value="{{$fed->category}}" selected>{{$fed->category}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->category}}">{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <label class="form-label mb-1">
                                        Area of Law
                                    </label>
                                    <textarea name="area_of_law" rows="5" class="form-control custom-textarea" placeholder="Enter area(s) of Law">{{$fed->area_of_law}}</textarea>
                                </div> --}}
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Subsidiary Legislation
                                    </label>
                                    <textarea name="subsidiary_legislation" rows="5" class="form-control custom-textarea" placeholder="">{{$fed->subsidiary_legislation}}</textarea>
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
                                        <h1 class="mb-3">Federation Part and sections</h1>
                                    </div>
                                </div>
                                @if(count($fed_parts) > 0)
                                    @php
                                        $fed_part_no = 1;
                                        $last_part = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->orderBy('id', 'DESC')->first();
                                        $part_count = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->count();
                                    @endphp
                                    @foreach($fed_parts as $fed_part)
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                {{$fed_part_no++}}. Part Title
                                            </label>
                                            <input type="text" name="part_header[{{$fed_part->id}}][]" class="form-control" value="{{$fed_part->part_header}}">
                                        </div>
                                        <hr class="my-5">
                                        @php
                                            $get_fed_sections = App\Models\LawOfFedSection::where('law_of_fed_part_id', $fed_part ? $fed_part->id : '')->where('law_of_federation_id', $fed->id)->get();
                                            $fed_section_no = 1;
                                            $last_section = App\Models\LawOfFedSection::where('law_of_fed_part_id', $fed_part ? $fed_part->id : '')->where('law_of_federation_id', $fed->id)->orderBy('id', 'DESC')->first();
                                            $section_count = App\Models\LawOfFedSection::where('law_of_fed_part_id', $fed_part ? $fed_part->id : '')->where('law_of_federation_id', $fed->id)->count();
                                        @endphp
                                        @if(count($get_fed_sections) > 0 )
                                            @foreach($get_fed_sections as $fed_section)
                                                <div class="add_more">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            {{$fed_section_no}}. Section Header
                                                            <?php $fed_section_no++; ?>
                                                        </label>
                                                        <input type="text" name="part_header[{{$fed_part->id}}][10][{{$fed_section->id}}][]" class="form-control" value="{{$fed_section->section_header}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Section Body
                                                        </label>
                                                        <textarea name="part_header[{{$fed_part->id}}][10][{{$fed_section->id}}][]" rows="5" class="custom-textarea form-control">{{$fed_section->section_body}}</textarea>
                                                    </div>
                                                    <div class="form-roup mb-4">
                                                        <div class="justify-content-end">
                                                            <input type="hidden" name="remove_fed_section_id" value="{{$fed_section->id}}">
                                                            <span onclick="removeSection('{{$fed_section->id}}')" class="cursor-pointer text-color"><i class="mdi mdi-close"></i> Remove section</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div id="add_field{{$fed_part->id}}"></div>
                                            <input type="hidden" id="secton-no{{$fed_part->id}}" value="{{$section_count}}">
                                            <input type="hidden" id="secton-id{{$fed_part->id}}" value="{{$last_section->id}}">
                                            <div class="justify-content-end">
                                                <a type="button" id="more_fields{{$fed_part->id}}" class="text-color" onclick="addFields('add_field{{$fed_part->id}}', '{{$fed_part->id}}', 'secton-no{{$fed_part->id}}', 'secton-id{{$fed_part->id}}')"><i class="mdi mdi-plus"></i> Add Section</a>
                                            </div>
                                        @endif
                                        <hr class="my-5">
                                        <div class="form-roup mb-4">
                                            <div class="justify-content-end">
                                                <input type="hidden" name="fed_part_id" value="{{$fed_part->id}}">
                                                <span class="text-color cursor-pointer" onclick="removePart('{{$fed_part->id}}')"><i class="mdi mdi-close"></i> Remove part</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr class="my-5">
                                    <div id="add_part"></div>
                                    <div class="justify-content-end mb-5">
                                        <input type="hidden" id="part-no" value="{{$part_count}}">

                                        <a type="button" id="more_part" class="text-color" onclick="addPart('part-no')"><i class="mdi mdi-plus"></i> Add New Part</a>
                                    </div>
                                @else
                                    <div id="add_new_part"></div>
                                    <div class="justify-content-end mb-5">
                                        <a type="button" id="more_new_part" class="text-color" onclick="addNewPart()"><i class="mdi mdi-plus"></i> Add New Part</a>
                                    </div>
                                @endif
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
                                                <textarea name="sched[{{$fed_sched->id}}][]" class="custom-textarea form-control" rows="5">{{$fed_sched->sched_body}}</textarea>
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
        function initMCEall(){
            tinymce.init({
                mode: "textareas",
                plugins: 'autolink lists link image'
            });
        }


        function removeSection(sectionId) {
            $.ajax({
                type: "POST",
                url: '/admin/laws-of-federation/edit-fed/remove-section/' + sectionId,
                data:{
                    "_token": "{{ csrf_token() }}",
                    id:sectionId
                },
                success:function(data){
                    console.log(data);
                    swal({
                        title: "Success!",
                        text: 'Section removed',
                        icon: "success",
                    });
                    window.location.href = "{{url()->current()}}";
                },
                error: function(error) {
                    swal({
                        title: "Error!",
                        text: 'Failed to remove section, please try again',
                        icon: "error",
                    });
                    console.log(error);
                }
            });
        }

        function removePart(partId) {
            $.ajax({
                type: "POST",
                url: '/admin/laws-of-federation/edit-fed/remove-part/' + partId,
                data:{
                    "_token": "{{ csrf_token() }}",
                    id:partId
                },
                success:function(data){
                    console.log(data);
                    swal({
                        title: "Success!",
                        text: 'Part removed',
                        icon: "success",
                    });
                    window.location.href = "{{url()->current()}}";
                },
                error: function(error) {
                    swal({
                        title: "Error!",
                        text: 'Failed to remove part, please try again',
                        icon: "error",
                    });
                    console.log(error);
                }
            });
        }

        ////////////////// Add an new section /////////////

        function addFields(addField, part_no, sectionNo, section_id) {
            section_no = document.getElementById(sectionNo).value;
            sectionId = document.getElementById(section_id).value;
            section_no++;
            sectionId++;
            document.getElementById(sectionNo).value = section_no;
            document.getElementById(section_id).value = sectionId;
            var objTo = document.getElementById(addField)
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + section_no +
            '. Section Header</label><input type="hidden" name="fed_section_part_id" value="'+ part_no +'"><input type="text" name="section_part_header['+ part_no +'][10]['+ sectionId +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="section_part_header['+ part_no +'][10]['+ sectionId +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
        }




        ////////////////// Add an new part /////////////

        var section_noss = 1;
        var section_nos = 0;
        function addPart(part_No) {
            part_no = document.getElementById(part_No).value;
            part_no++;
            document.getElementById(part_No).value = part_no
            var objTo = document.getElementById('add_part')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + part_no +
            '. Part Title</label><input type="text" name="new_part_header['+ part_no +'][]" class="form-control"></div><hr class="my-5"><div class="form-group"><label class="form-label mb-1">'+ section_noss +'. Section Header</label><input type="text" name="new_part_header['+ part_no +'][10]['+ section_nos +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="new_part_header['+ part_no +'][10]['+ section_nos +'][]" rows="5"></textarea></div><hr class="my-5"><div id="add_field' + part_no + '"></div><input type="hidden" id="secton-no'+ part_no +'" value="'+ section_noss +'"><input type="hidden" id="secton-id'+ part_no +'" value="'+ section_nos +'"><div class="justify-content-end"><a type="button" id="more_fields' + part_no + '" class="text-color" onclick="addFieldss(`add_field'+ part_no + '`, `secton-id'+ part_no +'`, `'+ part_no +'`, `secton-no'+ part_no +'`)"><i class="mdi mdi-plus"></i>Add Section</a></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
        }

        function addFieldss(addField, section_id, partNo, section_no) {
            sectionId = document.getElementById(section_id).value;
            sectionNo = document.getElementById(section_no).value;
            sectionId++;
            sectionNo++;
            document.getElementById(section_id).value = sectionId;
            document.getElementById(section_no).value = sectionNo;
            var objTo = document.getElementById(addField)
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + sectionNo +
            '. Section Header</label><input type="text" name="new_part_header['+ partNo +'][10]['+ sectionId +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="new_part_header['+ partNo +'][10]['+ sectionId +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
        }



        ////////////////// Add an entirely new part if there is none/////////////

        var new_part_no = 1;
        var new_section_noss = 1;
        var new_section_nos = 0;
        function addNewPart() {
            new_part_no++;
            var objTo = document.getElementById('add_new_part')
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + new_part_no +
            '. Part Title</label><input type="text" name="part_header['+ new_part_no +'][]" class="form-control"></div><hr class="my-5"><div class="form-group"><label class="form-label mb-1">'+ new_section_noss +'. Section Header</label><input type="text" name="part_header['+ new_part_no +'][10]['+ new_section_nos +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="part_header['+ new_part_no +'][10]['+ new_section_nos +'][]" rows="5"></textarea></div><hr class="my-5"><div id="add_field' + new_part_no + '"></div><div class="justify-content-end"><a type="button" id="more_fields' + new_part_no + '" class="text-color" onclick="addNewField(`add_field'+ new_part_no + '`, `'+ new_section_nos +'`, `'+ new_part_no +'`, `'+ new_section_noss +'`)"><i class="mdi mdi-plus"></i>Add Section</a></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
        }


        function addNewField(addField, sectionNo, partNo, sectionNoss) {
            sectionNo++;
            sectionNoss++;
            var objTo = document.getElementById(addField)
            var divcreate = document.createElement("div");
            divcreate.innerHTML = '<div class="form-group"><label class="form-label mb-1">' + sectionNoss +
            '. Section Header</label><input type="text" name="part_header['+ partNo +'][10]['+ sectionNo +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Section Body</label> <textarea class="form-control" name="part_header['+ partNo +'][10]['+ sectionNo +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
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
            '. Schedule Header</label><input type="hidden" name="new_sched['+ sched_id +'][]" value="{{$fed->id}}"><input type="text" name="new_sched['+ sched_id +'][]" class="form-control"></div><div class="form-group"><label class="form-label mb-1">Schedule Body</label> <textarea class="form-control custom-textarea" name="new_sched['+ sched_id +'][]" rows="5"></textarea></div><hr class="my-5">';
            objTo.appendChild(divcreate);
            initMCEall();
        }

        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this law of federation?"))
            event.preventDefault();

        }
    </script>
@endsection
