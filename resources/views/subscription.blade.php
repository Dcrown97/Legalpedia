@extends('layouts.subscription')

@section('title')

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
<div class="text-center cont">
    <h3 class="package">PACKAGE FEATURES</h3>
    <h2 class="package1">Package features</h2>
    <div class="row row_pad">
        <div class="col-md-6 col-sm-12">
            <div class="text-white font_head">
                <h4>{{$package->name}}</h4>
                <h5 class="font_siz">Monthly</h5>
                <h1 class="siz">₦{{number_format($package->price, 2)}}</h1>
                <button class="btn bg-white my-2 my-sm-0 btn_pa ml-auto" type="submit" style="color: #EC6959;">Subscribe now</button>
            </div>
        </div>
        <div class="col-md-6 text-left pad_top">
            <h4 class="pad_top2">Features</h4>
            <div class="pad_top1">
                <div class="row">
                    @if($package->judgement_feature)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-success"></i> <span>Judgement</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-secondary"></i> <span>Judgement</span>
                        </div>
                    @endif
                    @if($package->article_feature)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-success"></i> <span>Articles</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Articles</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>LFN</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Notes</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>ROC</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Sharing</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>DIC</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Bookmarks</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Maxims</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Teams</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Foreign Resources</span>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Forms and Precedents</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
