<style>
    .hide-desk {
        display: none;
    }

    @media screen and (min-width: 280px) and (max-width: 767px) {
        .hide-mobile {
            display: none;
        }

        .hide-desk {
            display: block;
        }
    }
</style>
<nav class="navbar navbar-vertical fixed-start navbar-expand-md " id="sidebar">
    <div class="container-fluid">
        <a class="navbar-user-link-0 hide-desk" data-bs-toggle="offcanvas" href="#sidebarOffcanvasSearch"
            aria-controls="sidebarOffcanvasSearch">
            <span class="navbar-toggler-icon"></span>
        </a>
        <!-- Brand -->
        <a class="navbar-brand" href="{{ url('admin/dashboard') }}">
            <img src="{{ asset('assets/images/legalpedia_logo.png') }}" class="navbar-brand-img mx-auto" alt="...">
        </a>
        <!-- User (xs) -->
        <div class="navbar-user d-md-none">

            <!-- Dropdown -->
            <div class="dropdown">

                <!-- Toggle -->
                <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-sm avatar-online">
                        @if (Auth::user()->photo)
                            <img src="{{ Auth::user()->photo }}" class="avatar-img rounded-circle"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <div class="initials">
                                <span>{{ Str::limit(Auth::user()->name, 1, '') }}{{ Str::limit(Auth::user()->surname, 1, '') }}</span>
                            </div>
                        @endif
                    </div>
                </a>

                <!-- Menu -->
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                    <a href="{{ route('edit.customer', Auth::user()->id) }}" class="dropdown-item">Settings</a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="mr-2" aria-hidden="true"><i class="mdi mdi-logout-variant"></i></span> Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </div>

        </div>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">

            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge input-group-reverse">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-text">
                        <span class="fe fe-search"></span>
                    </div>
                </div>
            </form>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/dashboard') }}">
                        <i class="fe fe-home"></i> Dashboard
                    </a>
                </li>
                @if (Auth::user()->role->name == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link" href="#judg" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="judg">
                            <i class="fe fe-bell"></i> Judgements
                        </a>
                        <div class="collapse" id="judg">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('admin/judgements') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> All Judgements
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/judgements/courts') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> Courts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/judgements/subject-matter-index') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> Subject Matter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/judgements') }}">
                            <i class="fe fe-bell"></i> Judgements
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/laws-of-federation') }}">
                        <i class="fe fe-bell"></i> Laws of Federation
                    </a>
                </li>
                @if (Auth::user()->role->name == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link" href="#cat" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="cat">
                            <i class="fe fe-bell"></i> Rules of Court
                        </a>
                        <div class="collapse " id="cat">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('admin/rules-of-court') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> All Rules of Court
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/rules-of-court/categories') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> Rule Categories
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/rules-of-court') }}">
                            <i class="fe fe-bell"></i> Rules of Court
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/state-rules-of-court') }}">
                        <i class="fe fe-bell"></i> State Rules of Court
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/forms-and-precedents') }}">
                        <i class="fe fe-bell"></i> Forms and Precedents
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/legal-articles') }}">
                        <i class="fe fe-bell"></i> Articles and Journals
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/law-dictionary') }}">
                        <i class="fe fe-bell"></i> Law Dictionary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/legal-maxims') }}">
                        <i class="fe fe-bell"></i> Legal Maxims
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/resources') }}">
                        <i class="fe fe-bell"></i> Foreign Resources
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/notes') }}">
                        <i class="fe fe-file"></i> Notes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/teams') }}">
                        <i class="fe fe-users"></i> Teams
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route(config('chatify.routes.prefix')) }}">
                        <i class="fe fe-message-square"></i> Chats
                    </a>
                </li>

                @if (Auth::user()->role->name == 'Staff')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/categories') }}">
                            <i class="fe fe-bell"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/featured-content') }}">
                            <i class="fe fe-bell"></i> Featured Content
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role->name == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/categories') }}">
                            <i class="fe fe-bell"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/featured-content') }}">
                            <i class="fe fe-bell"></i> Featured Content
                        </a>
                    </li>
                    <li class="nav-item" style="background: #f5f5f5">
                        <a class="nav-link active" href="{{ url('admin/customers') }}">
                            <i class="fe fe-users"></i> Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sub" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sub">
                            <i class="fe fe-bell"></i> Subscriptions
                        </a>
                        <div class="collapse" id="sub">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('admin/subscriptions') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> Packages
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/transactions') }}" class="nav-link ">
                                        <i class="fe fe-bell"></i> Transactions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/discount') }}">
                            <i class="fe fe-bell"></i> Discount
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/messages') }}">
                            <i class="fe fe-bell"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/licenses') }}">
                            <i class="fe fe-bell"></i> Institutional License
                        </a>
                    </li>
                @endif

                @if (!Auth::user()->package_id && Auth::user()->expiry_date < now())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/pricing') }}">
                            <span class="btn w-100 button_load text-white btn-sm btn-warning p-2"
                                onclick="this.classList.toggle('button--loading')">
                                <span class="button__text"><i class="mdi mdi-crown"></i> Subscribe</span>
                            </span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/pricing') }}" class="text-color">
                            <span class="btn w-100 button_load text-color btn-sm btn-custom p-2"
                                onclick="this.classList.toggle('button--loading')">
                                <span class="button__text"><i class="mdi mdi-crown"></i> Upgrade Package</span>
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="mt-auto">
                <div class="navbar-user d-none d-md-flex" id="sidebarUser">
                    {{-- <a class="navbar-user-link-0" data-bs-toggle="offcanvas" href="#sidebarOffcanvasActivity" aria-controls="sidebarOffcanvasActivity">
                    <span class="icon">
                        <i class="fe fe-bell"></i>
                    </span>
                </a> --}}
                    <div class="dropup">
                        <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-sm avatar-online">
                                @if (Auth::user()->photo)
                                    <img src="{{ Auth::user()->photo }}" class="avatar-img rounded-circle"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <div class="initials">
                                        <span>{{ Str::limit(Auth::user()->name, 1, '') }}{{ Str::limit(Auth::user()->surname, 1, '') }}</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                            <a href="{{ route('edit.customer', Auth::user()->id) }}"
                                class="dropdown-item">Settings</a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="mr-2" aria-hidden="true"><i class="mdi mdi-logout-variant"></i></span>
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                    {{-- <a class="navbar-user-link-0">
                    <span class="icon">
                        <i class="fe fe-search"></i>
                    </span>
                </a> --}}
                </div>
            </div>
        </div>
</nav>
