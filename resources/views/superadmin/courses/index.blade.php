@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.course_details')}}
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.course_details')}}</h1>
                </div>
                
                <form method="post" action="{{route('superadmin.course.bulk')}}">
                    @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-3">
                            <select name="action" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="clone">{{__('SuperAdmin/backend.clone')}}</option>
                                <option value="play">{{__('SuperAdmin/backend.play')}}</option>
                                <option value="pause">{{__('SuperAdmin/backend.pause')}}</option>
                                <option value="delete">{{__('SuperAdmin/backend.delete')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <input name="ids" type="hidden" value="" />
                            <button class="btn btn-primary btn-sm" onclick="return (confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_restore')}}') && DoBulkAction())">Bluk Action</button>
                        </div>
                    </div>
                </form>
                <a href="{{route('superadmin.course.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                </a>
                <table class="table table-hover table-bordered table-filtered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-filter="checkbox">{{__('SuperAdmin/backend.select')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["languages"])}}">{{__('SuperAdmin/backend.language')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["program_types"])}}">{{__('SuperAdmin/backend.program_type')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["study_modes"])}}">{{__('SuperAdmin/backend.study_mode')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_names"])}}">{{__('SuperAdmin/backend.school_name')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_cities"])}}">{{__('SuperAdmin/backend.city')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_countries"])}}">{{__('SuperAdmin/backend.country')}}</th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["branch_names"])}}">{{__('SuperAdmin/backend.school_branch_name')}}</th>
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
                                <td>{{ implode(", ", getCourseLanguageNames($course->language)) }}</td>
                                <td>{{ implode(", ", getCourseProgramTypeNames($course->program_type)) }}</td>
                                <td>{{ implode(", ", getCourseStudyModeNames($course->study_mode)) }}</td>
                                <td>{{ get_language() == 'en' ? $course->school->name ?? '-' : $course->school->name_ar ?? '-' }}</td>
                                <td>{{ $course->city }}</td>
                                <td>{{ $course->country }}</td>
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
                                        <a class="btn btn-primary btn-sm fa fa-pencil" href="{{route('superadmin.course.edit', $course->unique_id)}}"></a>
                                        <form method="post" action="{{route('superadmin.course.clone', $course->unique_id)}}">
                                            @csrf
                                            <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_clone')}}')" class="btn btn-info btn-sm fa fa-clone"></button>
                                        </form>

                                        @if($course->display)
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
                                        
                                        <form method="post" action="{{route('superadmin.course.delete', $course->unique_id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_you_wanna_delete')}}')" class="btn btn-danger btn-sm fa fa-trash"></button>
                                        </form>
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

                //Traverse all selectors with this class and manupulate HTML part to show Read More
                $(".addReadMore").each(function() {
                    if ($(this).find(".firstSec").length)
                        return;

                    var allstr = $(this).text();
                    if (allstr.length > carLmt) {
                        var firstSet = allstr.substring(0, carLmt);
                        var secdHalf = allstr.substring(carLmt, allstr.length);
                        var strtoadd = firstSet + "<p><span class='SecSec'>" + secdHalf + "</span></p><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                        $(this).html(strtoadd);
                    }
                });
                //Read More and Read Less Click Event binding
                $(document).on("click", ".readMore, .readLess", function() {
                    $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
                });
            }
            $(function() {
                //Calling function after Page Load
                AddReadMore();
            });

            function DoBulkAction() {
                var bulk_ids = [];
                $("table tr td input[type='checkbox']").each(function() {
                    if ($(this).is(':checked')) {
                        bulk_ids.push($(this).data("id"));
                    }
                });
                $("input[name='ids']").val(bulk_ids.join(","));
                return true;
            }
        </script>
    @endsection
@endsection