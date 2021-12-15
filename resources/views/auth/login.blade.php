@extends('layouts.auth')

@section('title')
    <title>Sign in - Legalpedia</title>
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
                <p class="login-card-description">Login</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mp4">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block login-btn" onclick="this.classList.toggle('button--loading')">
                        <span class="button__text">Login</span>
                    </button>
                    {{-- <a href="{{ url('/admin/dashboard') }}" class="btn btn-block login-btn" onclick="this.classList.toggle('button--loading')">
                        <span class="button__text">Login</span>
                    </a> --}}
                    {{-- <a href="{{ url('auth/google') }}" class="btn-google text-center btn-block mb-4" style="text-decoration: none; color: inherit"><img src="{{asset('assets/images/google.svg')}}" width="18"> &nbsp; Sign in with Google</a> --}}
                    {{-- <div class="form-group ml-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label " for="remember">
                            Keep me signed in
                        </label>
                    </div> --}}
                </form>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot password?</a>
                @endif
                <p class="login-card-footer-text"><span style="color: #EC6959;">Don't have an account?</span> <a href="{{ url('/register') }}" class="text-reset">Sign up</a></p>
                <!-- <nav class="login-card-footer-nav">
                    <a href="#!">Terms of use.</a>
                    <a href="#!">Privacy policy</a>
                </nav> -->
            </div>
        </div>
    </div>
</div>
@endsection
