@extends('superadmin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">@lang('SuperAdmin/backend.deleted_course_details')</h1>
                </div>
                <form method="post" action="{{route('superadmin.course.bulk')}}">
                    @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-3">
                            <select name="action" class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="restore">{{__('SuperAdmin/backend.restore')}}</option>
                                <option value="destroy">{{__('SuperAdmin/backend.delete')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <input name="ids" type="hidden" value="" />
                            <button class="btn btn-primary btn-sm" onclick="return (confirm('Are You Sure You Wanna Bulk Action') && DoBulkAction())">Bluk Action</button>
                        </div>
                    </div>
                </form>
                <a href="{{route('superadmin.course.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}</a>
                <table class="table table-hover table-bordered table-filtered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-filter="checkbox"> @lang('SuperAdmin/backend.select') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["languages"])}}"> @lang('SuperAdmin/backend.language') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["program_types"])}}"> @lang('SuperAdmin/backend.program_type') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["study_modes"])}}"> @lang('SuperAdmin/backend.study_mode') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_names"])}}"> @lang('SuperAdmin/backend.school_name') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_cities"])}}"> @lang('SuperAdmin/backend.city') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["school_countries"])}}"> @lang('SuperAdmin/backend.country') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["branch_names"])}}"> @lang('SuperAdmin/backend.school_branch_name') </th>
                            <th data-filter="select" data-select="{{implode(",", $choose_fields["currencies"])}}"> @lang('SuperAdmin/backend.currency') </th>

                            <th> @lang('SuperAdmin/backend.program_name') </th>
                            <th> @lang('SuperAdmin/backend.program_level') </th>
                            <th> @lang('SuperAdmin/backend.lessons_per_week') </th>
                            <th> @lang('SuperAdmin/backend.hours_per_week') </th>
                            <th> @lang('SuperAdmin/backend.study_time') </th>
                            <th> @lang('SuperAdmin/backend.start_day_every') </th>

                            <th> @lang("SuperAdmin/backend.action") </th>
                            <th> @lang("SuperAdmin/backend.created_on") </th>
                            <th> @lang("SuperAdmin/backend.updated_on") </th>
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
                                        <form method="post" action="{{route('superadmin.course.restore', $course->unique_id)}}">
                                            @csrf
                                            <button onclick="return confirm('Are You Sure You Wanna Restore')" class="btn btn-success btn-sm fa fa-undo"></button>
                                        </form>
                                        <form method="post" action="{{route('superadmin.course.destroy', $course->unique_id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are You Sure You Wanna Delete')" class="btn btn-danger btn-sm fa fa-trash"></button>
                                        </form>
                                    </div>
                                </td>
                                <td>{{$course->created_at->diffForHumans()}}</td>
                                <td>{{$course->updated_at->diffForHumans()}}</td>
                            </tr>

                            {{--Edit Modal--}}
                            <div class="modal fade" id="edit_modal{{$course->unique_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('superadmin.course_update')}}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('SuperAdmin/backend.edit_course_program_price')</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <input hidden name="id" value="{{$course->unique_id}}">
                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.language')}}</label>
                                                    <select name="language[]" multiple="multiple" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Language::all() as $language)
                                                            <option multiple="" value="{{$language->name}}" {{in_array($language->name, (array)$course->language) ? 'selected' : ''}} >{{$language->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.program_type')}}:</label>
                                                    <select name="program_type[]" multiple="multiple" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Program_Type::all() as $program_type)
                                                            <option multiple="" value="{{$program_type->name}}" {{in_array($program_type->name, (array)$course->program_type) ? 'selected' : ''}} >{{$program_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.study_mode')}}</label>
                                                    <select name="study_mode[]" multiple="multiple" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Study_Mode::all() as $study_mode)
                                                            <option multiple="" value="{{$study_mode->name}}" {{in_array($study_mode->name, (array)$course->study_mode) ? 'selected' : ''}} >{{$study_mode->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.school_name')}}</label>
                                                    <select name="school_id" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\School::all() as $schools)
                                                            <option value="{{$schools->id}}" {{in_array($schools->id, (array)$course->school_id) ? 'selected' : ''}} >{{$schools->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.school_branch_name')}}</label>
                                                    <select name="branch[]" multiple="multiple" class="form-control">
                                                        @if(isset($course->school->branch_name) && is_array($course->school->branch_name))
                                                            @foreach($course->school->branch_name as $branches)
                                                                <option multiple="" value="{{$branches}}" {{in_array($branches , $course->branch) ? 'selected' : ''}} >{{get_language() == 'en' ? $branches : $branches }}</option>
                                                            @endforeach
                                                        @else
                                                            <option multiple="" value="{{$course->school->branch_name}}" {{in_array($course->school->branch_name , $course->branch ?? []) ? 'selected' : ''}} >{{get_language() == 'en' ? $course->school->branch_name : $course->school->branch_name_ar }}</option>
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.currency')}}</label>
                                                    <input type="text" class="form-control" name='currency' value="{{$course->currency}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.program_name')}}:</label>
                                                    <input type="text" class="form-control" name='program_name' value="{{$course->program_name}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.program_level')}}</label>
                                                    <input type="text" class="form-control" name='program_level' value="{{$course->program_level}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.lessons_per_week')}}:</label>
                                                    <input type="text" class="form-control" name='lessons_per_week' value="{{$course->lessons_per_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.hours_per_week')}}:</label>
                                                    <input type="text" class="form-control" name='hours_per_week' value="{{$course->hours_per_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.study_time')}}:</label>
                                                    <select name="study_time[]" multiple="multiple" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Study_Time::all() as $study_time)
                                                            <option multiple="" value="{{$study_time->name}}" {{in_array($study_time->name, (array)$course->study_time) ? 'selected' : ''}} >{{$study_time->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.start_day_every')}}</label>
                                                    <select name="every_day[]" multiple="multiple" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Start_Day::all() as $start_day)
                                                            <option multiple="" value="{{$start_day->name}}" {{in_array($start_day->name, (array)$course->every_day) ? 'selected' : ''}} >{{$start_day->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.about_program')}} {{__('SuperAdmin/backend.in_english')}}</label>
                                                    <textarea id="textarea_about_program">{{$course->about_program}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.about_program')}} {{__('SuperAdmin/backend.in_arabic')}}</label>
                                                    <textarea id="textarea_about_program_ar">{{$course->about_program_ar}}</textarea>
                                                </div>

                                                <input name="about_program_ar" id="input_about_program">
                                                <input name="about_program" id="input_about_program_ar">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-info">Close</button>
                                                <input type="hidden" id="getvalue" name="formvalue">
                                                <button onclick="getContent('textarea_about_program_ar', 'input_about_courier_ar'); getContent('textarea_about_program', 'input_about_courier')" type="submit" class="btn btn-success">{{__('SuperAdmin/backend.submit')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{--Edit Modal Ends--}}
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