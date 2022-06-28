@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.course_details')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.course_details')}}</h1>
                </div>
                
                @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_add'] || auth('superadmin')->user()->permission['course_display'] || auth('superadmin')->user()->permission['course_delete'])
                    <form method="post" action="{{route('superadmin.course.bulk')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="form-group col-md-3">
                                <select name="action" class="custom-select custom-select-sm form-control form-control-sm">
                                    @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_add'])
                                        <option value="clone">{{__('SuperAdmin/backend.clone')}}</option>
                                    @endif
                                    @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_display'])
                                        <option value="play">{{__('SuperAdmin/backend.play')}}</option>
                                        <option value="pause">{{__('SuperAdmin/backend.pause')}}</option>
                                    @endif
                                    @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_delete'])
                                        <option value="delete">{{__('SuperAdmin/backend.delete')}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <input name="ids" type="hidden" value="" />
                                <button class="btn btn-primary btn-sm" onclick="return (confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_restore')}}') && DoBulkAction())">Bluk Action</button>
                            </div>
                        </div>
                    </form>
                @endif

                @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_add'])
                    <a href="{{route('superadmin.course.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body table table-responsive">
                <table class="table table-hover table-bordered table-filtered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-filter="checkbox">{{__('SuperAdmin/backend.select')}}</th>
                            <th>{{__('SuperAdmin/backend.promotion')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["languages"])}}">{{__('SuperAdmin/backend.language')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["program_types"])}}">{{__('SuperAdmin/backend.program_type')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["study_modes"])}}">{{__('SuperAdmin/backend.study_mode')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_names"])}}">{{__('SuperAdmin/backend.school_name')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_cities"])}}">{{__('SuperAdmin/backend.city')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_countries"])}}">{{__('SuperAdmin/backend.country')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["branch_names"])}}">{{__('SuperAdmin/backend.branch_name')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["currencies"])}}">{{__('SuperAdmin/backend.currency')}}</th>

                            <th>{{__('SuperAdmin/backend.program_name')}}</th>
                            <th>{{__('SuperAdmin/backend.program_level')}}</th>
                            <th>{{__('SuperAdmin/backend.lessons_per_week')}}</th>
                            <th>{{__('SuperAdmin/backend.hours_per_week')}}</th>
                            <th>{{__('SuperAdmin/backend.study_time')}}</th>
                            <th>{{__('SuperAdmin/backend.start_dates')}}</th>

                            <th>{{__("SuperAdmin/backend.action")}}</th>
                            <th>{{__("SuperAdmin/backend.created_on")}}</th>
                            <th>{{__("SuperAdmin/backend.updated_on")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><input type="checkbox" data-id="{{$course->unique_id}}" /></td>
                                <td>
                                    @if (auth('superadmin')->user()->permission['course_manager'])
                                        @if (checkCoursePromotion($course->unique_id))
                                            <form method="post" action="{{route('superadmin.course.promotion', $course->unique_id)}}">
                                                @csrf

                                                <input type="hidden" name="promotion" value="{{ $course->promotion ? 1 : 0 }}" />
                                                <button class="btn btn-{{ $course->promotion ? 'info' : 'danger' }} btn-sm fa fa-{{ $course->promotion ? 'check' : 'times' }}"></button>
                                            </form>
                                        @else
                                            <i class="fa fa-times px-3 py-2 m-2 color-danger cursor-default"></i>
                                        @endif
                                    @endif
                                </td>
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
                                    <div class="btn-group">
                                        @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_edit'])
                                            <a class="btn btn-primary btn-sm fa fa-pencil" href="{{route('superadmin.course.edit', $course->unique_id)}}"></a>
                                        @endif
                                        
                                        @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_add'])
                                            <form method="post" action="{{route('superadmin.course.clone', $course->unique_id)}}">
                                                @csrf
                                                <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_clone')}}')" class="btn btn-info btn-sm fa fa-clone"></button>
                                            </form>
                                        @endif

                                        @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_display'])
                                            @if ($course->display)
                                                <form method="post" action="{{route('superadmin.course.pause', $course->unique_id)}}">
                                                    @csrf
                                                    <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_pause')}}')" class="btn btn-secondary btn-sm fa fa-pause"></button>
                                                </form>
                                            @else
                                                <form method="post" action="{{route('superadmin.course.play', $course->unique_id)}}">
                                                    @csrf
                                                    <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_play')}}')" class="btn btn-success btn-sm fa fa-play"></button>
                                                </form>
                                            @endif
                                        @endif
                                        
                                        @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['course_delete'])
                                            <form method="post" action="{{route('superadmin.course.delete', $course->unique_id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_delete')}}')" class="btn btn-danger btn-sm fa fa-trash"></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td>{{$course->created_at->diffForHumans()}}</td>
                                <td>{{$course->updated_at->diffForHumans()}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @section('js')
        <script>
            function AddReadMore() {
                //This limit you can set after how much characters you want to show Read More.
                var carLmt = 100;
                // Text to show when text is collapsed
                var readMoreTxt = " ... Read More";
                // Text to show when text is expanded
                var readLessTxt = " Read Less";

                // Traverse all selectors with this class and manupulate HTML part to show Read More
                $(".addReadMore").each(function() {
                    if ($(this).find(".firstSec").length) {
                        return;
                    }

                    var allstr = $(this).text();
                    if (allstr.length > carLmt) {
                        var firstSet = allstr.substring(0, carLmt);
                        var secdHalf = allstr.substring(carLmt, allstr.length);
                        var strtoadd = firstSet + "<p><span class='SecSec'>" + secdHalf + "</span></p><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                        $(this).html(strtoadd);
                    }
                });
                // Read More and Read Less Click Event binding
                $(document).on("click", ".readMore, .readLess", function() {
                    $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
                });
            }
            
            $(function() {
                // Calling function after Page Load
                AddReadMore();
            });
        </script>
    @endsection
@endsection