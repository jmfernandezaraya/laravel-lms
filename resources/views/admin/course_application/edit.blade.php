@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.reservation_details')}}
@endsection

@section('content')
    <h3>{{__('Admin/backend.reservation_details')}}</h3>
    <table class="table table-bordered table-no-drawable">
        <tbody>
            <tr>
                <td>{{__('Admin/backend.name')}}</td>
                <td>{{ $course_application->fname ." " . $course_application->mname . " " . $course_application->lname }}</td>
            </tr>
            <tr>
                <td>{{__('Admin/backend.email')}}</td>
                <td>{{ $course_application->email }}</td>
            </tr>
            <tr>
                <td>{{__('Admin/backend.mobile')}}</td>
                <td>{{ $course_application->mobile }}</td>
            </tr>
            <tr>
                <td>{{__('Admin/backend.order_id')}}</td>
                <td>{{ $course_application->order_id }}</td>
            </tr>
        </tbody>
    </table>
    <div class="reservation-section">
        <div id="accordion" class="accordion">
            <div class="card mb-0">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapseReservationDetails">
                    <a class="card-title">{{__('Admin/backend.reservation_details')}}</a>
                </div>
                <div id="collapseReservationDetails" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="course-details">
                        <table class="table table-bordered table-no-drawable">
                            <tbody>
                                <tr>
                                    <td>{{__('Admin/backend.name')}}</td>
                                    <td>
                                        {{ $course_application->course->school && $course_application->course->school->name ? (app()->getLocale() == 'en' ? $course_application->course->school->name->name : $course_application->course->school->name->name_ar) : ''}}
                                        &nbsp;
                                        {{ app()->getLocale() == 'en' ? ($course_application->course->school->branch_name ?? '') : ($course_application->course->school->branch_name_ar ?? '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('Admin/backend.city')}}</td>
                                    <td>{{ $course_application->course->school && $course_application->course->school->city ? (app()->getLocale() == 'en' ? $course_application->course->school->city->name : $course_application->course->school->city->name_ar) : '' }}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Admin/backend.country')}}</td>
                                    <td>{{ $course_application->course->school && $course_application->course->school->country ? (app()->getLocale() == 'en' ? $course_application->course->school->country->name : $course_application->course->school->country->name_ar) : '' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if (auth('superadmin')->check())
                            <table class="table table-bordered table-no-drawable">
                                <thead>
                                    <tr>
                                        <th>{{__('Admin/backend.course_details')}}</th>
                                        <th>{{__('Admin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                        <th>{{__('Admin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}, {{ $course->lessons_per_week }} {{__('Admin/backend.lessons')}} / {{ $course->hours_per_week }} {{__('Admin/backend.hours_per_week')}}<br />
                                            {{ $program_start_date }} {{__('Admin/backend.to')}} {{ $program_end_date }} ( {{ $course_application->program_duration }} {{__('Admin/backend.weeks')}} )
                                        </td>
                                        <td>{{ toFixedNumber($program_cost['value']) }}</td>
                                        <td>{{ toFixedNumber($program_cost['converted_value']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Admin/backend.registraion_fees')}}</td>
                                        <td>{{ toFixedNumber($program_registration_fee['value']) }}</td>
                                        <td>{{ toFixedNumber($program_registration_fee['converted_value']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{__('Admin/backend.text_book_fees')}}
                                        </td>
                                        <td>{{ toFixedNumber($program_text_book_fee['value']) }}</td>
                                        <td>{{ toFixedNumber($program_text_book_fee['converted_value']) }}</td>
                                    </tr>
                                    @if ($program_summer_fees['value'])
                                        <tr>
                                            <td>{{__('Admin/backend.summer_fees')}}</td>
                                            <td>{{ toFixedNumber($program_summer_fees['value']) }}</td>
                                            <td>{{ toFixedNumber($program_summer_fees['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($program_peak_time_fees['value'])
                                        <tr>
                                            <td>{{__('Admin/backend.peak_time_fees')}}</td>
                                            <td>{{ toFixedNumber($program_peak_time_fees['value']) }}</td>
                                            <td>{{ toFixedNumber($program_peak_time_fees['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($program_under_age_fees['value'])
                                        <tr>
                                            <td>{{__('Admin/backend.under_age_fees')}}</td>
                                            <td>{{ toFixedNumber($program_under_age_fees['value']) }}</td>
                                            <td>{{ toFixedNumber($program_under_age_fees['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($program_express_mail_fee['value'])
                                        <tr>
                                            <td>{{__('Admin/backend.express_mail_fee')}}</td>
                                            <td>{{ toFixedNumber($program_express_mail_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($program_express_mail_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    @if ($program_discount_fee['value'])
                                        <tr>
                                            <td>{{__('Admin/backend.discount')}}</td>
                                            <td class="highlight-value">-{{ toFixedNumber($program_discount_fee['value']) }}</td>
                                            <td class="highlight-value">-{{ toFixedNumber($program_discount_fee['converted_value']) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('Admin/backend.age_range')}}</td>
                                        <td colspan="2">{{ $min_age ?? ''}} - {{ $max_age ?? ''}} {{__('Admin/backend.years')}}</td>
                                    </tr>
                                </tbody>
                            </table>

                            @if ($accommodation)
                                <table class="table table-bordered table-no-drawable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Admin/backend.accommodation_details')}}</th>
                                            <th>{{__('Admin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                            <th>{{__('Admin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{app()->getLocale() == 'en' ? $accommodation->type : $accommodation->type_ar}} - {{app()->getLocale() == 'en' ? $accommodation->room_type : $accommodation->room_type_ar}} - {{app()->getLocale() == 'en' ? $accommodation->meal : $accommodation->meal_ar}}<br />
                                                {{$accommodation_start_date}} to {{$accommodation_end_date}} ( {{$course_application->accommodation_duration}} {{__('Admin/backend.weeks')}} )
                                            </td>
                                            <td>{{ toFixedNumber($accommodation_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_fee['converted_value']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Admin/backend.placement_fee')}}</td>
                                            <td>{{ toFixedNumber($accommodation_placement_fee['value']) }}</td>
                                            <td>{{ toFixedNumber($accommodation_placement_fee['converted_value']) }}</td>
                                        </tr>
                                        @if ($accommodation_special_diet_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.special_diet_fee')}}</td>
                                                <td>{{ toFixedNumber($accommodation_special_diet_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_special_diet_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($accommodation_deposit_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.deposit_fee')}}</td>
                                                <td>{{ toFixedNumber($accommodation_deposit_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_deposit_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($accommodation_summer_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.summer_fees')}}</td>
                                                <td>{{ toFixedNumber($accommodation_summer_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_summer_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($accommodation_peak_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.peak_time_fees')}}</td>
                                                <td>{{ toFixedNumber($accommodation_peak_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_peak_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($accommodation_christmas_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.christmas_fees')}}</td>
                                                <td>{{ toFixedNumber($accommodation_christmas_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_christmas_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($accommodation_under_age_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.under_age_fees')}}</td>
                                                <td>{{ toFixedNumber($accommodation_under_age_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($accommodation_under_age_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($accommodation_discount_fee['value'])
                                            <tr>
                                                <td>{{__('Admin/backend.discount')}}</td>
                                                <td class="highlight-value">-{{ toFixedNumber($accommodation_discount_fee['value']) }}</td>
                                                <td class="highlight-value">-{{ toFixedNumber($accommodation_discount_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>{{__('Admin/backend.age_range')}}</td>
                                            <td colspan="2">{{ $accommodation_min_age ?? ''}} - {{ $accommodation_max_age ?? ''}} {{__('Admin/backend.years')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                            
                            @if ($airport || $medical || $custodian)
                                <table class="table table-bordered table-no-drawable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Admin/backend.other_services')}}</th>
                                            <th>{{__('Admin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                            <th>{{__('Admin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($airport)
                                            <tr>
                                                <td>
                                                    {{__('Admin/backend.transport')}}<br />
                                                    {{__('Admin/backend.service_provider')}}: {{ $airport_provider }}<br />
                                                    {{ $airport_name }} - {{ $airport_service }}<br />
                                                </td>
                                                <td>{{ toFixedNumber($airport_pickup_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($airport_pickup_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($medical)
                                            <tr>
                                                <td>
                                                    {{__('Admin/backend.medical_insurance')}}<br />
                                                    {{__('Admin/backend.company_name')}}: {{ $company_name }}<br />
                                                    {{ $medical_start_date }} - {{ $medical_end_date }} ( {{ $course_application->medical_duration }} {{__('Admin/backend.weeks')}} )<br />
                                                </td>
                                                <td>{{ toFixedNumber($medical_insurance_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($medical_insurance_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                        @if ($custodian)
                                            <tr>
                                                <td>
                                                    {{__('Admin/backend.custodian_fee')}}<br />
                                                </td>
                                                <td>{{ toFixedNumber($custodian_fee['value']) }}</td>
                                                <td>{{ toFixedNumber($custodian_fee['converted_value']) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            @endif
                            
                            <table class="table table-bordered table-no-drawable mb-3">
                                <thead>
                                    <tr>
                                        <th>{{__('Admin/backend.sub_total')}}</th>
                                        <th>{{ toFixedNumber($sub_total['value']) }} {{ $currency['cost'] }}</th>
                                        <th>{{ toFixedNumber($sub_total['converted_value']) }} {{ $currency['converted'] }}</th>
                                    </tr>
                                    <tr>
                                        <td>{{__('Admin/backend.bank_charge_fee')}}</td>
                                        <td>{{ toFixedNumber($bank_charge_fee['value']) }} {{ $currency['cost'] }}</td>
                                        <td>{{ toFixedNumber($bank_charge_fee['converted_value']) }} {{ $currency['converted'] }}</td>
                                    </tr>
                                    @if ($link_fee['value'])
                                        <tr>
                                            <td>{{__('Admin/backend.link_fee_including_vat')}} <span class="vat_fee">{{ $vat_fee }}</span>%</td>
                                            <td>{{ toFixedNumber($link_fee['value']) }} {{ $currency['cost'] }}</td>
                                            <td>{{ toFixedNumber($link_fee['converted_value']) }} {{ $currency['converted'] }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>{{__('Admin/backend.total_discount')}}</th>
                                        <th class="highlight-value">-{{ toFixedNumber($total_discount['value']) }} {{ $currency['cost'] }}</th>
                                        <th class="highlight-value">-{{ toFixedNumber($total_discount['converted_value']) }} {{ $currency['converted'] }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{__('Admin/backend.total_cost')}}</th>
                                        <th>{{ toFixedNumber($total_cost['value']) }} {{ $currency['cost'] }}</th>
                                        <th>{{ toFixedNumber($total_cost['converted_value']) }} {{ $currency['converted'] }}</th>
                                    </tr>
                                    @if (!isset($course_register_details->financial_guarantee))
                                        <tr>
                                            <th>{{__('Admin/backend.total_amount_paid')}}</th>
                                            <th>{{ toFixedNumber($amount_paid['value']) }} {{ $currency['cost'] }}</th>
                                            <th>{{ toFixedNumber($amount_paid['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                    @endif
                                    @if ($coupon_discount['value'])
                                        <tr>
                                            <th>{{__('Admin/backend.discount')}}</th>
                                            <th class="highlight-value">-{{ toFixedNumber($coupon_discount['value']) }} {{ $currency['cost'] }}</th>
                                            <th class="highlight-value">-{{ toFixedNumber($coupon_discount['converted_value']) }} {{ $currency['converted'] }}</th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>{{__('Admin/backend.total_balance_due')}}</th>
                                        <th class="highlight-value">{{ toFixedNumber($amount_balance['value']) }} {{ $currency['cost'] }}</th>
                                        <th class="highlight-value">{{ toFixedNumber($amount_balance['converted_value']) }} {{ $currency['converted'] }}</th>
                                    </tr>
                                </thead>
                            </table>
                            
                            @if (can_edit_course_application())
                                <a href="{{ auth('superadmin')->check() ? route('superadmin.course_application.course.edit', ['id' => $course_application->id]) : route('schooladmin.course_application.course.edit', ['id' => $course_application->id]) }}" class="btn btn-primary px-5">{{__('Admin/backend.edit')}}</a>
                            @endif
                            <button type="button" class="btn btn-primary float-right px-5" onclick="printCourseApplication('reservation')">{{__('Admin/backend.print')}}</button>
                        @endif
                    </div>
                </div>

                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseRegistrationForm">
                    <a class="card-title">{{__('Admin/backend.regsitration_form')}}</a>
                </div>
                <div id="collapseRegistrationForm" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="registration-form course-details">
                        <h4 class="m-2">{{__('Admin/backend.personal_info')}}:</h4>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname" class="col-form-label">{{__('Admin/backend.first_name')}}</label>
                                        <p>{{ $course_application->fname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mname" class="col-form-label">{{__('Admin/backend.middle_name')}}</label>
                                        <p>{{ $course_application->mname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lname" class="col-form-label">{{__('Admin/backend.last_name')}}</label>
                                        <p>{{ $course_application->lname }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">{{__('Admin/backend.place_of_birth')}}</label>
                                        <p>{{ $course_application->place_of_birth }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender" class="col-form-label">{{__('Admin/backend.gender')}}</label>
                                        <p>{{ $course_application->gender }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dob" class="col-form-label">{{__('Admin/backend.date_of_birth')}}</label>
                                        <p>{{ $course_application->dob }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('Admin/backend.nationality')}}</label>
                                        <p>{{ $course_application->nationality }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('Admin/backend.id_iqama_number')}}</label>
                                        <p>{{ $course_application->id_number }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Passport" class="col-form-label">{{__('Admin/backend.passport_no')}}</label>
                                        <p>{{ $course_application->passport_number }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="portdate" class="col-form-label">{{__('Admin/backend.passport_date_of_issue')}}</label>
                                        <p>{{ $course_application->passport_date_of_issue }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edate" class="col-form-label">{{__('Admin/backend.passport_date_of_expiry')}}</label>
                                        <p>{{ $course_application->passport_date_of_expiry }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname" class="col-form-label">{{__('Admin/backend.upload_passport_copy')}}</label>
                                        @if ($course_application->passport_copy)
                                            <img src="{{ '/storage/app/public/' . $course_application->passport_copy }}" class="img-fluid" />
                                            <form method="post" action="{{route('frontend.download')}}">
                                                @csrf
                                                <input name="file" type="hidden" value="{{ $course_application->passport_copy }}" />
                                                <button class="btn btn-primary btn-sm">{{__('Admin/backend.download')}}</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('Admin/backend.your_level_of_language')}}</label>
                                        <p>
                                            @if ($course_application->level_of_language == 'beginner_a1')
                                                {{__('Admin/backend.beginner_a1')}}
                                            @elseif ($course_application->level_of_language == 'elementary_a2')
                                                {{__('Admin/backend.elementary_a2')}}
                                            @elseif ($course_application->level_of_language == 'intermediate_b1')
                                                {{__('Admin/backend.intermediate_b1')}}
                                            @elseif ($course_application->level_of_language == 'upper_intermediate_b2')
                                                {{__('Admin/backend.upper_intermediate_b2')}}
                                            @elseif ($course_application->level_of_language == 'advanced_c1')
                                                {{__('Admin/backend.advanced_c1')}}
                                            @elseif ($course_application->level_of_language == 'proficient_c2')
                                                {{__('Admin/backend.proficient_c2')}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">{{__('Admin/backend.study_finance')}}</label>
                                        <p>
                                            @if ($course_application->study_finance == 'personal')
                                                {{__('Admin/backend.personal')}}
                                            @elseif ($course_application->study_finance == 'scholarship')
                                                {{__('Admin/backend.scholarship')}}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4" id="financial_guarantee">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('Admin/backend.upload_financial_gurantee')}}</label>
                                        @if ($course_application->financial_guarantee)
                                            <img src="{{ '/storage/app/public/' . $course_application->financial_guarantee }}" class="img-fluid" />
                                            <form method="post" action="{{route('frontend.download')}}">
                                                @csrf
                                                <input name="file" type="hidden" value="{{ $course_application->financial_guarantee }}" />
                                                <button class="btn btn-primary btn-sm">{{__('Admin/backend.download')}}</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4" id="bank_statement">
                                    <div class="form-group">
                                        <label for="nat" class="col-form-label">{{__('Admin/backend.upload_bank_statement')}}</label>
                                        @if ($course_application->bank_statement)
                                            <img src="{{ '/storage/app/public/' . $course_application->bank_statement }}" class="img-fluid" />
                                            <form method="post" action="{{route('frontend.download')}}">
                                                @csrf
                                                <input name="file" type="hidden" value="{{ $course_application->bank_statement }}" />
                                                <button class="btn btn-primary btn-sm">{{__('Admin/backend.download')}}</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="best">{{__('Admin/backend.contact_details')}}:</h4>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile" class="col-form-label">{{__('Admin/backend.mobile')}}</label>
                                        <p>{{ $course_application->mobile }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tel" class="col-form-label">{{__('Admin/backend.tel')}}</label>
                                        <p>{{ $course_application->telephone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Email" class="col-form-label">{{__('Admin/backend.email')}}</label>
                                        <p>{{ $course_application->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="Address" class="col-form-label">{{__('Admin/backend.address')}}</label>
                                        <p>{{ $course_application->address }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Post" class="col-form-label">{{__('Admin/backend.post_code')}}</label>
                                        <p>{{ $course_application->post_code }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city_contact" class="col-form-label">{{__('Admin/backend.city')}}</label>
                                        <p>{{ $course_application->city_contact }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="province_region" class="col-form-label">{{__('Admin/backend.province_region')}}</label>
                                        <p>{{ $course_application->province_region }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country_contact" class="col-form-label">{{__('Admin/backend.country')}}</label>
                                        <p>{{ $course_application->country_contact }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="best">{{__('Admin/backend.emergency_contact_details')}}:</h4>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="full_name_emergency" class="col-form-label">{{__('Admin/backend.full_name')}}</label>
                                        <p>{{ $course_application->full_name_emergency }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="relative_emergency" class="col-form-label">{{__('Admin/backend.relative')}}</label>
                                        <p>{{ $course_application->relative_emergency }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_emergency" class="col-form-label">{{__('Admin/backend.mobile')}}</label>
                                        <p>{{ $course_application->mobile_emergency }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telephone_emergency" class="col-form-label">{{__('Admin/backend.tel')}}</label>
                                        <p>{{ $course_application->telephone_emergency }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email_emergency" class="col-form-label">{{__('Admin/backend.email')}}</label>
                                        <p>{{ $course_application->email_emergency }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="best">{{__('Admin/backend.how_you_heard_about_link_for_study_abroad')}}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <p>{{ implode($course_application->heard_where, ", ") }}</p>
                                <p>{{ $course_application->other }}</p>
                            </div>
                        </div>

                        <h4 class="best">{{__('Admin/backend.comment')}}</h4>
                        <div class="study m-2">
                            <p>{{ $course_application->comments }}</p>
                        </div>
                        
                        @if (can_edit_course_application())
                            <a href="{{ auth('superadmin')->check() ? route('superadmin.course_application.register.edit', ['id' => $course_application->id]) : route('schooladmin.course_application.register.edit', ['id' => $course_application->id]) }}" class="btn btn-primary px-5">{{__('Admin/backend.edit')}}</a>
                        @endif
                        <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('registration')">{{__('Admin/backend.print')}}</button>
                    </div>
                </div>
                
                @if (auth('superadmin')->check())
                    <div class="card-header collapsed" data-toggle="collapse" href="#collapseRegistrationCancellationConditions">
                        <a class="card-title">{{__('Admin/backend.registration_cancelation_conditions')}}</a>
                    </div>
                    <div id="collapseRegistrationCancellationConditions" class="card-body collapse p-0" data-parent="#accordion">
                        <div class="study m-2">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="" />
                                </div>
                                <div class="col-md-9">
                                    <h2>{{__('Admin/backend.registration_cancelation_conditions')}}</h2>
                                </div>
                            </div>
                            <div class="row border-top-bottom form-group">
                                <div class="col-md-12">
                                    {!! app()->getLocale() == 'en' ? $course_application->registration_cancelation_conditions : $course_application->registration_cancelation_conditions_ar !!}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="student_guardian_full_name" class="col-form-label"><strong>{{__('Admin/backend.student_guardian_full_name')}}</strong>:</label>
                                    <p>{{ $course_application->guardian_full_name }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <label class="col-form-label"><strong>{{__('Admin/backend.date')}}:</strong></label>
                                </div>
                                <div class="col-md-10">
                                    <label class="col-form-label">{{ $today }}</label>
                                </div>
                            </div>
                            <div class="row form-group mb-3">
                                <div class="col-md-2">
                                    <label class="col-form-label"><strong>{{__('Admin/backend.signature')}}:</strong></label>
                                </div>
                                <div class="col-md-10">
                                    <img src="{{ $course_application->signature }}" />
                                </div>
                            </div>
                        </div>
                            
                        <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('registration_cancellation')">{{__('Admin/backend.print')}}</button>
                    </div>
                @endif

                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseReservationStatus">
                    <a class="card-title">{{__('Admin/backend.reservation_status')}}</a>
                </div>
                <div id="collapseReservationStatus" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="reservation-status my-3">
                        @if (can_manage_course_application() || can_edit_course_application() || can_chanage_status_course_application())
                            <div class="col-sm-12">
                                <form method="POST" id="update_reservation" action="{{ auth('superadmin')->check() ? route('superadmin.course_application.store') : route('schooladmin.course_application.store') }}">
                                    <div class="form-group row">
                                        {{csrf_field()}}

                                        <label for="reservation_status" class="col-sm-2 col-form-label">{{__('Admin/backend.reservation_status')}}</label>
                                        <input hidden name="id" value="{{ $course_application->id }}">
                                        <input hidden name="type_of_submit" value="update_reservation">
                                        <input hidden name="order_id" value="{{ $course_application->order_id }}">
                                        <div class="col-sm-8">
                                            <select class="form-control" name="status" id="reservation_status">
                                                <option value='received' {{$course_application->status == 'received' ? 'selected' : ''}}>{{__('Admin/backend.request_received')}}</option>
                                                <option value='process' {{$course_application->status == 'process' ? 'selected' : ''}}>{{__('Admin/backend.under_process')}}</option>
                                                <option value='files_sent_to_customer' {{$course_application->status == 'files_sent_to_customer' ? 'selected' : ''}}>{{__('Admin/backend.application_files_sent_to_customer')}}</option>
                                                <option value='customer_response' {{$course_application->status == 'customer_response' ? 'selected' : ''}}>{{__('Admin/backend.waiting_for_customer_response')}}</option>
                                                <option value='cancelled' {{$course_application->status == 'cancelled' ? 'selected' : ''}}>{{__('Admin/backend.request_cancelled')}}</option>
                                                <option value='completed' {{$course_application->status == 'completed' ? 'selected' : ''}}>{{__('Admin/backend.application_procedure_completed')}}</option>
                                                <option value='studying' {{$course_application->status == 'studying' ? 'selected' : ''}}>{{__('Admin/backend.studying')}}</option>
                                                <option value='course_extension' {{$course_application->status == 'course_extension' ? 'selected' : ''}}>{{__('Admin/backend.customer_request_course_extension')}}</option>
                                                <option value='request_cancellation' {{$course_application->status == 'request_cancellation' ? 'selected' : ''}}>{{__('Admin/backend.customer_request_cancellation')}}</option>
                                                <option value='refunded' {{$course_application->status == 'refunded' ? 'selected' : ''}}>{{__('Admin/backend.amount_refunded')}}</option>
                                                <option value='application_cancelled' {{$course_application->status == 'cancelled' ? 'selected' : ''}}>{{__('Admin/backend.application_cancelled')}}</option>
                                                <option value='end' {{$course_application->status == 'end' ? 'selected' : ''}}>{{__('Admin/backend.course_end')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button onclick="submitFormAction('update_reservation')" type="button" class="btn btn-primary mt-1 choose">{{__('Admin/backend.update')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="col-sm-12">
                            <table class="table table-bordered table-no-drawable">
                                <tbody>
                                    <tr>
                                        <th>{{__('Admin/backend.status')}}</th>
                                        <th>{{__('Admin/backend.date')}}</th>
                                    </tr>
                                    @foreach($course_application->courseApplicationStatusus as $status)
                                        <tr>
                                            <td>
                                                @if ($status->status == 'received')
                                                    {{__('Admin/backend.request_received')}}
                                                @elseif ($status->status == 'process')
                                                    {{__('Admin/backend.under_process')}}
                                                @elseif ($status->status == 'files_sent_to_customer')
                                                    {{__('Admin/backend.application_files_sent_to_customer')}}
                                                @elseif ($status->status == 'customer_response')
                                                    {{__('Admin/backend.waiting_for_customer_response')}}
                                                @elseif ($status->status == 'cancelled')
                                                    {{__('Admin/backend.request_cancelled')}}
                                                @elseif ($status->status == 'completed')
                                                    {{__('Admin/backend.application_procedure_completed')}}
                                                @elseif ($status->status == 'studying')
                                                    {{__('Admin/backend.studying')}}
                                                @elseif ($status->status == 'course_extension')
                                                    {{__('Admin/backend.customer_request_course_extension')}}
                                                @elseif ($status->status == 'request_cancellation')
                                                    {{__('Admin/backend.customer_request_cancellation')}}
                                                @elseif ($status->status == 'refunded')
                                                    {{__('Admin/backend.amount_refunded')}}
                                                @elseif ($status->status == 'application_cancelled')
                                                    {{__('Admin/backend.application_cancelled')}}
                                                @elseif ($status->status == 'end')
                                                    {{__('Admin/backend.course_end')}}
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
                
                @if (auth('superadmin')->check())
                    <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePaymentsRefundsStatement">
                        <a class="card-title">{{__('Admin/backend.payments_refunds_statement')}}</a>
                    </div>
                    <div id="collapsePaymentsRefundsStatement" class="card-body collapse p-0" data-parent="#accordion">
                        <div class="payments-refunds-statement mt-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-no-drawable">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('Admin/backend.date_of_payment')}}</th>
                                            <th>{{__('Admin/backend.amount_refunded')}}</th>
                                            <th>{{__('Admin/backend.amount_paid')}}</th>
                                            <th>{{__('Admin/backend.details')}}</th>
                                            <th>{{__('Admin/backend.transaction_reference')}}</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $course_application->created_at->format("d M Y") }}</td>
                                            <td> -</td>
                                            <td>{{ toFixedNumber($deposit_price['converted_value']) }}</td>
                                            <td>{{ __('Admin/backend.deposit_for_course') }} {{ $course_application->course->program_name }}</td>
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
                                                <td colspan="6" style="text-align:center">{{__('Admin/backend.details_not_available')}}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if (can_manage_course_application() || can_edit_course_application() || can_payment_refund_course_application())
                                <div class="col-sm-12 my-3">
                                    <form id="update_payment" method="POST" action="{{ auth('superadmin')->check() ? route('superadmin.course_application.store') : route('schooladmin.course_application.store') }}">
                                        {{csrf_field()}}

                                        <div class="form-row">
                                            <input hidden name="id" value="{{ $course_application->id }}">
                                            <div class="form-group col-md-6">
                                                <div class="form-group row">
                                                    <label for="inputamount" class="col-sm-4 col-form-label">{{__('Admin/backend.amount')}}</label>
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
                                            <input hidden name="order_id" value="{{ $course_application->order_id }}">
                                            <div class="form-group col-md-6 mb-0">
                                                <div class="form-group row mb-0">
                                                    <label for="course_details" class="col-sm-4 col-form-label">{{__('Admin/backend.details')}}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="course_details" value="" class="form-control" id="course_details" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-0">
                                                <div class="form-group row mb-0">
                                                    <label for="reference" class="col-sm-4 col-form-label">{{__('Admin/backend.transaction_reference')}}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="reference" value="" class="form-control" id="reference" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" onclick="submitFormAction('update_payment')" class="btn btn-primary float-right mt-1 choose">{{__('Admin/backend.update')}}</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="col-sm-12">
                                <table class="table table-bordered table-no-drawable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Admin/backend.currency')}}</th>
                                            <th>{{__('Admin/backend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                                            <th>{{__('Admin/backend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{__('Admin/backend.total_cost')}}</td>
                                            <td>{{ toFixedNumber($total_cost_fixed['value']) }}</td>
                                            <td>{{ toFixedNumber($total_cost_fixed['converted_value']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Admin/backend.total_amount_paid')}}</td>
                                            <td>{{ toFixedNumber($amount_paid['value']) }}</td>
                                            <td>{{ toFixedNumber($amount_paid['converted_value']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Admin/backend.total_amount_refunded')}}</td>
                                            <td>{{ toFixedNumber($amount_refunded['value']) }}</td>
                                            <td>{{ toFixedNumber($amount_refunded['converted_value']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Admin/backend.total_amount_due')}}</td>
                                            <td>{{ toFixedNumber($amount_due['value']) }}</td>
                                            <td>{{ toFixedNumber($amount_due['converted_value']) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <button type="button" class="btn btn-primary float-right mt-3 px-5" onclick="printCourseApplication('payments_refunds')">{{__('Admin/backend.print')}}</button>
                        </div>
                    </div>
                @endif
                
                <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseContactCenter">
                    <a class="card-title">{{__('Admin/backend.contact_center')}}</a>
                </div>
                <div id="collapseContactCenter" class="card-body collapse p-0" data-parent="#accordion">
                    <div class="contact-center row mt-3 p-3">
                        <div class="col-lg-6">
                            @if (can_manage_course_application() || can_edit_course_application() || can_contact_student_course_application())
                                <form id="contact_center_customer" method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course_application.store') : route('schooladmin.course_application.store') }}">                                
                                    @csrf
                                    
                                    <input hidden name="type_of_submit" value="send_message_to_student">

                                    <h5 class="text-center">{{__('Admin/backend.contact_center_customer')}}</h5>                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="subject" class="col-form-label">{{__('Admin/backend.subject')}}</label>
                                                <input class="form-control" name="subject">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="attachments" class="col-form-label">{{__('Admin/backend.add_attachments')}}</label>
                                                <input name="attachment[]" class="form-control" type="file" multiple class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="message" class="col-form-label">{{__('Admin/backend.message')}}</label>
                                                <textarea name="message" class="form-control ckeditor-input" rows="3" id="customerMessageText"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <input hidden name="type" value="to_student" />
                                    <input hidden name="type_id" value="{{ $course_application->id }}" />

                                    <button type="button" onclick="submitFormAction('contact_center_customer');" class="btn btn-primary px-3">{{__('Admin/backend.send')}}</button>
                                </form>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach ($student_messages as $student_message)
                                        <div class="message-item <?php echo ($student_message->type == 'to_student') ? 'send' : 'receive' ?>">
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
                                                        <i class="mdi mdi-arrow-right-bold"></i>
                                                    @else
                                                        <i class="mdi mdi-arrow-left-bold"></i>
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
                                                                    <i class="mdi mdi-file-document"></i>
                                                                @elseif ($attachment_ext == 'pdf')
                                                                    <i class="mdi mdi-file-pdf"></i>
                                                                @elseif ($attachment_ext == 'jpg' || $attachment_ext == 'bmp' || $attachment_ext == 'png')
                                                                    <i class="mdi mdi-file-image"></i>
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
                        <div class="col-lg-6">
                            @if (!empty($user_school))
                                @if (can_manage_course_application() || can_edit_course_application() || can_contact_school_course_application())
                                    <form id="contact_center_school" method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course_application.store') : route('schooladmin.course_application.store') }}">
                                        @csrf

                                        <input hidden name="type_of_submit" value="send_message_to_school">

                                        <h5 class="text-center">{{__('Admin/backend.contact_center_school')}}</h5>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subject" class="col-form-label">{{__('Admin/backend.subject')}}</label>
                                                    <input class="form-control" name="subject">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="attachments" class="col-form-label">{{__('Admin/backend.add_attachments')}}</label>
                                                    <input name="attachment[]" class="form-control" type="file" multiple class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="message" class="col-form-label">{{__('Admin/backend.message')}}</label>
                                                    <textarea name="message" class="form-control ckeditor-input" rows="3" id="schoolMessageText"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <input hidden name="type" value="to_school_admin" />
                                        <input hidden name="type_id" value="{{ $course_application->id }}" />

                                        <button type="button" onclick="submitFormAction('contact_center_school');" class="btn btn-primary px-3">{{__('Admin/backend.send')}}</button>
                                    </form>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($school_messages as $school_message)
                                            <div class="message-item <?php echo ($school_message->type == 'to_school_admin') ? 'send' : 'receive' ?>">
                                                <div class="message-header">
                                                    <div class="message-user-image">
                                                        @if ($school_message->fromUser->image)
                                                            <img src="{{ $school_message->fromUser->image }}" alt="profile">
                                                        @else
                                                            <img src="{{ asset('assets/images/user.png') }}" alt="profile">
                                                        @endif
                                                    </div>
                                                    <div class="message-user-name">
                                                        @if (app()->getLocale() == 'en')
                                                            {{ $school_message->fromUser->first_name_en }} {{ $school_message->fromUser->last_name_en }}
                                                        @else
                                                            {{ $school_message->fromUser->first_name_ar }} {{ $school_message->fromUser->last_name_ar }}
                                                        @endif
                                                        @if ($school_message->type == 'to_school_admin')
                                                            <i class="mdi mdi-arrow-right-bold"></i>
                                                        @else
                                                            <i class="mdi mdi-arrow-left-bold"></i>
                                                        @endif
                                                    </div>
                                                    <div class="message-time">
                                                        {{ $school_message->created_at->format('d M Y') }}
                                                    </div>
                                                </div>
                                                <div class="message-body">
                                                    <div>
                                                        <strong>{{__('Admin/backend.subject')}}: </strong>{{ $school_message->subject }}
                                                    </div>
                                                    <div>
                                                        <strong>{{__('Admin/backend.message')}}: </strong>{!! $school_message->message !!}
                                                    </div>
                                                    <div>
                                                        <strong>{{__('Admin/backend.attachments')}}: </strong>
                                                        @if ($school_message->attachments)
                                                            @foreach ($school_message->attachments as $message_attachment)
                                                                @php $attachment_ext = strtolower(pathinfo($message_attachment, PATHINFO_EXTENSION)); @endphp
                                                                <a href="{{ $message_attachment }}" target="_blank">
                                                                    @if ($attachment_ext == 'doc' || $attachment_ext == 'docx')
                                                                        <i class="mdi mdi-file-document"></i>
                                                                    @elseif ($attachment_ext == 'pdf')
                                                                        <i class="mdi mdi-file-pdf"></i>
                                                                    @elseif ($attachment_ext == 'jpg' || $attachment_ext == 'bmp' || $attachment_ext == 'png')
                                                                        <i class="mdi mdi-file-image"></i>
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
                            @else
                                {{__('Admin/backend.no_school_admin_found')}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            function printCourseApplication(section) {
                $.ajax({
                    url: "{{ auth('superadmin')->check() ? route('superadmin.course_application.print') : route('schooladmin.course_application.print') }}",
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
                            link.download = "{{__('Admin/backend.reservation_details')}} {{ $course_application->id }}.pdf";
                        } else if (section == 'registration') {
                            link.download = "{{__('Admin/backend.regsitration_form')}} {{ $course_application->id }}.pdf";
                        } else if (section == 'registration_cancellation') {
                            link.download = "{{__('Admin/backend.registration_cancelation_conditions')}} {{ $course_application->id }}.pdf";
                        } else if (section == 'payments_refunds') {
                            link.download = "{{__('Admin/backend.payments_refunds_statement')}} {{ $course_application->id }}.pdf";
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