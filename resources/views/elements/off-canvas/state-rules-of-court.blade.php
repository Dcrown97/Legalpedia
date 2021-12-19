<div class="offcanvas offcanvas-start" id="sidebarOffcanvasSearch" tabindex="-1">
    <div class="offcanvas-body" data-list='{"valueNames": ["name"]}'>
        <!-- List group -->
        <div class="my-n3">
            <div class="list-group list-group-flush list-group-focus list">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/dashboard')}}">
                        <i class="fe fe-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/judgements')}}">
                        <i class="fe fe-bell"></i> Judgements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/laws-of-federation')}}">
                        <i class="fe fe-bell"></i> Laws of Federation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{url('admin/rules-of-court')}}">
                        <i class="fe fe-bell"></i> Rules of Court
                        </a>
                    </li>
                    <li class="nav-item" style="background: #f5f5f5">
                        <a class="nav-link active" href="{{url('admin/state-rules-of-court')}}">
                        <i class="fe fe-bell"></i> State Rules of Court
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/forms-and-precedences')}}">
                        <i class="fe fe-bell"></i> Forms and Precedences
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/categories')}}">
                        <i class="fe fe-bell"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/areas-of-laws')}}">
                        <i class="fe fe-bell"></i> Areas of Laws
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/legal-articles')}}">
                        <i class="fe fe-bell"></i> Legal Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/law-dictionary')}}">
                        <i class="fe fe-bell"></i> Law Dictionary
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/legal-maxims')}}">
                        <i class="fe fe-bell"></i> Legal Maxims
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/resources')}}">
                        <i class="fe fe-bell"></i> Resources
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/customers')}}">
                            <i class="fe fe-users"></i> Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/subscriptions')}}">
                            <i class="fe fe-bell"></i> Subscriptions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/discount')}}">
                            <i class="fe fe-bell"></i> Discount
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/messages')}}">
                            <i class="fe fe-bell"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/licenses')}}">
                            <i class="fe fe-bell"></i> License
                        </a>
                    </li>
                </ul>
                <div class="mt-auto">
                    <div class="navbar-user d-none d-md-flex" id="sidebarUser">
                        <a class="navbar-user-link-0" data-bs-toggle="offcanvas" href="#sidebarOffcanvasActivity" aria-controls="sidebarOffcanvasActivity">
                        <span class="icon">
                            <i class="fe fe-bell"></i>
                        </span>
                        </a>
                        <div class="dropup">
                        <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-sm avatar-online">
                                <img src="{{asset('assets/images/user-avatar.jpg')}}" class="avatar-img rounded-circle" alt="...">
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
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
                        <a class="navbar-user-link-0">
                        <span class="icon">
                            <i class="fe fe-search"></i>
                        </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
