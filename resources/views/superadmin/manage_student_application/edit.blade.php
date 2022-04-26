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
    <center><h3>Reservation Details</h3></center>
    <div style="margin-left: 30px ; text-align: left">
        <b>Name : </b>{{$bookeddetails->fname ." " .$bookeddetails->mname . " " . $bookeddetails->lname }} <br>
        <b>Email : </b>{{$bookeddetails->email}}<br>
        <b>Mobile : </b>{{$bookeddetails->mobile}}<br>
    </div>
    <hr>

    <div class="reservation-section">
        <!--<div class="container">-->
        <div id="accordion" class="accordion">
            <div class="card mb-0">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                    <a class="card-title">
                        Reservation Details
                    </a>
                </div>
                <div id="collapseOne" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="course-details">
                        <h6 class="best mt-3">Reservation Details:</h6>
                        <a href = "{{route('superadmin.manage_application.editCourse', ['course_id' =>$bookeddetails->course_id, 'user_course_booked_id' => $bookeddetails->id, 'school_id' => $bookeddetails->course->school->id])}}" class="btn btn-primary pull-right">Edit</a>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>School Name</td>
                                    <?php
                                    $branch_name = is_array($bookeddetails->course->school->branch_name) ? $bookeddetails->course->school->branch_name[0] : $bookeddetails->course->school->branch_name ?? '';
                                    ?>
                                    <td>{{get_language() == 'en' ? $bookeddetails->course->school->name . ' - ' . $branch_name  :  $bookeddetails->course->school->name_ar . ' - ' . $branch_name }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{get_language() == 'en' ? $bookeddetails->course->school->city :  $bookeddetails->course->school->city_ar }}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{get_language() == 'en' ? $bookeddetails->course->school->country :  $bookeddetails->course->school->country_ar }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h6 class="best mt-3">Course Detail:</h6>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Programme Name</td>
                                <td>{{$bookeddetails->course->program_name}}</td>
                            </tr>
                            <tr>
                                <td>Lessons / Hours P/W</td>
                                <td>{{$bookeddetails->course->lessons_per_week}}
                                    Lessons/ {{$bookeddetails->course->hours_per_week}} Hours
                                </td>
                            </tr>
                            <tr>
                                <td>Duration</td>
                                <td>{{$bookeddetails->program_duration}} Weeks
                                </td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td>{{$bookeddetails->start_date->format('d-m-Y')}}</td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>{{$program_start_date = programEndDateExcludingLastWeekend($bookeddetails->start_date, $bookeddetails->program_duration)}}</td>
                            </tr>
                            <tr>
                                <td>Age Range</td>
                                <td>{{min($bookeddetails->getCourseProgram->program_age_range)}} - {{max($bookeddetails->getCourseProgram->program_age_range)}} Years
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        @if(isset($bookeddetails->accomodation->type))
                            <h6 class="best mt-3">Accommodation Details:</h6>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Accommodation type</td>
                                    <td>{{$bookeddetails->accomodation->type ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td> Duration</td>
                                    <td>{{$bookeddetails->accommodation_duration ?? ''}} Weeks</td>
                                </tr>
                                <tr>
                                    <td>Start Date</td>
                                    <td>{{$accom_start_ddate = $bookeddetails->start_date ?? \Carbon\Carbon::create($bookeddetails->start_date->toDateTimeString())->subDay()->format('d-m-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>End Date</td>
                                    <td>{{\Carbon\Carbon::create($accom_start_ddate)->addWeeks($bookeddetails->accommodation_duration)->subDay()->format('d-m-Y')}}</td>
                                </tr>
                                @if(isset($bookeddetails->accomodation->age_range))
                                    <tr>

                                        <td>Age Range</td>
                                        <td>{{min($bookeddetails->accomodation->age_range)}}
                                            - {{max($bookeddetails->accomodation->age_range)}} Years
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        @endif

                        @if(isset($bookeddetails->airport->{'airport_name_'.get_language() } ))
                            <h6 class="best mt-3">Airport Transfer:</h6>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>{{$bookeddetails->airport->{'airport_name_'.get_language() } ?? '' }}</td>

                                    <td>{{$bookeddetails->airport->{'airport_service_name_'.get_language() } ?? '' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        @endif

                        @if($bookeddetails->insurance_duration != null)
                            <h6 class="best mt-3">Medical Insurance:</h6>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Start Date</td>
                                    <td>{{$bookeddetails->start_date->subDay()->format('d-m-Y') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td>End Date</td>
                                    <td>{{$bookeddetails->start_date->subDay()->addWeeks($bookeddetails->insurance_duration)->subDay()->format('d-m-Y') ?? ''}}</td>
                                </tr>
                                </tbody>
                            </table>

                        @endif
                        <h6 class="best mt-3">Total Cost {{$bookeddetails->total_fees}}
                            / {{$bookeddetails->other_currency}} </h6>
                        <p>{{__('Please Note: Balance / final payment will be according to the exchange rate for the day of the payment')}}</p>
                    </div>
                </div>
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <a class="card-title">
                        Regsitration Form
                    </a>
                </div>
                <div id="collapseTwo" class="card-body collapse p-0" data-parent="#accordion">
                    <!--<p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt-->
                    <!--    aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat-->
                    <!--    craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.-->
                    <div class="study row m-2">

                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-5 col-form-label"> First Name*</label>
                                <div class="col-sm-7">
                                    <input type="text" name="fname" value="{{$bookeddetails->fname}}" class="form-control"
                                           id="fname" placeholder="First Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="mname" class="col-sm-5 col-form-label">Middle Name*</label>
                                <div class="col-sm-7">
                                    <input type="text" name="mname" value="{{$bookeddetails->mname}}" class="form-control"
                                           id="mname" placeholder="Middle Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="lname" class="col-sm-5 col-form-label"> Last Name*</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="lname" value="{{$bookeddetails->lname}}"
                                           id="lname" placeholder="Last Name">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row m-2"> -->

                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-5 col-form-label"> Date Of Birth:</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" value="{{$bookeddetails->dob}}" name="dob">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="city" class="col-sm-5 col-form-label">Place of Birth</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="mname" name="place_of_birth"
                                           value="{{$bookeddetails->mname}}" placeholder="City">

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="lname" class="col-sm-5 col-form-label"> Country *</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="mname" value="{{$bookeddetails->country}}" placeholder="Country*">
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="city" class="col-sm-4 col-form-label">Gender</label>
                                <div class="col-sm-7 row">
                                    <div class="form-check form-check-inline">
                                        <input required=""
                                               {{$bookeddetails->gender == 'male' ? 'checked' : ''}} class="form-check-input"
                                               type="radio" name="gender" id="inlineCheckbox1" value="male">
                                        <label class="form-check-label" for="inlineCheckbox1">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               {{$bookeddetails->gender == 'female' ? 'checked' : ''}} type="radio"
                                               name="gender" id="inlineCheckbox2" value="female">
                                        <label class="form-check-label" for="inlineCheckbox2">Female</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="nat" class="col-sm-5 col-form-label">Nationality</label>
                                <div class="col-sm-7">
                                    <select required name="nationality" class="form-control" id="nat">
                                        @foreach($nation_option as $option)
                                            <option
                                                    {{$option == $bookeddetails->nationality ? 'selected' : ''}} value="{{$option}}">{{$option}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Passport" class="col-sm-5 col-form-label">Passport no.</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="passport_number"
                                           value="{{$bookeddetails->passport_number}}" id="pport" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="portdate" class="col-sm-5 col-form-label"> Passport Date of Issue</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" name="passport_date_of_issue"
                                           value="{{$bookeddetails->passport_date_of_issue}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="edate" class="col-sm-5 col-form-label">Passport Date of Expiry</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date"
                                           value="{{$bookeddetails->passport_date_of_expiry}}"
                                           name="passport_date_of_expiry">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fname" class="col-sm-5 col-form-label"> Passport Copy Page of the
                                    details*</label>
                                <div class="col-sm-7">
                                    <a download href="{{asset($bookeddetails->passport_copy)}}">Download here</a>
                                    {{--<img src="{{asset($bookeddetails->passport_copy)}}" width="200px" height="200px">--}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="city" class="col-sm-5 col-form-label">study finance</label>
                                <div class="col-sm-7 row">
                                    <div class="form-check form-check-inline">
                                        <input
                                              class="form-check-input"
                                                type="radio" id="inlineCheckbox1"
                                                {{$bookeddetails->study_finance == 'personal' ? 'checked' : ''}}  value="personal"
                                                name="study_finance">
                                        <label class="form-check-label" for="inlineCheckbox1">Personal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               id="inlineCheckbox2" value="scholarship"
                                               {{$bookeddetails->study_finance == 'scholarship' ? 'checked' : ''}} name="study_finance">
                                        <label class="form-check-label" for="inlineCheckbox2">Scholarship</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if($bookeddetails->study_finance == 'scholarship')
                            <div class="form-group col-md-6">
                                <div class="form-group row">
                                    <label for="nat" class="col-sm-5 col-form-label">Upload Financial Guarantee</label>
                                    <div class="col-sm-7">
                                        <a href="{{asset($bookeddetails->financial_guarantee)}}" download>Download here</a>
                                        {{--<img src="{{asset($bookeddetails->financial_guarantee)}}" width="200px" height="200px">--}}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="nat" class="col-sm-5 col-form-label">ID/ Lqama Number</label>
                                <div class="col-sm-7">
                                    <input type="fname" value="{{$bookeddetails->id_number}}" class="form-control"
                                           id="fname" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="nat" class="col-sm-5 col-form-label">Your level of language?</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="nat">
                                        <option>Please select</option>
                                        <option value="Beginner (A1)" {{$bookeddetails->level_of_language == "Beginner (A1)" ? 'selected' : ''}}>
                                            Beginner (A1)
                                        </option>
                                        <option value="Elementary (A2)" {{$bookeddetails->level_of_language == "Elementary (A2)" ? 'selected' : ''}}>
                                            Elementary (A2)
                                        </option>
                                        <option value="Intermediate (B1)" {{$bookeddetails->level_of_language == "Intermediate (B1)" ? 'selected' : ''}}>
                                            Intermediate (B1)
                                        </option>
                                        <option value="Upper Intermediate (B2)" {{$bookeddetails->level_of_language == "Upper Intermediate (B2)" ? 'selected' : ''}}>
                                            Upper Intermediate (B2)
                                        </option>
                                        <option value="Advanced (C1)" {{$bookeddetails->level_of_language == "Advanced (C1)" ? 'selected' : ''}}>
                                            Advanced (C1)
                                        </option>
                                        <option value="Proficient (C2)" {{$bookeddetails->level_of_language == "Proficient (C2)" ? 'selected' : ''}}>
                                            Proficient (C2)
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if($bookeddetails->bank_statement != null)
                            <div class="form-group col-md-12">
                                <div class="form-group row">

                                    <label for="bank" class="col-sm-3 col-form-label">Bank Certificate/Statment</label>
                                    <div class="col-sm-9">
                                        <a href="{{asset($bookeddetails->bank_statement)}}" download>Download here</a>
                                        {{--<img src="{{asset($bookeddetails->bank_statement)}}" width="200px" height="200px">--}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <h6 class="best">Contact Details:</h6>
                    <div class="study row m-2">
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-3 col-form-label">Mobile* </label>
                                <div class="col-sm-9">
                                    <input type="number" name="mobile" value="{{$bookeddetails->mobile}}"
                                         class="form-control" id="mobile" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Tel" class="col-sm-3 col-form-label"> Tel*</label>
                                <div class="col-sm-9">
                                    <input type="number" value="{{$bookeddetails->telephone}}" name="telephone"
                                         class="form-control" id="Tel" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Email" class="col-sm-3 col-form-label">Email*</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" value="{{$bookeddetails->email}}" class="form-control"
                                           id="Email" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Address" class="col-sm-3 col-form-label">Address*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="address" value="{{$bookeddetails->address}}"
                                         class="form-control" id="Address" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Post" class="col-sm-3 col-form-label">Post Code*</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$bookeddetails->post_code}}" class="form-control" id="Post" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="City1" class="col-sm-3 col-form-label">City*</label>
                                <div class="col-sm-9">
                                    <input type="City1" value="{{$bookeddetails->city_contact}}" class="form-control"
                                           id="City1" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="City1" class="col-sm-3 col-form-label">Country*</label>
                                <div class="col-sm-9">
                                    <input type="City1" value="{{$bookeddetails->country_contact}}" class="form-control"
                                           id="City1" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="best">Emergency Contact Details:</h6>

                    <div class="study row m-2">
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="fullname" class="col-sm-3 col-form-label">Full Name*</label>
                                <div class="col-sm-9">
                                    <input type="fullname" value="{{$bookeddetails->full_name_emergency}}"
                                         class="form-control" id="fullname" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Relative" class="col-sm-3 col-form-label">Relative*</label>
                                <div class="col-sm-9">
                                    <input type="Relative" value="{{$bookeddetails->relative_emergency}}"
                                         class="form-control" id="Relative" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Mobile" class="col-sm-3 col-form-label">Mobile*</label>
                                <div class="col-sm-9">
                                    <input type="Mobile" value="{{$bookeddetails->mobile_emergency}}" class="form-control"
                                           id="Mobile" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Tel1" class="col-sm-3 col-form-label">Tel*</label>
                                <div class="col-sm-9">
                                    <input type="Tel1" value="{{$bookeddetails->telephone_emergency}}" class="form-control"
                                           id="Tel1" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group row">
                                <label for="Email1" class="col-sm-3 col-form-label">Email*</label>
                                <div class="col-sm-9">
                                    <input type="Email1" value="{{$bookeddetails->email_emergency}}" class="form-control"
                                           id="Email1" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="best">How you heard about link for study abroad?</h6>
                    <div class="study row m-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('Google', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Google</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('Twitter', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Twitter</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('Instagram', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Instagram</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('Snapchat', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Snapchat</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('Tiktok', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Tiktok</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('YouTube', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">YouTube</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                   {{in_array('Friend', $bookeddetails->heard_where) ? 'checked' : ''}} type="checkbox"
                                   id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">Friend</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox1">Other</label>
                            <input type="text" value="{{$bookeddetails->other}}" class="form-control ml-3" id="Email1" placeholder="">
                        </div>
                    </div>

                    <div class="study row m-2">
                        <h6 class="best">Comment:</h6>
                        <textarea class="form-control" id="" rows="3"> {!! $bookeddetails->comments !!}"</textarea>
                    </div>
                </div>
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    <a class="card-title">
                        Registration/Cancelation Conditions
                    </a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body p-0">

                        <div class="study m-2">
                            <img src="assets/img/logo.png" class="img-fluid" alt="" style="width: 100px;">
                            <h6 class="best text-center">Registration/Cancelation Conditions:</h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five
                                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker including
                                versions of Lorem Ipsum.</p>

                            <h6 class="best">Face to face Program:</h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five
                                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker including
                                versions of Lorem Ipsum.</p>

                            <h6 class="best">Online Program:</h6>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only five
                                centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker including
                                versions of Lorem Ipsum.</p>
                            <div class="study  m-2">
                                <form action="#" onsubmit="return onSubmit(this)" method="post">
                                    <label>Legal guardian Signature:</label>

                                    <div>
                                        <img src="{{$bookeddetails->signature}}">
                                    </div>
                                    <div>
                                        <input type="hidden" name="signature">
                                    </div>
                                    <!-- <button type="submit">Save</button> -->
                                    <button type="button" class="btn btn-primary mt-1 choose">Save</button>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="guardian" class="col-sm-6 col-form-label">Name of the legal
                                                    guardian:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" value="{{$bookeddetails->legal_guardian_name}}"
                                                         class="form-control" id="guardian" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="iqama" class="col-sm-5 col-form-label">ID/ Iqama Number :</label>
                                                <div class="col-sm-7">
                                                    <input type="text" value="{{$bookeddetails->legal_id_number}}"
                                                         class="form-control" id="iqama" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-6 col-form-label">Date:</label>
                                                <div class="col-sm-6">
                                                    <!-- <input type="fullname" class="form-control" id="fullname" placeholder=""> -->
                                                    <p>{{$bookeddetails->created_at->format('d M Y')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group row">
                                                <label for="fullname" class="col-sm-5 col-form-label">Mobile:</label>
                                                <div class="col-sm-7">
                                                    <input type="mobile" value="{{$bookeddetails->legal_mobile}}"
                                                         class="form-control" id="mobile" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" checked id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    I Read and Agreed to the(Registration Conditions, Teams and Conditions &amp; Private
                                    Policy) of Link for Study Abroad
                                </label>
                            </div>
                            <div class="form-check">
                                <input checked class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    I Read and Agree to the Terms and Conditions of the school/institute.
                                </label>
                            </div>
                            <p class="pt-2 diff-tution mb-0">Please note: Tuition fees need to be paid in full if you will
                                apply for the "Student Visa to the Ireland, Australia and New Zealand" to issue payment
                                receipt from school as per the embassy requiremet.</p>
                            <p class="diff-tution pt-2">The Tuition Fees are Refundable in case of visa Rejection</p>
                            @if($bookeddetails->course->program_registration_fee != null)
                                <h6 class="best">Deposit/ Registration Fee :
                                    } {{$bookeddetails->course->program_registration_fee  ?? 500 }} {{(new FrontendCalculator())->CurrencyConverted($request->program_id, $request->total_fees)['currency']}}
                                    / {{  (new FrontendCalculator())->CurrencyConverted($request->program_id, $request->total_fees)['price'] }}
                                    SAR</h6>
                            @else
                                <h6 class="best">Deposit/ Registration Fee : 500 SAR</h6>
                            @endif
                            @if($bookeddetails->courier_fee != 0)
                                <h6 class="best">Courier
                                    Fee: {{$bookeddetails->course->courseProgram->courier_fee}}  {{ (new App\Classes\FrontendCalculator())->CurrencyConverted($bookeddetails->course_id, $bookeddetails->course->courseProgram->courier_fee )['currency']}}
                                    / {{ (new App\Classes\FrontendCalculator())->CurrencyConverted($bookeddetails->course_id, $bookeddetails->course->courseProgram->courier_fee )['price']}}
                                    SAR</h6>
                            @endif
                            <h6 class="best">Total {{$bookeddetails->total_fees}} / {{$bookeddetails->other_currency}}</h6>
                        </div>
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
                <label for="inputPassword" class="col-sm-2 col-form-label">Reservation Status</label>
                <input hidden name="id" value="{{$bookeddetails->id}}">
                <input hidden name="type_of_submit" value="update_reservation">
                <input hidden name="order_id" value="{{$bookeddetails->order_id}}">
                <div class="col-sm-8">

                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                        <option value='received' {{$bookeddetails->status == 'received' ? 'selected' : ''}}>Request
                            Received
                        </option>
                        <option value='process' {{$bookeddetails->status == 'process' ? 'selected' : ''}}>Under Process
                        </option>
                        <option
                                value='files_sent_to_customer' {{$bookeddetails->status == 'files_sent_to_customer' ? 'selected' : ''}}>
                            Application/files Sent to Coustomer
                        </option>
                        <option
                                value='customer_response' {{$bookeddetails->status == 'customer_response' ? 'selected' : ''}}>
                            Waiting for the customer response
                        </option>
                        <option value='cancelled' {{$bookeddetails->status == 'cancelled' ? 'selected' : ''}}>Request
                            Cancelled
                        </option>
                        <option value='refunded' {{$bookeddetails->status == 'refunded' ? 'selected' : ''}}>Amount
                            Refunded
                        </option>
                        <option value='completed' {{$bookeddetails->status == 'completed' ? 'selected' : ''}}>Completed
                        </option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button onclick="sendMessage('send_to_student')" type="button" class="btn btn-primary mt-1 choose">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                @foreach($bookeddetails->userCourseBookedStatusus as $status)
                    <tr>
                        <?php
                            switch ($status->status) {
                                case "received" :
                                    $getStatus = "Request Received";

                                    break;
                                case "process" :
                                    $getStatus = "Under Process";
                                    break;
                                case "files_sent_to_customer" :
                                    $getStatus = "Application/files Sent to Coustomer";
                                    break;
                                case "customer_response" :
                                    $getStatus = "Waiting for the customer response";
                                    break;
                                case "cancelled" :
                                    $getStatus = "Cancelled";
                                    break;

                                case "refunded" :
                                    $getStatus = "Amount Refunded";
                                    break;

                                case "completed" :
                                    $getStatus = "Completed";
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
        <center><h5>Payments / Refunds Statement</h5></center>
        <table class="table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>Date of Payment</th>

                    <th>Amount Refunded</th>
                    <th>Amount Paid</th>
                    <th>Details</th>
                    <th>Transaction Reference</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>{{$bookeddetails->created_at->format("d M Y")}}</td>
                    <td> -</td>
                    <td>{{$bookeddetails->paid_amount}}</td>
                    <td>Deposit for Course {{$bookeddetails->course->program_name}}</td>
                    <td>{{optional($bookeddetails->transaction)->trx_reference}}</td>
                </tr>
                @forelse($transaction_refund as $refunds)
                    <tr>
                        <td>{{$loop->iteration + 1}}</td>
                        <td>{{$refunds->created_at->format("d M Y")}}</td>

                        <td>{{$refunds->amount_refunded == null ? '-' : $refunds->amount_refunded}}</td>
                        <td>{{$refunds->amount_added == null ? '-' : $refunds->amount_added}}</td>
                        <td>{{$refunds->details}}</td>

                        <td>{{$refunds->txn_reference}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center">Details Not Available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="">
        <form id="update_payment" method="POST" action="{{route('superadmin.manage_application.store')}}">
            {{csrf_field()}}
            <div class="form-row">
                <input hidden name="id" value="{{$bookeddetails->id}}">
                <div class="form-group col-md-6">
                    <div class="form-group row">
                        <label for="inputamount" class="col-sm-2 col-form-label">Amount</label>
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
                        <label for="inputdetails1" class="col-sm-2 col-form-label">Details</label>
                        <div class="col-sm-10">
                            <input type="text" name="course_details" value="" class="form-control" id="inputdetails1" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6 mb-0">
                    <div class="form-group row mb-0">
                        <label for="inputdetails2" class="col-sm-2 col-form-label">Transaction Reference</label>
                        <div class="col-sm-10">
                            <input type="text" name="reference" value="" class="form-control" id="inputdetails2" placeholder="">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="sendMessage('update_payment')" class="btn btn-primary mt-1 choose">Update
                </button>
            </div>
        </form>
    </div>

    <br>
    <b>Total Cost
        :</b> {{$bookeddetails->other_currency}}
    <br>
    <b>Amount Paid :</b> {{optional($bookeddetails->transaction)->amount ?? $bookeddetails->paid_amount +  $transaction_details->amountAdded()   ?? 0 }}  SAR<br>
    <b>Amount Refunded :</b> {{$totalrefund}} SAR<br>
    <b>Amount Due :</b> {{$transaction_details->amountDue($bookeddetails->total_balance)}} SAR
    <br><br><br>

    <div>
        <div class="row">
            <div class="col-lg-6" style="display: inline; float: left">
                <form id="student_message_send" method="post" action="{{route('superadmin.manage_application.store')}}"
                      enctype="multipart/form-data">

                    <center><h5>Contact Center - Customer</h5></center>
                    @foreach($studentMessage as $messages)
                        <div class="p-2 mb-2" style="background: lightgray; color:black">
                            <h6 style="color:black; margin-top: 10px"><b>From : </b>{{$bookeddetails->user->{'first_name_'.get_language()} }} {{$bookeddetails->user->{'last_name_'.get_language()} }}</h6>
                            <h6 style="color:black; margin-top: 10px"><b>Subject : </b>{{$messages->subject}}</h6>
                            <h6 style="text-align: right;color:black"><b>{{$messages->created_at->format('d M Y')}}</b></h6>
                            <h6 style="text-align: right;color:black"><b>+</b></h6>
                        </div>
                    @endforeach
                    <hr>

                    <div style="margin-left: 5px">
                        {{csrf_field()}}
                        <h5>Subject</h5>
                        <input class="form-control" style="" name="subject">
                        <h5>Add Attachments</h5>
                        <input class="form-control" type="file" multiple class="form-control" name="attachment[]">
                        <h4> Message </h4>
                        <!--<textarea cols="70%" rows="10"></textarea>-->
                        <textarea class="form-control" rows="3" id="textareaid2"></textarea>

                        <input hidden name="message" id="messageid2">
                        <input hidden name="to_email" value="{{$bookeddetails->User->email}}">
                        <input hidden name="user_id" value="{{$bookeddetails->user_id}}">
                        <input hidden name="type_of_submit" value="send_message_to_student">
                    </div>
                    <button type="button"
                            onclick="getCKEDITORdataSchool('textareaid2', 'messageid2'); sendMessage('student_message_send')"
                          class="btn btn-primary mt-3 choose">Send
                    </button>
                    <!--<button>Send</button>-->
                </form>
            </div>

            <div class="col-lg-6" style="display: inline; float:left">
                <form enctype="multipart/form-data" method="post" action="{{route('superadmin.manage_application.store')}}"
                      id="sendschoolmessage">
                    <center><h5>Contact Center - School</h5></center>
                    @forelse($chatMessage as $messages)
                        <div class="p-2 mb-2" style="background: lightgray; color:black">
                            <h6 style="color:black; margin-top: 10px"><b>From
                                    : </b> {{$messages->user->{'first_name_' .get_language() } }}</h6>
                            <h6 style="color:black; margin-top: 10px"><b>Subject : </b>{{$messages->subject}}</h6>
                            <h6 style="text-align: right;color:black"><b>{{$messages->created_at->format('d M Y')}}</b></h6>
                            <h6 style="text-align: right;color:black"><b>+</b></h6>
                        </div>
                    @empty
                    @endforelse

                    <hr>
                    @if(!empty($userSchool))
                        <div>
                            <h5>Subject</h5>
                            <input class="form-control" style="" name="subject">
                            {{csrf_field()}}
                            <h5>Add Attachments</h5>
                            <input type="file" multiple class="form-control" name="attachment[]">
                            <h4> Message </h4>
                            <!--<textarea cols="140" rows="10"></textarea>-->
                            <textarea name="" class="form-control" id="textareaid" rows="3"></textarea>
                            <input hidden name="message" id="messageid">
                            <input hidden name="to_email" value="{{$userSchool->email}}">
                            <input hidden name="user_id" value="{{$userSchool->id}}">
                            <input hidden name="type_of_submit" value="send_message_to_school">
                        </div>
                        <button type="button"
                                onclick="getCKEDITORdataCustomer('textareaid', 'messageid'); sendMessage('sendschoolmessage');" class="btn btn-primary mt-3 choose">Send
                        </button>
                        <!--<button>Send</button>-->
                </form>

                @else
                    <center>No School Admin Found</center>
                @endif
            </div>
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
