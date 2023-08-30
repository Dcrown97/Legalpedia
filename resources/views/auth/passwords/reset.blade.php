@extends('layouts.auth')

@section('title')
    <title>Reset Password - Legalpedia</title>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
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
                <p class="login-card-description">Reset Password</p>
                <form method="POST" action="{{ route('password.update') }}">
                    
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn button_load btn-block login-btn" onclick="this.classList.toggle('button--loading')">
                        <span class="button__text">{{ __('Reset Password') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
