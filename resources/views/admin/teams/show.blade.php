@extends('layouts.admin.teams')

@section('title')
    <title>{{$team->name}} - Legalpedia</title>
@endsection

@section('content')
    <style>
        .header-img-top {
            height: 300px !important;
            object-fit: cover !important;
        }
        .text-green-0{
            color: #32E017 !important;
        }
        .h-2{
            height: 25px;
        }
        .w-2{
            width: 25px;
        }
        .cursor {
            cursor: pointer;
        }
        .modal-content {
            width: 100% !important;
            height: auto !important;
        }
    </style>
    <div class="header">
        <img src="{{$team->photo}}" class="header-img-top" alt="...">
        <div class="container-fluid">
            @include('elements.notifications')
            <div class="header-body mt-n5 mt-md-n6">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <div class="avatar avatar-xxl header-avatar-top">
                            <img src="{{$team->photo}}" alt="..." class="avatar-img rounded border border-4 border-body">
                        </div>
                    </div>
                    <div class="col mb-3 ms-n3 ms-md-n2">
                        <h6 class="header-pretitle">
                            <a href="{{url('admin/teams')}}" class="text-color mb-6"><i class="fe fe-arrow-left mr-2"></i> Back to Teams</a>
                        </h6>
                        <h1 class="header-title">
                            {{$team->name}}
                        </h1>
                    </div>
                    <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3">
                        @if(Auth::user()->id !== $team->user_id)
                            @if(empty($send_request))
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
                                @elseif($send_request->send_request == 0)
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
                                @elseif($send_request->send_request == 1 && $send_request->approve_request == 0)
                                <a style="cursor: not-allowed; text-align: center" class="px-5 bg-padding py-3 d-block d-md-inline-block font-medium leading-5 text-gray-400 transition-colors duration-150 bg-gray-100 hover:bg-gray-100 dark:bg-gray-700 border border-transparent rounded-lg">Request Sent</a>
                                @elseif($send_request->send_request == 1 && $send_request->approve_request == 1)
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                        <ul class="nav nav-tabs nav-overflow header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="feeds-tab" data-toggle="tab" href="#feeds" role="tab" aria-controls="feeds" aria-selected="true">
                                    Team Feeds
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab" aria-controls="members" aria-selected="false">
                                    Members
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="false">
                                    Shared Resources
                                </a>
                            </li>
                            @if(Auth::user()->id == $team->user_id)
                                <li class="nav-item">
                                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                                        Settings
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="tab-content" id="wizardSteps">
            <div class="tab-pane fade show active" id="feeds" role="tabpanel" aria-labelledby="feeds-tab">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        @if(Auth::user()->id == $team->user_id)
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{route('post.comment')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group input-group-lg input-group-flush input-group-merge">
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="team_id" value="{{$team->id}}">
                                            <textarea name="comment_body" class="form-control form-control-flush" data-autosize rows="1" placeholder="Create posts and share files to this team"></textarea>
                                            <div class="input-group-text">
                                                <a class="text-reset me-3" style="cursor: pointer" id="attach" onclick="showFile()" data-bs-toggle="tooltip" title="Attach file">
                                                    <i class="fe fe-paperclip"></i>
                                                </a>
                                                <a class="text-reset me-3" style="cursor: pointer; display:none" id="remove" onclick="removeFile()" data-bs-toggle="tooltip" title="Remove file">
                                                    <i class="mdi mdi-close"></i>
                                                </a>
                                                <button type="submit" onclick="this.classList.toggle('button--loading')" id="remove-1" class="btn button_load text-white btn-primary">
                                                    <span class="button__text"><i class="mdi mdi-check"></i> Post</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="file-input" id="file_input" style="display: none">
                                            <div class="form-group">
                                                <label class="form-label mb-1">
                                                    Select File type
                                                </label>
                                                <select name="file_type" id="file_type" class="form-select" onchange="showDiv('PDF', 'DOC', 'ZIP', 'RAR', this)">
                                                    <option value="image">Image</option>
                                                    <option value="PDF" data_type="files">PDF</option>
                                                    <option value="DOC" data_type="files">DOC</option>
                                                    <option value="ZIP" data_type="files">ZIP</option>
                                                    <option value="RAR" data_type="files">RAR</option>
                                                </select>
                                            </div>
                                            <div class="form-group file_name" id="PDF" style="display: none">
                                                <label class="form-label mb-1">
                                                    File Name
                                                </label>
                                                <input type="text" name="pdf_name" class="form-control">
                                            </div>
                                            <div class="form-group file_name" id="DOC" style="display: none">
                                                <label class="form-label mb-1">
                                                    File Name
                                                </label>
                                                <input type="text" name="doc_name" class="form-control">
                                            </div>
                                            <div class="form-group file_name" id="ZIP" style="display: none">
                                                <label class="form-label mb-1">
                                                    File Name
                                                </label>
                                                <input type="text" name="zip_name" class="form-control">
                                            </div>
                                            <div class="form-group file_name" id="RAR" style="display: none">
                                                <label class="form-label mb-1">
                                                    File Name
                                                </label>
                                                <input type="text" name="rar_name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="actual-btn" style="cursor: pointer" class="w-100 p-6 w-full text-center px-4 py-6 bg-white rounded-md border border-blue cursor-pointer hover:bg-purple-600 dark:bg-gray-700 hover:text-white text-gray-600 dark:text-gray-200 ease-linear transition-all duration-150">
                                                    <i class="mdi mdi-cloud-upload icon-size"></i>
                                                    <span class="mt-2 text-base text-lg leading-normal">Select a file</span>
                                                    <input type="file" name="file" id="actual-btn" class="hidden"><br>
                                                    <h2 class="text-lg" id="file-chosen">No file chosen</h2>
                                                </label>
                                            </div>
                                            <button type="submit" onclick="this.classList.toggle('button--loading')" id="show-1" style="display: none; float: right" class="btn button_load text-white btn-primary">
                                                <span class="button__text"><i class="mdi mdi-check"></i> Post</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                            @if($send_request)
                                @if($send_request->send_request == 1 && $send_request->approve_request == 1)
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{route('post.comment')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group input-group-lg input-group-flush input-group-merge">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <input type="hidden" name="team_id" value="{{$team->id}}">
                                                    <textarea name="comment_body" class="form-control form-control-flush" data-autosize rows="1" placeholder="Create posts and share files to this team"></textarea>
                                                    <div class="input-group-text">
                                                        <a class="text-reset me-3" style="cursor: pointer" id="attach" onclick="showFile()" data-bs-toggle="tooltip" title="Attach file">
                                                            <i class="fe fe-paperclip"></i>
                                                        </a>
                                                        <a class="text-reset me-3" style="cursor: pointer; display:none" id="remove" onclick="removeFile()" data-bs-toggle="tooltip" title="Remove file">
                                                            <i class="mdi mdi-close"></i>
                                                        </a>
                                                        <button type="submit" onclick="this.classList.toggle('button--loading')" id="remove-1" class="btn button_load text-white btn-primary">
                                                            <span class="button__text"><i class="mdi mdi-check"></i> Post</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="file-input" id="file_input" style="display: none">
                                                    <div class="form-group">
                                                        <label class="form-label mb-1">
                                                            Select File type
                                                        </label>
                                                        <select name="file_type" id="file_type" class="form-select" onchange="showDiv('PDF', 'DOC', 'ZIP', 'RAR', this)">
                                                            <option value="image">Image</option>
                                                            <option value="PDF" data_type="files">PDF</option>
                                                            <option value="DOC" data_type="files">DOC</option>
                                                            <option value="ZIP" data_type="files">ZIP</option>
                                                            <option value="RAR" data_type="files">RAR</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group file_name" id="PDF" style="display: none">
                                                        <label class="form-label mb-1">
                                                            File Name
                                                        </label>
                                                        <input type="text" name="pdf_name" class="form-control">
                                                    </div>
                                                    <div class="form-group file_name" id="DOC" style="display: none">
                                                        <label class="form-label mb-1">
                                                            File Name
                                                        </label>
                                                        <input type="text" name="doc_name" class="form-control">
                                                    </div>
                                                    <div class="form-group file_name" id="ZIP" style="display: none">
                                                        <label class="form-label mb-1">
                                                            File Name
                                                        </label>
                                                        <input type="text" name="zip_name" class="form-control">
                                                    </div>
                                                    <div class="form-group file_name" id="RAR" style="display: none">
                                                        <label class="form-label mb-1">
                                                            File Name
                                                        </label>
                                                        <input type="text" name="rar_name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="actual-btn" style="cursor: pointer" class="w-100 p-6 w-full text-center px-4 py-6 bg-white rounded-md border border-blue cursor-pointer hover:bg-purple-600 dark:bg-gray-700 hover:text-white text-gray-600 dark:text-gray-200 ease-linear transition-all duration-150">
                                                            <i class="mdi mdi-cloud-upload icon-size"></i>
                                                            <span class="mt-2 text-base text-lg leading-normal">Select a file</span>
                                                            <input type="file" name="file" id="actual-btn" class="hidden"><br>
                                                            <h2 class="text-lg" id="file-chosen">No file chosen</h2>
                                                        </label>
                                                    </div>
                                                    <button type="submit" onclick="this.classList.toggle('button--loading')" id="show-1" style="display: none; float: right" class="btn button_load text-white btn-primary">
                                                        <span class="button__text"><i class="mdi mdi-check"></i> Post</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                        @if(count($comments) > 0)
                            @foreach($comments as $comment)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="avatar avatar-sm">
                                                        <?php $user = App\Models\User::where('id', $comment->user_id)->first(); ?>
                                                        @if($user->photo)
                                                            <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                            @else
                                                            <div class="initials">
                                                                <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                            </div>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col ms-n2">
                                                    <h4 class="mb-1">
                                                        <a href="{{route('user.profile', $user->id)}}">
                                                            {{$user->name}}
                                                        </a>
                                                    </h4>
                                                   <p class="card-text small text-muted">
                                                       <span class="fe fe-clock"></span>
                                                       @if($comment->created_at < $comment->updated_at)
                                                            Edited {{\Carbon\Carbon::parse($comment->updated_at)->toFormattedDateString()}}
                                                            @else
                                                            Posted {{\Carbon\Carbon::parse($comment->created_at)->toFormattedDateString()}}
                                                        @endif
                                                    </p>
                                                </div>
                                                @if($comment->user_id == Auth::user()->id)
                                                    @if(empty($comment->article_id))
                                                        <div class="col-auto">
                                                            <div class="dropdown">
                                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a style="cursor: pointer" data-bs-toggle="modal" onclick='showEditPost("{{$comment->comment_body}}", "{{$comment->id}}")' class="dropdown-item">
                                                                        <i class="mdi mdi-pencil mr-2"></i> Edit
                                                                    </a>
                                                                    <form action="/admin/teams/comment/{{$comment->id}}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" name="submit" onclick="return deletePost();" class="dropdown-item">
                                                                            <i class="fe fe-trash mr-2"></i>Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mb-4">
                                            @if($comment->article_id)
                                                @php
                                                    $body = json_decode($comment->comment_body)
                                                @endphp
                                                <p>{!! $body[0] !!}</p>
                                                <p>{!! $body[1] !!}</p>
                                                <p><a href="{{$body[2]}}" class="text-color"><u>View full article <i class="fe fe-arrow-right"></i></u></a></p>
                                                @else
                                                {!! $comment->comment_body !!}
                                            @endif
                                        </p>
                                        <p class="mb-4 text-center">
                                            @if($send_request)
                                                @if($send_request->send_request == 1 && $send_request->approve_request == 1)
                                                    @if($comment->file_type == 'image')
                                                        <img src="{{$comment->file}}" class="img-fluid rounded">
                                                        @elseif($comment->file_type == 'PDF')
                                                        <div class="comment-body">
                                                            <a class="w-full" href="{{$comment->file}}">
                                                                <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->pdf_name}}">
                                                                {{$comment->pdf_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        @elseif($comment->file_type == 'DOC')
                                                        <div class="comment-body">
                                                            <a class="w-full" href="{{$comment->file}}">
                                                                <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->doc_name}}">
                                                                {{$comment->doc_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        @elseif($comment->file_type == 'ZIP')
                                                        <div class="comment-body">
                                                            <a class="w-full" href="{{$comment->file}}">
                                                                <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->zip_name}}">
                                                                {{$comment->zip_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        @elseif($comment->file_type == 'RAR')
                                                        <div class="comment-body">
                                                            <a class="w-full" href="{{$comment->file}}">
                                                                <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->rar_name}}">
                                                                {{$comment->rar_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @else
                                                    @if($comment->file_type == 'image')
                                                        <img src="{{$comment->file}}" class="img-fluid rounded">
                                                        @elseif($comment->file_type == 'PDF')
                                                        <div class="comment-body">
                                                            <a class="w-full cursor" onclick="info()">
                                                                <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->pdf_name}}">
                                                                {{$comment->pdf_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        @elseif($comment->file_type == 'DOC')
                                                        <div class="comment-body">
                                                            <a class="w-full cursor" onclick="info()">
                                                                <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->doc_name}}">
                                                                {{$comment->doc_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        @elseif($comment->file_type == 'ZIP')
                                                        <div class="comment-body">
                                                            <a class="w-full cursor" onclick="info()">
                                                                <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->zip_name}}">
                                                                {{$comment->zip_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        @elseif($comment->file_type == 'RAR')
                                                        <div class="comment-body">
                                                            <a class="w-full cursor" onclick="info()">
                                                                <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->rar_name}}">
                                                                {{$comment->rar_name}}
                                                                <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                    <i class="fe fe-download mx-2"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                                @else
                                                @if($comment->file_type == 'image')
                                                    <img src="{{$comment->file}}" class="img-fluid rounded">
                                                    @elseif($comment->file_type == 'PDF')
                                                    <div class="comment-body">
                                                        <a class="w-full cursor" onclick="info()">
                                                            <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->pdf_name}}">
                                                            {{$comment->pdf_name}}
                                                            <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                <i class="fe fe-download mx-2"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    @elseif($comment->file_type == 'DOC')
                                                    <div class="comment-body">
                                                        <a class="w-full cursor" onclick="info()">
                                                            <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->doc_name}}">
                                                            {{$comment->doc_name}}
                                                            <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                <i class="fe fe-download mx-2"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    @elseif($comment->file_type == 'ZIP')
                                                    <div class="comment-body">
                                                        <a class="w-full cursor" onclick="info()">
                                                            <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->zip_name}}">
                                                            {{$comment->zip_name}}
                                                            <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                <i class="fe fe-download mx-2"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    @elseif($comment->file_type == 'RAR')
                                                    <div class="comment-body">
                                                        <a class="w-full cursor" onclick="info()">
                                                            <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$comment->rar_name}}">
                                                            {{$comment->rar_name}}
                                                            <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                <i class="fe fe-download mx-2"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        </p>
                                        @foreach($comment->comment_replies as $comment_reply)
                                            <div class="comment mt-4 mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-sm">
                                                            <?php $user = App\Models\User::where('id', $comment_reply->user_id)->first(); ?>
                                                            @if($user->photo)
                                                                <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                @else
                                                                <div class="initials">
                                                                    <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                                </div>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="col ms-n2">
                                                        <div class="comment-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="comment-title">
                                                                        <a href="{{route('user.profile', $user->id)}}">
                                                                            {{$user->name}}
                                                                        </a>
                                                                    </h5>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <time class="comment-time">
                                                                        {{\Carbon\Carbon::parse($comment->created_at)->toFormattedDateString()}}
                                                                    </time>
                                                                </div>
                                                            </div>
                                                            <p class="comment-text">
                                                                {{$comment_reply->comment_reply_body}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($send_request)
                                            @if($send_request->send_request == 1 && $send_request->approve_request == 1)
                                                <hr>
                                                <form class="mt-1" action="{{route('reply.comment')}}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <div class="avatar avatar-sm">
                                                                {{-- <img src="{{Auth::user()->photo}}" alt="{{Auth::user()->name}}" class="avatar-img rounded-circle"> --}}
                                                                @if(Auth::user()->photo)
                                                                    <img src="{{Auth::user()->photo}}" class="avatar-img rounded-circle" alt="{{Auth::user()->name}}">
                                                                    @else
                                                                    <div class="initials">
                                                                        <span>{{Str::limit(Auth::user()->name, 1, '')}}{{Str::limit(Auth::user()->surname, 1, '')}}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col ms-n2">
                                                            <label class="visually-hidden">Leave a comment...</label>
                                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                            <textarea name="comment_reply_body" class="form-control form-control-flush" data-autosize rows="1" placeholder="Leave a comment"></textarea>
                                                        </div>
                                                        <div class="col-auto align-self-end">
                                                            <div class="text-muted mb-2">
                                                                <button type="submit" name="reply" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white btn-primary">
                                                                    <span class="button__text"><i class="mdi mdi-check"></i> Comment</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @else
                            <div class="card">
                                <div class="card-body">
                                    <div class="mt-3 mb-3">
                                        <div class="row align-items-center text-center">
                                            <h4 class="text-muted"><i class="mdi mdi-file-outline"></i> There are currently no posts</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-header-title">
                                    Recent Files
                                </h4>
                            </div>
                            <div class="card-body">
                                @if(Auth::user()->id == $team->user_id)
                                    <div class="list-group list-group-flush my-n3">
                                        @if(count($shared_files) > 0)
                                            @foreach($shared_files as $shared_file)
                                                @if($shared_file->file_type == 'PDF')
                                                    <div class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->pdf_name}}">
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1">
                                                                    <a href="{{$shared_file->file}}">{{$shared_file->pdf_name}}</a>
                                                                </h4>
                                                                <p class="card-text small text-muted">
                                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                </p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                        <i class="fe fe-download mx-2"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @elseif($shared_file->file_type == 'DOC')
                                                    <div class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->doc_name}}">
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1">
                                                                    <a href="{{$shared_file->file}}">{{$shared_file->doc_name}}</a>
                                                                </h4>
                                                                <p class="card-text small text-muted">
                                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                </p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                        <i class="fe fe-download mx-2"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @elseif($shared_file->file_type == 'ZIP')
                                                    <div class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->zip_name}}">
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1">
                                                                    <a href="{{$shared_file->file}}">{{$shared_file->zip_name}}</a>
                                                                </h4>
                                                                <p class="card-text small text-muted">
                                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                </p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                        <i class="fe fe-download mx-2"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @elseif($shared_file->file_type == 'RAR')
                                                    <div class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->rar_name}}">
                                                                </a>
                                                            </div>
                                                            <div class="col ms-n2">
                                                                <h4 class="mb-1">
                                                                    <a href="{{$shared_file->file}}">{{$shared_file->rar_name}}</a>
                                                                </h4>
                                                                <p class="card-text small text-muted">
                                                                    <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                </p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a href="{{$shared_file->file}}">
                                                                    <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                        <i class="fe fe-download mx-2"></i>
                                                                    </span>
                                                                </a>
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
                                    </div>
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
                                        <div class="list-group list-group-flush my-n3">
                                            @if(count($shared_files) > 0)
                                                @foreach($shared_files as $shared_file)
                                                    @if($shared_file->file_type == 'PDF')
                                                        <div class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <img src="{{asset('assets/images/pdf.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->pdf_name}}">
                                                                    </a>
                                                                </div>
                                                                <div class="col ms-n2">
                                                                    <h4 class="mb-1">
                                                                        <a href="{{$shared_file->file}}">{{$shared_file->pdf_name}}</a>
                                                                    </h4>
                                                                    <p class="card-text small text-muted">
                                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                    </p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                            <i class="fe fe-download mx-2"></i>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @elseif($shared_file->file_type == 'DOC')
                                                        <div class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <img src="{{asset('assets/images/doc.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->doc_name}}">
                                                                    </a>
                                                                </div>
                                                                <div class="col ms-n2">
                                                                    <h4 class="mb-1">
                                                                        <a href="{{$shared_file->file}}">{{$shared_file->doc_name}}</a>
                                                                    </h4>
                                                                    <p class="card-text small text-muted">
                                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                    </p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                            <i class="fe fe-download mx-2"></i>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @elseif($shared_file->file_type == 'ZIP')
                                                        <div class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <img src="{{asset('assets/images/zip.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->zip_name}}">
                                                                    </a>
                                                                </div>
                                                                <div class="col ms-n2">
                                                                    <h4 class="mb-1">
                                                                        <a href="{{$shared_file->file}}">{{$shared_file->zip_name}}</a>
                                                                    </h4>
                                                                    <p class="card-text small text-muted">
                                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                    </p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                            <i class="fe fe-download mx-2"></i>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @elseif($shared_file->file_type == 'RAR')
                                                        <div class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <img src="{{asset('assets/images/rar.png')}}" class="h-2 w-2 mr-2" alt="{{$shared_file->rar_name}}">
                                                                    </a>
                                                                </div>
                                                                <div class="col ms-n2">
                                                                    <h4 class="mb-1">
                                                                        <a href="{{$shared_file->file}}">{{$shared_file->rar_name}}</a>
                                                                    </h4>
                                                                    <p class="card-text small text-muted">
                                                                        <time datetime="2018-05-24">Shared {{\Carbon\Carbon::parse($shared_file->created_at)->toFormattedDateString()}}</time>
                                                                    </p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <a href="{{$shared_file->file}}">
                                                                        <span class="flex align items text-gray-600 dark:text-gray-300">
                                                                            <i class="fe fe-download mx-2"></i>
                                                                        </span>
                                                                    </a>
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
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-header-title">
                                    Members
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush my-n3">
                                    @if($some_approved_members)
                                        @foreach ($some_approved_members as $some_approved_member)
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-sm">
                                                            <?php $user = App\Models\User::where('id', $some_approved_member->user_id)->first(); ?>
                                                            @if($user->photo)
                                                                <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                @else
                                                                <div class="initials">
                                                                    <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                                </div>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="col ms-n2">
                                                        <h4 class="mb-1">
                                                            <a href="{{route('user.profile', $user->id)}}">{{$user->name}}</a>
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
                                                </div>
                                            </div>
                                        @endforeach
                                        @else
                                        <div class="text-center mt-4">
                                            <h3 class="text-muted"><i class="fe fe-users"></i> No members</h3>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="row">
                    <div class="col-12 col-xl-8">
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
                                        @if(Auth::user()->id == $team->user_id)
                                            <div class="col-auto">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add_member" id="kt_toolbar_primary_button" class="text-color">
                                                   <i class="fe fe-plus"></i> Add members
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        @if(Auth::user()->id == $team->user_id)
                                            @if($approved_members)
                                                <ul id="table_data" class="list-group table_data list-group-lg list-group-flush list my-n4">
                                                    @foreach($approved_members as $approved_member)
                                                        <li class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <?php $user = App\Models\User::where('id', $approved_member->user_id)->first(); ?>
                                                                    <a href="{{route('user.profile', $user->id)}}" class="avatar avatar-lg">
                                                                        @if($user->photo)
                                                                            <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                            @else
                                                                            <div class="initials">
                                                                                <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                                            </div>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="col ms-n2">
                                                                    <h4 class="mb-1 item-name">
                                                                        <a href="{{route('user.profile', $user->id)}}">{{$user->name}}</a>
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
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @else
                                                <div class="text-center mt-8 mb-8">
                                                    <h3 class="text-muted"><i class="fe fe-users"></i> There are currently no members</h3>
                                                    <div class="col-auto mt-2">
                                                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_member" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                                            <i class="fe fe-plus"></i> Add members
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            @else
                                            @if($approved_members)
                                                <ul id="table_data" class="list-group table_data list-group-lg list-group-flush list my-n4">
                                                    @foreach($approved_members as $approved_member)
                                                        <li class="list-group-item">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <span class="avatar avatar-sm">
                                                                        <?php $user = App\Models\User::where('id', $approved_member->user_id)->first(); ?>
                                                                        @if($user->photo)
                                                                            <img src="{{$user->photo}}" class="avatar-img rounded-circle" alt="{{$user->name}}">
                                                                            @else
                                                                            <div class="initials">
                                                                                <span>{{Str::limit($user->name, 1, '')}}{{Str::limit($user->surname, 1, '')}}</span>
                                                                            </div>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="col ms-n2">
                                                                    <h4 class="mb-1 name">
                                                                        <a href="{{route('user.profile', $user->id)}}">{{$user->name}}</a>
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
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @else
                                                <div class="text-center mt-8 mb-8">
                                                    <h3 class="text-muted"><i class="fe fe-users"></i> There are currently no members</h3>
                                                    <div class="col-auto mt-2">
                                                        <a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_member" id="kt_toolbar_primary_button" class="btn btn-primary lift">
                                                            <i class="fe fe-plus"></i> Add members
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="row g-0">
                                        <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                                            <li class="page-item">
                                                <a class="page-link" href="#">
                                                <i class="fe fe-arrow-left me-1"></i> Prev
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>
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
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-group list-group-flush my-n3">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="mb-0">
                                                    Member Count
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    {{$approved_member_count}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="mb-0">
                                                    Created
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    {{\Carbon\Carbon::parse($team->created_at)->toFormattedDateString()}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="mb-0">
                                                    Team Owner
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    {{$team->team_owner}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                <div data-list='{"valueNames": ["name"]}'>
                    <div class="" data-list='{"valueNames": ["name"], "listClass": "listAlias"}'>
                        <div class="row mb-4">
                            <div class="col">
                                <form>
                                    <div class="input-group input-group-lg input-group-merge input-group-reverse">
                                        <input class="form-control list-search" type="text" placeholder="Search for resources or files" style="height: 50px">
                                        <div class="input-group-text">
                                            <span class="fe fe-search"></span>
                                        </div>
                                    </div>
                                </form>
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
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card">
                            <div class="card-body p-5">
                                <form class="tab-content pb-4" id="wizardSteps" action="{{route('settings.team', $team->id)}}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('patch') }}
                                    <div class="form-group">
                                        <label class="form-label">
                                            Team name
                                        </label>
                                        <input type="hidden" name="user_id" value="{{$team->user_id}}">
                                        <input type="hidden" name="team_owner" id="team_owner"value="{{$team->team_owner}}">
                                        <input type="text" name="name" class="form-control" value="{{$team->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Team description
                                        </label>
                                        <small class="form-text text-muted">
                                            This is what others will see about your team
                                        </small>
                                        <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter description">{{$team->description}}</textarea>
                                    </div>
                                    <hr class="mt-4 mb-5">
                                    <div class="form-group">
                                        <label class="form-label mb-1">
                                            Team Cover Image
                                        </label>
                                        <small class="form-text text-muted">
                                            Please use an image no larger than 1200px * 600px.
                                        </small>
                                        <div class="form-group">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview" style="background-image: url({{$team->photo}})">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                        <span class="button__text"><i class="mdi mdi-check"></i> Save team</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-group list-group-flush my-n3">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="mb-0">
                                                    Delete Team
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <form action="/admin/teams/{{$team->id}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" name="submit" onclick="return deleteFunction();" class="btn text-white btn-danger">
                                                        <i class="fe fe-trash mr-2"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_member" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Add a member</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('send.invite', $team->id)}}" method="POST">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">Send invite links to people to join your team</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        Email
                                    </label>
                                    <input type="hidden" name="team_id" class="form-control" value="{{$team->id}}">
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-message"></i> Send invite</span>
                                </button>
                            </form>
                            <div class="row justify-content-center">
                                <div class="text-center">
                                    <p class="text-muted">OR</p>
                                </div>
                            </div>
                            <a class="btn mb-5 button_load btn-custom w-100">
                                <i class="fe fe-paperclip mr-2"></i><input type="button" class="custom-button" id="hide-copy" value="Copy invite Link" onclick="Copy();" style="margin-top: -8px;">
                                <span class="text-color" id="show-status" style="display: none;">Link copied!</span>
                            </a>
                            <div class="row justify-content-center">
                                <span><input type="text" style="position: absolute; opacity: 0;" id="paste-box"></span>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="join_team" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Join this Team</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form class="tab-content pb-4" id="wizardSteps" action="{{route('joined.team', $team->id)}}" method="POST">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="text-center">
                                        <p class="mb-5 text-muted">You were invited to join this team</p>
                                    </div>
                                </div>
                                <input type="hidden" name="send_request" value="1">
                                <input type="hidden" name="approve_request" value="1">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="team_id" value="{{$team->id}}">
                                <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                    <span class="button__text"><i class="mdi mdi-check"></i> Join Team</span>
                                </button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fs-1 fw-boldest">Edit Post</div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mt-4">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <form action="{{route('update.comment')}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="input-group input-group-lg input-group-flush input-group-merge">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="team_id" value="{{$team->id}}">
                                    <input type="hidden" name="comment_id" id="comment-id">
                                    <textarea name="comment_body" id="comment-input" class="form-control form-control-flush" data-autosize rows="1" placeholder="Create posts and share files to this team"></textarea>
                                    <div class="input-group-text">
                                        <button type="submit" onclick="this.classList.toggle('button--loading')" id="remove-1" class="btn button_load text-white btn-primary">
                                            <span class="button__text"><i class="mdi mdi-check"></i> Repost</span>
                                        </button>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

        $(document ).ready(function() {
            @php
            $routeName = request()->route()->named("join.team");
            $join_team = App\Models\UserTeam::where('user_id', Auth::user()->id)->where('send_request', 1)->where('approve_request', 1)->first();
            @endphp
            @if(!$join_team)
                @if(Session::has('join') && Session::get('join') == 1 && $routeName == 'join.team')
                    $('#join_team').modal('show');
                    {{Session::forget('join')}};
                @endif
                @else
                @if($join_team->team_id !== $team->id)
                    @if(Session::has('join') && Session::get('join') == 1 && $routeName == 'join.team')
                        $('#join_team').modal('show');
                        {{Session::forget('join')}};
                    @endif
                @endif
            @endif
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
        function deleteFunction() {
            if(!confirm("Are you sure you want to delete this Team?"))
            event.preventDefault();
        }
        function deletePost() {
            if(!confirm("Are you sure you want to delete this Post?"))
            event.preventDefault();
        }
        const actualBtn = document.getElementById('actual-btn');

        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function(){
            fileChosen.textContent = this.files[0].name
        })
        function showFile() {
            document.getElementById('file_input').style.display = 'block';
            document.getElementById('attach').style.display = 'none';
            document.getElementById('remove').style.display = 'block';
            document.getElementById('remove-1').style.display = 'none';
            document.getElementById('show-1').style.display = 'block';
        }
        function removeFile() {
            document.getElementById('file_input').style.display = 'none';
            document.getElementById('attach').style.display = 'block';
            document.getElementById('remove').style.display = 'none';
            document.getElementById('remove').style.display = 'none';
            document.getElementById('remove-1').style.display = 'block';
            document.getElementById('show-1').style.display = 'none';
        }

        function showDiv(PDF, DOC, ZIP, RAR, element)
        {
            document.getElementById(PDF).style.display = element.value == 'PDF' ? 'block' : 'none';
            document.getElementById(DOC).style.display = element.value == 'DOC' ? 'block' : 'none';
            document.getElementById(ZIP).style.display = element.value == 'ZIP' ? 'block' : 'none';
            document.getElementById(RAR).style.display = element.value == 'RAR' ? 'block' : 'none';
        }

        function info() {
            swal({
                title: "Sorry!",
                text: "You need to join this team to get access to files",
                icon: "error",
            });
        }

        function showEditPost(comment, id){
            document.getElementById("comment-input").value = comment;
            document.getElementById("comment-id").value = id;
            $('#editPost').modal('show')
        }

        function Copy()
        {
            var Url = document.getElementById("paste-box");
            // Url.value = window.location.href;
            Url.value = "{{route('join.team', $team->id)}}";
            Url.focus();
            Url.select();
            document.execCommand("Copy");

            document.getElementById('hide-copy').style.display = 'none';
            document.getElementById('show-status').style.display = 'inline-block';
        }

    </script>
@endsection
