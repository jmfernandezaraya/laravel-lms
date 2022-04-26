@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.single_course')}}
@endsection

@section('css')
    <style>
        .section-title {
            font-size: 24px;
            margin: 30px 0 15px 0;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }
        .section-title:before {
            content: '';
            position: absolute;
            display: block;
            width: 100%;
            height: 1px;
            background: #eef0ef;
            bottom: 0;
            left: 0;
        }
        .section-title:after {
            content: '';
            position: absolute;
            display: block;
            width: 60px;
            height: 1px;
            background: #97d0db;
            bottom: 0;
            left: 0;
        }

        #tab-video .carousel-item {
            position: relative;
            width: 100%;
            height: 100%;
        }
        #tab-video .carousel-item .video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="tab-contents" class="tab-content">
                <div id="tab-photo" class="tab-pane fade active show">
                    <div id="carousel-photo" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach((array)$schools->multiple_photos as $photos)
                                <li data-target="#carousel-photo" data-slide-to="{{$loop->iteration - 1}}" class="{{$loop->iteration - 1 == 0? 'active' : ''}}"></li>
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach((array)$schools->multiple_photos as $photos)
                                <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : ''  }}">
                                    <img class="d-block w-100" src="{{asset('storage/app/public/school_images/'. $photos)}}" alt="First slide">
                                </div>
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carousel-photo" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">{{__('Frontend.previous')}}</span>
                        </a>

                        <a class="carousel-control-next" href="#carousel-photo" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">{{__('Frontend.next')}}</span>
                        </a>
                    </div>
                </div>

                <div id="tab-video" class="tab-pane fade">
                    <div class="row pb-2">
                        <div class="col-md-12">
                            <div id="carousel-video" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach((array)$schools->video_url as $video_url)
                                        <li data-target="#carousel-video-item{{$loop->iteration - 1}}" data-slide-to="{{$loop->iteration - 1}}" class="{{$loop->iteration - 1 == 0? 'active' : ''}}"></li>
                                    @endforeach
                                </ol>

                                <div class="carousel-inner">
                                    @foreach((array)$schools->video_url as $video_url)
                                        <div class="carousel-item active" href="#carousel-video-item{{$loop->iteration - 1}}">
                                            <iframe class="embed-responsive-item" src="{{$video_url}}" class="video" allowfullscreen height="450"></iframe>
                                        </div>
                                    @endforeach
                                </div>

                                <a class="carousel-control-prev" href="#carousel-video-item2" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">{{__('Frontend.previous')}}</span>
                                </a>

                                <a class="carousel-control-next" href="#carousel-video-item3" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">{{__('Frontend.next')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul id="nav-tabs" class="nav nav-tabs nav-fill">
                <li class="nav-item">
                    <a href="" data-target="#tab-photos" data-toggle="tab" class="nav-link small text-uppercase active">{{__('Frontend.photos')}}</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#tab-video" data-toggle="tab" class="nav-link small text-uppercase">{{__('Frontend.video')}}</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="inter-full mt-3">
        <div class="border-bottom">
            <div class="row">
                <div class="col-md-8">
                    <h3>
                        <p class="m-0 inter-school">{{ucwords($schools->name)}} - {{is_array($schools->branch_name) && !empty($schools->branch_name) ? ucwords($schools->branch_name[0]) : $schools->branch_name}}</p>
                        <span class="city">{{$schools->city}}, {{$schools->country}}</span>
                    </h3>
                    <ul>
                        @for($i = 1; $i <= 5; $i ++)
                            <li class="dynamic_starli" aria-hidden="true" id="rating{{$i}}">★</li>
                        @endfor
                    </ul>
                    {{ round($schools->avgRating()) }} {{__('Frontend.reviews')}}
                </div>

                <div class="col-md-4">
                    <a type="button" href="{{route('school.details', $schools->id)}}" class="btn btn-primary mt-1">{{__('Frontend.read_about_the_school')}}</a>
                </div>
            </div>
        </div>

        <div class="course-details border-bottom">
            <div class="row">
                <div class="col-md-12">                            
                    <h3>{{__('Frontend.program_information')}}</h3>
                    <div id="program_information">{!! get_language() == 'en' ? $course_update->program_information : $course_update->program_information_ar !!}</div>
                </div>
            </div>
            <table class="table table-bordered table-no-drawable">
                <tbody>
                    <tr>
                        <td>{{__('Frontend.level_required')}}</td>
                        <td id="level_required">{{$course_update->program_level}}</td>
                    </tr>
                    <tr>
                        <td>{{__('Frontend.lessons_per_week')}}</td>
                        <td id="lessons_per_week">{{$course_update->lessons_per_week}}</td>
                    </tr>
                    <tr>
                        <td>{{__('Frontend.hours_per_week')}}</td>
                        <td id="hours_per_week">{{$course_update->hours_per_week}}</td>
                    </tr>
                    <tr>
                        @php $course_study_times = \App\Models\SuperAdmin\Choose_Study_Time::whereIn('unique_id', is_null($course_update->study_time) ? [] : $course_update->study_time)->pluck('name')->toArray(); @endphp
                        <td>{{__('Frontend.study_time')}}</td>
                        <td id="study_time">{{implode(", ", $course_study_times)}}</td>
                    </tr>
                    <tr>
                        @php $course_classes_days = \App\Models\SuperAdmin\Choose_Classes_Day::whereIn('unique_id', is_null($course_update->classes_day) ? [] : $course_update->classes_day)->pluck('name')->toArray(); @endphp
                        <td>{{__('Frontend.classes_days')}}</td>
                        <td id="classes_day">{{implode(", ", $course_classes_days)}}</td>
                    </tr>
                    <tr>
                        @php $course_start_days = \App\Models\SuperAdmin\Choose_Start_Day::whereIn('unique_id', is_null($course_update->start_date) ? []: $course_update->start_date)->pluck('name')->toArray(); @endphp
                        <td>{{__('Frontend.start_dates')}}</td>
                        <td id="start_date">{{implode(", ", $course_start_days)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form method="POST" action="{{route('course.details.save')}}">
            @csrf
            <div class="study">
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="school_id" value="{{ $schools->id }}">
                        <label for="study_mode">{{__('SuperAdmin/backend.study_mode')}}:</label>
                        <select class="form-control" id="study_mode" name="study_mode" required>
                            <option value="" selected>{{__('Frontend.select_mode')}}</option>
                            @foreach ($study_modes as $study_mode)
                                <option value="{{$study_mode->unique_id}}">{{$study_mode->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="under_age">{{__('Frontend.your_age')}}:</label>
                        <select name="age_selected" class="form-control" id="under_age" required>
                            <option value="">{{__('Frontend.select_age')}}</option>
                            @foreach ($ages as $age)
                                <option value="{{$age->unique_id}}">{{$age->age}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="program_fees" class="mt-3">
                <h3 class="section-title">{{__('Frontend.program_fees')}}</h3>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="program_name">{{__('Frontend.program_name')}}:</label>                        
                        <input hidden name="program_unique_id" id="program_unique_id">

                        <select class="form-control" id="get_program_name" onchange="set_program_unique_id($(this).children('option:selected').data('id')); calculateCourse('select_program');" name="program_id" required>
                            <option value="" selected>{{__('Frontend.select_option')}}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="program_start_date">{{__('Frontend.program_start_date')}}:</label>
                        <input class="form-control datepicker" id="datepick" type="text" name="date_selected" autocomplete="off" onchange="calculateCourse('date_selected')" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="program_duration">{{__('Frontend.program_duration')}}:</label>
                        <select class="form-control" id="program_duration" name="program_duration" onchange="calculateCourse('duration'); discountPrice($(this).val(), '{{csrf_token()}}');" required>
                            <option value="" selected>{{__('Frontend.select_option')}}</option>
                        </select>
                    </div>
                </div>

                <div class="row" id="courier_fee" style="display: none">
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <input name="courier_fee" type="checkbox" class="form-check-input" id="checked_courier_fee" onchange="calculateCourse('duration', $('#program_duration').val())">
                            <label class="form-check-label mb-2" for="expressMailingCheck">
                                {{__('Frontend.express_mailing')}}<i class="fa fa-question-circle pl-2" data-toggle="modal" data-target="#expressMailingModal" aria-hidden="true"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="expressMailingModal" tabindex="-1" role="dialog" aria-labelledby="expressMailingModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="expressMailingModalLabel">{{__('Frontend.express_mailing')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>

                            <div class="modal-body">{{__('Frontend.express_mailing_description')}}</div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-no-drawable" id="program_fees_table">
                    <thead>
                        <tr>
                            <th>{{__('Frontend.details')}}</th>
                            <th>{{__('Frontend.amount')}} / <span class="cost_currency"></span></th>
                            <th>{{__('Frontend.amount')}} / <span class="converted_currency"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="program_cost">
                            <td>{{__('Frontend.program_cost')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="registration_fee">
                            <td>{{__('Frontend.registration_fee')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="text_book_fee">
                            <td>{{__('Frontend.text_book_fee')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="summer_fees">
                            <td>{{__('Frontend.summer_fees')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="peak_time_fees">
                            <td>{{__('Frontend.peak_time_fees')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="under_age_fees">
                            <td>{{__('Frontend.under_age_fees')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="express_mail_fee">
                            <td>{{__('Frontend.express_mail_fee')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="discount_fee">
                            <td>{{__('Frontend.discount')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>

                        <tr id="program_total">
                            <td>{{__('Frontend.total')}}</td>
                            <td class="cost_value">0</td>
                            <td class="converted_value">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="accommodation_fees">
                <div class="accommodation-fees">
                    <h3 class="section-title">{{__('Frontend.accommodation_fees')}}</h3>
                    <div class="mt-3">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="input">{{__("Frontend.accommodation_type")}}:</label>
                                <select name="accommodation_id" id="accom_type" class="form-control">
                                    <option value="">{{__('Frontend.select_option')}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="input">{{__('Frontend.room_type')}}:</label>
                                <select class="form-control" id="room_type">
                                    <option value="">{{__('Frontend.select_option')}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="input">{{__('Frontend.meal_type')}}:</label>
                                <select class="form-control" id="meal_type">
                                    <option value="">{{__('Frontend.select_option')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="input">{{__('Frontend.accommodation_duration')}}:</label>
                                <select name="accommodation_duration" class="form-control" id="accom_duration" onchange="calcuateAccommodation()">
                                    <option value="">{{__('Frontend.select')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" id="special_diet" style="display: none">
                            <div class="form-group col-md-12">
                                <div class="form-check">
                                    <input name="special_diet" type="checkbox" class="form-check-input" id="special_diet_check" onchange="calcuateAccommodation()">
                                    <label class="form-check-label mb-2" for="expressMailingCheck">
                                        {{__('Frontend.special_diet_fee')}}<i class="fa fa-question-circle pl-2" data-toggle="modal" data-target="#specialDietModal" aria-hidden="true"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="custodianship" style="display: none">
                            <div class="form-group col-md-12">
                                <div class="form-check">
                                    <input name="custodianship" type="checkbox" class="form-check-input" id="custodianship_check" onchange="calcuateAccommodation()">
                                    <label class="form-check-label mb-2" for="custodianshipCheck">
                                        {{__('Frontend.custodianship_need')}}<i class="fa fa-question-circle pl-2" data-toggle="modal" data-target="#custodianshipModal" aria-hidden="true"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Special Diet Modal -->
                        <div class="modal fade" id="specialDietModal" tabindex="-1" role="dialog" aria-labelledby="specialDietModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="specialDietModalLabel">{{__('Frontend.special_diet_fee')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Custodianship Modal -->
                        <div class="modal fade" id="custodianshipModal" tabindex="-1" role="dialog" aria-labelledby="custodianshipModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="custodianshipModalLabel">{{__('Frontend.custodianship')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">{{__('Frontend.custodianship_help')}}</div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-no-drawable" id="accommodation_fees_table">
                            <thead>
                                <tr>
                                    <th>{{__('Frontend.details')}}</th>
                                    <th>{{__('Frontend.amount')}} / <span class="cost_currency"></span></th>
                                    <th>{{__('Frontend.amount')}} / <span class="converted_currency"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="accommodation_fee">
                                    <td>{{__('Frontend.accommodation_fee')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_placement_fee">
                                    <td>{{__('Frontend.placement_fee')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_special_diet_fee">
                                    <td>{{__('Frontend.special_diet_fee')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_deposit_fee">
                                    <td>{{__('Frontend.deposit_fee')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_custodian_fee">
                                    <td>{{__('Frontend.custodian_fee')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_summer_fees">
                                    <td>{{__('Frontend.summer_fees')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_peak_fees">
                                    <td>{{__('Frontend.peak_time_fees')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_christmas_fees">
                                    <td>{{ucfirst(__('Frontend.christmas_fees'))}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_under_age_fees">
                                    <td>{{__('Frontend.under_age_fees')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_discount_fee">
                                    <td>{{__('Frontend.discount')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="accommodation_total">
                                    <td>{{__('Frontend.total')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="other-services" id="other_services">
                <h3 class="section-title">{{__('Frontend.other_services')}}</h3>
                <div id="airport_service" class="transport mt-3">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <h5><strong>{{__('Frontend.transport')}}</strong></h5>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="input">{{__('Frontend.service_provider')}}:</label>
                            <select class="form-control" name="airport_provider" id="airport_service_provider">
                                <option value="">{{__('Frontend.select')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="input">{{__('Frontend.airtport_name')}}:</label>
                            <select name="airport_name" class="form-control" id="airport_name">
                                <option value="">{{__('Frontend.select')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="input">{{__('Frontend.type_of_service')}}:</label>
                            <select name="airport_service" class="form-control" id="airport_type_of_service">
                                <option value="">{{__('Frontend.select')}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="medical_service" class="medical_insurance mt-3">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <h5><strong>{{__('Frontend.medical_insurance')}}</strong></h5>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="input">{{__('Frontend.company_name')}}:</label>
                            <select class="form-control" name="company_name" id="medical_company_name">
                                <option value="">{{__('Frontend.select')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="input">{{__('Frontend.deductible_up_to')}}:</label>
                            <select class="form-control" name="deductible_up_to" id="medical_deductible_up_to">
                                <option value="">{{__('Frontend.select')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="input">{{__('Frontend.duration')}}:</label>
                            <select class="form-control" name="duration" id="medical_duration">
                                <option value="">{{__('Frontend.select')}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <table class="table table-bordered table-no-drawable" id="airport_medical_fees_table">
                            <thead>
                                <tr>
                                    <th>{{__('Frontend.details')}}</th>
                                    <th>{{__('Frontend.amount')}} / <span class="cost_currency"></span></th>
                                    <th>{{__('Frontend.amount')}} / <span class="converted_currency"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="airport_pickup">
                                    <td>{{__('Frontend.airport_pickup')}}
                                        <i class="fa fa-question-circle pl-2" data-toggle="modal" data-target="#AirportPickupModal" aria-hidden="true"></i>
                                    </td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="medical_insurance">
                                    <td>{{__('Frontend.medical_insurance')}}
                                        <i class="fa fa-question-circle pl-2" data-toggle="modal" data-target="#MedicalInsuranceModal" aria-hidden="true"></i>
                                    </td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>

                                <tr id="airport_medical_total">
                                    <td>{{__('Frontend.total')}}</td>
                                    <td class="cost_value">0</td>
                                    <td class="converted_value">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Special Diet Modal -->
            <div class="modal fade" id="AirportPickupModal" tabindex="-1" role="dialog" aria-labelledby="AirportPickupModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AirportPickupModalLabel">{{__('Frontend.airport_pickup_note')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>

            <!-- Special Diet Modal -->
            <div class="modal fade" id="MedicalInsuranceModal" tabindex="-1" role="dialog" aria-labelledby="MedicalInsuranceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="MedicalInsuranceModalLabel">{{__('Frontend.medical_insurance_note')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
            <div class="total mt-3">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-no-drawable" id="total_table">
                            <tbody>
                                <tr>
                                    <td>{{__('Frontend.total_cost')}}</td>
                                    <td><span class="total_cost"></span> <span class="total_cost_currency"></span></td>
                                    <td><span class="total_converted"></span> <span class="total_converted_currency"></span></td>
                                </tr>
                            </tbody>
                        </table>

                        <input hidden id="total_fees" name="total_fees">
                        <button type="submit" class="btn btn-primary px-5 py-3 pull-right">{{__('Frontend.register_now')}}</button>
                    </div>
                </div>
            </div>

            <input hidden id="total_fees_to_save_to_db" name="total_fees_to_save_to_db">
            <input hidden id="other_currency_to_save_to_db" name="other_currency_to_save_to_db">
        </form>
    </div>
@endsection

@section('js')
    <script>
        var token = "{{csrf_token()}}";

        var rooms_meals_url = "{{route('course.rooms_meals')}}";
        var accomm_durations_url = "{{route('course.accomm_durations')}}";
        
        var calculate_url = "{{route('course.calculate')}}";
        var calculate_accommodation_url = "{{route('course.calculate.accommodation')}}";
        var calculate_discount_url = "{{route('course.calculate.discount')}}";
        var reload_calculate_url = "{{route('course.calculate.reset.program')}}";
        var reset_accommodation_url = "{{route('course.calculate.reset.accommodation')}}";
        var reset_airport_medical_url = "{{route('course.calculate.reset.airport_medical')}}";
        
        var airport_names_url = "{{route('course.airport.names')}}";
        var airport_services_url = "{{route('course.airport.services')}}";
        var airport_fee_url = "{{route('course.airport.fee')}}";
        var medical_deductibles_url = "{{route('course.medical.deductibles')}}";
        var medical_durations_url = "{{route('course.medical.durations')}}";
        var medical_fee_url = "{{route('course.medical.fee')}}";
        var airport_medical_fee_url = "{{route('course.airport_medical.fee')}}";

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
                fillCourseForm();
            }
        }

        function fillCourseForm() {
            @if (isset($course_details->study_mode))
                $('#study_mode').val('{{$course_details->study_mode}}');
            @endif
            @if (isset($course_details->age_selected))
                $('#under_age').val('');
                $('#under_age').val('{{$course_details->age_selected}}').trigger('change');
            @endif
        }

        function callbackCalculateCourse(type) {
            if (type == 'requested_for_under_age') {
                @if (isset($course_details->program_id))
                    $('#get_program_name').val('');
                    $('#get_program_name').val('{{$course_details->program_id}}').trigger('change');
                @endif
            } else if (type == 'select_program') {
                @if (isset($course_details->date_selected))
                    $('#datepick').val('');
                    $('#datepick').val('{{$course_details->date_selected}}').trigger('change');
                @endif
            } else if (type == 'date_selected') {
                @if (isset($course_details->program_duration))
                    $('#program_duration').val('');
                    $('#program_duration').val('{{$course_details->program_duration}}').trigger('change');
                @endif
            } else if (type == 'duration') {
                @if (isset($course_details->accommodation_id))
                    $('#accom_type').val('');
                    $('#accom_type').val('{{$course_details->accommodation_id}}').trigger('change');
                @endif
            }
        }

        function callbackChangeAccommodationType() {
            @if (isset($course_details->room_type))
                @if ($course_details->room_type)
                    $('#room_type').val('');
                    $('#room_type').val('{{$course_details->room_type}}').trigger('change');
                @else
                    @if (isset($course_details->airport_provider))
                        $('#airport_service_provider').val('');
                        $('#airport_service_provider').val('{{$course_details->airport_provider}}').trigger('change');
                    @endif
                @endif
            @endif
            @if (isset($course_details->meal_type))
                @if ($course_details->meal_type)
                    $('#meal_type').val('');
                    $('#meal_type').val('{{$course_details->meal_type}}').trigger('change');
                @else
                    @if (isset($course_details->airport_provider))
                        $('#airport_service_provider').val('');
                        $('#airport_service_provider').val('{{$course_details->airport_provider}}').trigger('change');
                    @endif
                @endif
            @endif
        }

        function callbackChangeAccommodationMealType() {
            @if (isset($course_details->accommodation_duration))
                $('#accom_duration').val('');
                $('#accom_duration').val('{{$course_details->accommodation_duration}}').trigger('change');
            @endif
        }

        function callbackCalcuateAccommodation() {
            @if (isset($course_details->airport_provider))
                @if ($course_details->airport_provider)
                    $('#airport_service_provider').val('');
                    $('#airport_service_provider').val('{{$course_details->airport_provider}}').trigger('change');
                @else
                    @if (isset($course_details->company_name))
                        $('#medical_company_name').val('');
                        $('#medical_company_name').val('{{$course_details->company_name}}').trigger('change');
                    @endif
                @endif
            @endif
        }

        function callbackChangeAirportServiceProvider() {
            @if (isset($course_details->airport_name))
                @if ($course_details->airport_name)
                    $('#airport_name').val('');
                    $('#airport_name').val('{{$course_details->airport_name}}').trigger('change');
                @else
                    @if (isset($course_details->company_name))
                        $('#medical_company_name').val('');
                        $('#medical_company_name').val('{{$course_details->company_name}}').trigger('change');
                    @endif
                @endif
            @endif
        }

        function callbackChangeAirportName() {
            @if (isset($course_details->airport_service))
                @if ($course_details->airport_service)
                    $('#airport_type_of_service').val('');
                    $('#airport_type_of_service').val('{{$course_details->airport_service}}').trigger('change');
                @else
                    @if (isset($course_details->company_name))
                        $('#medical_company_name').val('');
                        $('#medical_company_name').val('{{$course_details->company_name}}').trigger('change');
                    @endif
                @endif
            @endif
        }

        function callbackCalculateAirportMedical(type) {
            if (type == 'airport') {
                @if (isset($course_details->company_name))
                    $('#medical_company_name').val('');
                    $('#medical_company_name').val('{{$course_details->company_name}}').trigger('change');
                @endif
            }
        }

        function callbackChangeMedicalCompanyName() {
            @if (isset($course_details->deductible_up_to))
                $('#medical_deductible_up_to').val('');
                $('#medical_deductible_up_to').val('{{$course_details->deductible_up_to}}').trigger('change');
            @endif
        }

        function callbackChangeMedicalDeductibleUpTo() {
            @if (isset($course_details->duration))
                $('#medical_duration').val('');
                $('#medical_duration').val('{{$course_details->duration}}').trigger('change');
            @endif
        }

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
            var maximumvalue="{{round($schools->avgRating())}}";
            for (var i = 0; i <= maximumvalue; i++) {
                $("#rating" + i).addClass('selected');
            }
        });

        function set_program_unique_id(object) {
            $('#program_unique_id').val(object);
        }
    </script>
@endsection