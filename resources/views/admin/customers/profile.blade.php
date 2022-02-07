@extends('layouts.admin.customers')

@section('title')
    <title>User Profile - Legalpedia</title>
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
                        User Profile
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
                        <div class="col-auto mb-6">
                            <h2 class="mb-3">
                                {{$user->name}}'s Profile
                            </h2>
                            <div class="avatar">
                                @if($user->photo)
                                    <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                    @else
                                    <div class="initials">
                                        <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Email Address
                                </small>
                                <h4 class="mb-1">
                                    @if($user->email_display)
                                        {{$user->email}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Bio
                                </small>
                                <h4 class="mb-1">
                                    {!! $user->bio !!}
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
                                    @if($user->dob_display)
                                        {{\Carbon\Carbon::parse($user->dob)->toFormattedDateString()}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    phone
                                </small>
                                <h4 class="mb-1">
                                    @if($user->phone_display)
                                        {{$user->phone}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Year of Call to bar
                                </small>
                                <h4 class="mb-1">
                                    @if($user->ctb_display)
                                        {{$user->call_to_bar_year}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Social platforms
                                </small>
                                @if($user->social_display)
                                    <h4 class="mb-2">
                                        <a href="https://facebook.com/{{$user->facebook}}" class="text-color">
                                            <i class="mdi mdi-facebook"></i> {{$user->facebook}}
                                        </a>
                                    </h4>
                                    <h4 class="mb-2">
                                        <a href="https://instagram.com/{{$user->instagram}}" class="text-color">
                                            <i class="mdi mdi-instagram"></i> {{$user->instagram}}
                                        </a>
                                    </h4>
                                    <h4 class="mb-1">
                                        <a href="https://twitter.com/{{$user->twitter}}" class="text-color">
                                            <i class="mdi mdi-twitter"></i> {{$user->twitter}}
                                        </a>
                                    </h4>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 mb-4">
                            <div class="ms-n2">
                                <small class="text-muted">
                                    Website Link
                                </small>
                                <h4 class="mb-1">
                                    @if($user->web_display)
                                        <a href="{{$user->web_link}}" class="text-color">
                                            <i class="fe fe-globe"></i> {{$user->web_link}}
                                        </a>
                                    @endif
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
