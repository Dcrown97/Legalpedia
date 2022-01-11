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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/main-style.css')}}" id="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/theme.bundle.css')}}" id="stylesheetLight" />
    <link rel="stylesheet" href="{{asset('assets/css/theme-dark.bundle.css')}}" id="stylesheetDark" />
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

    }

    .siz {
        font-size: xxx-large;
        font-weight: 400;
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
    <script>
        $(document).ready(function(){
            var $window=$(window);
            $('.loader-bg').fadeOut();
        });
    </script>
</body>
</html>
