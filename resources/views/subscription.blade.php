@extends('layouts.subscription')

@section('title')
<title>{{$package->name}} Subscription Package</title>
@endsection

@section('content-1')
<div class="text-center container cont">
    <div class="container">
        <h3 class="package"> PACKAGE DESCRIPTION</h3>
        <h2 class="package1">{{$package->name}} Package</h2>
        <p class="package3">{!! $package->description !!}</p>
    </div>
</div>
@endsection

@section('content-2')
<style>
    .custom-feature {
       text-decoration: none !important;
       color: #EC6959;
    }
    .text-color {
       color: #EC6959;
    }
</style>
<div class="text-center cont">
    <h3 class="package">PACKAGE FEATURES</h3>
    <h2 class="package1">Package features</h2>
    <div class="row row_pad">
        <div class="col-md-6 col-sm-12">
            <div class="text-white font_head">
                <h4>{{$package->name}}</h4>
                <h5 class="font_siz">Monthly</h5>
                <h5 class="font_siz">(Package renews after {{$package->recur_date}} {{$package->validity}})</h5>
                <h1 class="siz">₦{{number_format($package->price, 2)}}</h1>

                <a href="{{route('checkout', $package->id)}}" class="btn bg-white my-2 my-sm-0 btn_pa ml-auto" style="color: #EC6959;">Subscribe now</a>
            </div>
        </div>
        <div class="col-md-6 text-left pad_top">
            <h4 class="pad_top2">Features</h4>
            <div class="pad_top1">
                <div class="row">
                    @if($package->judgement_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseJudg" role="button" aria-expanded="false" aria-controls="multiCollapseJudg">
                                <i class="fas fa-check-circle text-success"></i> <span>Judgements</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseJudg">
                                @if($package->judg_single_year)
                                    <div class="mt-2 ml-3">
                                        <i class="mdi mdi-check text-success"></i> <span>Cases in year {{$package->judg_single_year}} only</span>
                                    </div>
                                    @else
                                    <div class="mt-2 ml-3">
                                        <i class="mdi mdi-check text-success"></i> <span>Cases from year {{$package->judg_start_year}} - Year {{$package->judg_end_year}}</span>
                                    </div>
                                @endif
                                @if($package->judg_court)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Courts</h6>
                                        @php
                                            $judg_court = json_decode($package->judg_court)
                                        @endphp
                                        @foreach ($judg_court as $court)
                                            <p><i class="mdi mdi-check text-success"></i> {{$court}}</p>
                                        @endforeach
                                    </div>
                                @endif
                                @if($package->judg_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $judg_cat = json_decode($package->judg_cat)
                                        @endphp
                                        @foreach ($judg_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-c-circle text-secondary"></i> <span>Judgements</span>
                        </div>
                    @endif
                    @if($package->article_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseArticle" role="button" aria-expanded="false" aria-controls="multiCollapseArticle">
                                <i class="fas fa-check-circle text-success"></i> <span>Legal Articles</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseArticle">
                               @if($package->article_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $article_cat = json_decode($package->article_cat)
                                        @endphp
                                        @foreach ($article_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Legal Articles</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($package->lfn_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseLfn" role="button" aria-expanded="false" aria-controls="multiCollapseLfn">
                                <i class="fas fa-check-circle text-success"></i> <span>Laws of Federation</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseLfn">
                                @if($package->lfn_single_year)
                                    <div class="mt-2 ml-3">
                                        <i class="mdi mdi-check text-success"></i> <span>Laws in year {{$package->lfn_single_year}} only</span>
                                    </div>
                                    @else
                                    <div class="mt-2 ml-3">
                                        <i class="mdi mdi-check text-success"></i> <span>Laws from year {{$package->lfn_start_year}} - Year {{$package->lfn_end_year}}</span>
                                    </div>
                                @endif
                               @if($package->lfn_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $lfn_cat = json_decode($package->lfn_cat)
                                        @endphp
                                        @foreach($lfn_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Laws of Federation</span>
                        </div>
                    @endif
                    @if($package->note)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-success"></i> <span>Notes</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Notes</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($package->roc_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseRule" role="button" aria-expanded="false" aria-controls="multiCollapseRule">
                                <i class="fas fa-check-circle text-success"></i> <span>Rules of Court</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseRule">
                               @if($package->roc_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $roc_cat = json_decode($package->roc_cat)
                                        @endphp
                                        @foreach ($roc_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Rules of Court</span>
                        </div>
                    @endif
                    @if($package->share)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-secondary"></i> <span>Sharing</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Sharing</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($package->sroc_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseStateRule" role="button" aria-expanded="false" aria-controls="multiCollapseStateRule">
                                <i class="fas fa-check-circle text-success"></i> <span>State Rules of Court</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseStateRule">
                               @if($package->sroc_state)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">States</h6>
                                        @php
                                            $sroc_state = json_decode($package->sroc_state)
                                        @endphp
                                        @foreach ($sroc_state as $state)
                                            <p><i class="mdi mdi-check text-success"></i> {{$state}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>State Rules of Court</span>
                        </div>
                    @endif
                    @if($package->bookmark)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-secondary"></i> <span>Bookmarks</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Bookmarks</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($package->maxim_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseMaxim" role="button" aria-expanded="false" aria-controls="multiCollapseMaxim">
                                <i class="fas fa-check-circle text-success"></i> <span>Legal Maxims</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseMaxim">
                               @if($package->maxim_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $maxim_cat = json_decode($package->maxim_cat)
                                        @endphp
                                        @foreach ($maxim_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Legal Maxims</span>
                        </div>
                    @endif
                    @if($package->dict_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseDict" role="button" aria-expanded="false" aria-controls="multiCollapseDict">
                                <i class="fas fa-check-circle text-success"></i> <span>Law Dictionary</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseDict">
                               @if($package->dict_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $dict_cat = json_decode($package->dict_cat)
                                        @endphp
                                        @foreach ($dict_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Law Dictionary</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($package->resource_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseResource" role="button" aria-expanded="false" aria-controls="multiCollapseResource">
                                <i class="fas fa-check-circle text-success"></i> <span>Foreign Resources</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseResource">
                            @if($package->resource_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $resource_cat = json_decode($package->resource_cat)
                                        @endphp
                                        @foreach ($resource_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Foreign Resources</span>
                        </div>
                    @endif
                    @if($package->team)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-success"></i> <span>Teams</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Teams</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($package->form_feature)
                        <div class="col-md-6 pad_bot">
                            <a class="custom-feature" data-toggle="collapse" href="#multiCollapseForm" role="button" aria-expanded="false" aria-controls="multiCollapseForm">
                                <i class="fas fa-check-circle text-success"></i> <span>Forms and Precedents</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="collapse multi-collapse" id="multiCollapseForm">
                            @if($package->form_cat)
                                    <div class="mt-3 ml-3">
                                        <h6 class="text-color">Categories</h6>
                                        @php
                                            $form_cat = json_decode($package->form_cat)
                                        @endphp
                                        @foreach ($form_cat as $cat)
                                            <p><i class="mdi mdi-check text-success"></i> {{$cat}}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Forms and Precedents</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
