@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.courses')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.courses')}}</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="search-section">
                @include('frontend.layouts.search-course')
            </div>

            <div class="school-filter">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-md-3 p-0">
                                <div class="form-group">
                                    <select onchange="filterSchoolCourse()" class="form-control" id="filter-city">
                                        <option value="">{{ __('Frontend.all_cities') }}</option>
                                        @foreach ($school_cities as $school_city)
                                            <option value="{{ $school_city }}">{{ $school_city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 p-0">
                                <div class="form-group">
                                    <select onchange="filterSchoolCourse()" class="form-control" id="filter-school">
                                        <option value="">{{ __('Frontend.all_schools') }}</option>
                                        @foreach ($school_names as $school_name)
                                            <option value="{{ $school_name }}">{{ $school_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 p-0">
                                <div class="form-group form-group-dropdown">
                                    <input type="hidden" id="filter-ranking" onchange="filterSchoolCourse()" />
                                    <button class="btn btn-default dropdown-toggle btn-select form-control" type="button" id="filter-ranking-select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        {{ __('Frontend.school_ranking') }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="filter-ranking-select">
                                        @foreach ($school_ratings as $school_rating)
                                            <li value="{{ $school_rating }}" onclick="changeRankingValue({{ $school_rating }})">
                                                <div class="score-wrap">
                                                    <span class="stars" style="width: {{ $school_rating * 20 }}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 p-0">
                                <div class="form-group">
                                    <label class="form-control">
                                        {{ __('Frontend.no_of_courses') }} | <span class="courses-count">{{ count($courses) }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="school-list schools-style-promotion border-bottom">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    @include('frontend.layouts.course-list')
                </div>
            </div>
        </div>
    </div>
    
    @section('js')
        <script>
            $(document).ready(function () {
                setTimeout(function() {
                    checkPreloader();
                }, 1000);
            });

            function checkPreloader() {
                if ($('#preloader').length) {
                    setTimeout(function() {
                        checkPreloader();
                    }, 1000);
                } else {
                    fillCourseSearchForm();
                }
            }

            function fillCourseSearchForm() {
                @if (isset($course_search->language) && $course_search->language)
                    $('#choose-language').val('').val('{{$course_search->language}}').trigger('change');
                @endif
            }
            
            function callbackSearchCourse(type) {
                if (type == 'age') {
                    @if (isset($course_search->age) && $course_search->age)
                        $('#choose-age').val('').val('{{$course_search->age}}').trigger('change');
                    @endif
                } else if (type == 'country') {
                    @if (isset($course_search->country) && $course_search->country)
                        $('#choose-country').val('').val('{{$course_search->country}}').trigger('change');
                    @endif
                } else if (type == 'program-type') {
                    @if (isset($course_search->program_type) && $course_search->program_type)
                        $('#choose-program-type').val('').val('{{$course_search->program_type}}').trigger('change');
                    @endif
                } else if (type == 'study-mode') {
                    @if (isset($course_search->study_mode) && $course_search->study_mode)
                        $('#choose-study-mode').val('').val('{{$course_search->study_mode}}').trigger('change');
                    @endif
                } else if (type == 'city') {
                    @if (isset($course_search->city) && $course_search->city)
                        $('#choose-city').val('').val('{{$course_search->city}}').trigger('change');
                    @endif
                } else if (type == 'program-name') {
                    @if (isset($course_search->program_name) && $course_search->program_name)
                        $('#choose-program-name').val('').val('{{$course_search->program_name}}').trigger('change');
                    @endif
                }
            }

            function changeRankingValue(value) {
                $('#filter-ranking').val(value);
            }

            function filterSchoolCourse() {
                var filter_city = $('#filter-city').val();
                var filter_school = $('#filter-school').val();
                var filter_ranking = $('#filter-ranking').val();
                var filtered_courses = 0;
                $('.school-list .school-item').each(function() {
                    var item_display = true;
                    if (filter_city && $(this).data('city') != filter_city) item_display = false;
                    if (filter_school && $(this).data('school') != filter_school) item_display = false;
                    if (filter_ranking && $(this).data('ranking') != filter_ranking) item_display = false;
                    if (item_display) {
                        $(this).parent().closest('div').removeClass('hide');
                        filtered_courses = filtered_courses + 1;
                    } else {
                        $(this).parent().closest('div').addClass('hide');
                    }
                });
                $('.courses-count').html(filtered_courses);
            }
        </script>
    @endsection
@endsection