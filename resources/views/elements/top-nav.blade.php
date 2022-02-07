<nav class="navbar navbar-expand-lg " id="topnav">
    <div class="container">

      <!-- Toggler -->
      {{-- <button class="navbar-toggler me-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> --}}

        <a class="navbar-user-link-0" data-bs-toggle="offcanvas" href="#sidebarOffcanvasSearch" aria-controls="sidebarOffcanvasSearch">
            <span class="navbar-toggler-icon"></span>
        </a>

      <!-- Brand -->
      <a class="navbar-brand me-auto" href="index.html">
        <img src="{{asset('assets/images/legalpedia_logo.png')}}" alt="..." class="navbar-brand-img">
      </a>

      <!-- Form -->
      <form class="form-inline me-4 d-none d-lg-flex">
        <div class="input-group input-group-rounded input-group-merge input-group-reverse" data-list='{"valueNames": ["name"]}'>

          <!-- Input -->
          <input type="search" class="form-control dropdown-toggle list-search" data-bs-toggle="dropdown" placeholder="Search" aria-label="Search">

          <!-- Icon -->
          <div class="input-group-text">
            <i class="fe fe-search"></i>
          </div>

          <!-- Menu -->
          <div class="dropdown-menu dropdown-menu-card">
            <div class="card-body">

              <!-- List group -->
              <div class="list-group list-group-flush list-group-focus list my-n3">
                <a class="list-group-item" href="team-overview.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar">
                        <img src="assets/img/avatars/teams/team-logo-1.jpg" alt="..." class="avatar-img rounded">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Airbnb
                      </h4>

                      <!-- Time -->
                      <p class="small text-muted mb-0">
                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">Updated 2hr ago</time>
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
                <a class="list-group-item" href="team-overview.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar">
                        <img src="assets/img/avatars/teams/team-logo-2.jpg" alt="..." class="avatar-img rounded">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Medium Corporation
                      </h4>

                      <!-- Time -->
                      <p class="small text-muted mb-0">
                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">Updated 2hr ago</time>
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
                <a class="list-group-item" href="project-overview.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar avatar-4by3">
                        <img src="assets/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Homepage Redesign
                      </h4>

                      <!-- Time -->
                      <p class="small text-muted mb-0">
                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">Updated 4hr ago</time>
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
                <a class="list-group-item" href="project-overview.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar avatar-4by3">
                        <img src="assets/img/avatars/projects/project-2.jpg" alt="..." class="avatar-img rounded">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Travels & Time
                      </h4>

                      <!-- Time -->
                      <p class="small text-muted mb-0">
                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">Updated 4hr ago</time>
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
                <a class="list-group-item" href="project-overview.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar avatar-4by3">
                        <img src="assets/img/avatars/projects/project-3.jpg" alt="..." class="avatar-img rounded">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Safari Exploration
                      </h4>

                      <!-- Time -->
                      <p class="small text-muted mb-0">
                        <span class="fe fe-clock"></span> <time datetime="2018-05-24">Updated 4hr ago</time>
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
                <a class="list-group-item" href="profile-posts.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar">
                        <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Dianna Smiley
                      </h4>

                      <!-- Status -->
                      <p class="text-body small mb-0">
                        <span class="text-success">●</span> Online
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
                <a class="list-group-item" href="profile-posts.html">
                  <div class="row align-items-center">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar">
                        <img src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                      </div>

                    </div>
                    <div class="col ms-n2">

                      <!-- Title -->
                      <h4 class="text-body text-focus mb-1 name">
                        Ab Hadley
                      </h4>

                      <!-- Status -->
                      <p class="text-body small mb-0">
                        <span class="text-danger">●</span> Offline
                      </p>

                    </div>
                  </div> <!-- / .row -->
                </a>
              </div>

            </div>
          </div> <!-- / .dropdown-menu -->

        </div>
      </form>

      <!-- User -->
      <div class="navbar-user">

        <!-- Dropdown -->
        <div class="dropdown me-4 d-none d-lg-flex">

          <!-- Toggle -->
          <a href="#" class="navbar-user-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="icon active">
              <i class="fe fe-bell"></i>
            </span>
          </a>

          <!-- Menu -->
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
            <div class="card-header">

              <!-- Title -->
              <h5 class="card-header-title">
                Notifications
              </h5>

              <!-- Link -->
              <a href="#!" class="small">
                View all
              </a>

            </div> <!-- / .card-header -->
            <div class="card-body">

              <!-- List group -->
              <div class="list-group list-group-flush list-group-activity my-n3">
                <a class="list-group-item text-reset" href="#!">
                  <div class="row">
                    <div class="col-auto">

                      <!-- Avatar -->
                      <div class="avatar avatar-sm">
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

                      <!-- Content -->
                      <div class="small">
                        <strong>Welcome onboard!</strong> {{Auth::user()->name}}, Legalpedia has just the right resources for you to get started
                      </div>

                      <!-- Time -->
                      <small class="text-muted">
                        2m ago
                      </small>

                    </div>
                  </div> <!-- / .row -->
                </a>
              </div>

            </div>
          </div> <!-- / .dropdown-menu -->

        </div>

        <!-- Dropdown -->
        <div class="dropdown">

          <!-- Toggle -->
          <a href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
          </a>

          <!-- Menu -->
          <div class="dropdown-menu dropdown-menu-end">
            <a href="profile-posts.html" class="dropdown-item">Profile</a>
            <a href="account-general.html" class="dropdown-item">Settings</a>
            <hr class="dropdown-divider">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="mr-2" aria-hidden="true"><i class="mdi mdi-logout-variant"></i></span> Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
          </div>

        </div>

      </div>

      <!-- Collapse -->
      <div class="collapse navbar-collapse me-lg-auto order-lg-first" id="navbar">

        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <input type="search" class="form-control form-control-rounded" placeholder="Search" aria-label="Search">
        </form>

        <!-- Navigation -->
        <ul class="navbar-nav me-lg-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" id="topnavDashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Dashboards
            </a>
            <ul class="dropdown-menu" aria-labelledby="topnavDashboards">
              <li>
                <a class="dropdown-item active" href="index.html">
                  Default
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="dashboard-project-management.html">
                  Project Management
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="dashboard-ecommerce.html">
                  E-Commerce
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="topnavPages" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
              Pages
            </a>
            <ul class="dropdown-menu" aria-labelledby="topnavPages">
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavAccount" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Account
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavAccount">
                  <a class="dropdown-item " href="account-general.html">
                    General
                  </a>
                  <a class="dropdown-item " href="account-billing.html">
                    Billing
                  </a>
                  <a class="dropdown-item " href="account-members.html">
                    Members
                  </a>
                  <a class="dropdown-item " href="account-security.html">
                    Security
                  </a>
                  <a class="dropdown-item " href="account-notifications.html">
                    Notifications
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavCrm" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  CRM
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavCrm">
                  <a class="dropdown-item " href="crm-contacts.html">
                    Contacts
                  </a>
                  <a class="dropdown-item " href="crm-companies.html">
                    Companies
                  </a>
                  <a class="dropdown-item " href="crm-deals.html">
                    Deals
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavProfile" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Profile
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavProfile">
                  <a class="dropdown-item " href="profile-posts.html">
                    Posts
                  </a>
                  <a class="dropdown-item " href="profile-groups.html">
                    Groups
                  </a>
                  <a class="dropdown-item " href="profile-projects.html">
                    Projects
                  </a>
                  <a class="dropdown-item " href="profile-files.html">
                    Files
                  </a>
                  <a class="dropdown-item " href="profile-subscribers.html">
                    Subscribers
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavProject" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Project
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavProject">
                  <a class="dropdown-item " href="project-overview.html">
                    Overview
                  </a>
                  <a class="dropdown-item " href="project-files.html">
                    Files
                  </a>
                  <a class="dropdown-item " href="project-reports.html">
                    Reports
                  </a>
                  <a class="dropdown-item " href="project-new.html">
                    New project
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavTeam" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Team
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavTeam">
                  <a class="dropdown-item " href="team-overview.html">
                    Overview
                  </a>
                  <a class="dropdown-item " href="team-projects.html">
                    Projects
                  </a>
                  <a class="dropdown-item " href="team-members.html">
                    Members
                  </a>
                  <a class="dropdown-item " href="team-new.html">
                    New team
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavFeed" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Feed
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavFeed">
                  <a class="dropdown-item " href="feed.html">
                    Platform
                  </a>
                  <a class="dropdown-item " href="social-feed.html">
                    Social
                  </a>
                </div>
              </li>
              <li>
                <a class="dropdown-item " href="wizard.html">
                  Wizard
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="kanban.html">
                  Kanban
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="orders.html">
                  Orders
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="invoice.html">
                  Invoice
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="pricing.html">
                  Pricing
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="widgets.html">
                  Widgets
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="topnavAuth" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
              Auth
            </a>
            <ul class="dropdown-menu" aria-labelledby="topnavAuth">
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#" id="topnavSignIn" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Sign in
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavSignIn">
                  <a class="dropdown-item" href="sign-in-cover.html">
                    Cover
                  </a>
                  <a class="dropdown-item" href="sign-in-illustration.html">
                    Illustration
                  </a>
                  <a class="dropdown-item" href="sign-in-basics.html">
                    Basic
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#" id="topnavSignUp" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Sign up
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavSignUp">
                  <a class="dropdown-item" href="sign-up-cover.html">
                    Cover
                  </a>
                  <a class="dropdown-item" href="sign-up-illustration.html">
                    Illustration
                  </a>
                  <a class="dropdown-item" href="sign-up.html">
                    Basic
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#" id="topnavPassword" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Password reset
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavPassword">
                  <a class="dropdown-item" href="password-reset-cover.html">
                    Cover
                  </a>
                  <a class="dropdown-item" href="password-reset-illustration.html">
                    Illustration
                  </a>
                  <a class="dropdown-item" href="password-reset.html">
                    Basic
                  </a>
                </div>
              </li>
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#" id="topnavError" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Error
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavError">
                  <a class="dropdown-item" href="error-illustration.html">
                    Illustration
                  </a>
                  <a class="dropdown-item" href="error.html">
                    Basic
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="topnavDocumentation" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
              Docs
            </a>
            <ul class="dropdown-menu" aria-labelledby="topnavDocumentation">
              <li class="dropend">
                <a class="dropdown-item dropdown-toggle " href="#" id="topnavBasics" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Basics
                </a>
                <div class="dropdown-menu" aria-labelledby="topnavBasics">
                  <a class="dropdown-item " href="docs/getting-started.html">
                    Getting Started
                  </a>
                  <a class="dropdown-item " href="docs/design-file.html">
                    Design File
                  </a>
                </div>
              </li>
              <li>
                <a class="dropdown-item " href="docs/components.html">
                  Components
                </a>
              </li>
              <li>
                <a class="dropdown-item " href="docs/changelog.html">
                  Changelog
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasDemo" aria-controls="offcanvasDemo">
              Customize
            </a>
          </li>
        </ul>

      </div>

    </div> <!-- / .container -->
  </nav>
