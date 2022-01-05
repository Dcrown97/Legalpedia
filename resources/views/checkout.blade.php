@extends('layouts.subscription')

@section('title')
<title>Checkout - Legalpedia</title>
@endsection

@section('styles')
    <style>

        .form-container .field-container:first-of-type {
            grid-area: name;
        }

        .form-container .field-container:nth-of-type(2) {
            grid-area: number;
        }

        .form-container .field-container:nth-of-type(3) {
            grid-area: expiration;
        }

        .form-container .field-container:nth-of-type(4) {
            grid-area: security;
        }

        .field-container input {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .field-container {
            position: relative;
        }

        .form-container {
            display: grid;
            grid-column-gap: 10px;
            grid-template-columns: auto auto;
            grid-template-rows: 90px 90px 90px;
            grid-template-areas: "name name""number number""expiration security";
            max-width: 400px;
            padding: 20px;
            color: #707070;
        }

        label {
            padding-bottom: 5px;
            font-size: 13px;
        }

        input {
            margin-top: 3px;
            padding: 15px;
            font-size: 16px;
            width: 100%;
            border-radius: 3px;
            border: 1px solid #dcdcdc;
        }

        .ccicon {
            height: 38px;
            position: absolute;
            right: 6px;
            top: calc(50% - 17px);
            width: 60px;
        }


    </style>
    <style>
        .card-payment {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 3px;
            padding: 20px;
            margin-bottom: 3rem;
        }

        .course-check {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 3px;
            padding: 20px;
            margin-bottom: 3rem;
        }

        input {
            margin-top: 3px;
            padding: 15px;
            font-size: 16px;
            width: 100%;
            border-radius: 3px;
            border: 1px solid #dcdcdc;
        }

        input[type="text"],
        input[type="tel"] {
            border: 1px solid #ced4da;
            height: 50px;
            border-radius: 3px;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus{
            border: 1px solid #0066f5;
        }

        .pay-type img {
            display: flex;
            width: 50px;
        }
        .course-check img {
            display: flex;
            width: 50px;
        }


        .form-control:focus {
            box-shadow: 10px 0px 0px 0px #ffffff !important;
            border-color: #4ca746;
        }
        .border_bottom {
            border-bottom: 1px dashed #d9d9d9;
        }
        .package-list ul li{
            list-style: none;
        }
    </style>
@endsection

@section('content-1')
<div class="text-center container cont">
    <div class="container">
        <h3 class="package">PROCEED TO PAYMENT</h3>
        <h2 class="package1">Checkout</h2>
    </div>
</div>
@endsection

@section('content-2')
<div class="">
    {{-- <h2 class="package1">Package features</h2> --}}
    <div class="row row_pad">
        <div class="col-md-6 col-sm-12">
            <div class="">
                <div class="card-payment">
                    <div class="card-payment-body" style="height: 350px">
                        <h3 class="border_bottom pb-4">Subscription package</h3>
                        <div class="mt-4 package-list">
                            <h4>{{$package->name}}</h4>
                            <p>{!! $package->description !!}</p>
                            <ul>
                                <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Maxims</span></li>
                                <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Maxims</span></li>
                                <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Maxims</span></li>
                                <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Maxims</span></li>
                                <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Maxims</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="">
                <div class="card-payment">
                    <div class="row">
                        <div id="check"></div>
                        <div class="col-md-6 pb-3"> <span>Pay with Debit/Credit Card</span> </div>
                        <div class="col-md-6 text-right" class="pay-type" style="margin-top: -5px;">
                            <a href="#"><img src="{{asset('assets/images/pp.svg')}}" alt="paypal" class="social1"></a>
                            <a href="#"><img src="{{asset('assets/images/visa.svg')}}" alt="visa" class="social1"></a>
                            <a href="#"><img src="{{asset('assets/images/mc.svg')}}" alt="mastercard" class="social1"></a>
                        </div>
                    </div>
                    <div class="pb-2">
                        <h6>{{ $package->name }}</h6>
                    </div>
                    <div class="">
                        <p>₦{{number_format($package->price, 2)}}</p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-9">
                            <h5 style="color: #004053; font-weight: 600">Total:</h5>
                        </div>
                        <div class="col-md-3 text-right">
                            <h5 style="color: #004053; font-weight: 600">₦{{number_format($package->price, 2)}}</h5>
                        </div>
                    </div>
                    <p style="font-size: 14px">LegalPedia is required by law to collect applicable transaction taxes for purchases made in certain jurisdiction</p>
                    <p style="font-size: 14px">By completing your purchase you agree to these <a href="#" style="font-size: 14px">Terms of service</a></p>
                    <form id="paymentForm">
                        <input type="hidden" name="name" value="{{Auth::user() ? Auth::user()->name : ''}}">
                        <input type="hidden" name="email" value="{{Auth::user() ? Auth::user()->email : ''}}">
                        {{-- <input type="hidden" name="orderID" value="345"> --}}
                        <input type="hidden" name="amount" value="{{$package->price * 100}}">
                        <input type="hidden" name="package" value="{{$package->name}}">
                        <input type="hidden" name="status" value="pending">
                        {{-- <input type="hidden" name="quantity" value="1"> --}}
                        <input type="hidden" name="currency" value="NGN">
                        {{-- <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > For other necessary things you want to add to your payload. it is optional though --}}
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                        <button class="btn text-white my-2 my-sm-0 py-2 btn-md btn-block" type="submit" onclick="payWithPaystack(event)" style="background-color: #EC6959;">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', payWithPaystack, false);
    function payWithPaystack(e) {
        e.preventDefault();
        var amount = {{$package->price}};
        var userId = "{{Auth::user() ? Auth::user()->id : ''}}";
        var name = "{{Auth::user() ? Auth::user()->name : ''}}";
        var user_email = "{{Auth::user() ? Auth::user()->email : ''}}";
        var package = "{{$package->name}}";

        var handler = PaystackPop.setup({
            key: "{{env('PAYSTACK_PUBLIC_KEY')}}",
            email: user_email,
            amount: amount * 100,
            currency: "NGN",
            ref: "{{Paystack::genTranxRef()}}",
            // ref: "{{@$randomPaymentString}}",
            // subaccount: "{{env('PAYSTACK_SUB_ACCOUNT_OPEYEMI')}}",
            // bearer: 'subaccount',
            callback: function (response) {
                $.ajax({
                    type: 'GET',
                    url: "/subscription-package/payment/callback/" + response.reference,
                    success: function (response) {
                        console.log(response);
                        if (response.status == true) {
                            swal({
                                title: "Success!",
                                text: 'Payment Verified, redirecting you back to your dashboard',
                                icon: "success",
                            });
                            window.location.href = "{{route('admin.dashboard')}}";
                        }
                        if (response.status == false) {
                            swal({
                                title: "Error!",
                                text: 'Failed to verify payment, please try again',
                                icon: "error",
                            });
                        }
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "/subscription-package/payment/" + response.reference,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        reference: response.reference,
                        userId: userId,
                        amount: amount,
                        name: name,
                        email: user_email,
                        package: package,
                        status: 'paid'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.status == false) {
                            swal({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                            });
                        }
                        if (response.status == true) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                            });
                            window.location.href = 'admin/dashboard';
                        }

                    }
                });
            },
            onClose: function () {
                swal({
                    title: "Oops!",
                    text: "Seems you are not ready to pay now... You can always come back and pay later!",
                    icon: "error",
                });
            }
        });
        handler.openIframe();
    }
</script>
@endsection
