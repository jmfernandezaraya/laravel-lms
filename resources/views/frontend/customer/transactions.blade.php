@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.transactions')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{route('frontend.dashboard')}}" class="breadcrumb-home">
            <i class="bx bxs-dashboard"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.transactions')}}</h1>
    </div>
@endsection

@section('content')
    <div class="dashboard table table-responsive p-2">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-md-12">
                    <table class="table table-hover table-bordered table-filtered" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __("Frontend.date_added") }}</th>
                                <th>{{ __("Frontend.date_to_pay_the_commission") }}</th>
                                <th>{{ __("Frontend.description") }}</th>
                                <th>{{ __("Frontend.amount") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $transactions_amount = 0; @endphp
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('m/d/Y') }}</td>
                                    <td>{{ $transaction->course_application ? $transaction->course_application->start_date->addWeeks(4)->format('m/d/Y') : '' }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>
                                        @if ($transaction->amount_refunded)
                                            <span class="text-danger">{{ toFixedNumber('-' . $transaction->amount_refunded) }}</span>
                                            @php $transactions_amount = $transactions_amount - $transaction->amount_refunded; @endphp
                                        @endif
                                        @if ($transaction->amount_added)
                                            {{ toFixedNumber($transaction->amount_added) }}
                                            @php $transactions_amount = $transactions_amount + $transaction->amount_added; @endphp
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: #97d0db88;">
                                <td colspan="3" style="text-align: center;">{{ __("Frontend.balance") }}</td>
                                <td>{{ $transactions_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection