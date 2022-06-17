@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.course_application')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.course_application')}}</h1>
@endsection

@section('content')
    <div class="dashboard table table-responsive p-2">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <table class="table table-hover table-bordered table-filtered" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __("Frontend.created_on") }}</th>
                            <th>{{ __("Frontend.name") }}</th>
                            <th>{{ __("Frontend.email") }}</th>
                            <th>{{ __("Frontend.mobile") }}</th>
                            <th>{{ __("Frontend.name") }}</th>
                            <th>{{ __("Frontend.city") }}</th>
                            <th>{{ __("Frontend.country") }}</th>
                            <th>{{ __("Frontend.program_name") }}</th>
                            <th>{{ __("Frontend.start_date") }}</th>
                            <th>{{ __("Frontend.duration") }}</th>
                            <th>{{ __("Frontend.course_cost") }}</th>
                            <th>{{ __("Frontend.amount_paid") }}</th>
                            <th>{{ __("Frontend.application_status") }}</th>
                            <th>{{ __("Frontend.action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booked_courses as $booked_course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $booked_course->created_at }}</td>
                                <td>{{ ucwords($booked_course->fname) }} {{ ucwords($booked_course->lname) }}</td>
                                <td>{{ ucwords($booked_course->courseApplicationApprove->email ?? $booked_course->email) }}</td>
                                <td>{{ ucwords($booked_course->courseApplicationApprove->mobile ?? $booked_course->mobile) }}</td>
                                <td>{{ $booked_course->course->school->name ? (app()->getLocale() == 'en' ? ($booked_course->course->school->name->name ?? '-') : ($booked_course->course->school->name->name_ar ?? '-')) : '-' }} {{ app()->getLocale() == 'en' ? ($booked_course->course->school->branch_name ?? '') : ($booked_course->course->school->branch_name_ar ?? '') }}</td>
                                <td>{{ $booked_course->course->school->city ? (app()->getLocale() == 'en' ? ($booked_course->course->school->city->name ?? '-') : ($booked_course->course->school->city->name_ar ?? '-')) : '-' }}</td>
                                <td>{{ $booked_course->course->school->country ? (app()->getLocale() == 'en' ? ($booked_course->course->school->country->name ?? '-') : ($booked_course->course->school->country->name_ar ?? '-')) : '-' }}</td>
                                <td>{{ ucwords($booked_course->course->program_name) }}</td>
                                <td>{{ ucwords($booked_course->start_date) }}</td>
                                <td>{{ ucwords($booked_course->program_duration) }}</td>
                                <td>{{ ucwords($booked_course->program_cost) }}</td>
                                <td>{{ ucwords($booked_course->deposit_price) }}</td>
                                <td>{{ isset($booked_course->courseApplicationApprove->approve) ? ($booked_course->courseApplicationApprove->approve == 1 ? __("Frontend.application_recevied") : __("Frontend.send_to_school_admin") ) : __("Frontend.application_recevied") }}</td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('frontend.dashboard.course_application', $booked_course->id)}}" class="btn btn-info btn-sm fa fa-eye"></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', (event) => {
		    $('table').DataTable({ responsive: true });
		});
    </script>
@endsection