<style>
    .text-2xl {
        font-size: 35px;
    }
    .notify {
        position: absolute;
        margin: -15px 0 0 10px;
        background: #d5e5fa;
        border-radius: 100%;
        padding: 5px 10px;
        color: #2c7be5 !important;
        font-size: 10px;
    }

    .button_load {
        position: relative;
    }

    .button__text {
        transition: all 0.2s;
    }

    .button--loading1 {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, 0.9) !important;
        z-index: 999;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        transition: all .5s ease;
    }
    .button--loading1:hover {
        background: rgba(255, 255, 255, 0.9) !important;
    }

    .button--loading1 .button__text {
        visibility: hidden;
        opacity: 0;
    }

    .button--loading1::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 3px solid transparent;
        border-top-color: #EC6959;
        border-radius: 50%;
        background: transparent !important;
        animation: button-loading-spinner 1s ease infinite;
    }
    .button--loading1 .btn-primary::after {
        background: rgba(255, 255, 255, 0.9) !important;
    }
    .button--loading1 .btn-primary {
        background: rgba(255, 255, 255, 0.9) !important;
    }

    @keyframes button-loading-spinner {
        from {
            transform: rotate(0turn);
        }

        to {
            transform: rotate(1turn);
        }
    }
</style>
<nav class="navbar navbar-expand-md navbar-light d-none d-md-flex" id="topbar">
    <div class="container-fluid">
        <form action="{{route('search')}}" method="GET" class="me-4 d-none d-md-flex w-100" style="background: #f9fbfd; border-radius: 4px;">
            @if(Auth::user()->role->name == 'Admin')
                <div class="input-group-flush input-group-merge input-group-reverse w-100">
                    <button id="search-btn" class="btn button_load text-white btn-sm btn-primary p-2 px-3" onclick="this.classList.toggle('button--loading1')">
                        <span class="button__text">Search</span>
                    </button>
                    <input type="text" name="search" id="search" class="form-control dropdown-toggle list-search" data-bs-toggle="dropdown" placeholder="Search Legalpedia" aria-label="Search" />
                    <div class="input-group-text ml-4">
                        <i class="fe fe-search"></i>
                    </div>
                </div>
                @elseif(Auth::user()->subscribedUser())
                <div class="input-group-flush input-group-merge input-group-reverse w-100">
                    <button id="search-btn" class="btn button_load text-white btn-sm btn-primary p-2 px-3" onclick="this.classList.toggle('button--loading1')">
                        <span class="button__text">Search</span>
                    </button>
                    <input type="text" name="search" id="search" class="form-control dropdown-toggle list-search" data-bs-toggle="dropdown" placeholder="Search Legalpedia" aria-label="Search" />
                    <div class="input-group-text ml-4">
                        <i class="fe fe-search"></i>
                    </div>
                </div>
            @endif
        </form>
        <div class="navbar-user">
            @if(!Auth::user()->package_id && Auth::user()->expiry_date < now())
                <div class="dropdown me-4 d-none d-md-flex">
                    <a href="#" class="navbar-user-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon text-warning text-2xl">
                            <i class="mdi mdi-crown-circle"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                        <div class="card-header">
                            <h5 class="card-header-title">
                                <i class="mdi mdi-crown text-warning"></i> Subscribe to Legalpedia packages
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush list-group-activity">
                                <div class="small">
                                    <p>
                                        <strong>Get access to all Legalpedia resources!</strong> Subcribe to a plan to get started
                                    </p>
                                    <a class="mt-2" href="{{url('admin/pricing')}}">
                                        <span class="btn w-100 button_load text-white btn-sm btn-warning p-2" onclick="this.classList.toggle('button--loading')">
                                            <span class="button__text"><i class="mdi mdi-crown"></i> Subscribe</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="dropdown me-4 d-none d-md-flex">
                    <a href="#" class="navbar-user-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon text-color text-2xl">
                            <i class="mdi mdi-crown-circle"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                        <div class="card-header">
                            <h5 class="card-header-title">
                                @php
                                    $package = App\Models\Package::where('id', Auth::user()->package_id)->first();
                                @endphp
                                <i class="mdi mdi-crown text-color"></i> Active Package: {{$package->name}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush list-group-activity">
                                <div class="small">
                                    <p>
                                        <strong>Your Legalpedia package is currently active</strong> and will expire on {{\Carbon\Carbon::parse(Auth::user()->expiry_date)->toFormattedDateString()}}
                                    </p>
                                    <a class="mt-2" href="{{url('admin/pricing')}}">
                                        <span class="btn w-100 button_load text-color btn-sm btn-custom p-2" onclick="this.classList.toggle('button--loading')">
                                            <span class="button__text"><i class="mdi mdi-crown"></i> Renew Package</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="dropdown me-4 d-none d-md-flex">
                @php
                    $messages = App\Models\Message::where('type', 'in-app')->orderBy('created_at', 'DESC')->orderBy('created_at', 'DESC')->limit(3)->get();
                    $message_count = $messages->count();
                @endphp
                <a href="#" class="navbar-user-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon active">
                        <small class="notify">{{$message_count}}</small>
                        <i class="fe fe-bell"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                    <div class="card-header">
                        <h5 class="card-header-title">
                            Notifications
                        </h5>
                        {{-- <a href="#!" class="small">
                            View all
                        </a> --}}
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush list-group-activity my-n3">
                            @if(count($messages) > 0)
                                @foreach ($messages as $message)
                                    <a class="list-group-item text-reset" href="#!">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                                                        <i class="fe fe-bell"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col ms-n2">
                                                <div class="small">
                                                    <strong>{{$message->subject}}</strong>
                                                    {!! $message->body !!}
                                                </div>
                                                {{-- <small class="text-muted">
                                                {{$message->created_at->diffForHumans()}}
                                                </small> --}}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                @else
                                <div class="text-center">
                                    <h3 class="text-muted"><i class="fe fe-bell"></i> No notifications</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <a href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::user()->photo)
                        <img src="{{Auth::user()->photo}}" class="avatar-img rounded-circle" alt="{{Auth::user()->name}}">
                        @else
                        <div class="initials">
                            <span>{{Str::limit(Auth::user()->name, 1, '')}}{{Str::limit(Auth::user()->surname, 1, '')}}</span>
                        </div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{route('edit.customer', Auth::user()->id)}}" class="dropdown-item">Settings</a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="mr-2" aria-hidden="true"><i class="mdi mdi-logout-variant"></i></span> Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

    </div>
</nav>


