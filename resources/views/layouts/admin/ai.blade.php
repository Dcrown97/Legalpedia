<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon" />

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
    <link rel="stylesheet/less" type="text/css" href="{{ asset('assets/css/upload-group.scss') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />

    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ej11umb33e5ff2ugdnkhk98qxver3s1mfis8ko5ovmimyk5l/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MKT36XX');
    </script>
    <!-- End Google Tag Manager -->

    <style>
        body {
            display: none;
        }
    </style>

    <!-- Title -->
    @yield('title')

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MKT36XX" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>
    @include('elements.sidebar.notes')
    @include('elements.off-canvas.notes')
    @include('elements.small-sidebar')
    @include('elements.top-nav')
    @include('elements.mobile-navbar')
    <div class="main-content">
        @include('elements.mobile-navbar')
        @include('elements.searchbar')
        @yield('content')
        @include('elements.send-report')
    </div>

    <script src='../api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <!-- Vendor JS -->
    <script src="{{asset('assets/js/vendor.bundle.js')}}"></script>

    <!-- Theme JS -->
    <script src="{{asset('assets/js/theme.bundle.js')}}"></script>

    <script>
        $(document).ready(function() {
            var $window = $(window);
            $('.loader-bg').fadeOut();
        });
        tinymce.init({
            selector: '#description',
            plugins: 'autolink lists link image'
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        var route = "{{ url('autocomplete-search') }}";

        $('#search').typeahead({
            source: function(query, process) {
                return $.get(route, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    </script>
    <script type="text/javascript">
        Dropzone.options.dropzone = {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".pdf",
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response) {
                return false;
            }
        };
    </script>
</body>

</html>