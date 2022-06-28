<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{__('Frontend.reservation_details')}}</title>

    @if (app()->getLocale() != 'en')
        <style> 
            * { font-family: 'DejaVu Sans', sans-serif; }
        </style>
    @endif
    <style>
        .title {
            text-align: center;
            text-decoration: underline;
        }
        .logo {
            max-width: 150px;
        }
        hr {
            background-color: #97d0db;
            border: none;
            width: 100%;
            height: 5px;
        }
        .inter-full {
            width: 100%;
            border: 1px solid #ccc;
            padding: 15px 15px;
        }
        .study {
            box-shadow: 0px 0px 2px 1px #ccc;
            margin: 0.5rem!important;
        }
        table, .table {
            width: 100%;
            table-layout: fixed;
            overflow-wrap: break-word;
        }
        table.table-bold, .table.table-bold {
            font-weight: bold;
        }
        .table.table-bordered {
            border: 1px solid #ccc;
            box-shadow: 0px -1px 4px 1px #ece7e7;
        }
        .table th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }
        .table td, .table th {
            padding: 0.25rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead {
            background-color: #97d0db;
            color: white;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .highlight-value {
            color: #ff3333;
        }
    </style>
</head>

<body>
    <img src="{{$logo}}" class="logo"/>

    <h2 class="title">{{__('Mail.reservation_qutation')}}</h3>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>{{__('Frontend.name')}}</td>
                <td>{{ $school->name ? (app()->getLocale() == 'en' ? ($school->name->name ?? '-') : ($school->name->name_ar ?? '-')) : '-' }} {{ app()->getLocale() == 'en' ? ($school->branch_name ?? '-') : ($school->branch_name_ar ?? '-') }}</td>
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $course->program_name }}, {{ $course->lessons_per_week }} {{__('Frontend.lessons')}} / {{ $course->hours_per_week }} {{__('Frontend.hours_per_week')}}<br />
                    {{ $program_start_date }} {{__('Frontend.to')}} {{ $program_end_date }} ( {{ $course_application->program_duration }} {{__('Frontend.weeks')}} )
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
                        {{$accommodation_start_date}} to {{$accommodation_end_date}} ( {{$course_application->accommodation_duration}} {{__('Frontend.weeks')}} )
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
                            {{__('Frontend.service_provider')}}: {{ $airport_provider }}<br />
                            {{ $airport_name }} - {{ $airport_service }}<br />
                        </td>
                        <td>{{ toFixedNumber($airport_pickup_fee['value']) }}</td>
                        <td>{{ toFixedNumber($airport_pickup_fee['converted_value']) }}</td>
                    </tr>
                @endif
                @if ($medical)
                    <tr>
                        <td>
                            {{__('Frontend.medical_insurance')}}<br />
                            {{__('Frontend.company_name')}}: {{ $company_name }}<br />
                            {{ $medical_start_date }} - {{ $medical_end_date }} ( {{ $course_application->medical_duration }} {{__('Frontend.weeks')}} )<br />
                        </td>
                        <td>{{ toFixedNumber($medical_insurance_fee['value']) }}</td>
                        <td>{{ toFixedNumber($medical_insurance_fee['converted_value']) }}</td>
                    </tr>
                @endif
                @if ($custodian)
                    <tr>
                        <td>
                            {{__('Frontend.custodian_fee')}}<br />
                            {{__('Frontend.age_range')}}: {{ $custodian_min_age ?? ''}} - {{ $custodian_max_age ?? ''}} {{__('Frontend.years')}}<br />
                        </td>
                        <td>{{ toFixedNumber($custodian_fee['value']) }}</td>
                        <td>{{ toFixedNumber($custodian_fee['converted_value']) }}</td>
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
                    <th>{{__('Frontend.total_amount_paid')}}</th>
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
</body>
</html>