@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.country')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{ url('/') }}" class="breadcrumb-home">
            <i class="bx bx-home"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.country')}}</h1>
    </div>
@endsection

@section('content')
    <!-- ======= Age Section ======= -->
    <section id="age-selection" class="age-selection">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-lg-4">
                    <div class="section-title">
                        <h2>{{__('Frontend.age')}}</h2>
                    </div>

                    <select class="form-control" id="ages">
                        @foreach ($ages as $age)
                            <option value="{{ $age }}">{{ $age }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular School Section -->

    <!-- ======= Schools Section ======= -->
    <section id="schools" class="schools">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>{{__('Frontend.schools')}}</h2>
            </div>

            <div class="school-list schools-style-popular">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    @foreach($schools as $school)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                            <div class="school-item">
                                <a href="{{route('frontend.school.details', $school->id)}}">
                                    <div class="school-logo" style="background-image: url('{{ $school->logo }}')"></div>
                                    <div class="school-content">
                                        <div class="school-information">
                                            <a href="{{route('frontend.school.details', $school->id)}}">
                                                <div class="school-name-branch">{{ $school->name ? (app()->getLocale() == 'en' ? $school->name->name : $school->name->name_ar) : '' }}{{ app()->getLocale() == 'en' ? ($school->branch_name ? ' / ' . $school->branch_name : '') : ($school->branch_name_ar ? ' / ' . $school->branch_name_ar : '') }}</div>
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
    
    <!-- ======= Courses Section ======= -->
    <section id="courses" class="courses">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>{{__('Frontend.courses')}}</h2>
            </div>
            
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                @foreach ($courses as $course)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                        <!-- School Item-->
                        @php $course_ratings = getCourseRating($course->unique_id); @endphp
                        <div class="school-item"
                            data-city="{{ $course->school->city ? (app()->getLocale() == 'en' ? ($course->school->city->name ?? '-') : ($course->school->city->name_ar ?? '-')) : '-' }}"
                            data-school="{{ $course->school->name ? (app()->getLocale() == 'en' ? ($course->school->name->name ?? '-') : ($course->school->name->name_ar ?? '-')) : '-' }}"
                            data-city="{{ $course_ratings }}"
                        >
                            <a href="{{route('frontend.course.single', ['school_id' => $course->school->id, 'program_id' => $course->unique_id])}}">
                                <div class="school-logo" style="background-image: url('{{ $course->school->logo }}')"></div>
                                @if ($course->course_program)
                                    <div class="program-content">
                                        <div class="price-discount">
                                            @php
                                                $course_program_discount = false;
                                                $course_program_x_week_discount = false;
                                                if (checkBetweenDate($course->course_program->discount_start_date, $course->course_program->discount_end_date, $now)) {
                                                    $course_program_discount = true;
                                                }
                                                if ($course->course_program->x_week_selected && checkBetweenDate($course->course_program->x_week_start_date, $course->course_program->x_week_end_date, $now)) {
                                                    $course_program_x_week_discount = true;
                                                }
                                            @endphp
                                            <div class="price">
                                                <span class="sale-price {{ ($course_program_discount || $course_program_x_week_discount) ? 'discounted-value' : '' }}">
                                                    {{ getCurrencyConvertedValue($course->course_program->course_unique_id, $course->course_program->program_cost) }}
                                                </span>
                                                <span>
                                                    @if ($course_program_discount || $course_program_x_week_discount)
                                                        - {{ getDiscountedValue(getCurrencyConvertedValue($course->course_program->course_unique_id, $course->course_program->program_cost), $course->course_program->discount_per_week) }}
                                                    @endif
                                                </span>
                                                <span>{{ getGetDefaultCurrencyName() }} {{__('Frontend.per_week')}}</span>
                                            </div>
                                            @if ($course_program_discount || $course_program_x_week_discount)
                                                <div class="discount">
                                                    {{__('Frontend.discount')}}:&nbsp;
                                                    @if ($course->course_program->discount_per_week)
                                                        @if ($course_program_discount)
                                                            @php
                                                                $course_program_discount_per_weeks = explode(" ", $course->course_program->discount_per_week);
                                                                $course_program_discount_per_week_value = $course_program_discount_per_weeks[0];
                                                                $course_program_discount_per_week_symbol = count($course_program_discount_per_weeks) >= 2 ? $course_program_discount_per_weeks[1] : '';
                                                            @endphp
                                                            @if ($course_program_discount_per_week_symbol == '-')
                                                                {{ $course_program_discount_per_week_symbol }}{{ $course_program_discount_per_week_value }} {{ getGetDefaultCurrencyName() }}
                                                            @else
                                                                {{ $course_program_discount_per_week_value }}{{ $course_program_discount_per_week_symbol }}
                                                            @endif
                                                        @elseif ($course_program_x_week_discount)
                                                            @if ($course->course_program->how_many_week_free == 1)
                                                                {{__('Frontend.1_week_free')}}
                                                            @elseif ($course->course_program->how_many_week_free == 2)
                                                                {{__('Frontend.2_week_free')}}
                                                            @elseif ($course->course_program->how_many_week_free == 3)
                                                                {{__('Frontend.3_week_free')}}
                                                            @elseif ($course->course_program->how_many_week_free == 4)
                                                                {{__('Frontend.4_week_free')}}
                                                            @endif
                                                            {{__('Frontend.every')}} {{ $course->course_program->x_week_selected }} {{__('Frontend.per_week')}}
                                                        @endif
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="program-information">
                                            <div class="program-name">
                                                {{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}
                                            </div>
                                            <div class="program-lessons">{{__('Frontend.lessons_w')}}: {{ $course->lessons_per_week }} {{__('Frontend.lessons')}}</div>
                                            <div class="program-hours">{{__('Frontend.hours_w')}}: {{ $course->hours_per_week }} {{__('Frontend.hours')}}</div>
                                            <div class="program-level">{{__('Frontend.level_required')}}: {{ app()->getLocale() == 'en' ? $course->program_level : $course->program_level_ar }}</div>
                                            <div class="program-age_range">{{__('Frontend.age_range')}}: {{ $course->age_range['min_age'] }} - {{ $course->age_range['max_age'] }}  {{__('Frontend.years')}}</div>
                                        </div>
                                    </div>
                                    <div class="school-content">
                                        <div class="school-information">
                                            {{ $course->school->name ? (app()->getLocale() == 'en' ? ($course->school->name->name ?? '') : ($course->school->name->name_ar ?? '')) : '' }}
                                            {{ app()->getLocale() == 'en' ? ($course->school->branch_name ? ' / ' . $course->school->branch_name : '') : ($course->school->branch_name_ar ? ' / ' . $course->school->branch_name : '') }}
                                            {{ $course->school->city ? (app()->getLocale() == 'en' ? ($course->school->city->name ? ' / ' . $course->school->city->name : '') : ($course->school->city->name_ar ? ' / ' . $course->school->city->name_ar : '')) : '' }}
                                            {{ $course->school->country ? (app()->getLocale() == 'en' ? ($course->school->country->name ? ' / ' . $course->school->country->name : '') : ($course->school->country->name_ar ? ' / ' . $course->school->country->name_ar : '')) : '' }}
                                        </div>
                                        <div class="school-users-loves-likes">
                                            <div class="school-users-loves">
                                                <i class="bx bx-show"></i>&nbsp;{{$course->school->viewed_count}}&nbsp;&nbsp;
                                                @auth
                                                    @if (!empty(auth()->user()->likedSchool))
                                                        <i class="bx bxs-heart" data-school="{{ $course->school->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))"></i>&nbsp;{{ auth()->user()->likedSchool()->count() }}
                                                    @else
                                                        <i class="bx bx-heart" data-school="{{$course->school->id}}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))">&nbsp;{{ auth()->user()->likedSchool()->count() }}</i>
                                                    @endif
                                                @else
                                                    <i class="bx bx-heart" data-school="{{ $course->school->id }}" onclick="like_school($(this).attr('data-school'), true)" style="cursor:pointer">&nbsp;{{ \App\Models\Frontend\LikedSchool::count() }}</i>
                                                @endauth
                                            </div>
                                            <div class="score-wrap">
                                                <span class="stars" style="width: {{$course_ratings * 20}}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <!-- End School Item-->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Popular School Section -->
    
    @section('js')
        <script>
            var go_country_page_url = "{{ route('frontend.country.page', ['id' => $id]) }}";
            $(document).ready(function () {
                $('#ages').change(function() {
                    window.location.href = go_country_page_url + '/?age=' + $(this).val();
                });
            });
        </script>
    @endsection
@endsection