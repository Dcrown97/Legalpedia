<!-- Offcanvas: Demo -->
<form class="offcanvas offcanvas-end" id="offcanvasDemo" tabindex="-1">
    <div class="offcanvas-body">

      <!-- Close -->
      <a class="btn-close" href="#" data-bs-dismiss="offcanvas" aria-label="Close"></a>

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

      <!-- Button group -->
      <div class="btn-group-toggle row gx-2 mb-4" style="display: none">
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

      <!-- Button group -->
      <div class="btn-group-toggle row gx-2 mb-4" style="display: none">
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

        <!-- Button group -->
        <div class="btn-group-toggle row gx-2 mb-4" style="display: none">
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
      <!-- Button group -->
      <div class="btn-group-toggle row gx-2" style="display: none">
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
