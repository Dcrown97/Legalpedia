@extends('layouts.admin.laws-of-federation')

@section('title')
    <title>{{$fed->title}} - Legalpedia</title>
@endsection

@section('content')
<style>
    .modal-content {
        width: 100% !important;
        height: auto !important;
    }
</style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/laws-of-federation')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title text-center" style="color: #990033">
                            {{$fed->title}}
                        </h1>
                        <h3 class="card-text text-center text-color mt-2 mb-2">{{$fed->law_no}}</h3>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('edit.fed', $fed->id)}}" class="btn text-white btn-primary">
                                <i class="mdi mdi-pencil"></i> Edit Law
                            </a>
                        </div>
                    @endif
                    @include('elements.notifications')
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body p-5" id="content">
                        {{-- <h3>{{$fed->title}}</h3>
                        <p class="card-text text-muted small mb-1">Law No. <span class="text-color">{{$fed->law_no}}</span></p>
                        <p class="card-text text-muted small mb-1">Date: <span class="text-color">{{$fed->law_date}}</span></p>
                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$fed->category}}</span></p>
                        <p class="card-text text-muted small mb-1">Area of Law: <span class="text-color">{{$fed->area_of_law}}</span></p>
                        <span>{!! $fed->description !!}</span>
                        <hr class="my-5">
                        <span>{!! $fed->subsidiary_legislation !!}</span> --}}
                        <?php $fed_part = App\Models\LawOfFedPart::where('law_of_federation_id', $fed->id)->first() ;
                            $fed_sections = App\Models\LawOfFedSection::where('law_of_federation_id', $fed->id)->orderBy('section_header', 'ASC')->get() ;
                        ?>
                        {{-- @if($fed_part)
                            <p class="card-text text-muted small mb-1">Part: <span class="text-color">{{$fed_part->part_header}}</span></p>
                        @endif --}}
                        @if($fed_sections)
                            <?php $fed_section_no = 1; ?>
                            @foreach($fed_sections as $fed_section)
                                <h3 class="text-muted">{{$fed_section_no}}. {{$fed_section->section_header}}</h3>
                                <?php $fed_section_no++; ?>
                                <p class="card-text mb-1">{!! nl2br(e($fed_section->section_body)) !!}</p>
                                <hr class="my-4">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="cursor" data-bs-toggle="modal" data-bs-target="#view_notes" id="kt_toolbar_primary_button">
        <div class="note">
            <span class="icon"><i class="mdi mdi-file-document-multiple-outline"></i></span>
        </div>
    </a>

    <div class="modal fade" id="view_notes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Your current notes
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-header">
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                            <input class="form-control list-search" type="search" placeholder="Search">
                            <div class="input-group-text">
                                <span class="fe fe-search"></span>
                            </div>
                        </div>
                        <div class="col-auto me-n3">
                            <a href="{{url('admin/notes')}}" class="btn text-white btn-primary">
                                View all <i class="mdi arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush list my-n3">
                            @if(count($notes) > 0)
                                @foreach($notes as $note)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1 name">
                                                    @php
                                                        $note->comment = json_decode($note->comment);
                                                    @endphp
                                                    @foreach ($note->comment as $comment_type)
                                                        {{ucwords(strtolower($comment_type->value))}}
                                                    @endforeach
                                                </h5>
                                                @php
                                                    $note->content = json_decode($note->content);
                                                @endphp
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm" style="visibility: hidden">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="small text-gray-700 mb-0">
                                                    {{Str::words(ucwords(strtolower($note->content->selector[0]->exact)), 20)}}
                                                </p>
                                                <p class="card-text small text-muted">
                                                    {{$note->created_at->diffForHumans()}}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                @else
                                <div class="text-center my-4">
                                    <h3 class="text-muted"><i class="fe fe-file"></i> No notes</h3>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="save_public" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Make your notes public or private</div>
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
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.anote')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Make notes searchable</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="display" class="form-select">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>
                                <input type="hidden" name="note_id" id="note-id">
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save Note</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
        // Intialize Recogito
        var r = Recogito.init({
          content: 'content', // Element id or DOM node to attach to
          locale: 'auto',
      	  widgets: [
            { widget: 'COMMENT' },
            { widget: 'TAG', vocabulary: [ 'Place', 'Person', 'Event', 'Organization', 'Animal' ] }
          ],
          relationVocabulary: [ 'isRelated', 'isPartOf', 'isSameAs ']
        });

        // r.loadAnnotations('annotations.w3c.json');
        var jid = {{$fed->id}};
        r.loadAnnotations('fetch-annotations/' + jid).then(function() {
            var anotes =

            [
                {
                    "@context": "http://www.w3.org/ns/anno.jsonld",
                    "id": "#13e491af-2bff-4f97-86fb-f4d9c3e4b619",
                    "type": "Annotation",
                    "body": [{
                        "type": "TextualBody",
                        "value": "This is a something",
                        "purpose": "commenting"
                    }],
                    "target": {
                        "selector": [{
                            "type": "TextQuoteSelector",
                            "exact": "eard the matter and placed under its Undefended List and after considering, the affidavits of the parties"
                        }],
                        "0": [{
                            "type": "TextPositionSelector",
                            "start":1253,
                            "end":1358
                        }]
                    }
                }
            ];

            // return anotes;

            console.log(anotes)
            // var id = {{$fed->id}};
            // $.ajax({
            //     type: 'GET',
            //     url: "/admin/judgements/fetch-annotations/" + id,
            //     dataType: 'json',
            //     success: function (response) {
            //         console.log(response.anotes);
            //         // var myAnnotation = {
            //         //     'id': 'https://www.example.com/recogito-js-example/foo',
            //         //     'type': 'Annotation',
            //         //     'body': [{
            //         //     'type': 'TextualBody',
            //         //     'value': 'This annotation was added via JS.'
            //         //     }],
            //         //     'target': {
            //         //     'selector': [{
            //         //         'type': 'TextQuoteSelector',
            //         //         'exact': 'that ingenious hero'
            //         //     }, {
            //         //         'type': 'TextPositionSelector',
            //         //         'start': 38,
            //         //         'end': 57
            //         //     }]
            //         //     }
            //         // };
            //         $.each(response.anotes, function (key, item) {
            //             console.log(item);
            //             // $('#content').append(
            //             //     myAnnotation = {
            //             //         'id': item.note_id,
            //             //         'type': item.content_type,
            //             //         'body': [{
            //             //             'type': item.comment.type,
            //             //             'value': item.comment.value,
            //             //         }],
            //             //         'target': {
            //             //             'selector': [{
            //             //                 'type': item.content.type,
            //             //                 'exact': item.content.exact,
            //             //             }, {
            //             //                 'type': item.content.type,
            //             //                 'start': item.content.start,
            //             //                 'end': item.content.end,
            //             //             }]
            //             //         }
            //             //     }
            //             // );
            //             // anotes.push(myAnnotation())
            //         });
            //     }
            // });


        });

        r.on('selectAnnotation', function(annote) {
          console.log(annote);
        });

        r.on('createAnnotation', function(annote) {
            var userId = "{{Auth::user()->id}}";
            var contentId = "{{$fed ? $fed->id : ''}}";
            var resource_type = "fed";
            $.ajax({
                type: 'POST',
                url: "/admin/annotations",
                data: {
                    "_token": "{{ csrf_token() }}",
                    user_id: userId,
                    note_id: annote.id,
                    content_id: contentId,
                    content_type: annote.type,
                    content: annote.target,
                    comment: annote.body,
                    resource_type: resource_type,
                },
                success: function (response) {
                    console.log(response);
                    document.getElementById('note-id').value = annote.id;
                    $('#save_public').modal('show')
                    // swal({
                    //     title: "Success",
                    //     text: 'Annotation saved',
                    //     icon: "success",
                    // });
                }

            });

        });

        r.on('updateAnnotation', function(annotation, previous) {
          console.log('updated', previous, 'with', annotation);
        });

        // // Wire the Add/Update/Remove buttons
        // document.getElementById('add-annotation').addEventListener('click', function() {
        //   r.addAnnotation(myAnnotation);
        // });

        // document.getElementById('update-annotation').addEventListener('click', function() {
        //   r.addAnnotation(Object.assign({}, myAnnotation, {
        //     'body': [{
        //       'type': 'TextualBody',
        //       'value': 'This annotation was added via JS, and has been updated now.'
        //     }],
        //     'target': {
        //       'selector': [{
        //         'type': 'TextQuoteSelector',
        //         'exact': 'ingenious hero who'
        //       }, {
        //         'type': 'TextPositionSelector',
        //         'start': 43,
        //         'end': 61
        //       }]
        //     }
        //   }));
        // });

        // document.getElementById('remove-annotation').addEventListener('click', function() {
        //   r.removeAnnotation(myAnnotation);
        // });

        // // Switch annotation mode (annotation/relationships)
        // var annotationMode = 'ANNOTATION'; // or 'RELATIONS'

        // var toggleModeBtn = document.getElementById('toggle-mode');
        // toggleModeBtn.addEventListener('click', function() {
        //   if (annotationMode === 'ANNOTATION') {
        //     toggleModeBtn.innerHTML = 'MODE: RELATIONS';
        //     annotationMode = 'RELATIONS';
        //   } else  {
        //     toggleModeBtn.innerHTML = 'MODE: ANNOTATION';
        //     annotationMode = 'ANNOTATION';
        //   }

        //   r.setMode(annotationMode);
        // });
      })();
    </script>
@endsection
