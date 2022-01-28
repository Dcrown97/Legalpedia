@extends('layouts.admin.messages')

@section('title')
    <title>Messages - Legalpedia</title>
@endsection

@section('content')
    <style>
        .text-color {
            color: #EC6959 !important;
        }
        .custom-form {
            border-radius: 4px !important;
            height: inherit;
            width: 100% !important;
        }
        .show-mobile {
            display: none;
        }
        .mt-custom {
            margin-top: 8px;
        }
        .mr-custom-5 {
            margin-right: 40px;
        }
        @media screen and (min-width: 200px) and (max-width: 767px) {
            .hide-mobile {
                display: none;
            }
            .show-mobile {
                display: inline;
            }
        }
    </style>
    <div class="header">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">
                        <h6 class="header-pretitle">
                        </h6>
                        <h1 class="header-title">
                            Message History
                        </h1>
                    </div>
                    @if(Auth::user()->role->name == 'Admin')
                        <div class="col-auto">
                            <a href="{{route('create.message')}}" class="btn btn-primary text-white">
                                <i class="fe fe-plus"></i> New Message
                            </a>
                        </div>
                    @endif
                    @include('elements.notifications')
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
                        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">
                            Send Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="auto-message-tab" data-toggle="tab" href="#autoMessage" role="tab" aria-controls="autoMessage" aria-selected="false">
                            All Messages
                        </a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="tab-content" id="wizardSteps">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-xl">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-2">
                                                All customers
                                            </h6>
                                            <span class="h1 mb-0">
                                                {{number_format($user_count)}}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="h2 text-color mb-0">
                                                <i class="fe fe-users"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-2">
                                                Messages created
                                            </h6>
                                            <span class="h1 mb-0">
                                                {{number_format($message_count)}}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="h2 text-color mb-0">
                                                <i class="mdi mdi-message-outline"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-2">
                                                Active Subscribers
                                            </h6>
                                            <span class="h1 mb-0">
                                                {{number_format($active_user_count)}}
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="chart chart-sparkline">
                                                <canvas class="chart-canvas" id="sparklineChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center gx-0">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted mb-2">
                                                Inactive Subsribers
                                            </h6>
                                            <span class="h1 mb-0">
                                                {{number_format($inactive_user_count)}}
                                            </span>
                                        </div>
                                        <div class="col-auto text-color">
                                            <i class="mdi mdi-cancel"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-end justify-content-end mt-4 p-3">
                        <form action="{{route('admin.messages')}}" method="GET" class="me-3">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Subscribers
                                        </label>
                                        <select name="status" class="form-select mr-8">
                                            <option value="active">Active</option>
                                            <option value="inactive">Not Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Package
                                        </label>
                                        <select name="package" class="form-select mr-8" data-choices='{"searchEnabled": true}'>
                                            <option value="">All</option>
                                            @foreach($packages as $package)
                                                <option value="{{$package->name}}" {{ $package->name == $selected_package['package'] ? 'selected' : '' }}>{{$package->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            From
                                        </label>
                                        <input type="text" id="start_date" name="start_date" class="form-control custom-form w-8" placeholder="<?php echo date('Y-m-d');?>" data-flatpickr>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            To
                                        </label>
                                        <input type="text" id="end_date" name="end_date" class="form-control custom-form w-8" placeholder="<?php echo date('Y-m-d');?>" data-flatpickr>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-auto">
                                    <button type="submit" name="fetch_user" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-sm btn-primary p-2">
                                        <span class="button__text"><i class="mdi mdi-filter"></i> Filter</span>
                                    </button>
                                    <a href="{{url('admin/messages')}}" onclick="this.classList.toggle('button--loading')" class="ml-2 button_load btn button_load text-white btn-sm btn-primary p-2">
                                        <span class="button__text"><i class="mdi mdi-close"></i> Clear</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                        <form action="{{route('send.message')}}" method="POST">
                            @csrf
                            <div class="card-header">
                                <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                    <input class="form-control list-search" type="search" placeholder="Search">
                                    <span class="input-group-text">
                                        <i class="fe fe-search"></i>
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <select name="message_id" class="form-select form-select-md form-control-flush mr-custom-5"  data-choices='{"searchEnabled": true}'>
                                        <option value="">Select Message to send</option>
                                        @foreach($messages as $message)
                                            <option value="{{$message->id}}">{{$message->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input list-checkbox-all" name="checkBoxArray" id="ordersSelectAll" type="checkbox">
                                        <label class="form-check-label" for="ordersSelectAll">&nbsp;</label>Send to all Customers
                                    </div>
                                </div>
                                <div class="col-auto me-n3">
                                    <button type="submit" name="send_message" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                        <span class="button__text"><i class="mdi mdi-send"></i> Send</span>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <?php $user_no = 1; ?>
                                @if(count($users) > 0)
                                    <table class="table table-sm table-nowrap card-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Name</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Email</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Package</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Active Date</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Expiry Date</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Status</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Joined at</a></th>
                                                <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="form-check mb-n2">
                                                            <input class="form-check-input list-checkbox" type="checkbox" name="checkBoxArray[]" id="ordersSelectOne" value="{{$user->id}}">
                                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td class="orders-order">{{$user_no}}</td>
                                                    <?php $user_no++; ?>
                                                    <td class="orders-product">{{$user->name}}</td>
                                                    <td class="orders-product">{{$user->email}}</td>
                                                    @php
                                                        $package = App\Models\Package::where('id', $user->package_id)->first();
                                                    @endphp
                                                    <td class="orders-total">{{$package ? $package->name : '--'}}</td>
                                                    @if($package)
                                                        <td class="orders-date">{{\Carbon\Carbon::parse($user->active_date)->toFormattedDateString()}}</td>
                                                        <td class="orders-total">{{\Carbon\Carbon::parse($user->expiry_date)->toFormattedDateString()}}</td>
                                                        <td class="orders-status">
                                                            <div class="badge bg-success-soft">
                                                                {{$user->status}}
                                                            </div>
                                                        </td>
                                                        @else
                                                        <td class="orders-date">--</td>
                                                        <td class="orders-total">--</td>
                                                        <td class="orders-status">
                                                            <div class="badge bg-secondary-soft">
                                                                inactive
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td class="orders-total">{{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}</td>
                                                    <td class="text-end">
                                                        <div class="dropdown">

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="text-center mt-4 mb-4">
                                        <h3 class="text-muted"><i class="fe fe-user"></i> No user found</h3>
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
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="autoMessage" role="tabpanel" aria-labelledby="auto-message-tab">
                    <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsLis">
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
                            <?php $message_no = 1; ?>
                            @if(count($all_messages) > 0)
                                <table class="table table-sm table-nowrap card-table">
                                    <thead>
                                        <tr>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Name</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Subject</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-product">Body</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Type</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Receipient</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-total">No of Receipients</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Times Sent</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Created at</a></th>
                                            <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Action</a></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach($all_messages as $message)
                                            <tr>
                                                <td class="orders-order">{{$message_no}}</td>
                                                <?php $message_no++; ?>
                                                <td class="orders-product">{{Str::words($message->name, 3)}}</td>
                                                <td class="orders-product">{{Str::words($message->subject, 3)}}</td>
                                                <td class="orders-product">{!! Str::words($message->body, 5) !!}</td>
                                                <td class="orders-total">
                                                    @if($message->type == 'normal')
                                                        Email
                                                        @elseif($message->type == 'in-app')
                                                        In-app
                                                        @elseif($message->type == 'automated')
                                                        Automated
                                                    @endif
                                                </td>
                                                <td class="orders-total">{{$message->receipient}}</td>
                                                @php
                                                    $receipient = App\Models\MailMessage::where('message_id', $message ? $message->id : '')->first();
                                                    if($receipient) {
                                                        $receipient_count = $receipient->count();
                                                        $receipient_users['user_id'] = json_decode($receipient->users);
                                                        $receipient_no = count($receipient_users);
                                                    }
                                                @endphp
                                                @if($receipient)
                                                    <td class="orders-total">{{$receipient_no}}</td>
                                                    <td class="orders-total">{{$receipient_count}}</td>
                                                    @else
                                                    <td class="orders-total">--</td>
                                                    <td class="orders-total">--</td>
                                                @endif
                                                <td class="orders-total">{{$message->created_at->diffForHumans()}}</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{route('edit.message', $message->id)}}" style="cursor: pointer" class="dropdown-item">
                                                                <i class="mdi mdi-pencil mr-2"></i> Edit
                                                            </a>
                                                            <form action="/admin/messages/{{$message->id}}" method="POST">
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
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center mt-4 mb-4">
                                    <h3 class="text-muted"><i class="mdi mdi-message-utline"></i> No messages found</h3>
                                    <div class="col-auto mt-2">
                                        <a href="{{route('create.message')}}" class="btn btn-primary text-white">
                                            <i class="fe fe-plus"></i> Create Message
                                        </a>
                                    </div>
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
@endsection
