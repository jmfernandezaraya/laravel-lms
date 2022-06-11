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
                <img src="{{ getHeaderLogo() ? getStorageImages('setting', getHeaderLogo()) : asset('public/frontend/assets/img/logo.png') }}" class="img-fluid" alt="">
            </a>
        </h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                @php $header_menu = getHeaderMenu(); @endphp
                @foreach ($header_menu as $header_menu_item)
                    @if (count($header_menu_item['sub_menu']))
                        <li class="drop-down">
                            <a href="#">
                                @if (app()->getLocale() == 'en')
                                    {{ $header_menu_item['label'] }}
                                @else
                                    {{ $header_menu_item['label_ar'] }}
                                @endif
                            </a>
                            <ul>
                                @foreach ($header_menu_item['sub_menu'] as $header_menu_sub)
                                    <li>
                                        <a href="{{ $header_menu_sub['type'] == 'page' ? getPageUrl($header_menu_sub['page']) : '' }}">
                                            @if ($header_menu_sub['type'] == 'page')
                                                {{ getPageTitle($header_menu_sub['page']) }}
                                            @else
                                                @if (app()->getLocale() == 'en')
                                                    {{ $header_menu_sub['label'] }}
                                                @else
                                                    {{ $header_menu_sub['label_ar'] }}
                                                @endif
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ $header_menu_item['type'] == 'page' ? getPageUrl($header_menu_item['page']) : '' }}">
                                @if ($header_menu_item['type'] == 'page')
                                    {{ getPageTitle($header_menu_item['page']) }}
                                @else
                                    @if (app()->getLocale() == 'en')
                                        {{ $header_menu_item['label'] }}
                                    @else
                                        {{ $header_menu_item['label_ar'] }}
                                    @endif
                                @endif
                            </a>
                        </li>
                    @endif
                @endforeach
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