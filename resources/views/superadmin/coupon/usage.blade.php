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
                                <td>{{ get_language() == 'en' ? $coupon_usage->course_application->User->first_name_en : $coupon_usage->course_application->User->first_name_ar }} {{ get_language() == 'en' ? $coupon_usage->course_application->User->last_name_en : $coupon_usage->course_application->User->last_name_ar }}</td>
                                <td>{{ $coupon_usage->course_application->User->email }}</td>
                                <td>{{ $coupon_usage->course_application->school && $coupon_usage->course_application->school->name ? (get_language() == 'en' ? $coupon_usage->course_application->school->name->name : $coupon_usage->course_application->school->name->name_ar) : '' }}</td>
                                <td>{{ $coupon_usage->course_application->school && $coupon_usage->course_application->school->city ? (get_language() == 'en' ? $coupon_usage->course_application->school->city->name : $coupon_usage->course_application->school->city->name_ar) : '' }}</td>
                                <td>{{ $coupon_usage->course_application->school && $coupon_usage->course_application->school->country ? (get_language() == 'en' ? $coupon_usage->course_application->school->country->name : $coupon_usage->course_application->school->country->name_ar) : '' }}</td>
                                <td>{{ $coupon_usage->course_application->course_program->program_cost }}</td>
                                <td>{{ $coupon_usage->afflicate_user->name }}</td>
                                <td>{{ $coupon_usage->course_application->commission }}</td>
                                <td>{{ $coupon_usage->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection