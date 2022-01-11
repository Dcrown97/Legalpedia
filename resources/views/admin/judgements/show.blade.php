@extends('layouts.admin.judgements')

@section('title')
    <title>{{$judgement_summary->title}} - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-green {
            color: #009900 !important;
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
                        {{-- <?php $sum_area_of_laws = App\Models\SumAreaOfLaw::where('suit_no', $judgement_summary->suit_no)->get();?>
                        @if($sum_area_of_laws)
                            @foreach($sum_area_of_laws as $area_of_law)
                                <?php $area_of_law = App\Models\AreaOfLaw::where('id', $area_of_law->area_of_law_id)->first();?>
                                <p class="card-text mb-1">{{$area_of_law->area_of_law}}</p>
                            @endforeach
                        @endif --}}
                        <p class="card-text mb-1">{{$judgement_summary->area_of_law}}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">SUMMARY OF FACTS</h3>
                        <p class="card-text mb-1">{!! $judgement_summary->summary_of_facts !!}</p>
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
                                <p class="card-text mb-1">{{$ratio->body}}</p>
                                <hr class="my-4">
                            @endforeach
                        @endif
                        <hr class="my-4">
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
                                <p class="card-text mb-1 mt-4" style="line-height: 25px; font-weight: 400">{!! $full_judgement ? $full_judgement->judgement : '' !!}</p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h3 class="text-muted">COUNSELS</h3>
                        <hr class="my-4">
                        <?php $counsels = App\Models\JudgementCounsel::where('suit_no', $judgement_summary->suit_no)->first() ;?>
                        <p class="card-text mb-1">{{$counsels ? $counsels->counsels : ''}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    //   $('.r60-btns').click(function(e){
    //         e.preventDefault();
    //         function saveAnnotation() {
    //             var userId = "{{Auth::user()->id}}";
    //             var contentId = "{{$judgement_summary ? $judgement_summary->suit_no : ''}}";
    //             var data = {
    //                 user_id: userId,
    //                 note_id: annote.id,
    //                 content_id: contentId,
    //                 content_type: annote.type,
    //                 content: annote.body,
    //             }
    //             $.ajax({
    //                 type: 'POST',
    //                 url: "/admin/annotation"
    //                 data: {
    //                     "_token": "{{ csrf_token() }}",
    //                     user_id: userId,
    //                     note_id: annote.id,
    //                     content_id: contentId,
    //                     content_type: annote.type,
    //                     content: annote.body,
    //                     // comment: comment,
    //                     // replies: replies,
    //                     // text_target: text_target,
    //                     // tags: tags
    //                 },
    //                 success: function (annote) {
    //                     console.log(annote);
    //                     swal({
    //                         title: "Error!",
    //                         text: 'Annotation saved',
    //                         icon: "success",
    //                     });
    //                 }
    //             });
    //             return data;
    //         }
    //     });

        // function saveAnnotation() {
        //     var userId = "{{Auth::user()->id}}";
        //     var contentId = "{{$judgement_summary ? $judgement_summary->suit_no : ''}}";
        //     var data = {
        //         user_id: userId,
        //         note_id: annote.id,
        //         content_id: contentId,
        //         content_type: annote.type,
        //         content: annote.body,
        //     }
        //     $.ajax({
        //         type: 'POST',
        //         url: "/admin/annotation"
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             user_id: userId,
        //             note_id: annote.id,
        //             content_id: contentId,
        //             content_type: annote.type,
        //             content: annote.body,
        //             // comment: comment,
        //             // replies: replies,
        //             // text_target: text_target,
        //             // tags: tags
        //         },
        //         success: function (annote) {
        //             console.log(annote);
        //             swal({
        //                 title: "Error!",
        //                 text: 'Annotation saved',
        //                 icon: "success",
        //             });
        //         }
        //     });
        //     return data;
        // }

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

        r.loadAnnotations('annotations.w3c.json');

        r.on('selectAnnotation', function(a) {
          console.log('selected', a);
        });



        r.on('createAnnotation', function(annote) {

            // data = annote;
            // console.log(annote.id);



            // alert(annote.body)
            // alert(saveAnnotation());

        });

        r.on('updateAnnotation', function(annotation, previous) {
          console.log('updated', previous, 'with', annotation);
        });

        // Wire the Add/Update/Remove buttons
        document.getElementById('add-annotation').addEventListener('click', function() {
          r.addAnnotation(myAnnotation);
        });

        document.getElementById('update-annotation').addEventListener('click', function() {
          r.addAnnotation(Object.assign({}, myAnnotation, {
            'body': [{
              'type': 'TextualBody',
              'value': 'This annotation was added via JS, and has been updated now.'
            }],
            'target': {
              'selector': [{
                'type': 'TextQuoteSelector',
                'exact': 'ingenious hero who'
              }, {
                'type': 'TextPositionSelector',
                'start': 43,
                'end': 61
              }]
            }
          }));
        });

        document.getElementById('remove-annotation').addEventListener('click', function() {
          r.removeAnnotation(myAnnotation);
        });

        // Switch annotation mode (annotation/relationships)
        var annotationMode = 'ANNOTATION'; // or 'RELATIONS'

        var toggleModeBtn = document.getElementById('toggle-mode');
        toggleModeBtn.addEventListener('click', function() {
          if (annotationMode === 'ANNOTATION') {
            toggleModeBtn.innerHTML = 'MODE: RELATIONS';
            annotationMode = 'RELATIONS';
          } else  {
            toggleModeBtn.innerHTML = 'MODE: ANNOTATION';
            annotationMode = 'ANNOTATION';
          }

          r.setMode(annotationMode);
        });
      })();
    </script>
@endsection
