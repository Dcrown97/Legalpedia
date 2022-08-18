@extends('layouts.auth')

@section('title')
    <title>Sign in - Legalpedia</title>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">

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

    .nav-tabs {
        border-bottom: 1px solid #EC6959;
        width: 67%;
        justify-content: center;
        margin: auto;
    }

    .nav-tabs .nav-link {
        color: #91a8be;
    }

    /* .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
        border: none;
    } */

    .nav-tabs .nav-link.active {
        color: #EC6959;
        background-color: #fff;
        border-color: #EC6959 #EC6959 #fff;
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
                 <div class="row align-items-center">
                    <div class="col">
                        <ul class="nav nav-tabs nav-overflow header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">
                                   Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">
                                    Sign up
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="wizardSteps">
                            <div class="tab-pane fade show active" id="login" style="height: 100vh" role="tabpanel" aria-labelledby="login-tab">
                                <p class="login-card-description mt-4">Login to your account</p>
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
                                {{-- <p class="login-card-footer-text"><span style="color: #EC6959;">Don't have an account?</span> <a href="{{ url('/register') }}" class="text-reset">Sign up</a></p> --}}
                                <!-- <nav class="login-card-footer-nav">
                                    <a href="#!">Terms of use.</a>
                                    <a href="#!">Privacy policy</a>
                                </nav> -->
                            </div>
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <p class="login-card-description mt-4">Create an account</p>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="is_active" value="1">
                                        <input type="hidden" name="token" value="{{Str::random(15)}}">
                                        <input type="hidden" name="send_request" value="0">
                                        <input type="hidden" name="approve_request" value="0">
                                        <label for="name">First Name <span class="text-color">*<span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="First Name" name="name" value="{{ old('name') }}" required autocomplete="first-name">
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
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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

                                    {{-- <div class="form-group">
                                        <label for="call_to_bar_year">Call to Bar Year <span class="text-color">*<span></label>
                                        <input id="datepicker" type="text" class="form-control @error('call_to_bar_year') is-invalid @enderror" placeholder="Call to Bar Year" name="call_to_bar_year" required>
                                        @error('call_to_bar_year')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                     <div class="form-group">
                                        <label for="area_of_practice">Area of Practice <span class="text-color">*<span></label>
                                        <input type="text" class="form-control @error('area_of_practice') is-invalid @enderror" placeholder="Area of Practice" name="area_of_practice" required value="{{ old('area_of_practice') }}">
                                        @error('area_of_practice')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nba_branch">NBA Branch <span class="text-color">*<span></label>
                                        <input type="text" class="form-control @error('nba_branch') is-invalid @enderror" placeholder="NBA Branch" name="nba_branch" required value="{{ old('nba_branch') }}">
                                        @error('nba_branch')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-30">
                                        <label for="phone">Phone Number <span class="text-color">*<span></label>
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="23481000xxxxx" name="phone" required value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth <span class="text-color">*<span></label>
                                        <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" placeholder="Date of Birth" name="dob" required value="{{ old('dob') }}">
                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="link">Referrer</label>
                                        <input id="referrer" type="text" class="form-control @error('referrer') is-invalid @enderror" placeholder="Referrer" name="referrer">
                                        @error('referrer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    <button type="submit" class="btn btn-block login-btn mb-4" onclick="this.classList.toggle('button--loading')">
                                        <span class="button__text">Sign up</span>
                                    </button>
                                </form>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot password?</a>
                                @endif
                                {{-- <p class="login-card-footer-text"><span style="color: #EC6959;">Don't have an account?</span> <a href="{{ url('/register') }}" class="text-reset">Sign up</a></p> --}}
                                <!-- <nav class="login-card-footer-nav">
                                    <a href="#!">Terms of use.</a>
                                    <a href="#!">Privacy policy</a>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
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
