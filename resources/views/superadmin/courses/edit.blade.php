@extends('superadmin.layouts.app')

@section('content')
    @include('superadmin.courses.scripts')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_course')}}</h1>
                    <change>
                        @if(app()->getLocale() == 'en')
                            {{__('SuperAdmin/backend.in_english')}}
                        @endif
                        @if(app()->getLocale() == 'ar')
                            {{__('SuperAdmin/backend.in_arabic')}}
                        @endif
                    </change>
                </div>

                @include('superadmin.include.alert')
                
                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="current_page_item selected">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}</a>
                        </li>
                        <li>
                            <a onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                <div id="show_form"></div>

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.update", $courses->unique_id)}}" id="form1">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="program_language">
                                    {{__('SuperAdmin/backend.choose_lang')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#LanguageModal" aria-hidden="true"></i>
                                    <i class="fa fa-trash pl-3" onclick="delete_language()" aria-hidden="true"></i>
                                </label>
                                <select name="language[]" id="language_choose" multiple="multiple" class="3col active">
                                    @foreach($choose_languages as $choose_language)
                                        <option value="{{$choose_language->unique_id}}" {{in_array($choose_language->unique_id, (array)$courses->language ?? []) ? 'selected' : ''  }}>{{$choose_language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="program_language">{{__('SuperAdmin/backend.choose_study_mode')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudyModeModal" aria-hidden="true"></i>
                                    <i class="fa fa-trash pl-3" onclick="deleteStudyMode()" aria-hidden="true"></i>
                                </label>
                                <select name="study_mode[]" id="study_mode_choose" multiple="multiple" class="3col active">
                                    @foreach($choose_study_modes as $study_mode)
                                        <option value="{{$study_mode->unique_id}}" {{in_array($study_mode->unique_id, (array)$courses->study_mode ?? []) ? 'selected' : ''  }}>{{$study_mode->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="program_language">{{__('SuperAdmin/backend.choose_program_type')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramTypeModal" aria-hidden="true"></i>
                                    <i onclick="deleteProgramType()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="program_type[]" id="program_type_choose" multiple="multiple" class="3col active">
                                    @foreach($choose_program_types as $program_type)
                                        <option value="{{$program_type->unique_id}}" {{in_array($program_type->unique_id, (array)$courses->program_type ?? []) ? 'selected' : ''  }}>{{$program_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="school_name">{{__('SuperAdmin/backend.choose_school')}}:</label>
                                <select onchange="getSchool(url_schols, $(this).val())" class="form-control" id="school_name" name="school_id">
                                    <option value="">{{__('SuperAdmin/backend.select_school')}}</option>
                                    @foreach($schools as $school)
                                        <option value="{{$school->id}}" {{in_array($school->id, (array)$courses->school_id ?? []) ? 'selected' : ''  }}>{{get_language() == 'en' ?  $school->name : $school->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="country_name">{{__('SuperAdmin/backend.choose_country')}}:</label>
                                <select class="form-control" id="country_name" name="country">
                                    <option>{{__('SuperAdmin/backend.select')}}</option>
                                    <option value="{{$courses->country}}" selected>{{$courses->country}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="city_name">{{__('SuperAdmin/backend.choose_city')}}:</label>
                                <select class="form-control" id="city_name" name="city">
                                    <option>{{__('SuperAdmin/backend.select')}}</option>
                                    <option value="{{$courses->city}}" selected>{{$courses->city}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="branch">{{__('SuperAdmin/backend.add_branch_if_applicable')}}
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#BranchModal" aria-hidden="true"></i>
                                    <i class="fa fa-trash pl-3" aria-hidden="true" onclick="deleteBranch()"></i>
                                </label>
                                <select name="branch[]" id="branch_choose" multiple="multiple" class="3col active2">
                                    @foreach($choose_branches as $branch)
                                        <option value="{{$branch->unique_id}}" {{$branch->unique_id == $courses->branch ? 'selected' : ''}}>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label for="choose_currency">{{__('SuperAdmin/backend.choose_currency')}}:</label>
                                <select class="form-control" id="choose_currency" name="currency">
                                    <option value="">{{__('SuperAdmin/backend.select')}}</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}" {{$currency->id == $courses->currency ? 'selected' : ''}}>{{$currency->name}}</option>
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
                                <input value="{{$courses->program_name}}" class="form-control" type="text" name="program_name" placeholder="@lang('SuperAdmin/backend.program_name')">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="program_level_required">{{__('SuperAdmin/backend.level_required')}}:</label>
                                <input value="{{$courses->program_level}}" class="form-control" type="text" name="program_level" placeholder="program level required">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="lessons_per_week">{{__('SuperAdmin/backend.lessons_per_week')}}:</label>
                                <input value="{{$courses->lessons_per_week}}" class="form-control" type="number" name="lessons_per_week" placeholder="lessons per week">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="hours_per_week">{{__('SuperAdmin/backend.hours_per_week')}}:</label>
                                <input value="{{$courses->hours_per_week}}" class="form-control" type="number" name="hours_per_week" placeholder="hours per week">
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
                                        <option value="{{$study_time->unique_id}}" {{in_array($study_time->unique_id, (array)$courses->study_time ?? []) ? 'selected' : ''  }}>{{$study_time->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="classes_days">{{__('SuperAdmin/backend.classes_days')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudyTimeModal" aria-hidden="true"></i>
                                    <i onclick="deleteClassesDay()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="classes_day[]" id="classes_day_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_classes_days as $classes_day)
                                        <option value="{{$classes_day->unique_id}}" {{in_array($classes_day->unique_id, (array)$courses->classes_day ?? []) ? 'selected' : ''  }}>{{$study_time->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="start_date">{{__('SuperAdmin/backend.start_dates')}}
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StartDateModal" aria-hidden="true"></i>
                                    <i onclick="deleteStartDate()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <select name="start_date[]" id="start_date_choose" multiple="multiple" class="3col active">
                                    @foreach($choose_start_days as $start_date)
                                        <option value="{{$start_date->unique_id}}" {{in_array($start_date->unique_id, (array)$courses->start_date ?? []) ? 'selected' : ''  }}>{{$start_date->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{__('SuperAdmin/backend.program_information')}}:</label>
                                <textarea class="form-control" name="program_information" placeholder="{{__('SuperAdmin/backend.program_information')}}" id="program_information">{!! $courses->program_information !!}</textarea>
                            </div>
                        </div>

                        <input hidden name="program_increment" value="{{$courses->coursePrograms ? $courses->coursePrograms->count() - 1 : 0}}">

                        @forelse ($courses->coursePrograms as $programs)
                            <div id="course_program_clone{{$loop->iteration - 1}}" class="course-program-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h3>{{__('SuperAdmin/backend.program_cost')}}</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="program_name">{{__('SuperAdmin/backend.program_id')}}:</label>
                                        <input readonly class="form-control" value="{{$programs->unique_id}}" type="text" id="program_id{{$loop->iteration - 1}}" name="program_id[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_registration_free')}}:</label>
                                        <input class="form-control" value="{{$programs->program_registration_fee}}" type="number" name="program_registration_fee[]" placeholder="{{__('SuperAdmin/backend.program_registration_free')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input class="form-control" value="{{$programs->program_duration}}" type="number" name="program_duration[]" id="gotilla" placeholder="{{__('SuperAdmin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.program_deposit')}}:</label>
                                        <input class="form-control" value="{{$programs->deposit ? explode(" ", $programs->deposit)[0] : ''}}" type="number" name="deposit[]" placeholder="{{__('SuperAdmin/backend.deposit')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.deposit_symbol')}}:</label>
                                        <select class="form-control" name="deposit_symbol[]">
                                            <option {{$programs->deposit && explode(" ", $programs->deposit)[1] == '%' ? 'selected' :'' }}>%</option>
                                            <option {{$programs->deposit && explode(" ", $programs->deposit)[1] == 'fixed' ? 'selected' :'' }}>{{__('SuperAdmin/backend.fixed')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="program_age_range">{{__('SuperAdmin/backend.age_range')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteProgramAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select name="age_range[{{$loop->iteration - 1}}][]" id="program_age_range_choose{{$loop->iteration - 1}}" multiple="multiple" class="3col active">
                                            @foreach($choose_program_age_ranges as $choose_program_age_range)
                                                <option value="{{$choose_program_age_range->unique_id}}" {{in_array($choose_program_age_range->unique_id, (array)$programs->program_age_range ?? []) ? 'selected' : ''  }}>{{$choose_program_age_range->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.courier_fee')}}:</label>
                                        <input type="number" class="form-control" name="courier_fee[]" value="{{$programs->courier_fee}}" placeholder="{{__('SuperAdmin/backend.courier_fee')}}">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.about_courier')}}:</label>
                                        <textarea class="form-control tinymce" name="about_courier[]" id="about_courier{{$loop->iteration - 1}}" placeholder="{{__('SuperAdmin/backend.about_courier')}}" rows="3">{!! get_language() == 'en' ?  $programs->about_courier :  $programs->about_courier_ar !!}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_cost')}}:</label>
                                        <input value="{{$programs->program_cost}}" class="form-control" type="number" name="program_cost[]" placeholder="{{__('SuperAdmin/backend.program_cost')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration_start')}}:</label>
                                        <input value="{{$programs->program_duration_start}}" class="form-control" type="number" name="program_duration_start[]" placeholder="{{__('SuperAdmin/backend.program_duration_start')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration_end')}}:</label>
                                        <input value="{{$programs->program_duration_end}}" class="form-control" type="number" name="program_duration_end[]" placeholder="{{__('SuperAdmin/backend.program_duration_end')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_start_date')}}:</label>
                                        <input value="{{$programs->program_start_date}}" class="form-control" type="date" name="program_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_end_date')}}:</label>
                                        <input value="{{$programs->program_end_date}}" class="form-control" type="date" name="program_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.available_dates')}}:</label>
                                        <select class="form-control available_date" name="available_date[]">
                                            <option value="start_day_every" {{$programs->available_date == 'start_day_every' ? 'selected' : ''}}>{{__('SuperAdmin/backend.start_day_every')}}</option>
                                            <option value="selected_dates" {{$programs->available_date == 'selected_dates' ? 'selected' : ''}}>{{__('SuperAdmin/backend.selected_dates')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.select_day')}}:</label>
                                        <select class="form-control select_day_week" name="select_day_week[]" {{$programs->available_date == 'selected_dates' ? 'style=display:none' : ""}}>
                                            <option value="Monday" {{($programs->select_day_week == 'Monday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Monday')}}</option>
                                            <option value="Tuesday" {{($programs->select_day_week == 'Tuesday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Tuesday')}}</option>
                                            <option value="Wednesday" {{($programs->select_day_week == 'Wednesday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Wednesday')}}</option>
                                            <option value="Thursday" {{($programs->select_day_week == 'Thursday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Thursday')}}</option>
                                            <option value="Friday" {{($programs->select_day_week == 'Friday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Friday')}}</option>
                                            <option value="Saturday" {{($programs->select_day_week == 'saturday' ? 'selected' : '')}}>{{__('SuperAdmin/backend.Saturday')}}</option>
                                        </select>
                                        <input class="form-control available_days yeardatepicker" value="{{$programs->available_days}}" name="available_days[]" {{$programs->available_date == 'start_day_every' ? 'style=display:none' : ""}}>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input value="{{explode(" ", $programs->discount_per_week)[0]}}" class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_symbol')}}:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            <option {{explode(" ", $programs->discount_per_week)[1] == '%' ? 'selected' :'' }}>%</option>
                                            <option {{explode(" ", $programs->discount_per_week)[1] == '-' ? 'selected' :'' }}>-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_start_date')}}:</label>
                                        <input value="{{$programs->discount_start_date}}" class="form-control" type="date" name="discount_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.discount_end_date')}}:</label>
                                        <input value="{{$programs->discount_end_date}}" class="form-control" type="date" name="discount_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_start_date')}}:</label>
                                        <input class="form-control" value="{{$programs->christmas_start_date}}" type="date" name="christmas_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_end_date')}}:</label>
                                        <input class="form-control" value="{{$programs->christmas_end_date}}" type="date" name="christmas_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_selected')}}:</label>
                                        <input value="{{$programs->x_week_selected}}" class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('SuperAdmin/backend.every_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.free_week')}}:</label>
                                        <select class="form-control" name="how_many_week_free[]">
                                            <option value=''>{{__('SuperAdmin/backend.select')}} </option>
                                            <option value='1' {{$programs->how_many_week_free == 1 ? 'selected' : ''}}>{{__('SuperAdmin/backend.1_week_free')}} </option>
                                            <option value='2' {{$programs->how_many_week_free == 2 ? 'selected' : ''}}>{{__('SuperAdmin/backend.2_week_free')}}</option>
                                            <option value='3' {{$programs->how_many_week_free == 3 ? 'selected' : ''}}>{{__('SuperAdmin/backend.3_week_free')}}</option>
                                            <option value='4' {{$programs->how_many_week_free == 4 ? 'selected' : ''}}>{{__('SuperAdmin/backend.4_week_free')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_start_date')}}:</label>
                                        <input value="{{$programs->x_week_start_date}}" class="form-control" type="date" name="x_week_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_end_date')}}:</label>
                                        <input value="{{$programs->x_week_end_date}}" class="form-control" type="date" name="x_week_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee')}}:</label>
                                        <input value="{{$programs->summer_fee_per_week}}" class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_start_date')}}:</label>
                                        <input value="{{$programs->summer_fee_start_date}}" class="form-control" type="date" name="summer_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_end_date')}}:</label>
                                        <input value="{{$programs->summer_fee_end_date}}" class="form-control" type="date" name="summer_fee_end_date[]">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_fee_per_week')}}:</label>
                                        <input value="{{$programs->peak_time_fee_per_week}}" class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_start_date')}}:</label>
                                        <input value="{{$programs->peak_time_start_date}}" class="form-control" type="date" name="peak_time_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_end_date')}}:</label>
                                        <input value="{{$programs->peak_time_end_date}}" class="form-control" type="date" name="peak_time_end_date[]">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addProgramCost($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus"  type="button" onclick="removeProgramCost($(this))"></button>
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
                                        <input readonly class="form-control" value="{{time().rand(00,99)}}" type="text" id="program_id0" name="program_id[]">
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
                                        <input class="form-control" type="number" name="program_duration[]" id="gotilla" placeholder="{{__('SuperAdmin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.program_deposit')}}:</label>
                                        <input class="form-control" type="number" name="deposit[]" placeholder="{{__('SuperAdmin/backend.deposit')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{__('SuperAdmin/backend.deposit_symbol')}}:</label>
                                        <select class="form-control" name="deposit_symbol[]">
                                            <option value="%">%</option>
                                            <option value="fixed">{{__('SuperAdmin/backend.fixed')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="program_age_range">{{__('SuperAdmin/backend.age_range')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteProgramAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select id="program_age_range_choose0" name="age_range[0][]" multiple="multiple" class="3col active">
                                            @foreach($choose_program_age_ranges as $program_age_range)
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
                                        <textarea class="form-control tinymce" id="about_courier0" name="about_courier[]" placeholder="{{__('SuperAdmin/backend.about_courier')}}" rows="3" name=""></textarea>
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
                                            <option value="start_day_every">{{__('SuperAdmin/backend.start_day_every')}}</option>
                                            <option value="selected_dates">{{__('SuperAdmin/backend.selected_dates')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.select_day')}}:</label>
                                        <select class="form-control select_day_week" name="select_day_week[]">
                                            <option value="Monday">{{__('SuperAdmin/backend.Monday')}}</option>
                                            <option value="Tuesday">{{__('SuperAdmin/backend.Tuesday')}}</option>
                                            <option value="Wednesday">{{__('SuperAdmin/backend.Wednesday')}}</option>
                                            <option value="Thursday">{{__('SuperAdmin/backend.Thursday')}}</option>
                                            <option value="Friday">{{__('SuperAdmin/backend.Friday')}}</option>
                                            <option value="Saturday">{{__('SuperAdmin/backend.Saturday')}}</option>
                                        </select>
                                        <input class="form-control available_days yeardatepicker" name="available_days[]" style="display: none">
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
                                        <select class="form-control" name="discount_symbol[]">
                                            <option value="%">%</option>
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
                                            <option value='1'>{{__('SuperAdmin/backend.1_week_free')}} </option>
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
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addProgramCost($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus"  type="button" onclick="removeProgramCost($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <script>
                        datepicker_available_days = "{{!empty($programs) ? $programs->available_days : ''}}".split(",");
                    </script>
                    
                    <a onclick="getCourseProgramContents(); updateCourseForm($(this));" class="btn btn-primary pull-right">{{__('SuperAdmin/backend.submit')}}</a>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.courses.modals')
@endsection