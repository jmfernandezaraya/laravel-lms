<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
                </div>
            </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="{{ asset('assets/images/user.png') }}" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ app()->getLocale() == 'en' ? auth('schooladmin')->user()->first_name_en . ' ' . auth('schooladmin')->user()->lsst_name_en : auth('schooladmin')->user()->first_name_ar . ' ' . auth('schooladmin')->user()->last_name_ar }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#"><i class="mdi mdi-cached mr-2 text-success"></i>{{__('Admin/backend.activity_log')}}</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{route('schooladmin.logout')}}">
                        @csrf
                        <button type ="submit" class="dropdown-item">
                        <i class="mdi mdi-logout mr-2 text-primary"></i>{{__('Admin/backend.signout')}}</button>
                    </form>
                </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-email-outline"></i>
                    <span class="count-symbol bg-warning"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <h6 class="p-3 mb-0">{{__('Admin/backend.messages_title')}}</h6>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count-symbol bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0">{{__('Admin/backend.notifications')}}</h6>
                </div>
            </li>
            <li class="nav-item nav-language dropdown">
                <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    @if (app()->getLocale() == 'en')
                        <img class="pr-2" src="{{ asset('public/frontend/assets/img/ar.png') }}" alt="logo">{{__('Admin/backend.english')}}
                    @else
                        <img class="pr-2" src="{{ asset('public/frontend/assets/img/ar.png') }}" alt="logo">{{__('Admin/backend.arabic')}}
                    @endif
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                    <a href="{{ url('set_language/en') }}" class="dropdown-item">
                        <img class="pr-2" src="{{ asset('public/frontend/assets/img/eng.png') }}" alt="logo">{{__('Admin/backend.english')}}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('set_language/ar') }}" class="dropdown-item">
                        <img class="pr-2" src="{{ asset('public/frontend/assets/img/ar.png') }}" alt="logo">{{__('Admin/backend.arabic')}}
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>