@extends('layouts.admin.customers')

@section('title')
    <title>Account Profile - Legalpedia</title>
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
                        Profile Settings
                    </h1>
                </div>
                @include('elements.notifications')
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body p-5">
                    <div class="header">
                        <div class="header-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="header-pretitle">Update your profile</h6>
                                    <h1 class="header-title">Account</h1>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <ul class="nav nav-tabs nav-overflow header-tabs">
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link active">
                                            General
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link">
                                            Billing
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link">
                                            Notifications
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('update.customer', Auth::user()->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-auto mr-6">
                                        <div class="avatar">
                                            @if(Auth::user()->photo)
                                                <img class="avatar-img rounded-circle w-8 h-8" src="{{Auth::user()->photo}}" alt="{{Auth::user()->name}}">
                                                @else
                                                <img class="avatar-img rounded-circle w-8 h-8" src="{{asset('assets/images/user-avatar.jpg')}}" alt="{{Auth::user()->name}}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col ml-5">
                                        <h4 class="mb-1">
                                            Profile picture
                                        </h4>
                                        <small class="text-muted">
                                            PNG or JPG format.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a class="btn text-white btn-sm btn-primary">
                                    Upload
                                </a>
                            </div>
                        </div>
                        <hr class="mt-6 mb-5">
                        <div class="form-group">
                            <label class="form-label">Full name</label>
                            <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="mb-1">Email address</label>
                            <small class="form-text text-muted">Your Verified Email.</small>
                            <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control">

                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control mb-3" placeholder="(___)___-____" data-inputmask="'mask': '(999)999-999-9999'">
                                </div>
                                </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Birthday</label>
                                    <input type="text" name="dob" value="{{Auth::user()->dob}}" class="form-control" data-flatpickr>

                                </div>
                            </div>
                        </div>
                        <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary">
                            <span class="button__text"><i class="mdi mdi-check"></i> Save changes</span>
                        </button>
                        {{-- <hr class="my-5"> --}}
                        {{-- <div class="row">
                            <div class="col-12 col-md-6">

                            <!-- Public profile -->
                            <div class="form-group">

                                <!-- Label -->
                                <label class="mb-1">
                                Public profile
                                </label>

                                <!-- Form text -->
                                <small class="form-text text-muted">
                                Making your profile public means that anyone on the Dashkit network will be able to find you.
                                </small>

                                <div class="row">
                                <div class="col-auto">

                                    <!-- Switch -->
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchOne" />
                                    <label class="form-check-label" for="switchOne"></label>
                                    </div>

                                </div>
                                <div class="col ms-n2">

                                    <!-- Help text -->
                                    <small class="text-muted">
                                    You're currently invisible
                                    </small>

                                </div>
                                </div> <!-- / .row -->
                            </div>

                            </div>
                            <div class="col-12 col-md-6">

                            <!-- Allow for additional Bookings -->
                            <div class="form-group">

                                <!-- Label -->
                                <label class="mb-1">
                                Allow for additional Bookings
                                </label>

                                <!-- Form text -->
                                <small class="form-text text-muted">
                                If you are available for hire outside of the current situation, you can encourage others to hire you.
                                </small>

                                <div class="row">
                                <div class="col-auto">

                                    <!-- Switch -->
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="switchTwo" checked />
                                    <label class="form-check-label" for="switchTwo"></label>
                                    </div>

                                </div>
                                <div class="col ms-n2">

                                    <!-- Help text -->
                                    <small class="text-muted">
                                    You're currently available
                                    </small>

                                </div>
                                </div> <!-- / .row -->
                            </div>

                            </div>
                        </div> --}}
                        <hr class="mt-4 mb-5">

                        <div class="row justify-content-between">
                            <div class="col-12 col-md-6">

                            <!-- Heading -->
                            <h4>
                                Delete your account
                            </h4>

                            <!-- Text -->
                            <p class="small text-muted mb-md-0">
                                Please note, deleting your account is a permanent action and will no be recoverable once completed.
                            </p>

                            </div>
                            <div class="col-auto">

                            <!-- Button -->
                            <a class="btn text-white btn-danger">
                                <i class="fe fe-trash"></i> Delete
                            </a>

                            </div>
                        </div>
                    </form>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
