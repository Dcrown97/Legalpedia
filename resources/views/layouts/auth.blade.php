<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('title')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon"/>

    <!-- <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    @yield('links')
    <style>
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
            .modal-content {
                width: 100% !important;
            }
        }
    </style>

    </head>
    <body>
        <main class="d-flex align-items-center height-100">
            @include('elements.notifications')
            @yield('content')
        </main>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.toast').toast('show');
            });
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose:true //to close picker once year is selected
            });
        </script>
    </body>
</html>
