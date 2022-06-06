@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.reservation_details')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.reservation_details')}}</h1>
@endsection

@section('content')
    <style>
        table thead {
            background-color: #97d0db;
            color: white;
        }
        .registration-form {
            padding: 0 15px;
        }
        #collapseRegistrationForm .col-form-label {
            font-weight: bold;
        }
    </style>

    <section class="dashboard">
        <div class="container" data-aos="fade-up">
            <div class="reservation-section">
                <div id="accordion" class="accordion">
                    <div class="card mb-0">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseReservationDetails">
                            <a class="card-title">{{__('Frontend.reservation_details')}}</a>
                        </div>
                        <div id="collapseReservationDetails" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="course-details">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>{{__('Frontend.name')}}</td>
                                            <td>{{ app()->getLocale() == 'en' ? ($school->name . ($school->branch_name ? $school->branch_name : '')) : ($school->name_ar . ($school->branch_name_ar ? $school->branch_name_ar : '')) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Frontend.city')}}</td>
                                            <td>{{ app()->getLocale() == 'en' ? $school->city : $school->city_ar }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Frontend.country')}}</td>
                                            <td>{{ app()->getLocale() == 'en' ? $school->country : $school->country_ar }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{__('Frontend.course_details')}}</th>
                                            <th>{{__('Frontend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                            <th>{{__('Frontend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ $course->program_name }}, {{ $course->lessons_per_week }} {{__('Frontend.lessons')}} / {{ $course->hours_per_week }} {{__('Frontend.hours_per_week')}}<br />
                                                {{ $program_start_date }} {{__('Frontend.to')}} {{ $program_end_date }} ( {{ $course_booked_detail->program_duration }} {{__('Frontend.weeks')}} )
                                            </td>
                                            <td>{{ toFixedNumber($program_cost['value']) }}</td>
                                            <td>{{ toFixedNumber($program_cost['converted_value']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Frontend.registraion_fees')}}</td>
                                            <td>{{ toFixedNumber($program_registration_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($program_registration_fee['converted_value']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{__('Frontend.text_book_fees')}}
                                            </td>
                                            <td>{{ toFixedNumber($program_text_book_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($program_text_book_fee['converted_value']) }}</td>
                                        </tr>
                                        @if ($program_summer_fees['value'])
                                            <tr>
                                                <td>{{__('Frontend.summer_fees')}}</td>
                                                <td>{{ toFixedNumber($program_summer_fees['value']) }}</td>
                                                <td>{{ toFixedNumber($program_summer_fees['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($program_peak_time_fees['value'])
                                            <tr>
                                                <td>{{__('Frontend.peak_time_fees')}}</td>
                                                <td>{{ toFixedNumber($program_peak_time_fees['value']) }}</td>
                                                <td>{{ toFixedNumber($program_peak_time_fees['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($program_under_age_fees['value'])
                                            <tr>
                                                <td>{{__('Frontend.under_age_fees')}}</td>
                                                <td>{{ toFixedNumber($program_under_age_fees['value']) }}</td>
                                                <td>{{ toFixedNumber($program_under_age_fees['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($program_express_mail_fee['value'])
                                            <tr>
                                                <td>{{__('Frontend.express_mail_fee')}}</td>
                                                <td>{{ toFixedNumber($program_express_mail_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($program_express_mail_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($program_discount_fee['value'])
                                            <tr>
                                                <td>{{__('Frontend.discount')}}</td>
                                                <td class="highlight-value">-{{ toFixedNumber($program_discount_fee['value']) }}</td>
                                                <td class="highlight-value">-{{ toFixedNumber($program_discount_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>{{__('Frontend.age_range')}}</td>
                                            <td colspan="2">{{ $min_age ?? ''}} - {{ $max_age ?? ''}} {{__('Frontend.years')}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                @if ($accommodation)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('Frontend.accommodation_details')}}</th>
                                                <th>{{__('Frontend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                                <th>{{__('Frontend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{$accommodation->type}} - {{$accommodation->room_type}} - {{$accommodation->meal}}<br />
                                                    {{$accommodation_start_date}} to {{$accommodation_end_date}} ( {{$course_booked_detail->accommodation_duration}} {{__('Frontend.weeks')}} )
                                                </td>
                                                <td>{{ toFixedNumber($accommodation_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_fee['converted_value']) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Frontend.placement_fee')}}</td>
                                                <td>{{ toFixedNumber($accommodation_placement_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_placement_fee['converted_value']) }}</td>
                                            </tr>
                                            @if ($accommodation_special_diet_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.special_diet_fee')}}</td>
                                                    <td>{{ toFixedNumber($accommodation_special_diet_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($accommodation_special_diet_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($accommodation_deposit_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.deposit_fee')}}</td>
                                                    <td>{{ toFixedNumber($accommodation_deposit_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($accommodation_deposit_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($accommodation_summer_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.summer_fees')}}</td>
                                                    <td>{{ toFixedNumber($accommodation_summer_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($accommodation_summer_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($accommodation_peak_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.peak_time_fees')}}</td>
                                                    <td>{{ toFixedNumber($accommodation_peak_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($accommodation_peak_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($accommodation_christmas_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.christmas_fees')}}</td>
                                                    <td>{{ toFixedNumber($accommodation_christmas_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($accommodation_christmas_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($accommodation_under_age_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.under_age_fees')}}</td>
                                                    <td>{{ toFixedNumber($accommodation_under_age_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($accommodation_under_age_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($accommodation_discount_fee['value'])
                                                <tr>
                                                    <td>{{__('Frontend.discount')}}</td>
                                                    <td class="highlight-value">-{{ toFixedNumber($accommodation_discount_fee['value']) }}</td>
                                                    <td class="highlight-value">-{{ toFixedNumber($accommodation_discount_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>{{__('Frontend.age_range')}}</td>
                                                <td colspan="2">{{ $accommodation_min_age ?? ''}} - {{ $accommodation_max_age ?? ''}} {{__('Frontend.years')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                                
                                @if ($airport || $medical)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('Frontend.other_services')}}</th>
                                                <th>{{__('Frontend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                                <th>{{__('Frontend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($airport)
                                                <tr>
                                                    <td>
                                                        {{__('Frontend.transport')}}<br />
                                                        {{__('Frontend.service_provider')}}: {{ $course_booked_detail->airport_provider }}<br />
                                                        {{ $course_booked_detail->airport_name }} - {{ $course_booked_detail->airport_service }}<br />
                                                    </td>
                                                    <td>{{ toFixedNumber($airport_pickup_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($airport_pickup_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($medical)
                                                <tr>
                                                    <td>
                                                        {{__('Frontend.medical_insurance')}}<br />
                                                        {{__('Frontend.company_name')}}: {{ $course_booked_detail->company_name }}<br />
                                                        {{ $medical_start_date }} - {{ $medical_end_date }} ( {{ $course_booked_detail->duration }} {{__('Frontend.weeks')}} )<br />
                                                    </td>
                                                    <td>{{ toFixedNumber($medical_insurance_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($medical_insurance_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                                
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{__('Frontend.sub_total')}}</th>
                                            <th>{{ toFixedNumber($sub_total['value']) }} {{ $currency['cost'] }}</th>
                                            <th>{{ toFixedNumber($sub_total['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{__('Frontend.total_discount')}}</th>
                                            <th class="highlight-value">-{{ toFixedNumber($total_discount['value']) }} {{ $currency['cost'] }}</th>
                                            <th class="highlight-value">-{{ toFixedNumber($total_discount['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{__('Frontend.total_cost')}}</th>
                                            <th>{{ toFixedNumber($total_cost['value']) }} {{ $currency['cost'] }}</th>
                                            <th>{{ toFixedNumber($total_cost['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                        @if (!isset($course_register_details->financial_guarantee))
                                            <tr>
                                                <th>{{__('Frontend.amount_to_pay_now_deposit')}}</th>
                                                <th>{{ toFixedNumber($deposit_price['value']) }} {{ $currency['cost'] }}</th>
                                                <th>{{ toFixedNumber($deposit_price['converted_value']) }} {{ $currency['converted'] }}</th>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>{{__('Frontend.total_balance_due')}}</th>
                                            <th class="highlight-value">{{ toFixedNumber($total_balance['value']) }} {{ $currency['cost'] }}</th>
                                            <th class="highlight-value">{{ toFixedNumber($total_balance['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                    </thead>
                                </table>
                                
                                <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('reservation')">{{__('Frontend.print')}}</button>
                            </div>
                        </div>

                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseRegistrationForm">
                            <a class="card-title">{{__('Frontend.regsitration_form')}}</a>
                        </div>
                        <div id="collapseRegistrationForm" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="registration-form course-details">
                                <h3>{{__('Frontend.personal_info')}}:</h3>
                                <div class="study m-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fname" class="col-form-label">{{__('Frontend.first_name')}}</label>
                                                <p>{{ $course_booked_detail->fname }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mname" class="col-form-label">{{__('Frontend.middle_name')}}</label>
                                                <p>{{ $course_booked_detail->mname }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lname" class="col-form-label">{{__('Frontend.last_name')}}</label>
                                                <p>{{ $course_booked_detail->lname }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city" class="col-form-label">{{__('Frontend.place_of_birth')}}</label>
                                                <p>{{ $course_booked_detail->place_of_birth }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender" class="col-form-label">{{__('Frontend.gender')}}</label>
                                                <p>{{ $course_booked_detail->gender }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dob" class="col-form-label">{{__('Frontend.date_of_birth')}}</label>
                                                <p>{{ $course_booked_detail->dob }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.nationality')}}</label>
                                                <p>{{ $course_booked_detail->nationality }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.id_iqama_number')}}</label>
                                                <p>{{ $course_booked_detail->id_number }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Passport" class="col-form-label">{{__('Frontend.passport_no')}}</label>
                                                <p>{{ $course_booked_detail->passport_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="portdate" class="col-form-label">{{__('Frontend.passport_date_of_issue')}}</label>
                                                <p>{{ $course_booked_detail->passport_date_of_issue }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edate" class="col-form-label">{{__('Frontend.passport_date_of_expiry')}}</label>
                                                <p>{{ $course_booked_detail->passport_date_of_expiry }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fname" class="col-form-label">{{__('Frontend.upload_passport_copy')}}</label>
                                                @if ($course_booked_detail->passport_copy)
                                                    <img src="{{ $course_booked_detail->passport_copy }}" class="img-fluid" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.your_level_of_language')}}</label>
                                                <p>
                                                    @if ($course_booked_detail->level_of_language == 'beginner_a1')
                                                        {{__('Frontend.beginner_a1')}}
                                                    @elseif ($course_booked_detail->level_of_language == 'elementary_a2')
                                                        {{__('Frontend.elementary_a2')}}
                                                    @elseif ($course_booked_detail->level_of_language == 'intermediate_b1')
                                                        {{__('Frontend.intermediate_b1')}}
                                                    @elseif ($course_booked_detail->level_of_language == 'upper_intermediate_b2')
                                                        {{__('Frontend.upper_intermediate_b2')}}
                                                    @elseif ($course_booked_detail->level_of_language == 'advanced_c1')
                                                        {{__('Frontend.advanced_c1')}}
                                                    @elseif ($course_booked_detail->level_of_language == 'proficient_c2')
                                                        {{__('Frontend.proficient_c2')}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city" class="col-form-label">{{__('Frontend.study_finance')}}</label>
                                                <p>
                                                    @if ($course_booked_detail->study_finance == 'personal')
                                                        {{__('Frontend.personal')}}
                                                    @elseif ($course_booked_detail->study_finance == 'scholarship')
                                                        {{__('Frontend.scholarship')}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="financial_guarantee">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.upload_financial_gurantee')}}</label>
                                                @if ($course_booked_detail->financial_guarantee)
                                                    <img src="{{ $course_booked_detail->financial_guarantee }}" class="img-fluid" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="bank_statement">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.upload_bank_statement')}}</label>
                                                @if ($course_booked_detail->bank_statement)
                                                    <img src="{{ $course_booked_detail->bank_statement }}"  class="img-fluid" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="best">{{__('Frontend.contact_details')}}:</h3>
                                <div class="study m-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mobile" class="col-form-label">{{__('Frontend.mobile')}}</label>
                                                <p>{{ $course_booked_detail->mobile }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Tel" class="col-form-label">{{__('Frontend.tel')}}</label>
                                                <p>{{ $course_booked_detail->telephone }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Email" class="col-form-label">{{__('Frontend.email')}}</label>
                                                <p>{{ $course_booked_detail->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="Address" class="col-form-label">{{__('Frontend.address')}}</label>
                                                <p>{{ $course_booked_detail->address }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Post" class="col-form-label">{{__('Frontend.post_code')}}</label>
                                                <p>{{ $course_booked_detail->post_code }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city_contact" class="col-form-label">{{__('Frontend.city')}}</label>
                                                <p>{{ $course_booked_detail->city_contact }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="province_region" class="col-form-label">{{__('Frontend.province_region')}}</label>
                                                <p>{{ $course_booked_detail->province_region }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country_contact" class="col-form-label">{{__('Frontend.country')}}</label>
                                                <p>{{ $course_booked_detail->country_contact }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="best">{{__('Frontend.emergency_contact_details')}}:</h3>
                                <div class="study m-2">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="full_name_emergency" class="col-form-label">{{__('Frontend.full_name')}}</label>
                                                <p>{{ $course_booked_detail->full_name_emergency }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="relative_emergency" class="col-form-label">{{__('Frontend.relative')}}</label>
                                                <p>{{ $course_booked_detail->relative_emergency }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mobile_emergency" class="col-form-label">{{__('Frontend.mobile')}}</label>
                                                <p>{{ $course_booked_detail->mobile_emergency }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telephone_emergency" class="col-form-label">{{__('Frontend.tel')}}</label>
                                                <p>{{ $course_booked_detail->telephone_emergency }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email_emergency" class="col-form-label">{{__('Frontend.email')}}</label>
                                                <p>{{ $course_booked_detail->email_emergency }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="best">{{__('Frontend.how_you_heard_about_link_for_study_abroad')}}</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ implode($course_booked_detail->heard_where, ", ") }}</p>
                                        <p>{{ $course_booked_detail->other }}</p>
                                    </div>
                                </div>

                                <h3 class="best">{{__('Frontend.comment')}}</h3>
                                <div class="study m-2">
                                    <p>{{ $course_booked_detail->comments }}</p>
                                </div>
                                
                                <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('registration')">{{__('Frontend.print')}}</button>
                            </div>
                        </div>
                        
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseRegistrationCancellationConditions">
                            <a class="card-title">{{__('Frontend.registration_cancelation_conditions')}}</a>
                        </div>
                        <div id="collapseRegistrationCancellationConditions" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="registration-cancellation-conditions course-details">
                                <div class="study m-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="" />
                                        </div>
                                        <div class="col-md-9">
                                            <h2>{{__('Frontend.registration_cancelation_conditions')}}</h2>
                                        </div>
                                    </div>
                                    <div class="row border-top-bottom form-group">
                                        <div class="col-md-12">
                                            <p>{{__('Frontend.registration_cancelation_conditions_description')}}</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label for="student_guardian_full_name" class="col-form-label"><strong>{{__('Frontend.student_guardian_full_name')}}</strong>:</label>
                                            <p>{{ $course_booked_detail->guardian_full_name }}</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <label class="col-form-label"><strong>{{__('Frontend.date')}}:</strong></label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="col-form-label">{{ $today }}</label>
                                        </div>
                                    </div>
                                    <div class="row form-group mb-3">
                                        <div class="col-md-2">
                                            <label class="col-form-label"><strong>{{__('Frontend.signature')}}:</strong></label>
                                        </div>
                                        <div class="col-md-10">
                                            <img src="{{ $course_booked_detail->signature }}" />
                                        </div>
                                    </div>
                                </div>
                                    
                                <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('registration_cancellation')">{{__('Frontend.print')}}</button>
                            </div>
                        </div>
                        
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseReservationStatus">
                            <a class="card-title">{{__('Frontend.reservation_status')}}</a>
                        </div>
                        <div id="collapseReservationStatus" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="reservation-status mt-3">
                                <div class="col-sm-12">
                                    <p>
                                        @if ($course_booked_detail->status == 'received')
                                            {{__('Frontend.request_received')}}
                                        @elseif ($course_booked_detail->status == 'process')
                                            {{__('Frontend.under_process')}}
                                        @elseif ($course_booked_detail->status == 'files_sent_to_customer')
                                            {{__('Frontend.application_files_sent_to_customer')}}
                                        @elseif ($course_booked_detail->status == 'customer_response')
                                            {{__('Frontend.waiting_for_customer_response')}}
                                        @elseif ($course_booked_detail->status == 'cancelled')
                                            {{__('Frontend.request_cancelled')}}
                                        @elseif ($course_booked_detail->status == 'refunded')
                                            {{__('Frontend.amount_refunded')}}
                                        @elseif ($course_booked_detail->status == 'completed')
                                            {{__('Frontend.application_procedure_completed')}}
                                        @elseif ($course_booked_detail->status == 'studying')
                                            {{__('Frontend.studying')}}
                                        @elseif ($course_booked_detail->status == 'course_extension')
                                            {{__('Frontend.customer_request_course_extension')}}
                                        @elseif ($course_booked_detail->status == 'request_cancellation')
                                            {{__('Frontend.customer_request_cancellation')}}
                                        @elseif ($course_booked_detail->status == 'amount_refunded')
                                            {{__('Frontend.amount_refunded')}}
                                        @elseif ($course_booked_detail->status == 'application_cancelled')
                                            {{__('Frontend.application_cancelled')}}
                                        @elseif ($course_booked_detail->status == 'end')
                                            {{__('Frontend.course_end')}}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>{{__('Frontend.status')}}</th>
                                                <th>{{__('Frontend.date')}}</th>
                                            </tr>
                                            @foreach($course_booked_detail->userCourseBookedStatusus as $status)
                                                <tr>
                                                    <td>
                                                        @if ($status->status == 'received')
                                                            {{__('Frontend.request_received')}}
                                                        @elseif ($status->status == 'process')
                                                            {{__('Frontend.under_process')}}
                                                        @elseif ($status->status == 'files_sent_to_customer')
                                                            {{__('Frontend.application_files_sent_to_customer')}}
                                                        @elseif ($status->status == 'customer_response')
                                                            {{__('Frontend.waiting_for_customer_response')}}
                                                        @elseif ($status->status == 'cancelled')
                                                            {{__('Frontend.request_cancelled')}}
                                                        @elseif ($status->status == 'refunded')
                                                            {{__('Frontend.amount_refunded')}}
                                                        @elseif ($status->status == 'completed')
                                                            {{__('Frontend.completed')}}
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
                            <a class="card-title">{{__('Frontend.payments_refunds_statement')}}</a>
                        </div>
                        <div id="collapsePaymentsRefundsStatement" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="payments-refunds-statement mt-3">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Frontend.date_of_payment')}}</th>
                                                <th>{{__('Frontend.amount_refunded')}}</th>
                                                <th>{{__('Frontend.amount_paid')}}</th>
                                                <th>{{__('Frontend.details')}}</th>
                                                <th>{{__('Frontend.transaction_reference')}}</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>{{$course_booked_detail->created_at->format("d M Y")}}</td>
                                                <td> -</td>
                                                <td>{{$course_booked_detail->paid_amount}}</td>
                                                <td>{{__('Frontend.deposit_for_course')}} {{$course_booked_detail->course->program_name}}</td>
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
                                                    <td colspan="6" style="text-align:center">{{__('Frontend.details_not_available')}}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>{{__('Frontend.currency')}}</th>
                                                <th>{{__('Frontend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                                <th>{{__('Frontend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                            </tr>
                                            <tr>
                                                <td>{{__('Frontend.total_cost')}}</td>
                                                <td>{{ toFixedNumber($total_cost['value']) }}</td>
                                                <td>{{ toFixedNumber($total_cost['converted_value']) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Frontend.total_amount_paid')}}</td>
                                                <td>{{ toFixedNumber($amount_paid['value']) }}</td>
                                                <td>{{ toFixedNumber($amount_paid['converted_value']) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Frontend.total_amount_refunded')}}</td>
                                                <td>{{ toFixedNumber($amount_refunded['value']) }}</td>
                                                <td>{{ toFixedNumber($amount_refunded['converted_value']) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Frontend.total_amount_due')}}</td>
                                                <td>{{ toFixedNumber($amount_due['value']) }}</td>
                                                <td>{{ toFixedNumber($amount_due['converted_value']) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('payments_refunds')">{{__('Frontend.print')}}</button>
                            </div>
                        </div>
                
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseContactCenter">
                            <a class="card-title">{{__('Frontend.contact_center')}}</a>
                        </div>
                        <div id="collapseContactCenter" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="contact-center row mt-3 p-3">
                                <div class="col-lg-12">
                                    <form id="contact_center_admin" method="post" action="{{ route('dashboard.course_application.send_message') }}">
                                        <h5 class="text-center">{{__('Frontend.contact_center_admin')}}</h5>

                                        <div class="row">
                                            @foreach ($student_messages as $student_message)
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="From" class="col-form-label">{{__('Frontend.From')}}</label>
                                                        @if (app()->getLocale() == 'en')
                                                            {{ $course_booked_detail->User->first_name }} {{ $course_booked_detail->User->last_name }}
                                                        @else
                                                            {{ $course_booked_detail->User->first_name_ar }} {{ $course_booked_detail->User->last_name_ar }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="subject" class="col-form-label">{{__('Frontend.subject')}}</label>
                                                        {{ $student_message->subject }}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="message" class="col-form-label">{{__('Frontend.message')}}</label>
                                                        {{ $student_message->created_at->format('d M Y') }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subject" class="col-form-label">{{__('Frontend.subject')}}</label>
                                                    <input class="form-control" name="subject">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="add_attachments" class="col-form-label">{{__('Frontend.add_attachments')}}</label>
                                                    <input class="form-control" type="file" multiple class="form-control" name="attachment[]">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="message" class="col-form-label">{{__('Frontend.message')}}</label>
                                                    <textarea class="form-control" rows="3" name="message"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <input hidden name="to_email" value="{{ $course_booked_detail->User->email }}" />
                                        <input hidden name="user_id" value="{{ $course_booked_detail->user_id }}" />

                                        <button type="button" onclick="submitFormAction('contact_center_admin');" class="btn btn-primary px-3">{{__('Frontend.send')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function printCourseApplication(section) {
            $.ajax({
                url: "{{route('dashboard.course_application.print')}}",
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
                        link.download = "{{__('Frontend.reservation_details')}} {{ $course_booked_detail->id }}.pdf";
                    } else if (section == 'registration') {
                        link.download = "{{__('Frontend.regsitration_form')}} {{ $course_booked_detail->id }}.pdf";
                    } else if (section == 'registration_cancellation') {
                        link.download = "{{__('Frontend.registration_cancelation_conditions')}} {{ $course_booked_detail->id }}.pdf";
                    } else if (section == 'payments_refunds') {
                        link.download = "{{__('Frontend.payments_refunds_statement')}} {{ $course_booked_detail->id }}.pdf";
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