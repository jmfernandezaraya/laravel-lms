@extends('branchadmin.layouts.app')
@section('content')
@section('css')

<style>
    .pl-3:hover {
        cursor: pointer;
    }
    
    .fa {
        cursor: pointer;
    }
    
    .tox .tox-notification--warn,
    .tox .tox-notification--warning {
        display: none !important;
    }
    
    #ms-list-1,
    #ms-list-2,
    #ms-list-3,
    #ms-list-4,
    #ms-list-5,
    #ms-list-6,
    #ms-list-7,
    #ms-list-8,
    #ms-list-9,
    #ms-list-11,
    #ms-list-10 {
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
    
    ul.multiselect-container.dropdown-menu.show {
        width: 100%;
    }
    
    .multiselect-native-select .btn-group {
        width: 100%;
    }
    
    button.multiselect.dropdown-toggle.btn.btn-default {
        outline: 1px solid #ebedf2;
        color: #c9c8c8;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
    }
    
    span.multiselect-selected-text {
        font-size: 12px;
        font-family: sans-serif;
    }
</style>
@endsection
@include('branchadmin.courses.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h4 class="card-title">@lang('Admin/backend.add_course') </h4>
                <change>{{__('Admin/backend.in_english')}}</change>
            </div>

            @include('branchadmin.include.alert')

            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                        </a>
                    </li>
                </ul>
            </div>
            {{--
            <form class="forms-sample" method="POST" action="{{route(" course.store ")}}" id="form1">
                {{csrf_field()}}
                <input hidden name="about_program" id="about_program_value">
                <input hidden name="about_courier" id="about_courier_value">
                <input hidden name="text_book_note" id="text_book_note_value">
                <input hidden name="special_diet_note" id="special_diet_note_value">
                <input hidden name="medical_insurance_note" id="medical_insurance_note_value">
                <div class="first-form">
                    <div class="row">
                        <!--popup_end-->
                        <div class="col-md-4">
                            <label for="program_language">{{__('Admin/backend.choose_lang')}}:
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#LanguageModal" aria-hidden="true"></i>
                                <i class="fa fa-trash pl-3" onclick="delete_language()" aria-hidden="true"></i>
                            </label>
                            <select name="language[]" multiple="multiple" id="language_choose" class="3col active">
                                @foreach($choose_languages as $choose_language)
                                <option value="{{$choose_language->unique_id}}">{{$choose_language->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">@lang('Admin/backend.choose_study_mode'):
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudymodeModal" aria-hidden="true"></i>
                                <i class="fa fa-trash pl-3" onclick="deleteStudyMode()" aria-hidden="true"></i>
                            </label>
                            <select name="study_mode[]" id="study_mode_choose" multiple="multiple" class="3col active">
                                @foreach(\App\Models\SuperAdmin\Choose_Study_Mode::all() as $studymode)
                                <option value="{{$studymode->unique_id}}">{{$studymode->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">{{__('Admin/backend.choose_program_type')}}:
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramTypeModal" aria-hidden="true"></i>
                                <i onclick="deleteProgramType()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="program_type[]" id="program_type_choose" multiple="multiple" class="3col active">
                                @foreach(\App\Models\SuperAdmin\Choose_Program_Type::all() as $program_type)
                                <option value="{{$program_type->unique_id}}">{{$program_type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="name">{{__('Admin/backend.choose_school')}}:</label>
                            <select onchange="changeSchool(url_school_country_list, $(this).val())" class="form-control" id="name" name="school_id">
                                <option value="">{{__('Admin/backend.select_school')}}</option>
                                @foreach($schools as $school)
                                <option value="{{$school->unique_id}}">{{$school->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="country_name">{{__('Admin/backend.choose_country')}}:</label>
                            <select class="form-control" id="country_name" name="">
                                <option>{{__('Admin/backend.select')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city_name">{{__('Admin/backend.choose_city')}}:</label>
                            <select class="form-control" id="city_name" name="">
                                <option>{{__('Admin/backend.select')}}</option>
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
                                <option value="Branch1">{{__('Admin/backend.select')}}</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="choose_currency">{{__('Admin/backend.choose_currency')}}:</label>
                            <select class="form-control" id="choose_currency" name="currency">
                                <!--<option>{{__('Admin/backend.select')}}</option>-->
                                <option>{{__('Admin/backend.USD')}}</option>
                                <option>{{__('Admin/backend.GBP')}}</option>
                                <option>{{__('Admin/backend.CAD')}}</option>
                                <option>{{__('Admin/backend.AUS')}}</option>
                                <option>{{__('Admin/backend.NZD')}}</option>
                                <option>{{__('Admin/backend.EUR')}}</option>
                            </select>
                            <br>
                            <br>
                        </div>
                        <div class="col-md-4"></div>
                    </div>

                    <h2>{{__('Admin/backend.program_features')}}</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="program_name">{{__('Admin/backend.program_name')}}:</label>
                            <input class="form-control" type="text" name="program_name" placeholder="Program Name">
                        </div>
                        <div class="col-md-4">
                            <label for="program_level_required">{{__('Admin/backend.level_required')}}:</label>
                            <input class="form-control" type="text" name="program_level_required" placeholder="program level required">
                        </div>
                        <div class="col-md-4">
                            <label for="lessons_per_week">{{__('Admin/backend.lessons_per_week')}}:</label>
                            <input class="form-control" type="text" name="lessons_per_week" placeholder="lessons per week">
                            <br>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="hours_per_week">{{__('Admin/backend.hours_per_week')}}:</label>
                            <input class="form-control" type="text" name="hours_per_week" placeholder="hours per week">
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">{{__('Admin/backend.study_time')}}:
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StudyTimeModal" aria-hidden="true"></i>
                                <i onclick="deleteStudyTime()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="study_time[]" multiple="multiple" id="study_time_choose" class="3col active">
                                <!--<option value="">{{__('Admin/backend.select')}}</option>-->
                                <option value="Morning">{{__('Admin/backend.morning')}}</option>
                                <option value="Afternoon">{{__('Admin/backend.afternoon')}}</option>
                                <option value="Evening">{{__('Admin/backend.evening')}}</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="course_start_day">{{__('Admin/backend.start_day_every')}}
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StarDayModal" aria-hidden="true"></i>
                                <i onclick="deleteStartDay()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="every_day[]" id="start_dates_option" multiple="multiple" class="3col active">
                                @foreach(\App\Models\SuperAdmin\Choose_Start_Day::all() as $option)
                                <option value="{{$option->unique_id}}">{{$option->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group">
                        <label>About program: </label>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" type="text" name="about_program" placeholder="About program" id="about_program"></textarea>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div id="clone_program_form0">
                        <div class="clone_program_with_clone_data">
                            <h2>{{__('Admin/backend.program_cost')}}</h2>
                            <br>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>{{__('Admin/backend.program_registration_free')}}:</label>
                                        <input class="form-control" type="text" name="program_registration_fee[]" placeholder="{{__('Admin/backend.program_registration_free')}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>{{__('Admin/backend.program_duration')}}:</label>
                                        <input class="form-control" type="text" name="program_duration[]" placeholder="{{__('Admin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Program_age_range">{{__('Admin/backend.age_range')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramAgeRangeModal" aria-hidden="true"></i>
                                    <i onclick="deleteProgramAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                </label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="age_range[]" id="program_age_range_choose" multiple="multiple" class="3col active">
                                            @foreach(\App\Models\SuperAdmin\Choose_Program_Age_Range::all() as $option)
                                            <option value="{{$option->age}}">{{$option->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <!--<input class="form-control" type="text" name="max_program_age_range" placeholder="{{__('Admin/backend.max_age')}}">-->
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{__('Admin/backend.courier_fee')}}:</label>
                                    <input type="text" class="form-control" name="courier_fee[]" placeholder="{{__('Admin/backend.courier_fee')}}">
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Textarea : </label>
                                    <textarea class="form-control tinymce" id="about_courier" placeholder="textarea" rows="3" name="about_courier[]"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.program_cost'):</label>
                                    <input class="form-control" type="text" name="program_cost[]" placeholder="{{__('Admin/backend.program_cost')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.program_duration_start'):</label>
                                    <input class="form-control" type="text" name="program_duration_start[]" placeholder="{{__('Admin/backend.program_duration_start')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.program_duration_end'):</label>
                                    <input class="form-control" type="text" name="program_duration_end[]" placeholder="{{__('Admin/backend.program_duration_end')}}">
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.program_start_date'):</label>
                                    <input class="form-control" type="date" name="program_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.program_end_date'):</label>
                                    <input class="form-control" type="date" name="program_end_date[]">
                                </div>
                                <div class="col-md-4">
                                    <!--<input class="form-control" type="date" name="program_end_date">-->
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.discount_per_week'):</label>
                                    <input class="form-control" type="text" name="discount_per_week[]" placeholder="{{__('Admin/backend.discount_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.discount_symbol'):</label>
                                    <select class="form-control" name="discount_symbol[]">
                                        <option>%</option>
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.discount_start_date'):</label>
                                    <input class="form-control" type="date" name="discount_start_date[]">
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.discount_end_date'):</label>
                                    <input class="form-control" type="date" name="discount_end_date[]">
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.x_week_selected'):</label>
                                    <input class="form-control" type="text" name="x_week_selected[]" placeholder="{{__('Admin/backend.every_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.free_week'):</label>
                                    <select class="form-control" name="how_many_week_free[]">
                                        <!--<option value=''>{{__('Admin/backend.select')}} </option>-->
                                        <option value='1'>{{__('Admin/backend.1_week_free')}} </option>
                                        <option value='2'>{{__('Admin/backend.2_week_free')}}</option>
                                        <option value='3'>{{__('Admin/backend.3_week_free')}}</option>
                                        <option value='4'>{{__('Admin/backend.4_week_free')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.x_week_end_date'):</label>
                                    <input class="form-control" type="date" name="x_week_start_date[]">
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.x_week_end_date'):</label>
                                    <input class="form-control" type="date" name="x_week_end_date[]">
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee'):</label>
                                    <!--program summer fee start-->
                                    <input class="form-control" type="text" name="program_summer_fee_per_week[]" placeholder="{{__('Admin/backend.summer_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_start_date'):</label>
                                    <input class="form-control" type="date" name="program_summer_fee_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_end_date'):</label>
                                    <input class="form-control" type="date" name="program_summer_fee_end_date[]">
                                    <!--program summer fee end-->
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_fee_per_week'):</label>
                                    <!--program summer fee start-->
                                    <input class="form-control" type="text" name="program_peak_time_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_start_date') :</label>
                                    <input class="form-control" type="date" name="program_peak_time_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_end_date') :</label>
                                    <input class="form-control" type="date" name="program_peak_time_end_date[]">
                                    <!--program summer fee end-->
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="" id="clone_under_age0">
                                <div class="row">
                                    <input name="clone_under_age_increment[]" id="increment" value='1' hidden>
                                    <div class="col-md-4">
                                        <label for="">{{__('Admin/backend.under_age_fee_per_week')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramUnderAgeModal" aria-hidden="true"></i>
                                            <i class="fa fa-trash pl-3" onclick="deleteProgramUnderAgeRange()" aria-hidden="true"></i>
                                        </label>
                                        <select name="under_age[0][age]" id="program_under_age_range_choose0" multiple="multiple" class="3col active tobehided">
                                            @foreach(\App\Models\SuperAdmin\Choose_Program_Under_Age::all() as $option)
                                            <option value="{{$option->age}}">{{$option->age}}</option>
                                            @endforeach
                                        </select>
                                        <input hidden name="under_age_program_increment" value=1 id="under_age_program_increment">
                                    </div>

                                    <div class="col-md-4 pt-3">
                                        <label>@lang('Admin/backend.fees_week'):</label>
                                        <input class="form-control" type="text" name="under_age[0][fees]" placeholder="Fees/Week" id="fees_under_age">
                                        <!--program summer fee end-->
                                    </div>
                                    <div class="col-md-4 mt-4 pt-3">
                                        <i class="fa fa-plus-circle" aria-hidden="true" id="program_under_age_add"></i>
                                        <i class="fa fa-minus" aria-hidden="true" onclick="removeProgramUnderAge($(this))" id="program_under_age_remove0"></i>
                                        <!--program summer fee end-->
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row" id="clone_program_text_book_fee0">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.text_book_fee'):</label>
                                    <input class="form-control" type="text" name="text_book_fee[]" placeholder="Text book fee">
                                </div>
                                <div class="col-md-3">
                                    <input id="textbookfeeincrement" hidden>
                                    <label>@lang('Admin/backend.text_book_start_date'):</label>
                                    <input class="form-control" type="text" name="text_book_fee_start_date[]" placeholder="{{__('Admin/backend.weeks')}}">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.text_book_end_date'):</label>
                                    <input class="form-control" type="text" name="text_book_fee_end_date[]" placeholder="{{__('Admin/backend.weeks')}}">
                                    <!--program summer fee end-->
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                    <!--program summer fee end-->
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Text-book-note : </label>
                                    <textarea class="form-control" type="text" name="text_book_note[]" id="text_book_note" placeholder="Text book note"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>

                            <input hidden name="program_increment" value=1 id="increment_program">
                            <input hidden name="program_unique_id[]" value="{{rand(000, 999)}}" id="program_unique_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="button" name="####" id="add_program-dost-d" onclick="addAnotherProgramCost($(this))" value="add another program cost">{{__('Admin/backend.add_another_program_cost')}}</button>
                                </div>
                                <div class="col-md-6">
                                    <!--<button class="btn btn-primary" type="button" name="####" value="add another program cost">-->
                                    <!--    add another program type-->
                                    <!--</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>

                <div id="clone_accommodation_form">
                    <h2>{{__('Admin/backend.accommodation_cost')}}</h2>
                    <div class="form-group">
                        <!--<label for="type">{{__('Admin/backend.accommodation_type')}}:</label>-->
                        <div class="row">
                            <div class="col-md-4">
                                <label for="type">{{__('Admin/backend.accommodation_type')}}:</label>
                                <input class="form-control" type="text" name="type[]" placeholder="{{__('Admin/backend.accommodation_type')}}" style="width:250px">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.room_type'):</label>
                                <input class="form-control" type="text" name="room_type[]" placeholder="{{__('Admin/backend.room_type')}}" style="width:250px">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.meal'):</label>
                                <input class="form-control" type="text" name="meal[]" placeholder="{{__('Admin/backend.Meal')}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="age_range">{{__('Admin/backend.age_range')}} :<i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccommodationAgeRangeModal" aria-hidden="true"></i><i onclick="deleteProgramUnderAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i></label>
                        <div class="row">
                            <div class="col-md-4">
                                <select id="accom_age_choose" name="age_range[]" multiple="multiple" class="3col active">
                                    @foreach(\App\Models\SuperAdmin\Choose_Accommodation_Age_Range::all() as $option)
                                    <option value="{{$option->age}}">{{$option->age}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <!--<label>{{__('Admin/backend.accommodation_placement_fee')}}:</label>-->
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{__('Admin/backend.accommodation_placement_fee')}}:</label>
                                <input class="form-control" type="text" name="placement_fee[]" placeholder="{{__('Admin/backend.accommodation_placement_fee')}}">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.accommodation_program_duration') </label>
                                <input class="form-control" type="text" name="program_duration[]" placeholder="{{__('Admin/backend.if_program_duration')}}">
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('Admin/backend.accommodation_deposit_fee')}}:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="text" name="deposit_fee[]" placeholder="{{__('Admin/backend.accommodation_deposit_fee')}}">
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{__('Admin/backend.special_diet_fee')}}:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <!--<label>Courier fee1 : </label>-->
                                <input class="form-control" type="text" name="special_diet_fee[]" placeholder="{{__('Admin/backend.special_diet_fee_pw')}}">
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('Admin/backend.special_diet_note'):</label>
                        <textarea class="form-control" type="text" name="special_diet_note[]" placeholder="special diet note" id="special_diet_note"></textarea>
                    </div>

                    <div class="form-group">
                        <!--<label>Accommodation fee: </label>-->
                        <div class="row">
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.accommodation_fee'):</label>
                                <input class="form-control" type="text" name="fee_per_week[]" placeholder="{{__('Admin/backend.accommodation_fee')}} ">
                            </div>
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.accommodation_start_date'):</label>
                                <input class="form-control" type="text" name="start_week[]" placeholder="{{__('Admin/backend.accommodation_duration_start')}}">
                            </div>
                            <div class="col-md-3">
                                <label>Accommodation-start-end-date:</label>
                                <input class="form-control" type="text" name="end_week[]" placeholder="{{__('Admin/backend.accommodation_duration_end')}}">
                            </div>
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.accommodation_start_date'):</label>
                                <input class="form-control" type="date" name="start_date[]">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.accommodation_end_date'):</label>
                                <input class="form-control" type="date" name="end_date[]">
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Accommodation-discount-per-week:</label>
                                <input class="form-control" type="text" name="discount_per_week[]" placeholder="{{__('Admin/backend.discount_per_week')}} ">
                            </div>
                            <div class="col-md-3">
                                <label>Accommodation-symbol:</label>
                                <select class="form-control" name="discount_per_week_symbol[]">
                                    <option>%</option>
                                    <option>-</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Accommodation-discount-start-date:</label>
                                <input class="form-control" type="date" name="discount_start_date[]">
                            </div>
                            <div class="col-md-3">
                                <label>Accommodation-discount-end-date:</label>
                                <input class="form-control" type="date" name="discount_end_date[]">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.summer_fee_per_week'):</label>
                                <input class="form-control" type="text" name="summer_fee_per_week[]" placeholder="{{__('Admin/backend.summer_fee_per_week')}} ">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.summer_fee_start_date'):</label>
                                <input class="form-control" type="date" name="summer_fee_start_date[]">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.summer_fee_end_date'):</label>
                                <input class="form-control" type="date" name="summer_fee_end_date[]">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.peak_time_fee_per_week') </label>
                                <input class="form-control" type="text" name="peak_time_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.peak_time_start_date') </label>
                                <input class="form-control" type="date" name="peak_time_fee_start_date[]">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.peak_time_end_date') </label>
                                <input class="form-control" type="date" name="peak_time_fee_end_date[]">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.christmas_fee'):</label>
                                <input class="form-control" type="text" name="christmas_fee_per_week[]" placeholder="{{__('Admin/backend.christmas_fee_per_week')}}">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.christmas_start_fee'):</label>
                                <input class="form-control" type="date" name="christmas_fee_start_date[]">
                            </div>
                            <div class="col-md-4">
                                <label>@lang('Admin/backend.christmas_end_fee'):</label>
                                <input class="form-control" type="date" name="christmas_fee_end_date[]">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row" id="accom_under_age_clone0">
                            <input id="increment" name="accom_increment" hidden value='1'>

                            <div class="col-md-4 mt-3">
                                <label for="under_age_fee">{{__('Admin/backend.under_age_fee_per_week')}}:
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i><i onclick="DeleteAccomUnderAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i></label>
                                <select name="under_age[]" id="under_age_choose0" multiple="multiple" class="3col active">
                                    @foreach(\App\Models\SuperAdmin\Choose_Accommodation_Under_Age::all() as $option)
                                    <option value="{{$option->age}}">{{$option->age}}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-4 pt-3">
                                <label>@lang('Admin/backend.add_week'):</label>
                                <input class="form-control" type="text" name="under_age_fee_per_week[]" placeholder="@lang('Admin/backend.add_week')">
                            </div>
                            <div class="col-md-4 mt-4 pt-3">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">

                                <button class="btn btn-primary" type="button" name="####">{{__('Admin/backend.add_another_accommodation_cost')}}</button>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>

                <div id="accom_program_duration_clone">
                    <input hidden id="airportincrement" name="airportincrement">
                    <div class="form-group">
                        <label>
                            <h2>{{__('Admin/backend.airport_fee')}}</h2></label>
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('Admin/backend.airport_name')}}:</label>
                                <input class="form-control" type="text" name="airport_name" placeholder="{{__('Admin/backend.airport_name')}}">
                            </div>
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.airport_service_name'):</label>
                                <input class="form-control" type="text" name="airport_service_name" placeholder="{{__('Admin/backend.service_name')}}">
                            </div>
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.airport_service_fee'):</label>
                                <input class="form-control" type="text" name="service_fee" placeholder="{{__('Admin/backend.airport_service_fee')}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.program_duration'):</label>
                                <input class="form-control" type="text" name="week_selected_fee" placeholder="{{__('Admin/backend.if_program_duration_airport_fee')}}">
                            </div>
                            <div class="col-md-3">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>

                </div>

                <div id="medical_clone">
                    <input id="medicalincrement" hidden>
                    <div class="form-group">
                        <label>
                            <h2>{{__('Admin/backend.medical_insurance_cost')}}</h2></label>
                        <div class="row">
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.medical_insurance_fee'):</label>
                                <input class="form-control" type="text" name="medical_fees_per_week[]" placeholder="{{__('Admin/backend.medical_insurance_fee_pw')}}" style="width:200px">
                            </div>
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.medical_start_date'):</label>
                                <input class="form-control" type="text" name="medical_start_date[]" placeholder="@lang('Admin/backend.medical_start_date')">
                            </div>
                            <div class="col-md-3">
                                <label>@lang('Admin/backend.medical_end_date'):</label>
                                <input class="form-control" type="text" name="medical_end_date[]" placeholder="{{__('Admin/backend.medical_insurance_duration_end')}}">
                            </div>
                            <div class="col-md-3">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>@lang('Admin/backend.medical_insurance_note'):</label>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control" type="text" name="medical_insurance_note" id="medical_insurance_note" placeholder="@lang('Admin/backend.medical_insurance_note')"></textarea>
                        </div>
                    </div>
                </div>

                <script>
                    course_url_store = "{{route('course.store')}}";
                </script>

                <button type="submit" onclick="get_content(); /*submitCourseForm(course_url_store)*/" class="btn btn-primary">@lang('Admin/backend.submit')</button>
            </form>
            --}} {{--
            <form id="form2" class="forms-sample" enctype="multipart/form-data" action="{{route('school.store')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.name')}}</label>
                    <input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.name')}}" value="{{old('name')}}">
                </div>
                <input type="hidden" name="ar" value='1'> @if($errors->has('name'))
                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputEmail3">{{__('Admin/backend.email_address')}}</label>
                    <input value="{{old('email')}}" name="email" type="text" class="form-control" id="exampleInputEmail3" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.email_address')}}">
                </div>

                @if($errors->has('email'))
                <div class="alert alert-danger">{{$errors->first('email')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleSelectGender">{{__('Admin/backend.contact_number')}}</label>
                    <input value="{{old('contact')}}" name="contact" class="form-control" id="exampleSelectGender" placeholder="{{__('Admin/backend.contact_number')}}" type="text">
                </div>

                @if($errors->has('contact'))
                <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.emergency_number')}}</label>
                    <input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.emergency_number')}}" value="{{old('emergency_number')}}">
                </div>

                @if($errors->has('emergency_number'))
                <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.branch_name')}}</label>
                    <input name="branch_name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.branch_name')}}" value="{{old('branch_name')}}">
                </div>

                @if($errors->has('branch_name'))
                <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.capacity')}}</label>
                    <input name="capacity" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.capacity')}}" value="{{old('capacity')}}">
                </div>

                @if($errors->has('capacity'))
                <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.facilities')}}</label>
                    <textarea name="facilities" class="form-control" id="exampleTextarea1" rows="4">{{old('facilities')}}</textarea>
                </div>

                @if($errors->has('facilities'))
                <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.class_size')}}</label>
                    <input name="class_size" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.class_size')}}" value="{{old('class_size')}}">
                </div>

                @if($errors->has('class_size'))
                <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.year_opened')}}</label>
                    <input name="opened" type="text" class="form-control" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.year_opened')}}" value="{{old('opened')}}">
                </div>

                @if($errors->has('opened'))
                <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.about_the_school')}}</label>
                    <textarea name="about" class="form-control" id="exampleTextarea1" rows="4">{{old('about')}}</textarea>
                </div>
                @if($errors->has('about'))
                <div class="alert alert-danger">{{$errors->first('about')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.address')}}</label>
                    <input name="address" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.address_map_location')}}" value="{{old('address')}}">
                </div>

                @if($errors->has('address'))
                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.enter_city')}}</label>
                    <input name="city" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.enter_city')}}" value="{{old('city')}}">
                </div>

                @if($errors->has('city'))
                <div class="alert alert-danger">{{$errors->first('city')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.enter_country')}}</label>
                    <input name="country" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.program_duration_start')}}{{__('Admin/backend.enter_country')}}" value="{{old('country')}}">
                </div>

                @if($errors->has('country'))
                <div class="alert alert-danger">{{$errors->first('country')}}</div>
                @endif

                <div class="form-group">
                    <ul id="myTags"></ul>
                </div>

                @if($errors->has('video_url'))
                <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                @endif

                <input hidden name="ar" value='1'>

                <button type="button" onclick="submitForm(addschoolurl)" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
            </form>
            --}}
        </div>
    </div>
</div>

@include('branchadmin.courses.modals')
<script>
        $(document).ready(function() {
            $('select[multiple].active2.3col').multiselect({
                includeSelectAllOption: true
            })
            $('select[multiple].active.3col').multiselect({
                includeSelectAllOption: true
            })
        });
    </script>
@endsection