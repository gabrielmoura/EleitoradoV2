<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
     id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
            data-feather="menu"></i></button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{route('dashboard')}}">{{config('app.name')}}</a>
    <!-- Navbar Search Input-->
    <!-- * * Note: * * Visible only on and above the lg breakpoint-->
{{--    <form class="form-inline me-auto d-none d-lg-block me-3">--}}
{{--        <div class="input-group input-group-joined input-group-solid">--}}
{{--            <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search"/>--}}
{{--            <div class="input-group-text"><i data-feather="search"></i></div>--}}
{{--        </div>--}}
{{--    </form>--}}
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <!-- Documentation Dropdown-->
        <livewire:documentation-center/>
        <!-- Navbar Search Dropdown-->
        <!-- * * Note: * * Visible only below the lg breakpoint-->
        <li class="nav-item dropdown no-caret me-3 d-lg-none">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
            <!-- Dropdown - Search-->
            <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--fade-in-up"
                 aria-labelledby="searchDropdown">
                <form class="form-inline me-auto w-100">
                    <div class="input-group input-group-joined input-group-solid">
                        <input class="form-control pe-0" type="text" placeholder="Search for..." aria-label="Search"
                               aria-describedby="basic-addon2"/>
                        <div class="input-group-text"><i data-feather="search"></i></div>
                    </div>
                </form>
            </div>
        </li>
        @role(['manager','user'])
            <livewire:alerts-center/>
            <livewire:message-center/>
        @endrole

        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
               href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <img alt="{{session()->get('user.name')}}" class="img-fluid"
                     src="{{session()->get('user.profile_photo_url')}}"/>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                 aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img alt="{{session()->get('user.name')}}" class="dropdown-user-img"
                         src="{{session()->get('user.profile_photo_url')}}"/>
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{session()->get('user.name')}}</div>
                        <div class="dropdown-user-details-email">{{session()->get('user.email')}}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('profile.show')}}">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    {{__('Account')}}
                </a>
                <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logout-form').submit();">
                    <i class="dropdown-item-icon" data-feather="log-out"></i>
                    {{__('Logout')}}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
