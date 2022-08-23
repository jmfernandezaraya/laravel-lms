@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.course_details')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.course_details')}}</h1>
                </div>

                @if (can_manage_course() || can_add_course() || can_display_course() || can_delete_course())
                    <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.bulk') : route('schooladmin.course.bulk') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="form-group col-md-3">
                                <select name="action" class="custom-select custom-select-sm form-control form-control-sm">
                                    @if (can_manage_course() || can_add_course())
                                        <option value="clone">{{__('Admin/backend.clone')}}</option>
                                    @endif
                                    @if (can_manage_course() || can_display_course())
                                        <option value="play">{{__('Admin/backend.play')}}</option>
                                        <option value="pause">{{__('Admin/backend.pause')}}</option>
                                    @endif
                                    @if (can_manage_course() || can_delete_course())
                                        <option value="delete">{{__('Admin/backend.delete')}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <input name="ids" type="hidden" value="" />
                                <button class="btn btn-primary btn-sm" onclick="return (confirm('{{__('Admin/backend.are_you_sure_you_wanna_restore')}}') && DoBulkAction())">Bluk Action</button>
                            </div>
                        </div>
                    </form>
                @endif

                @if (can_manage_course() || can_add_course())
                    <a href="{{ auth('superadmin')->check() ? route('superadmin.course.create') : route('schooladmin.course.create') }}" type="button" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-plus"></i>&nbsp;{{__('Admin/backend.add')}}
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
                            <th data-filter="checkbox">{{__('Admin/backend.select')}}</th>

                            <th>{{__('Admin/backend.promotion')}}</th>

                            <th data-filter="select" data-select="{{implode(",", $choose_fields["languages"])}}">{{__('Admin/backend.language')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["program_types"])}}">{{__('Admin/backend.program_type')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["study_modes"])}}">{{__('Admin/backend.study_mode')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_names"])}}">{{__('Admin/backend.school_name')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_cities"])}}">{{__('Admin/backend.city')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_countries"])}}">{{__('Admin/backend.country')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["branch_names"])}}">{{__('Admin/backend.branch_name')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["currencies"])}}">{{__('Admin/backend.currency')}}</th>

                            <th>{{__('Admin/backend.link_fee')}}</th>

                            <th>{{__('Admin/backend.program_name')}}</th>
                            <th>{{__('Admin/backend.program_level')}}</th>
                            <th>{{__('Admin/backend.lessons_per_week')}}</th>
                            <th>{{__('Admin/backend.hours_per_week')}}</th>
                            <th>{{__('Admin/backend.study_time')}}</th>
                            <th>{{__('Admin/backend.start_dates')}}</th>

                            <th>{{__("Admin/backend.action")}}</th>
                            <th>{{__("Admin/backend.created_on")}}</th>
                            <th>{{__("Admin/backend.updated_on")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><input type="checkbox" data-id="{{$course->unique_id}}" /></td>
                                <td>
                                    @if (can_manage_course())
                                        @if (checkCoursePromotion($course->unique_id))
                                            <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.promotion', $course->unique_id) : route('schooladmin.course.promotion', $course->unique_id) }}">
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
                                <td>
                                    @if (can_manage_course())
                                        <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.link_fee', $course->unique_id) : route('schooladmin.course.link_fee', $course->unique_id) }}">
                                            @csrf

                                            <input type="hidden" name="link_fee" value="{{ $course->link_fee ? 1 : 0 }}" />
                                            <button class="btn btn-{{ $course->link_fee ? 'info' : 'danger' }} btn-sm fa fa-{{ $course->link_fee ? 'play' : 'pause' }}"></button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}</td>
                                <td>{{ $course->program_level }}</td>
                                <td>{{ $course->lessons_per_week }}</td>
                                <td>{{ $course->hours_per_week }}</td>
                                <td>{{ implode(", ", getCourseStudyTimeNames($course->study_time)) }}</td>
                                <td>{{ implode(", ", getCourseStartDateNames($course->start_date)) }}</td>

                                <td>
                                    <div class="btn-group">
                                        @if (can_manage_course() || can_edit_course())
                                            <a class="btn btn-primary btn-sm fa fa-pencil" href="{{ auth('superadmin')->check() ? route('superadmin.course.edit', $course->unique_id) : route('schooladmin.course.edit', $course->unique_id) }}"></a>
                                        @endif
                                        
                                        @if (can_manage_course() || can_add_course())
                                            <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.clone', $course->unique_id) : route('schooladmin.course.clone', $course->unique_id) }}">
                                                @csrf
                                                <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_clone')}}')" class="btn btn-info btn-sm fa fa-clone"></button>
                                            </form>
                                        @endif

                                        @if (can_manage_course() || can_display_course())
                                            @if ($course->display)
                                                <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.pause', $course->unique_id) : route('schooladmin.course.pause', $course->unique_id) }}">
                                                    @csrf
                                                    <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_pause')}}')" class="btn btn-secondary btn-sm fa fa-pause"></button>
                                                </form>
                                            @else
                                                <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.play', $course->unique_id) : route('schooladmin.course.play', $course->unique_id) }}">
                                                    @csrf
                                                    <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_play')}}')" class="btn btn-success btn-sm fa fa-play"></button>
                                                </form>
                                            @endif
                                        @endif
                                        
                                        @if (can_manage_course() || can_delete_course())
                                            <form method="post" action="{{ auth('superadmin')->check() ? route('superadmin.course.delete', $course->unique_id) : route('schooladmin.course.delete', $course->unique_id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_delete')}}')" class="btn btn-danger btn-sm fa fa-trash"></button>
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