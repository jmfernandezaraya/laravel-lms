<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    @if (auth('superadmin')->user()->image)
                        <img src="{{ auth('superadmin')->user()->image }}" alt="profile">
                    @else
                        <img src="{{ asset('assets/images/user.png') }}" alt="profile">
                    @endif
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ app()->getLocale() == 'en' ? auth('superadmin')->user()->first_name_en . ' ' . auth('superadmin')->user()->lsst_name_en : auth('superadmin')->user()->first_name_ar . ' ' . auth('superadmin')->user()->last_name_ar }}</span>
                    <span class="text-secondary text-small mb-1">{{ auth('superadmin')->user()->email }}</span>
                    <span class="text-secondary text-small">{{ __('SuperAdmin/dashboard.' . auth('superadmin')->user()->user_type) }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('superadmin/dashboard')}}">
                <span class="menu-title">{{__('SuperAdmin/dashboard.dashboard')}}</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        @if (auth('superadmin')->user()->permission['blog_manager'] || auth('superadmin')->user()->permission['blog_add'] || auth('superadmin')->user()->permission['blog_edit'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#blogs" aria-expanded="false" aria-controls="blogs">
                    <span class="menu-title">{{__('SuperAdmin/backend.manage_blogs')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="blogs">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.blogs.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (auth('superadmin')->user()->permission['school_manager'] || auth('superadmin')->user()->permission['school_add'] || auth('superadmin')->user()->permission['school_edit'])
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#school" aria-expanded="false" aria-controls="school">
                    <span class="menu-title">{{__('SuperAdmin/dashboard.school')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="school">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.school.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.school.country_city')}}">{{__('SuperAdmin/backend.countries_cities')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.school.name')}}">{{__('SuperAdmin/backend.names')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_add'] || auth('superadmin')->user()->permission['course_edit'] || auth('superadmin')->user()->permission['course_display'] || auth('superadmin')->user()->permission['course_delete'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#course" aria-expanded="false" aria-controls="course">
                    <span class="menu-title">{{__('SuperAdmin/dashboard.courses')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-account-school-outline menu-icon"></i>
                </a>
                <div class="collapse" id="course">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.course.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.course.deleted')}}">{{__('SuperAdmin/dashboard.deleted')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (auth('superadmin')->user()->permission['course_application_manager'] || auth('superadmin')->user()->permission['course_application_edit'] || auth('superadmin')->user()->permission['course_application_chanage_status'] || auth('superadmin')->user()->permission['course_application_payment_refund'] || auth('superadmin')->user()->permission['course_application_contact_student'] || auth('superadmin')->user()->permission['course_application_contact_school'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#course_application" aria-expanded="false" aria-controls="course_application">
                    <span class="menu-title">{{__('SuperAdmin/backend.course_application')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="course_application">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.manage_application.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#review" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{__('SuperAdmin/backend.rating_review')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="review">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.review.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#payment_received" aria-expanded="false" aria-controls="payment_received">
                <span class="menu-title">{{__('SuperAdmin/backend.payment_received')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="payment_received">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.payment_received.index')}}">{{ __('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_add'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'] || auth('superadmin')->user()->permission['user_permission'])
           <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
                    <span class="menu-title">{{__('SuperAdmin/backend.users')}}</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.user.customer.index')}}">{{__('SuperAdmin/dashboard.customers')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.user.school_admin.index')}}">{{__('SuperAdmin/dashboard.school_admin')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.user.super_admin.index')}}">{{__('SuperAdmin/dashboard.super_admin')}}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#enquiry" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_enquiries')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="enquiry">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('superadmin/enquiry')}}">{{ __('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#visas" aria-expanded="false" aria-controls="visas">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_formbuilder')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-form-select menu-icon"></i>
            </a>
            <div class="collapse" id="visas">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('superadmin/visa')}}">{{ __('SuperAdmin/dashboard.view')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('superadmin/visa/create')}}">{{ __('SuperAdmin/dashboard.formbuilder')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#visa_application" aria-expanded="false" aria-controls="visa_application">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_visa')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-card-bulleted menu-icon"></i>
            </a>
            <div class="collapse" id="visa_application">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('superadmin/visa_application/')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.view_visa_forms')}}">{{__('SuperAdmin/backend.view_visa_forms')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                <span class="menu-title">{{__('SuperAdmin/dashboard.settings')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-settings menu-icon"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    @if (auth('superadmin')->user()->permission['currency_manager'] || auth('superadmin')->user()->permission['currency_deit'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('superadmin.setting.currency.index')}}">{{__('SuperAdmin/dashboard.currency')}}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.setting.home_page')}}">{{__('SuperAdmin/dashboard.home_page')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.setting.header_footer')}}">{{__('SuperAdmin/dashboard.header_footer')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.setting.front_page.index')}}">{{__('SuperAdmin/dashboard.front_pages')}}</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>