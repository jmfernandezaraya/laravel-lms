@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.school_details')}}
@endsection

@section('after_header')
    <!-- slider -->
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div id="tabsJustifiedContent" class="tab-content">
                    <div id="schoolPhotos" class="tab-pane fade active show">
                        <div id="schoolPhotoCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach((array)$school->multiple_photos as $photos)
                                    <li data-target="#schoolPhotoCarousel" data-slide-to="{{$loop->iteration - 1}}" class="{{$loop->iteration - 1 == 0? 'active' : ''}}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach((array)$school->multiple_photos as $photos)
                                    <div class="carousel-item {{$loop->iteration == 1 ?  'active' : '' }}">
                                        <img class="d-block w-100" src="{{asset('storage/app/public/school_images/'. $photos)}}" alt="First slide">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#schoolPhotoCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">{{__('Frontend.previous')}}</span>
                            </a>
                            <a class="carousel-control-next" href="#schoolPhotoCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">{{__('Frontend.next')}}</span>
                            </a>
                        </div>
                    </div>
                    <div id="schoolVideos" class="tab-pane fade">
                        <div class="row pb-2">
                            <div id="schoolVideoCarousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ((array)$school->video as $video)
                                        <li data-target="#schoolVideoCarousel" data-slide-to="{{$loop->iteration - 1}}" class="{{$loop->iteration - 1 == 0 ? 'active' : ''}}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ((array)$school->video as $video)
                                        <div class="carousel-item {{$loop->iteration == 1 ? 'active' : ''}}">
                                            <iframe src="{{ $video }}" height="500"></iframe>                                            
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#schoolVideoCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">{{__('Frontend.previous')}}</span>
                                </a>
                                <a class="carousel-control-next" href="#schoolVideoCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">{{__('Frontend.next')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <ul id="tabsJustified" class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <a href="" data-target="#schoolPhotos" data-toggle="tab" class="nav-link small text-uppercase active">{{__('Frontend.photos')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#schoolVideos" data-toggle="tab" class="nav-link small text-uppercase">{{__('Frontend.video')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- slider_end -->
    <!-- ======= Hero Section ======= -->
@endsection

@section('content')
    <div class="courses">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-right mt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="school-logo">
                                    <img src="{{ $school->logo }}" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="school-name">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="border-none" scope="row">
                                                    <p>{{ucfirst($school->name ? (app()->getLocale() == 'en' ? $school->name->name : $school->name->name_ar) : '-')}}{{app()->getLocale() == 'en' ? ($school->branch_name ? ' - ' . $school->branch_name : '') : ($school->branch_name_ar ? ' - ' . $school->branch_name_ar : '')}}</p>
                                                    <span class="city">{{$school->city ? (app()->getLocale() == 'en' ? $school->city->name : $school->city->name_ar) : '-'}},</span>
                                                    <p><span class="country">{{$school->country ? (app()->getLocale() == 'en' ? $school->country->name : $school->country->name_ar) : '-'}}</span></p>
                                                    <ul class="custom">
                                                        @for($i = 1; $i <=5; $i ++)
                                                            <li data-toggle="modal" data-target="#myModal" class="dynamic_starli" onclick="save_rating({{$i}})" onmouseover="highlightStar(this);" onClick="addRating(this);" id="rating{{$i}}">★</li>
                                                        @endfor
                                                        ({{round($school->avgRating())}})
                                                    </ul>
                                                </th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Frontend.school_opening_hours')}}</th>
                                                <td>{{app()->getLocale() == 'en' ? $school->opening_hours : $school->opening_hours_ar}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Frontend.school_capacity')}}</th>
                                                <td>{{$school->capacity}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Frontend.number_of_classrooms')}}</th>
                                                <td>{{$school->opening_hours}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Frontend.class_size')}}</th>
                                                <td>{{app()->getLocale() == 'en' ? $school->class_size : $school->class_size_ar}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{__('Frontend.year_is_established')}}</th>
                                                <td>{{$school->opened}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                @if ($school->nationalities && count($school->nationalities))
                                    <div class="nationality-mix border-bottom">
                                        <h5 class="text-center best">{{__('Frontend.nationality_mix')}}</h5>
                                        <div class="nationality-mix-chart">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    @foreach ($school->nationalities as $school_nationality)
                                                        <tr>
                                                            <td>{{ $school_nationality->nationality ? $school_nationality->nationality->name : '' }}</td>
                                                            <td><div style="width: {{ $school_nationality->mix }}%"></div></td>
                                                            <td>{{ $school_nationality->mix }}%</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                <div class="about-school border-bottom mt-2">
                                    <h5 class="best">{{__('Frontend.last_updated')}}</h5>
                                    <div class="m-0">{{ $school->updated_at->format('Y-m-d') }}</div>
                                </div>

                                <div class="about-school border-bottom mt-2">
                                    <h5 class="best">{{__('Frontend.about_the_school')}}</h5>
                                    <div class="m-0">{!! app()->getLocale() == 'en' ? $school->about : $school->about_ar !!}</div>
                                </div>

                                <div class="Facility border-bottom">
                                    <h5 class="best">{{__('Frontend.facilities')}}</h5>
                                    <div class="m-0">{!! app()->getLocale() == 'en' ? $school->facilities : $school->facilities_ar !!}</div>
                                </div>

                                @if ($school->logos)
                                    <div class="accreditations_memberships border-bottom p-3">
                                        <h5 class="best">{{__('Frontend.accreditations_memberships')}}</h5>
                                        <section class="customer-logos slider">
                                            @foreach($school->logos as $logoss)
                                                <div class="slide">
                                                    <img src="{{ asset('storage/app/public/school_images/' . $logoss) }}">
                                                </div>
                                            @endforeach
                                        </section>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="program-hd mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-center">{{__('Frontend.programs')}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-5 col-form-label text-right pr-0">{{__('Frontend.choose_language')}}</label>
                            <div class="col-sm-7">
                                <select onchange="get_program($(this).val())" name="choose_language" class="form-control" id="choose_language">
                                    @foreach($languages as $language)
                                        <option value="{{$language->unique_id}}">{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-5 col-form-label text-right pr-0">{{__('Frontend.study_mode')}}</label>
                            <div class="col-sm-7">
                                <select onchange="get_program($(this).val())" name="study_mode" class="form-control" id="study_mode">
                                    @foreach($study_modes as $study_mode)
                                        <option value="{{$study_mode->unique_id}}">{{$study_mode->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-5 col-form-label text-right pr-0">{{__('Frontend.your_age')}}</label>
                            <div class="col-sm-7">
                                <select onchange="get_program($(this).val())" name="your_age" class="form-control" id="your_age">
                                    @foreach($age_ranges as $age_range)
                                        <option value="{{$age_range->unique_id}}">{{$age_range->age}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="program"></div>

            <div class="school-reviews-overview border-bottom mt-3">
                <h5 class="best">{{__('Frontend.reviews')}}</h5>
                <p class="m-0">{{__('Frontend.100_recommend')}}</p>
                @php
                    $school_top_review_rating_count = 0;
                    $school_top_review_ratings = 0;
                    $school_top_review_quality_teachings = 0;
                    $school_top_review_school_facilities = 0;
                    $school_top_review_social_activities = 0;
                    $school_top_review_school_locations = 0;
                    $school_top_review_satisfied_teachings = 0;
                    $school_top_review_five_scores = 0;
                    $school_top_review_four_scores = 0;
                    $school_top_review_three_scores = 0;
                    $school_top_review_two_scores = 0;
                    $school_top_review_one_scores = 0;
                @endphp
                @foreach ($school_top_review_course_applications as $school_top_review_course_application)
                    @php
                        $school_top_review_rating = ($school_top_review_course_application->review->quality_teaching + $school_top_review_course_application->review->school_facilities + $school_top_review_course_application->review->social_activities + 
                            $school_top_review_course_application->review->school_location + $school_top_review_course_application->review->satisfied_teaching + $school_top_review_course_application->review->level_cleanliness + 
                            $school_top_review_course_application->review->distance_accommodation_school + $school_top_review_course_application->review->satisfied_accommodation + $school_top_review_course_application->review->airport_transfer + 
                            $school_top_review_course_application->review->city_activities) / 10;
                        $school_top_review_ratings += $school_top_review_rating;
                        $school_top_review_quality_teachings += $school_top_review_course_application->review->quality_teaching;
                        $school_top_review_school_facilities += $school_top_review_course_application->review->school_facilities;
                        $school_top_review_social_activities += $school_top_review_course_application->review->social_activities;
                        $school_top_review_school_locations += $school_top_review_course_application->review->school_location;
                        $school_top_review_satisfied_teachings += $school_top_review_course_application->review->satisfied_teaching;
                        if ($school_top_review_rating == 5) $school_top_review_five_scores += 1;
                        if ($school_top_review_rating < 5 && $school_top_review_rating >= 4) $school_top_review_four_scores += 1;
                        if ($school_top_review_rating < 4 && $school_top_review_rating >= 3) $school_top_review_three_scores += 1;
                        if ($school_top_review_rating < 3 && $school_top_review_rating >= 2) $school_top_review_two_scores += 1;
                        if ($school_top_review_rating < 2 && $school_top_review_rating >= 1) $school_top_review_one_scores += 1;
                    @endphp
                @endforeach
                @if ($school_top_review_course_applications && count($school_top_review_course_applications))
                    @php
                        $school_top_review_rating_count = count($school_top_review_course_applications);
                        $school_top_review_ratings = $school_top_review_ratings / $school_top_review_rating_count;
                        $school_top_review_quality_teachings = $school_top_review_quality_teachings / $school_top_review_rating_count;
                        $school_top_review_school_facilities = $school_top_review_school_facilities / $school_top_review_rating_count;
                        $school_top_review_social_activities = $school_top_review_social_activities / $school_top_review_rating_count;
                        $school_top_review_school_locations = $school_top_review_school_locations / $school_top_review_rating_count;
                        $school_top_review_satisfied_teachings = $school_top_review_satisfied_teachings / $school_top_review_rating_count;
                    @endphp
                @endif
                <div class="score-wrap">
                    <span class="stars" style="width: {{$school_top_review_ratings * 20}}%">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </span>
                    <span>{{__('Frontend.based_on_five_reviews')}}</span>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>{{__('Frontend.five_stars')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $school_top_review_rating_count ? $school_top_review_five_scores / $school_top_review_rating_count * 100 :  0 }}%" aria-valuenow="{{ $school_top_review_rating_count ? $school_top_review_five_scores / $school_top_review_rating_count * 100 :  0 }}" aria-valuemin="0" aria-valuemax="100">{{ $school_top_review_five_scores }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>{{__('Frontend.quality_of_teaching')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="score-wrap">
                            <span class="stars" style="width: {{$school_top_review_quality_teachings * 20}}%">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>{{__('Frontend.four_stars')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $school_top_review_rating_count ? $school_top_review_four_scores / $school_top_review_rating_count * 100 :  0 }}%" aria-valuenow="{{ $school_top_review_rating_count ? $school_top_review_four_scores / $school_top_review_rating_count * 100 :  0 }}" aria-valuemin="0" aria-valuemax="100">{{ $school_top_review_four_scores }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>{{__('Frontend.school_facilities')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="score-wrap">
                            <span class="stars" style="width: {{$school_top_review_school_facilities * 20}}%">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>{{__('Frontend.three_stars')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $school_top_review_rating_count ? $school_top_review_three_scores / $school_top_review_rating_count * 100 :  0 }}%" aria-valuenow="{{ $school_top_review_rating_count ? $school_top_review_three_scores / $school_top_review_rating_count * 100 :  0 }}" aria-valuemin="0" aria-valuemax="100">{{ $school_top_review_three_scores }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>{{__('Frontend.social_activities')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="score-wrap">
                            <span class="stars" style="width: {{$school_top_review_social_activities * 20}}%">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>{{__('Frontend.two_stars')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $school_top_review_rating_count ? $school_top_review_two_scores / $school_top_review_rating_count * 100 :  0 }}%" aria-valuenow="{{ $school_top_review_rating_count ? $school_top_review_two_scores / $school_top_review_rating_count * 100 :  0 }}" aria-valuemin="0" aria-valuemax="100">{{ $school_top_review_two_scores }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>{{__('Frontend.school_location')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="score-wrap">
                            <span class="stars" style="width: {{$school_top_review_school_locations * 20}}%">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>{{__('Frontend.one_stars')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $school_top_review_rating_count ? $school_top_review_one_scores / $school_top_review_rating_count * 100 :  0 }}%" aria-valuenow="{{ $school_top_review_rating_count ? $school_top_review_one_scores / $school_top_review_rating_count * 100 :  0 }}" aria-valuemin="0" aria-valuemax="100">{{ $school_top_review_one_scores }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>{{__('Frontend.satisfied_teaching')}}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="score-wrap">
                            <span class="stars" style="width: {{$school_top_review_satisfied_teachings * 20}}%">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="school-reviews mt-3 border-bottom">
                @foreach ($school_top_review_course_applications as $school_top_review_course_application)
                    @php
                        $school_top_review_rating = ($school_top_review_course_application->review->quality_teaching + $school_top_review_course_application->review->school_facilities + $school_top_review_course_application->review->social_activities + 
                            $school_top_review_course_application->review->school_location + $school_top_review_course_application->review->satisfied_teaching + $school_top_review_course_application->review->level_cleanliness + 
                            $school_top_review_course_application->review->distance_accommodation_school + $school_top_review_course_application->review->satisfied_accommodation + $school_top_review_course_application->review->airport_transfer + 
                            $school_top_review_course_application->review->city_activities) / 10;
                    @endphp
                    <div class="score-wrap">
                        <span class="stars" style="width: {{$school_top_review_rating * 20}}%">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p class="city mb-0 mt-1">{{ $school->city ? (app()->getLocale() == 'en' ? $school->city->name : $school->city->name_ar) : '-'}}, {{$school->country ? (app()->getLocale() == 'en' ? $school->country->name : $school->country->name_ar) : '-' }}</p>
                    <h6 class="best">{{__('Frontend.my_ratings_for_this_school')}}</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <p>{{__('Frontend.quality_of_teaching')}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="score-wrap">
                                <span class="stars" style="width: {{$school_top_review_course_application->review->quality_teaching * 20}}%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>{{__('Frontend.duration_of_study')}}</p>
                        </div>
                        <div class="col-md-3">
                            <p>{{ $school_top_review_course_application->program_duration }} {{__('Frontend.weeks')}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p>{{__('Frontend.school_facilities')}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="score-wrap">
                                <span class="stars" style="width: {{$school_top_review_course_application->review->school_facilities * 20}}%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>{{__('Frontend.date_of_study')}}</p>
                        </div>
                        <div class="col-md-3">
                            <p>{{ $school_top_review_course_application->start_date ? date('d M Y', strtotime($school_top_review_course_application->start_date)) : '' }} - {{ $school_top_review_course_application->end_date ? date('d M Y', strtotime($school_top_review_course_application->end_date)) : '' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p>{{__('Frontend.social_activities')}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="score-wrap">
                                <span class="stars" style="width: {{$school_top_review_course_application->review->social_activities * 20}}%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>{{__('Frontend.would_you_recommend_this_school')}}</p>
                        </div>
                        <div class="col-md-3">
                            <p>{{ $school_top_review_course_application->recommend_this_school ? __('Frontend.yes') : __('Frontend.no') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p>{{__('Frontend.school_location')}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="score-wrap">
                                <span class="stars" style="width: {{$school_top_review_course_application->review->school_location * 20}}%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p>{{__('Frontend.use_my_full_name_for_the_rating_and_review')}}</p>
                        </div>
                        <div class="col-md-3">
                            <p>{{ $school_top_review_course_application->use_full_name ? __('Frontend.yes') : __('Frontend.no') }}</p>
                        </div>
                    </div>
                @endforeach
                <p>{{__('Frontend.verified_review_student_has_booked')}}</p>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <!--Google map-->
                    <div id="map-container-google-2" class="z-depth-1-half map-container" style="height: 400px; width: 100%;">
                        @if (str_contains($school->address, "<iframe"))
                            {!! $school->address !!}
                        @else
                            <iframe src="{!! $school->address !!}" frameborder="0" style="border:0; width: 100% !important; height: 400px;" allowfullscreen></iframe>
                        @endif
                    </div>
                    <!--Google Maps-->
                </div>
            </div>

            <!-- ======= School Branches Section ======= -->
            @if ($school_branches && count($school_branches))
                <section id="school-branches" class="school-branches" data-aos="fade-up">
                    <h5 class="best">{{__('Frontend.school_branches')}}</h5>

                    <div class="school-list schools-style-popular">
                        @foreach($school_branches as $school_branch_index => $school_branch)
                            @if ($school_branch_index % 3 == 0)
                                <div class="row" data-aos="zoom-in" data-aos-delay="100" data-row-index="{{ $school_branch_index / 3 + 1 }}">
                            @endif
                            <div class="col-md-4 d-flex align-items-stretch mt-4 mt-md-0">
                                <div class="school-item">
                                    <a href="{{route('frontend.school.details', $school->id)}}">
                                        <div class="school-logo" style="background-image: url('{{ $school->logo }}')"></div>
                                        <div class="school-content">
                                            <div class="school-information">
                                                <a href="{{route('frontend.school.details', $school->id)}}">
                                                    <div class="school-name-branch">{{ $school_branch->name ? (app()->getLocale() == 'en' ? $school_branch->name->name : $school_branch->name->name_ar) : '' }}{{ app()->getLocale() == 'en' ? ($school_branch->branch_name ? ' / ' . $school_branch->branch_name : '') : ($school_branch->branch_name_ar ?' / ' . $school_branch->branch_name_ar : '') }}</div>
                                                    <div class="school-city">{{ $school_branch->city ? (app()->getLocale() == 'en' ? $school_branch->city->name : $school_branch->city->name_ar) : '' }}</div>
                                                    <div class="school-country">{{ $school_branch->country ? (app()->getLocale() == 'en' ? $school_branch->country->name : $school_branch->country->name_ar) : '' }}</div>
                                                </a>
                                            </div>
                                            <div class="school-users-loves-likes">
                                                <div class="school-users-loves">
                                                    <i class="bx bx-show"></i>&nbsp;{{$school_branch->viewed_count}}&nbsp;&nbsp;
                                                    @auth
                                                        @if (!empty(auth()->user()->likedSchool))
                                                            <i class="bx bxs-heart" data-school="{{ $school_branch->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))"></i>&nbsp;{{ auth()->user()->likedSchool()->count() }}
                                                        @else
                                                            <i class="bx bx-heart" data-school="{{ $school_branch->id }}" style="cursor:pointer" onclick="like_school($(this).attr('data-school'))">&nbsp;{{ auth()->user()->likedSchool()->count() }}</i>
                                                        @endif
                                                    @else
                                                        <i class="bx bx-heart" data-school="{{ $school_branch->id }}" onclick="like_school($(this).attr('data-school'), true)" style="cursor:pointer">&nbsp;{{ \App\Models\Frontend\LikedSchool::count() }}</i>
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
                            @if ($school_branch_index % 3 == 2)
                                </div>
                            @endif
                        @endforeach
                        @if (count($school_branches) % 3 != 2)
                            </div>
                        @endif
                        @if (count($school_branches) > 3)
                            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                                <div class="col-md-12">
                                    <button onclick="loadMoreSchoolBranch()" class="btn btn-primary w-100">{{__('Frontend.more_branches')}}</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            @endif
            <!-- End School Branches Section -->
        </div>
    </div>

    {{-- Rate Comment Modal --}}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{route('frontend.rate.save')}}">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ucfirst($school->name)}}</h4>
                        <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">{{__('Frontend.comments')}}</label>
                            <textarea class="form-control" name="comments" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('Frontend.close')}}</button>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{__('Frontend.submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var save_rating_url = "{{route('save_rating')}}";
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

        function highlightStar(obj) {
            removeHighlight();
            $('li').each(function (index) {
                $(this).addClass('highlight');
                if (index == $("li").index(obj)) {
                    return false;
                }
            });
        }

        function removeHighlight() {
            $('li').removeClass('selected');
            $('li').removeClass('highlight');
        }

        function addRating(obj) {
            $('li').each(function (index) {
                $(this).addClass('selected');
                $('#rating').val((index + 1));
                if (index == $("li").index(obj)) {
                    return false;
                }
            });
        }

        $(document).ready(function () {
            var maximumvalue="{{round($school->avgRating())}}";
            for (var i = 0; i <= maximumvalue; i++) {
                $("#rating" + i).addClass('selected');
            }
        });

        function resetRating() {
            if ($("#rating").val()) {
                $('li').each(function (index) {
                    $(this).addClass('selected');
                    if ((index + 1) == $("#rating").val()) {
                        return false;
                    }
                });
            }
        }

        function save_rating(how_much) {
            $.post(save_rating_url, {
                _token: "{{csrf_token()}}",
                how_much: how_much,
                school_id: "{{$school->id}}"
            }, function (data) {
                if (data.failed) {
                    $("#close_modal").click();
                    setTimeout(function () {
                        alert(data.failed);
                    }, 2000);
                }
            });
        }

        function get_program() {
            var urlname = "{{route('frontend.school.programs')}}";
            $.post(
                urlname, 
                {
                    id: "{{ $id }}",
                    _token: "{{ csrf_token() }}",
                    language: $('#choose_language').val(),
                    study_mode: $('#study_mode').val(),
                    age: $('#your_age').val()
                },
                function (data) {
                    $(".program").html(data.data)
                    $("#loader").hide()
                }
            );
        }

        var school_branch_page = 1;
        function loadMoreSchoolBranch() {
            $('#school-branches .school-list .row').each(function() {
                if (parseInt($(this).data('row-index')) > school_branch_page) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            school_branch_page = school_branch_page + 1;
        }

        $(document).ready(function () {
            get_program();
        });
    </script>
    <div id="loader"></div>
@endsection