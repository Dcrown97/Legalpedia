@extends('layouts.auth')

@section('title')
    <title>Sign up - Legalpedia</title>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
@endsection

@section('content')
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
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="is_active" value="1">
                        <input type="hidden" name="token" value="{{Str::random(15)}}">
                        <input type="hidden" name="group_id" value="0">
                        <input type="hidden" name="send_request" value="0">
                        <input type="hidden" name="approve_request" value="0">
                        <label for="name">Full Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" value="{{ old('name') }}" required autocomplete="full-name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="coupon">Coupon code</label>
                        <input id="coupon" type="text" class="form-control @error('coupon') is-invalid @enderror" placeholder="Coupon code" name="coupon" required>
                        @error('coupon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link">Referral Link</label>
                        <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" placeholder="Referral Link" name="link" required>
                        @error('link')
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
@endsection
