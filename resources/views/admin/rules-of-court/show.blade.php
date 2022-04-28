@extends('layouts.admin.rules-of-court')

@section('title')
    @if($order)
        <title>{{$order->title}} - Legalpedia</title>
        @elseif($schedule)
        <title>{{$schedule->title}} - Legalpedia</title>
        @elseif($part)
        <title>{{$part->title}} - Legalpedia</title>
        @elseif($form)
        <title>{{$form->title}} - Legalpedia</title>
        @elseif($probate_form)
        <title>{{$probate_form->title}} - Legalpedia</title>
        @elseif($civil_form)
        <title>{{$civil_form->title}} - Legalpedia</title>
        @elseif($appendix)
        <title>{{$appendix->title}} - Legalpedia</title>
    @endif
@endsection

@section('content')
<style>
    .modal-content {
        width: 100% !important;
        height: auto !important;
    }
</style>
<style>html {scroll-behavior: smooth;}</style>
    @php
        if (isset(request()->search) && !empty(request()->search)) {
            $searchData = request()->search;
        } elseif(isset(request()->year_result) && !empty(request()->year_result)) {
            $searchData = request()->year_result;
        } elseif(isset(request()->more_result) && !empty(request()->more_result)) {
            $searchData = request()->more_result;
        } else {
            $searchData = "";
        }
    @endphp
    @php
        if($order){
            $rule_id = $order->id;
        }
        elseif($schedule){
            $rule_id = $schedule->id;
        }
        elseif($part){
            $rule_id = $part->id;
        }
        elseif($form){
            $rule_id = $form->id;
        }
        elseif($probate_form){
            $rule_id = $probate_form->id;
        }
        elseif($civil_form){
            $rule_id = $civil_form->id;
        }
        elseif($appendix){
            $rule_id = $appendix->id;
        }
    @endphp
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end mb-4">
                    <div class="col">
                        <a href="{{url('admin/rules-of-court')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            @if($order)
                                <a href="{{route('edit.rule', $order->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                                @elseif($schedule)
                                <a href="{{route('edit.rule', $schedule->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                                @elseif($part)
                                <a href="{{route('edit.rule', $part->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                                @elseif($form)
                                <a href="{{route('edit.rule', $form->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                                @elseif($probate_form)
                                <a href="{{route('edit.rule', $probate_form->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                                @elseif($civil_form)
                                <a href="{{route('edit.rule', $civil_form->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                                @elseif($appendix)
                                <a href="{{route('edit.rule', $appendix->id)}}" class="btn text-white btn-primary">
                                    <i class="mdi mdi-pencil"></i> Edit Rule
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="row align-items-end">
                    <div class="col">
                        <h1 class="header-title">
                            @if($order)
                                {!! highlightText($order->title, $searchData) !!}
                                @elseif($schedule)
                                {!! highlightText($schedule->title, $searchData) !!}
                                @elseif($part)
                                {!! highlightText($part->title, $searchData) !!}
                                @elseif($form)
                                {!! highlightText($form->title, $searchData) !!}
                                @elseif($probate_form)
                                {!! highlightText($probate_form->title, $searchData) !!}
                                @elseif($civil_form)
                                {!! highlightText($civil_form->title, $searchData) !!}
                                @elseif($appendix)
                                {!! highlightText($appendix->title, $searchData) !!}
                            @endif
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
                    <div class="card-body p-5" id="content">
                        <h3>
                            @if($order)
                                {!! highlightText($order->title, $searchData) !!}
                                @elseif($schedule)
                                {!! highlightText($schedule->title, $searchData) !!}
                                @elseif($part)
                                {!! highlightText($part->title, $searchData) !!}
                                @elseif($form)
                                {!! highlightText($form->title, $searchData) !!}
                                @elseif($probate_form)
                                {!! highlightText($probate_form->title, $searchData) !!}
                                @elseif($civil_form)
                                {!! highlightText($civil_form->title, $searchData) !!}
                                @elseif($appendix)
                                {!! highlightText($appendix->title, $searchData) !!}
                            @endif
                        </h3>
                        @if($order)
                            <p id="{{returnHighlightText($order->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($order->content, $searchData) !!}
                            </p>
                        @elseif($schedule)
                            <p id="{{returnHighlightText($schedule->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($schedule->content, $searchDa) !!}
                            </p>
                        @elseif($part)
                            <p id="{{returnHighlightText($part->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($part->content, $searchData) !!}
                            </p>
                        @elseif($form)
                            <p id="{{returnHighlightText($form->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($form->content, $searchData) !!}
                            </p>
                        @elseif($probate_form)
                            <p id="{{returnHighlightText($probate_form->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($probate_form->content, $searchData) !!}
                            </p>
                        @elseif($civil_form)
                            <p id="{{returnHighlightText($civil_form->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($civil_form->content, $searchData) !!}
                            </p>
                        @elseif($appendix)
                            <p id="{{returnHighlightText($appendix->content, $searchData) == true ? 'rule' : '' }}">
                                {!! highlightText($appendix->content, $searchData) !!}
                            </p>
                        @endif
                        </p>
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
        var jid = {{$rule_id}};
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
            // var id = {{$rule_id}};
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
            var contentId = "{{$rule_id}}";
            var resource_type = "rule";
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
