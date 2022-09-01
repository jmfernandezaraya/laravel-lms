@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_course')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_course')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>
                
                <div id="menu">
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ auth('superadmin')->check() ? route('superadmin.course.store') : route('schooladmin.course.store') }}" id="form1">
                    {{csrf_field()}}

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="have_accommodation">
                                    {{__('Admin/backend.course_have_accommodation')}}:
                                </label>
                                <div class="3col active">
                                    <input type="radio" value="yes" name="accommodation" checked>
                                    <label for="have_accommodation_yes">
                                        {{__('Admin/backend.yes')}}
                                    </label>
                                    <input type="radio" value="no" name="accommodation">
                                    <label for="have_accommodation_no">
                                        {{__('Admin/backend.no')}}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-4"></div>
                            <div class="form-group col-md-4"></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="language">{{__('Admin/backend.choose_lang')}}:</label>
                                <select name="language[]" multiple="multiple" id="language_choose" class="3col active">
                                    @foreach ($choose_languages as $choose_language)
                                        <option value="{{$choose_language->unique_id}}">{{$choose_language->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="study_mode">{{__('Admin/backend.choose_study_mode')}}:</label>
                                <select name="study_mode[]" id="study_mode_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_study_modes as $study_mode)
                                        <option value="{{$study_mode->unique_id}}">{{$study_mode->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="program_type">{{__('Admin/backend.choose_program_type')}}:</label>
                                <select name="program_type[]" id="program_type_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_program_types as $program_type)
                                        <option value="{{$program_type->unique_id}}">{{$program_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">{{__('Admin/backend.choose_school')}}:</label>
                                <select onchange="changeSchool()" class="form-control" id="school_name" name="school_name">
                                    <option value="">{{__('Admin/backend.select_school')}}</option>
                                    @foreach ($choose_schools as $choose_school)
                                        <option value="{{$choose_school}}">{{ $choose_school }}</option>
                                    @endforeach
                                </select>  
                            </div>
                            <div class="form-group col-md-4">
                                <label for="country_name">{{__('Admin/backend.choose_country')}}:</label>
                                <select onchange="changeUserCountry()" class="form-control" id="country_name" name="country_id">
                                    <option value="">{{__('Admin/backend.select')}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="city_name">{{__('Admin/backend.choose_city')}}:</label>
                                <select onchange="changeCity()" class="form-control" id="city_name" name="city_id">
                                    <option value="">{{__('Admin/backend.select')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="branch">{{__('Admin/backend.add_branch_if_applicable')}}:</label>
                                <select class="form-control" name="branch" id="branch_choose">
                                    <option value="">{{__('Admin/backend.select')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="choose_currency">{{__('Admin/backend.choose_currency')}}:</label>
                                <select class="form-control" id="choose_currency" name="currency">
                                    <option value="">{{__('Admin/backend.select')}}</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{$currency->id}}">{{app()->getLocale() == 'en' ? $currency->name : $currency->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="link_fee">{{__('Admin/backend.link_fee')}}:</label>
                                <select class="form-control" id="link_fee_enable" name="link_fee_enable">
                                    <option value="1">{{__('Admin/backend.enable')}}</option>
                                    <option value="0">{{__('Admin/backend.disable')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <h3>{{__('Admin/backend.program_features')}}</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="program_name">{{__('Admin/backend.program_name')}}:</label>
                                <div class="english">
                                    <input class="form-control" type="text" name="program_name" placeholder="{{__('Admin/backend.program_name')}}">
                                </div>
                                <div class="arabic">
                                    <input class="form-control" type="text" name="program_name_ar" placeholder="{{__('Admin/backend.program_name')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="program_level_required">{{__('Admin/backend.level_required')}}:</label>
                                <div class="english">
                                    <input class="form-control" type="text" name="program_level" placeholder="{{__('Admin/backend.level_required')}}">
                                </div>
                                <div class="arabic">
                                    <input class="form-control" type="text" name="program_level_ar" placeholder="{{__('Admin/backend.level_required')}}">                                    
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="lessons_per_week">{{__('Admin/backend.lessons_per_week')}}:</label>
                                <input class="form-control" type="number" name="lessons_per_week" placeholder="{{__('Admin/backend.lessons_per_week')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="hours_per_week">{{__('Admin/backend.hours_per_week')}}:</label>
                                <input class="form-control" type="number" name="hours_per_week" placeholder="{{__('Admin/backend.hours_per_week')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="study_time">{{__('Admin/backend.study_time')}}:</label>
                                <select name="study_time[]" id="study_time_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_study_times as $study_time)
                                        <option value="{{$study_time->unique_id}}">{{$study_time->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="classes_day">{{__('Admin/backend.classes_days')}}:</label>
                                <select name="classes_day[]" id="classes_day_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_classes_days as $classes_day)
                                        <option value="{{$classes_day->unique_id}}">{{$classes_day->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="start_date">{{__('Admin/backend.start_dates')}}:</label>
                                <select name="start_date[]" id="start_date_choose" multiple="multiple" class="3col active">
                                    @foreach ($choose_start_days as $start_day)
                                        <option value="{{$start_day->unique_id}}">{{$start_day->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{__('Admin/backend.program_information')}}:</label>
                                <div class="english">
                                    <textarea class="form-control ckeditor-input" name="program_information" placeholder="{{__('Admin/backend.program_information')}}" id="program_information"></textarea>
                                </div>
                                <div class="arabic">
                                    <textarea class="form-control ckeditor-input" name="program_information_ar" placeholder="{{__('Admin/backend.program_information')}}" id="program_information_ar"></textarea>
                                </div>
                            </div>
                        </div>

                        <script>
                            window.addEventListener('load', function() {
                                course_program_clone = 0;
                            }, false );
                        </script>

                        <input hidden id="program_increment" name="program_increment" value="0">

                        <div id="course_program_clone0" class="course-program-clone clone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h3>{{__('Admin/backend.program_cost')}}</h3>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="program_name">{{__('Admin/backend.program_id')}}:</label>
                                    <input readonly class="form-control" value="{{time() . rand(000, 999)}}" type="text" id="program_id0" name="program_id[]">
                                </div>
                                <div class="form-group col-md-4"></div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.link_study_abroad_fee')}}: ({{ getGetDefaultCurrencyName() }})</label>
                                    <input class="form-control" type="number" name="link_fee[]" placeholder="{{__('Admin/backend.link_study_abroad_fee')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.tax_percent')}}(%):</label>
                                    <input class="form-control" type="number" name="tax_percent[]" placeholder="{{__('Admin/backend.tax_percent')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.bank_transfer_fee')}}:</label>
                                    <input class="form-control" type="number" name="bank_transfer_fee[]" placeholder="{{__('Admin/backend.bank_transfer_fee')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_registration_fee')}}:</label>
                                    <input class="form-control" type="number" name="program_registration_fee[]" placeholder="{{__('Admin/backend.program_registration_fee')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_duration')}}:</label>
                                    <input class="form-control" type="number" name="program_duration[]" placeholder="{{__('Admin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                </div>
                                <div class="col-md-2">
                                    <label>{{__('Admin/backend.program_deposit')}}:</label>
                                    <input class="form-control" type="number" name="deposit[]" placeholder="{{__('Admin/backend.deposit')}}">
                                </div>
                                <div class="col-md-2">
                                    <label>{{__('Admin/backend.deposit_symbol')}}:</label>
                                    <select class="form-control" name="deposit_symbol[]">
                                        <option value="%" selected>%</option>
                                        <option value="fixed">{{__('Admin/backend.fixed')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4 age_range">
                                    <label for="program_age_range">{{__('Admin/backend.age_range')}}:</label>
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
                                    <label>{{__('Admin/backend.courier_fee')}}:</label>
                                    <input type="number" class="form-control" name="courier_fee[]" placeholder="{{__('Admin/backend.courier_fee')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>{{__('Admin/backend.about_courier')}}:</label>
                                    <div class="english">
                                        <textarea class="form-control ckeditor-input" name="about_courier[]" placeholder="{{__('Admin/backend.about_courier')}}" id="about_courier0"></textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="about_courier_ar[]" placeholder="{{__('Admin/backend.about_courier')}}" id="about_courier_ar0"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_cost')}}:</label>
                                    <input class="form-control" type="text" name="program_cost[]" placeholder="{{__('Admin/backend.program_cost')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_duration_start')}}:</label>
                                    <input class="form-control" type="text" name="program_duration_start[]" placeholder="{{__('Admin/backend.program_duration_start')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_duration_end')}}:</label>
                                    <input class="form-control" type="text" name="program_duration_end[]" placeholder="{{__('Admin/backend.program_duration_end')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_start_date')}}:</label>
                                    <input class="form-control" type="date" name="program_start_date[]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.program_end_date')}}:</label>
                                    <input class="form-control" type="date" name="program_end_date[]">
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.available_dates')}}:</label>
                                    <select class="form-control available_date" name="available_date[]">
                                        <option value="start_day_every" selected>{{__('Admin/backend.start_day_every')}}</option>
                                        <option value="selected_dates">{{__('Admin/backend.selected_dates')}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 select_day_week">
                                    <label>{{__('Admin/backend.select_day')}}:</label>
                                    <select class="form-control" name="select_day_week[]">
                                        <option value="Monday" selected>{{__('Admin/backend.Monday')}}</option>
                                        <option value="Tuesday">{{__('Admin/backend.Tuesday')}}</option>
                                        <option value="Wednesday">{{__('Admin/backend.Wednesday')}}</option>
                                        <option value="Thursday">{{__('Admin/backend.Thursday')}}</option>
                                        <option value="Friday">{{__('Admin/backend.Friday')}}</option>
                                        <option value="Saturday">{{__('Admin/backend.Saturday')}}</option>
                                        <option value="Sunday">{{__('Admin/backend.Sunday')}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 available_days" style="display: none">
                                    <label>{{__('Admin/backend.available_days')}}:</label>
                                    <input class="form-control yeardatepicker" data-index="0" name="available_days[]">
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.discount_per_week')}}:</label>
                                    <input class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('Admin/backend.discount_per_week')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.discount_symbol')}}:</label>
                                    <select class="form-control" name="discount_per_week_symbol[]">
                                        <option value="%" selected>%</option>
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.discount_start_date')}}:</label>
                                    <input class="form-control" type="date" name="discount_start_date[]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.discount_end_date')}}:</label>
                                    <input class="form-control" type="date" name="discount_end_date[]">
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.christmas_start_date')}}:</label>
                                    <input class="form-control" type="date" name="christmas_start_date[]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.christmas_end_date')}}:</label>
                                    <input class="form-control" type="date" name="christmas_end_date[]">
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.x_week_selected')}}:</label>
                                    <input class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('Admin/backend.every_week')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.free_week')}}:</label>
                                    <select class="form-control" name="how_many_week_free[]">
                                        <option value='1' selected>{{__('Admin/backend.1_week_free')}} </option>
                                        <option value='2'>{{__('Admin/backend.2_week_free')}}</option>
                                        <option value='3'>{{__('Admin/backend.3_week_free')}}</option>
                                        <option value='4'>{{__('Admin/backend.4_week_free')}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.x_week_start_date')}}:</label>
                                    <input class="form-control" type="date" name="x_week_start_date[]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.x_week_end_date')}}:</label>
                                    <input class="form-control" type="date" name="x_week_end_date[]">
                                </div>
                                <div class="form-group col-md-4"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.summer_fee')}}:</label>
                                    <input class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('Admin/backend.summer_fee_per_week')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.summer_fee_start_date')}}:</label>
                                    <input class="form-control" type="date" name="summer_fee_start_date[]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.summer_fee_end_date')}}:</label>
                                    <input class="form-control" type="date" name="summer_fee_end_date[]">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.peak_time_fee_per_week')}}:</label>
                                    <input class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.peak_time_start_date')}} :</label>
                                    <input class="form-control" type="date" name="peak_time_start_date[]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('Admin/backend.peak_time_end_date')}} :</label>
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
                    </div>

                    <a onclick="submitCourseForm($(this));" class="btn btn-primary pull-right">{{__('Admin/backend.submit')}}</a>
                </form>
            </div>
        </div>
    </div>

    @include('admin.include.modals')

    @section('js')
        <script>
            var uploadFileOption = "{{ auth('superadmin')->check() ? route('superadmin.course.upload', ['_token' => csrf_token() ]) : route('schooladmin.course.upload', ['_token' => csrf_token() ]) }}";
        </script>
    @endsection
@endsection