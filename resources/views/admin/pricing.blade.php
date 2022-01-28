@extends('layouts.pricing')

@section('title')
    <title>Pricing - Legalpedia</title>
@endsection

@section('content')
    <style>
        .alert-primary {
            background-color: #E3EDFF !important;
            border-color: #E3EDFF !important;
            color: #767676 !important;
        }
        .text-green-0{
            color: #32E017;
        }
        .text-4xl {
            font-size: 30px;
        }
        .bg-ellipses.bg-dark {
            /* background-image: radial-gradient(#E3EDFF,#E3EDFF 70%,transparent 70.1%) !important; */
            background-image: none !important;
        }
    </style>
    <div class="pt-7 pb-8 bg-dark bg-ellipses">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6">
                    <h1 class="display-3 text-center text-color">
                        Subscription Packages
                    </h1>
                    <p class="lead text-center text-muted">
                        Get unwavering access to thousands of resources on Legalpedia when you subscibe to any of these plans.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mt-n7">
            @if($packages)
                @foreach($packages as $package)
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-uppercase text-center text-muted my-4">
                                    {{$package->name}}
                                </h6>
                                <div class="row g-0 align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <div class="h2 mb-0">₦</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="display-3 mb-0">{{number_format($package->price, 2)}}</div>
                                    </div>
                                </div>
                                <div class="h6 text-uppercase text-center text-muted mb-5">
                                    @if($package->validity == 'Days')
                                        / {{$package->recur_date}} Days
                                        @elseif($package->validity == 'Months')
                                        / {{$package->recur_date}} Months
                                        @elseif($package->validity == 'Years')
                                        / {{$package->recur_date}} Years
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->judgement_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseJudg" role="button" aria-expanded="false" aria-controls="multiCollapseJudg">
                                                    <small>Judgements</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseJudg">
                                                    @if($package->judg_single_year)
                                                        <div class="mt-2 ml-3 d-flex justify-content-between">
                                                            <small>Cases in year {{$package->judg_single_year}} only</small> <i class="fe fe-check-circle text-success"></i>
                                                        </div>
                                                        @else
                                                        <div class="mt-2 ml-3 d-flex justify-content-between">
                                                            <small>Cases from year {{$package->judg_start_year}} - Year {{$package->judg_end_year}}</small> <i class="fe fe-check-circle text-success"></i>
                                                        </div>
                                                    @endif
                                                    <hr>
                                                    @php
                                                        $judg_court = json_decode($package->judg_court)
                                                    @endphp
                                                    @if($judg_court)
                                                        <div class="mt-3 ml-3">
                                                            <p><small >Courts</small></p>
                                                            @foreach ($judg_court as $court)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$court}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    <hr>
                                                    @php
                                                        $judg_cat = json_decode($package->judg_cat)
                                                    @endphp
                                                    @if($judg_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small >Categories</small></p>
                                                            @foreach ($judg_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Judgements</small> <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->lfn_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseLfn" role="button" aria-expanded="false" aria-controls="multiCollapseLfn">
                                                    <small>Laws of Federation</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseLfn">
                                                    @if($package->lfn_single_year)
                                                        <div class="mt-2 ml-3 d-flex justify-content-between">
                                                            <small>Laws in year {{$package->lfn_single_year}} only</small> <i class="fe fe-check-circle text-success"></i>
                                                        </div>
                                                        @else
                                                        <div class="mt-2 ml-3 d-flex justify-content-between">
                                                            <small>Laws from year {{$package->lfn_start_year}} - Year {{$package->lfn_end_year}}</small> <i class="fe fe-check-circle text-success"></i>
                                                        </div>
                                                    @endif
                                                    <hr>
                                                    @php
                                                        $lfn_cat = json_decode($package->lfn_cat);
                                                    @endphp
                                                    @if($lfn_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small >Categories</small></p>
                                                            @foreach ($lfn_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Laws of Federation</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->roc_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseRoc" role="button" aria-expanded="false" aria-controls="multiCollapseRoc">
                                                    <small>Rules of Court</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseRoc">
                                                    @php
                                                        $roc_cat = json_decode($package->roc_cat)
                                                    @endphp
                                                    @if($roc_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small >Categories</small></p>
                                                            @foreach ($roc_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Rules of Court</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->sroc_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseSroc" role="button" aria-expanded="false" aria-controls="multiCollapseSroc">
                                                    <small>State Rules of Court</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseSroc">
                                                    @php
                                                        $sroc_state = json_decode($package->sroc_state)
                                                    @endphp
                                                    @if($sroc_state)
                                                        <div class="mt-3 ml-3">
                                                            <p><small>States</small></p>
                                                            @foreach ($sroc_state as $state)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$state}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>State Rules of Court</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->form_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseForm" role="button" aria-expanded="false" aria-controls="multiCollapseForm">
                                                    <small>Forms and Precedents</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseForm">
                                                    @php
                                                        $form_cat = json_decode($package->form_cat)
                                                    @endphp
                                                    @if($form_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small>Categories</small></p>
                                                            @foreach ($form_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Forms and Precedents</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->article_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseArticle" role="button" aria-expanded="false" aria-controls="multiCollapseArticle">
                                                    <small>Legal Articles</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseArticle">
                                                    @php
                                                        $article_cat = json_decode($package->article_cat)
                                                    @endphp
                                                    @if($article_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small>Categories</small></p>
                                                            @foreach ($article_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Legal Articles</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->dict_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseDict" role="button" aria-expanded="false" aria-controls="multiCollapseDict">
                                                    <small>Law Dictionary</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseDict">
                                                    @php
                                                        $dict_cat = json_decode($package->dict_cat)
                                                    @endphp
                                                    @if($dict_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small>Categories</small></p>
                                                            @foreach ($dict_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Law Dictionary</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->maxim_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseMax" role="button" aria-expanded="false" aria-controls="multiCollapseMax">
                                                    <small>Legal Maxims</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseMax">
                                                    @php
                                                        $maxim_cat = json_decode($package->maxim_cat)
                                                    @endphp
                                                    @if($maxim_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small>Categories</small></p>
                                                            @foreach ($maxim_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Legal Maxims</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="list-group-item align-items-center justify-content-between px-0">
                                            @if($package->resource_feature)
                                                <a class="d-flex justify-content-between" data-toggle="collapse" href="#multiCollapseResource" role="button" aria-expanded="false" aria-controls="multiCollapseResource">
                                                    <small>Resources</small>
                                                    <i class="fe fe-check-circle text-success"></i>
                                                </a>
                                                <div class="collapse multi-collapse" id="multiCollapseResource">
                                                    @php
                                                        $resource_cat = json_decode($package->resource_cat)
                                                    @endphp
                                                    @if($resource_cat)
                                                        <div class="mt-3 ml-3">
                                                            <p><small>Categories</small></p>
                                                            @foreach ($resource_cat as $cat)
                                                                <p class="d-flex justify-content-between">
                                                                    <small>{{$cat}}</small> <i class="fe fe-check-circle text-success"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="d-flex justify-content-between">
                                                    <small>Resources</small>
                                                     <i class="fe fe-x-circle text-secondary"></i>
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                @if(Auth::user()->package_id == $package->id)
                                    <a href="{{route('checkout', $package->id)}}" class="btn w-100 text-color btn-custom">
                                        <i class="mdi mdi-crown"></i> Renew Package
                                    </a>
                                    @else
                                    <a href="{{route('checkout', $package->id)}}" class="btn w-100 text-white btn-primary">
                                        <i class="mdi mdi-crown"></i> Subscribe
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                <div class="text-center mt-8">
                    <h3 class="text-muted"><i class="fe fe-users"></i> No package available</h3>
                </div>
            @endif
        </div>
    </div>


@endsection
