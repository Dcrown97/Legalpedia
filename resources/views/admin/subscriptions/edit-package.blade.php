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
                        <form class="tab-content pb-4" id="wizardSteps" action="{{route('update.package')}}" method="POST">
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
                                        <h6 class="text-uppercase text-muted mb-0">Step 1 of 2</h6>
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
                                    <label class="form-label mb-1">
                                        Category
                                    </label>
                                    <select multiple name="test[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                        <option value="{{$package['test']}}">{{$package['test']}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->category}}">{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="judgement_feature" type="checkbox" id="judgementCheck" {{ $package->judgement_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Judgements</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->judgement_feature !==NULL)
                                        <div id="show_judgement_content">
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
                                                        <input type="number" max="2021" name="judg_end_year" placeholder="2021" class="form-control"  value="{{$package->judg_end_year}}">
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
                                                            <option value="{{$package->judg_cat}}">{{$package->judg_cat}}</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->category}}">{{$category->category}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Area of Law
                                                        </label>
                                                        <select multiple name="judg_area_of_law[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Area of Law</option>
                                                            @foreach($area_of_laws as $area_of_law)
                                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_judgement_content" style="display: none">
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
                                                        <input type="number" max="2021" name="judg_end_year" placeholder="2021" class="form-control"  value="{{$package->judg_end_year}}">
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
                                                            <option value="{{$package->judg_cat}}">{{$package->judg_cat}}</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->category}}">{{$category->category}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Area of Law
                                                        </label>
                                                        <select multiple name="judg_area_of_law[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Area of Law</option>
                                                            @foreach($area_of_laws as $area_of_law)
                                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
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
                                        <input class="form-check-input list-checkbox" name="lfn_feature" type="checkbox" id="lfnCheck" {{ $package->lfn_feature !==NULL ? 'checked' : '' }}>
                                        <h5 class="pt-2 pl-2">Law of Federation</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->lfn_feature !==NULL)
                                        <div id="show_lfn_content">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
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
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Area of Law
                                                        </label>
                                                        <select multiple name="lfn_area_of_law[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Area of Law</option>
                                                            @foreach($area_of_laws as $area_of_law)
                                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_lfn_content" style="display: none">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
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
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Area of Law
                                                        </label>
                                                        <select multiple name="lfn_area_of_law[]" class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Area of Law</option>
                                                            @foreach($area_of_laws as $area_of_law)
                                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
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
                                        <input class="form-check-input list-checkbox" type="checkbox" name="roc_feature" id="rocCheck">
                                        <h5 class="pt-2 pl-2">Rule of Court</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->roc_feature !==NULL)
                                        <div id="show_roc_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="roc_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_roc_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="roc_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
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
                                        <input class="form-check-input list-checkbox" name="sroc_feature" type="checkbox" id="srocCheck">
                                        <h5 class="pt-2 pl-2">State Rule of Court</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->sroc_feature !==NULL)
                                        <div id="show_sroc_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="sroc_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_sroc_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Category
                                                </label>
                                                <select name="sroc_cat[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
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
                                        <input class="form-check-input list-checkbox" type="checkbox" name="form_feature" id="formCheck">
                                        <h5 class="pt-2 pl-2">Forms and Precedence</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->form_feature !==NULL)
                                        <div id="show_form_content">
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
                                        <input class="form-check-input list-checkbox" type="checkbox" name="article_feature" id="articleCheck">
                                        <h5 class="pt-2 pl-2">Legal Articles</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->article_feature !==NULL)
                                        <div id="show_article_content">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
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
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Area of Law
                                                        </label>
                                                        <select name="article_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Area of Law</option>
                                                            @foreach($area_of_laws as $area_of_law)
                                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_article_content" style="display: none">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
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
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Area of Law
                                                        </label>
                                                        <select name="article_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                            <option value="">Select Area of Law</option>
                                                            @foreach($area_of_laws as $area_of_law)
                                                                <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
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
                                        <input class="form-check-input list-checkbox" type="checkbox" name="maxim_feature" id="maximCheck">
                                        <h5 class="pt-2 pl-2">Legal Maxims</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->maxim_feature !==NULL)
                                        <div id="show_maxim_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="maxim_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_maxim_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="maxim_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="dict_feature" id="dictCheck">
                                        <h5 class="pt-2 pl-2">Legal Dictionary</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->dict_feature !==NULL)
                                        <div id="show_dict_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="dict_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_dict_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="dict_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="resource_feature" id="resourceCheck">
                                        <h5 class="pt-2 pl-2">Foreign Resources</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                    @if($package->resource_feature !==NULL)
                                        <div id="show_resource_content">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="resource_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div id="show_resource_content" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Area of Law
                                                </label>
                                                <select name="resource_area_of_law[]" multiple class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select Area of Law</option>
                                                    @foreach($area_of_laws as $area_of_law)
                                                        <option value="{{$area_of_law->area_of_law}}">{{$area_of_law->area_of_law}}</option>
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
                                        <h6 class="text-uppercase text-muted mb-0">Step 2 of 2</h6>
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
