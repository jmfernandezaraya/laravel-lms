@extends('superadmin.layouts.app')

@section('css')
    <style>
        .study {
            box-shadow: 0px 0px 2px 1px #ccc;
            padding: 15px 15px;
        }
        .accordion .card-header:after {
            font-family: 'FontAwesome';
            content: "\f068";
            float: right;
        }
        .accordion .card-header.collapsed:after {
            content: "\f067";
            cursor: pointer;
        }
        .table {
            border: 1px solid #ccc;
            box-shadow: 0px -1px 4px 1px #ece7e7;
            background: #fff;
        }
        .content-wrapper {
            background: #ffffff;
            border: 1px solid #ccc;
        }
        .diff-tution {
            color: #b94443;
        }
        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }
        .form-check-input {
            position: absolute;
            margin-top: .3rem;
            margin-left: -1.25rem;
        }
        .best {
            font-size: 16px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <center><h3>{{__('SuperAdmin/backend.reservation_details')}}</h3></center>
    <div style="margin-left: 30px ; text-align: left">
        <b>{{__('SuperAdmin/backend.name')}}: </b>{{ $bookeddetails->fname ." " . $bookeddetails->mname . " " . $bookeddetails->lname }} <br>
        <b>{{__('SuperAdmin/backend.email')}}: </b>{{ $bookeddetails->email }}<br>
        <b>{{__('SuperAdmin/backend.mobile')}}: </b>{{ $bookeddetails->mobile }}<br>
    </div>
    <hr>
    <div class="reservation-section">
        <div id="accordion" class="accordion">
            <div class="card mb-0">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                    <a class="card-title">{{__('SuperAdmin/backend.reservation_details')}}</a>
                </div>
                <div id="collapseOne" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="course-details">
                        <h6 class="best mt-3">{{__('SuperAdmin/backend.reservation_details')}}:</h6>
                        <a href = "{{route('superadmin.manage_application.editCourse', ['course_id' =>$bookeddetails->course_id, 'user_course_booked_id' => $bookeddetails->id, 'school_id' => $bookeddetails->course->school->id])}}" class="btn btn-primary pull-right">Edit</a>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.school_name')}}</td>
                                    <?php $branch_name = is_array($bookeddetails->course->school->branch_name) ? $bookeddetails->course->school->branch_name[0] : $bookeddetails->course->school->branch_name ?? ''; ?>
                                    <td>{{get_language() == 'en' ? $bookeddetails->course->school->name . ' - ' . $branch_name  :  $bookeddetails->course->school->name_ar . ' - ' . $branch_name }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.city')}}</td>
                                    <td>{{get_language() == 'en' ? $bookeddetails->course->school->city :  $bookeddetails->course->school->city_ar }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.country')}}</td>
                                    <td>{{get_language() == 'en' ? $bookeddetails->course->school->country :  $bookeddetails->course->school->country_ar }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="best mt-3">{{__('SuperAdmin/backend.course_detail')}}:</h6>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.program_name')}}</td>
                                    <td>{{$bookeddetails->course->program_name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.lessons_hours_pw')}}</td>
                                    <td>{{$bookeddetails->course->lessons_per_week}}
                                        Lessons/ {{$bookeddetails->course->hours_per_week}} {{__('SuperAdmin/backend.hours')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.duration')}}</td>
                                    <td>{{$bookeddetails->program_duration}} {{__('SuperAdmin/backend.weeks')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.start_date')}}</td>
                                    <td>{{$bookeddetails->start_date->format('d-m-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.end_date')}}</td>
                                    <td>{{$program_start_date = programEndDateExcludingLastWeekend($bookeddetails->start_date, $bookeddetails->program_duration)}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.age_range')}}</td>
                                    <td>{{min($bookeddetails->getCourseProgram->program_age_range)}} - {{max($bookeddetails->getCourseProgram->program_age_range)}} {{__('SuperAdmin/backend.years')}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if (isset($bookeddetails->accomodation->type))
                            <h6 class="best mt-3">{{__('SuperAdmin/backend.accommodation_details')}}:</h6>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.accommodation_type')}}</td>
                                        <td>{{$bookeddetails->accomodation->type ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.duration')}}</td>
                                        <td>{{$bookeddetails->accommodation_duration ?? ''}} {{__('SuperAdmin/backend.weeks')}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.start_date')}}</td>
                                        <td>{{$accom_start_ddate = $bookeddetails->start_date ?? \Carbon\Carbon::create($bookeddetails->start_date->toDateTimeString())->subDay()->format('d-m-Y')}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.end_date')}}</td>
                                        <td>{{\Carbon\Carbon::create($accom_start_ddate)->addWeeks($bookeddetails->accommodation_duration)->subDay()->format('d-m-Y')}}</td>
                                    </tr>
                                    @if (isset($bookeddetails->accomodation->age_range))
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.age_range')}}</td>
                                        <td>{{min($bookeddetails->accomodation->age_range)}} - {{max($bookeddetails->accomodation->age_range)}} {{__('SuperAdmin/backend.years')}}
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        @endif

                        @if(isset($bookeddetails->airport->{'airport_name_'.get_language() } ))
                            <h6 class="best mt-3">{{__('SuperAdmin/backend.airport_transfer')}}:</h6>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>{{$bookeddetails->airport->{'airport_name_' . get_language() } ?? '' }}</td>
                                        <td>{{$bookeddetails->airport->{'airport_service_name_' . get_language() } ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif

                        @if($bookeddetails->insurance_duration != null)
                            <h6 class="best mt-3">{{__('SuperAdmin/backend.medical_insurance')}}:</h6>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.start_date')}}</td>
                                        <td>{{$bookeddetails->start_date->subDay()->format('d-m-Y') ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.end_date')}}</td>
                                        <td>{{$bookeddetails->start_date->subDay()->addWeeks($bookeddetails->insurance_duration)->subDay()->format('d-m-Y') ?? ''}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif

                        <h6 class="best mt-3">{{__('SuperAdmin/backend.total_cost')}} {{$bookeddetails->total_fees}} / {{$bookeddetails->other_currency}}</h6>
                        <p>{{__('SuperAdmin/backend.please_note_balance_final_payment_will_be_according_to_the_exchange_rate_for_the_day_of_the_payment')}}</p>
                    </div>
                </div>
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <a class="card-title">{{__('SuperAdmin/backend.regsitration_form')}}</a>
                </div>
                <div id="collapseTwo" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="study row m-2">
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.first_name')}}*</label>
                                <div class="col-sm-7">
                                    <input type="text" name="fname" value="{{$bookeddetails->fname}}" class="form-control" id="fname" placeholder="First Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="mname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.middle_name')}}*</label>
                                <div class="col-sm-7">
                                    <input type="text" name="mname" value="{{$bookeddetails->mname}}" class="form-control" id="mname" placeholder="Middle Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="lname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.last_name')}}*</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="lname" value="{{$bookeddetails->lname}}" id="lname" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.date_of_birth')}}:</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" value="{{$bookeddetails->dob}}" name="dob">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="city" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.place_of_birth')}}:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{$bookeddetails->place_of_birth}}" placeholder="City">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="lname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.country')}}*</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="country" value="{{$bookeddetails->country}}" placeholder="Country*">
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="city" class="col-sm-4 col-form-label">{{__('SuperAdmin/backend.gender')}}</label>
                                <div class="col-sm-7 row">
                                    <div class="form-check form-check-inline">
                                        <input required="" {{$bookeddetails->gender == 'male' ? 'checked' : ''}} class="form-check-input" type="radio" name="gender" id="inlineCheckbox1" value="male">
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.male')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" {{$bookeddetails->gender == 'female' ? 'checked' : ''}} type="radio" name="gender" id="inlineCheckbox2" value="female">
                                        <label class="form-check-label" for="inlineCheckbox2">{{__('SuperAdmin/backend.female')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="nat" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.nationality')}}</label>
                                <div class="col-sm-7">
                                    <select required name="nationality" class="form-control" id="nat">
                                        @foreach($nation_option as $option)
                                            <option {{$option == $bookeddetails->nationality ? 'selected' : ''}} value="{{$option}}">{{$option}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Passport" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.passport_no')}}.</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="passport_number" value="{{$bookeddetails->passport_number}}" id="pport" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="portdate" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.passport_date_of_issue')}}</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" name="passport_date_of_issue" value="{{$bookeddetails->passport_date_of_issue}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="edate" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.passport_date_of_expiry')}}</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" value="{{$bookeddetails->passport_date_of_expiry}}" name="passport_date_of_expiry">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.passport_copy_page_of_the_details')}}*</label>
                                <div class="col-sm-7">
                                    <a download href="{{asset($bookeddetails->passport_copy)}}">{{__('SuperAdmin/backend.download_here')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="city" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.study_finance')}}</label>
                                <div class="col-sm-7 row">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineCheckbox1" {{$bookeddetails->study_finance == 'personal' ? 'checked' : ''}}  value="personal" name="study_finance">
                                        <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.personal')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineCheckbox2" value="scholarship" {{$bookeddetails->study_finance == 'scholarship' ? 'checked' : ''}} name="study_finance">
                                        <label class="form-check-label" for="inlineCheckbox2">{{__('SuperAdmin/backend.scholarship')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($bookeddetails->study_finance == 'scholarship')
                            <div class="form-group col-md-6">
                                <div class="form-group row">
                                    <label for="nat" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.financial_gurantee')}}</label>
                                    <div class="col-sm-7">
                                        <a href="{{asset($bookeddetails->financial_guarantee)}}" download>{{__('SuperAdmin/backend.download_here')}}</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="nat" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.id_iqama_number')}}</label>
                                <div class="col-sm-7">
                                    <input type="fname" value="{{$bookeddetails->id_number}}" class="form-control" id="fname" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="nat" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.your_level_of_language')}}</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="nat">
                                        <option>{{__('SuperAdmin/backend.please_select')}}</option>
                                        <option value="beginner_a1" {{$bookeddetails->level_of_language == "beginner_a1" ? 'selected' : ''}}>{{__('SuperAdmin/backend.beginner_a1')}}</option>
                                        <option value="elementary_a2" {{$bookeddetails->level_of_language == "elementary_a2" ? 'selected' : ''}}>{{__('SuperAdmin/backend.elementary_a2')}}</option>
                                        <option value="intermediate_b1" {{$bookeddetails->level_of_language == "intermediate_b1" ? 'selected' : ''}}>{{__('SuperAdmin/backend.intermediate_b1')}}</option>
                                        <option value="upper_intermediate_b2" {{$bookeddetails->level_of_language == "upper_intermediate_b2" ? 'selected' : ''}}>{{__('SuperAdmin/backend.upper_intermediate_b2')}}</option>
                                        <option value="advanced_c1" {{$bookeddetails->level_of_language == "advanced_c1" ? 'selected' : ''}}>{{__('SuperAdmin/backend.advanced_c1')}}</option>
                                        <option value="proficient_c2" {{$bookeddetails->level_of_language == "proficient_c2" ? 'selected' : ''}}>{{__('SuperAdmin/backend.proficient_c2')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($bookeddetails->bank_statement != null)
                            <div class="form-group col-md-12">
                                <div class="form-group row">
                                    <label for="bank" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.bank_statement')}}</label>
                                    <div class="col-sm-9">
                                        <a href="{{asset($bookeddetails->bank_statement)}}" download>{{__('SuperAdmin/backend.download_here')}}</a>
                                    </div>
                                </div>
                            </div>
                        @endif                        
                    </div>

                    <h6 class="best">{{__('SuperAdmin/backend.contact_details')}}:</h6>
                    <div class="study row m-2">
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.mobile')}}*</label>
                                <div class="col-sm-9">
                                    <input type="number" name="mobile" value="{{$bookeddetails->mobile}}" class="form-control" id="mobile" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Tel" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.tel')}}*</label>
                                <div class="col-sm-9">
                                    <input type="number" value="{{$bookeddetails->telephone}}" name="telephone" class="form-control" id="Tel" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Email" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.email')}}*</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" value="{{$bookeddetails->email}}" class="form-control" id="Email" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Address" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.address')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="address" value="{{$bookeddetails->address}}" class="form-control" id="Address" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Post" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.post_code')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->post_code}}" class="form-control" id="Post" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="City" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.city')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->city_contact}}" class="form-control" id="City" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Country" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.country')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->country_contact}}" class="form-control" id="Country" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="best">{{__('SuperAdmin/backend.emergency_contact_details')}}:</h6>
                    <div class="study row m-2">
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fullname" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.full_name')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->full_name_emergency}}" class="form-control" id="fullname" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Relative" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.relative')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->relative_emergency}}" class="form-control" id="Relative" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Mobile" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.mobile')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->mobile_emergency}}" class="form-control" id="Mobile" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Tel" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.mobile')}}*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->telephone_emergency}}" class="form-control" id="Tel" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Email" class="col-sm-3 col-form-label">{{__('SuperAdmin/backend.email')}}*</label>
                                <div class="col-sm-9">
                                    <input type="email" value="{{$bookeddetails->email_emergency}}" class="form-control" id="Email" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="best">{{__('SuperAdmin/backend.how_you_heard_about_link_for_study_abroad')}}</h6>
                    <div class="study row m-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('Google', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.google')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('Twitter', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.twitter')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('Instagram', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.instagram')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('Snapchat', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.snapchat')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('Tiktok', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.tiktok')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('YouTube', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.youTube')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" {{in_array('Friend', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.friend')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox1">{{__('SuperAdmin/backend.other')}}</label>
                            <input type="text" value="{{$bookeddetails->other}}" class="form-control ml-3" id="Other" placeholder="">
                        </div>
                    </div>
                    <div class="study row m-2">
                        <h6 class="best">{{__('SuperAdmin/backend.comment')}}:</h6>
                        <textarea class="form-control" id="" rows="3"> {!! $bookeddetails->comments !!}"</textarea>
                    </div>
                </div>
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    <a class="card-title">{{__('SuperAdmin/backend.registration_cancelation_conditions')}}</a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body p-0">
                        <div class="study m-2">
                            <img src="assets/img/logo.png" class="img-fluid" alt="" style="width: 100px;">
                            <h6 class="best text-center">{{__('SuperAdmin/backend.registration_cancelation_conditions')}}:</h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five
                                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker including
                                versions of Lorem Ipsum.
                            </p>
                            <h6 class="best">{{__('SuperAdmin/backend.face_to_face_program')}}:</h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five
                                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker including
                                versions of Lorem Ipsum.
                            </p>
                            <h6 class="best">{{__('SuperAdmin/backend.online_program')}}:</h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five
                                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker including
                                versions of Lorem Ipsum.
                            </p>
                            <div class="study  m-2">
                                <form action="#" onsubmit="return onSubmit(this)" method="post">
                                    <label>{{__('SuperAdmin/backend.legal_guardian_signature')}}:</label>
                                    <div>
                                        <img src="{{$bookeddetails->signature}}">
                                    </div>
                                    <div>
                                        <input type="hidden" name="signature">
                                    </div>
                                    <button type="button" class="btn btn-primary mt-1 choose">{{__('SuperAdmin/backend.save')}}</button>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="guardian" class="col-sm-6 col-form-label">{{__('SuperAdmin/backend.name_of_the_legal_guardian')}}:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" value="{{$bookeddetails->legal_guardian_name}}" class="form-control" id="guardian" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="iqama" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.id_iqama_number')}}:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" value="{{$bookeddetails->legal_id_number}}" class="form-control" id="iqama" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-6 col-form-label">{{__('SuperAdmin/backend.date')}}:</label>
                                                <div class="col-sm-6">
                                                    <p>{{$bookeddetails->created_at->format('d M Y')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="fullname" class="col-sm-5 col-form-label">{{__('SuperAdmin/backend.mobile')}}:</label>
                                                <div class="col-sm-7">
                                                    <input type="mobile" value="{{$bookeddetails->legal_mobile}}" class="form-control" id="mobile" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" checked id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">{{__('SuperAdmin/backend.i_read_agreed_to_registration_conditions_teams_conditions')}}</label>
                            </div>
                            <div class="form-check">
                                <input checked class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">{{__('SuperAdmin/backend.i_read_agreed_to_terms_condtions_school_institute')}}</label>
                            </div>
                            <p class="pt-2 diff-tution mb-0">{{__('SuperAdmin/backend.please_note_tuition_fees_embassy_requiremet')}}</p>
                            <p class="diff-tution pt-2">{{__('SuperAdmin/backend.the_tuition_fees_are_refundable_in_case_of_visa_rejection')}}</p>
                            
                            @if ($bookeddetails->course->program_registration_fee != null)
                                <h6 class="best">{{__('SuperAdmin/backend.deposit_registration_fee')}}: {{$bookeddetails->course->program_registration_fee  ?? 500 }} {{(new FrontendCalculator())->CurrencyConverted($request->program_id, $request->total_fees)['currency']}} / {{ (new FrontendCalculator())->CurrencyConverted($request->program_id, $request->total_fees)['price'] }} SAR</h6>
                            @else
                                <h6 class="best">{{__('SuperAdmin/backend.deposit_registration_fee')}}: 500 SAR</h6>
                            @endif

                            @if($bookeddetails->courier_fee != 0)
                                <h6 class="best">{{__('SuperAdmin/backend.courier_fee')}}: {{$bookeddetails->course->courseProgram->courier_fee}} {{ (new App\Classes\FrontendCalculator())->CurrencyConverted($bookeddetails->course_id, $bookeddetails->course->courseProgram->courier_fee )['currency']}} / {{ (new App\Classes\FrontendCalculator())->CurrencyConverted($bookeddetails->course_id, $bookeddetails->course->courseProgram->courier_fee )['price']}} SAR</h6>
                            @endif
                            <h6 class="best">{{__('SuperAdmin/backend.total')}} {{$bookeddetails->total_fees}} / {{$bookeddetails->other_currency}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="reservation-status mt-3">
        <form method="POST" id="send_to_student" action="{{route('superadmin.manage_application.store')}}">
            <div class="form-group row">
                {{csrf_field()}}
                <label for="inputPassword" class="col-sm-2 col-form-label">{{__('SuperAdmin/backend.reservation_status')}}</label>
                <input hidden name="id" value="{{$bookeddetails->id}}">
                <input hidden name="type_of_submit" value="update_reservation">
                <input hidden name="order_id" value="{{$bookeddetails->order_id}}">
                <div class="col-sm-8">
                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                        <option value='received' {{$bookeddetails->status == 'received' ? 'selected' : ''}}>{{__('SuperAdmin/backend.request_received')}}</option>
                        <option value='process' {{$bookeddetails->status == 'process' ? 'selected' : ''}}>{{__('SuperAdmin/backend.under_process')}}</option>
                        <option value='files_sent_to_customer' {{$bookeddetails->status == 'files_sent_to_customer' ? 'selected' : ''}}>{{__('SuperAdmin/backend.application_files_sent_to_customer')}}</option>
                        <option value='customer_response' {{$bookeddetails->status == 'customer_response' ? 'selected' : ''}}>{{__('SuperAdmin/backend.waiting_for_the_customer_response')}}</option>
                        <option value='cancelled' {{$bookeddetails->status == 'cancelled' ? 'selected' : ''}}>{{__('SuperAdmin/backend.request_cancelled')}}</option>
                        <option value='refunded' {{$bookeddetails->status == 'refunded' ? 'selected' : ''}}>{{__('SuperAdmin/backend.amount_refunded')}}</option>
                        <option value='completed' {{$bookeddetails->status == 'completed' ? 'selected' : ''}}>{{__('SuperAdmin/backend.completed')}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button onclick="sendMessage('send_to_student')" type="button" class="btn btn-primary mt-1 choose">{{__('SuperAdmin/backend.update')}}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>{{__('SuperAdmin/backend.status')}}</th>
                    <th>{{__('SuperAdmin/backend.date')}}</th>
                </tr>
                @foreach($bookeddetails->userCourseBookedStatusus as $status)
                    <tr>
                        <?php
                            switch ($status->status) {
                                case "received":
                                    $getStatus = "{{__('SuperAdmin/backend.request_received')}}";
                                    break;

                                case "process":
                                    $getStatus = "{{__('SuperAdmin/backend.under_process')}}";
                                    break;

                                case "files_sent_to_customer":
                                    $getStatus = "{{__('SuperAdmin/backend.application_files_sent_to_customer')}}";
                                    break;

                                case "customer_response":
                                    $getStatus = "{{__('SuperAdmin/backend.waiting_for_the_customer_response')}}";
                                    break;

                                case "cancelled":
                                    $getStatus = "{{__('SuperAdmin/backend.cancelled')}}";
                                    break;
                            
                                case "refunded":
                                    $getStatus = "{{__('SuperAdmin/backend.amount_refunded')}}";
                                    break;
                            
                                case "completed":
                                    $getStatus = "{{__('SuperAdmin/backend.completed')}}";
                                    break;
                            }
                            ?>
                        <td>{{$getStatus}}</td>
                        <td>{{$status->created_at->format('d M Y') ?? '-'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="Second-table mt-3 mb-3">
        <center><h5>{{__('SuperAdmin/backend.payments_refunds_statement')}}</h5></center>
        <table class="table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>{{__('SuperAdmin/backend.date_of_payment')}}</th>
                    <th>{{__('SuperAdmin/backend.amount_refunded')}}</th>
                    <th>{{__('SuperAdmin/backend.amount_paid')}}</th>
                    <th>{{__('SuperAdmin/backend.details')}}</th>
                    <th>{{__('SuperAdmin/backend.transaction_reference')}}</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>{{ $bookeddetails->created_at->format("d M Y") }}</td>
                    <td> -</td>
                    <td>{{ $bookeddetails->paid_amount }}</td>
                    <td>{{__('SuperAdmin/backend.deposit_for_course')}} {{ $bookeddetails->course->program_name }}</td>
                    <td>{{ optional($bookeddetails->transaction)->trx_reference }}</td>
                </tr>

                @forelse ($transaction_refund as $refunds)
                    <tr>
                        <td>{{ $loop->iteration + 1 }}</td>
                        <td>{{ $refunds->created_at->format("d M Y") }}</td>
                        <td>{{ $refunds->amount_refunded == null ? '-' : $refunds->amount_refunded }}</td>
                        <td>{{ $refunds->amount_added == null ? '-' : $refunds->amount_added }}</td>
                        <td>{{ $refunds->details }}</td>
                        <td>{{ $refunds->txn_reference }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center">{{__('SuperAdmin/backend.details_not_available')}}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="">
        <form id="update_payment" method="POST" action="{{route('superadmin.manage_application.store')}}">
            {{csrf_field()}}

            <div class="form-row">
                <input hidden name="id" value="{{ $bookeddetails->id }}">
                <div class="form-group col-md-6">
                    <div class="form-group row">
                        <label for="inputamount" class="col-sm-2 col-form-label">{{__('SuperAdmin/backend.amount')}}</label>
                        <div class="col-sm-10">
                            <input type="decimal" name="amount" value="" class="form-control" id="inputamount" placeholder="amount">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group row">
                        <label for="inputdetails" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <select name="symbol" class="form-control form-control-lg">
                                <option value='+'>+</option>
                                <option value='-'>-</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <input hidden name="order_id" value="{{$bookeddetails->order_id}}">
                <div class="form-group col-md-6 mb-0">
                    <div class="form-group row mb-0">
                        <label for="course_details" class="col-sm-2 col-form-label">{{__('SuperAdmin/backend.details')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="course_details" value="" class="form-control" id="course_details" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6 mb-0">
                    <div class="form-group row mb-0">
                        <label for="reference" class="col-sm-2 col-form-label">{{__('SuperAdmin/backend.transaction_reference')}}</label>
                        <div class="col-sm-10">
                            <input type="text" name="reference" value="" class="form-control" id="reference" placeholder="">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="sendMessage('update_payment')" class="btn btn-primary mt-1 choose">{{__('SuperAdmin/backend.update')}}</button>
            </div>
        </form>
    </div>

    <br>
    <b>{{__('SuperAdmin/backend.total_cost')}}:</b> {{$bookeddetails->other_currency}}
    <br>
    <b>{{__('SuperAdmin/backend.amount_paid')}}:</b> {{optional($bookeddetails->transaction)->amount ?? $bookeddetails->paid_amount + $transaction_details->amountAdded() ?? 0 }}  SAR<br>
    <b>{{__('SuperAdmin/backend.amount_refunded')}}:</b> {{$totalrefund}} SAR<br>
    <b>{{__('SuperAdmin/backend.amount_due')}}:</b> {{$transaction_details->amountDue($bookeddetails->total_balance)}} SAR
    <br><br><br>

    <div class="row">
        <div class="col-lg-6" style="display: inline; float: left">
            <form id="student_message_send" method="post" action="{{route('superadmin.manage_application.store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <center><h5>{{__('SuperAdmin/backend.contact_center_customer')}}</h5></center>
                @foreach($studentMessage as $messages)
                    <div class="p-2 mb-2" style="background: lightgray; color:black">
                        <h6 style="color:black; margin-top: 10px"><b>{{__('SuperAdmin/backend.from')}}: </b>{{ $bookeddetails->user->{'first_name_'.get_language()} }} {{ $bookeddetails->user->{'last_name_'.get_language()} }}</h6>
                        <h6 style="color:black; margin-top: 10px"><b>{{__('SuperAdmin/backend.subject')}}: </b>{{ $messages->subject }}</h6>
                        <h6 style="text-align: right;color:black"><b>{{ $messages->created_at->format('d M Y') }}</b></h6>
                        <h6 style="text-align: right;color:black"><b>+</b></h6>
                    </div>
                @endforeach
                <hr>
                <div style="margin-left: 5px">
                    <h5>{{__('SuperAdmin/backend.subject')}}</h5>
                    <input class="form-control" style="" name="subject">
                    <h5>{{__('SuperAdmin/backend.add_attachments')}}</h5>
                    <input class="form-control" type="file" multiple class="form-control" name="attachment[]">
                    <h4>{{__('SuperAdmin/backend.message')}}</h4>
                    <textarea class="form-control" rows="3" id="textareaid2"></textarea>
                    <input hidden name="message" id="messageid2">
                    <input hidden name="to_email" value="{{$bookeddetails->User->email}}">
                    <input hidden name="user_id" value="{{$bookeddetails->user_id}}">
                    <input hidden name="type_of_submit" value="send_message_to_student">
                </div>
                <button type="button" onclick="getCKEDITORdataSchool('textareaid2', 'messageid2'); sendMessage('student_message_send')" class="btn btn-primary mt-3 choose">Send</button>
            </form>
        </div>
        <div class="col-lg-6" style="display: inline; float:left">
            @if(!empty($userSchool))
                <form enctype="multipart/form-data" method="post" action="{{route('superadmin.manage_application.store')}}" id="sendschoolmessage">
                    {{csrf_field()}}
                    <center><h5>{{__('SuperAdmin/backend.contact_center_school')}}</h5></center>
                    @forelse ($chatMessage as $messages)
                        <div class="p-2 mb-2" style="background: lightgray; color:black">
                            <h6 style="color:black; margin-top: 10px"><b>{{__('SuperAdmin/backend.from')}}: </b> {{$messages->user->{'first_name_' .get_language() } }}
                            </h6>
                            <h6 style="color:black; margin-top: 10px"><b>{{__('SuperAdmin/backend.subject')}}: </b>{{$messages->subject}}</h6>
                            <h6 style="text-align: right;color:black"><b>{{$messages->created_at->format('d M Y')}}</b></h6>
                            <h6 style="text-align: right;color:black"><b>+</b></h6>
                        </div>
                    @empty
                    @endforelse
                    <hr>
                        <div>
                            <h5>{{__('SuperAdmin/backend.subject')}}</h5>
                            <input class="form-control" style="" name="subject">
                            <h5>{{__('SuperAdmin/backend.add_attachments')}}</h5>
                            <input type="file" multiple class="form-control" name="attachment[]">
                            <h4>{{__('SuperAdmin/backend.message')}}</h4>
                            <textarea name="" class="form-control" id="textareaid" rows="3"></textarea>
                            <input hidden name="message" id="messageid">
                            <input hidden name="to_email" value="{{$userSchool->email}}">
                            <input hidden name="user_id" value="{{$userSchool->id}}">
                            <input hidden name="type_of_submit" value="send_message_to_school">
                        </div>
                        <button type="button" onclick="getCKEDITORdataCustomer('textareaid', 'messageid'); sendMessage('sendschoolmessage');" class="btn btn-primary mt-3 choose">Send</button>
                </form>
            @else
            <center>{{__('SuperAdmin/backend.no_school_admin_found')}}</center>
            @endif
        </div>
    </div>

    @section('js')
        <script>
            $(document).ready(function () {
                initCkeditor("textareaid")
                initCkeditor("textareaid2")
            });
            $("#myTags1").tagit({
                fieldName: "heard_where[]"
            });
        </script>
    @endsection
@endsection