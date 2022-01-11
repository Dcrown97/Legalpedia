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


    <style>body { display: none; }</style>

    <!-- Title -->
    @yield('title')

  </head>
  <body>
    <div class="loader-bg">
		<div class="loader-bar"></div>
    </div>
    @include('elements.sidebar.license')
    @include('elements.off-canvas.license')
    @include('elements.small-sidebar')
    @include('elements.top-nav')
    @include('elements.mobile-navbar')
    <div class="main-content">
        @include('elements.mobile-navbar')
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
