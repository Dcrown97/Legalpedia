<!DOCTYPE html>
<html>

<head>
    <title>{{ $judgement_summary->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: darkred;
        }
    </style>
</head>

<body>
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
                <div class="row align-items-end">
                    <div class="col text-center">
                        <h1 class="header-title text-center mb-2" style="color: #990033">
                            {{ $judgement_summary->title }}
                        </h1>
                        {{-- <img src="{{ asset('assets/images/nigerian-coat-of-arms.png') }}" class="mb-2"
                            style="height: 150px;"> --}}
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
    <hr>
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
                        <hr class="my-4">
                        @php
                            $party_a_name = App\Models\JudgementPartyA::where(
                                'suit_no',
                                $judgement_summary->suit_no,
                            )->first();
                            $party_a_type = App\Models\PartyAType::where(
                                'id',
                                $judgement_summary->party_a_type_id,
                            )->first();
                        @endphp
                        <p class="card-text mb-1">{!! $party_a_name ? $party_a_name->party_a_names : '' !!} <span
                                class="text-muted">{{ $party_a_type ? $party_a_type->party_a_type : '' }}</span></p>
                        <hr class="my-4">
                        @php
                            $party_b_name = App\Models\JudgementPartyB::where(
                                'suit_no',
                                $judgement_summary->suit_no,
                            )->first();
                            $party_b_type = App\Models\PartyBType::where(
                                'id',
                                $judgement_summary->party_b_type_id,
                            )->first();
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
                        <h3 class="text-muted">RATIONES DECIDENDI</h3>
                        <hr class="my-4">
                        <?php $ratios = App\Models\SummaryRatio::where('suit_no', $judgement_summary->suit_no)->get(); ?>
                        @if ($ratios)
                            @foreach ($ratios as $ratio)
                                <h4 class="text-muted"
                                    id="{{ returnHighlightText($ratio->heading, $searchData) == true ? 'ratio' : '' }}">
                                    {!! highlightText($ratio->heading, $searchData) !!}</h4>
                                <hr class="my-4">
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
                            <h3 class="mr-2 text-color" onclick="readFunction()" id="hide"><i
                                    class="mdi mdi-plus"></i>
                                Full Judgement</h3>
                            <h3 class="text-muted" id="show" onclick="hideFunction()" style="display: none">FULL
                                JUDGEMENT</h3>
                        </span>
                        <div class="">
                            <div class="collapse multi-collapse" id="multiCollapse">
                                <?php $full_judgement = App\Models\Judgement::where('suit_no', 'LIKE', '%' . $judgement_summary->suit_no . '%')->first(); ?>
                                @php
                                    $list = explode(
                                        "\n",
                                        highlightText($full_judgement ? $full_judgement->judgement : '', $searchData),
                                    );
                                    $tlist = '<ol>';
                                    foreach ($list as $num => $item) {
                                        $tlist .=
                                            '<li class="nu">' . htmlspecialchars_decode($item, ENT_QUOTES) . '</li>';
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
            </div>
        </div>
    </div>
</body>

</html>
