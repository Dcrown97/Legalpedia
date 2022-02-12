@extends('layouts.admin.subscriptions')

@section('title')
    <title>Subscription Packages- Legalpedia</title>
@endsection

@section('content')
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <h6 class="header-pretitle">
                    </h6>
                    <h1 class="header-title">
                        Manage Subscription Packages
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                        <i class="fe fe-plus"></i> Add Packages
                    </a>
                </div>
                @include('elements.notifications')
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" data-list='{"valueNames": ["name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                <div class="card-header">
                    <form>
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                        <input class="form-control list-search" type="search" placeholder="Search">
                        <span class="input-group-text">
                            <i class="fe fe-search"></i>
                        </span>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <?php $package_no = 1; ?>
                    @if($packages)
                        <table class="table table-sm table-nowrap card-table">
                            <thead>
                                <tr>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Name</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Price</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Date Created</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Package Link</a></th>
                                    <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                                </tr>
                            </thead>
                            @foreach($packages as $package)
                                <tbody class="list">
                                    <tr>
                                        <td class="orders-order">{{$package_no}}</td>
                                        <?php $package_no++ ;?>
                                        <td class="orders-product name">{{$package->name}}</td>
                                        <td class="orders-total">₦{{number_format($package->price, 2)}}</td>
                                        <td class="orders-total">{{\Carbon\Carbon::parse($package->created_at)->toFormattedDateString()}}</td>
                                        @if($package->slug)
                                            <td class="orders-total"><a href="{{route('sub.pack', $package->slug)}}" target="_blank">{{route('sub.pack', $package->slug)}}</a></td>
                                            @else
                                            <td class="orders-total"><a href="{{url('/subscription-package')}}" target="_blank">{{url('/subscription-package')}}</a></td>
                                        @endif
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{route('edit.package', $package->id)}}" class="dropdown-item">
                                                        <i class="mdi mdi-pencil mr-2"></i>Edit
                                                    </a>
                                                    <form action="/admin/subscriptions/{{$package->id}}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                        @else
                        <div class="text-center">
                            <h1>No record found</h1>
                        </div>
                    @endif
                </div>
                <!-- Pagination -->
                <div class="row g-0">
                    <!-- Pagination (prev) -->
                    <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                        <li class="page-item">
                            <a class="page-link" href="#">
                            <i class="fe fe-arrow-left me-1"></i> Prev
                            </a>
                        </li>
                    </ul>
                    <!-- Pagination -->
                    <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                    <!-- Pagination (next) -->
                    <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="#">
                            Next <i class="fe fe-arrow-right ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-9">
        <div class="modal-content rounded">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Add Subscription</div>
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
                        <form class="tab-content pb-4" id="wizardSteps" action="{{route('store.package')}}" method="POST">
                            @csrf
                            <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel" aria-labelledby="wizardTabOne">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Name of Package
                                    </label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Description
                                    </label>
                                    <textarea name="description" rows="5" class="form-control" placeholder="Enter description"></textarea>
                                </div>
                                <div class="form-group priceamount">
                                    <label class="form-label mb-1">
                                        Price
                                    </label>
                                    <input type="number" name="price" class="form-control">
                                    <span class="curr">₦</span>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-label mb-1">
                                                Validity
                                            </label>
                                            <select name="validity" class="form-select">
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
                                            <input type="number" name="recur_date" placeholder="30" class="form-control">
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
                                        <input class="form-check-input list-checkbox" name="judgement_feature" type="checkbox" id="judgementCheck" value="judgement">
                                        <h5 class="pt-2 pl-2">Judgements</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                                <input type="number" min="1960" name="judg_single_year" placeholder="1960" class="form-control">
                                            </div>
                                        </div>
                                        <div id="range" style="display: none">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            From Year
                                                        </label>
                                                        <input type="number" min="1960" name="judg_start_year" placeholder="1960" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            To Year
                                                        </label>
                                                        <?php $current_year = date("Y"); ?>
                                                        <input type="number" max="{{$current_year}}" name="judg_end_year" placeholder="{{$current_year}}" class="form-control">
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="lfn_feature" type="checkbox" id="lfnCheck" value="lfn">
                                        <h5 class="pt-2 pl-2">Law of Federation</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                                <input type="number" name="lfn_single_year" min="1960" placeholder="1960" class="form-control">
                                            </div>
                                        </div>
                                        <div id="year_range" style="display: none">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            From Year
                                                        </label>
                                                        <input type="number" min="1960" name="lfn_start_year" placeholder="1960" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            To Year
                                                        </label>
                                                        <input type="number" max="{{$current_year}}" name="lfn_end_year" placeholder="{{$current_year}}" class="form-control">
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="roc_feature" id="rocCheck" value="rule of court">
                                        <h5 class="pt-2 pl-2">Rule of Court</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="sroc_feature" type="checkbox" id="srocCheck" value="state rule of court">
                                        <h5 class="pt-2 pl-2">State Rule of Court</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="form_feature" id="formCheck" value="forms">
                                        <h5 class="pt-2 pl-2">Forms and Precedence</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="article_feature" id="articleCheck" value="article">
                                        <h5 class="pt-2 pl-2">Legal Articles</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="maxim_feature" id="maximCheck" value="maxim">
                                        <h5 class="pt-2 pl-2">Legal Maxims</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="dict_feature" id="dictCheck" value="dictionary">
                                        <h5 class="pt-2 pl-2">Law Dictionary</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" type="checkbox" name="resource_feature" id="resourceCheck" value="resource">
                                        <h5 class="pt-2 pl-2">Foreign Resources</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
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
                                        <input class="form-check-input list-checkbox" name="team" type="checkbox" value="team">
                                        <h5 class="pt-2 pl-2">Can create Teams</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-n2">
                                        <input class="form-check-input list-checkbox" name="note" type="checkbox" value="note">
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
                                        <input class="form-check-input list-checkbox" name="share" type="checkbox" value="share">
                                        <h5 class="pt-2 pl-2">Can share Articles</h5>
                                        <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        Publish this package?
                                    </label>
                                    <select name="is_active" id="report-type" class="form-select" onchange="showDiv('show_report', 'report_message', this)">
                                        <option value="1">Publish</option>
                                        <option value="0">Don't publish</option>
                                    </select>
                                </div>
                                <hr class="my-5">
                                <div class="nav row align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>
                                    </div>
                                    <div class="col text-center">
                                        <h6 class="text-uppercase text-muted mb-0">Step 3 of 3</h6>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                            <span class="button__text"><i class="mdi mdi-check"></i> Create</span>
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
