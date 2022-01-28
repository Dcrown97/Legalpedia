@extends('layouts.admin.state-rules-of-court')

@section('title')
    <title>State Rules of Court - Legalpedia</title>
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
                            State Rules of Court
                        </h1>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="#" class="btn text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                <i class="fe fe-plus"></i> Add State Rules
                            </a>
                        </div>
                    @endif
                    @include('elements.notifications')
                </div>
                <div class="row align-items-end justify-content-end mt-4 p-3">
                    <form action="{{route('admin.state-rules-of-court')}}" method="GET" class="me-3 d-flex">
                        <select name="name" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                            @foreach($states as $state)
                                <option value="{{$state->name}}" {{ $state->name == $selected_name['name'] ? 'selected' : '' }}>{{$state->name}}</option>
                            @endforeach
                        </select>
                        <button type="submit" name="fetch_rule" onclick="this.classList.toggle('button--loading')" class="ml-3 mr-3 btn button_load text-white btn-sm btn-primary p-2">
                            <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                        </button>
                        <a href="{{url('admin/state-rules-of-court')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-mobile">
                            <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                        </a>
                    </form>
                </div>
                <div class="row">
                    <div class="col-3">
                        <a href="{{url('admin/state-rules-of-court')}}" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary btn-sm p-2 hide-desk show-mobile">
                            <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="header-body mb-4 mt-n5 mt-md-n6">
          <div class="row align-items-center">
            <div class="col">
                <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="order-tab" data-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="true">
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="part-tab" data-toggle="tab" href="#part" role="tab" aria-controls="part" aria-selected="false">
                            Parts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="schedule-tab" data-toggle="tab" href="#schedule" role="tab" aria-controls="schedule" aria-selected="false">
                            Schedules
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="false">
                            Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="probate-tab" data-toggle="tab" href="#probate" role="tab" aria-controls="probate" aria-selected="false">
                            Probate Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="civil-tab" data-toggle="tab" href="#civil" role="tab" aria-controls="civil" aria-selected="false">
                            Civil Forms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="appendix-tab" data-toggle="tab" href="#appendix" role="tab" aria-controls="appendix" aria-selected="false">
                            Appendix
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="wizardSteps">
                    <div class="tab-pane fade show active" id="order" role="tabpanel" aria-labelledby="order-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Orders</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($order_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($orders) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($orders as $order)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $order->id)}}">{{$order->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $order->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$order->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteOrderFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="tab-pane fade" id="part" role="tabpanel" aria-labelledby="part-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Parts</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($part_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($parts) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach ($parts as $part)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $part->id)}}">{{$part->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $part->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$part->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deletePartFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Schedules</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($schedule_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($schedules) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach ($schedules as $schedule)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $schedule->id)}}">{{$schedule->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $schedule->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$schedule->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteScheduleFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Forms</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($form_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($forms as $form)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $form->id)}}">{{$form->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $form->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$form->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteFormFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="tab-pane fade" id="probate" role="tabpanel" aria-labelledby="probate-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Probate Forms</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($probate_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($probate_forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($probate_forms as $probate_form)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $probate_form->id)}}">{{$probate_form->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $probate_form->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$probate_form->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteProbateFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="tab-pane fade" id="civil" role="tabpanel" aria-labelledby="civil-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Civil Forms</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($civil_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($civil_forms) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($civil_forms as $civil_form)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $civil_form->id)}}">{{$civil_form->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $civil_form->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$civil_form->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteCivilFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                    <div class="tab-pane fade" id="appendix" role="tabpanel" aria-labelledby="appendix-tab">
                        <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <h4 class="card-header-title">Appendix</h4>
                            </div>
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                         <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search titles">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-auto me-n3">
                                        <h4>{{number_format($appendix_count)}} records</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($appendices) > 0)
                                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                                        @foreach($appendices as $appendix)
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-1 item-name">
                                                            <i class="fe fe-file mr-1"></i><a href="{{route('show.state-rule', $appendix->id)}}">{{$appendix->title}}</a>
                                                        </h4>
                                                    </div>
                                                    @if(Auth::user()->role->name == 'Admin')
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a href="{{route('edit.rule', $appendix->id)}}" class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/rules-of-court/{{$appendix->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deleteAppendixFunction();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="text-center">
                                        <h3 class="text-muted"><i class="fe fe-file"></i> No record found</h3>
                                    </div>
                                @endif
                            </div>
                            <div class="row g-0">
                                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                        <i class="fe fe-arrow-left me-1"></i> Prev
                                        </a>
                                    </li>
                                </ul>
                                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
        </div>
    </div>
    <div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Create State Rule of Court</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y m-5">
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <div class="container">
                            <div class="stepper-nav justify-content-center py-2">
                                <form action="{{route('store.state-rule')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    State
                                                </label>
                                                <select name="name" class="form-select" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select state</option>
                                                    @foreach($states as $state)
                                                        <option value="{{Str::upper($state->name)}}">{{Str::upper($state->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Section
                                                </label>
                                                <select name="section" class="form-select" data-choices='{"searchEnabled": true}'>
                                                    <option value="">Select section</option>
                                                    <option value="ORDERS">ORDERS</option>
                                                    <option value="PARTS">PARTS</option>
                                                    <option value="SCHEDULES">SCHEDULES</option>
                                                    <option value="FORMS">FORMS</option>
                                                    <option value="PROBATE FORMS">PROBATE FORMS</option>
                                                    <option value="CIVIL FORMS">CIVIL FORMS</option>
                                                    <option value="APPENDIX">APPENDIX</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            State Rule Title
                                        </label>
                                        <input type="hidden" name="type" value="State">
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="form-label mb-1">
                                            Version No.
                                        </label>
                                        <input type="text" name="version_no" class="form-control">
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Content
                                        </label>
                                        <textarea name="content" class="form-control" rows="5" placeholder="Enter description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                            <span class="button__text"><i class="mdi mdi-plus"></i> Add State Rule</span>
                                        </button>
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
        function deleteOrderFunction() {
            if(!confirm("Are you sure you want to delete this Rule order?"))
            event.preventDefault();
        }
        function deletePartFunction() {
            if(!confirm("Are you sure you want to delete this Rule part?"))
            event.preventDefault();
        }
        function deleteScheduleFunction() {
            if(!confirm("Are you sure you want to delete this Rule schedule?"))
            event.preventDefault();
        }
        function deleteFormFunction() {
            if(!confirm("Are you sure you want to delete this Rule form?"))
            event.preventDefault();
        }
        function deleteProbateFunction() {
            if(!confirm("Are you sure you want to delete this Rule Probate form?"))
            event.preventDefault();
        }
        function deleteCivilFunction() {
            if(!confirm("Are you sure you want to delete this Rule Civil form?"))
            event.preventDefault();
        }
        function deleteAppendixFunction() {
            if(!confirm("Are you sure you want to delete this Rule appendix?"))
            event.preventDefault();
        }
    </script>
@endsection
