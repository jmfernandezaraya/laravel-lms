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
            <a href="{{url('/')}}">
                <img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="">
            </a>
        </h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="{{url('/')}}">{{__('Frontend.home')}}</a></li>
                <li><a href="{{url('about_us')}}">{{__('Frontend.about_us')}}</a></li>
                <li><a href="{{route('frontend.blog')}}">{{__('Frontend.blog')}}</a></li>
                <li class="drop-down"><a href="#">{{__('Frontend.more')}}</a>
                    <ul>
                        <li><a href="{{url('how_to_apply')}}">{{__('Frontend.header.how_to_apply')}}</a></li>
                        <li><a href="{{route('frontend.visa')}}">{{__('Frontend.header.apply_for_visa')}}</a></li>
                    </ul>
                </li>

                <li><a href="{{route('contact-us-get')}}">{{__('Frontend.contact_us')}}</a></li>
                @auth
                    <li><a href="{{route('dashboard')}}">{{__('Frontend.dashboard')}}</a></li>
                    <li>
                        <form method="post" action="{{route('logout')}}">
                            @csrf
                            <button type="submit">{{__('Frontend.logout')}}</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{route('login')}}">{{__('Frontend.login')}}</a></li>
                @endauth

                <li>
                    <a href="{{route('change_lang', 'en')}}">
                        <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" class="img-fluid" alt="">{{__('Frontend.english')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('change_lang', 'ar')}}">
                        <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" class="img-fluid" alt="">{{__('Frontend.arabic')}}
                    </a>
                </li>
            </ul>
        </nav><!-- .nav-menu -->
    </div>
</header>