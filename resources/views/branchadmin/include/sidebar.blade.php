<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{asset('assets/images/user.png')}}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{auth('branch_admin')->user()->{'first_name_'.get_language() } }} {{auth('branch_admin')->user()->{'last_name_'.get_language() } }}</span>
                    <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('branch_admin/dashboard')}}">
                <span class="menu-title">{{ __('SuperAdmin/dashboard.dashboard')}}</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#manage_app" aria-expanded="false" aria-controls="manage_app">
                <span class="menu-title">{{ __('SuperAdmin/backend.course_application') }}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="manage_app">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('branch_admin.manage_application.index')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#payment_received" aria-expanded="false" aria-controls="payment_received">
                <span class="menu-title">{{ __('SuperAdmin/backend.payment_received')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="payment_received">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('branch_admin.payment_received.index')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('branch_admin/rating/*')) ?  'active' :'' }}">
            <a class="nav-link" data-toggle="collapse" href="#rating" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{ __('SuperAdmin/backend.rating')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('branch_admin/rating/*')) ?  'show' :'' }}" id="rating">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link {{(request()->is('branch_admin/rating/*')) ?  'active' :'' }}" href="{{route('branch_admin.rating.index')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('branch_admin/enquiry/*')) ?  'active' :'' }}">
            <a class="nav-link" data-toggle="collapse" href="#enquiry" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">@lang('SuperAdmin/backend.manage_enquiries')</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('branch_admin/enquiry/*')) ?  'show' :'' }}" id="enquiry">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link {{(request()->is('branch_admin/enquiry/*')) ?  'active' :'' }}" href="{{url('branch_admin/enquiry')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('branch_admin/send_message_to_student/*')) ?  'active' :'' }}">
            <a class="nav-link" data-toggle="collapse" href="#send_message" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">@lang('SchoolAdmin.message_student')</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('branch_admin/send_message_to_student*')) ?  'show' :'' }}" id="send_message">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link {{(request()->is('branch_admin/send_message_to_student*')) ?  'active' :'' }}" href="{{url('branch_admin/send_message_to_student')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#course" aria-expanded="false" aria-controls="course">
                <span class="menu-title">{{ __('SuperAdmin/dashboard.courses')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="course">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('branch_admin.course.index')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        {{-- 
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#courses" aria-expanded="false" aria-controls="courses">
                <span class="menu-title">{{ __('SuperAdmin/dashboard.courses')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="courses">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('branch_admin.course.index')}}">{{ __('SuperAdmin/dashboard.view')}} </a></li>
                </ul>
            </div>
        </li>
        --}}
        <!--
            <li class="nav-item">
                <a class="nav-link" href="pages/icons/mdi.html">
                    <span class="menu-title">Icons</span>
                    <i class="mdi mdi-contacts menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pages/forms/basic_elements.html">
                    <span class="menu-title">Forms</span>
                    <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pages/charts/chartjs.html">
                    <span class="menu-title">Charts</span>
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pages/tables/basic-table.html">
                    <span class="menu-title">Tables</span>
                    <i class="mdi mdi-table-large menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                    <span class="menu-title">Sample Pages</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-medical-bag menu-icon"></i>
                </a>
                <div class="collapse" id="general-pages">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                        <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                        <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                        <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                        <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                    </ul>
                </div>
            </li>
        -->
            
        <!--
            <li class="nav-item sidebar-actions">
                <span class="nav-link">
                    <div class="border-bottom">
                        <h6 class="font-weight-normal mb-3">Projects</h6>
                    </div>
                    <button class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add a project</button>
                    <div class="mt-4">
                        <div class="border-bottom">
                            <p class="text-secondary">Categories</p>
                        </div>
                        <ul class="gradient-bullet-list mt-4">
                            <li>Free</li>
                            <li>Pro</li>
                        </ul>
                    </div>
                </span>
            </li>
        -->
    </ul>
</nav>