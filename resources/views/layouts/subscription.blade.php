<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('title')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon"/>
    {{-- <link src='/assets/fonts/poppins' rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('assets/css/main-style.css')}}" id="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
@yield('styles')
<style>
    body {
    font-family: 'Poppins', sans-serif;
    }

    .backg {
        background: url("{{asset('assets/images/frame2.svg')}}");
        position: absolute;
        top: 183px;
        left: 80px;
        height: 222px;
        width: 261px;
    }

    .backg2 {
        background: url("{{asset('assets/images/frame1.svg')}}");
        position: absolute;
        top: 183px;
        left: 1174px;
        height: 222px;
        width: 260px;
    }

    .cont {
        padding-top: 70px;
        padding-bottom: 20px;
    }

    .head {
        padding: 10px 60px;
    }

    .btn_pad {
        padding: 10px 57px;
        margin-left: 15px !important;
    }

    .btn_pa {
        padding: 10px 57px;
        margin-top: 15px !important;
    }

    .nav-item {
        margin: 0px 15px;
    }

    .package {
        color: #EC6959;
        font-size: small;

    }

    .package3 {
        color: #363636;
        padding: 20px 196px;
    }

    .package1 {
        color: #363636;
        font-size: -webkit-xxx-large;
    }

    @media(max-width: 991px) {
        .package3 {
            color: #363636;
            padding: 10px 100px;
        }
    }

    @media(max-width: 767px) {
        .package3 {
            color: #363636;
            padding: 0px !important;
        }


    }

    @media(max-width: 977px) {

        .row_pad {

            margin: 0px !important;
        }
    }

    @media(max-width: 1433px) {

        .backg,
        .backg2 {
            display: none !important;
        }
    }

    @media(max-width: 1230px) {
        .font_head {
            background: url("{{asset('assets/images/atm.svg')}}");
            background-size: cover;
            padding: 50px 0px;
            margin: 20px !important;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }
    }

    .row_pad {
        box-shadow: 0px 0px 1px #ccc;
        margin: 50px 187px;
    }

    .font_siz {
        font-size: small;
        margin-top: 20px;
    }

    .font_head {
        background: url("{{asset('assets/images/atm.svg')}}");
        background-size: cover;
        padding: 50px 0px;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .siz {
        font-size: xxx-large;
        font-weight: 500;
        margin-top: 40px;
    }

    .pad_bot {
        padding: 7px 0px;
        color: #777777;

    }

    .pad_top {
        padding-top: 20px;

    }

    .pad_top1 {
        padding-left: 55px;
    }

    .pad_top2 {
        padding-left: 36px;
    }

    .ulz {
        list-style: none;
        padding: 0px;
        color: #777777;
    }

    .cont2 {
        padding: 74px;
    }

    .logo_1 {
        margin-bottom: 30px;
        margin-top: 7px;
    }

    .logos {
        margin-bottom: 24px;
    }

    .liz {
        margin-bottom: 7px;
    }

    .social {
        border-radius: 50px;
        box-shadow: 0 0 3px #ccc;
        padding: 6px;
        margin: 6px;
    }

    .social1 {

        padding: 6px;
        margin: 6px;
    }

    .ads:hover {
        color: #EC6959;
        font-size: large;
        text-decoration: none;
    }

    .ads {
        color: #777777;
    }
    .toast {
        background: #20D489 !important;
        top: 5% !important;
        left: 70%;
        position: fixed !important;
        z-index: 999 !important;
        padding: 0 !important;
        transform-origin: right;
        -webkit-animation: notify 3s ease-out;
        animation: notify 3s ease-out;
        box-shadow: 0 0.55rem 0.5rem rgb(18 38 63 / 3%) !important;
    }
    .toast-error {
        background: #F41919 !important;
        top: 5% !important;
        left: 70%;
        position: fixed !important;
        z-index: 999 !important;
        padding: 0 !important;
        transform-origin: right;
        -webkit-animation: notify 3s ease-out;
        animation: notify 3s ease-out;
        box-shadow: 0 0.5rem 0.5rem rgb(18 38 63 / 3%) !important;
    }
    @-webkit-keyframes notify {
        0% {transform: scaleX(0);}
        10% {transform: scaleX(0.5);}
        13% {transform: scale(1);}
        16% {transform: scale(1);}
        55% {transform: scaleX(1);}
        65% {transform: scaleX(1);}
        95% {transform: scaleX(1);}
        100% {transform: scaleX(1);}
    }

    @keyframes notify {
        0% {transform: scaleX(0);}
        10% {transform: scaleX(0.5);}
        13% {transform: scale(1);}
        16% {transform: scale(1);}
        55% {transform: scaleX(1);}
        65% {transform: scaleX(1);}
        95% {transform: scaleX(1);}
        100% {transform: scaleX(1);}
    }
    .toast-header {
        background-color: transparent !important;
        border-bottom: none !important;
        /* background-color: rgba(255,255,255,.85) !important; */
    }
    .toast-body {
        /* background-color: rgba(255,255,255,.85) !important; */
        background-color: none !important;
    }

    @media screen and (min-width: 280px) and (max-width: 1000px) {
        .toast {
            left: 30% !important;
            top: 10% !important;
        }

        .toast-error {
            left: 30% !important;
            top: 10% !important;
        }
    }
    .button_load {
        position: relative;
    }

    .button__text {
        /* color: #fff; */
        transition: all 0.2s;
    }

    .button--loading .button__text {
        visibility: hidden;
        opacity: 0;
    }

    .button--loading::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        border: 3px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: button-loading-spinner 1s ease infinite;
    }

    @keyframes button-loading-spinner {
        from {
            transform: rotate(0turn);
        }

        to {
            transform: rotate(1turn);
        }
    }

    .fh5co-loader {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, 0.9) !important;
        z-index: 999;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        transition: all .5s ease;
        }
        .loader{
        display: block;
        position: relative;
        left: 50%;
        top: 50%;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: transparent;
        border-top-color: #EC6959;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }
    .loader:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #EC6959;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }
    .loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #EC6959;
        -webkit-animation: spin 1.5s linear infinite;
        animation: spin 1.5s linear infinite;
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
<body style="background: #fff;">
    <div class="loader-bg">
		<div class="loader-bar"></div>
    </div>
    <div style="background: linear-gradient(0deg, rgba(255,255,255,1) 51%, rgba(255,240,240,1) 80%);">
        <div class="backg"></div>
        @include('elements.main-nav')
        @yield('content-1')
        <div class="backg2"></div>
    </div>
    @yield('content-2')
    @include('elements.footer')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @include('elements.notifications')
    <script>
        $(document).ready(function(){
            var $window=$(window);
            $('.loader-bg').fadeOut();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.toast').toast('show');
        });
    </script>
</body>
</html>
