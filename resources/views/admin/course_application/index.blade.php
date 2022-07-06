@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.course_application_details')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.course_application_details')}}</h1>
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
                            <th>#</th>
                            <td>{{__('Admin/backend.created_at')}}</td>
                            <th>{{__('Admin/backend.user_name')}}</th>
                            <th>{{__('Admin/backend.user_email')}}</th>
                            <th>{{__('Admin/backend.name')}}</th>
                            <th>{{__('Admin/backend.email')}}</th>
                            <th>{{__('Admin/backend.mobile')}}</th>
                            <th>{{__('Admin/backend.school_name')}}</th>
                            <th>{{__('Admin/backend.city')}}</th>
                            <th>{{__('Admin/backend.country')}}</th>
                            <th>{{__('Admin/backend.programme_name')}}</th>
                            <th>{{__('Admin/backend.start_date')}}</th>
                            <th>{{__('Admin/backend.duration')}}</th>
                            <th>{{__('Admin/backend.course_cost')}}</th>
                            <th>{{__('Admin/backend.amount_paid')}}</th>
                            <th>{{__('Admin/backend.application_status')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booked_details as $details)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $details->created_at }}</td>
                                <td>{{ get_language() == 'en' ? $details->User->first_name_en : $details->User->first_name_ar }} {{ get_language() == 'en' ? $details->User->last_name_en : $details->User->last_name_ar }}</td>
                                <td>{{ $details->User->email ?? '-' }}</td>
                                <td>{{ $details->fname ?? '' }} {{ $details->mname ?? '' }} {{ $details->lname ?? '' }}</td>
                                <td>{{ $details->email }}</td>
                                <td>{{ $details->User->contact ?? $details->mobile }}</td>
                                <td>{{ $details->course->school && $details->course->school->name ? (get_language() == 'en' ? $details->course->school->name->name : $details->course->school->name->name_ar) : '' }}</td>
                                <td>{{ $details->course->school && $details->course->school->city ? (get_language() == 'en' ? $details->course->school->city->name : $details->course->school->city->name_ar) : '' }}</td>
                                <td>{{ $details->course->school && $details->course->school->country ? (get_language() == 'en' ? $details->course->school->country->name : $details->course->school->country->name_ar) : '' }}</td>
                                <td>{{ $details->course->program_name }}</td>
                                <td>{{ $details->start_date }}</td>
                                <td>{{ $details->program_duration }}</td>
                                <td>{{ toFixedNumber(getCurrencyConvertedValue($details->course_id, $details->total_cost)) }}</td>
                                <td>{{ toFixedNumber(getCurrencyConvertedValue($details->course_id, $details->deposit_price)) }}</td>
                                <td>{{ isset($details->courseApplicationApprove->approve) ? ucwords($details->courseApplicationApprove->approve  == 1 ? 'Application Recevived' : 'Send To School Admin' ) : 'Application Recevived' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ auth('superadmin')->check() ? route('superadmin.course_application.edit', $details->id) : route('schooladmin.course_application.edit', $details->id) }}" class="btn btn-info btn-sm fa fa-eye"></a>
                                        @if (isset($details->courseApplicationApprove->approved))
                                            @if ($details->courseApplicationApprove->approved == 1)
                                                <a href="{{ auth('superadmin')->check() ? route('superadmin.course_application.approve', ['id' => $details->id, 'value' => 0]) : route('schooladmin.course_application.approve', ['id' => $details->id, 'value' => 0]) }}" class="btn btn-success btn-sm fa fa-check"></a>
                                            @else
                                                <a href="{{ auth('superadmin')->check() ? route('superadmin.course_application.approve', ['id' => $details->id, 'value' => 1]) : route('schooladmin.course_application.approve', ['id' => $details->id, 'value' => 1]) }}" class="btn btn-danger btn-sm fa fa-window-close"></a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection