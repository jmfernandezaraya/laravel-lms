<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{__('Frontend.payments_refunds_statement')}}</title>

    @if (app()->getLocale() != 'en')
        <style> 
            * { font-family: 'DejaVu Sans', sans-serif; }
        </style>
    @endif
    <style>
        .mt-3, .my-3 {
            margin-top: 1rem!important;
        }
        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto,
        .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto,
        .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto,
        .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto,
        .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        @media (min-width: 768px) {
            .col-sm-12 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
            table-layout: fixed;
            overflow-wrap: break-word;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }
        .table td, .table th {
            padding: 0.5rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            white-space: pre-line;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <div class="payments-refunds-statement row mt-3">
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
    </div>
</body>
</html>