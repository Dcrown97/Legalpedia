<style>
    .search-form{
        display: none;
    }
     @media screen and (min-width: 280px) and (max-width: 767px) {
        .search-form{
            display: block;
            border: 1px solid #e3ebf6;
        }
    }

</style>
<form action="{{route('search')}}" method="GET" class="me-4 d-md-none d-sm-flex w-100" style="background: #f9fbfd; border-radius: 4px;">
    @if(Auth::user()->role->name == 'Admin')
        <div class="input-group-flush input-group-merge search-form input-group-reverse w-100">
            <button id="search-btn" class="btn button_load text-white btn-sm btn-primary p-2 px-3" onclick="this.classList.toggle('button--loading1')">
                <span class="button__text">Search</span>
            </button>
            <input type="text" name="search" id="search" class="form-control dropdown-toggle list-search" data-bs-toggle="dropdown" placeholder="Search Legalpedia" aria-label="Search" />
            <div class="input-group-text ml-4">
                <i class="fe fe-search"></i>
            </div>
        </div>
        @elseif(Auth::user()->subscribedUser())
        <div class="input-group-flush input-group-merge search-form input-group-reverse w-100">
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
