@extends('layouts.auth')

@section('title')
    <title>Sign in - Legalpedia</title>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endsection

@section('content')
<style>
    .eye-icon {
        float: right;
        margin: 40px 150px;
        position: absolute;
        cursor: pointer;
    }
    @media screen and (min-width: 200px) and (max-width: 480px) {
        .eye-icon {
            margin: 40px 100px;
        }
    }
    .mb-30 {
        margin-bottom: 30px;
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
                    <div class="form-group mb-30">
                        <label for="password">Password</label>
                        <i class="mdi mdi-eye-off-outline eye-icon" id="togglePassword"></i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn button_load btn-block login-btn" onclick="this.classList.toggle('button--loading')">
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
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('mdi-eye-off-outline');
        this.classList.toggle('mdi-eye-outline');
    });
</script>
@endsection
