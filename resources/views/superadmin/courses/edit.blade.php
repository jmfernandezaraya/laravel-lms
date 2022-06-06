@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_course')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_course')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>
                
                <div id="menu">
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('superadmin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{route('superadmin.course.update', $course->unique_id)}}" id="form1">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="program_language">
                                    {{__('SuperAdmin/backend.choose_lang')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#LanguageModal" aria-hidden="true"></i>
                                    <i class="fa fa-trash pl-3" onclick="deleteLanguage()" aria-hidden="true"></i>
                                </label>
                                <select name="language[]" id="language_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_languages as $choose_language)
                                        <option value="{{ $choose_language->unique_id }}" {{in_array($choose_language->unique_id, (array)$course->language ?? []) ? 'selected' : ''}}>{{$choose_language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="program_language">{{__('SuperAdmin/backend.choose_study_mode')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudyModeModal" aria-hidden="true"></i>
                                    <i class="fa fa-trash pl-3" onclick="deleteStudyMode()" aria-hidden="true"></i>
                                </label>
                                <select name="study_mode[]" id="study_mode_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_study_modes as $study_mode)
                                        <option value="{{ $study_mode->unique_id }}" {{in_array($study_mode->unique_id, (array)$course->study_mode ?? []) ? 'selected' : ''}}>{{$study_mode->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="program_language">{{__('SuperAdmin/backend.choose_program_type')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramTypeModal" aria-hidden="true"></i>
                                    <i onclick="deleteProgramType()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="program_type[]" id="program_type_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_program_types as $program_type)
                                        <option value="{{ $program_type->unique_id }}" {{in_array($program_type->unique_id, (array)$course->program_type ?? []) ? 'selected' : ''}}>{{$program_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">{{__('SuperAdmin/backend.choose_school')}}:</label>
                                <select onchange="changeCourseSchool()" class="form-control" id="school_name" name="school_name">
                                    <option value="">{{__('SuperAdmin/backend.select_school')}}</option>
                                    @foreach ($choose_schools as $choose_school)
                                        <option value="{{ $choose_school }}" {{ $choose_school == $school_name ? 'selected' : '' }}>{{ $choose_school }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="country_name">{{__('SuperAdmin/backend.choose_country')}}:</label>
                                <select onchange="changeCourseCountry()" class="form-control" id="country_name" name="country_id">
                                    <option value="">{{__('SuperAdmin/backend.select')}}</option>
                                    @foreach ($school_countries as $school_country)
                                        <option value="{{ $school_country->id }}" {{ $course->country_id == $school_country->id ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ?  $school_country->name : $school_country->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="city_name">{{__('SuperAdmin/backend.choose_city')}}:</label>
                                <select onchange="changeCourseCity()" class="form-control" id="city_name" name="city_id">
                                    <option value="">{{__('SuperAdmin/backend.select')}}</option>
                                    @foreach ($school_countries as $school_country)
                                        @if ($school_country->id == $course->school->country_id)
                                            @foreach ($school_country->cities as $city)
                                                <option value="{{ $city->id }}" {{ $city->id == $course->school->city_id ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $city->name : $city->name_ar }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="branch">{{__('SuperAdmin/backend.add_branch_if_applicable')}}</label>
                                <select class="form-control" name="branch" id="branch_choose">
                                    <option value="">{{__('SuperAdmin/backend.select')}}</option>
                                    @foreach ($school_branches as $school_branch)
                                        <option value="{{ $school_branch }}" {{$course->branch == $school_branch ? 'selected' : ''}}>{{$school_branch}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="choose_currency">{{__('SuperAdmin/backend.choose_currency')}}:</label>
                                <select class="form-control" id="choose_currency" name="currency">
                                    <option value="">{{__('SuperAdmin/backend.select')}}</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{$currency->id == $course->currency ? 'selected' : ''}}>{{$currency->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <h3>{{__('SuperAdmin/backend.program_features')}}</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="program_name">{{__('SuperAdmin/backend.program_name')}}:</label>
                                <div class="english">
                                    <input value="{{ $course->program_name }}" class="form-control" type="text" name="program_name" placeholder="{{__('SuperAdmin/backend.program_name')}}">
                                </div>
                                <div class="arabic">
                                    <input value="{{ $course->program_name_ar }}" class="form-control" type="text" name="program_name_ar" placeholder="{{__('SuperAdmin/backend.program_name')}}">
                                </div> 
                            </div>
                            <div class="form-group col-md-3">
                                <label for="program_level_required">{{__('SuperAdmin/backend.level_required')}}:</label>
                                <div class="english">
                                    <input value="{{ $course->program_level }}" class="form-control" type="text" name="program_level" placeholder="{{__('SuperAdmin/backend.level_required')}}">
                                </div>
                                <div class="arabic">
                                    <input value="{{ $course->program_level_ar }}" class="form-control" type="text" name="program_level_ar" placeholder="{{__('SuperAdmin/backend.level_required')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="lessons_per_week">{{__('SuperAdmin/backend.lessons_per_week')}}:</label>
                                <input value="{{ $course->lessons_per_week }}" class="form-control" type="number" name="lessons_per_week" placeholder="{{__('SuperAdmin/backend.lessons_per_week')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="hours_per_week">{{__('SuperAdmin/backend.hours_per_week')}}:</label>
                                <input value="{{ $course->hours_per_week }}" class="form-control" type="number" name="hours_per_week" placeholder="{{__('SuperAdmin/backend.hours_per_week')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="study_time">{{__('SuperAdmin/backend.study_time')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudyTimeModal" aria-hidden="true"></i>
                                    <i onclick="deleteStudyTime()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="study_time[]" id="study_time_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_study_times as $study_time)
                                        <option value="{{ $study_time->unique_id }}" {{in_array($study_time->unique_id, (array)$course->study_time ?? []) ? 'selected' : ''}}>{{$study_time->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="classes_days">{{__('SuperAdmin/backend.classes_days')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ClassesDayModal" aria-hidden="true"></i>
                                    <i onclick="deleteClassesDay()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="classes_day[]" id="classes_day_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_classes_days as $classes_day)
                                        <option value="{{ $classes_day->unique_id }}" {{in_array($classes_day->unique_id, (array)$course->classes_day ?? []) ? 'selected' : ''}}>{{$classes_day->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="start_date">{{__('SuperAdmin/backend.start_dates')}}
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StartDateModal" aria-hidden="true"></i>
                                    <i onclick="deleteStartDate()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="start_date[]" id="start_date_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_start_days as $start_date)
                                        <option value="{{ $start_date->unique_id }}" {{in_array($start_date->unique_id, (array)$course->start_date ?? []) ? 'selected' : ''}}>{{$start_date->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{__('SuperAdmin/backend.program_information')}}:</label>
                                <div class="english">
                                    <textarea class="form-control ckeditor-input" name="program_information" placeholder="{{__('SuperAdmin/backend.program_information')}}" id="program_information">{!! $course->program_information !!}</textarea>
                                </div>
                                <div class="arabic">
                                    <textarea class="form-control ckeditor-input" name="program_information_ar" placeholder="{{__('SuperAdmin/backend.program_information')}}" id="program_information_ar">{!! $course->program_information_ar !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <script>
                            window.addEventListener('load', function() {
                                course_program_clone = {{$course && $course->coursePrograms->count() ? $course->coursePrograms->count() - 1 : 0}};
                            }, false );
                        </script>

                        <input hidden id="program_increment" name="program_increment" value="{{$course->coursePrograms && $course->coursePrograms->count() ? $course->coursePrograms->count() - 1 : 0}}">

                        @forelse ($course->coursePrograms as $course_program)
                            <div id="course_program_clone{{$loop->iteration - 1}}" class="course-program-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h3>{{__('SuperAdmin/backend.program_cost')}}</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="program_name">{{__('SuperAdmin/backend.program_id')}}:</label>
                                        <input readonly class="form-control" value="{{ $course_program->unique_id }}" type="text" id="program_id{{$loop->iteration - 1}}" name="program_id[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    @php $course_program_deposits = explode(" ", $course_program->deposit); @endphp
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_registration_free')}}:</label>
                                        <input class="form-control" value="{{ $course_program->program_registration_fee }}" type="number" name="program_registration_fee[]" placeholder="{{__('SuperAdmin/backend.program_registration_free')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input class="form-control" value="{{ $course_program->program_duration }}" type="number" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.program_deposit')}}:</label>
                                        <input class="form-control" value="{{ isset($course_program_deposits[0]) ? $course_program_deposits[0] : '' }}" type="number" name="deposit[]" placeholder="{{__('SuperAdmin/backend.deposit')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.deposit_symbol')}}:</label>
                                        <select class="form-control" name="deposit_symbol[]">
                                            <option value="%" {{$course_program->deposit && isset($course_program_deposits[0]) && $course_program_deposits[1] == '%' ? 'selected' :'' }}>%</option>
                                            <option value="fixed" {{$course_program->deposit && isset($course_program_deposits[1]) && $course_program_deposits[1] == 'fixed' ? 'selected' :'' }}>{{__('SuperAdmin/backend.fixed')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 age_range">
                                        <label for="program_age_range">{{__('SuperAdmin/backend.age_range')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteProgramAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select name="age_range[{{$loop->iteration - 1}}][]" id="program_age_range_choose{{$loop->iteration - 1}}" multiple="multiple" class="3col active">
                                            @foreach ($choose_program_age_ranges as $choose_program_age_range)
                                                <option value="{{ $choose_program_age_range->unique_id }}" {{in_array($choose_program_age_range->unique_id, (array)$course_program->program_age_range ?? []) ? 'selected' : ''}}>{{$choose_program_age_range->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.courier_fee')}}:</label>
                                        <input type="number" class="form-control" name="courier_fee[]" value="{{$course_program->courier_fee}}" placeholder="{{__('SuperAdmin/backend.courier_fee')}}">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.about_courier')}}:</label>
                                        <div class="english">
                                            <textarea class="form-control ckeditor-input" name="about_courier[]" placeholder="{{__('SuperAdmin/backend.about_courier')}}" id="about_courier{{$loop->iteration - 1}}">{!! $course_program->about_courier !!}</textarea>
                                        </div>
                                        <div class="arabic">
                                            <textarea class="form-control ckeditor-input" name="about_courier_ar[]" placeholder="{{__('SuperAdmin/backend.about_courier')}}" id="about_courier_ar{{$loop->iteration - 1}}">{!! $course_program->about_courier_ar !!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_cost')}}:</label>
                                        <input value="{{$course_program->program_cost}}" class="form-control" type="number" name="program_cost[]" placeholder="{{__('SuperAdmin/backend.program_cost')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration_start')}}:</label>
                                        <input value="{{$course_program->program_duration_start}}" class="form-control" type="number" name="program_duration_start[]" placeholder="{{__('SuperAdmin/backend.program_duration_start')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration_end')}}:</label>
                                        <input value="{{$course_program->program_duration_end}}" class="form-control" type="number" name="program_duration_end[]" placeholder="{{__('SuperAdmin/backend.program_duration_end')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_start_date')}}:</label>
                                        <input value="{{$course_program->program_start_date}}" class="form-control" type="date" name="program_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_end_date')}}:</label>
                                        <input value="{{$course_program->program_end_date}}" class="form-control" type="date" name="program_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.available_dates')}}:</label>
                                        <select class="form-control available_date" name="available_date[]">
                                            <option value="start_day_every" {{$course_program->available_date == 'start_day_every' ? 'selected' : ''}}>{{__('SuperAdmin/backend.start_day_every')}}</option>
                                            <option value="selected_dates" {{$course_program->available_date == 'selected_dates' ? 'selected' : ''}}>{{__('SuperAdmin/backend.selected_dates')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 select_day_week" {{$course_program->available_date == 'selected_dates' ? 'style=display:none' : ""}}>
                                        <label>{{__('SuperAdmin/backend.select_day')}}:</label>
                                        <select class="form-control" name="select_day_week[]">
                                            <option value="Monday" {{($course_program->select_day_week == 'Monday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Monday')}}</option>
                                            <option value="Tuesday" {{($course_program->select_day_week == 'Tuesday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Tuesday')}}</option>
                                            <option value="Wednesday" {{($course_program->select_day_week == 'Wednesday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Wednesday')}}</option>
                                            <option value="Thursday" {{($course_program->select_day_week == 'Thursday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Thursday')}}</option>
                                            <option value="Friday" {{($course_program->select_day_week == 'Friday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Friday')}}</option>
                                            <option value="Saturday" {{($course_program->select_day_week == 'saturday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Saturday')}}</option>
                                            <option value="Sunday" {{($course_program->select_day_week == 'Sunday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Sunday')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 available_days" {{$course_program->available_date == 'start_day_every' ? 'style=display:none' : ""}}>
                                        <label>{{__('SuperAdmin/backend.available_days')}}:</label>
                                        <input class="form-control yeardatepicker" data-index="{{$loop->iteration - 1}}" value="{{$course_program->available_days}}" name="available_days[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    @php $course_program_discount_per_weeks = explode(" ", $course_program->discount_per_week); @endphp
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input value="{{isset($course_program_discount_per_weeks[0]) ? $course_program_discount_per_weeks[0] : ''}}" class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_symbol')}}:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            <option value="%" {{isset($course_program_discount_per_weeks[1]) && $course_program_discount_per_weeks[1] == '%' ? 'selected' :'' }}>%</option>
                                            <option value="-" {{isset($course_program_discount_per_weeks[1]) && $course_program_discount_per_weeks[1] == '-' ? 'selected' :'' }}>-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_start_date')}}:</label>
                                        <input value="{{$course_program->discount_start_date}}" class="form-control" type="date" name="discount_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_end_date')}}:</label>
                                        <input value="{{$course_program->discount_end_date}}" class="form-control" type="date" name="discount_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_start_date')}}:</label>
                                        <input class="form-control" value="{{$course_program->christmas_start_date}}" type="date" name="christmas_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_end_date')}}:</label>
                                        <input class="form-control" value="{{$course_program->christmas_end_date}}" type="date" name="christmas_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_selected')}}:</label>
                                        <input value="{{$course_program->x_week_selected}}" class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('SuperAdmin/backend.every_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.free_week')}}:</label>
                                        <select class="form-control" name="how_many_week_free[]">
                                            <option value=''>{{__('SuperAdmin/backend.select')}} </option>
                                            <option value='1' {{$course_program->how_many_week_free == 1 ? 'selected' : ''}}>{{__('SuperAdmin/backend.1_week_free')}} </option>
                                            <option value='2' {{$course_program->how_many_week_free == 2 ? 'selected' : ''}}>{{__('SuperAdmin/backend.2_week_free')}}</option>
                                            <option value='3' {{$course_program->how_many_week_free == 3 ? 'selected' : ''}}>{{__('SuperAdmin/backend.3_week_free')}}</option>
                                            <option value='4' {{$course_program->how_many_week_free == 4 ? 'selected' : ''}}>{{__('SuperAdmin/backend.4_week_free')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_start_date')}}:</label>
                                        <input value="{{$course_program->x_week_start_date}}" class="form-control" type="date" name="x_week_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_end_date')}}:</label>
                                        <input value="{{$course_program->x_week_end_date}}" class="form-control" type="date" name="x_week_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee')}}:</label>
                                        <input value="{{$course_program->summer_fee_per_week}}" class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_start_date')}}:</label>
                                        <input value="{{$course_program->summer_fee_start_date}}" class="form-control" type="date" name="summer_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_end_date')}}:</label>
                                        <input value="{{$course_program->summer_fee_end_date}}" class="form-control" type="date" name="summer_fee_end_date[]">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_fee_per_week')}}:</label>
                                        <input value="{{$course_program->peak_time_fee_per_week}}" class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_start_date')}}:</label>
                                        <input value="{{$course_program->peak_time_start_date}}" class="form-control" type="date" name="peak_time_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_end_date')}}:</label>
                                        <input value="{{$course_program->peak_time_end_date}}" class="form-control" type="date" name="peak_time_end_date[]">
                                    </div>
                                </div>

                                <script>
                                    window.addEventListener('load', function() {
                                        yeardatepicker_days.push("{{$course_program->available_days ? $course_program->available_days : ''}}".split(","));
                                        yeardatepicker_months.push([]);
                                    }, false );
                                </script>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addCourseProgram($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="removeCourseProgram($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="course_program_clone0" class="course-program-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h3>{{__('SuperAdmin/backend.program_cost')}}</h3>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="program_name">{{__('SuperAdmin/backend.program_id')}}:</label>
                                        <input readonly class="form-control" value="{{time() . rand(000, 999)}}" type="text" id="program_id0" name="program_id[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_registration_free')}}:</label>
                                        <input class="form-control" type="number" name="program_registration_fee[]" placeholder="{{__('SuperAdmin/backend.program_registration_free')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input class="form-control" type="number" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.program_deposit')}}:</label>
                                        <input class="form-control" type="number" name="deposit[]" placeholder="{{__('SuperAdmin/backend.deposit')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.deposit_symbol')}}:</label>
                                        <select class="form-control" name="deposit_symbol[]">
                                            <option value="%" selected>%</option>
                                            <option value="fixed">{{__('SuperAdmin/backend.fixed')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 age_range">
                                        <label for="program_age_range">{{__('SuperAdmin/backend.age_range')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteProgramAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select id="program_age_range_choose0" name="age_range[0][]" multiple="multiple" class="3col active">
                                            @foreach ($choose_program_age_ranges as $program_age_range)
                                                <option value="{{$program_age_range->unique_id}}">{{$program_age_range->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.courier_fee')}}:</label>
                                        <input type="number" class="form-control" name="courier_fee[]" placeholder="{{__('SuperAdmin/backend.courier_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.about_courier')}}:</label>
                                        <div class="english">
                                            <textarea class="form-control ckeditor-input" name="about_courier[]" placeholder="{{__('SuperAdmin/backend.about_courier')}}" id="about_courier0"></textarea>
                                        </div>
                                        <div class="arabic">
                                            <textarea class="form-control ckeditor-input" name="about_courier_ar[]" placeholder="{{__('SuperAdmin/backend.about_courier')}}" id="about_courier_ar0"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_cost')}}:</label>
                                        <input class="form-control" type="text" name="program_cost[]" placeholder="{{__('SuperAdmin/backend.program_cost')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration_start')}}:</label>
                                        <input class="form-control" type="text" name="program_duration_start[]" placeholder="{{__('SuperAdmin/backend.program_duration_start')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration_end')}}:</label>
                                        <input class="form-control" type="text" name="program_duration_end[]" placeholder="{{__('SuperAdmin/backend.program_duration_end')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_start_date')}}:</label>
                                        <input class="form-control" type="date" name="program_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_end_date')}}:</label>
                                        <input class="form-control" type="date" name="program_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.available_dates')}}:</label>
                                        <select class="form-control available_date" name="available_date[]">
                                            <option value="start_day_every" selected>{{__('SuperAdmin/backend.start_day_every')}}</option>
                                            <option value="selected_dates">{{__('SuperAdmin/backend.selected_dates')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 select_day_week">
                                        <label>{{__('SuperAdmin/backend.select_day')}}:</label>
                                        <select class="form-control" name="select_day_week[]">
                                            <option value="Monday" selected>{{__('SuperAdmin/backend.Monday')}}</option>
                                            <option value="Tuesday">{{__('SuperAdmin/backend.Tuesday')}}</option>
                                            <option value="Wednesday">{{__('SuperAdmin/backend.Wednesday')}}</option>
                                            <option value="Thursday">{{__('SuperAdmin/backend.Thursday')}}</option>
                                            <option value="Friday">{{__('SuperAdmin/backend.Friday')}}</option>
                                            <option value="Saturday">{{__('SuperAdmin/backend.Saturday')}}</option>
                                            <option value="Sunday">{{__('SuperAdmin/backend.Sunday')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 available_days" style="display: none">
                                        <label>{{__('SuperAdmin/backend.available_days')}}:</label>
                                        <input class="form-control yeardatepicker" data-index="0" name="available_days[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_symbol')}}:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            <option value="%" selected>%</option>
                                            <option value="-">-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_start_date')}}:</label>
                                        <input class="form-control" type="date" name="discount_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_end_date')}}:</label>
                                        <input class="form-control" type="date" name="discount_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_start_date')}}:</label>
                                        <input class="form-control" type="date" name="christmas_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_end_date')}}:</label>
                                        <input class="form-control" type="date" name="christmas_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_selected')}}:</label>
                                        <input class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('SuperAdmin/backend.every_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.free_week')}}:</label>
                                        <select class="form-control" name="how_many_week_free[]">
                                            <option value='1' selected>{{__('SuperAdmin/backend.1_week_free')}} </option>
                                            <option value='2'>{{__('SuperAdmin/backend.2_week_free')}}</option>
                                            <option value='3'>{{__('SuperAdmin/backend.3_week_free')}}</option>
                                            <option value='4'>{{__('SuperAdmin/backend.4_week_free')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_start_date')}}:</label>
                                        <input class="form-control" type="date" name="x_week_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_end_date')}}:</label>
                                        <input class="form-control" type="date" name="x_week_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee')}}:</label>
                                        <input class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_start_date')}}:</label>
                                        <input class="form-control" type="date" name="summer_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_end_date')}}:</label>
                                        <input class="form-control" type="date" name="summer_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_fee_per_week')}}:</label>
                                        <input class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_start_date')}} :</label>
                                        <input class="form-control" type="date" name="peak_time_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_end_date')}} :</label>
                                        <input class="form-control" type="date" name="peak_time_end_date[]">
                                    </div>
                                </div>

                                <script>
                                    window.addEventListener('load', function() {
                                        yeardatepicker_days.push([]);
                                        yeardatepicker_months.push([]);
                                    }, false );
                                </script>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addCourseProgram($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="removeCourseProgram($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <a onclick="updateCourseForm($(this));" class="btn btn-primary pull-right">{{__('SuperAdmin/backend.submit')}}</a>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.include.modals')
    
    @section('js')
        <script>
            var uploadFileOption = "{{route('superadmin.course.upload', ['_token' => csrf_token() ])}}";
        </script>
    @endsection
@endsection