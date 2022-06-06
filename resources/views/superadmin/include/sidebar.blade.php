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
        <li class="nav-item {{(request()->is('superadmin/blogs/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse"  href="#blogs" aria-expanded="false" aria-controls="blogs">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_blogs')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/blogs/*')) ? 'show' : ''}}" id="blogs">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/blogs/*')) ? 'active' : ''}}" href="{{route('superadmin.blogs.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('superadmin/customers/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse"  href="#customers" aria-expanded="false" aria-controls="customers">
                <span class="menu-title">{{__('SuperAdmin/backend.customers')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/customers/*')) ? 'show' : ''}}" id="customers">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/customers/*')) ? 'active' : ''}}" href="{{route('superadmin.customers.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('superadmin/manage_application/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse"  href="#aapp" aria-expanded="false" aria-controls="aapp">
                <span class="menu-title">{{__('SuperAdmin/backend.course_application')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/manage_application/*')) ? 'show' : ''}}" id="aapp">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item" > <a class="nav-link {{(request()->is('superadmin/manage_application/*')) ? 'active' : ''}}" href="{{route('superadmin.manage_application.index')}}">{{__('SuperAdmin/dashboard.view')}}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('superadmin/school/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#school" aria-expanded="false" aria-controls="school">
                <span class="menu-title">{{__('SuperAdmin/dashboard.school')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/school/*')) ? 'show' : ''}}" id="school">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/school/*')) ? 'active' : ''}}" href="{{route('superadmin.school.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/school/country_city*')) ? 'active' : ''}}" href="{{route('superadmin.school.country_city')}}">{{__('SuperAdmin/backend.countries_cities')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/school/name/*')) ? 'active' : ''}}" href="{{route('superadmin.school.name')}}">{{__('SuperAdmin/backend.names')}}</a>
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
        <li class="nav-item {{(request()->is('superadmin/school_admin/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#school_admin" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{__('SuperAdmin/dashboard.school_admin')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/school_admin/*')) ? 'show' : ''}}" id="school_admin">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/school_admin/*')) ? 'active' : ''}}" href="{{route('superadmin.school_admin.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('superadmin/review/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#review" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{__('SuperAdmin/backend.rating_review')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/review/*')) ? 'show' : ''}}" id="review">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/review/*')) ? 'active' : ''}}" href="{{route('superadmin.review.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{(request()->is('superadmin/enquiry/*')) ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#enquiry" aria-expanded="false" aria-controls="school_admin">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_enquiries')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse {{(request()->is('superadmin/enquiry/*')) ? 'show' : ''}}" id="enquiry">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{(request()->is('superadmin/enquiry/*')) ? 'active' : ''}}" href="{{url('superadmin/enquiry')}}">{{ __('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->is('superadmin/visa') || request()->is('superadmin/visa/create') ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#visas" aria-expanded="false" aria-controls="visas">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_formbuilder')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-form-select menu-icon"></i>
            </a>
            <div class="collapse {{request()->is('superadmin/visa') || request()->is('superadmin/visa/create') ? 'show' : ''}}" id="visas">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('superadmin/visa') ? 'active' : ''}}" href="{{url('superadmin/visa')}}">{{ __('SuperAdmin/dashboard.view')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('superadmin/visa/create') ? 'active' : ''}}" href="{{url('superadmin/visa/create')}}">{{ __('SuperAdmin/dashboard.formbuilder')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{request()->is('superadmin/visa_application') || request()->is('superadmin/view_visa_forms') ? 'active' : ''}}">
            <a class="nav-link" data-toggle="collapse" href="#visa_application" aria-expanded="false" aria-controls="visa_application">
                <span class="menu-title">{{__('SuperAdmin/backend.manage_visa')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-card-bulleted menu-icon"></i>
            </a>
            <div class="collapse {{request()->is('superadmin/visa_application') || request()->is('superadmin/view_visa_forms') ? 'show' : ''}}" id="visa_application">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('superadmin/visa_application') ? 'active' : ''}}" href="{{url('superadmin/visa_application/')}}">{{ __('SuperAdmin/dashboard.view')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->is('superadmin/visa_application/view_visa_forms') ? 'active' : ''}}" href="{{route('superadmin.view_visa_forms')}}">@lang('SuperAdmin/backend.view_visa_forms')</a>
                    </li>
                </ul>
            </div>
        </li>
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
        <li class="nav-item {{request()->is('superadmin/currency/*') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('superadmin.currency.index')}}">
                <span class="menu-title">{{__('SuperAdmin/backend.currency')}}</span>
                <i class="mdi mdi-currency-usd menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                <span class="menu-title">{{__('SuperAdmin/dashboard.settings')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-settings menu-icon"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.front_page.home')}}">{{__('SuperAdmin/dashboard.home_page')}}</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#front_pages" aria-expanded="false" aria-controls="front_pages">
                <span class="menu-title">{{__('SuperAdmin/dashboard.front_pages')}}</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-file-outline menu-icon"></i>
            </a>
            <div class="collapse" id="front_pages">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.front_page.home')}}">{{__('SuperAdmin/dashboard.home_page')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('superadmin.front_page.index')}}">{{__('SuperAdmin/dashboard.view')}}</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>