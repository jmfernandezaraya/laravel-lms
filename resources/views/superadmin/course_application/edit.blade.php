@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.reservation_details')}}
@endsection

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
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        table thead {
            background-color: #97d0db;
            color: white;
        }
        .table td, .table th {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
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
        .registration-form {
            padding: 0 15px;
        }
        .col-form-label {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <h3>{{__('SuperAdmin/backend.reservation_details')}}</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>{{__('SuperAdmin/backend.name')}}</td>
                <td>{{ $course_booked_detail->fname ." " . $course_booked_detail->mname . " " . $course_booked_detail->lname }}</td>
            </tr>
            <tr>
                <td>{{__('SuperAdmin/backend.email')}}</td>
                <td>{{ $course_booked_detail->email }}</td>
            </tr>
            <tr>
                <td>{{__('SuperAdmin/backend.mobile')}}</td>
                <td>{{ $course_booked_detail->mobile }}</td>
            </tr>
        </tbody>
    </table>
    <div class="reservation-section">
        <div id="accordion" class="accordion">
            <div class="card mb-0">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapseReservationDetails">
                    <a class="card-title">{{__('SuperAdmin/backend.reservation_details')}}</a>
                </div>
                <div id="collapseReservationDetails" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="course-details">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.name')}}</td>
                                    <td>{{ app()->getLocale() == 'en' ? ($course_booked_detail->course->school->name . ($course_booked_detail->course->school->branch_name ? $course_booked_detail->course->school->branch_name : '')) : ($course_booked_detail->course->school->name_ar . ($course_booked_detail->course->school->branch_name_ar ? $course_booked_detail->course->school->branch_name_ar : '')) }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.city')}}</td>
                                    <td>{{ app()->getLocale() == 'en' ? $course_booked_detail->course->school->city : $course_booked_detail->course->school->city_ar }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.country')}}</td>
                                    <td>{{ app()->getLocale() == 'en' ? $course_booked_detail->course->school->country : $course_booked_detail->course->school->country_ar }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('SuperAdmin/backend.course_details')}}</th>
                                    <th>{{__('SuperAdmin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                    <th>{{__('SuperAdmin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $course->program_name }}, {{ $course->lessons_per_week }} {{__('SuperAdmin/backend.lessons')}} / {{ $course->hours_per_week }} {{__('SuperAdmin/backend.hours_per_week')}}<br />
                                        {{ $program_start_date }} {{__('SuperAdmin/backend.to')}} {{ $program_end_date }} ( {{ $course_booked_detail->program_duration }} {{__('SuperAdmin/backend.weeks')}} )
                                    </td>
                                    <td>{{ toFixedNumber($program_cost['value']) }}</td>
                                    <td>{{ toFixedNumber($program_cost['converted_value']) }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('SuperAdmin/backend.registraion_fees')}}</td>
                                    <td>{{ toFixedNumber($program_registration_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($program_registration_fee['converted_value']) }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__('SuperAdmin/backend.text_book_fees')}}
                                    </td>
                                    <td>{{ toFixedNumber($program_text_book_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($program_text_book_fee['converted_value']) }}</td>
                                </tr>
                                @if ($program_summer_fees['value'])
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.summer_fees')}}</td>
                                        <td>{{ toFixedNumber($program_summer_fees['value']) }}</td>
                                        <td>{{ toFixedNumber($program_summer_fees['converted_value']) }}</td>
                                    </tr>
                                @endif
                                @if ($program_peak_time_fees['value'])
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.peak_time_fees')}}</td>
                                        <td>{{ toFixedNumber($program_peak_time_fees['value']) }}</td>
                                        <td>{{ toFixedNumber($program_peak_time_fees['converted_value']) }}</td>
                                    </tr>
                                @endif
                                @if ($program_under_age_fees['value'])
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.under_age_fees')}}</td>
                                        <td>{{ toFixedNumber($program_under_age_fees['value']) }}</td>
                                        <td>{{ toFixedNumber($program_under_age_fees['converted_value']) }}</td>
                                    </tr>
                                @endif
                                @if ($program_express_mail_fee['value'])
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.express_mail_fee')}}</td>
                                        <td>{{ toFixedNumber($program_express_mail_fee['value']) }}</td>
                                        <td>{{ toFixedNumber($program_express_mail_fee['converted_value']) }}</td>
                                    </tr>
                                @endif
                                @if ($program_discount_fee['value'])
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.discount')}}</td>
                                        <td class="highlight">-{{ toFixedNumber($program_discount_fee['value']) }}</td>
                                        <td class="highlight">-{{ toFixedNumber($program_discount_fee['converted_value']) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>{{__('SuperAdmin/backend.age_range')}}</td>
                                    <td colspan="2">{{ $min_age ?? ''}} - {{ $max_age ?? ''}} {{__('SuperAdmin/backend.years')}}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if ($accommodation)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('SuperAdmin/backend.accommodation_details')}}</th>
                                        <th>{{__('SuperAdmin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                        <th>{{__('SuperAdmin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{$accommodation->type}} - {{$accommodation->room_type}} - {{$accommodation->meal}}<br />
                                            {{$accommodation_start_date}} to {{$accommodation_end_date}} ( {{$course_booked_detail->accommodation_duration}} {{__('SuperAdmin/backend.weeks')}} )
                                        </td>
                                        <td>{{ toFixedNumber($accommodation_fee['value']) }}</td>
                                        <td>{{ toFixedNumber($accommodation_fee['converted_value']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.placement_fee')}}</td>
                                        <td>{{ toFixedNumber($accommodation_placement_fee['value']) }}</td>
                                        <td>{{ toFixedNumber($accommodation_placement_fee['converted_value']) }}</td>
                                    </tr>
                                    @if ($accommodation_special_diet_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.special_diet_fee')}}</td>
                                            <td>{{ toFixedNumber($accommodation_special_diet_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_special_diet_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_deposit_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.deposit_fee')}}</td>
                                            <td>{{ toFixedNumber($accommodation_deposit_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_deposit_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_custodian_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.custodian_fee')}}</td>
                                            <td>{{ toFixedNumber($accommodation_custodian_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_custodian_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_summer_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.summer_fees')}}</td>
                                            <td>{{ toFixedNumber($accommodation_summer_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_summer_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_peak_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.peak_time_fees')}}</td>
                                            <td>{{ toFixedNumber($accommodation_peak_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_peak_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_christmas_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.christmas_fees')}}</td>
                                            <td>{{ toFixedNumber($accommodation_christmas_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_christmas_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_under_age_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.under_age_fees')}}</td>
                                            <td>{{ toFixedNumber($accommodation_under_age_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_under_age_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($accommodation_discount_fee['value'])
                                        <tr>
                                            <td>{{__('SuperAdmin/backend.discount')}}</td>
                                            <td class="highlight">-{{ toFixedNumber($accommodation_discount_fee['value']) }}</td>
                                            <td class="highlight">-{{ toFixedNumber($accommodation_discount_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.age_range')}}</td>
                                        <td colspan="2">{{ $accommodation_min_age ?? ''}} - {{ $accommodation_max_age ?? ''}} {{__('SuperAdmin/backend.years')}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        
                        @if ($airport || $medical)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('SuperAdmin/backend.other_services')}}</th>
                                        <th>{{__('SuperAdmin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                        <th>{{__('SuperAdmin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($airport)
                                        <tr>
                                            <td>
                                                {{__('SuperAdmin/backend.transport')}}<br />
                                                {{__('SuperAdmin/backend.service_provider')}}: {{ $course_booked_detail->airport_provider }}<br />
                                                {{ $course_booked_detail->airport_name }} - {{ $course_booked_detail->airport_service }}<br />
                                            </td>
                                            <td>{{ toFixedNumber($airport_pickup_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($airport_pickup_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($medical)
                                        <tr>
                                            <td>
                                                {{__('SuperAdmin/backend.medical_insurance')}}<br />
                                                {{__('SuperAdmin/backend.company_name')}}: {{ $course_booked_detail->company_name }}<br />
                                                {{ $medical_start_date }} - {{ $medical_end_date }} ( {{ $course_booked_detail->duration }} {{__('SuperAdmin/backend.weeks')}} )<br />
                                            </td>
                                            <td>{{ toFixedNumber($medical_insurance_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($medical_insurance_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        @endif
                        
                        <table class="table table-bordered mb-3">
                            <thead>
                                <tr>
                                    <th>{{__('SuperAdmin/backend.sub_total')}}</th>
                                    <th>{{ toFixedNumber($sub_total['value']) }} {{ $currency['cost'] }}</th>
                                    <th>{{ toFixedNumber($sub_total['converted_value']) }} {{ $currency['converted'] }}</th>
                                </tr>
                                <tr>
                                    <th>{{__('SuperAdmin/backend.total_discount')}}</th>
                                    <th class="highlight">-{{ toFixedNumber($total_discount['value']) }} {{ $currency['cost'] }}</th>
                                    <th class="highlight">-{{ toFixedNumber($total_discount['converted_value']) }} {{ $currency['converted'] }}</th>
                                </tr>
                                <tr>
                                    <th>{{__('SuperAdmin/backend.total_cost')}}</th>
                                    <th>{{ toFixedNumber($total_cost['value']) }} {{ $currency['cost'] }}</th>
                                    <th>{{ toFixedNumber($total_cost['converted_value']) }} {{ $currency['converted'] }}</th>
                                </tr>
                                @if (!isset($course_register_details->financial_guarantee))
                                    <tr>
                                        <th>{{__('SuperAdmin/backend.amount_to_pay_now_deposit')}}</th>
                                        <th>{{ toFixedNumber($deposit_price['value']) }} {{ $currency['cost'] }}</th>
                                        <th>{{ toFixedNumber($deposit_price['converted_value']) }} {{ $currency['converted'] }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th>{{__('SuperAdmin/backend.total_balance_due')}}</th>
                                    <th class="highlight">{{ toFixedNumber($total_balance['value']) }} {{ $currency['cost'] }}</th>
                                    <th class="highlight">{{ toFixedNumber($total_balance['converted_value']) }} {{ $currency['converted'] }}</th>
                                </tr>
                            </thead>
                        </table>
                        
                        <a href="{{route('superadmin.manage_application.editCourse', ['course_id' => $course_booked_detail->course_id, 'user_course_booked_id' => $course_booked_detail->id, 'school_id' => $course_booked_detail->course->school->id])}}" class="btn btn-primary px-5">Edit</a>
                        <button type="button" class="btn btn-primary float-right px-5" onclick="printCourseApplication('reservation')">{{__('SuperAdmin/backend.print')}}</button>
                    </div>
                </div>

                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseRegistrationForm">
                    <a class="card-title">{{__('SuperAdmin/backend.regsitration_form')}}</a>
                </div>
                <div id="collapseRegistrationForm" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="registration-form course-details">
                        <h4 class="m-2">{{__('SuperAdmin/backend.personal_info')}}:</h4>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname" class="col-form-label">{{__('SuperAdmin/backend.first_name')}}</label>
                                        <p>{{ $course_booked_detail->fname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mname" class="col-form-label">{{__('SuperAdmin/backend.middle_name')}}</label>
                                        <p>{{ $course_booked_detail->mname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lname" class="col-form-label">{{__('SuperAdmin/backend.last_name')}}</label>
                                        <p>{{ $course_booked_detail->lname }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">{{__('SuperAdmin/backend.place_of_birth')}}</label>
                                        <p>{{ $course_booked_detail->place_of_birth }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender" class="col-form-label">{{__('SuperAdmin/backend.gender')}}</label>
                                        <p>{{ $course_booked_detail->gender }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dob" class="col-form-label">{{__('SuperAdmin/backend.date_of_birth')}}</label>
                                        <p>{{ $course_booked_detail->dob }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('SuperAdmin/backend.nationality')}}</label>
                                        <p>{{ $course_booked_detail->nationality }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('SuperAdmin/backend.id_iqama_number')}}</label>
                                        <p>{{ $course_booked_detail->id_number }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Passport" class="col-form-label">{{__('SuperAdmin/backend.passport_no')}}</label>
                                        <p>{{ $course_booked_detail->passport_number }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="portdate" class="col-form-label">{{__('SuperAdmin/backend.passport_date_of_issue')}}</label>
                                        <p>{{ $course_booked_detail->passport_date_of_issue }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edate" class="col-form-label">{{__('SuperAdmin/backend.passport_date_of_expiry')}}</label>
                                        <p>{{ $course_booked_detail->passport_date_of_expiry }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname" class="col-form-label">{{__('SuperAdmin/backend.upload_passport_copy')}}</label>
                                        @if ($course_booked_detail->passport_copy)
                                            <img src="public/images/user_booked_details/{{ $course_booked_detail->passport_copy }}" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('SuperAdmin/backend.your_level_of_language')}}</label>
                                        <p>
                                            @if ($course_booked_detail->level_of_language == 'beginner_a1')
                                                {{__('SuperAdmin/backend.beginner_a1')}}
                                            @elseif ($course_booked_detail->level_of_language == 'elementary_a2')
                                                {{__('SuperAdmin/backend.elementary_a2')}}
                                            @elseif ($course_booked_detail->level_of_language == 'intermediate_b1')
                                                {{__('SuperAdmin/backend.intermediate_b1')}}
                                            @elseif ($course_booked_detail->level_of_language == 'upper_intermediate_b2')
                                                {{__('SuperAdmin/backend.upper_intermediate_b2')}}
                                            @elseif ($course_booked_detail->level_of_language == 'advanced_c1')
                                                {{__('SuperAdmin/backend.advanced_c1')}}
                                            @elseif ($course_booked_detail->level_of_language == 'proficient_c2')
                                                {{__('SuperAdmin/backend.proficient_c2')}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">{{__('SuperAdmin/backend.study_finance')}}</label>
                                        <p>
                                            @if ($course_booked_detail->study_finance == 'personal')
                                                {{__('SuperAdmin/backend.personal')}}
                                            @elseif ($course_booked_detail->study_finance == 'scholarship')
                                                {{__('SuperAdmin/backend.scholarship')}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4" id="financial_guarantee">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('SuperAdmin/backend.upload_financial_gurantee')}}</label>
                                        @if ($course_booked_detail->financial_guarantee)
                                            <img src="public/images/user_booked_details/{{ $course_booked_detail->financial_guarantee }}" />
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4" id="bank_statement">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('SuperAdmin/backend.upload_bank_statement')}}</label>
                                        @if ($course_booked_detail->bank_statement)
                                            <img src="public/images/user_booked_details/{{ $course_booked_detail->bank_statement }}" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="best">{{__('SuperAdmin/backend.contact_details')}}:</h4>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile" class="col-form-label">{{__('SuperAdmin/backend.mobile')}}</label>
                                        <p>{{ $course_booked_detail->mobile }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tel" class="col-form-label">{{__('SuperAdmin/backend.tel')}}</label>
                                        <p>{{ $course_booked_detail->telephone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Email" class="col-form-label">{{__('SuperAdmin/backend.email')}}</label>
                                        <p>{{ $course_booked_detail->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="Address" class="col-form-label">{{__('SuperAdmin/backend.address')}}</label>
                                        <p>{{ $course_booked_detail->address }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Post" class="col-form-label">{{__('SuperAdmin/backend.post_code')}}</label>
                                        <p>{{ $course_booked_detail->post_code }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city_contact" class="col-form-label">{{__('SuperAdmin/backend.city')}}</label>
                                        <p>{{ $course_booked_detail->city_contact }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="province_region" class="col-form-label">{{__('SuperAdmin/backend.province_region')}}</label>
                                        <p>{{ $course_booked_detail->province_region }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country_contact" class="col-form-label">{{__('SuperAdmin/backend.country')}}</label>
                                        <p>{{ $course_booked_detail->country_contact }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="best">{{__('SuperAdmin/backend.emergency_contact_details')}}:</h4>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="full_name_emergency" class="col-form-label">{{__('SuperAdmin/backend.full_name')}}</label>
                                        <p>{{ $course_booked_detail->full_name_emergency }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="relative_emergency" class="col-form-label">{{__('SuperAdmin/backend.relative')}}</label>
                                        <p>{{ $course_booked_detail->relative_emergency }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_emergency" class="col-form-label">{{__('SuperAdmin/backend.mobile')}}</label>
                                        <p>{{ $course_booked_detail->mobile_emergency }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telephone_emergency" class="col-form-label">{{__('SuperAdmin/backend.tel')}}</label>
                                        <p>{{ $course_booked_detail->telephone_emergency }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email_emergency" class="col-form-label">{{__('SuperAdmin/backend.email')}}</label>
                                        <p>{{ $course_booked_detail->email_emergency }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="best">{{__('SuperAdmin/backend.how_you_heard_about_link_for_study_abroad')}}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <p>{{ implode($course_booked_detail->heard_where, ", ") }}</p>
                                <p>{{ $course_booked_detail->other }}</p>
                            </div>
                        </div>

                        <h4 class="best">{{__('SuperAdmin/backend.comment')}}</h4>
                        <div class="study m-2">
                            <p>{{ $course_booked_detail->comments }}</p>
                        </div>
                        
                        <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('registration')">{{__('SuperAdmin/backend.print')}}</button>
                    </div>
                </div>
                
                <div class="card-header collapsed" data-toggle="collapse" href="#collapseRegistrationCancellationConditions">
                    <a class="card-title">{{__('SuperAdmin/backend.registration_cancelation_conditions')}}</a>
                </div>
                <div id="collapseRegistrationCancellationConditions" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="study m-2">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="" />
                            </div>
                            <div class="col-md-9">
                                <h2>{{__('SuperAdmin/backend.registration_cancelation_conditions')}}</h2>
                            </div>
                        </div>
                        <div class="row border-top-bottom form-group">
                            <div class="col-md-12">
                                <p>{{__('SuperAdmin/backend.registration_cancelation_conditions_description')}}</p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="student_guardian_full_name" class="col-form-label"><strong>{{__('SuperAdmin/backend.student_guardian_full_name')}}</strong>:</label>
                                <p>{{ $course_booked_detail->guardian_full_name }}</p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label class="col-form-label"><strong>{{__('SuperAdmin/backend.date')}}:</strong></label>
                            </div>
                            <div class="col-md-10">
                                <label class="col-form-label">{{ $today }}</label>
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <div class="col-md-2">
                                <label class="col-form-label"><strong>{{__('SuperAdmin/backend.signature')}}:</strong></label>
                            </div>
                            <div class="col-md-10">
                                <img src="{{ $course_booked_detail->signature }}" />
                            </div>
                        </div>
                    </div>
                        
                    <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('registration_cancellation')">{{__('SuperAdmin/backend.print')}}</button>
                </div>
                
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseReservationStatus">
                    <a class="card-title">{{__('SuperAdmin/backend.reservation_status')}}</a>
                </div>
                <div id="collapseReservationStatus" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="reservation-status mt-3">
                        <div class="col-sm-12">
                            <form method="POST" id="update_reservation" action="{{route('superadmin.manage_application.store')}}">
                                <div class="form-group row">
                                    {{csrf_field()}}

                                    <label for="reservation_status" class="col-sm-2 col-form-label">{{__('SuperAdmin/backend.reservation_status')}}</label>
                                    <input hidden name="id" value="{{ $course_booked_detail->id }}">
                                    <input hidden name="type_of_submit" value="update_reservation">
                                    <input hidden name="order_id" value="{{ $course_booked_detail->order_id }}">
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status" id="reservation_status">
                                            <option value='received' {{$course_booked_detail->status == 'received' ? 'selected' : ''}}>{{__('SuperAdmin/backend.request_received')}}</option>
                                            <option value='process' {{$course_booked_detail->status == 'process' ? 'selected' : ''}}>{{__('SuperAdmin/backend.under_process')}}</option>
                                            <option value='files_sent_to_customer' {{$course_booked_detail->status == 'files_sent_to_customer' ? 'selected' : ''}}>{{__('SuperAdmin/backend.application_files_sent_to_customer')}}</option>
                                            <option value='customer_response' {{$course_booked_detail->status == 'customer_response' ? 'selected' : ''}}>{{__('SuperAdmin/backend.waiting_for_customer_response')}}</option>
                                            <option value='cancelled' {{$course_booked_detail->status == 'cancelled' ? 'selected' : ''}}>{{__('SuperAdmin/backend.request_cancelled')}}</option>
                                            <option value='completed' {{$course_booked_detail->status == 'completed' ? 'selected' : ''}}>{{__('SuperAdmin/backend.application_procedure_completed')}}</option>
                                            <option value='studying' {{$course_booked_detail->status == 'studying' ? 'selected' : ''}}>{{__('SuperAdmin/backend.studying')}}</option>
                                            <option value='course_extension' {{$course_booked_detail->status == 'course_extension' ? 'selected' : ''}}>{{__('SuperAdmin/backend.customer_request_course_extension')}}</option>
                                            <option value='request_cancellation' {{$course_booked_detail->status == 'request_cancellation' ? 'selected' : ''}}>{{__('SuperAdmin/backend.customer_request_cancellation')}}</option>
                                            <option value='refunded' {{$course_booked_detail->status == 'refunded' ? 'selected' : ''}}>{{__('SuperAdmin/backend.amount_refunded')}}</option>
                                            <option value='application_cancelled' {{$course_booked_detail->status == 'cancelled' ? 'selected' : ''}}>{{__('SuperAdmin/backend.application_cancelled')}}</option>
                                            <option value='end' {{$course_booked_detail->status == 'end' ? 'selected' : ''}}>{{__('SuperAdmin/backend.course_end')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button onclick="submitFormAction('update_reservation')" type="button" class="btn btn-primary mt-1 choose">{{__('SuperAdmin/backend.update')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{__('SuperAdmin/backend.status')}}</th>
                                        <th>{{__('SuperAdmin/backend.date')}}</th>
                                    </tr>
                                    @foreach($course_booked_detail->userCourseBookedStatusus as $status)
                                        <tr>
                                            <td>
                                                @if ($status->status == 'received')
                                                    {{__('SuperAdmin/backend.request_received')}}
                                                @elseif ($status->status == 'process')
                                                    {{__('SuperAdmin/backend.under_process')}}
                                                @elseif ($status->status == 'files_sent_to_customer')
                                                    {{__('SuperAdmin/backend.application_files_sent_to_customer')}}
                                                @elseif ($status->status == 'customer_response')
                                                    {{__('SuperAdmin/backend.waiting_for_customer_response')}}
                                                @elseif ($status->status == 'cancelled')
                                                    {{__('SuperAdmin/backend.request_cancelled')}}
                                                @elseif ($status->status == 'completed')
                                                    {{__('SuperAdmin/backend.application_procedure_completed')}}
                                                @elseif ($status->status == 'studying')
                                                    {{__('SuperAdmin/backend.studying')}}
                                                @elseif ($status->status == 'course_extension')
                                                    {{__('SuperAdmin/backend.customer_request_course_extension')}}
                                                @elseif ($status->status == 'request_cancellation')
                                                    {{__('SuperAdmin/backend.customer_request_cancellation')}}
                                                @elseif ($status->status == 'refunded')
                                                    {{__('SuperAdmin/backend.amount_refunded')}}
                                                @elseif ($status->status == 'application_cancelled')
                                                    {{__('SuperAdmin/backend.application_cancelled')}}
                                                @elseif ($status->status == 'end')
                                                    {{__('SuperAdmin/backend.course_end')}}
                                                @endif
                                            </td>
                                            <td>{{ $status->created_at->format('d M Y') ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePaymentsRefundsStatement">
                    <a class="card-title">{{__('SuperAdmin/backend.payments_refunds_statement')}}</a>
                </div>
                <div id="collapsePaymentsRefundsStatement" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="payments-refunds-statement mt-3">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
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
                                        <td>{{$course_booked_detail->created_at->format("d M Y")}}</td>
                                        <td> -</td>
                                        <td>{{$course_booked_detail->paid_amount}}</td>
                                        <td>{{__('SuperAdmin/backend.deposit_for_course')}} {{$course_booked_detail->course->program_name}}</td>
                                        <td>{{optional($course_booked_detail->transaction)->trx_reference}}</td>
                                    </tr>
                                    @forelse ($transaction_refund as $refunds)
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
                                            <td colspan="6" style="text-align:center">{{__('SuperAdmin/backend.details_not_available')}}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 my-3">
                            <form id="update_payment" method="POST" action="{{ route('superadmin.manage_application.store') }}">
                                {{csrf_field()}}

                                <div class="form-row">
                                    <input hidden name="id" value="{{ $course_booked_detail->id }}">
                                    <div class="form-group col-md-6">
                                        <div class="form-group row">
                                            <label for="inputamount" class="col-sm-4 col-form-label">{{__('SuperAdmin/backend.amount')}}</label>
                                            <div class="col-sm-8">
                                                <input type="decimal" name="amount" value="" class="form-control" id="inputamount" placeholder="amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group row">
                                            <label for="inputdetails" class="col-sm-4 col-form-label"></label>
                                            <div class="col-sm-8">
                                                <select name="symbol" class="form-control form-control-lg">
                                                    <option value='+'>+</option>
                                                    <option value='-'>-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <input hidden name="order_id" value="{{ $course_booked_detail->order_id }}">
                                    <div class="form-group col-md-6 mb-0">
                                        <div class="form-group row mb-0">
                                            <label for="course_details" class="col-sm-4 col-form-label">{{__('SuperAdmin/backend.details')}}</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="course_details" value="" class="form-control" id="course_details" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <div class="form-group row mb-0">
                                            <label for="reference" class="col-sm-4 col-form-label">{{__('SuperAdmin/backend.transaction_reference')}}</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="reference" value="" class="form-control" id="reference" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="submitFormAction('update_payment')" class="btn btn-primary float-right mt-1 choose">{{__('SuperAdmin/backend.update')}}</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{__('SuperAdmin/backend.currency')}}</th>
                                        <th>{{__('SuperAdmin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                        <th>{{__('SuperAdmin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.total_cost')}}</td>
                                        <td>{{ toFixedNumber($total_cost['value']) }}</td>
                                        <td>{{ toFixedNumber($total_cost['converted_value']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.total_amount_paid')}}</td>
                                        <td>{{ toFixedNumber($amount_paid['value']) }}</td>
                                        <td>{{ toFixedNumber($amount_paid['converted_value']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.total_amount_refunded')}}</td>
                                        <td>{{ toFixedNumber($amount_refunded['value']) }}</td>
                                        <td>{{ toFixedNumber($amount_refunded['converted_value']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('SuperAdmin/backend.total_amount_due')}}</td>
                                        <td>{{ toFixedNumber($amount_due['value']) }}</td>
                                        <td>{{ toFixedNumber($amount_due['converted_value']) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('payments_refunds')">{{__('SuperAdmin/backend.print')}}</button>
                    </div>
                </div>                
                
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseContactCenter">
                    <a class="card-title">{{__('SuperAdmin/backend.contact_center')}}</a>
                </div>
                <div id="collapseContactCenter" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="contact-center row mt-3 p-3">
                        <div class="col-lg-6">
                            <form id="contact_center_customer" method="post" action="{{ route('superadmin.manage_application.store') }}">
                                <h5 class="text-center">{{__('SuperAdmin/backend.contact_center_customer')}}</h5>
                                <div class="row">
                                    @foreach ($student_messages as $student_message)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="From" class="col-form-label">{{__('SuperAdmin/backend.From')}}</label>
                                                @if (app()->getLocale() == 'en')
                                                    {{ $course_booked_detail->User->first_name }} {{ $course_booked_detail->User->last_name }}
                                                @else
                                                    {{ $course_booked_detail->User->first_name_ar }} {{ $course_booked_detail->User->last_name_ar }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="subject" class="col-form-label">{{__('SuperAdmin/backend.subject')}}</label>
                                                {{ $student_message->subject }}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="message" class="col-form-label">{{__('SuperAdmin/backend.message')}}</label>
                                                {{ $student_message->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subject" class="col-form-label">{{__('SuperAdmin/backend.subject')}}</label>
                                            <input class="form-control" name="subject">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="add_attachments" class="col-form-label">{{__('SuperAdmin/backend.add_attachments')}}</label>
                                            <input class="form-control" type="file" multiple class="form-control" name="attachment[]">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message" class="col-form-label">{{__('SuperAdmin/backend.message')}}</label>
                                            <textarea class="form-control" rows="3" id="customerMessageText"></textarea>
                                            <input hidden name="message" id="customerMessageInput">
                                        </div>
                                    </div>
                                </div>

                                <input hidden name="to_email" value="{{ $course_booked_detail->User->email }}" />
                                <input hidden name="user_id" value="{{ $course_booked_detail->user_id }}" />

                                <button type="button" onclick="getCkEditorData('customerMessageText', 'customerMessageInput'); sendMessage('contact_center_customer');" class="btn btn-primary px-3">{{__('SuperAdmin/backend.send')}}</button>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            @if (!empty($user_school))
                                <form id="contact_center_school" method="post" action="{{ route('superadmin.manage_application.store') }}">
                                    <h5 class="text-center">{{__('SuperAdmin/backend.contact_center_school')}}</h5>
                                    <div class="row">
                                        @foreach ($chat_messages as $chat_message)
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="From" class="col-form-label">{{__('SuperAdmin/backend.From')}}</label>
                                                    @if (app()->getLocale() == 'en')
                                                        {{ $chat_message->user->first_name }} {{ $course_booked_detail->user->last_name }}
                                                    @else
                                                        {{ $chat_message->user->first_name_ar }} {{ $course_booked_detail->user->last_name_ar }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subject" class="col-form-label">{{__('SuperAdmin/backend.subject')}}</label>
                                                    {{ $student_message->subject }}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="message" class="col-form-label">{{__('SuperAdmin/backend.message')}}</label>
                                                    {{ $student_message->created_at->format('d M Y') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="subject" class="col-form-label">{{__('SuperAdmin/backend.subject')}}</label>
                                                <input class="form-control" name="subject">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="add_attachments" class="col-form-label">{{__('SuperAdmin/backend.add_attachments')}}</label>
                                                <input class="form-control" type="file" multiple class="form-control" name="attachment[]">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="message" class="col-form-label">{{__('SuperAdmin/backend.message')}}</label>
                                                <textarea class="form-control" rows="3" id="schoolMessageText"></textarea>
                                                <input hidden name="message" id="schoolMessageInput">
                                            </div>
                                        </div>
                                    </div>

                                    <input hidden name="to_email" value="{{ $course_booked_detail->User->email }}" />
                                    <input hidden name="user_id" value="{{ $course_booked_detail->user_id }}" />

                                    <button type="button" onclick="getCkEditorData('schoolMessageText', 'schoolMessageInput'); sendMessage('contact_center_school');" class="btn btn-primary px-3">{{__('SuperAdmin/backend.send')}}</button>
                                </form>
                            @else
                                {{__('SuperAdmin/backend.no_school_admin_found')}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $(document).ready(function () {
                initCkeditor("customerMessageText")
                initCkeditor("schoolMessageText")
            });
            
            function printCourseApplication(section) {
                $.ajax({
                    url: "{{route('superadmin.manage_application.print')}}",
                    method: 'POST',
                    data: { _token: $("meta[name='csrf-token']").attr('content'), id: "{{ $course_booked_detail->id }}", section: section },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        $("#loader").hide();
                        if (data.errors) {
                            $('.alert-danger').show();
                            $('.alert-danger ul').html('');
                            for (var error in data.errors) {
                                $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                            }
                        } else if (data.message) {
                            $('.alert-danger').show();
                            $('.alert-danger ul').html('');
                            for (var error in data.errors) {
                                $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                            }
                        }
                        var blob = new Blob([data]);
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        if (section == 'reservation') {
                            link.download = "{{__('SuperAdmin/backend.reservation_details')}} {{ $course_booked_detail->id }}.pdf";
                        } else if (section == 'registration') {
                            link.download = "{{__('SuperAdmin/backend.regsitration_form')}} {{ $course_booked_detail->id }}.pdf";
                        } else if (section == 'registration_cancellation') {
                            link.download = "{{__('SuperAdmin/backend.registration_cancelation_conditions')}} {{ $course_booked_detail->id }}.pdf";
                        } else if (section == 'payments_refunds') {
                            link.download = "{{__('SuperAdmin/backend.payments_refunds_statement')}} {{ $course_booked_detail->id }}.pdf";
                        }
                        link.click();
                    },
                    error: function(blob) {
                        $("#loader").hide();
                    }
                });
            }
        </script>
    @endsection
@endsection