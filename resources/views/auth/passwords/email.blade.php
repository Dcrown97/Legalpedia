@extends('layouts.auth')

@section('title')
    <title>Forgot Password - Legalpedia</title>
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
                <p class="login-card-description">Reset your password</p>
                @if (session('success2'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success2') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('forgot.password.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn button_load btn-block login-btn" onclick="this.classList.toggle('button--loading')">
                        <span class="button__text">Send Password Reset Link</span>
                    </button>
                    <div class="mt-4">
                        <a href="{{url('/login')}}"><i class="mdi mdi-arrow-left"></i> Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
