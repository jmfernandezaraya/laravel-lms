@extends('schooladmin.layouts.app')


@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">@lang('SuperAdmin/backend.course_details')</h1>
                </div>

                @can('can_add_course')
                    <a href="{{route('schooladmin.course.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                    </a>
                @endcan
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('SuperAdmin/backend.language')}}</th>
                            <th>{{__('SuperAdmin/backend.program_type')}}</th>
                            <th>{{__('SuperAdmin/backend.study_mode')}}</th>
                            <th>{{__('SuperAdmin/backend.school_name')}}</th>
                            <th>{{__('SuperAdmin/backend.city')}}</th>
                            <th>{{__('SuperAdmin/backend.country')}}</th>
                            <th>{{__('SuperAdmin/backend.branch_name')}}</th>
                            <th>{{__('SuperAdmin/backend.currency')}}</th>

                            <th>{{__('SuperAdmin/backend.program_name')}}</th>
                            <th>{{__('SuperAdmin/backend.program_level')}}</th>
                            <th>{{__('SuperAdmin/backend.lessons_per_week')}}</th>
                            <th>{{__('SuperAdmin/backend.hours_per_week')}}</th>
                            <th>{{__('SuperAdmin/backend.study_time')}}</th>
                            <th>{{__('SuperAdmin/backend.start_dates')}}</th>

                            <th>{{__("SuperAdmin/backend.action")}}</th>
                            <th>{{__("SuperAdmin/backend.created_on")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                            @foreach($school->courses as $course)
                                <tr>      
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ implode(", ", getCourseLanguageNames($course->language)) }}</td>
                                    <td>{{ implode(", ", getCourseProgramTypeNames($course->program_type)) }}</td>
                                    <td>{{ implode(", ", getCourseStudyModeNames($course->study_mode)) }}</td>
                                    <td>{{ $course->school && $course->school->name ? (get_language() == 'en' ? $course->school->name->name : $course->school->name->name_ar) : '-' }}</td>
                                    <td>{{ $course->school && $course->school->city ? (get_language() == 'en' ? $course->school->city->name : $course->school->city->name_ar) : '-' }}</td>
                                    <td>{{ $course->school && $course->school->country ? (get_language() == 'en' ? $course->school->country->name : $course->school->country->name_ar) : '-' }}</td>
                                    <td>{{ $course->branch }}</td>
                                    <td>{{ is_null($course->getCurrency) ? '-' : $course->getCurrency->name }}</td>
                                    <td>{{ $course->program_name }}</td>
                                    <td>{{ $course->program_level }}</td>
                                    <td>{{ $course->lessons_per_week }}</td>
                                    <td>{{ $course->hours_per_week }}</td>
                                    <td>{{ implode(", ", getCourseStudyTimeNames($course->study_time)) }}</td>
                                    <td>{{ implode(", ", getCourseStartDateNames($course->start_date)) }}</td>

                                    <td>
                                        @can('can_edit_course')
                                            <div class="btn-group">
                                                <a href="{{route('schooladmin.course.edit', $course->unique_id)}}" class="btn btn-primary btn-sm fa fa-pencil"></a>
                                            </div>
                                        @endcan
                                        @can('can_delete_course')
                                            <form method="post" action="{{route('schooladmin.course.delete', $course->unique_id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_delete')}}')" class="btn btn-danger btn-sm fa fa-trash"></button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{$course->created_at->diffForHumans()}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection