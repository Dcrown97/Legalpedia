@extends('layouts.auth')

@section('title')
    <title>Verify your Email | Twelve Academy</title>
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
                <div class="brand-wrapper">
                    <img src="{{ asset('assets/images/legalpedia_logo.png') }}" alt="logo" class="logo">
                </div>
                <p class="login-card-description">Verify Your Email Address</p>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p>Before proceeding, please check your email for a verification link.</p>
                <p>If you did not receive the email</p>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-block login-btn mb-2"><span class="button__text"> Send another request</span></button>.
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
