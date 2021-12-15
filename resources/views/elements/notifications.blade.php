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
@if(session()->has('success'))
    <div class="toast" data-autohide="false">
        <div class="toast-body">
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
            <p class="text-white"><i class="mdi mdi-check mr-1"></i> {{ session()->get('success') }}</p>
        </div>
    </div>
@endif
