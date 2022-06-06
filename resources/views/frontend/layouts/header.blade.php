<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        @if (\Session::has('error_message'))
            @php
                $alert = session()->get('error_message');
                echo "<script>alert('$alert')</script>";
            @endphp
        @endif
        <h1 class="logo mr-auto">
            <a href="{{ url('/') }}">
                <img src="{{ asset('public/frontend/assets/img/logo.png') }}" class="img-fluid" alt="">
            </a>
        </h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="{{ url('/') }}">{{__('Frontend.home')}}</a></li>
                <li class="drop-down">
                    <a href="#">{{__('Frontend.our_services')}}</a>
                    <ul>
                        <li><a href="{{ route('frontend.course') }}">{{__('Frontend.apply_for_program')}}</a></li>
                        <li><a href="{{ route('frontend.visa') }}">{{__('Frontend.apply_for_visa')}}</a></li>
                        <li><a href="{{ url('how_to_apply') }}">{{__('Frontend.how_to_apply')}}</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('about_us') }}">{{__('Frontend.about_us')}}</a></li>
                <li><a href="{{ route('contact-us-get') }}">{{__('Frontend.contact_us')}}</a></li>
                <li><a href="{{ route('contact-us-get') }}">{{__('Frontend.why_book_with_us')}}</a></li>
                <li><a href="{{ route('frontend.blog') }}">{{__('Frontend.blog')}}</a></li>
                <li class="drop-down">
                    <a href="#">
                        @if (app()->getLocale() == 'en')
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" class="img-fluid" alt="">{{__('Frontend.english')}}
                        @else
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" class="img-fluid" alt="">{{__('Frontend.arabic')}}
                        @endif
                    </a>
                    <ul>
                        <li>
                            @if (app()->getLocale() == 'en')
                                <a href="{{route('change_lang', 'ar')}}">
                                    <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" class="img-fluid" alt="">{{__('Frontend.arabic')}}
                                </a>
                            @else
                                <a href="{{route('change_lang', 'en')}}">
                                    <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" class="img-fluid" alt="">{{__('Frontend.english')}}
                                </a>
                            @endif
                        </li>
                    </ul>
                </li>
                <li class="drop-down">
                    <a href="#"><i class="bx bx-user"></i></a>
                    <ul>
                        @auth
                            <li>
                                <a href="{{route('dashboard')}}"><i class="bx bx-home"></i>&nbsp;{{__('Frontend.dashboard')}}</a>
                            </li>
                            <li>
                                <form method="post" action="{{route('logout')}}">
                                    @csrf                                    
                                    <i class="bx bx-log-out"></i>&nbsp;<button type="submit">{{__('Frontend.logout')}}</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{route('login')}}"><i class="bx bx-log-in"></i>&nbsp;{{__('Frontend.login')}}</a></li>
                            <li><a href="{{route('register_user')}}"><i class="bx bx-user-plus"></i>&nbsp;{{__('Frontend.register')}}</a></li>
                        @endauth
                    </ul>
                </li>
            </ul>
        </nav><!-- .nav-menu -->
    </div>
</header>