@extends('schooladmin.layouts.app')
@section('content')
@section('css')
    <style>
        .pl-3:hover {
            cursor: pointer;
        }

        .pull-right {
            margin-left: 300px !important;
        }

        .fa {
            cursor: pointer;
        }

        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none !important;
        }

        #ms-list-1, #ms-list-2, #ms-list-3, #ms-list-4, #ms-list-5, #ms-list-6, #ms-list-7, #ms-list-8, #ms-list-9, #ms-list-11, #ms-list-10 {
            padding: 10px 8px;
            border: 1px solid #ebedf2;
        }

        .ms-options-wrap > .ms-options {
            left: 21px;
            width: 87%;
        }

        button {
            border: none !important;
        }

        i.fa.fa-plus-circle {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 15px 15px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
        }

        i.fa.fa-minus {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 15px 15px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
        }

        i.fa.fa-plus {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
        }

        i.fa.fa-trash {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
        }
    </style>
@endsection

@include('superadmin.courses.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h4 class="card-title">@lang('SuperAdmin/backend.add_course') </h4>
                <change>{{__('SuperAdmin/backend.in_english')}}</change>
            </div>

            @include('superadmin.include.alert')
            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}
                        </a>
                    </li>
                </ul>
            </div>

            <div id="show_form"></div>

            <form class="forms-sample" method="POST" action="{{route("superadmin.course.store")}}" id="forms">
                {{csrf_field()}}
                <input hidden name="about_program" id="about_program_value">
                <input hidden name="about_courier" id="about_courier_value">
                <input hidden name="text_book_note" id="text_book_note_value">
                <input hidden name="special_diet_note" id="special_diet_note_value">
                <input hidden name="medical_insurance_note" id="medical_insurance_note_value">
                <div class="first-form">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="program_language">{{__('SuperAdmin/backend.choose_lang')}}:
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#LanguageModal" aria-hidden="true"></i>
                                <i class="fa fa-trash pl-3" onclick="delete_language()" aria-hidden="true"></i>
                            </label>
                            <select name="language[]" multiple="multiple" id="language_choose" class="3col active">
                                @foreach($choose_languages as $choose_language)
                                    <option value="{{$choose_language->name}}">{{$choose_language->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">@lang('SuperAdmin/backend.choose_study_mode'):
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudymodeModal" aria-hidden="true"></i>
                                <i class="fa fa-trash pl-3" onclick="deleteStudyMode()" aria-hidden="true"></i>
                            </label>
                            <select name="study_mode[]" id="study_mode_choose" multiple="multiple" class="3col active">
                                @foreach(\App\Models\SuperAdmin\Choose_Study_Mode::all() as $studymode)
                                    <option value="{{$studymode->name}}">{{$studymode->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">{{__('SuperAdmin/backend.choose_program_type')}}:
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramTypeModal" aria-hidden="true"></i>
                                <i onclick="deleteProgramType()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="program_type[]" id="program_type_choose" multiple="multiple" class="3col active">
                                @foreach(\App\Models\SuperAdmin\Choose_Program_Type::all() as $program_type)
                                    <option value="{{$program_type->name}}">{{$program_type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="name">{{__('SuperAdmin/backend.choose_school')}}:</label>
                            <select onchange="changeCourseSchool()" class="form-control" id="name" name="school_id">
                                <option value="">{{__('SuperAdmin/backend.select_school')}}</option>
                                @foreach($schools as $school)
                                    <option value="{{$school->unique_id}}">{{$school->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="country_name">{{__('SuperAdmin/backend.choose_country')}}:</label>
                            <select onchange="changeCourseCountry()" class="form-control" id="country_name" name="">
                                <option>{{__('SuperAdmin/backend.select')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city_name">{{__('SuperAdmin/backend.choose_city')}}:</label>
                            <select onchange="changeCourseCity()" class="form-control" id="city_name" name="">
                                <option>{{__('SuperAdmin/backend.select')}}</option>

                            </select>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="add_branch">Add Branch "if Applicable"
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#exampleModal9" aria-hidden="true"></i>
                                <i class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="branch[]" multiple="multiple" class="3col active2">
                                <option value="Branch1">{{__('SuperAdmin/backend.select')}}</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="choose_currency">{{__('SuperAdmin/backend.choose_currency')}}:</label>
                            <select class="form-control" id="choose_currency" name="currency">
                                <option>{{__('SuperAdmin/backend.USD')}}</option>
                                <option>{{__('SuperAdmin/backend.GBP')}}</option>
                                <option>{{__('SuperAdmin/backend.CAD')}}</option>
                                <option>{{__('SuperAdmin/backend.AUS')}}</option>
                                <option>{{__('SuperAdmin/backend.NZD')}}</option>
                                <option>{{__('SuperAdmin/backend.EUR')}}</option>
                            </select>
                            <br>
                            <br>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>

                    <h2>{{__('SuperAdmin/backend.program_features')}}</h2>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="program_name">@lang('SuperAdmin/backend.program_name') </label>
                            <input class="form-control" type="text" name="program_name" placeholder="@lang('SuperAdmin/backend.program_name')">
                        </div>
                        <div class="col-md-4">
                            <label for="program_level_required">{{__('SuperAdmin/backend.level_required')}}:</label>
                            <input class="form-control" type="text" name="program_level" placeholder="program level required">
                        </div>
                        <div class="col-md-4">
                            <label for="lessons_per_week">{{__('SuperAdmin/backend.lessons_per_week')}}:</label>
                            <input class="form-control" type="text" name="lessons_per_week" placeholder="lessons per week">
                            <br><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="hours_per_week">{{__('SuperAdmin/backend.hours_per_week')}}:</label>
                            <input class="form-control" type="text" name="hours_per_week" placeholder="hours per week">
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">{{__('SuperAdmin/backend.study_time')}}:
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudyTimeModal" aria-hidden="true"></i>
                                <i onclick="deleteStudyTime()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="study_time[]" multiple="multiple" id="study_time_choose" class="3col active">
                                @foreach (\App\Models\SuperAdmin\Choose_Study_Time::all() as $studytime)
                                    <option value="{{$studytime->name}}">{{$studytime->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="course_start_day">{{__('SuperAdmin/backend.start_day_every')}}
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StarDayModal" aria-hidden="true"></i>
                                <i onclick="deleteStartDay()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="every_day[]" id="start_dates_option" multiple="multiple" class="3col active">
                                @foreach(\App\Models\SuperAdmin\Choose_Start_Day::all() as $option)
                                    <option value="{{$option->name}}">{{$option->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group">
                        <label>About program: </label>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" name="" placeholder="About program" id="about_program"></textarea>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div id="clone_program_form0">
                        <div class="clone_program_with_clone_data">
                            <h2>{{__('SuperAdmin/backend.program_cost')}}</h2>
                            <br>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="program_name">{{__('SuperAdmin/backend.program_id')}}:</label>
                                    <input readonly class="form-control" value="{{time().rand(00,99)}}" type="text" id="program_id" name="program_id[]">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_registration_free')}}:</label>
                                        <input class="form-control" type="text" name="program_registration_fee[]" placeholder="{{__('SuperAdmin/backend.program_registration_free')}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input class="form-control" type="text" name="program_duration[]" id="gotilla" placeholder="{{__('SuperAdmin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Program_age_range">{{__('SuperAdmin/backend.age_range')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramAgeRangeModal" aria-hidden="true"></i>
                                    <i onclick="deleteProgramAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="to_be_inserted_age0"></div>
                                        <select name="age_range[0][]" id="program_age_range_choose0" multiple="multiple" class="3col active">
                                            @foreach(\App\Models\SuperAdmin\Choose_Program_Age_Range::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all() as $option)
                                                <option value="{{$option->age}}">{{$option->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{__('SuperAdmin/backend.courier_fee')}}:</label>
                                    <input type="text" class="form-control" name="courier_fee[]" placeholder="{{__('SuperAdmin/backend.courier_fee')}}">
                                    <br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Textarea : </label>
                                    <textarea class="form-control tinymce" id="about_courier" placeholder="textarea" rows="3" name=""></textarea>
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.program_cost'):</label>
                                    <input class="form-control" type="text" name="program_cost[]" placeholder="{{__('SuperAdmin/backend.program_cost')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.program_duration_start'):</label>
                                    <input class="form-control" type="text" name="program_duration_start[]" placeholder="{{__('SuperAdmin/backend.program_duration_start')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.program_duration_end'):</label>
                                    <input class="form-control" type="text" name="program_duration_end[]" placeholder="{{__('SuperAdmin/backend.program_duration_end')}}">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.program_start_date'):</label>
                                    <input class="form-control" type="date" name="program_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.program_end_date'):</label>
                                    <input class="form-control" type="date" name="program_end_date[]">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.discount_per_week'):</label>
                                    <input class="form-control" type="text" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.discount_symbol'):</label>
                                    <select class="form-control" name="discount_symbol[]">
                                        <option>%</option>
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.discount_start_date'):</label>
                                    <input class="form-control" type="date" name="discount_start_date[]">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.discount_end_date'):</label>
                                    <input class="form-control" type="date" name="discount_end_date[]">
                                    <br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.x_week_selected'):</label>
                                    <input class="form-control" type="text" name="x_week_selected[]" placeholder="{{__('SuperAdmin/backend.every_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.free_week'):</label>
                                    <select class="form-control" name="how_many_week_free[]">
                                        <option value='1'>{{__('SuperAdmin/backend.1_week_free')}} </option>
                                        <option value='2'>{{__('SuperAdmin/backend.2_week_free')}}</option>
                                        <option value='3'>{{__('SuperAdmin/backend.3_week_free')}}</option>
                                        <option value='4'>{{__('SuperAdmin/backend.4_week_free')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.x_week_start_date'):</label>
                                    <input class="form-control" type="date" name="x_week_start_date[]">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.x_week_end_date'):</label>
                                    <input class="form-control" type="date" name="x_week_end_date[]">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.summer_fee'):</label>
                                    <input class="form-control" type="text" name="program_summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.summer_fee_start_date'):</label>
                                    <input class="form-control" type="date" name="program_summer_fee_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.summer_fee_end_date'):</label>
                                    <input class="form-control" type="date" name="program_summer_fee_end_date[]">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.peak_time_fee_per_week'):</label>
                                    <input class="form-control" type="text" name="program_peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.peak_time_start_date') :</label>
                                    <input class="form-control" type="date" name="program_peak_time_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('SuperAdmin/backend.peak_time_end_date') :</label>
                                    <input class="form-control" type="date" name="program_peak_time_end_date[]">
                                </div>
                            </div>
                            <br><br>

                            <input hidden name="program_increment" value=0 id="increment_program">
                            <input hidden name="program_unique_id[]" value="{{rand(000, 999)}}" id="program_unique_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary fa fa-plus" type="button" name="####"
                                            id="add_program-dost-d0" onclick="addAnotherProgramCost($(this))"
                                            value="add another program cost"></button>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-danger fa fa-minus" type="button" name="####"
                                            id="remove_program_button0"  onclick="removeAnotherProgramCost($(this))"
                                            value="add another program cost"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>

                <script>
                    deletestudytimeurl = "{{route('superadmin.delete_study_time')}}"
                    course_url_store = "{{route('superadmin.course.store')}}";
                </script>
                <a onclick="getContent('about_program', 'about_program_value'); getContent('about_courier', 'about_courier_value'); submitCourseForm($(this));"
                    class="btn btn-primary pull-right">Submit</a>
            </form>
        </div>
    </div>
</div>

@include('superadmin.courses.modals')
@endsection


