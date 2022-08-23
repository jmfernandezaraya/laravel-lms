@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.reservation_details')}}
@endsection

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@section('breadcrumbs')
    <h1>{{__('Frontend.reservation_details')}}</h1>
    <p>{{__('Frontend.reservation_details_description')}}</p>
@endsection

@section('content')
    <!-- Reservation -->
    <div class="container">
        <div class="course-details mt-5">
            
            @include('common.include.alert')
            
            <form id="course_reversation" enctype="multipart/form-data" action="{{route('frontend.course.reservation')}}" method="POST">
                {{csrf_field()}}

                <table class="table table-bordered">
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

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{__('Frontend.course_details')}}</th>
                            <th>{{__('Frontend.amount')}} / <span class="cost_currency">{{ $currency['cost'] }}</span></th>
                            <th>{{__('Frontend.amount')}} / <span class="converted_currency">{{ $currency['converted'] }}</span></th>
                            <input type="hidden" value="{{$currency['converted']}}" name="other_currency" />
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>{{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}, {{ $course->lessons_per_week }} {{__('Frontend.lessons')}} / {{ $course->hours_per_week }} {{__('Frontend.hours_per_week')}}</p>
                                <p>{{ $program_start_date }} {{__('Frontend.to')}} {{ $program_end_date }} ( {{ $course_details->program_duration }} {{__('Frontend.weeks')}} )</p>
                            </td>
                            <td>{{ toFixedNumber($program_cost['value']) }}</td>
                            <td>{{ toFixedNumber($program_cost['converted_value']) }}</td>
                            <input type="hidden" value="{{$program_cost['value']}}" name="program_cost" />
                        </tr>
                        <tr>
                            <td>{{__('Frontend.registraion_fees')}}</td>
                            <td>{{ toFixedNumber($program_registration_fee['value']) }}</td>
                            <td>{{ toFixedNumber($program_registration_fee['converted_value']) }}</td>
                            <input type="hidden" value="{{$program_registration_fee['value']}}" name="registration_fee" />
                        </tr>
                        <tr>
                            <td>
                                {{__('Frontend.text_book_fees')}}
                            </td>
                            <td>{{ toFixedNumber($program_text_book_fee['value']) }}</td>
                            <td>{{ toFixedNumber($program_text_book_fee['converted_value']) }}</td>
                            <input type="hidden" value="{{$program_text_book_fee['value']}}" name="text_book_fee" />
                        </tr>
                        @if ($program_summer_fees['value'])
                            <tr>
                                <td>{{__('Frontend.summer_fees')}}</td>
                                <td>{{ toFixedNumber($program_summer_fees['value']) }}</td>
                                <td>{{ toFixedNumber($program_summer_fees['converted_value']) }}</td>
                                <input type="hidden" value="{{$program_summer_fees['value']}}" name="summer_fees" />
                            </tr>
                        @endif
                        @if ($program_peak_time_fees['value'])
                            <tr>
                                <td>{{__('Frontend.peak_time_fees')}}</td>
                                <td>{{ toFixedNumber($program_peak_time_fees['value']) }}</td>
                                <td>{{ toFixedNumber($program_peak_time_fees['converted_value']) }}</td>
                                <input type="hidden" value="{{$program_peak_time_fees['value']}}" name="peak_time_fees" />
                            </tr>
                        @endif
                        @if ($program_under_age_fees['value'])
                            <tr>
                                <td>{{__('Frontend.under_age_fees')}}</td>
                                <td>{{ toFixedNumber($program_under_age_fees['value']) }}</td>
                                <td>{{ toFixedNumber($program_under_age_fees['converted_value']) }}</td>
                                <input type="hidden" value="{{$program_under_age_fees['value']}}" name="under_age_fees" />
                            </tr>
                        @endif
                        @if ($program_express_mail_fee['value'])
                            <tr>
                                <td>{{__('Frontend.express_mail_fee')}}</td>
                                <td>{{ toFixedNumber($program_express_mail_fee['value']) }}</td>
                                <td>{{ toFixedNumber($program_express_mail_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$program_express_mail_fee['value']}}" name="courier_fee" />
                            </tr>
                        @endif
                        @if ($program_discount_fee['value'])
                            <tr>
                                <td>{{__('Frontend.discount')}}</td>
                                <td class="highlight-value">-{{ toFixedNumber($program_discount_fee['value']) }}</td>
                                <td class="highlight-value">-{{ toFixedNumber($program_discount_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$program_discount_fee['value']}}" name="discount_fee" />
                            </tr>
                        @endif
                        <tr>
                            <td>{{__('Frontend.age_range')}}</td>
                            <td colspan="2">{{ $course_register_details->min_age ?? ''}} - {{ $course_register_details->max_age ?? ''}} {{__('Frontend.years')}}</td>
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
                                    <p>{{app()->getLocale() == 'en' ? $accommodation->type : $accommodation->type_ar}} - {{app()->getLocale() == 'en' ? $accommodation->room_type : $accommodation->room_type_ar}} - {{app()->getLocale() == 'en' ? $accommodation->meal : $accommodation->meal_ar}}</p>
                                    <p>{{$accommodation_start_date}} to {{$accommodation_end_date}} ( {{$course_details->accommodation_duration}} {{__('Frontend.weeks')}} )</p>
                                </td>
                                <input type="hidden" value="{{$accommodation_start_date}}" name="accommodation_start_date" />
                                <input type="hidden" value="{{$accommodation_end_date}}" name="accommodation_end_date" />
                                <td>{{ toFixedNumber($accommodation_fee['value']) }}</td>
                                <td>{{ toFixedNumber($accommodation_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_fee['value']}}" name="accommodation_fee" />
                            </tr>
                            <tr>
                                <td>{{__('Frontend.placement_fee')}}</td>
                                <td>{{ toFixedNumber($accommodation_placement_fee['value']) }}</td>
                                <td>{{ toFixedNumber($accommodation_placement_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_placement_fee['value']}}" name="accommodation_placement_fee" />
                            </tr>
                            @if ($accommodation_special_diet_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.special_diet_fee')}}</td>
                                    <td>{{ toFixedNumber($accommodation_special_diet_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($accommodation_special_diet_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_special_diet_fee['value']}}" name="accommodation_special_diet_fee" />
                                </tr>
                            @endif
                            @if ($accommodation_deposit_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.deposit_fee')}}</td>
                                    <td>{{ toFixedNumber($accommodation_deposit_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($accommodation_deposit_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_deposit_fee['value']}}" name="accommodation_deposit_fee" />
                                </tr>
                            @endif
                            @if ($accommodation_summer_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.summer_fees')}}</td>
                                    <td>{{ toFixedNumber($accommodation_summer_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($accommodation_summer_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_summer_fee['value']}}" name="accommodation_summer_fee" />
                                </tr>
                            @endif
                            @if ($accommodation_peak_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.peak_time_fees')}}</td>
                                    <td>{{ toFixedNumber($accommodation_peak_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($accommodation_peak_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_peak_fee['value']}}" name="accommodation_peak_fee" />
                                </tr>
                            @endif
                            @if ($accommodation_christmas_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.christmas_fees')}}</td>
                                    <td>{{ toFixedNumber($accommodation_christmas_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($accommodation_christmas_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_christmas_fee['value']}}" name="accommodation_christmas_fee" />
                                </tr>
                            @endif
                            @if ($accommodation_under_age_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.under_age_fees')}}</td>
                                    <td>{{ toFixedNumber($accommodation_under_age_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($accommodation_under_age_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_under_age_fee['value']}}" name="accommodation_under_age_fee" />
                                </tr>
                            @endif
                            @if ($accommodation_discount_fee['value'])
                                <tr>
                                    <td>{{__('Frontend.discount')}}</td>
                                    <td class="highlight-value">-{{ toFixedNumber($accommodation_discount_fee['value']) }}</td>
                                    <td class="highlight-value">-{{ toFixedNumber($accommodation_discount_fee['converted_value']) }}</td>
                                <input type="hidden" value="{{$accommodation_discount_fee['value']}}" name="accommodation_discount_fee" />
                                </tr>
                            @endif
                            <tr>
                                <td>{{__('Frontend.age_range')}}</td>
                                <td colspan="2">{{ $course_register_details->accommodation_min_age ?? ''}} - {{ $course_register_details->accommodation_max_age ?? ''}} {{__('Frontend.years')}}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
                
                @if ($airport || $medical || $custodian)
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
                                        <p>{{__('Frontend.transport')}}</p>
                                        <p>{{__('Frontend.service_provider')}}: {{ $course_details->airport_provider }}</p>
                                        <p>{{ $course_details->airport_name }} - {{ $course_details->airport_service }}</p>
                                    </td>
                                    <td>{{ toFixedNumber($airport_pickup_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($airport_pickup_fee['converted_value']) }}</td>
                                    <input type="hidden" value="{{$airport_pickup_fee['value']}}" name="airport_pickup_fee" />
                                </tr>
                            @endif
                            @if ($medical)
                                <tr>
                                    <td>
                                        <p>{{__('Frontend.medical_insurance')}}</p>
                                        <p>{{__('Frontend.company_name')}}: {{ $course_details->company_name }}</p>
                                        <p>{{ $medical_start_date }} - {{ $medical_end_date }} ( {{ $course_details->duration }} {{__('Frontend.weeks')}} )</p>
                                    </td>
                                    <input type="hidden" value="{{$medical_start_date}}" name="medical_start_date" />
                                    <input type="hidden" value="{{$medical_end_date}}" name="medical_end_date" />
                                    <td>{{ toFixedNumber($medical_insurance_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($medical_insurance_fee['converted_value']) }}</td>
                                    <input type="hidden" value="{{$medical_insurance_fee['value']}}" name="medical_insurance_fee" />
                                </tr>
                            @endif
                            @if ($custodian)
                                <tr>
                                    <td>
                                        <p>{{__('Frontend.custodian')}}</p>
                                        <p>{{__('Frontend.age_range')}}: {{ $course_register_details->custodian_min_age ?? ''}} - {{ $course_register_details->custodian_max_age ?? ''}} {{__('Frontend.years')}}</p>
                                    </td>
                                    <td>{{ toFixedNumber($custodian_fee['value']) }}</td>
                                    <td>{{ toFixedNumber($custodian_fee['converted_value']) }}</td>
                                    <input type="hidden" value="{{$custodian_fee['value']}}" name="custodian_fee" />
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
                            <input type="hidden" value="{{$sub_total['value']}}" name="sub_total" />
                        </tr>
                        <tr>
                            <td>{{__('Frontend.bank_transfer_fee')}}</td>
                            <td>{{ toFixedNumber($bank_transfer_fee['value']) }} {{ $currency['cost'] }}</td>
                            <td>{{ toFixedNumber($bank_transfer_fee['converted_value']) }} {{ $currency['converted'] }}</td>
                            <input type="hidden" value="{{$bank_transfer_fee['value']}}" name="bank_transfer_fee" />
                        </tr>
                        @if ($link_fee['value'])
                            <tr>
                                <td>{{__('Frontend.link_study_abroad_fee')}}</td>
                                <td>{{ toFixedNumber($link_fee['value']) }} {{ $currency['cost'] }}</td>
                                <td>{{ toFixedNumber($link_fee['converted_value']) }} {{ $currency['converted'] }}</td>
                                <input type="hidden" value="{{$link_fee['value']}}" name="link_fee" />
                                <input type="hidden" value="{{$link_fee['converted_value']}}" name="link_fee_converted" />
                            </tr>
                        @endif
                        <tr>
                            <th>{{__('Frontend.total_discount')}}</th>
                            <th class="highlight-value">-{{ toFixedNumber($total_discount['value']) }} {{ $currency['cost'] }}</th>
                            <th class="highlight-value">-{{ toFixedNumber($total_discount['converted_value']) }} {{ $currency['converted'] }}</th>
                            <input type="hidden" value="{{$total_discount['value']}}" name="total_discount" />
                        </tr>
                        <tr>
                            <th>{{__('Frontend.total_cost')}}</th>
                            <th>{{ toFixedNumber($total_cost['value']) }} {{ $currency['cost'] }}</th>
                            <th>{{ toFixedNumber($total_cost['converted_value']) }} {{ $currency['converted'] }}</th>
                            <input type="hidden" value="{{$total_cost['value']}}" name="total_cost" />
                        </tr>
                        @if (!isset($course_register_details->financial_guarantee))
                            <tr>
                                <th>{{__('Frontend.amount_to_pay_now_deposit')}}</th>
                                <th>{{ toFixedNumber($deposit_price['value']) }} {{ $currency['cost'] }}</th>
                                <th>{{ toFixedNumber($deposit_price['converted_value']) }} {{ $currency['converted'] }}</th>
                                <input type="hidden" value="{{$deposit_price['value']}}" name="deposit_price" />
                            </tr>
                        @endif
                        <tr>
                            <th>{{__('Frontend.total_balance_due')}}</th>
                            <th class="highlight-value">{{ toFixedNumber($total_balance['value']) }} {{ $currency['cost'] }}</th>
                            <th class="highlight-value">{{ toFixedNumber($total_balance['converted_value']) }} {{ $currency['converted'] }}</th>
                            <input type="hidden" value="{{$total_balance['value']}}" name="total_balance" />
                        </tr>
                    </thead>
                </table>
                
                <div class="row">
                    <div class="col-md-12 highlight-value">
                        <p>{{__('Frontend.please_note')}}:</p>
                        <p>*{{__('Frontend.balance_final_payment')}}</p>
                        <p>*{{__('Frontend.tuition_fees_need_to_be_paid')}}</p>
                        <p>*{{__('Frontend.tuition_fees_are_refundable')}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary px-5 py-3" onclick="backRegister($(this))">{{__('Frontend.back')}}</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary px-5 py-3 pull-right" onclick="doReservation($(this))">{{__('Frontend.next')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function backRegister(object) {
            window.location.href='{{ route("frontend.course.register.detail") }}';
        }
        function doReservation(object) {
            var formData = new FormData($(object).parents().find('#course_reversation')[0]);
            var urlName = ($(object).parents().find('#course_reversation').attr('action'));
            $("#loader").show();

            $.ajax({
                type: 'POST',
                url: urlName,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#loader").hide();
                    console.log(data);
                    if (data.success == true) {
                        document.documentElement.scrollTop = 0;

                        window.location.href='{{ route("frontend.course.reservation_confirm.detail") }}';
                    }
                }
            });
        }
    </script>
@endsection