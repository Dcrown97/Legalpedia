@extends('layouts.auth')

@section('title')
    <title>Sign up - Legalpedia</title>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
@endsection

@section('content')
<style>
    .text-color {
        color: #EC6959 !important;
    }
</style>
<div class="login-card">
    <div class="row">
        <div class="col-md-6 image">
            <img src="{{ asset('assets/images/lady_signup.png') }}" alt="login" class="login-card-img">
        </div>
        <div class="col-md-6">
            <div class="card-body">
                <div class="brand-wrapper text-center">
                    <img src="{{ asset('assets/images/legalpedia_logo.png') }}" alt="logo" class="logo">
                </div>
                <p class="login-card-description">Sign up</p>
                <form method="POST" action="{{ route('accept') }}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="is_active" value="1">
                        {{-- <input type="hidden" name="user_id" value="{{Auth::user()->id}}"> --}}
                        <input type="hidden" name="team_id" value="{{$invite->team_id}}">
                        <input type="hidden" name="token" value="{{$invite->token}}">
                        <input type="hidden" name="send_request" value="1">
                        <input type="hidden" name="approve_request" value="1">
                        <label for="name">First Name <span class="text-color">*<span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" value="{{ old('name') }}" required autocomplete="first-name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="surname">Last Name <span class="text-color">*<span></label>
                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" placeholder="Last Name" name="surname" value="{{ old('surname') }}" required autocomplete="last-name">
                        @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address <span class="text-color">*<span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ $invite->email }}" required autocomplete="email" autofocus readonly="true">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-color">*<span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password <span class="text-color">*<span></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth <span class="text-color">*<span></label>
                        <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" placeholder="Date of Birth" name="dob" required>
                        @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="call_to_bar_year">Call to Bar Year <span class="text-color">*<span></label>
                        <input id="datepicker" type="text" class="form-control @error('call_to_bar_year') is-invalid @enderror" placeholder="Call to Bar Year" name="call_to_bar_year" required>
                        @error('call_to_bar_year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="license_code">License code</label>
                        <input id="license_code" type="text" class="form-control @error('license_code') is-invalid @enderror" placeholder="License code" name="license_code">
                        @error('license_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="link">Referrer</label>
                        <input id="referrer" type="text" class="form-control @error('referrer') is-invalid @enderror" placeholder="Referrer" name="referrer">
                        @error('referrer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block login-btn mb-4" onclick="this.classList.toggle('button--loading')">
                        <span class="button__text">Sign up</span>
                    </button>
                </form>
                <p class="login-card-footer-text"><span style="color: #EC6959;">Already have an account?</span> <a href="{{ url('/login') }}" class="text-reset">Login</a></p>
                <!-- <nav class="login-card-footer-nav">
                    <a href="#!">Terms of use.</a>
                    <a href="#!">Privacy policy</a>
                </nav> -->
            </div>
        </div>
    </div>
    <script>
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    </script>
@endsection
