@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.reservation_details')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{route('frontend.dashboard')}}" class="breadcrumb-home">
            <i class="bx bxs-dashboard"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.reservation_details')}}</h1>
    </div>
@endsection

@section('content')
    <div class="dashboard">
        <div class="container" data-aos="fade-up">
            <div class="reservation-section">
                <div id="accordion" class="accordion">
                    <div class="card mb-0">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseReservationDetails">
                            <a class="card-title">{{__('Frontend.reservation_details')}}</a>
                        </div>
                        <div id="collapseReservationDetails" class="card-body collapse p-0" data-parent="#accordion">
                            <div class="course-details">
                                <table class="table table-bordered table-no-drawable">
                                    <tbody>
                                        <tr>
                                            <td>{{__('Frontend.name')}}</td>
                                            <td>{{ $school->name ? (app()->getLocale() == 'en' ? ($school->name->name ?? '-') : ($school->name->name_ar ?? '-')) : '-' }} {{ app()->getLocale() == 'en' ? ($school->branch_name ?? '') : ($school->branch_name_ar ?? '') }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Frontend.city')}}</td>
                                            <td>{{ $school->city ? (app()->getLocale() == 'en' ? ($school->city->name ?? '-') : ($school->city->name_ar ?? '-')) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Frontend.country')}}</td>
                                            <td>{{ $school->country ? (app()->getLocale() == 'en' ? ($school->country->name ?? '-') : ($school->country->name_ar ?? '-')) : '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-no-drawable">
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
                                                <p>{{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}, {{ $course->lessons_per_week }} {{__('Frontend.lessons')}} / {{ $course->hours_per_week }} {{__('Frontend.hours_per_week')}}</p>
                                                <p>{{ $program_start_date }} {{__('Frontend.to')}} {{ $program_end_date }} ( {{ $course_application->program_duration }} {{__('Frontend.weeks')}} )</p>
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
                                    <table class="table table-bordered table-no-drawable">
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
                                                    <p>{{app()->getLocale() == 'en' ? $accommodation->type : $accommodation->type_ar}} - {{app()->getLocale() == 'en' ? $accommodation->room_type : $accommodation->room_type_ar}} - {{app()->getLocale() == 'en' ? $accommodation->meal : $accommodation->meal_ar}}</p>
                                                    <p>{{$accommodation_start_date}} to {{$accommodation_end_date}} ( {{$course_application->accommodation_duration}} {{__('Frontend.weeks')}} )</p>
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
                                
                                @if ($airport || $medical || $custodian)
                                    <table class="table table-bordered table-no-drawable">
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
                                                        <p>{{__('Frontend.transport')}}</p>
                                                        <p>{{__('Frontend.service_provider')}}: {{ $airport_provider }}</p>
                                                        <p>{{ $airport_name }} - {{ $airport_service }}</p>
                                                    </td>
                                                    <td>{{ toFixedNumber($airport_pickup_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($airport_pickup_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($medical)
                                                <tr>
                                                    <td>
                                                        <p>{{__('Frontend.medical_insurance')}}</p>
                                                        <p>{{__('Frontend.company_name')}}: {{ $company_name }}</p>
                                                        <p>{{ $medical_start_date }} - {{ $medical_end_date }} ( {{ $course_application->medical_duration }} {{__('Frontend.weeks')}} )</p>
                                                    </td>
                                                    <td>{{ toFixedNumber($medical_insurance_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($medical_insurance_fee['converted_value']) }}</td>
                                                </tr>
                                            @endif
                                            @if ($custodian)
                                                <tr>
                                                    <td>
                                                        <p>{{__('Frontend.custodian')}}</p>
                                                        <p>{{__('Frontend.age_range')}}: {{ $course_application->custodian_min_age ?? ''}} - {{ $course_application->custodian_max_age ?? ''}} {{__('Frontend.years')}}</p>
                                                    </td>
                                                    <td>{{ toFixedNumber($custodian_fee['value']) }}</td>
                                                    <td>{{ toFixedNumber($custodian_fee['converted_value']) }}</td>
                                                    <input type="hidden" value="{{$custodian_fee['value']}}" name="custodian_fee" />
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                                
                                <table class="table table-bordered table-no-drawable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Frontend.sub_total')}}</th>
                                            <th>{{ toFixedNumber($sub_total['value']) }} {{ $currency['cost'] }}</th>
                                            <th>{{ toFixedNumber($sub_total['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{__('Frontend.bank_charge_fee')}}</td>
                                            <td>{{ toFixedNumber($bank_charge_fee['value']) }} {{ $currency['cost'] }}</td>
                                            <td>{{ toFixedNumber($bank_charge_fee['converted_value']) }} {{ $currency['converted'] }}</td>
                                        </tr>
                                        @if ($link_fee['value'])
                                            <tr>
                                                <td>{{__('Frontend.link_fee_including_vat')}} <span class="vat_fee">{{ $vat_fee }}</span>%</td>
                                                <td>{{ toFixedNumber($link_fee['value']) }} {{ $currency['cost'] }}</td>
                                                <td>{{ toFixedNumber($link_fee['converted_value']) }} {{ $currency['converted'] }}</td>
                                            </tr>
                                        @endif
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
                                        @if (!isset($course_application->financial_guarantee))
                                            <tr>
                                                <th>{{__('Frontend.amount_to_pay_now_deposit')}}</th>
                                                <th>{{ toFixedNumber($deposit_price['value']) }} {{ $currency['cost'] }}</th>
                                                <th>{{ toFixedNumber($deposit_price['converted_value']) }} {{ $currency['converted'] }}</th>
                                            </tr>
                                        @endif
                                        @if ($coupon_discount['value'])
                                            <tr>
                                                <th>{{__('Frontend.discount_code')}}</th>
                                                <th class="highlight-value">-{{ toFixedNumber($coupon_discount['value']) }} {{ $currency['cost'] }}</th>
                                                <th class="highlight-value">-{{ toFixedNumber($coupon_discount['converted_value']) }} {{ $currency['converted'] }}</th>
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
                                                <p>{{ $course_application->fname }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mname" class="col-form-label">{{__('Frontend.middle_name')}}</label>
                                                <p>{{ $course_application->mname }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lname" class="col-form-label">{{__('Frontend.last_name')}}</label>
                                                <p>{{ $course_application->lname }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city" class="col-form-label">{{__('Frontend.place_of_birth')}}</label>
                                                <p>{{ $course_application->place_of_birth }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender" class="col-form-label">{{__('Frontend.gender')}}</label>
                                                <p>{{ $course_application->gender }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dob" class="col-form-label">{{__('Frontend.date_of_birth')}}</label>
                                                <p>{{ $course_application->dob }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.nationality')}}</label>
                                                <p>{{ $course_application->nationality }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.id_iqama_number')}}</label>
                                                <p>{{ $course_application->id_number }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Passport" class="col-form-label">{{__('Frontend.passport_no')}}</label>
                                                <p>{{ $course_application->passport_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="portdate" class="col-form-label">{{__('Frontend.passport_date_of_issue')}}</label>
                                                <p>{{ $course_application->passport_date_of_issue }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edate" class="col-form-label">{{__('Frontend.passport_date_of_expiry')}}</label>
                                                <p>{{ $course_application->passport_date_of_expiry }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fname" class="col-form-label">{{__('Frontend.upload_passport_copy')}}</label>
                                                @if ($course_application->passport_copy)
                                                    <img src="{{ '/storage/app/public/' . $course_application->passport_copy }}" class="img-fluid" />
                                                    <form method="post" action="{{route('frontend.download')}}">
                                                        @csrf
                                                        <input name="file" type="hidden" value="{{ $course_application->passport_copy }}" />
                                                        <button class="btn btn-primary btn-sm">{{__('Frontend.download')}}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.your_level_of_language')}}</label>
                                                <p>
                                                    @if ($course_application->level_of_language == 'beginner_a1')
                                                        {{__('Frontend.beginner_a1')}}
                                                    @elseif ($course_application->level_of_language == 'elementary_a2')
                                                        {{__('Frontend.elementary_a2')}}
                                                    @elseif ($course_application->level_of_language == 'intermediate_b1')
                                                        {{__('Frontend.intermediate_b1')}}
                                                    @elseif ($course_application->level_of_language == 'upper_intermediate_b2')
                                                        {{__('Frontend.upper_intermediate_b2')}}
                                                    @elseif ($course_application->level_of_language == 'advanced_c1')
                                                        {{__('Frontend.advanced_c1')}}
                                                    @elseif ($course_application->level_of_language == 'proficient_c2')
                                                        {{__('Frontend.proficient_c2')}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city" class="col-form-label">{{__('Frontend.study_finance')}}</label>
                                                <p>
                                                    @if ($course_application->study_finance == 'personal')
                                                        {{__('Frontend.personal')}}
                                                    @elseif ($course_application->study_finance == 'scholarship')
                                                        {{__('Frontend.scholarship')}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="financial_guarantee">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.upload_financial_gurantee')}}</label>
                                                @if ($course_application->financial_guarantee)
                                                    <img src="{{ '/storage/app/public/' . $course_application->financial_guarantee }}" class="img-fluid" />
                                                    <form method="post" action="{{route('frontend.download')}}">
                                                        @csrf
                                                        <input name="file" type="hidden" value="{{ $course_application->financial_guarantee }}" />
                                                        <button class="btn btn-primary btn-sm">{{__('Frontend.download')}}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="bank_statement">
                                            <div class="form-group">
                                                <label for="nat" class="col-form-label">{{__('Frontend.upload_bank_statement')}}</label>
                                                @if ($course_application->bank_statement)
                                                    <img src="{{ '/storage/app/public/' . $course_application->bank_statement }}"  class="img-fluid" />
                                                    <form method="post" action="{{route('frontend.download')}}">
                                                        @csrf
                                                        <input name="file" type="hidden" value="{{ $course_application->bank_statement }}" />
                                                        <button class="btn btn-primary btn-sm">{{__('Frontend.download')}}</button>
                                                    </form>
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
                                                <p>{{ $course_application->mobile }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Tel" class="col-form-label">{{__('Frontend.tel')}}</label>
                                                <p>{{ $course_application->telephone }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Email" class="col-form-label">{{__('Frontend.email')}}</label>
                                                <p>{{ $course_application->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="Address" class="col-form-label">{{__('Frontend.address')}}</label>
                                                <p>{{ $course_application->address }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Post" class="col-form-label">{{__('Frontend.post_code')}}</label>
                                                <p>{{ $course_application->post_code }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city_contact" class="col-form-label">{{__('Frontend.city')}}</label>
                                                <p>{{ $course_application->city_contact }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="province_region" class="col-form-label">{{__('Frontend.province_region')}}</label>
                                                <p>{{ $course_application->province_region }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country_contact" class="col-form-label">{{__('Frontend.country')}}</label>
                                                <p>{{ $course_application->country_contact }}</p>
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
                                                <p>{{ $course_application->full_name_emergency }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="relative_emergency" class="col-form-label">{{__('Frontend.relative')}}</label>
                                                <p>{{ $course_application->relative_emergency }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mobile_emergency" class="col-form-label">{{__('Frontend.mobile')}}</label>
                                                <p>{{ $course_application->mobile_emergency }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telephone_emergency" class="col-form-label">{{__('Frontend.tel')}}</label>
                                                <p>{{ $course_application->telephone_emergency }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email_emergency" class="col-form-label">{{__('Frontend.email')}}</label>
                                                <p>{{ $course_application->email_emergency }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="best">{{str_replace("###SITE_NAME", __('Frontend.how_you_heard_about_site_name'), __('Frontend.site_name'))}}</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ implode($course_application->heard_where, ", ") }}</p>
                                        <p>{{ $course_application->other }}</p>
                                    </div>
                                </div>

                                <h3 class="best">{{__('Frontend.comment')}}</h3>
                                <div class="study m-2">
                                    <p>{{ $course_application->comments }}</p>
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
                                            {!! app()->getLocale() == 'en' ? $course_application->registration_cancelation_conditions : $course_application->registration_cancelation_conditions_ar !!}
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label for="student_guardian_full_name" class="col-form-label"><strong>{{__('Frontend.student_guardian_full_name')}}</strong>:</label>
                                            <p>{{ $course_application->guardian_full_name }}</p>
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
                                            <img src="{{ $course_application->signature }}" />
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
                            <div class="reservation-status my-3">
                                <div class="col-sm-12">
                                    <p>
                                        @if ($course_application->status == 'received')
                                            {{__('Frontend.request_received')}}
                                        @elseif ($course_application->status == 'process')
                                            {{__('Frontend.under_process')}}
                                        @elseif ($course_application->status == 'files_sent_to_customer')
                                            {{__('Frontend.application_files_sent_to_customer')}}
                                        @elseif ($course_application->status == 'customer_response')
                                            {{__('Frontend.waiting_for_customer_response')}}
                                        @elseif ($course_application->status == 'cancelled')
                                            {{__('Frontend.request_cancelled')}}
                                        @elseif ($course_application->status == 'refunded')
                                            {{__('Frontend.amount_refunded')}}
                                        @elseif ($course_application->status == 'completed')
                                            {{__('Frontend.application_procedure_completed')}}
                                        @elseif ($course_application->status == 'studying')
                                            {{__('Frontend.studying')}}
                                        @elseif ($course_application->status == 'course_extension')
                                            {{__('Frontend.customer_request_course_extension')}}
                                        @elseif ($course_application->status == 'request_cancellation')
                                            {{__('Frontend.customer_request_cancellation')}}
                                        @elseif ($course_application->status == 'amount_refunded')
                                            {{__('Frontend.amount_refunded')}}
                                        @elseif ($course_application->status == 'application_cancelled')
                                            {{__('Frontend.application_cancelled')}}
                                        @elseif ($course_application->status == 'end')
                                            {{__('Frontend.course_end')}}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-no-drawable">
                                        <tbody>
                                            <tr>
                                                <th>{{__('Frontend.status')}}</th>
                                                <th>{{__('Frontend.date')}}</th>
                                            </tr>
                                            @foreach($course_application->courseApplicationStatusus as $status)
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
                                    <table class="table table-bordered table-no-drawable">
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
                                                <td>{{ $course_application->created_at->format("d M Y") }}</td>
                                                <td> -</td>
                                                <td>{{ $course_application->paid_amount}}</td>
                                                <td>{{ __('Frontend.deposit_for_course') }} {{ $course_application->course->program_name }}</td>
                                                <td>{{ optional($course_application->transaction)->trx_reference }}</td>
                                            </tr>
                                            @forelse ($transaction_refunds as $transaction_refund)
                                                <tr>
                                                    <td>{{ $loop->iteration + 1 }}</td>
                                                    <td>{{ $transaction_refund->created_at->format("d M Y") }}</td>
                                                    <td>{{ $transaction_refund->amount_refunded == null ? '-' : $transaction_refund->amount_refunded }}</td>
                                                    <td>{{ $transaction_refund->amount_added == null ? '-' : $transaction_refund->amount_added }}</td>
                                                    <td>{{ $transaction_refund->details }}</td>
                                                    <td>{{ $transaction_refund->txn_reference }}</td>
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
                                    <table class="table table-bordered table-no-drawable">
                                        <tbody>
                                            <tr>
                                                <th>{{__('Frontend.currency')}}</th>
                                                <th>{{__('Frontend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                                <th>{{__('Frontend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                            </tr>
                                            <tr>
                                                <td>{{__('Frontend.total_cost')}}</td>
                                                <td>{{ toFixedNumber($total_cost_fixed['value']) }}</td>
                                                <td>{{ toFixedNumber($total_cost_fixed['converted_value']) }}</td>
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
                                    <form id="contact_center_admin" method="post" action="{{ route('frontend.dashboard.course_application.send_message') }}">
                                        @csrf

                                        <h5 class="text-center">{{__('Frontend.contact_center_admin')}}</h5>
                                        
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

                                        <input hidden name="type" value="to_admin" />
                                        <input hidden name="type_id" value="{{ $course_application->id }}" />

                                        <button type="button" onclick="submitFormAction('contact_center_admin');" class="btn btn-primary px-3">{{__('Frontend.send')}}</button>
                                    </form>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach ($student_messages as $student_message)
                                                <div class="message-item">
                                                    <div class="message-header">
                                                        <div class="message-user-image">
                                                            @if ($student_message->fromUser->image)
                                                                <img src="{{ $student_message->fromUser->image }}" alt="profile">
                                                            @else
                                                                <img src="{{ asset('assets/images/user.png') }}" alt="profile">
                                                            @endif
                                                        </div>
                                                        <div class="message-user-name">
                                                            @if ($student_message->type == 'to_admin')
                                                                {{ $course_application->fname ." " . $course_application->mname . " " . $course_application->lname }}
                                                            @else
                                                                @if (app()->getLocale() == 'en')
                                                                    {{ $student_message->fromUser->first_name_en }} {{ $student_message->fromUser->last_name_en }}
                                                                @else
                                                                    {{ $student_message->fromUser->first_name_ar }} {{ $student_message->fromUser->last_name_ar }}
                                                                @endif
                                                            @endif
                                                            @if ($student_message->type == 'to_student')
                                                                <i class="bx bxs-chevron-left"></i>
                                                            @else
                                                                <i class="bx bxs-chevron-right"></i>
                                                            @endif
                                                        </div>
                                                        <div class="message-time">
                                                            {{ $student_message->created_at->format('d M Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="message-body">
                                                        <div>
                                                            <strong>{{__('Admin/backend.subject')}}: </strong>{{ $student_message->subject }}
                                                        </div>
                                                        <div>
                                                            <strong>{{__('Admin/backend.message')}}: </strong>{!! $student_message->message !!}
                                                        </div>
                                                        <div>
                                                            <strong>{{__('Admin/backend.attachments')}}: </strong>
                                                            @if ($student_message->attachments)
                                                                @foreach ($student_message->attachments as $message_attachment)
                                                                    @php $attachment_ext = strtolower(pathinfo($message_attachment, PATHINFO_EXTENSION)); @endphp
                                                                    <a href="{{ $message_attachment }}" target="_blank">
                                                                        @if ($attachment_ext == 'doc' || $attachment_ext == 'docx')
                                                                            <i class="bx bxs-file-doc"></i>
                                                                        @elseif ($attachment_ext == 'pdf')
                                                                            <i class="bx bxs-file-pdf"></i>
                                                                        @elseif ($attachment_ext == 'jpg' || $attachment_ext == 'bmp' || $attachment_ext == 'png')
                                                                            <i class="bx bxs-file-image"></i>
                                                                        @endif
                                                                    </a>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printCourseApplication(section) {
            $.ajax({
                url: "{{route('frontend.dashboard.course_application.print')}}",
                method: 'POST',
                data: { _token: $("meta[name='csrf-token']").attr('content'), id: "{{ $course_application->id }}", section: section },
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
                        link.download = "{{__('Frontend.reservation_details')}} {{ $course_application->id }}.pdf";
                    } else if (section == 'registration') {
                        link.download = "{{__('Frontend.regsitration_form')}} {{ $course_application->id }}.pdf";
                    } else if (section == 'registration_cancellation') {
                        link.download = "{{__('Frontend.registration_cancelation_conditions')}} {{ $course_application->id }}.pdf";
                    } else if (section == 'payments_refunds') {
                        link.download = "{{__('Frontend.payments_refunds_statement')}} {{ $course_application->id }}.pdf";
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