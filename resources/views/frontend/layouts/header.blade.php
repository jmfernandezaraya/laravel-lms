<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        @if(\Session::has('error_message'))
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
                <li class="active"><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{url('about_us')}}">About Us</a></li>
                <li><a href="{{route('frontend.blog')}}">Blog</a></li>
                <li class="drop-down"><a href="#">More</a>
                    <ul>
                        <li><a href="{{url('how_to_apply')}}">@lang('Frontend.header.how_to_apply')</a></li>
                        <li><a href="{{route('frontend.visa')}}">@lang('Frontend.header.apply_for_visa')</a></li>
                    </ul>
                </li>

                <li><a href="{{route('contact-us-get')}}">@lang('Frontend.contact_us')</a></li>
                @auth
                    <li>
                        <form method="post" action="{{route('logout')}}">
                            @csrf
                            <button type="submit" style="border:none;background-color:#fff">@lang('Frontend.logout')</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{route('login')}}">Log In</a></li>
                @endauth

                <li>
                    <a href="#">
                        <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" class="img-fluid" alt="">English
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" class="img-fluid" alt="">Arabic
                    </a>
                </li>
            </ul>
        </nav><!-- .nav-menu -->
    </div>
</header>