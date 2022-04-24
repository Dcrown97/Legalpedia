<style>
    .swal-modal .swal-text {
        text-align: center;
    }
 </style>
@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="toast toast-error" data-autohide="false">
            <div class="toast-body">
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                <p class="text-white"><i class="mdi mdi-information-outline mr-1"></i>{{ $error }}</p>
            </div>
        </div>
    @endforeach
@endif
@if(session()->has('error1'))
    <div class="toast toast-error" data-autohide="false">
        <div class="toast-body">
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
            <p class="text-white"><i class="mdi mdi-information-outline mr-1"></i>{{ session()->get('error1') }}</p>
        </div>
    </div>
@endif
@if(session()->has('success'))
    <div class="toast" id="toast-success" data-autohide="false">
        <div class="toast-body">
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
            <p class="text-white"><i class="mdi mdi-check mr-1"></i> {{ session()->get('success') }}</p>
        </div>
    </div>
@endif
 <script type="text/javascript">

     @if(Session::has('success1'))
         swal({
             title: "Success!",
             text: "{{Session::get('success1')}}",
             icon: "success",
         });
     @endif

    // @if($errors->any())
    //     @foreach ($errors->all() as $error)
    //         swal({
    //             title: "Sorry!",
    //             text: "{{$error}}",
    //             icon: "warning",
    //         });
    //     @endforeach
    // @endif

    @if(session()->has('error'))
        swal({
            title: "Sorry!",
            text: "{{session()->get('error')}}",
            icon: "warning",
        });
    @endif

    //  @if(Session::has('warning'))
    //      swal({
    //          title: "Atention!",
    //          text: "{{Session::get('warning')}}",
    //          icon: "warning",
    //      });
    //  @endif

    //  @if(Session::has('info'))
    //      swal({
    //          title: "OK!",
    //          text: "{{Session::get('info')}}",
    //          icon: "info",
    //      });
    //  @endif
 </script>
