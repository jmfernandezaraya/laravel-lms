@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.home_page')}}
@endsection

@section('after_header')
    <!-- Slider -->
    <div id="slider" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            @if (isset($content['heros']) && $content['heros'])
                @foreach ($content['heros'] as $hero_key => $hero)
                    <li data-target="#slider" data-slide-to="{{ $hero_key }}" class="{{ !$hero_key ? 'active' : '' }}"></li>
                @endforeach
            @endif
        </ul>
        <div class="carousel-inner">
            @if (isset($content['heros']) && $content['heros'])
                @foreach ($content['heros'] as $hero_key => $hero)
                    <div class="carousel-item {{!$hero_key ? 'active' : ''}}">
                        <img src="{{ $hero['background'] ? asset('storage/app/public/front_page/') . '/'. $hero['background'] : '' }}" alt="Los Angeles" width="1100" height="500">
                        <div class="carousel-caption">
                            <h3 data-aos="fade-right">{!! app()->getLocale() == 'en' ? $hero['title'] : $hero['title_ar'] !!}</h3>
                            <p data-aos="fade-left">{!! app()->getLocale() == 'en' ? $hero['text'] : $hero['text_ar'] !!}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <a class="carousel-control-prev" href="#slider" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#slider" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
    <!-- Slider -->

    <!-- ======= Search Form Section ======= -->
    <div class="search-section">
        @include('frontend.layouts.search-course')
    </div>
    <!-- End Search Form Section -->
@endsection

@section('content')
    <!-- ======= School Promotion Section ======= -->
    <section id="school_promotion" class="school-promotion">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>{{__('Frontend.school_promotion')}}</h2>
                <p>{{__('Frontend.school_promotion')}}</p>
            </div>

            <div class="school-list schools-style-promotion">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    @php $now = Carbon\Carbon::now()->format('Y-m-d') @endphp
                    @foreach ($schools as $school)
                        @if ($content && $content['school_promotions'] && in_array($school->id, $content['school_promotions']))
                            @php
                                $course = null;
                                $course_program = null;
                                foreach ($school->courses as $school_course) {
                                    foreach ($school_course->coursePrograms as $school_course_program) {
                                        if ($school_course_program->discount_per_week != ' -' && $school_course_program->discount_per_week != ' %' && 
                                            (($school_course_program->discount_start_date <= $now && $school_course_program->discount_end_date >= $now)
                                            || ($school_course_program->x_week_selected && $school_course_program->x_week_start_date <= $now && $school_course_program->x_week_end_date >= $now))) {
                                            $course = $school_course;
                                            $course_program = $school_course_program;
                                            $course_prgram_age_range = getCourseProgramAgeRange($course_program->program_age_range);
                                            break;
                                        }
                                    }
                                    if ($course_program) {
                                        break;
                                    }
                                }
                            @endphp
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <!-- School Item-->
                                <div class="school-item">
                                    <a href="{{route('school.details', $school->id)}}">
                                        <div class="school-logo" style="background-image: url('{{ $school->logo }}')"></div>
                                        @if ($course_program)
                                            <div class="program-content">
                                                <div class="price-discount">
                                                    @php
                                                        $course_program_discount = false;
                                                        $course_program_x_week_discount = false;
                                                        if (checkBetweenDate($course_program->discount_start_date, $course_program->discount_end_date, $now)) {
                                                            $course_program_discount = true;
                                                        }
                                                        if ($course_program->x_week_selected && checkBetweenDate($course_program->x_week_start_date, $course_program->x_week_end_date, $now)) {
                                                            $course_program_x_week_discount = true;
                                                        }
                                                    @endphp
                                                    <div class="price">
                                                        <span class="sale-price {{ ($course_program_discount || $course_program_x_week_discount) ? 'discounted-value' : '' }}">
                                                            {{ getCurrencyConvertedValue($course_program->course_unique_id, $course_program->program_cost) }}
                                                        </span>
                                                        <span>
                                                            @if ($course_program_discount || $course_program_x_week_discount)
                                                                - {{ getDiscountedValue(getCurrencyConvertedValue($course_program->course_unique_id, $course_program->program_cost), $course_program->discount_per_week) }}
                                                            @endif
                                                        </span>
                                                        <span>{{ getGetDefaultCurrencyName() }} {{__('Frontend.per_week')}}</span>
                                                    </div>
                                                    @if ($course_program_discount || $course_program_x_week_discount)
                                                        <div class="discount">
                                                            {{__('Frontend.discount')}}:&nbsp;
                                                            @if ($course_program->discount_per_week)
                                                                @if ($course_program_discount)
                                                                    @php
                                                                        $course_program_discount_per_weeks = explode(" ", $course_program->discount_per_week);
                                                                        $course_program_discount_per_week_value = $course_program_discount_per_weeks[0];
                                                                        $course_program_discount_per_week_symbol = count($course_program_discount_per_weeks) >= 2 ? $course_program_discount_per_weeks[1] : '';
                                                                    @endphp
                                                                    @if ($course_program_discount_per_week_symbol == '-')
                                                                        {{ $course_program_discount_per_week_symbol }}{{ $course_program_discount_per_week_value }} {{ getGetDefaultCurrencyName() }}
                                                                    @else
                                                                        {{ $course_program_discount_per_week_value }}{{ $course_program_discount_per_week_symbol }}
                                                                    @endif
                                                                @elseif ($course_program_x_week_discount)
                                                                    @if ($course_program->how_many_week_free == 1)
                                                                        {{__('Frontend.1_week_free')}}
                                                                    @elseif ($course_program->how_many_week_free == 2)
                                                                        {{__('Frontend.2_week_free')}}
                                                                    @elseif ($course_program->how_many_week_free == 3)
                                                                        {{__('Frontend.3_week_free')}}
                                                                    @elseif ($course_program->how_many_week_free == 4)
                                                                        {{__('Frontend.4_week_free')}}
                                                                    @endif
                                                                    {{__('Frontend.every')}} {{ $course_program->x_week_selected }} {{__('Frontend.per_week')}}
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="program-information">
                                                    <div class="program-name">{{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}</div>
                                                    <div class="program-lessons">{{__('Frontend.lessons_w')}}: {{ $course->lessons_per_week }} {{__('Frontend.lessons')}}</div>
                                                    <div class="program-hours">{{__('Frontend.hours_w')}}: {{ $course->hours_per_week }} {{__('Frontend.hours')}}</div>
                                                    <div class="program-level">{{__('Frontend.level_required')}}: {{ app()->getLocale() == 'en' ? $course->program_level : $course->program_level_ar }}</div>
                                                    <div class="program-age_range">{{__('Frontend.age_range')}}: {{ $course_prgram_age_range['min_age'] }} - {{ $course_prgram_age_range['max_age'] }}  {{__('Frontend.years')}}</div>
                                                </div>
                                            </div>
                                            <div class="school-content">
                                                <div class="school-information">
                                                    {{ $school->name ? (app()->getLocale() == 'en' ? ($school->name->name ?? '-') : ($school->name->name_ar ?? '-')) : '-' }}
                                                    / {{ app()->getLocale() == 'en' ? ($school->branch_name ?? '-') : ($school->branch_name_ar ?? '-') }}
                                                    / {{ $school->city ? (app()->getLocale() == 'en' ? ($school->city->name ?? '-') : ($school->city->name_ar ?? '-')) : '-' }}
                                                    / {{ $school->country ? (app()->getLocale() == 'en' ? ($school->country->name ?? '-') : ($school->country->name_ar ?? '-')) : '-' }}
                                                </div>
                                                <div class="school-users-loves-likes">
                                                    <div class="school-users-loves">
                                                        <i class="bx bx-show"></i>&nbsp;{{$school->viewed_count}}&nbsp;&nbsp;
                                                        @auth
                                                            @if (!empty(auth()->user()->likedSchool))
                                                                <i class="bx bxs-heart" data-school="{{ $school->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))"></i>&nbsp;{{ auth()->user()->likedSchool()->count() }}
                                                            @else
                                                                <i class="bx bx-heart" data-school="{{ $school->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))">&nbsp;{{ auth()->user()->likedSchool()->count() }}</i>
                                                            @endif
                                                        @else
                                                            <i class="bx bx-heart" data-school="{{ $school->id }}" onclick="like_school($(this).attr('data-school'), true)" style="cursor:pointer">&nbsp;{{ \App\Models\Frontend\LikedSchool::count() }}</i>
                                                        @endauth
                                                    </div>
                                                    <div class="school-likes">
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star"></i>
                                                        <i class="bx bxs-star-half"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <!-- End School Item-->
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End School Promotion Section -->

    <!-- ======= Popular Country Section ======= -->
    <section id="popular_country" class="popular-country">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>{{__('Frontend.popular_country')}}</h2>
                <p>{{__('Frontend.popular_country')}}</p>
            </div>

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                @if ($content && $content['popular_countries'])
                    @foreach ($content['popular_countries'] as $country)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                            <!-- Country Item-->
                            <div class="country-item">
                                <img src="{{ $country['logo'] ? asset('storage/app/public/front_page/') . '/'. $country['logo'] : '' }}" class="img-fluid" alt="Country Logo">
                                <div class="country-content">
                                    <div class="country-name">{{ getSchoolCountryName($country['id']) }}</div>
                                </div>
                            </div>
                            <!-- End Country Item-->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Popular Country Section -->

    <!-- ======= Popular School Section ======= -->
    <section id="popular-school" class="popular-school">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>{{__('Frontend.popular_school')}}</h2>
                <p>{{__('Frontend.popular_school')}}</p>
            </div>

            <div class="school-list schools-style-popular">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    @foreach($schools as $school)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                            <div class="school-item">
                                <a href="{{route('school.details', $school->id)}}">
                                    <div class="school-logo" style="background-image: url('{{ $school->logo }}')"></div>
                                    <div class="school-content">
                                        <div class="school-information">
                                            <a href="{{route('school.details', $school->id)}}">
                                                <div class="school-name-branch">{{ $school->name ? (app()->getLocale() == 'en' ? $school->name->name : $school->name->name_ar) : '' }} / {{ app()->getLocale() == 'en' ? $school->branch_name : $school->branch_name_ar }}</div>
                                                <div class="school-city">{{ $school->city ? (app()->getLocale() == 'en' ? $school->city->name : $school->city->name_ar) : '' }}</div>
                                                <div class="school-country">{{ $school->country ? (app()->getLocale() == 'en' ? $school->country->name : $school->country->name_ar) : '' }}</div>
                                            </a>
                                        </div>
                                        <div class="school-users-loves-likes">
                                            <div class="school-users-loves">
                                                <i class="bx bx-show"></i>&nbsp;{{$school->viewed_count}}&nbsp;&nbsp;
                                                @auth
                                                    @if (!empty(auth()->user()->likedSchool))
                                                        <i class="bx bxs-heart" data-school="{{ $school->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))"></i>&nbsp;{{ auth()->user()->likedSchool()->count() }}
                                                    @else
                                                        <i class="bx bx-heart" data-school="{{ $school->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))">&nbsp;{{ auth()->user()->likedSchool()->count() }}</i>
                                                    @endif
                                                @else
                                                    <i class="bx bx-heart" data-school="{{ $school->id }}" onclick="like_school($(this).attr('data-school'), true)" style="cursor:pointer">&nbsp;{{ \App\Models\Frontend\LikedSchool::count() }}</i>
                                                @endauth
                                            </div>
                                            <div class="school-likes">
                                                <i class="bx bxs-star"></i>
                                                <i class="bx bxs-star"></i>
                                                <i class="bx bxs-star"></i>
                                                <i class="bx bxs-star"></i>
                                                <i class="bx bxs-star-half"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div> <!-- End School Item-->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular School Section -->

    <!-- ======= Testimonial Section ======= -->
    @if(\Ghanem\Rating\Models\Rating::where('approved', true)->where('comments', '!=', null)->count() > 0)
        <div class="test-1">
            <div class="container">
                <div class="section-title">
                    <h2>{{__('Frontend.student_testimonial')}}</h2>
                    <p>{{__('Frontend.student_testimonial')}}</p>
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
                                    <span class=""></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End Testimonial Section -->

    <div class="logo-2nd-last">
        <div class="container">
            <div class="section-title">
                <h2>Our partners</h2>
                <p>Our partners logos</p>
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
            const choices = new Choices('[data-trigger]',
                {
                    searchEnabled: false,
                    itemSelectText: '',
                });
            $("#country_selector").countrySelect({
                preferredCountries: ['ca', 'gb', 'us']
            });
            
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
                        settings: { slidesToShow: 4 }
                    }, {
                        breakpoint: 520,
                        settings: { slidesToShow: 3 }
                    }]
                });
            });
        </script>
    @endsection
@endsection