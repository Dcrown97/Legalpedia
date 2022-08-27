@extends('layouts.admin.judgements')

@section('title')
    <title>{{ $judgement_summary->title }} - Legalpedia</title>
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

        .note {
            overflow: hidden;
            background: #ec6959;
            width: 80px;
            height: 80px;
            /* position: absolute; */
            right: 20px;
            border-radius: 100%;
            position: fixed;
            top: 80%;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
        }

        .note .icon {
            color: #fff;
            font-size: 30px;
            padding: 15px 0 0 25px;
        }

        a .note {
            transition: .3s;
        }

        a .note:hover {
            margin-top: -10px;
            transition: .3s;
            box-shadow: 0 10px 35px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
        }

        ol .nu::before {
            color: #95aac9 !important;
            font-size: 10px;
        }
    </style>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    @php
    if (isset(request()->search) && !empty(request()->search)) {
        $searchData = request()->search;
    } elseif (isset(request()->year_result) && !empty(request()->year_result)) {
        $searchData = request()->year_result;
    } elseif (isset(request()->more_result) && !empty(request()->more_result)) {
        $searchData = request()->more_result;
    } else {
        $searchData = '';
    }
    @endphp
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end mb-4">
                    <div class="col">
                        <a href="{{ url('admin/judgements') }}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i>
                            Back</a>
                    </div>
                    @if (Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{ route('edit.judgement', $judgement_summary->id) }}"
                                class="btn text-white btn-primary">
                                <i class="mdi mdi-pencil"></i> Edit Judgement
                            </a>
                        </div>
                    @endif
                </div>
                <div class="row align-items-end">
                    <div class="col text-center">
                        <h1 class="header-title text-center mb-2" style="color: #990033">
                            {{ $judgement_summary->title }}
                        </h1>
                        <img src="{{ asset('assets/images/nigerian-coat-of-arms.png') }}" class="mb-2"
                            style="height: 150px;">
                        <h3 class="text-green mb-2">Legalpedia Citation: {{ $judgement_summary->lp_citation }}</h3>
                        <?php $court = App\Models\Court::where('id', $judgement_summary->court_id)->first(); ?>
                        <h3 class="card-text text-color mb-2">{{ $court->court }}</h3>
                        <?php $holden = App\Models\Holden::where('id', $judgement_summary->holden_at_id)->first(); ?>
                        <h3 class="card-text text-color mb-2">{{ $holden ? $holden->holden_at : '' }}</h3>
                        <h3 class="card-text text-color mb-2">
                            {{ \Carbon\Carbon::parse($judgement_summary->judgement_date)->format('D') }}
                            {{ \Carbon\Carbon::parse($judgement_summary->judgement_date)->toFormattedDateString() }}
                        </h3>
                        <h3 class="text-green mb-2">Suit Number: <span
                                class="text-black">{{ $judgement_summary->suit_no }}</span></h3>
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
                        <h3 class="text-muted">CORAM</h3>
                        <hr class="my-4">
                        <?php $judg_coram = App\Models\JudgementCoram::where('suit_no', $judgement_summary->suit_no)->get(); ?>
                        @if ($judg_coram)
                            @foreach ($judg_coram as $coram)
                                <?php $coram = App\Models\Coram::where('id', $coram->coram_id)->first(); ?>
                                <p class="card-text mb-1">{{ $coram->name }}</p>
                            @endforeach
                        @endif
                        <hr class="my-4">
                        <h3 class="text-muted">PARTIES</h3>
                        {{-- <hr class="my-4">
                        <h4 class="text-muted" id="ratio">PARTY A</h4> --}}
                        <hr class="my-4">
                        @php
                            $party_a_name = App\Models\JudgementPartyA::where('suit_no', $judgement_summary->suit_no)->first();
                            $party_a_type = App\Models\PartyAType::where('id', $judgement_summary->party_a_type_id)->first();
                        @endphp
                        <p class="card-text mb-1">{!! $party_a_name ? $party_a_name->party_a_names : '' !!} <span
                                class="text-muted">{{ $party_a_type ? $party_a_type->party_a_type : '' }}</span></p>
                        {{-- <hr class="my-4">
                        <h4 class="text-muted" id="ratio">PARTY B</h4> --}}
                        <hr class="my-4">
                        @php
                            $party_b_name = App\Models\JudgementPartyB::where('suit_no', $judgement_summary->suit_no)->first();
                            $party_b_type = App\Models\PartyBType::where('id', $judgement_summary->party_b_type_id)->first();
                        @endphp
                        <p class="card-text mb-1">{!! $party_b_name ? $party_b_name->party_b_names : '' !!} <span
                                class="text-muted">{{ $party_b_type ? $party_b_type->party_b_type : '' }}</span></p>
                        <hr class="my-4">
                        <h3 class="text-muted">AREA(S) OF LAW</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->area_of_law !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">SUMMARY OF FACTS</h3>
                        <p class="card-text mb-1"
                            id="{{ returnHighlightText($judgement_summary->summary_of_facts, $searchData) == true ? 'sum' : '' }}">
                            {!! htmlspecialchars_decode(
                                nl2br(e(highlightText($judgement_summary->summary_of_facts, $searchData))),
                                ENT_QUOTES,
                            ) !!}</p>
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
                        <?php $ratios = App\Models\SummaryRatio::where('suit_no', $judgement_summary->suit_no)->get(); ?>
                        @if ($ratios)
                            @foreach ($ratios as $ratio)
                                <h4 class="text-muted"
                                    id="{{ returnHighlightText($ratio->heading, $searchData) == true ? 'ratio' : '' }}">
                                    {!! highlightText($ratio->heading, $searchData) !!}</h4>
                                <hr class="my-4">
                                {{-- <p class="card-text mb-1">{!! nl2br(e(strip_tags($ratio->body))) !!}</p> --}}
                                <p class="card-text mb-1"
                                    id="{{ returnHighlightText($ratio->body, $searchData) == true ? 'ratio' : '' }}">
                                    {!! htmlspecialchars_decode(nl2br(e($ratio->body)), ENT_QUOTES) !!}</p>
                                <hr class="my-4">
                            @endforeach
                        @endif
                        <h3 class="text-muted">CASES CITED</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->cases_cited !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">STATUTES REFERRED TO</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->statutes_cited !!}</p>
                        <hr class="my-4">
                        <h3 class="text-muted">OTHER CITATIONS</h3>
                        <hr class="my-4">
                        <p class="card-text mb-1">{!! $judgement_summary->other_citations !!}</p>
                        <hr class="my-4">
                        <span data-toggle="collapse" href="#multiCollapse" role="button" aria-expanded="false"
                            aria-controls="multiCollapse">
                            <h3 class="mr-2 text-color" onclick="readFunction()" id="hide"><i class="mdi mdi-plus"></i>
                                Read Full Judgement</h3>
                            <h3 class="text-muted" id="show" onclick="hideFunction()" style="display: none">FULL
                                JUDGEMENT</h3>
                        </span>
                        <div class="">
                            <div class="collapse multi-collapse" id="multiCollapse">
                                <?php $full_judgement = App\Models\Judgement::where('suit_no', 'LIKE', '%' . $judgement_summary->suit_no . '%')->first(); ?>
                                @php
                                    $list = explode("\n", highlightText($full_judgement ? $full_judgement->judgement : '', $searchData));
                                    $tlist = '<ol>';
                                    foreach ($list as $num => $item) {
                                        $tlist .= '<li class='nu'>' . htmlspecialchars_decode($item, ENT_QUOTES) . '</li>';
                                    }
                                    $tlist .= '</ol>';
                                @endphp
                                <p id="{{ returnHighlightText($full_judgement ? $full_judgement->judgement : '', $searchData) == true ? 'judg' : '' }}"
                                    class="card-text mb-1 mt-4" style="line-height: 25px; font-weight: 400">
                                    {!! $tlist !!}</p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h3 class="text-muted">COUNSEL</h3>
                        <hr class="my-4">
                        <?php $counsels = App\Models\JudgementCounsel::where('suit_no', $judgement_summary->suit_no)->first(); ?>
                        <p class="card-text mb-1">{!! $counsels ? $counsels->counsels : '' !!}</p>
                    </div>
                </div>
                {{-- <div class="d-flex">
                    <a href="#" id="copy-text" class="cursor-pointer">
                        <div id="showCopy" class="note">
                            <span class="icon">
                                <i class="mdi mdi-content-copy"></i>
                            </span>
                        </div>
                    </a>
                    <a href="#" class="cursor-pointer">
                        <div id="showShare" class="note cml-6">
                            <span class="icon">
                                <i class="mdi mdi-share-variant-outline"></i>
                            </span>
                        </div>
                    </a>
                    <a href="#" class="cursor-pointer">
                        <div id="showPrint" class="note cml-12">
                            <span class="icon">
                                <img src="{{asset('assets/images/printing-text.png')}}" alt="">
                            </span>
                        </div>
                    </a>
                </div> --}}
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
                            <a href="{{ url('admin/notes') }}" class="btn text-white btn-primary">
                                View all <i class="mdi arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush list my-n3">
                            @if (count($notes) > 0)
                                @foreach ($notes as $note)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div
                                                        class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
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
                                                        {{ ucwords(strtolower($comment_type->value)) }}
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
                                                    <div
                                                        class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="small text-gray-700 mb-0">
                                                    {{ Str::words(ucwords(strtolower($note->content->selector[0]->exact)), 20) }}
                                                </p>
                                                <p class="card-text small text-muted">
                                                    {{ $note->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @elseif(count($notes) < 1)
                                @foreach ($admin_notes as $note)
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div
                                                        class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <h5 class="mb-1">
                                                    <a href="{{ url('admin/notes') }}">
                                                        {{ $note->comment }}
                                                    </a>
                                                    </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm" style="visibility: hidden">
                                                    <div
                                                        class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="small text-gray-700 mb-0">
                                                    {{ Str::words(ucwords(strtolower($note->content)), 20) }}
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
                    <h5 class="fs-1 fw-boldest">Make your notes public or private</h5>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y">
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
                                    <span class="t-1" id="hide-copy">
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
                                            <img src="{{ asset('assets/images/printing-text-1.png') }}" alt="">
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
                                <form class="tab-content pb-4" id="wizardSteps" action="{{ route('update.anote') }}"
                                    method="POST">
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
                                    <button type="submit" onclick="this.classList.toggle('button--loading')"
                                        class="btn button_load text-white w-100 btn-primary">
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
                                <form action="{{ route('share.anote') }}" method="POST">
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
                                                <input class="form-check-input list-checkbox-all" name="checkBoxArray"
                                                    id="ordersSelectAll" type="checkbox">
                                                <label class="form-check-label" for="ordersSelectAll">&nbsp;</label> All
                                                Teams
                                            </div>
                                        </div>
                                        <div class="col-auto me-n3">
                                            <input type="hidden" name="anote_id" id="anote-id">
                                            <input type="hidden" name="comment_body" id="anote-content">
                                            <button type="submit" name="share_all"
                                                onclick="this.classList.toggle('button--loading')"
                                                class="btn button_load text-white w-100 btn-primary">
                                                <span class="button__text"><i class="mdi mdi-share-variant-outline"></i>
                                                    Share</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush list my-n3">
                                            @if (count($teams) > 0)
                                                @foreach ($teams as $team)
                                                    <li class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-1">
                                                                <div class="form-check mb-n2">
                                                                    <input class="form-check-input list-checkbox"
                                                                        type="checkbox" name="checkBoxArray[]"
                                                                        id="ordersSelectOne"
                                                                        value="{{ $team->team_id }}">
                                                                    <label class="form-check-label"
                                                                        for="ordersSelectOne">&nbsp;</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <?php $my_team = App\Models\Team::where('id', $team->team_id)->first(); ?>
                                                                <a href="{{ route('show.team', $team->team_id) }}"
                                                                    class="avatar avatar-lg">
                                                                    <img src="{{ $my_team->photo }}"
                                                                        class="avatar-img rounded-circle w-2 h-2"
                                                                        alt="{{ $my_team->name }}">
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <h4 class="mb-1 name">
                                                                    <a
                                                                        href="{{ route('show.team', $team->team_id) }}">{{ $my_team->name }}</a>
                                                                </h4>
                                                                <?php $team_member_count = App\Models\UserTeam::where('approve_request', 1)
                                                                    ->where('team_id', $team->team_id)
                                                                    ->count(); ?>
                                                                <small class="text-muted">
                                                                    {{ $team_member_count }} members
                                                                </small>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::user()->id }}">
                                                                <input type="hidden" name="team_id"
                                                                    value="{{ $team->team_id }}">
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                <div class="text-center mt-8 mb-8">
                                                    <h3 class="text-muted"><i class="fe fe-users"></i> You have no teams
                                                    </h3>
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
                                    <a class="cursor-pointer btn btn-primary text-white printNow"
                                        onclick="printContent('printTag')">Print</a>
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function printContent(elem) {
            var mywindow = window.open('', 'PRINT', 'height=800,width=1200');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }

        // var t = '';
        // function gText(e) {
        //     t = (document.all) ? document.selection.createRange().text : document.getSelection();

        //     document.getElementById('input').value = t;
        // }
        // document.onmouseup = gText;
        // if (!document.all) document.captureEvents(Event.MOUSEUP);
    </script>

    {{-- <script>
        $(document).ready(function(){

            $('html').click(function(e){
                setTimeout(() => {
                    mouseX=e.pageX;
                    mouseY=e.pageY;
                    var bodyTop = document.documentElement.scrollTop + document.body.scrollTop;
                    var windowWidth  = $(window).outerWidth();
                    var windowHeight = $(window).outerHeight();
                    let left_p = parseInt($('.r6o-editor').css('left'));
                    let top_p = parseInt($('.r6o-editor').css('top')) - 100;

                    let left = left_p + 'px';
                    let top = top_p + 'px';

                    console.log(left, top);
                    $('#showCopy').css({position:"absolute",top,left});
                    $('#showCopy').show();
                    $('#showShare').css({position:"absolute",top,left});
                    $('#showShare').show();
                    $('#showPrint').css({position:"absolute",top,left});
                    $('#showPrint').show();

                    if($('.r6o-editor').css('left') == undefined) {
                        $('#showCopy').hide();
                        $('#showShare').hide();
                        $('#showPrint').hide();
                    }
                }, 1000);

            });
        });

    </script> --}}
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
                widgets: [{
                        widget: 'COMMENT'
                    },
                    {
                        widget: 'TAG',
                        vocabulary: ['Place', 'Person', 'Event', 'Organization', 'Animal']
                    }
                ],
                relationVocabulary: ['isRelated', 'isPartOf', 'isSameAs ']
            });

            // r.loadAnnotations('annotations.w3c.json');
            var jid = {{ $judgement_summary->id }};

            r.on('createAnnotation', function(annote) {
                console.log(annote.target)
                var userId = "{{ Auth::user()->id }}";
                var contentId = "{{ $judgement_summary ? $judgement_summary->suit_no : '' }}";
                var resource_type = "judgement";
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
                    success: function(response) {
                        console.log(response);
                        document.getElementById('note-id').value = annote.id;
                        document.getElementById('anote-id').value = response.anote.id;
                        document.getElementById('anote-content').value = response.anote.selector[0]
                            .exact;
                        document.getElementById('printTag').innerHTML = response.anote.selector[0]
                            .exact;
                        $('#save_public').modal('show');

                        $('.copiedText').click(function() {
                            var Url = document.getElementById("input");
                            Url.value = response.anote.selector[0].exact;
                            Url.focus();
                            Url.select();
                            document.execCommand("Copy");
                            document.getElementById('hide-copy').style.display = 'none';
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
        var caseId = {{ $judgement_summary->id }};
        $(document).ready(function() {
            fetchAnote();
        });

        function fetchAnote() {
            $.ajax({
                type: 'GET',
                url: "/admin/judgements/fetch-annotations/" + caseId,
                success: function(response) {
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
                var charCount = 0,
                    endCharCount;

                for (var i = 0, textNode; textNode = textNodes[i++];) {
                    endCharCount = charCount + textNode.length;
                    if (!foundStart && start >= charCount && (start < endCharCount || (start == endCharCount && i <=
                            textNodes.length))) {
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
