@extends('layouts.admin.customers')

@section('title')
    <title>Account Profile - Legalpedia</title>
@endsection

@section('content')
<style>
    .avatar-upload {
        margin: 0px !important;
    }
</style>
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
                    <form action="{{route('update.customer', Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-auto mr-6">
                                        <div class="avatar-upload text-center">
                                            <div class="avatar-edit">
                                                <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                @if(Auth::user()->photo)
                                                    <div id="imagePreview" style="background-image: url({{Auth::user()->photo ? Auth::user()->photo : 'assets/images/user-avatar.jpg'}});">
                                                    </div>
                                                    @else
                                                    <div id="imagePreview" style="background-image: url({{asset('assets/images/user-avatar.jpg')}});">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
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
                        <hr class="mt-4 mb-5">
                        <div class="row justify-content-between">
                            <div class="col-12 col-md-6">
                                <h4>
                                    Delete your account
                                </h4>
                                <p class="small text-muted mb-md-0">
                                    Please note, deleting your account is a permanent action and will no be recoverable once completed.
                                </p>
                            </div>
                            <div class="col-auto">
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
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
</script>
@endsection
