@extends('layouts.subscription')

@section('title')
<title>{{$package->name}} Subscription Package</title>
@endsection

@section('content-1')
<div class="text-center container cont">
    <div class="container">
        <h3 class="package"> PACKAGE DESCRIPTION</h3>
        <h2 class="package1">{{$package->name}} Package</h2>
        <p class="package3">{!! $package->description !!}</p>
    </div>
</div>
@endsection

@section('content-2')
<div class="text-center cont">
    <h3 class="package">PACKAGE FEATURES</h3>
    <h2 class="package1">Package features</h2>
    <div class="row row_pad">
        <div class="col-md-6 col-sm-12">
            <div class="text-white font_head">
                <h4>{{$package->name}}</h4>
                <h5 class="font_siz">Monthly</h5>
                <h5 class="font_siz">(Package renews after {{$package->recur_date}} {{$package->validity}})</h5>
                <h1 class="siz">₦{{number_format($package->price, 2)}}</h1>

                <a href="{{route('checkout', $package->id)}}" class="btn bg-white my-2 my-sm-0 btn_pa ml-auto" style="color: #EC6959;">Subscribe now</a>
            </div>
        </div>
        <div class="col-md-6 text-left pad_top">
            <h4 class="pad_top2">Features</h4>
            <div class="pad_top1">
                <div class="row">
                    @if($package->judgement_feature)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-success"></i> <span>Judgement</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-secondary"></i> <span>Judgement</span>
                        </div>
                    @endif
                    @if($package->article_feature)
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-check-circle text-success"></i> <span>Articles</span>
                        </div>
                        @else
                        <div class="col-md-6 pad_bot">
                            <i class="fas fa-times-circle text-secondary"></i> <span>Articles</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>LFN</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Notes</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>ROC</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Sharing</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>DIC</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Bookmarks</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Maxims</span>
                    </div>
                    <div class="col-md-6 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Teams</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Foreign Resources</span>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 pad_bot">
                        <i class="fas fa-check-circle text-success"></i> <span>Forms and Precedents</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("input[name=_token]").val()
        }
    });

    function payWithPaystack() {

        $.ajax({
            type: 'POST',
            url: "{{ route('sub.pay') }}",
            data: {
                reference: response.reference,
                // domain_name: domainName,
                user_id: userId,
                amount: amount
            },
            success: function (data) {
                console.log(data);
                document.getElementById('btn-available').style.display = 'none';

                var amount = {{$package->price}};
                var userId = "{{Auth::user() ? Auth::user()->id : ''}}";
                // var domainName = $("input[name=domain_name]").val();

                var handler = PaystackPop.setup({
                    key: "{{env('PAYSTACK_PUBLIC_KEY')}}",
                    email: "{{Auth::user() ? Auth::user()->email : ''}}",
                    amount: amount * 100,
                    currency: "NGN",
                    ref: "{{@$randomPaymentString}}",
                    // subaccount: "{{env('PAYSTACK_SUB_ACCOUNT_OPEYEMI')}}",
                    // bearer: 'subaccount',

                    callback: function (response) {
                        //
                        // alert('success. transaction ref is ' + response.reference);
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('sub.pay') }}",
                            data: {
                                reference: response.reference,
                                // domain_name: domainName,
                                user_id: userId,
                                amount: amount
                            },
                            success: function (data) {
                                console.log(data);
                                document.getElementById('btn-available').style.display = 'none';

                                if (data.status == 'error') {

                                    swal({
                                        title: "Error!",
                                        text: data.data,
                                        icon: "error",
                                    });
                                }

                                if (data.status == 'success') {
                                    document.getElementById('btn-available').style.display = 'none';

                                    document.getElementById('default-domain').innerHTML = 'You custom domain name is: '+ domainName;
                                    swal({
                                        title: "Success!",
                                        text: data.data,
                                        icon: "success",
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

                        if (data.status == 'error') {

                            swal({
                                title: "Error!",
                                text: data.data,
                                icon: "error",
                            });
                        }

                        if (data.status == 'success') {
                            document.getElementById('btn-available').style.display = 'none';

                            document.getElementById('default-domain').innerHTML = 'You custom domain name is: '+ domainName;
                            swal({
                                title: "Success!",
                                text: data.data,
                                icon: "success",
                            });
                        }

                    }
                });


    }
</script>
@endsection
