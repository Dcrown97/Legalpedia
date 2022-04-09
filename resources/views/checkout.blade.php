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

        .card {
        word-wrap: break-word;
        background-clip: border-box;
        background-color: #fff;
        border: 1px solid #edf2f9;
        border-radius: .5rem;
        display: flex;
        flex-direction: column;
        min-width: 0;
        position: relative;

        border-color: #edf2f9;
        box-shadow: 0 0.75rem 1.5rem rgb(18 38 63 / 3%);
        margin-bottom: 1.5rem;
        }
        .custom-text {
            color: #999 !important;
            font-weight: 400;
            /* line-height: 25px; */
        }
        .text-muted {
            opacity: 1;
            color: #95aac9!important;
        }
        .text-color {
            color: #EC6959 !important;
        }
        .btn-primary {
            background-color: #EC6959 !important;
            border-color: #EC6959 !important;
            color: #fff !important;
        }
        .btn {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
            border-radius: 3px !important;
        }
        .custom-input {
            height: fit-content !important;
            border-radius: 3px !important;
            width: 50% !important;
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
        .border_top {
            border-top: 1px dashed #d9d9d9;
        }
        .package-list ul li{
            list-style: none;
        }

        .custom-option-width {
            width: inherit !important;
        }
        .-mt-1 {
            margin-top: -10px;
        }
        .alert-warning, .alert-success {
            padding: 15px;
            border-radius: 5px;
            font-size: 14px !important;
        }
    </style>
@endsection

@section('content-1')
<div class="fh5co-loader" id="reloader" style="display: none">
    <div class="loader"></div>
</div>
<div class="text-center container cont">
    <div class="container">
        <h3 class="package">PROCEED TO PAYMENT</h3>
        <h2 class="package1">Checkout</h2>
    </div>
    {{-- @include('elements.notifications') --}}
</div>
@endsection

@section('content-2')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-6">
            <div class="card p-2">
                <div class="card-body">
                    <h3 class="border_bottom pb-4">Subscription package</h3>
                    <div class="my-4 package-list">
                        <h4>{{$package->name}}</h4>
                        <p>{!! $package->description !!}</p>
                        <div class="row">
                            <div class="col-md-6 pad-bot">
                                <ul>
                                    @if($package->judgement_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Judgements</span></li>
                                    @endif
                                    @if($package->lfn_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Laws of Federation</span></li>
                                    @endif
                                    @if($package->roc_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Rules of Court</span></li>
                                    @endif
                                    @if($package->sroc_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>State Rules of Court</span></li>
                                    @endif
                                    @if($package->form_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Forms and Precedents</span></li>
                                    @endif
                                    @if($package->article_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Legal Articles</span></li>
                                    @endif
                                    @if($package->dict_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Law Dictionary</span></li>
                                    @endif
                                    @if($package->maxim_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Legal Maxims</span></li>
                                    @endif
                                    @if($package->resource_feature)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Foreign Resources</span></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6 pad-bot">
                                <ul>
                                    @if($package->note)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Notes</span></li>
                                    @endif
                                    @if($package->share)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Sharing</span></li>
                                    @endif
                                    {{-- @if($package->bookmark)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Bookmarks</span></li>
                                    @endif --}}
                                    @if($package->team)
                                        <li><i class="fas fa-check-circle text-success mr-2"></i> <span>Teams</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <span>
                        <p class="border_top pt-4">Have a discount coupon?</p>
                        <form action="{{route('use.discount', $package->id)}}" method="POST" class="d-flex">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <input type="hidden" name="package_id" class="form-control" value="{{$package->id}}">
                            <input type="text" name="used" class="form-control custom-input mr-2">
                            <button type="submit" name="verify_code" onclick="this.classList.toggle('button--loading')" class="button_load btn btn-primary text-white">
                                <span class="button__text"><i class="mdi mdi-check"></i> Apply coupon</span>
                            </button>
                        </form>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6">
            <div class="card p-2">
                <div class="card-body">
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
                        <div class="col-md-6">
                            <h5 style="color: #004053; font-weight: 600">Total:</h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5 style="color: #004053; font-weight: 600">₦{{number_format($package->price, 2)}}</h5>
                        </div>
                    </div>
                    <p style="font-size: 14px">LegalPedia is required by law to collect applicable transaction taxes for purchases made in certain jurisdiction</p>
                    <p style="font-size: 14px">By completing your purchase you agree to these <a href="#" style="font-size: 14px">Terms of service</a></p>
                    <div class="form-group">
                        <label class="flex">
                            <input type="radio" name="payment_option" class="custom-option-width" id="bank-option" checked>
                            <span class="pl-2 -mt-1">Direct Bank Transfer</span>
                        </label><br>
                        <p class="alert-warning" id="bank-message">Make your payment directly into Legalpedia's account.
                            Details can be found after completing this purchase.
                            Once your payment is confirmed, your package will be activated.
                        </p>
                    </div>
                    <div class="form-group">
                        <label class="flex">
                            <input type="radio" name="payment_option" class="custom-option-width" id="paystack-option">
                            <span class="pl-2 -mt-1">Paystack - Fast and secure</span>
                        </label><br>
                        <p class="alert-success" id="paystack-message">Pay with your credit/debit cards, USSD or Instant bank payment and activate your package instantly</p>
                    </div>
                    <form id="paymentForm">
                        <input type="hidden" name="name" value="{{Auth::user() ? Auth::user()->name : ''}}">
                        <input type="hidden" name="email" value="{{Auth::user() ? Auth::user()->email : ''}}">
                        {{-- <input type="hidden" name="orderID" value="345"> --}}
                        <input type="hidden" name="amount" value="{{$package->price * 100}}">
                        <input type="hidden" name="package" value="{{$package->name}}">
                        <input type="hidden" name="package_id" value="{{$package->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user() ? Auth::user()->id : ''}}">
                        <input type="hidden" name="status" value="pending">
                        <input type="hidden" name="expiry_date" value="">
                        <input type="hidden" name="recur_date" value="{{$package->recur_date}}">
                        {{-- <input type="hidden" name="quantity" value="1"> --}}
                        <input type="hidden" name="currency" value="NGN">
                        {{-- <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > For other necessary things you want to add to your payload. it is optional though --}}
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                        <button class="btn text-white my-2 my-sm-0 py-2 btn-md btn-block" type="submit" onclick="payWithPaystack(event)" style="background-color: #EC6959;">Proceed to Payment</button>
                    </form>
                    @php
                        $random_string = Paystack::genTranxRef();
                    @endphp
                    <form action="{{route('payment.success', $random_string)}}" method="POST" id="bankPayment">
                        @csrf
                        <input type="hidden" name="name" value="{{Auth::user() ? Auth::user()->name : ''}}">
                        <input type="hidden" name="email" value="{{Auth::user() ? Auth::user()->email : ''}}">
                        <input type="hidden" name="amount" value="{{$package->price}}">
                        <input type="hidden" name="package" value="{{$package->name}}">
                        <input type="hidden" name="package_id" value="{{$package->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::user() ? Auth::user()->id : ''}}">
                        <input type="hidden" name="status" value="pending">
                        <input type="hidden" name="expiry_date" value="">
                        <input type="hidden" name="recur_date" value="{{$package->recur_date}}">
                        <input type="hidden" name="reference" value="{{$random_string}}">
                        <button class="btn text-white my-2 my-sm-0 py-2 btn-md btn-block button_load" type="submit" name="bank_payment" onclick="this.classList.toggle('button--loading')" style="background-color: #EC6959;">
                            <span class="button__text"> Complete Purchase</span>
                        </button>
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
    $(document).ready(function () {
        $("#paystack-message").hide();
        $("#paymentForm").hide();
        $('#bank-option').change(function () {
            if (this.checked) {
                $("#bank-message").show();
                $("#bankPayment").show();
                $("#paystack-message").hide();
                $("#paymentForm").hide();
            }
            else {
                $("#bank-message").hide();
                $("#bankPayment").hide();
                $("#paystack-message").show();
                $("#paymentForm").show();

            }
        });
        $('#paystack-option').change(function () {
            if (this.checked) {
                $("#bank-message").hide();
                $("#bankPayment").hide();
                $("#paystack-message").show();
                $("#paymentForm").show();
            }
            else {
                $("#bank-message").show();
                $("#bankPayment").show();
                $("#paystack-message").hide();
                $("#paymentForm").hide();
            }
        });
    });
</script>
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
        var packageId = "{{$package->id}}";
        var recur_date = {{$package->recur_date}};

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
                document.getElementById('reloader').style.display = 'block';
                /// initialise payment and set status to pending
                $.ajax({
                    type: 'POST',
                    url: "/subscription-package/payment/" + response.reference,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        reference: response.reference,
                        user_id: userId,
                        amount: amount,
                        name: name,
                        email: user_email,
                        package: package,
                        package_id: packageId,
                        recur_date: recur_date,
                        status: 'pending'
                    },
                    success: function (response) {
                        console.log(response);
                    }

                });

                /// verify the payment then update status to paid
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
