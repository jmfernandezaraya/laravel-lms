@extends('branchadmin.layouts.app')

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

@include('admin.course.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h4 class="card-title">@lang('Admin/backend.add_course') </h4>
                <change>{{__('Admin/backend.in_english')}}</change>
            </div>

            @include('common.include.alert')
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

            <div id="show_form"></div>

            <form class="forms-sample" method="POST" action="{{route("admin.course.store")}}" id="forms">
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
                            <select name="language[]" id="language_choose" multiple="multiple" class="3col active">
                                @foreach($choose_languages as $choose_language)
                                    <option value="{{$choose_language->name}}">{{$choose_language->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">@lang('Admin/backend.choose_study_mode'):<i
                                  class="fa fa-plus pl-3"
                                    data-toggle="modal"
                                    data-target="#StudymodeModal"
                                    aria-hidden="true"></i><i
                                  class="fa fa-trash pl-3" onclick="deleteStudyMode()"
                                    aria-hidden="true"></i></label>
                            <select name="study_mode[]" id="study_mode_choose" multiple="multiple" class="3col active">
                                @foreach(\App\Models\ChooseStudyMode::all() as $studymode)
                                    <option value="{{$studymode->name}}">{{$studymode->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="program_language">{{__('Admin/backend.choose_program_type')}}:<i
                                  class="fa fa-plus pl-3"
                                    data-toggle="modal"
                                    data-target="#ProgramTypeModal"
                                    aria-hidden="true"></i><i
                                    onclick="deleteProgramType()" class="fa fa-trash pl-3"
                                    aria-hidden="true"></i></label>
                            <select name="program_type[]" id="program_type_choose" multiple="multiple" class="3col active">
                                @foreach(\App\Models\ChooseProgramType::all() as $program_type)
                                    <option value="{{$program_type->name}}">{{$program_type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="name">{{__('Admin/backend.choose_school')}}:</label>
                            <select onchange="changeSchool()" class="form-control" id="school_name" name="school_name">
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
                            <label for="branch">{{__('Admin/backend.add_branch_if_applicable')}}
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#BranchModal" aria-hidden="true"></i>
                                <i class="fa fa-trash pl-3" aria-hidden="true" onclick="deleteBranch()"></i>
                            </label>
                            <select name="branch[]" id="branch_choose" multiple="multiple" class="3col active2">
                                <option value="Branch1">{{__('Admin/backend.select')}}</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="choose_currency">{{__('Admin/backend.choose_currency')}}:</label>
                            <select class="form-control" id="choose_currency" name="currency">
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
                        <div class="col-md-4">
                        </div>
                    </div>

                    <h2>{{__('Admin/backend.program_features')}}</h2>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="program_name">@lang('Admin/backend.program_name') </label>
                            <input class="form-control" type="text" name="program_name" placeholder="@lang('Admin/backend.program_name')">
                        </div>
                        <div class="col-md-4">
                            <label for="program_level_required">{{__('Admin/backend.level_required')}}:</label>
                            <input class="form-control" type="text" name="program_level" placeholder="program level required">
                        </div>
                        <div class="col-md-4">
                            <label for="lessons_per_week">{{__('Admin/backend.lessons_per_week')}}:</label>
                            <input class="form-control" type="text" name="lessons_per_week" placeholder="lessons per week">
                            <br><br>
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
                                @foreach (\App\Models\ChooseStudyTime::all() as $studytime)
                                    <option value="{{$studytime->name}}">{{$studytime->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="course_start_day">{{__('Admin/backend.start_day_every')}}
                                <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#StarDayModal" aria-hidden="true"></i>
                                <i onclick="deleteStartDay()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                            </label>
                            <select name="every_day[]" id="start_dates_option" multiple="multiple" class="3col active">
                                @foreach(\App\Models\ChooseStartDate::all() as $option)
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
                            <h2>{{__('Admin/backend.program_cost')}}</h2>
                            <br>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="program_name">{{__('Admin/backend.program_id')}}:</label>
                                    <input readonly class="form-control" value="{{time().rand(00,99)}}" type="text" id="program_id" name="program_id[]">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>{{__('Admin/backend.program_registration_fee')}}:</label>
                                        <input class="form-control" type="text" name="program_registration_fee[]" placeholder="{{__('Admin/backend.program_registration_fee')}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Program-duration: </label>
                                        <input class="form-control" type="text" name="program_duration[]" id="gotilla" placeholder="{{__('Admin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Program_age_range">{{__('Admin/backend.age_range')}}:<i
                                      class="fa fa-plus pl-3" data-toggle="modal"
                                        data-target="#ProgramAgeRangeModal"
                                        aria-hidden="true"></i><i
                                        onclick="deleteProgramAgeRange($(this))" class="fa fa-trash pl-3"
                                        aria-hidden="true"></i></label>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="to_be_inserted_age0"></div>
                                        <select name="age_range[0][]" id="program_age_range_choose0" multiple="multiple" class="3col active">
                                            @foreach(\App\Models\ChooseProgramAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all() as $option)
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
                                    <input type="text" class="form-control" name="courier_fee[]" placeholder="{{__('Admin/backend.courier_fee')}}"><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Textarea : </label>
                                    <textarea class="form-control tinymce" id="about_courier" placeholder="textarea" rows="3" name=""></textarea>
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
                            <br><br>

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
                            <br><br>
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
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.discount_end_date'):</label>
                                    <input class="form-control" type="date" name="discount_end_date[]">
                                    <br><br>
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
                                        <option value='1'>{{__('Admin/backend.1_week_free')}} </option>
                                        <option value='2'>{{__('Admin/backend.2_week_free')}}</option>
                                        <option value='3'>{{__('Admin/backend.3_week_free')}}</option>
                                        <option value='4'>{{__('Admin/backend.4_week_free')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.x_week_start_date'):</label>
                                    <input class="form-control" type="date" name="x_week_start_date[]">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.x_week_end_date'):</label>
                                    <input class="form-control" type="date" name="x_week_end_date[]">
                                </div>
                            </div>
                            <br><br>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee'):</label>
                                    <input class="form-control" type="text" name="program_summer_fee_per_week[]" placeholder="{{__('Admin/backend.summer_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_start_date'):</label>
                                    <input class="form-control" type="date" name="program_summer_fee_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_end_date'):</label>
                                    <input class="form-control" type="date" name="program_summer_fee_end_date[]">
                                </div>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_fee_per_week'):</label>
                                    <input class="form-control" type="text" name="program_peak_time_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_start_date') :</label>
                                    <input class="form-control" type="date" name="program_peak_time_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_end_date') :</label>
                                    <input class="form-control" type="date" name="program_peak_time_end_date[]">
                                </div>
                            </div>
                            <br><br>

                            <input hidden name="program_increment" value=0 id="increment_program">
                            <input hidden name="program_unique_id[]" value="{{rand(000, 999)}}" id="program_unique_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary fa fa-plus" type="button" name="####" id="add_program-dost-d0" onclick="addAnotherProgramCost($(this))" value="add another program cost"></button>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-danger fa fa-minus" type="button" name="####" id="remove_program_button0" onclick="removeAnotherProgramCost($(this))" value="add another program cost"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <script>
                    course_url_store = "{{ auth('superadmin')->check() ? route('superadmin.course.store') : route('schooladmin.course.store') }}";
                </script>

                <a onclick="getContent('about_program', 'about_program_value'); getContent('about_courier', 'about_courier_value'); submitCourseForm($(this));"
                 class="btn btn-primary pull-right">Submit</a>

            </form>
        </div>
    </div>
</div>

@include('admin.course.modals')
@endsection


