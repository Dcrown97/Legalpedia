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
                        <div class="row text-center justify-content-center mt-2 mb-5">
                            <div class="col-3">
                                <a class="cursor-pointer publicText">
                                    <div id="public" class="note12">
                                        <span class="icon-1">
                                            <i class="mdi mdi-account-group"></i>
                                        </span>
                                    </div>
                                    <span class="t-1">
                                        Public
                                    </span>
                                </a>
                            </div>
                            <div class="col-3">
                                <a id="copy-text" class="cursor-pointer copiedText">
                                    <div id="copy" class="note12">
                                        <span class="icon-1">
                                            <i class="mdi mdi-content-copy"></i>
                                        </span>
                                    </div>
                                    <span class="t-1" id="hide-copy1">
                                        Copy
                                    </span>
                                    <span class="t-1 text-color" id="show-copy" style="display: none">
                                        copied!
                                    </span>
                                </a>
                            </div>
                            <div class="col-3">
                                <a class="cursor-pointer shareText">
                                    <div id="share" class="note12">
                                        <span class="icon-1">
                                            <i class="mdi mdi-share-variant-outline"></i>
                                        </span>
                                    </div>
                                    <span class="t-1">
                                        Share
                                    </span>
                                </a>
                            </div>
                            <div class="col-3">
                                <a class="cursor-pointer printText">
                                    <div id="print" class="note12">
                                        <span class="icon-1">
                                            <img src="{{asset('assets/images/printing-text-1.png')}}" alt="">
                                        </span>
                                    </div>
                                    <span class="t-1">
                                        Print
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="row justify-content-center" id="main">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.anote')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Make notes searchable by saving to public</p>
                                        <input type="text" id="input" style="opacity: 0; position: absolute">
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
                        <div class="row justify-content-center" id="shareToTeam" style="display: none">
                            <div data-list='{"valueNames": ["name"]}'>
                                <div class="card-header">
                                    <h4 class="card-header-title" id="exampleModalCenterTitle">
                                        Share Note to teams
                                    </h4>
                                </div>
                                <form action="{{route('share.anote')}}" method="POST">
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
                                                <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="orders" type="checkbox">
                                                <label class="form-check-label" for="orders">&nbsp;</label> All Teams
                                            </div>
                                        </div>
                                        <div class="col-auto me-n3">
                                            <input type="hidden" name="anote_id" id="anote-id">
                                            <input type="hidden" name="comment_body" id="anote-content">
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
                                                                    <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArray[]" id="ordersSelectOnes" value="{{$team->team_id}}">
                                                                    <label class="form-check-label" for="ordersSelect">&nbsp;</label>
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
                        <div class="row justify-content-center" id="printNote" style="display: none">
                            <div class="col-12">
                                <div class="card-header">
                                    <h4 class="card-header-title" id="exampleModalCenterTitle">
                                        Print note
                                    </h4>
                                    <a class="cursor-pointer btn btn-primary text-white printNow" onclick="printContent('printTag')">Print</a>
                                </div>
                                <div class="card-body">
                                    <div id="printTag"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printContent(elem)
        {
            var mywindow = window.open('', 'PRINT', 'height=800,width=1200');

            mywindow.document.write('<html><head><title>' + document.title  + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title  + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
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
        var jid = {{$rule_id}};

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
                    document.getElementById('note-id').value = annote.id;
                    document.getElementById('anote-id').value = response.anote.id;
                    document.getElementById('anote-content').value = response.anote.selector[0].exact;
                    document.getElementById('printTag').innerHTML = response.anote.selector[0].exact;
                    $('#save_public').modal('show');

                    $('.copiedText').click(function() {
                        var Url = document.getElementById("input");
                        Url.value =  response.anote.selector[0].exact;
                        Url.focus();
                        Url.select();
                        document.execCommand("Copy");
                        document.getElementById('hide-copy1').style.display = 'none';
                        document.getElementById('show-copy').style.display = 'initial';
                    });
                    $('.shareText').click(function() {
                        $('#main').hide();
                        $('#shareToTeam').show();
                        $('#printNote').hide();
                    });
                    $('.printText').click(function() {
                        $('#main').hide();
                        $('#shareToTeam').hide();
                        $('#printNote').show();
                    });
                    $('.publicText').click(function() {
                        $('#main').show();
                        $('#shareToTeam').hide();
                        $('#printNote').hide();
                    });
                }

            });

        });

        r.on('updateAnnotation', function(annotation, previous) {
          console.log('updated', previous, 'with', annotation);
        });
      })();
    </script>
    <script>
        var ruleId = {{$rule_id}};
        $(document).ready(function () {
            fetchAnote();
        });
        function fetchAnote() {
            $.ajax({
                type: 'GET',
                url: "/admin/rules-of-court/fetch-annotations/" + ruleId,
                success: function (response) {
                    console.log(response);
                    var array = response.anotes;
                    var objTo = document.getElementById('content');
                    $.each(array, function(key, element) {
                        var co = JSON.parse(element.content)
                        selectAndHighlightRange(objTo, co.selector[1].start, co.selector[1].end);
                    });
                }
            });
        }
        function getTextNodesIn(node) {
            var textNodes = [];
            if (node.nodeType == 3) {
                textNodes.push(node);
            } else {
                var children = node.childNodes;
                for (var i = 0, len = children.length; i < len; ++i) {
                    textNodes.push.apply(textNodes, getTextNodesIn(children[i]));
                }
            }
            return textNodes;
        }

        function setSelectionRange(el, start, end) {
            if (document.createRange && window.getSelection) {
                var range = document.createRange();
                range.selectNodeContents(el);
                var textNodes = getTextNodesIn(el);
                var foundStart = false;
                var charCount = 0, endCharCount;

                for (var i = 0, textNode; textNode = textNodes[i++]; ) {
                    endCharCount = charCount + textNode.length;
                    if (!foundStart && start >= charCount && (start < endCharCount || (start == endCharCount && i <= textNodes.length))) {
                        range.setStart(textNode, start - charCount);
                        foundStart = true;
                    }
                    if (foundStart && end <= endCharCount) {
                        range.setEnd(textNode, end - charCount);
                        break;
                    }
                    charCount = endCharCount;
                }

                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            } else if (document.selection && document.body.createTextRange) {
                var textRange = document.body.createTextRange();
                textRange.moveToElementText(el);
                textRange.collapse(true);
                textRange.moveEnd("character", end);
                textRange.moveStart("character", start);
                textRange.select();
            }
        }

        function makeEditableAndHighlight(colour) {
            sel = window.getSelection();
            if (sel.rangeCount && sel.getRangeAt) {
                range = sel.getRangeAt(0);
            }
            document.designMode = "on";
            if (range) {
                sel.removeAllRanges();
                sel.addRange(range);
            }
            // Use HiliteColor since some browsers apply BackColor to the whole block
            if (!document.execCommand("HiliteColor", false, colour)) {
                document.execCommand("BackColor", false, colour);
            }
            document.designMode = "off";
        }

        function highlight(colour) {
            var range, sel;
            if (window.getSelection) {
                // IE9 and non-IE
                try {
                    if (!document.execCommand("BackColor", false, colour)) {
                        makeEditableAndHighlight(colour);
                    }
                } catch (ex) {
                    makeEditableAndHighlight(colour)
                }
            } else if (document.selection && document.selection.createRange) {
                // IE <= 8 case
                range = document.selection.createRange();
                range.execCommand("BackColor", false, colour);
            }
        }

        function selectAndHighlightRange(id, start, end) {
            setSelectionRange(document.getElementById("content"), start, end);
            highlight("#ffa50033");
        }
    </script>
@endsection
