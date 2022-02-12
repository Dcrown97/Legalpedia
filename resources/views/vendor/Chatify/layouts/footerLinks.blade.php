<script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
<script >
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
    encrypted: true,
    cluster: "{{ config('chatify.pusher.options.cluster') }}",
    authEndpoint: '{{route("pusher.auth")}}',
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
  });
</script>
<script src="{{ asset('js/chatify/code.js') }}"></script>


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
            selector: '#description',
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
