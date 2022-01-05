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
                        <h1 class="header-title">
                            {{$team->name}}
                        </h1>
                    </div>
                    <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3">
                        @if(Auth::user()->id !== $team->user_id)
                            {{-- <div class="me-2 text-color"><span class="text-green-0"><i class="fas fa-check-circle text-success"></i> Joined</span></div>
                            @else --}}
                            @if(empty($send_request))
                                <form action="{{route('send.request')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="send_request" value="1">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="team_id" value="{{$team->id}}">
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
                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="btn text-white btn-primary d-block d-md-inline-block">
                                        <span class="button__text"><i class="mdi mdi-plus"></i> Request Access</span>
                                    </button>
                                </form>
                                @elseif($send_request->send_request == 1)
                                <a style="cursor: not-allowed; text-align: center" class="px-5 bg-padding py-3 d-block d-md-inline-block font-medium leading-5 text-gray-400 transition-colors duration-150 bg-gray-100 hover:bg-gray-100 dark:bg-gray-700 border border-transparent rounded-lg">Request Sent</a>
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
                                <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="false">
                                    Shared Resources
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab" aria-controls="members" aria-selected="false">
                                    Members
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
                                    <form>
                                        <div class="input-group input-group-lg input-group-flush input-group-merge">
                                            <input type="text" class="form-control" placeholder="Post to this team">
                                            <div class="input-group-text">
                                                <span class="fe fe-camera"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                    <a href="#!" class="avatar">
                                        <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                    </a>
                                    </div>
                                    <div class="col ms-n2">
                                    <h4 class="mb-1">
                                        Dianna Smiley
                                    </h4>
                                    <p class="card-text small text-muted">
                                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">4hr ago</time>
                                    </p>
                                    </div>
                                    <div class="col-auto">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item">
                                            Action
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            Another action
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            Something else here
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <p class="mb-3">
                                    I've been working on shipping the latest version of Launchday. The story I'm trying to focus on is something like "You're launching soon and need to be 100% focused on your product. Don't lose precious days designing, coding, and testing a product site. Instead, build one in minutes."
                                </p>
                                <p class="mb-4">
                                What do you y'all think? Would love some feedback from <a href="#!" class="badge bg-primary-soft">@Ab</a> or <a href="#!" class="badge bg-primary-soft">@Adolfo</a>?
                                </p>

                                <!-- Image -->
                                <p class="text-center mb-3">
                                <img src="assets/img/posts/post-1.jpg" alt="..." class="img-fluid rounded">
                                </p>

                                <!-- Buttons -->
                                <div class="mb-3">
                                <div class="row">
                                    <div class="col">

                                    <!-- Reaction -->
                                    <a href="#!" class="btn btn-sm btn-white">
                                        😬 1
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-white">
                                        👍 2
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-white">
                                        Add Reaction
                                    </a>

                                    </div>
                                    <div class="col-auto me-n3">

                                    <!-- Avatar group -->
                                    <div class="avatar-group d-none d-sm-flex">
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Ab Hadley">
                                        <img src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Adolfo Hess">
                                        <img src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Daniela Dewitt">
                                        <img src="assets/img/avatars/profiles/avatar-4.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Miyah Myles">
                                        <img src="assets/img/avatars/profiles/avatar-5.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                    </div>

                                    </div>
                                    <div class="col-auto">

                                    <!-- Button -->
                                    <a href="#!" class="btn btn-sm btn-white">
                                        Share
                                    </a>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <!-- Divider -->
                                <hr>

                                <!-- Comments -->

                                <div class="comment mb-3">
                                <div class="row">
                                    <div class="col-auto">

                                    <!-- Avatar -->
                                    <a class="avatar" href="profile-posts.html">
                                        <img src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                                    </a>

                                    </div>
                                    <div class="col ms-n2">

                                    <!-- Body -->
                                    <div class="comment-body">

                                        <div class="row">
                                        <div class="col">

                                            <!-- Title -->
                                            <h5 class="comment-title">
                                            Ab Hadley
                                            </h5>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Time -->
                                            <time class="comment-time">
                                            11:12
                                            </time>

                                        </div>
                                        </div> <!-- / .row -->

                                        <!-- Text -->
                                        <p class="comment-text">
                                        Looking good Dianna! I like the image grid on the left, but it feels like a lot to process and doesn't really <em>show</em> me what the product does? I think using a short looping video or something similar demo'ing the product might be better?
                                        </p>

                                    </div>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <div class="comment mb-3">
                                <div class="row">
                                    <div class="col-auto">

                                    <!-- Avatar -->
                                    <a class="avatar" href="profile-posts.html">
                                        <img src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
                                    </a>

                                    </div>
                                    <div class="col ms-n2">

                                    <!-- Body -->
                                    <div class="comment-body">

                                        <div class="row">
                                        <div class="col">

                                            <!-- Title -->
                                            <h5 class="comment-title">
                                            Adolfo Hess
                                            </h5>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Time -->
                                            <time class="comment-time">
                                            11:12
                                            </time>

                                        </div>
                                        </div> <!-- / .row -->

                                        <!-- Text -->
                                        <p class="comment-text">
                                        Any chance you're going to link the grid up to a public gallery of sites built with Launchday?
                                        </p>

                                    </div>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <!-- Divider -->
                                <hr>

                                <!-- Form -->
                                <div class="row">
                                <div class="col-auto">

                                    <!-- Avatar -->
                                    <div class="avatar avatar-sm">
                                    <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>

                                </div>
                                <div class="col ms-n2">

                                    <!-- Form -->
                                    <form class="mt-1">

                                    <!-- Label -->
                                    <label class="visually-hidden">Leave a comment...</label>

                                    <!-- Textarea -->
                                    <textarea class="form-control form-control-flush" data-autosize rows="1" placeholder="Leave a comment"></textarea>

                                    </form>

                                </div>
                                <div class="col-auto align-self-end">

                                    <!-- Icons -->
                                    <div class="text-muted mb-2">
                                    <a class="text-reset me-3" href="#" data-bs-toggle="tooltip" title="Add photo">
                                        <i class="fe fe-camera"></i>
                                    </a>
                                    <a class="text-reset me-3" href="#" data-bs-toggle="tooltip" title="Attach file">
                                        <i class="fe fe-paperclip"></i>
                                    </a>
                                    <a class="text-reset" href="#" data-bs-toggle="tooltip" title="Record audio">
                                        <i class="fe fe-mic"></i>
                                    </a>
                                    </div>

                                </div>
                                </div> <!-- / .row -->

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <!-- Header -->
                                <div class="mb-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">

                                    <!-- Avatar -->
                                    <a href="#!" class="avatar">
                                        <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                    </a>

                                    </div>
                                    <div class="col ms-n2">

                                    <!-- Title -->
                                    <h4 class="mb-1">
                                        Dianna Smiley
                                    </h4>

                                    <!-- Time -->
                                    <p class="card-text small text-muted">
                                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">4hr ago</time>
                                    </p>

                                    </div>
                                    <div class="col-auto">

                                    <!-- Dropdown -->
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" class="dropdown-item">
                                            Action
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            Another action
                                        </a>
                                        <a href="#!" class="dropdown-item">
                                            Something else here
                                        </a>
                                        </div>
                                    </div>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <!-- Text -->
                                <p class="mb-3">
                                I've spent a lot of time thinking about our design process and trying to figure out a better order for us to tackle things. Right now it feels like we're everywhere with tools and process, so here's my suggestion:
                                </p>

                                <!-- List -->
                                <ol class="mb-3">
                                <li><strong>Define the goals</strong>: Create a template for expressing what the purpose of a project is and why we're investing time and money in tackling it.</li>
                                <li><strong>Sketch a solution</strong>: Use tried and true paper and pencil to express ideas and share them with others at the company before going too deep on design.</li>
                                <li><strong>User test with Figma</strong>: Use the page linking in Figma to get a rough clickable prototype and test this with real users.</li>
                                <li><strong>Prototype with code</strong>: Built and HTML/CSS with dummied data to test how things feel before building a true front-end.</li>
                                </ol>

                                <!-- Text -->
                                <p class="mb-4">
                                Wanna help me out <a href="#!" class="badge bg-primary-soft">@Ryu Duke</a> or <a href="#!" class="badge bg-primary-soft">@Miyah Miles</a>?
                                </p>

                                <!-- Buttons -->
                                <div class="mb-3">
                                <div class="row">
                                    <div class="col">

                                    <!-- Reaction -->
                                    <a href="#!" class="btn btn-sm btn-white">
                                        😍 4
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-white">
                                        👍 3
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-white">
                                        Add Reaction
                                    </a>

                                    </div>
                                    <div class="col-auto me-n3">

                                    <!-- Avatar group -->
                                    <div class="avatar-group d-none d-sm-flex">
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Daniela Dewitt">
                                        <img src="assets/img/avatars/profiles/avatar-4.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Ab Hadley">
                                        <img src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                        <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Adolfo Hess">
                                        <img src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
                                        </a>
                                    </div>

                                    </div>
                                    <div class="col-auto">

                                    <!-- Button -->
                                    <a href="#!" class="btn btn-sm btn-white">
                                        Share
                                    </a>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <!-- Divider -->
                                <hr>

                                <!-- Comments -->
                                <div class="comment mb-3">
                                <div class="row">
                                    <div class="col-auto">

                                    <!-- Avatar -->
                                    <a class="avatar" href="profile-posts.html">
                                        <img src="assets/img/avatars/profiles/avatar-5.jpg" alt="..." class="avatar-img rounded-circle">
                                    </a>

                                    </div>
                                    <div class="col ms-n2">

                                    <!-- Body -->
                                    <div class="comment-body">

                                        <div class="row">
                                        <div class="col">

                                            <!-- Title -->
                                            <h5 class="comment-title">
                                            Miyah Miles
                                            </h5>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Time -->
                                            <time class="comment-time">
                                            11:12
                                            </time>

                                        </div>
                                        </div> <!-- / .row -->

                                        <!-- Text -->
                                        <p class="comment-text">
                                        I love this Dianna! Let's add to our wiki tomorrow!
                                        </p>

                                    </div>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <div class="comment mb-3">
                                <div class="row">
                                    <div class="col-auto">

                                    <!-- Avatar -->
                                    <a class="avatar" href="profile-posts.html">
                                        <img src="assets/img/avatars/profiles/avatar-6.jpg" alt="..." class="avatar-img rounded-circle">
                                    </a>

                                    </div>
                                    <div class="col ms-n2">

                                    <!-- Body -->
                                    <div class="comment-body">

                                        <div class="row">
                                        <div class="col">

                                            <!-- Title -->
                                            <h5 class="comment-title">
                                            Ryu Duke
                                            </h5>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Time -->
                                            <time class="comment-time">
                                            11:12
                                            </time>

                                        </div>
                                        </div> <!-- / .row -->

                                        <!-- Text -->
                                        <p class="comment-text">
                                        I'm onboard for sure. Sign me up to prototype anytime.
                                        </p>

                                    </div>

                                    </div>
                                </div> <!-- / .row -->
                                </div>

                                <!-- Divider -->
                                <hr>

                                <!-- Form -->
                                <div class="row">
                                <div class="col-auto">

                                    <!-- Avatar -->
                                    <div class="avatar avatar-sm">
                                    <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>

                                </div>
                                <div class="col ms-n2">

                                    <!-- Form -->
                                    <form class="mt-1">

                                    <!-- Label -->
                                    <label class="visually-hidden">Leave a comment...</label>

                                    <!-- Textarea -->
                                    <textarea class="form-control form-control-flush" data-autosize rows="1" placeholder="Leave a comment"></textarea>

                                    </form>

                                </div>
                                <div class="col-auto align-self-end">

                                    <!-- Icons -->
                                    <div class="text-muted mb-2">
                                    <a class="text-reset me-3" href="#" data-bs-toggle="tooltip" title="Add photo">
                                        <i class="fe fe-camera"></i>
                                    </a>
                                    <a class="text-reset me-3" href="#" data-bs-toggle="tooltip" title="Attach file">
                                        <i class="fe fe-paperclip"></i>
                                    </a>
                                    <a class="text-reset" href="#" data-bs-toggle="tooltip" title="Record audio">
                                        <i class="fe fe-mic"></i>
                                    </a>
                                    </div>

                                </div>
                                </div> <!-- / .row -->

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-header-title">
                                    Recent Files
                                </h4>
                                <a href="project-overview.html" class="small">View all</a>
                            </div>
                            <div class="card-body">
                                @if(Auth::user()->id !== $team->user_id)
                                    <div class="text-center m-6">
                                        <h3 class="text-muted"><i class="i.mdi.mdi-warning"></i> You need to join this team to get access</h3>
                                        <div class="col-auto mt-2">
                                            @if(empty($send_request))
                                                <form action="{{route('send.request')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="send_request" value="1">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <input type="hidden" name="team_id" value="{{$team->id}}">
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
                                                    <button type="submit" name="submit" onclick="this.classList.toggle('button--loading')" class="btn text-white btn-primary d-block d-md-inline-block">
                                                        <span class="button__text"><i class="mdi mdi-plus"></i> Request Access</span>
                                                    </button>
                                                </form>
                                                @elseif($send_request->send_request == 1)
                                                <a style="cursor: not-allowed; text-align: center" class="px-5 bg-padding py-3 d-block d-md-inline-block font-medium leading-5 text-gray-400 transition-colors duration-150 bg-gray-100 hover:bg-gray-100 dark:bg-gray-700 border border-transparent rounded-lg">Request Sent</a>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <div class="list-group list-group-flush my-n3">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="project-overview.html" class="avatar avatar-4by3">
                                                <img src="assets/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
                                                </a>

                                            </div>
                                            <div class="col ms-n2">
                                                <h4 class="mb-1">
                                                <a href="project-overview.html">Homepage Redesign</a>
                                                </h4>
                                                <p class="card-text small text-muted">
                                                <time datetime="2018-05-24">Updated 4hr ago</time>
                                                </p>

                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#!" class="dropdown-item">
                                                    Action
                                                    </a>
                                                    <a href="#!" class="dropdown-item">
                                                    Another action
                                                    </a>
                                                    <a href="#!" class="dropdown-item">
                                                    Something else here
                                                    </a>
                                                </div>
                                                </div>

                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-header-title">
                                    Members
                                </h4>
                                <a href="profile-posts.html" class="small">View all</a>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush my-n3">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a href="profile-posts.html" class="avatar">
                                            <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                            </a>

                                        </div>
                                        <div class="col ms-n2">
                                            <h4 class="mb-1">
                                            <a href="profile-posts.html">Dianna Smiley</a>
                                            </h4>
                                            <p class="card-text small">
                                            <span class="text-success">●</span> Online
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="#!" class="dropdown-item">
                                                Action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Another action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Something else here
                                                </a>
                                            </div>
                                            </div>

                                        </div>
                                        </div> <!-- / .row -->
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                        <div class="col-auto">

                                            <!-- Avatar -->
                                            <a href="profile-posts.html" class="avatar">
                                            <img src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                                            </a>

                                        </div>
                                        <div class="col ms-n2">

                                            <!-- Title -->
                                            <h4 class="mb-1">
                                            <a href="profile-posts.html">Ab Hadley</a>
                                            </h4>

                                            <!-- Time -->
                                            <p class="card-text small">
                                            <span class="text-success">●</span> Online
                                            </p>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="#!" class="dropdown-item">
                                                Action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Another action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Something else here
                                                </a>
                                            </div>
                                            </div>

                                        </div>
                                        </div> <!-- / .row -->
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                        <div class="col-auto">

                                            <!-- Avatar -->
                                            <a href="profile-posts.html" class="avatar">
                                            <img src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
                                            </a>

                                        </div>
                                        <div class="col ms-n2">

                                            <!-- Title -->
                                            <h4 class="mb-1">
                                            <a href="profile-posts.html">Adolfo Hess</a>
                                            </h4>

                                            <!-- Time -->
                                            <p class="card-text small">
                                            <span class="text-danger">●</span> Offline
                                            </p>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="#!" class="dropdown-item">
                                                Action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Another action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Something else here
                                                </a>
                                            </div>
                                            </div>

                                        </div>
                                        </div> <!-- / .row -->
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                        <div class="col-auto">

                                            <!-- Avatar -->
                                            <a href="profile-posts.html" class="avatar">
                                            <img src="assets/img/avatars/profiles/avatar-4.jpg" alt="..." class="avatar-img rounded-circle">
                                            </a>

                                        </div>
                                        <div class="col ms-n2">

                                            <!-- Title -->
                                            <h4 class="mb-1">
                                            <a href="profile-posts.html">Daniela Dewitt</a>
                                            </h4>

                                            <!-- Time -->
                                            <p class="card-text small">
                                            <span class="text-warning">●</span> Busy
                                            </p>

                                        </div>
                                        <div class="col-auto">

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="#!" class="dropdown-item">
                                                Action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Another action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                Something else here
                                                </a>
                                            </div>
                                            </div>

                                        </div>
                                        </div> <!-- / .row -->
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">

                                            <!-- Avatar -->
                                            <a href="project-overview.html" class="avatar avatar-lg avatar-4by3">
                                                <img src="assets/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
                                            </a>

                                            </div>
                                            <div class="col ms-n2">

                                            <!-- Title -->
                                            <h4 class="mb-1 name">
                                                <a href="project-overview.html">Homepage Redesign</a>
                                            </h4>

                                            <!-- Text -->
                                            <p class="card-text small text-muted mb-1">
                                                <time datetime="2018-06-21">Updated 2hr ago</time>
                                            </p>

                                            <!-- Progress -->
                                            <div class="row align-items-center g-0">
                                                <div class="col-auto">

                                                <!-- Value -->
                                                <div class="small me-2">29%</div>

                                                </div>
                                                <div class="col">

                                                <!-- Progress -->
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar" role="progressbar" style="width: 29%" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                                </div>
                                            </div> <!-- / .row -->

                                            </div>
                                            <div class="col-auto">

                                            <!-- Avatar group -->
                                            <div class="avatar-group d-none d-md-inline-flex">
                                                <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Ab Hadley">
                                                <img src="assets/img/avatars/profiles/avatar-2.jpg" class="avatar-img rounded-circle" alt="...">
                                                </a>
                                                <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Adolfo Hess">
                                                <img src="assets/img/avatars/profiles/avatar-3.jpg" class="avatar-img rounded-circle" alt="...">
                                                </a>
                                                <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Daniela Dewitt">
                                                <img src="assets/img/avatars/profiles/avatar-4.jpg" class="avatar-img rounded-circle" alt="...">
                                                </a>
                                                <a href="profile-posts.html" class="avatar avatar-xs" data-bs-toggle="tooltip" title="Miyah Myles">
                                                <img src="assets/img/avatars/profiles/avatar-5.jpg" class="avatar-img rounded-circle" alt="...">
                                                </a>
                                            </div>

                                            </div>
                                            <div class="col-auto">

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                <a href="#!" class="dropdown-item">
                                                    Action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                    Another action
                                                </a>
                                                <a href="#!" class="dropdown-item">
                                                    Something else here
                                                </a>
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
            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card mb-3" data-list='{"valueNames": ["item-name"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <form>
                                            <div class="input-group input-group-flush input-group-merge input-group-reverse">
                                                <input class="form-control list-search" type="search" placeholder="Search">
                                                <span class="input-group-text">
                                                    <i class="fe fe-search"></i>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($approved_members)
                                    @foreach($approved_members as $approved_member)
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="profile-posts.html" class="avatar avatar-lg">
                                                    <img src="{{$approved_member->user->photo}}" alt="..." class="avatar-img rounded-circle">
                                                </a>
                                            </div>
                                            <div class="col ms-n2">
                                                <h4 class="mb-1 item-name">
                                                    <a href="profile-posts.html">{{$approved_member->user->name}}</a>
                                                </h4>
                                                <p class="card-text small">
                                                    <span class="text-success">●</span> Online
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#!" class="btn btn-sm btn-primary d-none d-md-inline-block">
                                                    <i class="mdi mdi-close"></i> Remove
                                                </a>
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
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_member" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen p-9">
            <div class="modal-content rounded">
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
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
