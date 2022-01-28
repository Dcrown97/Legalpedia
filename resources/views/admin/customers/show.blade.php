@extends('layouts.admin.customers')

@section('title')
    <title>Manage Customers - Legalpedia</title>
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
                        Manage Customers
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h2 class="mb-3">
                                {{$user->name}}'s Details
                            </h2>
                            <div class="avatar">
                                @if($user->photo)
                                    <img class="avatar-img rounded-circle w-8 h-8" src="{{$user ? $user->photo : ''}}" alt="{{$user->name}}">
                                    @else
                                    <img class="avatar-img rounded-circle w-8 h-8" src="{{asset('assets/images/user-avatar.jpg')}}" alt="{{$user->name}}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Email Address
                                </small>
                                <h4 class="mb-1">
                                    {{$user->email}}
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Phone
                                </small>
                                <h4 class="mb-1">
                                    {{$user->phone}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Date of Birth
                                </small>
                                <h4 class="mb-1">
                                    {{$user->dob}}
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Referee
                                </small>
                                <h4 class="mb-1">
                                    {{$user->referral_link}}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    License code
                                </small>
                                <h4 class="mb-1">
                                    {{$user->coupon_code}}
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Year of Call to bar
                                </small>
                                <h4 class="mb-1">
                                    {{$user->call_to_bar_year}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
