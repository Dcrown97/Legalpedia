@extends('layouts.admin.judgements')

@section('title')
    <title>{{$judgement_summary->title}} - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-green {
            color: #009900 !important;
        }
        .modal-content {
            width: 100% !important;
            height: auto !important;
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <a href="{{url('admin/judgements')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                    <div class="col text-center">
                        <h1 class="header-title text-center mb-2" style="color: #990033">
                            {{$judgement_summary->title}}
                        </h1>
                        <img src="{{asset('assets/images/nigerian-coat-of-arms.png')}}" class="mb-2" style="height: 150px;">
                        <h3 class="text-green mb-2">{{$judgement_summary->lp_citation}}</h3>
                        <?php $court = App\Models\Court::where('id', $judgement_summary->court_id)->first();?>
                        <h3 class="card-text text-color mb-2">{{$court->court}}</h3>
                        <?php $holden = App\Models\Holden::where('id', $judgement_summary->holden_at_id)->first() ;?>
                        <h3 class="card-text text-color mb-2">{{$holden ? $holden->holden_at : ''}}</h3>
                        <h3 class="card-text text-color mb-2">
                            {{\Carbon\Carbon::parse($judgement_summary->judgement_date)->format('D')}}  {{\Carbon\Carbon::parse($judgement_summary->judgement_date)->toFormattedDateString()}}
                        </h3>
                        <h3 class="text-green mb-2">Suit Number: <span class="text-black">{{$judgement_summary->suit_no}}</span></h3>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('edit.judgement', $judgement_summary->id)}}" class="btn text-white btn-primary">
                                <i class="mdi mdi-pencil"></i> Edit Judgement
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
                <div class="card" id="content">
                    <div class="p-5">
                        <h3 class="text-muted">CORAMS</h3>
                        <hr class="my-4">
                        <?php $judg_coram = App\Models\JudgementCoram::where('suit_no', $judgement_summary->suit_no)->get() ;?>
                        @if($judg_coram)
                            @foreach($judg_coram as $coram)
                                <?php $coram = App\Models\Coram::where('id', $coram->coram_id)->first();?>
                                <p class="card-text mb-1">{{$coram->name}}</p>
                            @endforeach
                        @endif
                        <hr class="my-4">
                        <h3 class="text-muted">AREA(S) OF LAW</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->area_of_law !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">SUMMARY OF FACTS</h3>
                        <p class="card-text mb-1">{!! nl2br(e(strip_tags($judgement_summary->summary_of_facts))) !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">HELD</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->held !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">ISSUES</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->issues !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">RATIONEES</h3>
                        <hr class="my-4">
                        <?php $ratios = App\Models\SummaryRatio::where('suit_no', $judgement_summary->suit_no)->get() ;?>
                        @if($ratios)
                            @foreach($ratios as $ratio)
                                <h4 class="text-muted" id="ratio">{{$ratio->heading}}</h4>
                                <hr class="my-4">
                                <p class="card-text mb-1">{!! nl2br(e(strip_tags($ratio->body))) !!}</p>
                                <hr class="my-4">
                            @endforeach
                        @endif
                        <h3 class="text-muted">STATUTES REFERRED TO</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->statutes_cited !!}</p>
                        <hr class="my-4">
                        <span data-toggle="collapse" href="#multiCollapse" role="button" aria-expanded="false" aria-controls="multiCollapse">
                            <h3 class="mr-2 text-color" onclick="readFunction()" id="hide"><i class="mdi mdi-plus"></i> Read Full Judgement</h3>
                            <h3 class="text-muted" id="show" onclick="hideFunction()" style="display: none">FULL JUDGEMENT</h3>
                        </span>
                        <div class="">
                            <div class="collapse multi-collapse" id="multiCollapse">
                                <?php $full_judgement = App\Models\Judgement::where('suit_no', 'LIKE', '%'.$judgement_summary->suit_no. '%')->first() ;?>
                                <p class="card-text mb-1 mt-4" style="line-height: 25px; font-weight: 400">{!! nl2br(e(strip_tags($full_judgement ? $full_judgement->judgement : ''))) !!}</p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h3 class="text-muted">COUNSELS</h3>
                        <hr class="my-4">
                        <?php $counsels = App\Models\JudgementCounsel::where('suit_no', $judgement_summary->suit_no)->first() ;?>
                        <p class="card-text mb-1">{!! $counsels ? $counsels->counsels : '' !!}</p>
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
                                        <p class="mb-5 text-muted">Save note to public or private</p>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var data = null;
        function readFunction() {
            document.getElementById('hide').style.display = 'none'
            document.getElementById('show').style.display = 'block'
        }
        function hideFunction() {
            document.getElementById('hide').style.display = 'block'
            document.getElementById('show').style.display = 'none'
        }


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
        var jid = {{$judgement_summary->id}};
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
            // var id = {{$judgement_summary->id}};
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
            var contentId = "{{$judgement_summary ? $judgement_summary->suit_no : ''}}";
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
