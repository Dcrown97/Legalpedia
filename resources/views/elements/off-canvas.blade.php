<!-- OFFCANVAS -->
      <!-- Offcanvas: Demo -->
      <form class="offcanvas offcanvas-end" id="offcanvasDemo" tabindex="-1">
        <div class="offcanvas-body">

          <!-- Close -->
          <a class="btn-close" href="#" data-bs-dismiss="offcanvas" aria-label="Close"></a>

          <!-- Image -->
          <div class="text-center">
            <img src="assets/img/illustrations/designer-life.svg" alt="..." class="img-fluid mb-3">
          </div>

          <!-- Heading -->
          <h2 class="text-center mb-2">
            Make Dashkit Your Own
          </h2>

          <!-- Text -->
          <p class="text-center mb-4">
            Set preferences that will be cookied for your live preview demonstration.
          </p>

          <!-- Divider -->
          <hr class="mb-4">

          <!-- Heading -->
          <h4 class="mb-1">
            Color Scheme
          </h4>

          <!-- Text -->
          <p class="small text-muted mb-3">
            Overall light or dark presentation.
          </p>

          <!-- Button group -->
          <div class="btn-group-toggle row gx-2 mb-4">
            <div class="col">
              <input class="btn-check" name="colorScheme" id="colorSchemeLight" type="radio" value="light">
              <label class="btn w-100 btn-white" for="colorSchemeLight">
                <i class="fe fe-sun me-2"></i> Light Mode
              </label>
            </div>
            <div class="col">
              <input class="btn-check" name="colorScheme" id="colorSchemeDark" type="radio" value="dark">
              <label class="btn w-100 btn-white" for="colorSchemeDark">
                <i class="fe fe-moon me-2"></i> Dark Mode
              </label>
            </div>
          </div>

          <!-- Heading -->
          <h4 class="mb-1">
            Navigation Position
          </h4>

          <!-- Text -->
          <p class="small text-muted mb-3">
            Select the primary navigation paradigm for your app.
          </p>

          <!-- Button group -->
          <div class="btn-group-toggle row gx-2 mb-4">
            <div class="col">
              <input class="btn-check" name="navPosition" id="navPositionSidenav" type="radio" value="sidenav">
              <label class="btn w-100 btn-white" for="navPositionSidenav">
                Sidenav
              </label>
            </div>
            <div class="col">
              <input class="btn-check" name="navPosition" id="navPositionTopnav" type="radio" value="topnav">
              <label class="btn w-100 btn-white" for="navPositionTopnav">
                Topnav
              </label>
            </div>
            <div class="col">
              <input class="btn-check" name="navPosition" id="navPositionCombo" type="radio" value="combo">
              <label class="btn w-100 btn-white" for="navPositionCombo">
                Combo
              </label>
            </div>
          </div>

          <!-- Collapse -->
          <div id="sidebarSizeContainer">

            <!-- Heading -->
            <h4 class="mb-1">
              Sidenav Sizing
            </h4>

            <!-- Text -->
            <p class="small text-muted mb-3">
              Standard navigation sizing or minified icons with dropdowns.
            </p>

            <!-- Button group -->
            <div class="btn-group-toggle row gx-2 mb-4">
              <div class="col">
                <input class="btn-check" name="sidebarSize" id="sidebarSizeBase" type="radio" value="base">
                <label class="btn w-100 btn-white" for="sidebarSizeBase">
                  Fullsize
                </label>
              </div>
              <div class="col">
                <input class="btn-check" name="sidebarSize" id="sidebarSizeSmall" type="radio" value="small">
                <label class="btn w-100 btn-white" for="sidebarSizeSmall">
                  Icons
                </label>
              </div>
            </div>

          </div>

          <!-- Heading -->
          <h4 class="mb-1">
            Navigation Color
          </h4>

          <!-- Text -->
          <p class="small text-muted mb-3">
            Usually dictated by the color scheme, but can be overriden.
          </p>

          <!-- Button group -->
          <div class="btn-group-toggle row gx-2">
            <div class="col">
              <input class="btn-check" name="navColor" id="navColorDefault" type="radio" value="default">
              <label class="btn w-100 btn-white" for="navColorDefault">
                Default
              </label>
            </div>
            <div class="col">
              <input class="btn-check" name="navColor" id="navColorInverted" type="radio" value="inverted">
              <label class="btn w-100 btn-white" for="navColorInverted">
                Inverted
              </label>
            </div>
            <div class="col">
              <input class="btn-check" name="navColor" id="navColorVibrant" type="radio" value="vibrant">
              <label class="btn w-100 btn-white" for="navColorVibrant">
                Vibrant
              </label>
            </div>
          </div>

        </div>
        <div class="offcanvas-header">

          <!-- Button -->
          <button type="submit" class="btn w-100 btn-primary mt-auto">
            Preview
          </button>

        </div>
      </form>

    <!-- Offcanvas: Search -->
    <div class="offcanvas offcanvas-start" id="sidebarOffcanvasSearch" tabindex="-1">
      <div class="offcanvas-body" data-list='{"valueNames": ["name"]}'>

        <!-- Form -->
        <form class="mb-4">
          <div class="input-group input-group-merge input-group-rounded input-group-reverse">
            <input class="form-control list-search" type="search" placeholder="Search">
            <div class="input-group-text">
              <span class="fe fe-search"></span>
            </div>
          </div>
        </form>

        <!-- List group -->
        <div class="my-n3">
          <div class="list-group list-group-flush list-group-focus list">
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

      </div>
    </div>

    <!-- Offcanvas: Activity -->
    <div class="offcanvas offcanvas-start" id="sidebarOffcanvasActivity" tabindex="-1">
      <div class="offcanvas-header">

        <!-- Title -->
        <h4 class="offcanvas-title">
          Notifications
        </h4>

        <!-- Navs -->
        <ul class="nav nav-tabs nav-tabs-sm modal-header-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#modalActivityAction">Action</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#modalActivityUser">User</a>
          </li>
        </ul>

      </div>
      <div class="offcanvas-body">
        <div class="tab-content">
          <div class="tab-pane fade show active" id="modalActivityAction">

            <!-- List group -->
            <div class="list-group list-group-flush list-group-activity my-n3">
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-mail"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Launchday 1.4.0 update email sent
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Sent to all 1,851 subscribers over a 24 hour period
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-archive"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      New project "Goodkit" created
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Looks like there might be a new theme soon.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-code"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dashkit 1.5.0 was deployed.
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      A successful to deploy to production was executed.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-git-branch"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      "Update Dependencies" branch was created.
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      This branch was created off of the "master" branch.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-mail"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Launchday 1.4.0 update email sent
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Sent to all 1,851 subscribers over a 24 hour period
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-archive"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      New project "Goodkit" created
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Looks like there might be a new theme soon.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-code"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dashkit 1.5.0 was deployed.
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      A successful to deploy to production was executed.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-git-branch"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      "Update Dependencies" branch was created.
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      This branch was created off of the "master" branch.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-mail"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Launchday 1.4.0 update email sent
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Sent to all 1,851 subscribers over a 24 hour period
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-archive"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      New project "Goodkit" created
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Looks like there might be a new theme soon.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-code"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dashkit 1.5.0 was deployed.
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      A successful to deploy to production was executed.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm">
                      <div class="avatar-title fs-lg bg-primary-soft rounded-circle text-primary">
                        <i class="fe fe-git-branch"></i>
                      </div>
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      "Update Dependencies" branch was created.
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      This branch was created off of the "master" branch.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
            </div>

          </div>
          <div class="tab-pane fade" id="modalActivityUser">

            <!-- List group -->
            <div class="list-group list-group-flush list-group-activity my-n3">
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dianna Smiley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Uploaded the files "Launchday Logo" and "New Design".
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Ab Hadley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Shared the "Why Dashkit?" post with 124 subscribers.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      1h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-offline">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Adolfo Hess
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Exported sales data from Launchday's subscriber data.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      3h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dianna Smiley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Uploaded the files "Launchday Logo" and "New Design".
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Ab Hadley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Shared the "Why Dashkit?" post with 124 subscribers.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      1h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-offline">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Adolfo Hess
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Exported sales data from Launchday's subscriber data.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      3h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dianna Smiley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Uploaded the files "Launchday Logo" and "New Design".
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Ab Hadley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Shared the "Why Dashkit?" post with 124 subscribers.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      1h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-offline">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Adolfo Hess
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Exported sales data from Launchday's subscriber data.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      3h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Dianna Smiley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Uploaded the files "Launchday Logo" and "New Design".
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      2m ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-online">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Ab Hadley
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Shared the "Why Dashkit?" post with 124 subscribers.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      1h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
              <a class="list-group-item text-reset" href="#!">
                <div class="row">
                  <div class="col-auto">

                    <!-- Avatar -->
                    <div class="avatar avatar-sm avatar-offline">
                      <img class="avatar-img rounded-circle" src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." />
                    </div>

                  </div>
                  <div class="col ms-n2">

                    <!-- Heading -->
                    <h5 class="mb-1">
                      Adolfo Hess
                    </h5>

                    <!-- Text -->
                    <p class="small text-gray-700 mb-0">
                      Exported sales data from Launchday's subscriber data.
                    </p>

                    <!-- Time -->
                    <small class="text-muted">
                      3h ago
                    </small>

                  </div>
                </div> <!-- / .row -->
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
