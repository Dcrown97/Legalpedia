@extends('layouts.admin.teams')

@section('title')
    <title>Meeting - {{$team->name}} - Legalpedia</title>
@endsection

@section('content')
<script src='https://meet.jit.si/external_api.js'></script>
    <style>html, body, #meeting { height: 100vh; }</style>
    <script type="text/javascript">
        // window.onload = () => {
        //     const api = new JitsiMeetExternalAPI("meet.jit.si", {
        //         roomName: "{!! Str::words($team->name ? $team->name : 'MyMeeting', 1, '') !!}",
        //         height: '100%',
        //         width: '100%',
        //         parentNode: document.querySelector('#meeting')
        //     });
        // }
        $(document).ready(function() {
            var domain = 'meet.jit.si';
            var options = {
                roomName: "{!! Str::words($team->name ? $team->name : 'MyMeeting', 1, '') !!}",
                height: '100%',
                width: '100%',
                parentNode: document.querySelector('#meeting')
            }
            var api = new JitsiMeetExternalAPI(domain, options);
        });
    </script>

<div class="container-fluid" id="meeting"></div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
