@extends('layouts.admin.subscriptions')

@section('title')
    <title>{{$package->name}} - Legalpedia</title>
@endsection

@section('content')
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <a href="{{url('admin/subscriptions')}}" class="text-color mb-4"><i class="fe fe-arrow-left mr-2"></i> Back</a>
                        <h1 class="header-title">
                            Edit Subscription Package
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
                    <div class="card-body p-5">
                        <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.package', $package)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel" aria-labelledby="wizardTabOne">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Name of Package
                                    </label>
                                    <input type="text" name="name" class="form-control" value="{{$package->name}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Description
                                    </label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="Enter description">{{$package->description}}</textarea>
                                </div>
                                <div class="form-group priceamount">
                                    <label class="form-label mb-1">
                                        Price
                                    </label>
                                    <input type="number" name="price" value="{{$package->price}}" class="form-control">
                                    <span class="curr">₦</span>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Validity
                                            </label>
                                            <select name="validity" class="form-select">
                                                <option value="{{$package->validity}}" selected>{{$package->validity}}</option>
                                                <option value="Days">Days</option>
                                                <option value="Months">Months</option>
                                                <option value="Years">Years</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Recurring Date
                                            </label>
                                            <input type="number" name="recur_date" value="{{$package->recur_date}}" placeholder="30" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-5">
                                <div class="nav row align-items-center">
                                    <div class="col-auto">
                                        <button class="btn btn-white" type="reset">Cancel</button>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 1 of 3</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepTwo">Next <i class="mdi mdi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel" aria-labelledby="wizardTabTwo">
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <h1 class="mb-3">Features</h1>
                                        <p class="mb-5 text-muted">Add features to subscription package</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="judgement_feature" type="checkbox" id="judgementCheck" value="judgement" {{ $package->judgement_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Judgements</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->judgement_feature !==NULL)
                                        <div id="show_judgement_content">
                                            <div class="select_type">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year type
                                                    </label>
                                                    <select class="form-select" id="year_type" onchange="showDiv('single', 'range', this)">
                                                        <option value="single">Single Year</option>
                                                        <option value="range">Year range</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="single">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year
                                                    </label>
                                                    <input type="number" min="1960" name="judg_single_year" placeholder="1960" class="form-control" value="{{$package->judg_single_year}}">
                                                </div>
                                            </div>
                                            <div id="range" style="display: none">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                From Year
                                                            </label>
                                                            <input type="number" min="1960" name="judg_start_year" placeholder="1960" class="form-control" value="{{$package->judg_start_year}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                To Year
                                                            </label>
                                                            <?php $current_year = date("Y"); ?>
                                                            <input type="number" max="{{$current_year}}" name="judg_end_year" placeholder="{{$current_year}}" class="form-control" value="{{$package->judg_end_year}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Category
                                                            {{-- <small class="text-muted ml-4">
                                                                <button class="custom-button cursor text-color" id="select-all" type="button"> Select All Categories</button>
                                                            </small> --}}
                                                        </label>
                                                        @php
                                                            $judg_cat = json_decode($package->judg_cat);
                                                        @endphp
                                                        <select multiple name="judg_cat[]" id="judg-cat" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->category}}" @if($judg_cat){{ in_array($category->category, $judg_cat) ? 'selected' : '' }}@endif>{{$category->category}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Courts
                                                        </label>
                                                        @php
                                                            $judg_court = json_decode($package->judg_court);
                                                        @endphp
                                                        <select multiple name="judg_court[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Court</option>
                                                            @foreach($courts as $court)
                                                                <option value="{{$court->court}}" @if($judg_court){{ in_array($court->court, $judg_court) ? 'selected' : '' }}@endif>{{$court->court}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_judgement_content" style="display: none">
                                            <div class="select_type">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year type
                                                    </label>
                                                    <select class="form-select" id="year_type" onchange="showDiv('single', 'range', this)">
                                                        <option value="single">Single Year</option>
                                                        <option value="range">Year range</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="single">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year
                                                    </label>
                                                    <input type="number" min="1960" name="judg_single_year" placeholder="1960" class="form-control" value="{{$package->judg_single_year}}">
                                                </div>
                                            </div>
                                            <div id="range" style="display: none">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                From Year
                                                            </label>
                                                            <input type="number" min="1960" name="judg_start_year" placeholder="1960" class="form-control" value="{{$package->judg_start_year}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                To Year
                                                            </label>
                                                            <?php $current_year = date("Y"); ?>
                                                            <input type="number" max="{{$current_year}}" name="judg_end_year" placeholder="{{$current_year}}" class="form-control" value="{{$package->judg_end_year}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Category
                                                        </label>
                                                        <select multiple name="judg_cat[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->category}}">{{$category->category}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Courts
                                                        </label>
                                                        <select multiple name="judg_court[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Court</option>
                                                            @foreach($courts as $court)
                                                                <option value="{{$court->court}}">{{$court->court}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="lfn_feature" type="checkbox" id="lfnCheck" value="lfn" {{ $package->lfn_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Law of Federation</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->lfn_feature !==NULL)
                                        <div id="show_lfn_content">
                                            <div class="select_type">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year type
                                                    </label>
                                                    <select class="form-select" id="year" onchange="showYear('single_year', 'year_range', this)">
                                                        <option value="single_year">Single Year</option>
                                                        <option value="year_range">Year range</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="single_year">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year
                                                    </label>
                                                    <input type="number" name="lfn_single_year" min="1960" placeholder="1960" class="form-control" value="{{$package->lfn_single_year}}">
                                                </div>
                                            </div>
                                            <div id="year_range" style="display: none">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                From Year
                                                            </label>
                                                            <input type="number" min="1960" name="lfn_start_year" placeholder="1960" class="form-control" value="{{$package->lfn_start_year}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                To Year
                                                            </label>
                                                            <input type="number" max="{{$current_year}}" name="lfn_end_year" placeholder="{{$current_year}}" class="form-control" value="{{$package->lfn_end_year}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $lfn_cat = json_decode($package->lfn_cat)
                                                @endphp
                                                <select name="lfn_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}" @if($lfn_cat){{ in_array($category->category, $lfn_cat) ? 'selected' : '' }}@endif>{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_lfn_content" style="display: none">
                                            <div class="select_type">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year type
                                                    </label>
                                                    <select class="form-select" id="year" onchange="showYear('single_year', 'year_range', this)">
                                                        <option value="single_year">Single Year</option>
                                                        <option value="year_range">Year range</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="single_year">
                                                <div class="form-group">
                                                    <label class="form-label mb-1">
                                                        Year
                                                    </label>
                                                    <input type="number" name="lfn_single_year" min="1960" placeholder="1960" class="form-control" value="{{$package->lfn_single_year}}">
                                                </div>
                                            </div>
                                            <div id="year_range" style="display: none">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                From Year
                                                            </label>
                                                            <input type="number" min="1960" name="lfn_start_year" placeholder="1960" class="form-control" value="{{$package->lfn_start_year}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-1">
                                                                To Year
                                                            </label>
                                                            <input type="number" max="{{$current_year}}" name="lfn_end_year" placeholder="{{$current_year}}" class="form-control" value="{{$package->lfn_end_year}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="lfn_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="roc_feature" id="rocCheck" value="rule of court" {{ $package->roc_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Rule of Court</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->roc_feature !==NULL)
                                        <div id="show_roc_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Rule Category
                                                </label>
                                                @php
                                                    $roc_cat = json_decode($package->roc_cat);
                                                @endphp
                                                <select name="roc_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select rule category</option>
                                                    @foreach($rule_categories as $category)
                                                        <option value="{{$category->name}}" @if($roc_cat){{in_array($category->name, $roc_cat) ? 'selected' : ''}}@endif>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_roc_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Rule Category
                                                </label>
                                                <select name="roc_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select rule category</option>
                                                    @foreach($rule_categories as $category)
                                                        <option value="{{$category->name}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="sroc_feature" type="checkbox" id="srocCheck" value="state rule of court" {{ $package->sroc_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">State Rule of Court</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->sroc_feature !==NULL)
                                        <div id="show_sroc_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    State
                                                </label>
                                                @php
                                                    $sroc_state = json_decode($package->sroc_state);
                                                @endphp
                                                <select name="sroc_state[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select State</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->name}}" @if($sroc_state){{in_array($state->name, $sroc_state) ? 'selected' : ''}}@endif>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_sroc_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    State
                                                </label>
                                                <select name="sroc_state[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select State</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->name}}">{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="form_feature" id="formCheck" value="forms" {{ $package->form_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Forms and Precedence</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->form_feature !==NULL)
                                        <div id="show_form_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $form_cat = json_decode($package->form_cat);
                                                @endphp
                                                <select name="form_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}" @if($form_cat){{in_array($category->category, $form_cat) ? 'selected' : ''}}@endif>{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_form_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="form_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="article_feature" id="articleCheck" value="article" {{ $package->article_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Legal Articles</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->article_feature !==NULL)
                                        <div id="show_article_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $article_cat = json_decode($package->article_cat);
                                                @endphp
                                                <select name="article_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}" @if($article_cat){{in_array($category->category, $article_cat) ? 'selected' : ''}}@endif>{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_article_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="article_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="maxim_feature" id="maximCheck" value="maxim" {{ $package->maxim_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Legal Maxims</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->maxim_feature !==NULL)
                                        <div id="show_maxim_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $maxim_cat = json_decode($package->maxim_cat);
                                                @endphp
                                                <select name="maxim_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}" @if($maxim_cat){{in_array($category->category, $maxim_cat) ? 'selected' : ''}}@endif>{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_maxim_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="maxim_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="dict_feature" id="dictCheck" value="dictionary" {{ $package->dict_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Law Dictionary</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->dict_feature !==NULL)
                                        <div id="show_dict_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $dict_cat = json_decode($package->dict_cat);
                                                @endphp
                                                <select name="dict_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}" @if($dict_cat){{in_array($category->category, $dict_cat) ? 'selected' : ''}}@endif>{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_dict_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="dict_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="resource_feature" id="resourceCheck" value="resource" {{ $package->resource_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Foreign Resources</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->resource_feature !==NULL)
                                        <div id="show_resource_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                @php
                                                    $resource_cat = json_decode($package->resource_cat);
                                                @endphp
                                                <select name="resource_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}" @if($resource_cat){{in_array($category->category, $resource_cat) ? 'selected' : ''}}@endif>{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_resource_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="resource_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <hr class="my-5">
                                <div class="nav row align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-white" data-toggle="wizard" href="#wizardStepOne">Back</a>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 2 of 3</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn text-white btn-primary" data-toggle="wizard" href="#wizardStepThree">Next <i class="mdi mdi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="wizardStepThree" role="tabpanel" aria-labelledby="wizardTabThree">
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <h1 class="mb-3">More Features</h1>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="team" type="checkbox" value="team" {{ $package->team !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Can create Teams</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="note" type="checkbox" value="note" {{ $package->note !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Can add Notes</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="bookmark" type="checkbox" value="bookmark">
                                        <h5 class="pt-2 pl-2">Can add Bookmarks</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="share" type="checkbox" value="share" {{ $package->share !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Can share Articles</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="nav row align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 3 of 3</h6>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                            <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this package?"))
            event.preventDefault();
        }

        function showDiv(single, range, element)
        {
            document.getElementById(single).style.display = element.value == 'single' ? 'block' : 'none';
            document.getElementById(range).style.display = element.value == 'range' ? 'block' : 'none';
        }
        function showYear(single_year, year_range, element_type)
        {
            document.getElementById(single_year).style.display = element_type.value == 'single_year' ? 'block' : 'none';
            document.getElementById(year_range).style.display = element_type.value == 'year_range' ? 'block' : 'none';
        }

        // $('#select-all').click(function() {
        //     // $('#judg-cat option').prop('selected', true);
        //     $('select#judg-cat > option').prop('selected', 'selected');
        // });

        $(function () {
            $("#judgementCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_judgement_content").show();
                } else {
                    $("#show_judgement_content").hide();
                }
            });
            $("#lfnCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_lfn_content").show();
                } else {
                    $("#show_lfn_content").hide();
                }
            });
            $("#rocCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_roc_content").show();
                } else {
                    $("#show_roc_content").hide();
                }
            });
            $("#srocCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_sroc_content").show();
                } else {
                    $("#show_sroc_content").hide();
                }
            });
            $("#formCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_form_content").show();
                } else {
                    $("#show_form_content").hide();
                }
            });
            $("#articleCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_article_content").show();
                } else {
                    $("#show_article_content").hide();
                }
            });
            $("#dictCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_dict_content").show();
                } else {
                    $("#show_dict_content").hide();
                }
            });
            $("#maximCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_maxim_content").show();
                } else {
                    $("#show_maxim_content").hide();
                }
            });
            $("#resourceCheck").click(function () {
                if ($(this).is(":checked")) {
                    $("#show_resource_content").show();
                } else {
                    $("#show_resource_content").hide();
                }
            });
        });
    </script>
@endsection
