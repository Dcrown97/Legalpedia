@extends('layouts.subscription')

@section('title')
<title>Message Sent</title>
@endsection

@section('content-1')
<div class="text-center container">
    <div class="container">
        <img src="{{asset('assets/images/conf.gif')}}" style="height: 100px">
        <h3>Congratulations, Messages are currently on their way!</h3>
        <p><a href="{{url('admin/messages')}}" class="text-color" style="text-decoration: none"><i class="mdi mdi-arrow-left"></i>  Back to messages </a></p>
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

</style>
<div class="text-center">
    <div class="row row_pad text-center justify-content-center">
        <img src="{{asset('assets/images/success.gif')}}" style="height: 300px">
    </div>
</div>
@endsection
