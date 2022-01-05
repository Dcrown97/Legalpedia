
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
                                        <h4 class="mb-1 name">
                                            <a href="{{route('show.form', $form->id)}}">{{$form->title}}</a>
                                        </h4>
                                        <p class="card-text text-muted small mb-1">Category: <span class="text-color">{{$form->category}}</span></p>
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

















