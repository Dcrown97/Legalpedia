<title>My Messages - Legalpedia</title>

{{-- Meta tags --}}
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="id" content="{{ $id }}">
<meta name="type" content="{{ $type }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

{{-- scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

{{-- styles --}}
<link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon"/>

<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/'.$dark_mode.'.mode.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.tiny.cloud/1/ej11umb33e5ff2ugdnkhk98qxver3s1mfis8ko5ovmimyk5l/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/less@4.1.1" ></script>


{{-- Messenger Color Style--}}
@include('Chatify::layouts.messengerColor')
<div class="loader-bg">
    <div class="loader-bar"></div>
</div>
@include('elements.sidebar.chats')
@include('elements.off-canvas-demo')
@include('elements.off-canvas.chats')
@include('elements.small-sidebar')
@include('elements.top-nav')
@include('elements.mobile-navbar')
