@extends('layouts.subscription')

@section('title')
<title>Payment Successful</title>
@endsection

@section('content-1')
<div class="text-center container">
    <div class="container">
        <img src="{{asset('assets/images/paperplane.gif')}}" style="height: 100px">
        <h3>Purchase Successful!</h3>
        <p>Your purchase ID has been received.
            To confirm your payment and activate your package, send a receipt of payment issued from your bank to
            <a href="mailto:legalpediapayments@gmail.com">legalpediapayments@gmail.com</a>
            alongside your payment reference ID. Payment details can be found below
        </p>
        <p><a href="{{url('admin/dashboard')}}" class="text-color" style="text-decoration: none"><i class="mdi mdi-arrow-left"></i>  Back to dashboard </a></p>
    </div>
</div>
@endsection

@section('content-2')
<style>
    .custom-feature {
       text-decoration: none !important;
       color: #EC6959;
    }
    .text-color {
       color: #EC6959;
    }
    .backg2 {
        opacity: 0.4;
    }
</style>
<div class="text-center">
    <div class="row row_pad text-center justify-content-center p-4">
        <p>Payment reference ID: {{$transaction->reference}} <br>
            Subscribed Package: {{$transaction->package}} <br>
            Amount to pay: ₦{{number_format($transaction->amount, 2)}} <br>
            Purchase date: {{\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()}} <br>
            Name: {{$transaction->name}} <br>
            Email: {{$transaction->email}} <br>
        </p>
    </div>
    <div class="row text-center justify-content-center p-4">
        <p class="text-color">Account Number: 0809282089 <br>
            Account Name: Legalpedia Nig Ltd<br>
            Bank: Access Bank <br>
        </p>
    </div>
</div>
@endsection
