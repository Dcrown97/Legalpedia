
        $('.save_category').click(function(e){
            e.preventDefault();
            let category_id = $('#category_id').val();
            let category_name = $('#category_name').val();
            let route = "{{route('update.category')}}"
            $.ajax({
                url:route,
                type:'POST',
                data:{
                    "_token": "{{ csrf_token() }}",
                    category_id:category_id,
                    category:category_name,
                },
                success:function(response){
                    $('#notify_success').show();
                    setTimeout(function() {
                        $('#notify_success').fadeOut("slow");
                    }, 6000 );
                    // console.log(response);
                },
                error :function( data ) {
                    if( data.status === 422 ) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            // console.log(key+ " " +value);
                        $('#response').addClass("alert alert-danger");

                            if($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    console.log(key+ " " +value);
                                $('#response').show().append(value+"<br/>");

                                });
                            }else{
                                $('#response').show().append(value+"<br/>"); //this is my div with messages
                            }
                        });
                    }
                }

            });
        });






        <div class="card" data-list='{"valueNames": ["name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}'>
            <div class="card-header">
                <h4 class="card-header-title">Forms</h4>
                <form class="me-3 w-20">
                    <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": true}'>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{$category->category}}">{{$category->category}}</option>
                        @endforeach
                    </select>
                </form>
                <a href="#!" class="btn text-white btn-sm btn-primary p-2"><i class="mdi mdi-filter"></i> Filter</a>
            </div>
            <div class="card-header">
                <form action="{{ route('search.form') }}" method="GET">
                    <div class="input-group input-group-flush input-group-merge input-group-reverse">
                        <input class="form-control list-search" name="search" id="search" type="text" placeholder="Search" aria-label="Search">
                        <div class="input-group-text">
                            <span class="fe fe-search"></span>
                        </div>
                    </div>
                </form>
                {{-- <form action="{{ route('search.form') }}" method="GET">
                    <input name="search" id="search" autocomplete="false" class="form-control list-search" type="text" placeholder="Search" aria-label="Search">
                </form> --}}
            </div>
            <div class="card-body">
                @if($forms)
                    <ul class="list-group list-group-lg list-group-flush list my-n4">
                        @foreach($forms as $form)
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <a href="{{route('show.form', $form->id)}}" class="avatar text-color avatar-lg">
                                            <i class="fe fe-file"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4 class="mb-1 name name">
                                            <a href="{{route('show.form', $form->id)}}">{{$form->title}}</a>
                                        </h4>
                                        <p class="card-text text-muted small mb-1 name">Category: <span class="text-color">{{$form->category}}</span></p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{route('edit.form', $form->id)}}" class="dropdown-item">
                                                    <i class="mdi mdi-pencil mr-2"></i> Edit
                                                </a>
                                                <form action="/admin/forms-and-precedents/{{$form->id}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" name="submit" onclick="return deleteFunction();" class="dropdown-item">
                                                        <i class="fe fe-trash mr-2"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="text-center">
                        <h1>No record found</h1>
                    </div>
                @endif
            </div>
            <div class="row g-0">

                <!-- Pagination (prev) -->
                <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fe fe-arrow-left me-1"></i> Prev
                    </a>
                  </li>
                </ul>

                <!-- Pagination -->
                <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>

                <!-- Pagination (next) -->
                <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                  <li class="page-item">
                    <a class="page-link" href="#">
                      Next <i class="fe fe-arrow-right ms-1"></i>
                    </a>
                  </li>
                </ul>

            </div>
            <div class="card-footer d-flex justify-content-center">
                {{-- <div class="m-2">
                    {{$forms->links()}}
                </div> --}}
                <div class="row g-0">

                    <!-- Pagination (prev) -->
                    <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                      <li class="page-item">
                        <a class="page-link" href="#">
                          <i class="fe fe-arrow-left me-1"></i> Prev
                        </a>
                      </li>
                    </ul>

                    <!-- Pagination -->
                    <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>

                    <!-- Pagination (next) -->
                    <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                      <li class="page-item">
                        <a class="page-link" href="#">
                          Next <i class="fe fe-arrow-right ms-1"></i>
                        </a>
                      </li>
                    </ul>

                  </div>
            </div>
        </div>





        <div class="row list">
            @if(Auth::user()->id == $team->user_id)
                @if(count($shared_resources) > 0)
                    @foreach($shared_resources as $shared_resource)
                        @if($shared_resource->file_type == 'PDF')
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->pdf_name}}">
                                                </a>
                                            </div>
                                            <div class="col ms-n2">
                                                <h4 class="mb-1 name">
                                                    <a href="{{$shared_resource->file}}">{{$shared_resource->pdf_name}}</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                        <i class="fe fe-download mx-2"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($shared_resource->file_type == 'DOC')
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->doc_name}}">
                                                </a>
                                            </div>
                                            <div class="col ms-n2">
                                                <h4 class="mb-1 name">
                                                    <a href="{{$shared_resource->file}}">{{$shared_resource->doc_name}}</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                        <i class="fe fe-download mx-2"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($shared_resource->file_type == 'ZIP')
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->zip_name}}">
                                                </a>
                                            </div>
                                            <div class="col ms-n2">
                                                <h4 class="mb-1 name">
                                                    <a href="{{$shared_resource->file}}">{{$shared_resource->zip_name}}</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                        <i class="fe fe-download mx-2"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($shared_resource->file_type == 'RAR')
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->rar_name}}">
                                                </a>
                                            </div>
                                            <div class="col ms-n2">
                                                <h4 class="mb-1 name">
                                                    <a href="{{$shared_resource->file}}">{{$shared_resource->rar_name}}</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{$shared_resource->file}}">
                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                        <i class="fe fe-download mx-2"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @else
                    <div class="row align-items-center text-center">
                        <h4 class="text-muted"><i class="mdi mdi-file-outline"></i> There are no files</h4>
                    </div>
                @endif
                @else
                @if(empty($send_request))
                    <div class="text-center m-6">
                        <h3 class="text-muted"><i class="i.mdi.mdi-warning"></i> You need to join this team to get access</h3>
                        <div class="col-auto mt-2">
                            <form action="{{route('send.request')}}" method="POST">
                                @csrf
                                <input type="hidden" name="send_request" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="team_id" value="{{$team->id}}">
                                <input type="hidden" name="team_owner_id" value="{{$team->user_id}}">
                                <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="btn text-white btn-primary d-block d-md-inline-block">
                                    <span class="button__text"><i class="mdi mdi-plus"></i> Request Access</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @elseif($send_request->send_request == 0)
                    <div class="text-center m-6">
                        <h3 class="text-muted"><i class="i.mdi.mdi-warning"></i> You need to join this team to get access</h3>
                        <div class="col-auto mt-2">
                            <form action="{{route('send.request')}}" method="POST">
                                @csrf
                                <input type="hidden" name="send_request" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="team_id" value="{{$team->id}}">
                                <input type="hidden" name="team_owner_id" value="{{$team->user_id}}">
                                <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="btn text-white btn-primary d-block d-md-inline-block">
                                    <span class="button__text"><i class="mdi mdi-plus"></i> Request Access</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @elseif($send_request->send_request == 1 && $send_request->approve_request == 0)
                    <div class="text-center m-6">
                        <h3 class="text-muted"><i class="i.mdi.mdi-warning"></i> You need to join this team to get access</h3>
                        <div class="col-auto mt-2">
                            <a style="cursor: not-allowed; text-align: center" class="px-5 bg-padding py-3 d-block d-md-inline-block font-medium leading-5 text-gray-400 transition-colors duration-150 bg-gray-100 hover:bg-gray-100 dark:bg-gray-700 border border-transparent rounded-lg">Request Sent</a>
                        </div>
                    </div>
                    @elseif($send_request->send_request == 1 && $send_request->approve_request == 1)
                    @if(count($shared_resources) > 0)
                        @foreach($shared_resources as $shared_resource)
                            @if($shared_resource->file_type == 'PDF')
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->pdf_name}}">
                                                    </a>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{$shared_resource->file}}">{{$shared_resource->pdf_name}}</a>
                                                    </h4>
                                                    <p class="card-text small text-muted">
                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                            <i class="fe fe-download mx-2"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif($shared_resource->file_type == 'DOC')
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->doc_name}}">
                                                    </a>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{$shared_resource->file}}">{{$shared_resource->doc_name}}</a>
                                                    </h4>
                                                    <p class="card-text small text-muted">
                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                            <i class="fe fe-download mx-2"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif($shared_resource->file_type == 'ZIP')
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->zip_name}}">
                                                    </a>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{$shared_resource->file}}">{{$shared_resource->zip_name}}</a>
                                                    </h4>
                                                    <p class="card-text small text-muted">
                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                            <i class="fe fe-download mx-2"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif($shared_resource->file_type == 'RAR')
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_resource->rar_name}}">
                                                    </a>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h4 class="mb-1 name">
                                                        <a href="{{$shared_resource->file}}">{{$shared_resource->rar_name}}</a>
                                                    </h4>
                                                    <p class="card-text small text-muted">
                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_resource->created_at)->toFormattedDateString()}}</time>
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{$shared_resource->file}}">
                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                            <i class="fe fe-download mx-2"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @else
                        <div class="row align-items-center text-center">
                            <h4 class="text-muted"><i class="mdi mdi-file-outline"></i> There are no files</h4>
                        </div>
                    @endif
                @endif
            @endif
        </div>



        <div class="row list">
            @if(Auth::user()->id == $team->user_id)
                @if($approved_members)
                    @foreach($approved_members as $approved_member)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="profile-posts.html" class="avatar avatar-lg">
                                                <?php $user = App\Models\User::where('id', $approved_member->user_id)->first(); ?>
                                                @if($user->photo)
                                                    <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                    @else
                                                    <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col ms-n2">
                                            <h4 class="mb-1 name">
                                                <a href="profile-posts.html">{{$user->name}}</a>
                                            </h4>
                                            <?php $online_user = App\Models\User::select("*")->whereNotNull('last_seen')->first();?>
                                            <p class="card-text small">
                                                @if(Illuminate\Support\Facades\Cache::has('user-is-online-' . $online_user->id))
                                                    <span class="text-success">●</span> Online
                                                    @else
                                                    <span class="text-secondary">●</span> Offline
                                                @endif
                                            </p>
                                        </div>
                                        @if($approved_member->user_id !== $team->user_id)
                                            <div class="col-auto">
                                                <form action="/admin/teams/remove/{{$approved_member->id}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                                        <span class="button__text"><i class="mdi mdi-close"></i> Remove</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <div class="text-center mt-4">
                        <h3 class="text-muted"><i class="fe fe-users"></i> There are no members</h3>
                        <div class="col-auto mt-2">
                            <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_member" id="kt_toolbar_primary_button" class="btn btn-primary">
                                <i class="fe fe-plus"></i> Add member
                            </a>
                        </div>
                    </div>
                @endif
                @else
                @if($approved_members)
                    @foreach($approved_members as $approved_member)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar avatar-sm">
                                                <?php $user = App\Models\User::where('id', $approved_member->user_id)->first(); ?>
                                                @if($user->photo)
                                                    <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                    @else
                                                    <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col ms-n2">
                                            <h4 class="mb-1 name">
                                                <a href="profile-posts.html">{{$user->name}}</a>
                                            </h4>
                                            <?php $online_user = App\Models\User::select("*")->whereNotNull('last_seen')->first();?>
                                            <p class="card-text small">
                                                @if(Illuminate\Support\Facades\Cache::has('user-is-online-' . $online_user->id))
                                                    <span class="text-success">●</span> Online
                                                    @else
                                                    <span class="text-secondary">●</span> Offline
                                                @endif
                                            </p>
                                        </div>
                                        @if($approved_member->user_id == auth()->id())
                                            <div class="col-auto">
                                                <form action="/admin/teams/leave/{{$approved_member->id}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                                        <span class="button__text"><i class="mdi mdi-close"></i> Leave</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <div class="text-center mt-4">
                        <h3 class="text-muted"><i class="fe fe-users"></i> There are no members</h3>
                        <div class="col-auto mt-2">
                            <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_member" id="kt_toolbar_primary_button" class="btn btn-primary">
                                <i class="fe fe-plus"></i> Add member
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>









        <div class="modal fade" id="share_articl" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen p-9">
                <div class="modal-content rounded">
                    <div class="modal-header">
                        <div class="fs-1 fw-boldest">Add new Article</div>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-2x">
                                <i class="mdi mdi-close"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y">
                        <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                            <div class="container">
                                <div class="stepper-nav justify-content-center">
                                    <form action="{{route('share.article', $article->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="input-group input-group-lg input-group-flush input-group-merge">
                                                    <textarea name="comment_body" class="form-control form-control-flush" data-autosize rows="1">
                                                        Hello, this is a new article I'm sharing
                                                        <a href="{{$article->link}}"><u>{{$article->title}}</u></a>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                                                    <div class="card-header">
                                                        <form>
                                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                                <div class="input-group-text">
                                                                    <span class="fe fe-search"></span>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="form-check mb-n2">
                                                            <input class="form-check-input list-checkbox-all" name="ordersSelect" id="ordersSelectAll" type="checkbox">
                                                            <label class="form-check-label" for="ordersSelectAll">&nbsp;</label> All Teams
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        @if($teams)
                                                            <ul id="table_data" class="list-group table_data list-group-lg list-group-flush list my-n4">
                                                                @foreach($teams as $team)
                                                                    <li class="list-group-item">
                                                                        <div class="row align-items-center">
                                                                            <div class="col">
                                                                                <div class="form-check mb-n2">
                                                                                    <input class="form-check-input list-checkbox" type="checkbox" name="ordersSelect" id="ordersSelectOne">
                                                                                    <label class="form-check-label" for="ordersSelectOne">&nbsp;</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <a href="profile-posts.html" class="avatar avatar-lg">
                                                                                    <img src="{{$team->photo}}" class="avatar-img rounded-circle" alt="{{$team->name}}">
                                                                                </a>
                                                                            </div>
                                                                            <div class="col ms-n2">
                                                                                <h4 class="mb-1 item-name">
                                                                                    <a href="profile-posts.html">{{$team->name}}</a>
                                                                                </h4>
                                                                                {{-- <small class="text-muted">
                                                                                    {{$team_member_count}}
                                                                                </small> --}}
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                                                <input type="hidden" name="team_id" value="{{$team->id}}">
                                                                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                                                                    <span class="button__text"><i class="mdi mdi-close"></i> Share</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            @else
                                                            <div class="text-center mt-8 mb-8">
                                                                <h3 class="text-muted"><i class="fe fe-users"></i> You have no teams</h3>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- $voucher->code = $this->generateRandomString(6);// it should be dynamic and unique

        public  function generateRandomString($length = 20) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            } --}}







            // (function() {
                // var r = Recogito.init({
                //     content: document.getElementById('my-content') // ID or DOM element
                // });

                // // Add an event handler
                // r.on('createAnnotation', function(annotation) { /** **/ });
                // })();


                // An example annotation we'll add/remove via JavaScript
              var myAnnotation = {
                '@context': 'http://www.w3.org/ns/anno.jsonld',
                'id': 'https://www.example.com/recogito-js-example/foo',
                'type': 'Annotation',
                'body': [{
                  'type': 'TextualBody',
                  'value': 'This annotation was added via JS.'
                }],
                'target': {
                  'selector': [{
                    'type': 'TextQuoteSelector',
                    'exact': 'that ingenious hero'
                  }, {
                    'type': 'TextPositionSelector',
                    'start': 38,
                    'end': 57
                  }]
                }
              };








