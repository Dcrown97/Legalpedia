<style>
    .initials {
        color: #fff;
        font-size: 20px;
        padding: 5px 0 0 8px;
        background: #EC6959 !important;
        height: 40px;
        width: 40px;
        border-radius: 50%;
    }
    .dropdown-toggle::after {
        opacity: 0;
    }
    .dropdown-menu {
        position: inherit;
    }
    .cursor {
        cursor: pointer;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light ">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse head justify-content-between" id="navbarTogglerDemo01" style="align-items: baseline;">
        <a class="navbar-brand" href="/">
            <img src="/assets/images/legalpedia_logo.png" alt="nav_logo">
        </a>
        @if(Auth::check())
            <div class="">
                <a id="sidebarIcon" class="dropdown-toggle cursor" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-sm avatar-online">
                        @if(Auth::user()->photo)
                            <img src="{{Auth::user()->photo}}" height="50" class="avatar-img rounded-circle" alt="{{Auth::user()->name}}">
                            @else
                            <div class="initials">
                                <span>{{Str::limit(Auth::user()->name, 1, '')}}{{Str::limit(Auth::user()->surname, 1, '')}}</span>
                            </div>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                    <a href="{{route('edit.customer', Auth::user()->id)}}" class="dropdown-item">Settings</a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="mr-2" aria-hidden="true"><i class="mdi mdi-logout-variant"></i></span> Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            @else
            <a class="btn btn-primary text-white py-2 px-4" href="{{route('login')}}">Sign in</a>
        @endif
    </div>
</nav>
