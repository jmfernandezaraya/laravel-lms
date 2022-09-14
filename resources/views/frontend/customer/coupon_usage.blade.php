@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.coupon_history')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{route('frontend.dashboard')}}" class="breadcrumb-home">
            <i class="bx bxs-dashboard"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.coupon_history')}}</h1>
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
                                <th>{{ __("Frontend.order_no") }}</th>
                                <th>{{ __("Frontend.school_name") }}</th>
                                <th>{{ __("Frontend.city") }}</th>
                                <th>{{ __("Frontend.country") }}</th>
                                <th>{{ __("Frontend.course_cost") }}</th>
                                <th>{{ __("Frontend.commission") }}</th>
                                <th>{{ __("Frontend.date_of_use") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupon_usages as $coupon_usage)
                                <tr>
                                    <td>{{ $coupon_usage->course_application->id }}</td>
                                    <td>{{ $coupon_usage->course_application->course->school->name ? (app()->getLocale() == 'en' ? ($coupon_usage->course_application->course->school->name->name ?? '-') : ($coupon_usage->course_application->course->school->name->name_ar ?? '-')) : '-' }} {{ app()->getLocale() == 'en' ? ($coupon_usage->course_application->course->school->branch_name ?? '') : ($coupon_usage->course_application->course->school->branch_name_ar ?? '') }}</td>
                                    <td>{{ $coupon_usage->course_application->course->school->city ? (app()->getLocale() == 'en' ? ($coupon_usage->course_application->course->school->city->name ?? '-') : ($coupon_usage->course_application->course->school->city->name_ar ?? '-')) : '-' }}</td>
                                    <td>{{ $coupon_usage->course_application->course->school->country ? (app()->getLocale() == 'en' ? ($coupon_usage->course_application->course->school->country->name ?? '-') : ($coupon_usage->course_application->course->school->country->name_ar ?? '-')) : '-' }}</td>
                                    <td>{{ toFixedNumber(getCurrencyConvertedValue($coupon_usage->course_application->course_id, $coupon_usage->course_application->program_cost)) }}</td>
                                    <td>{{ toFixedNumber($coupon_usage->course_application->coupon_discount_converted) }}</td>
                                    <td>{{ $coupon_usage->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', (event) => {
		    $('table').DataTable({ responsive: true });
		});
    </script>
@endsection