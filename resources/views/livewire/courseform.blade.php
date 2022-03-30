<div>
    <form class="forms-sample" method="POST" action="{{route("course.store")}}" id="form1">
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
                            <option value="{{$choose_language->unique_id}}">{{$choose_language->name}}</option>
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
                            <option value="{{$studymode->unique_id}}">{{$studymode->name}}</option>
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
                            <option value="{{$program_type->unique_id}}">{{$program_type->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label for="school_name">{{__('SuperAdmin/backend.choose_school')}}:</label>
                    <select onchange="getSchool(url_schols, $(this).val())" class="form-control" id="school_name" name="school_id">
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
                    <select class="form-control" id="country_name" name="">
                        <option>{{__('SuperAdmin/backend.select')}}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="city_name">{{__('SuperAdmin/backend.choose_city')}}:</label>
                    <select class="form-control" id="city_name" name="">
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
                    <br><br>
                </div>
                <div class="col-md-4"></div>
            </div>

            <h2>{{__('SuperAdmin/backend.program_features')}}</h2>
            <div class="row">
                <div class="col-md-4">
                    <label for="program_name">{{__('SuperAdmin/backend.program_name')}}:</label>
                    <input class="form-control" type="text" name="program_name" placeholder="Program Name">
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
                        <option value="Morning">{{__('SuperAdmin/backend.Morning')}}</option>
                        <option value="Afternoon">{{__('SuperAdmin/backend.Afternoon')}}</option>
                        <option value="Evening">{{__('SuperAdmin/backend.Evening')}}</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="course_start_day">{{__('SuperAdmin/backend.start_day_every')}}
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

            <div id="clone_program_form0" >
                <div class ="clone_program_with_clone_data">
                    <h2>{{__('SuperAdmin/backend.program_cost')}}</h2>
                    <br>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{__('SuperAdmin/backend.program_registration_free')}}</label>
                                <input class="form-control" type="text" name="program_registration_fee[]" placeholder="{{__('SuperAdmin/backend.program_registration_free')}}">
                            </div>
                            <div class="col-md-4">
                                <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                <input class="form-control" type="text" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_=X_weeks+_get_free _Program_Registration_fee')}}">
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
                                <select name="age_range[]" id="program_age_range_choose" multiple="multiple" class="3col active">
                                    @foreach(\App\Models\SuperAdmin\Choose_Program_Age_Range::all() as $option)
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
                            <textarea class="form-control tinymce" id="about_courier" placeholder="textarea" rows="3" name="about_courier[]"></textarea>
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
                        <div class="col-md-4">
                        </div>
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
                            <label>@lang('SuperAdmin/backend.x_week_end_date'):</label>
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

                    <div class="" id="clone_under_age0">
                        @foreach($inputs as $key => $value)
                        <div class="row">
                            <input name="clone_under_age_increment[]" id="increment" value='1' hidden>
                            <div class="col-md-4">
                                <label for="">{{__('SuperAdmin/backend.underage_fee_per_week')}}: 
                                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramUnderAgeModal" aria-hidden="true"></i>
                                    <i class="fa fa-trash pl-3" onclick="deleteProgramUnderAgeRange()" aria-hidden="true"></i>
                                </label>
                                <select name="under_age" id="program_under_age_range_choose0" multiple="multiple" class="3col active tobehided">
                                    @foreach(\App\Models\SuperAdmin\Choose_Program_Under_Age::all() as $option)
                                        <option value="{{$option->age}}">{{$option->age}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 pt-3">
                                <label>@lang('SuperAdmin/backend.fees_week'):</label>
                                <input class="form-control" type="text" name="underage_fee_per_week" placeholder="Fees/Week">
                            </div>
                            <div class="col-md-4 mt-4 pt-3">
                                <i class="fa fa-plus-circle"  aria-hidden="true"  wire:click.prevent="add" id="program_under_age_add"></i>
                                <i class="fa fa-minus" aria-hidden="true" wire:click.prevent="remove({{$key}})" {{--onclick="removeProgramUnderAge($(this))" --}}id="program_under_age_remove0"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <br><br>

                    <div class="row" id="clone_program_text_book_fee0">
                        <div class="col-md-4">
                            <label>@lang('SuperAdmin/backend.text_book_fee'):</label>
                            <input class="form-control" type="text" name="text_book_fee[]" placeholder="Text book fee">
                        </div>
                        <div class="col-md-3">
                            <input id="textbookfeeincrement" hidden>
                            <label>@lang('SuperAdmin/backend.text_book_start_date'):</label>
                            <input class="form-control" type="text" name="text_book_fee_start_date[]" placeholder="{{__('SuperAdmin/backend.weeks')}}">
                        </div>
                        <div class="col-md-3">
                            <label>@lang('SuperAdmin/backend.text_book_end_date'):</label>
                            <input class="form-control" type="text" name="text_book_fee_end_date[]" placeholder="{{__('SuperAdmin/backend.weeks')}}">
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Text-book-note : </label>
                            <textarea class="form-control" type="text" name="text_book_note[]" id="text_book_note" placeholder="Text book note"></textarea>
                        </div>
                    </div>
                    <br><br>
                    <input hidden name="program_increment" value = 1 id="increment_program">
                    <input hidden name="program_unique_id[]" value="{{rand(000, 999)}}" id="program_unique_id">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="button" name="####" id="add_program-dost-d" onclick="addAnotherProgramCost($(this))"    value="add another program cost">{{__('SuperAdmin/backend.add_another_program_cost')}}</button>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div id="clone_accommodation_form">
            <h2>{{__('SuperAdmin/backend.accommodation_cost')}}</h2>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="type">{{__('SuperAdmin/backend.accommodation_type')}}:</label>
                        <input class="form-control" type="text" name="type[]" placeholder="{{__('SuperAdmin/backend.accommodation_type')}}" style="width:250px">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.room_type'):</label>
                        <input class="form-control" type="text" name="room_type[]" placeholder="{{__('SuperAdmin/backend.room_type')}}" style="width:250px">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.meal'):</label>
                        <input class="form-control" type="text" name="meal[]" placeholder="{{__('SuperAdmin/backend.Meal')}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="age_range">{{__('SuperAdmin/backend.age_range')}} :
                    <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccommodationAgeRangeModal" aria-hidden="true"></i>
                    <i onclick="deleteProgramUnderAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                </label>
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
                <div class="row">
                    <div class="col-md-4">
                        <label>{{__('SuperAdmin/backend.accommodation_placement_fee')}}:</label>
                        <input class="form-control" type="text" name="placement_fee[]" placeholder="{{__('SuperAdmin/backend.accommodation_placement_fee')}}">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.accommodation_program_duration')  </label>
                        <input class="form-control" type="text" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration')}}">
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

            <div class="form-group">
                <label>{{__('SuperAdmin/backend.accommodation_deposit_fee')}}:</label>
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="deposit_fee[]" placeholder="{{__('SuperAdmin/backend.accommodation_deposit_fee')}}">
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 pt-3">
                        <label>{{__('SuperAdmin/backend.accommodation_custodian_fee')}}:</label>
                        <input class="form-control" type="text" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.accommodation_custodian_fee')}}">
                    </div>
                    <div class="col-md-4">
                        <label>{{__('SuperAdmin/backend.custodian_age_range')}} 
                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeAcoomModal" aria-hidden="true"></i>
                            <i onclick="DeleteAccomCustodianAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                        </label>
                        <select name="age_range_for_custodian[]" id="custodian_age_range_choose" multiple="multiple" class="3col active">
                            @foreach(\App\Models\SuperAdmin\Choose_Custodian_Under_Age::all() as $option)
                                <option value="{{$option->age}}">"{{$option->age}}"</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

            <div class="form-group">
                <label>{{__('SuperAdmin/backend.special_diet_fee')}}:</label>
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="special_diet_fee[]" placeholder="{{__('SuperAdmin/backend.special_diet_fee_pw')}}">
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>
            </div>

            <div class="form-group">
                <label>@lang('SuperAdmin/backend.special_diet_note'):</label>
                <textarea class="form-control" type="text" name="special_diet_note[]" placeholder="special diet note" id="special_diet_note"></textarea>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.accommodation_fee'):</label>
                        <input class="form-control" type="text" name="fee_per_week[]" placeholder="{{__('SuperAdmin/backend.accommodation_fee')}} ">
                    </div>
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.accommodation_start_date'):</label>
                        <input class="form-control" type="text" name="start_week[]" placeholder="{{__('SuperAdmin/backend.accommodation_duration_start')}}">
                    </div>
                    <div class="col-md-3">
                        <label>Accommodation-start-end-date:</label>
                        <input class="form-control" type="text" name="end_week[]" placeholder="{{__('SuperAdmin/backend.accommodation_duration_end')}}">
                    </div>
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.accommodation_start_date'):</label>
                        <input class="form-control" type="date" name="start_date[]">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.accommodation_end_date'):</label>
                        <input class="form-control" type="date" name="end_date[]">
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label>Accommodation-discount-per-week:</label>
                        <input class="form-control" type="text" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}} ">
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
                        <label>@lang('SuperAdmin/backend.summer_fee_per_week'):</label>
                        <input class="form-control" type="text" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}} ">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.summer_fee_start_date'):</label>
                        <input class="form-control" type="date" name="summer_fee_start_date[]">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.summer_fee_end_date'):</label>
                        <input class="form-control" type="date" name="summer_fee_end_date[]">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.peak_time_fee_per_week') </label>
                        <input class="form-control" type="text" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.peak_time_start_date') </label>
                        <input class="form-control" type="date" name="peak_time_fee_start_date[]">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.peak_time_end_date') </label>
                        <input class="form-control" type="date" name="peak_time_fee_end_date[]">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.christmas_fee'):</label>
                        <input class="form-control" type="text" name="christmas_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.christmas_fee_per_week')}}">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.christmas_start_fee'):</label>
                        <input class="form-control" type="date" name="christmas_fee_start_date[]">
                    </div>
                    <div class="col-md-4">
                        <label>@lang('SuperAdmin/backend.christmas_end_fee'):</label>
                        <input class="form-control" type="date" name="christmas_fee_end_date[]">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row" id="accom_under_age_clone0">
                    <input id="increment" name="accom_increment" hidden value="1">
                    <div class="col-md-4 mt-3">
                        <label for="accommodation_underage_fee">{{__('SuperAdmin/backend.underage_fee_per_week')}}:
                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i>
                            <i onclick="DeleteAccomUnderAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                        </label>
                        <select name="under_age[]" id="under_age_choose0" multiple="multiple" class="3col active">
                            @foreach(\App\Models\SuperAdmin\Choose_Accommodation_Under_Age::all() as $option)
                                <option value="{{$option->age}}">{{$option->age}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mt-4 pt-3">
                        <label>@lang('SuperAdmin/backend.add_week'):</label>
                        <input class="form-control" type="text" name="under_age_fee_per_week[]" placeholder="@lang('SuperAdmin/backend.add_week')">
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
                        <button class="btn btn-primary" type="button" name="####">{{__('SuperAdmin/backend.add_another_accommodation_cost')}}</button>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <div id="accom_program_duration_clone">
            <input hidden  id ="airportincrement" name="airportincrement">
            <div class="form-group">
                <label><h2>{{__('SuperAdmin/backend.airport_fee')}}</h2></label>
                <div class="row">
                    <div class="col-md-3">
                        <label>{{__('SuperAdmin/backend.airport_name')}}:</label>
                        <input class="form-control" type="text" name="airport_name" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                    </div>
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.airport_service_name'):</label>
                        <input class="form-control" type="text" name="airport_service_name" placeholder="{{__('SuperAdmin/backend.service_name')}}">
                    </div>
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.airport_service_fee'):</label>
                        <input class="form-control" type="text" name="service_fee" placeholder="{{__('SuperAdmin/backend.airport_service_fee')}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row" >
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.program_duration'):</label>
                        <input class="form-control" type="text" name="week_selected_fee" placeholder="{{__('SuperAdmin/backend.if_program_duration_airport_fee')}}">
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <div id="medical_clone">
            <input id="medicalincrement" hidden>
            <div class="form-group">
                <label><h2>{{__('SuperAdmin/backend.medical_insurance_cost')}}</h2></label>
                <div class="row">
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.medical_insurance_fee'):</label>
                        <input class="form-control" type="text" name="medical_fees_per_week[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_fee_pw')}}" style="width:200px">
                    </div>
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.medical_start_date'):</label>
                        <input class="form-control" type="text" name="medical_start_date[]" placeholder="@lang('SuperAdmin/backend.medical_start_date')">
                    </div>
                    <div class="col-md-3">
                        <label>@lang('SuperAdmin/backend.medical_end_date'):</label>
                        <input class="form-control" type="text" name="medical_end_date[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_duration_end')}}">
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>@lang('SuperAdmin/backend.medical_insurance_note'):</label>
            <div class="row">
                <div class="col-md-12">
                    <textarea class="form-control" type="text" name="medical_insurance_note" id="medical_insurance_note" placeholder="@lang('SuperAdmin/backend.medical_insurance_note')"></textarea>
                </div>
            </div>
        </div>

        <script>
            course_url_store = "{{route('course.store')}}";
        </script>
        <button type="submit" onclick="get_content(); class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
    </form>
</div>