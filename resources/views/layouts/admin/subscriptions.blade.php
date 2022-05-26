<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon"/>

    <!-- Map CSS -->
    <link rel="stylesheet" href="../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/libs.bundle.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.1.95/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    @yield('links')

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/theme.bundle.css')}}" id="stylesheetLight" />
    <link rel="stylesheet" href="{{asset('assets/css/theme-dark.bundle.css')}}" id="stylesheetDark" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ej11umb33e5ff2ugdnkhk98qxver3s1mfis8ko5ovmimyk5l/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MKT36XX');
    </script>
    <!-- End Google Tag Manager -->

    <style>body { display: none; }</style>

    <!-- Title -->
    @yield('title')

  </head>
  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MKT36XX"height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="loader-bg">
		<div class="loader-bar"></div>
    </div>
    @include('elements.sidebar.subscriptions')
    @include('elements.off-canvas.subscriptions')
    @include('elements.small-sidebar')
    @include('elements.top-nav')
    @include('elements.mobile-navbar')
    <div class="main-content">
        @include('elements.mobile-navbar')
        @include('elements.searchbar')
        @yield('content')
    </div>

    <script src='../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <!-- Vendor JS -->
    <script src="{{asset('assets/js/vendor.bundle.js')}}"></script>

    <!-- Theme JS -->
    <script src="{{asset('assets/js/theme.bundle.js')}}"></script>

    <script>
        $(document).ready(function(){
            var $window=$(window);
            $('.loader-bg').fadeOut();
        });
        tinymce.init({
            selector: 'textarea',
            plugins: 'autolink lists link image'
        });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
        $(document).ready(function(){
            $('.toast').toast('show');
        });
  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var route = "{{ url('autocomplete-search') }}";

    $('#search').typeahead({
        source: function (query, process) {
            return $.get(route, {
                query: query
            }, function (data) {
                return process(data);
            });
        }
    });
</script>
  </body>
</html>
