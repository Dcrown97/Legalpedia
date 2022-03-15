@extends('layouts.admin.customers')

@section('title')
    <title>Account Profile - Legalpedia</title>
@endsection

@section('content')
<style>
    .avatar-upload {
        margin: 0px !important;
    }
    .text-30 {
        font-size: 30px;
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
                                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                                General
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="bio-tab" data-toggle="tab" href="#bio" role="tab" aria-controls="bio" aria-selected="false">
                                                Profile Bio
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="transact-tab" data-toggle="tab" href="#transact" role="tab" aria-controls="transact" aria-selected="false">
                                                Subscription
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="wizardSteps">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <form action="{{route('update.customer', $user->id)}}" method="POST" enctype="multipart/form-data">
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
                                @if(Auth::user()->license_code)
                                    <div class="form-group">
                                        <label class="form-label">Organization Name</label>
                                        <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control">
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">First name</label>
                                                <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Last name</label>
                                                <input type="text" name="surname" value="{{Auth::user()->surname}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="mb-1">Email address</label>
                                    <small class="form-text text-muted">Your Verified Email.</small>
                                    @if(Auth::user()->license_code)
                                        <input type="email" name="email" value="{{Auth::user()->email}}" readonly class="form-control">
                                        @else
                                        <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control">
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control mb-3" placeholder="234810xxxxxxxx">
                                            {{-- <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control mb-3" placeholder="(___)___-____" data-inputmask="'mask': '(999)999-999-9999'"> --}}
                                        </div>
                                        </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Birthday</label>
                                            <input type="text" name="dob" value="{{Auth::user()->dob}}" class="form-control" data-flatpickr>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-4 mb-5">
                                @if(!Auth::user()->license_code)
                                    <h4>Update your password</h4>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="password" class="form-control mb-3">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Retype Password</label>
                                                <input type="password" name="password_confirmation" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save changes</span>
                                </button>
                                {{-- <hr class="mt-4 mb-5">
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
                                </div> --}}
                            {{-- </form> --}}
                            <br><br>
                        </div>
                        <div class="tab-pane fade" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                            {{-- <form action="{{route('update.customer', Auth::user()->id)}}" method="POST"> --}}
                                {{-- {{ csrf_field() }}
                                {{ method_field('patch') }} --}}
                                <div class="form-group mt-4">
                                    <label class="form-label">Bio</label>
                                    <small class="form-text text-muted">
                                        Add a short bio to your profle
                                    </small>
                                    <textarea name="bio" rows="5" class="form-control">{{Auth::user()->bio}}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Call to Bar Year</label>
                                            <input type="number" min="1960" name="call_to_bar_year" value="{{Auth::user()->call_to_bar_year}}" class="form-control">
                                        </div>
                                        </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <input type="text" name="city" value="{{Auth::user()->city}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">State</label>
                                            <select name="state" class="form-select">
                                                <option value="{{Auth::user()->state}}" selected>{{Auth::user()->state}}</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->name}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Country</label>
                                            <select name="country" class="form-select">
                                                <option value="{{Auth::user()->country}}" selected>{{Auth::user()->country}}</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-4 mb-5">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><i class="mdi mdi-facebook"></i> Facebook</label>
                                            <input type="text" name="facebook" placeholder="facebook_handle" value="{{Auth::user()->facebook}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"><i class="mdi mdi-instagram"></i> Instagram</label>
                                            <input type="text" name="instagram" placeholder="instagram_handle" value="{{Auth::user()->instagram}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"><i class="mdi mdi-twitter"></i> Twitter</label>
                                            <input type="text" name="twitter" placeholder="twitter_handle" value="{{Auth::user()->twitter}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fe fe-globe"></i> Website Link</label>
                                            <input type="text" name="web_link" value="{{Auth::user()->web_link}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="save_bio" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save changes</span>
                                </button>
                                <hr class="mt-4 mb-5">
                                <div class="row justify-content-between">
                                    <div class="col-12 col-md-6">
                                        <h4>
                                            Make your profile Public
                                        </h4>
                                        <p class="small text-muted mb-md-0">
                                            You can set your profile fields to public or private
                                        </p>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="form-check mt-2 mb-n2">
                                            <input class="form-check-input list-checkbox" name="email_display" type="checkbox" value="public" {{ Auth::user()->email_display !==NULL ? 'checked' : '' }}>
                                            <h5 class="pt-2 pl-2">Email</h5>
                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check mt-2 mb-n2">
                                            <input class="form-check-input list-checkbox" name="phone_display" type="checkbox" value="public" {{ Auth::user()->phone_display !==NULL ? 'checked' : '' }}>
                                            <h5 class="pt-2 pl-2">Phone</h5>
                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check mt-2 mb-n2">
                                            <input class="form-check-input list-checkbox" name="dob_display" type="checkbox" value="public" {{ Auth::user()->dob_display !==NULL ? 'checked' : '' }}>
                                            <h5 class="pt-2 pl-2">Date of birth</h5>
                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check mt-2 mb-n2">
                                            <input class="form-check-input list-checkbox" name="ctb_display" type="checkbox" value="public" {{ Auth::user()->ctb_display !==NULL ? 'checked' : '' }}>
                                            <h5 class="pt-2 pl-2">Call to bar year</h5>
                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check mt-2 mb-n2">
                                            <input class="form-check-input list-checkbox" name="social_display" type="checkbox" value="public" {{ Auth::user()->social_display !==NULL ? 'checked' : '' }}>
                                            <h5 class="pt-2 pl-2">Social handles</h5>
                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check mt-2 mb-n2">
                                            <input class="form-check-input list-checkbox" name="web_display" type="checkbox" value="public" {{ Auth::user()->web_display !==NULL ? 'checked' : '' }}>
                                            <h5 class="pt-2 pl-2">Website</h5>
                                            <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="save_bio" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Save</span>
                                </button>
                                <br><br>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="transact" role="tabpanel" aria-labelledby="transact-tab">
                            <div class="row">
                                <div class="col-12 col-xl-4">
                                    @if($package && $user->expiry_date > now())
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-header-title">
                                                <i class="mdi mdi-crown text-color"></i> Active Package
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="list-group list-group-flush list-group-activity my-n3">
                                                    <div class="list-group-item">
                                                        <div class="row mb-4">
                                                            <div class="col-auto">
                                                                <div class="avatar avatar-sm">
                                                                    <i class="fe fe-check-circle text-success text-30"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h5 class="mb-1">
                                                                    {{$package->name}}
                                                                </h5>
                                                                <p class="small text-gray-700 mb-0">
                                                                    Expires on {{\Carbon\Carbon::parse($user->expiry_date)->toFormattedDateString()}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <a class="mt-4" href="{{url('admin/pricing')}}">
                                                                    <span class="btn w-100 button_load text-color btn-sm btn-custom p-2" onclick="this.classList.toggle('button--loading')">
                                                                        <span class="button__text"><i class="mdi mdi-crown"></i> Renew Package</span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif($package && $user->expiry_date < now())
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-header-title">
                                                <i class="mdi mdi-crown text-color"></i> Inactive Package
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="list-group list-group-flush list-group-activity my-n3">
                                                    <div class="list-group-item">
                                                        <div class="row mb-4">
                                                            <div class="col-auto">
                                                                <div class="avatar avatar-sm">
                                                                    <i class="mdi mdi-close text-color text-30"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h5 class="mb-1">
                                                                    {{$package->name}}
                                                                </h5>
                                                                <p class="small text-gray-700 mb-0">
                                                                    Expired on {{\Carbon\Carbon::parse($user->expiry_date)->toFormattedDateString()}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <a class="mt-4" href="{{url('admin/pricing')}}">
                                                                    <span class="btn w-100 button_load text-color btn-sm btn-custom p-2" onclick="this.classList.toggle('button--loading')">
                                                                        <span class="button__text"><i class="mdi mdi-crown"></i> Renew Package</span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="list-group list-group-flush list-group-activity my-n3">
                                                    <div class="list-group-item">
                                                        <div class="row mb-4">
                                                            <div class="col ms-n2">
                                                                <h5 class="mb-1">
                                                                    <i class="mdi mdi-close text-color"></i> You have no active subscription
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <a class="mt-2" href="{{url('admin/pricing')}}">
                                                                    <span class="btn w-100 button_load text-white btn-sm btn-warning p-2" onclick="this.classList.toggle('button--loading')">
                                                                        <span class="button__text"><i class="mdi mdi-crown"></i> Subscribe</span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-xl-8">
                                    <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                                        <div class="card-header">
                                            <h4>Your Transactions</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-nowrap card-table">
                                                <thead>
                                                    <tr>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-order">s/n</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-date">Payment Reference</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Amount</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-total">Discounted Price</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Payment Status</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Payment Date</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package Status</a></th>
                                                        <th><a href="#" class="text-muted list-sort" data-sort="orders-status">Package Expiry Date</a></th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $transaction_no = 1
                                                @endphp
                                                @if($transactions)
                                                    <tbody class="list">
                                                        @foreach($transactions as $transaction)
                                                            <tr>
                                                                <td class="orders-order">{{$transaction_no}}</td>
                                                                @php
                                                                    $transaction_no++
                                                                @endphp
                                                                <td class="orders-date">{{$transaction->reference}}</td>
                                                                <td class="orders-date">₦{{number_format($transaction->amount, 2)}}</td>
                                                                <td class="orders-date">₦{{number_format($transaction->discounted_price, 2)}}</td>
                                                                <td class="orders-date">{{$transaction->package}}</td>
                                                                <td class="orders-date">{{$transaction->status}}</td>
                                                                <td class="orders-total">{{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}}</td>
                                                                @php
                                                                    $package_expiry = App\Models\Package::where('id', $transaction->package_id)->first();

                                                                    if($package_expiry->validity == 'Days'){
                                                                        $day = $package_expiry->recur_date;
                                                                        $expiry_date =  $transaction->created_at->addDays($day);
                                                                    }
                                                                    if($package_expiry->validity == 'Months'){
                                                                        $month = $package->recur_date;
                                                                        $expiry_date =  $transaction->created_at->addMonths($month);
                                                                    }
                                                                    if($package_expiry->validity == 'Years'){
                                                                        $year = $package->recur_date;
                                                                        $expiry_date =  $transaction->created_at->addYears($year);
                                                                    }
                                                                @endphp
                                                                @if($transaction->status == 'paid')
                                                                    <td class="orders-status">
                                                                        @if($expiry_date > now())
                                                                            <div class="badge bg-success-soft">
                                                                                Active
                                                                            </div>
                                                                            @else
                                                                            <div class="badge bg-secondary-soft">
                                                                                Inactive
                                                                            </div>
                                                                        @endif
                                                                    </td>

                                                                    <td class="orders-date">{{\Carbon\Carbon::parse($expiry_date)->toFormattedDateString()}}</td>
                                                                    @else
                                                                    <td class="orders-status">
                                                                        <div class="badge bg-secondary-soft">
                                                                            Inactive
                                                                        </div>
                                                                    </td>
                                                                    <td class="orders-date">--</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    @else
                                                    <div class="text-center">
                                                        <h1>No transaction found</h1>
                                                    </div>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="row g-0">
                                            <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                              <li class="page-item">
                                                <a class="page-link" href="#">
                                                  <i class="fe fe-arrow-left me-1"></i> Prev
                                                </a>
                                              </li>
                                            </ul>
                                            <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
                                            <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                                              <li class="page-item">
                                                <a class="page-link" href="#">
                                                  Next <i class="fe fe-arrow-right ms-1"></i>
                                                </a>
                                              </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
