@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.course_application_details')}}
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.course_application_details')}}</h1>
                </div>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <td>{{__('SuperAdmin/backend.course_application_details')}}</td>
                            <th>{{__('SuperAdmin/backend.user_name')}}</th>
                            <th>{{__('SuperAdmin/backend.name')}}</th>
                            <th>{{__('SuperAdmin/backend.email')}}</th>
                            <th>{{__('SuperAdmin/backend.mobile')}}</th>
                            <th>{{__('SuperAdmin/backend.school_name')}}</th>
                            <th>{{__('SuperAdmin/backend.city')}}</th>
                            <th>{{__('SuperAdmin/backend.country')}}</th>
                            <th>{{__('SuperAdmin/backend.programme_name')}}</th>
                            <th>{{__('SuperAdmin/backend.start_date')}}</th>
                            <th>{{__('SuperAdmin/backend.duration')}}</th>
                            <th>{{__('SuperAdmin/backend.course_cost')}}</th>
                            <th>{{__('SuperAdmin/backend.amount_paid')}}</th>
                            <th>{{__('SuperAdmin/backend.application_status')}}</th>
                            <th>{{__('SuperAdmin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booked_details as $details)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $details->created_at }}</td>
                                <td>{{ get_language() == 'en' ? ucwords($details->User->first_name_en) : ucwords($details->User->first_name_ar) }} {{ get_language() == 'en' ? ucwords($details->User->last_name_en) : ucwords($details->User->last_name_ar) }}</td>
                                <td>{{ ucwords($details->fname) }} {{ucwords($details->lname) }}</td>
                                <td>{{ ucwords($details->userBookDetailsApproved->email ?? $details->email) }}</td>
                                <td>{{ ucwords($details->userBookDetailsApproved->mobile ?? $details->mobile) }}</td>
                                <td>{{ ucwords(get_language() == 'en' ? $details->course->school->name : $details->course->school->name_ar) }}</td>
                                <td>{{ ucwords( $details->course->school->city) }}</td>
                                <td>{{ ucwords($details->course->school->country) }}</td>
                                <td>{{ ucwords($details->course->program_name) }}</td>
                                <td>{{ ucwords($details->start_date) }}</td>
                                <td>{{ ucwords($details->program_duration) }}</td>
                                <td>{{ ucwords($details->other_currency) }}</td>
                                <td>{{ ucwords($details->paid_amount) }}</td>
                                <td>{{ isset($details->userBookDetailsApproved->approve) ? ucwords($details->userBookDetailsApproved->approve  == 1 ? 'Application Recevived' : 'Send To School Admin' ) : 'Application Recevived' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.manage_application.edit', $details->id)}}" class="btn btn-info btn-sm fa fa-eye"></a>
                                        @if (isset($details->userBookDetailsApproved->approved))
                                            @if ($details->userBookDetailsApproved->approved == 1)
                                                <a href="{{route('superadmin.manage_application.approve', ['id' => $details->id, 'value' => 0])}}" class="btn btn-success btn-sm fa fa-check"></a>
                                            @else
                                                <a href="{{route('superadmin.manage_application.approve', ['id' => $details->id, 'value' => 1])}}" class="btn btn-danger btn-sm fa fa-window-close"></a>
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