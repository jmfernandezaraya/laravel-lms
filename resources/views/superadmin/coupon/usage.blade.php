@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.coupon_usages')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.coupon_usages')}}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body table table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{__('Admin/backend.order_no')}}</th>
                            <th>{{__('Admin/backend.customer_name')}}</th>
                            <th>{{__('Admin/backend.email')}}</th>
                            <th>{{__('Admin/backend.school_name')}}</th>
                            <th>{{__('Admin/backend.city')}}</th>
                            <th>{{__('Admin/backend.country')}}</th>
                            <th>{{__('Admin/backend.course_cost')}}</th>
                            <th>{{__('Admin/backend.discount')}}</th>
                            <th>{{__('Admin/backend.afflicate_user')}}</th>
                            <th>{{__('Admin/backend.commission')}}</th>
                            <th>{{__('Admin/backend.date_of_use')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupon_usages as $coupon_usage)
                            <tr>
                                <td>{{ $coupon_usage->course_application->id }}</td>
                                <td>
                                    @if (get_language() == 'en')
                                        {{ $coupon_usage->course_application->User->first_name_en }} {{ $coupon_usage->course_application->User->last_name_en }}
                                    @else
                                        {{ $coupon_usage->course_application->User->first_name_ar }} {{ $coupon_usage->course_application->User->last_name_ar }}
                                    @endif
                                </td>
                                <td>{{ $coupon_usage->course_application->User->email }}</td>
                                <td>
                                    @if ($coupon_usage->course_application->school && $coupon_usage->course_application->school->name)
                                        @if (get_language() == 'en')
                                            {{ $coupon_usage->course_application->school->name->name }}
                                        @else
                                            {{ $coupon_usage->course_application->school->name->name_ar }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($coupon_usage->course_application->school && $coupon_usage->course_application->school->city)
                                        @if (get_language() == 'en')
                                            {{ $coupon_usage->course_application->school->city->name }}
                                        @else
                                            {{ $coupon_usage->course_application->school->city->name_ar }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($coupon_usage->course_application->school && $coupon_usage->course_application->school->country)
                                        @if (get_language() == 'en')
                                            {{ $coupon_usage->course_application->school->country->name }}
                                        @else
                                            {{ $coupon_usage->course_application->school->country->name_ar }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($coupon_usage->course_application->getCourseProgram)
                                        {{ $coupon_usage->course_application->getCourseProgram->program_cost }}
                                    @endif
                                </td>
                                <td>{{ $coupon_usage->course_application->coupon_discount_converted }}</td>
                                <td>
                                    @if ($coupon_usage->coupon->afflicate_user)
                                        @if (get_language() == 'en')
                                            {{ $coupon_usage->coupon->afflicate_user->first_name_en }} {{ $coupon_usage->coupon->afflicate_user->last_name_en }}
                                        @else
                                            {{ $coupon_usage->coupon->afflicate_user->first_name_ar }} {{ $coupon_usage->coupon->afflicate_user->last_name_ar }}
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $coupon_usage->course_application->coupon_discount_converted }}</td>
                                <td>{{ $coupon_usage->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection