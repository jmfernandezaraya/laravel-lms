@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.home_page')}}
@endsection

@section('after_header')
    <!-- slider -->
    <div id="demo" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('public/frontend/assets/img/01.jpg')}}" alt="Los Angeles" width="1100" height="500">
                <div class="carousel-caption">
                    <h3 data-aos="fade-right">Lorem Ipsum is simply</h3>
                    <p data-aos="fade-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('public/frontend/assets/img/01.jpg')}}" alt="Chicago" width="1100" height="500">
                <div class="carousel-caption">
                    <h3 data-aos="fade-right">Lorem Ipsum is simply</h3>
                    <p data-aos="fade-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('public/frontend/assets/img/01.jpg')}}" alt="New York" width="1100" height="500">
                <div class="carousel-caption">
                    <h3 data-aos="fade-right">Lorem Ipsum is simply</h3>
                    <p data-aos="fade-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
    <!-- slider_end -->

    <!-- ======= Hero Section ======= -->
    <div class="s002">
        <form>
            <div class="inner-form">
                <div class="input-field second-wrap">
                    <div class="form-group">
                        <label for="choose-language">Choose Language</label>
                        <select class="form-control" id="choose-language">
                            <option>Please Choose</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-field second-wrap">
                    <div class="form-group">
                        <label for="choose-age">Your Age</label>
                        <select class="form-control" id="choose-age">
                            <option>Please Choose</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>

                <div class="input-field second-wrap">
                    <div class="form-group">
                        <label for="choose-country">Country</label>
                        <select class="form-control" id="choose-country">
                            <option>Please Choose</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>

                <div class="input-field second-wrap">
                    <div class="form-group">
                        <label for="choose-program-type">Program Type</label>
                        <select class="form-control" id="choose-program-type">
                            <option>Please Choose</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>

                <div class="input-field second-wrap">
                    <div class="form-group">
                        <label for="choose-study-mode">Study mode</label>
                        <select class="form-control" id="choose-study-mode">
                            @foreach($study_modes as $study_mode)
                                <option value="{{$study_mode->id}}">{{$study_mode->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-field third-wrap">
                    <div class="icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"></path>
                        </svg>
                    </div>
                    <input class="datepicker" id="return" type="text" placeholder="30 Aug 2018"/>
                </div>
                <div class="input-field fifth-wrap">
                    <a href="javascript:void(0);">
                        <button class="btn-search" type="button">SEARCH</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <!-- ======= Popular Courses Section ======= -->
    <section id="popular-courses" class="courses">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>school promotion</h2>
                <p>school promotion</p>
            </div>

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="course-item">
                        <img src="{{asset('public/frontend/assets/img/course-1.jpg')}}" class="img-fluid" alt="...">
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Lorem Ipsum</h4>
                                <p class="price">$39</p>
                            </div>

                            <h3><a href="course-details.html">Lorem Ipsum</a></h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text.</p>
                            <div class="trainer d-flex justify-content-between align-items-center">
                                <div class="trainer-rank d-flex align-items-center">
                                    <i class="bx bx-user"></i>&nbsp;50
                                    &nbsp;&nbsp;
                                    <i class="bx bx-heart"></i>&nbsp;65
                                </div>
                                <div class="trainer-profile d-flex align-items-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Course Item-->

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                    <div class="course-item">
                        <img src="{{asset('public/frontend/assets/img/course-1.jpg')}}" class="img-fluid" alt="...">
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="school.html"><h4>Lorem Ipsum</h4></a>
                                <p class="price">$70</p>
                            </div>

                            <h3><a href="course-details.html">Lorem Ipsum</a></h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text.</p>
                            <div class="trainer d-flex justify-content-between align-items-center">
                                <div class="trainer-rank d-flex align-items-center">
                                    <i class="bx bx-user"></i>&nbsp;50
                                    &nbsp;&nbsp;
                                    <i class="bx bx-heart"></i>&nbsp;65
                                </div>
                                <div class="trainer-profile d-flex align-items-center">
                                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i><i class="bx bxs-star-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Course Item-->

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                    <div class="course-item">
                        <img src="{{asset('public/frontend/assets/img/course-1.jpg')}}" class="img-fluid" alt="...">
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="school.html"><h4>Lorem Ipsum</h4></a>
                                <p class="price">$50</p>
                            </div>

                            <h3><a href="course-details.html">Lorem Ipsum</a></h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text.</p>
                            <div class="trainer d-flex justify-content-between align-items-center">
                                <div class="trainer-rank d-flex align-items-center">
                                    <i class="bx bx-user"></i>&nbsp;50
                                    &nbsp;&nbsp;
                                    <i class="bx bx-heart"></i>&nbsp;65
                                </div>
                                <div class="trainer-profile d-flex align-items-center">
                                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i><i class="bx bxs-star-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Course Item-->
            </div>
        </div>
    </section><!-- End Popular Courses Section -->

    <!-- ======= Trainers Section ======= -->

    <!-- ======= Popular Courses Section ======= -->
    <section id="popular-courses1" class="courses">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>popular country</h2>
                <p>popular country</p>
            </div>

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="course-item">
                        <img src="{{asset('public/frontend/assets/img/course-1.jpg')}}" class="img-fluid" alt="...">
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Lorem Ipsum</h4>
                                <!-- <p class="price">$39</p> -->
                            </div>

                            <h3><a href="course-details.html">Lorem Ipsum</a></h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text.</p>
                            <div class="trainer d-flex justify-content-between align-items-center">
                                <div class="trainer-rank d-flex align-items-center">
                                    <i class="bx bx-user"></i>&nbsp;50
                                    &nbsp;&nbsp;
                                    <i class="bx bx-heart"></i>&nbsp;65
                                </div>
                                <div class="trainer-profile d-flex align-items-center">
                                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i><i class="bx bxs-star-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Course Item-->

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                    <div class="course-item">
                        <img src="{{asset('public/frontend/assets/img/course-1.jpg')}}" class="img-fluid" alt="...">
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Lorem Ipsum</h4>
                                <!-- <p class="price">$70</p> -->
                            </div>

                            <h3><a href="course-details.html">Lorem Ipsum</a></h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text.</p>
                            <div class="trainer d-flex justify-content-between align-items-center">
                                <div class="trainer-rank d-flex align-items-center">
                                    <i class="bx bx-user"></i>&nbsp;50
                                    &nbsp;&nbsp;
                                    <i class="bx bx-heart"></i>&nbsp;65
                                </div>
                                <div class="trainer-profile d-flex align-items-center">
                                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i><i class="bx bxs-star-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Course Item-->

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                    <div class="course-item">
                        <img src="{{asset('public/frontend/assets/img/course-1.jpg')}}" class="img-fluid" alt="...">
                        <div class="course-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Lorem Ipsum</h4>
                                <!--  <p class="price">$50</p> -->
                            </div>

                            <h3><a href="course-details.html">Lorem Ipsum</a></h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text.</p>
                            <div class="trainer d-flex justify-content-between align-items-center">
                                <div class="trainer-rank d-flex align-items-center">
                                    <i class="bx bx-user"></i>&nbsp;50
                                    &nbsp;&nbsp;
                                    <i class="bx bx-heart"></i>&nbsp;65
                                </div>
                                <div class="trainer-profile d-flex align-items-center">
                                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                                    <i class="bx bxs-star"></i><i class="bx bxs-star-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Course Item-->
            </div>
        </div>
    </section><!-- End Popular Courses Section -->

    <!-- ======= Trainers Section ======= -->

    <!-- ======= Popular Courses Section ======= -->
    <section id="popular-courses2" class="courses">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>@lang('Frontend.popular_school')</h2>
                <p>@lang('Frontend.popular_school')</p>
            </div>

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                @foreach($schools as $school)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                        <div class="course-item">
                            <img src="{{$school->logo}}" class="img-fluid" alt="...">
                            <div class="course-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                </div>

                                <h3><a href="{{route('school.details', $school->id)}}">{{$school->name}}</a></h3>
                                <p>{!! ucfirst($school->about) !!}</p>
                                <div class="trainer d-flex justify-content-between align-items-center">
                                    <div class="trainer-rank d-flex align-items-center">
                                        <i class="bx bx-user"></i>&nbsp;{{$school->viewed_count}}
                                        @auth
                                            @if(!empty(auth()->user()->likedSchool))
                                                &nbsp;&nbsp;
                                                <i class="bx bxs-heart" data-school="{{$school->id}}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))"></i>&nbsp;{{auth()->user()->likedSchool()->count()}}
                                            @else
                                                &nbsp;&nbsp; <i data-school="{{$school->id}}" class="bx bx-heart" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))">&nbsp;{{auth()->user()->likedSchool()->count()}}</i>
                                            @endif
                                        @else
                                            &nbsp;&nbsp; <i data-school="{{$school->id}}"  onclick="like_school($(this).attr('data-school'), true)" style="cursor:pointer" class="bx bx-heart">&nbsp;{{\App\Models\Frontend\LikedSchool::count()}}</i>
                                        @endauth
                                    </div>
                                    <div class="trainer-profile d-flex align-items-center">
                                        <input type="hidden" name="rating" id="rating"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Course Item-->
                @endforeach
            </div> <!-- End Course Item-->
        </div>
    </section>
    <!-- ======= testimonial ======= -->

    @if(\Ghanem\Rating\Models\Rating::where('approved', true)->where('comments', '!=', null)->count() > 0)
        <div class="test-1">
            <div class="container">
                <div class="section-title">
                    <h2>@lang('Frontend.student_testimonial')</h2>
                    <p>@lang('Frontend.student_testimonial')</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="testimonial-slider" class="owl-carousel">
                            @foreach (\Ghanem\Rating\Models\Rating::where('approved', true)->where('comments', '!=', null)->get() as $rating)
                                <div class="testimonial">
                                    <div class="pic">
                                        <img src="{{asset('public/frontend/assets/img/student.png')}}">
                                    </div>
                                    <p class="description">
                                        {{$rating->comments}}
                                    </p>
                                    <div class="testimonial-profile">
                                        {{--   <h3 class="title">Lorem Ipsum is-</h3>
                                           <span class="post">Lorem Ipsum is</span>--}}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="owl-controls clickable">
                            <div class="owl-pagination">
                                <div class="owl-page">
                                    <span class=""></span>
                                </div>
                                <div class="owl-page active">
                                    <span class="">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- ======= testimonial-end ======= -->

    <div class="logo-2nd-last">
        <div class="container">
            <div class="section-title">
                <h2>our partners</h2>
                <p>our partners logos</p>
            </div>
            <div class="customer-logos slider">
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/luxury-letter-e-logo-design_1017-8903.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/football-logo-background_1195-244.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/3d-box-logo_1103-876.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/blue-tech-logo_1103-822.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/colors-curl-logo-template_23-2147536125.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/abstract-cross-logo_23-2147536124.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/football-logo-background_1195-244.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/background-of-spots-halftone_1035-3847.jpg">
                </div>
                <div class="slide">
                    <img src="//image.freepik.com/free-vector/retro-label-on-rustic-background_82147503374.jpg">
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            const choices = new Choices('[data-trigger]',
                {
                    searchEnabled: false,
                    itemSelectText: '',
                });
        </script>

        <script>
            $("#country_selector").countrySelect({
                preferredCountries: ['ca', 'gb', 'us']
            });
        </script>

        <script>
            try {
                fetch(new Request("//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", {
                    method: 'HEAD',
                    mode: 'no-cors'
                })).then(function (response) {
                    return true;
                }).catch(function (e) {
                    var carbonScript = document.createElement("script");
                    carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
                    carbonScript.id="_carbonads_js";
                    document.getElementById("carbon-block").appendChild(carbonScript);
                });
            } catch (error) {
                console.log(error);
            }
        </script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? '//ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <script>
            $(document).ready(function () {
                $("#testimonial-slider").owlCarousel({
                    items: 2,
                    itemsDesktop: [1000, 2],
                    itemsDesktopSmall: [979, 2],
                    itemsTablet: [768, 2],
                    itemsMobile: [650, 1],
                    pagination: true,
                    navigation: false,
                    slideSpeed: 1000,
                    autoPlay: true
                });
            });
        </script>

        <!------ Include the above in your HEAD tag ---------->
        <script>
            $(document).ready(function () {
                $('.customer-logos').slick({
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1500,
                    arrows: false,
                    dots: false,
                    pauseOnHover: false,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4
                        }
                    }, {
                        breakpoint: 520,
                        settings: {
                            slidesToShow: 3
                        }
                    }]
                });
            });

            function like_school(school_id, user_login_check=false)
            {
                if(user_login_check){
                    alert('Login First');
                }
                urlname="{{url('like_school')}}" + '/' +  school_id;
                $.get(urlname, {}, function(data){
                });
            }
        </script>
    @endsection
@endsection