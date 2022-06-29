<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    @if (auth('schooladmin')->user()->image)
                        <img src="{{ auth('schooladmin')->user()->image }}" alt="profile">
                    @else
                        <img src="{{ asset('assets/images/user.png') }}" alt="profile">
                    @endif
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ app()->getLocale() == 'en' ? auth('schooladmin')->user()->first_name_en . ' ' . auth('schooladmin')->user()->lsst_name_en : auth('schooladmin')->user()->first_name_ar . ' ' . auth('schooladmin')->user()->last_name_ar }}</span>
                    <span class="text-secondary text-small mb-1">{{ auth('schooladmin')->user()->email }}</span>
                    <span class="text-secondary text-small">{{ __('Admin/dashboard.' . auth('schooladmin')->user()->user_type) }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('schooladmin/dashboard')}}">
                <span class="menu-title">{{__('Admin/dashboard.dashboard')}}</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        @if (can_manage_school() || can_add_school() || can_edit_school())
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#school" aria-expanded="false" aria-controls="school">
                    <span class="menu-title">{{__('Admin/dashboard.school')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="school">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('schooladmin.school.index')}}">{{__('Admin/dashboard.view')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (can_manage_course() || can_add_course() || can_edit_course())
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#course" aria-expanded="false" aria-controls="course">
                    <span class="menu-title">{{__('Admin/dashboard.courses')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-account-school-outline menu-icon"></i>
                </a>
                <div class="collapse" id="course">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('schooladmin.course.index') }}">{{__('Admin/dashboard.view')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('schooladmin.course.deleted') }}">{{__('Admin/dashboard.deleted')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#course_application" aria-expanded="false" aria-controls="course_application">
                <span class="menu-title">{{__('Admin/backend.course_application')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="course_application">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('schooladmin.course_application.index')}}">{{__('Admin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#enquiry" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{__('Admin/backend.manage_enquiries')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="enquiry">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('schooladmin/enquiry')}}">{{ __('Admin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>