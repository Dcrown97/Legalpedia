@extends('layouts.admin.legal-articles')

@section('title')
    <title>{{$article->title}} - Legalpedia</title>
@endsection

@section('content')
    <style>
        .article-image {
            height: 300px !important;
            object-fit: cover !important;
        }

        .modal-content {
            width: 100% !important;
            height: auto !important;
        }
    </style>
    <div class="header">
        @if($article->photo)
            <img src="{{$article ? $article->photo : ''}}" class="header-img-top" alt="{{$article->title}}">
        @endif
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end mb-4">
                    <div class="col">
                        <a href="{{url('admin/legal-articles')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                    </div>
                    @if(Auth::user()->id == $article->user_id)
                        <div class="col-auto">
                            <a href="{{route('edit.article', $article->id)}}" class="btn btn-primary text-white">
                                <i class="mdi mdi-pencil"></i> Edit Article
                            </a>
                        </div>
                        @elseif($article->article_type == 'legalpedia' && Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('edit.article', $article->id)}}" class="btn btn-primary text-white">
                                <i class="mdi mdi-pencil"></i> Edit Article
                            </a>
                        </div>
                    @endif
                </div>
                <div class="row align-items-end">
                    <div class="col">
                        <h1 class="header-title text-center" style="color: #990033">
                            {{$article->title}}
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
                    <div class="card-header">
                        <h3 class="header-title">
                            @if($article->article_type == 'legalpedia')
                                @if($article->authur == null)
                                    By Legalpedia
                                @else
                                    By {{$article->authur}}
                                @endif
                            @else
                                <a href="{{route('user.profile', $article ? $article->user_id : '')}}"> By {{$article->authur}}</a>
                            @endif
                        </h3>
                        <small class="text-muted">
                            Posted: <span class="text-color">{{\Carbon\Carbon::parse($article->created_at)->toFormattedDateString()}}</span>
                        </small>
                        @php
                            $subscribed_package = App\Models\Package::where('id', Auth::user()->package_id)->first();
                        @endphp
                        @if(Auth::user()->role->name == 'Admin')
                            <div class="col-auto">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-share-variant"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a data-bs-toggle="modal" data-bs-target="#share_articles" id="kt_toolbar_primary_button" class="cursor dropdown-item">
                                            <i class="fe fe-users mr-2"></i> Share to teams
                                        </a>
                                        <a href="https://api.whatsapp.com/send?text={{route('articles', $article->id)}}" target="_blank" class="dropdown-item">
                                            <i class="mdi mdi-whatsapp mr-2"></i> Share to Whatsapp
                                        </a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('articles', $article->id)}}" target="_blank" class="dropdown-item">
                                            <i class="mdi mdi-facebook mr-2"></i> Share to Facebook
                                        </a>
                                        <a class="dropdown-item d-flex">
                                            <i class="fe fe-paperclip mr-2"></i><input type="button" class="custom-button dropdown-item" id="hide-copy" value="Copy Link" onclick="Copy();" style="margin-left: -20px; margin-top: -8px;">
                                            <span class="text-color" id="show-status" style="display: none;">Link copied!</span>
                                        </a>
                                        <span><input type="text" style="position: absolute; opacity: 0;" id="paste-box"></span>
                                        @if(Auth::user()->id == $article->user_id)
                                            <form action="/admin/legal-articles/{{$article->id}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                    <i class="fe fe-trash mr-2"></i>Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @else
                            @if($subscribed_package->share)
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-share-variant"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a data-bs-toggle="modal" data-bs-target="#share_articles" id="kt_toolbar_primary_button" class="cursor dropdown-item">
                                                <i class="fe fe-users mr-2"></i> Share to teams
                                            </a>
                                            <a href="https://api.whatsapp.com/send?text={{route('articles', $article->id)}}" target="_blank" class="dropdown-item">
                                                <i class="mdi mdi-whatsapp mr-2"></i> Share to Whatsapp
                                            </a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{route('articles', $article->id)}}" target="_blank" class="dropdown-item">
                                                <i class="mdi mdi-facebook mr-2"></i> Share to Facebook
                                            </a>
                                            <a class="dropdown-item d-flex">
                                                <i class="fe fe-paperclip mr-2"></i><input type="button" class="custom-button dropdown-item" id="hide-copy" value="Copy Link" onclick="Copy();" style="margin-left: -20px; margin-top: -8px;">
                                                <span class="text-color" id="show-status" style="display: none;">Link copied!</span>
                                            </a>
                                            <span><input type="text" style="position: absolute; opacity: 0;" id="paste-box"></span>
                                            @if(Auth::user()->id == $article->user_id)
                                                <form action="/admin/legal-articles/{{$article->id}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                        <i class="fe fe-trash mr-2"></i>Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="card-body p-5" id="content">
                        {{-- <h3 class="text-muted">Category</h3>
                        <p class="card-text mb-1">{!! $article->category !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">Area(s) of Law</h3>
                        <p class="card-text mb-1">{!! $article->area_of_law !!}</p>
                        <hr class="my-4"> --}}
                        {{-- <h3 class="text-muted">Description</h3> --}}
                        <p class="card-text mb-1">{!! $article->description !!}</p>
                        <hr class="my-4">
                        {{-- <h3 class="text-muted">Content</h3> --}}
                        <p class="card-text mb-1" id="my-content">{!! $article->content !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">References</h3>
                        <p class="card-text mb-1">{!! $article->references !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">Link</h3>
                        <p class="card-text mb-1">
                            <a href="{{$article->link}}" target="_blank" class="text-color">{{ $article->link}}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="share_articles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <h4 class="card-header-title" id="exampleModalCenterTitle">
                            Share Article to teams
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('share.article', $article->id)}}" method="POST">
                        @csrf
                        <div class="card-header">
                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                <input class="form-control list-search" type="search" placeholder="Search">
                                <div class="input-group-text">
                                <span class="fe fe-search"></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check mb-n2">
                                    <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="ordersSelectAll" type="checkbox">
                                    <label class="form-check-label" for="ordersSelectAll">&nbsp;</label> All Teams
                                </div>
                            </div>
                            <div class="col-auto me-n3">
                                <input type="hidden" name="team_id">
                                <button type="submit" name="share_all" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-share-variant-outline"></i> Share</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my-n3">
                                @if(count($teams) > 0)
                                    @foreach($teams as $team)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-1">
                                                    <div class="form-check mb-n2">
                                                        <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArray[]" id="ordersSelectOne" value="{{$team->team_id}}">
                                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <?php $my_team = App\Models\Team::where('id', $team->team_id)->first(); ?>
                                                    <a href="{{route('show.team', $team->team_id)}}" class="avatar avatar-lg">
                                                        <img src="{{$my_team->photo}}" class="avatar-img rounded-circle w-2 h-2" alt="{{$my_team->name}}">
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{route('show.team', $team->team_id)}}">{{$my_team->name}}</a>
                                                    </h4>
                                                    <?php $team_member_count = App\Models\UserTeam::where('approve_request', 1)->where('team_id', $team->team_id)->count(); ?>
                                                    <small class="text-muted">
                                                        {{$team_member_count}} members
                                                    </small>
                                                </div>
                                                <div class="col-3">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <input type="hidden" name="team_id" value="{{$team->team_id}}">
                                                    <input type="hidden" name="article_id" value="{{$article->id}}">
                                                    <?php $link = route('show.article', $article->id);
                                                        $article_data = [$article->title, $article->description, $link] ;
                                                    ?>
                                                    <input type="hidden" name="comment_body" value="{{ json_encode([$article->title, $article->description, $link]) }}">
                                                    <input type="hidden" name="file" value="{{substr($article->photo, 31)}}">
                                                    <input type="hidden" name="file_type" value="image">
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @else
                                    <div class="text-center mt-8 mb-8">
                                        <h3 class="text-muted"><i class="fe fe-users"></i> You have no teams</h3>
                                    </div>
                                @endif
                            </ul>
                        </div>
                    </form>
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
                                @elseif(count($notes) < 1)
                                @foreach($admin_notes as $note)
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1">
                                                    <a href="{{url('admin/notes')}}">
                                                        {{$note->comment}}
                                                    </a>
                                                </h4>
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
                                                    {{Str::words(ucwords(strtolower($note->content)), 20)}}
                                                </p>
                                                {{-- <p class="card-text small text-muted">
                                                    {{$note->created_at->diffForHumans()}}
                                                </p> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="text-center">
                                    <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
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
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this article?"))
            event.preventDefault();
        }
        function Copy()
        {
            var Url = document.getElementById("paste-box");
            // Url.value = window.location.href;
            Url.value = "{{route('articles', $article->id)}}";
            Url.focus();
            Url.select();
            document.execCommand("Copy");

            document.getElementById('hide-copy').style.display = 'none';
            document.getElementById('show-status').style.display = 'block';
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
        var jid = {{$article->id}};
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
            // var id = {{$article->id}};
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
            var contentId = "{{$article ? $article->id : ''}}";
            var resource_type = "article";
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
