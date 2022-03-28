@extends('branchadmin.layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.course_details')</h1></div>
                @can('can_add_course')
                    <a href="{{route('branch_admin.course.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                    </a>
                @endcan
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('SuperAdmin/backend.language') </th>
                            <th> @lang('SuperAdmin/backend.program_type') </th>
                            <th> @lang('SuperAdmin/backend.study_mode') </th>
                            <th> @lang('SuperAdmin/backend.school_name') </th>
                            <th> @lang('SuperAdmin/backend.school_branch_name') </th>
                            <th> @lang('SuperAdmin/backend.currency') </th>

                            <th> @lang('SuperAdmin/backend.program_name') </th>
                            <th> @lang('SuperAdmin/backend.program_level') </th>
                            <th> @lang('SuperAdmin/backend.lessons_per_week') </th>
                            <th> @lang('SuperAdmin/backend.hours_per_week') </th>
                            <th> @lang('SuperAdmin/backend.study_time') </th>
                            <th> @lang('SuperAdmin/backend.start_day_every') </th>
                            <th> @lang('SuperAdmin/backend.about_program') </th>
                            <th> @lang("SuperAdmin/backend.program") </th>
                            <th> @lang('SuperAdmin/backend.accommodation') </th>
                            <th> @lang("SuperAdmin/backend.airport") </th>
                            <th> @lang('SuperAdmin/backend.medical') </th>
                            <th> @lang("SuperAdmin/backend.action") </th>
                            <th> @lang("SuperAdmin/backend.created_on") </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools->courses as  $course)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{is_array($course->language) ? implode(', ', $course->language) : $course->language}}</td>
                                <td>{{ is_null($course->program_type) ? '-' : implode(", ", $course->program_type)}}</td>
                                <td>{{is_null($course->study_mode) ? '-' : implode(", ", $course->study_mode)}}</td>
                                <td>{{get_language()== 'en'  ?  $course->school->name ?? '-' :  $course->school->name_ar  ?? '-'}}</td>
                                <td>{{is_array($course->branch) ? implode(", ", $course->branch) : $course->branch}}</td>
                                <td>{{$course->currency}}</td>
                                <td>{{$course->program_name}}</td>
                                <td>{{$course->program_level}}</td>
                                <td>{{$course->lessons_per_week}}</td>
                                <td>{{$course->hours_per_week}}</td>
                                <td>{{is_null($course->study_time) ? '-' : implode(", ", $course->study_time)}}</td>
                                <td>{{is_null($course->every_day) ? '-' : implode(", ", $course->every_day)}}</td>
                                <td>{!! $course->about_program !!}</td>
                                <td>
                                    @if(!($course->coursePrograms()->get()->isEmpty()))
                                        <a type="button" href="{{route('branch_admin.course_program_details', $course->unique_id)}}" class="btn btn-sm btn-primary">@lang('SuperAdmin/backend.click_here')</a>
                                    @else
                                        @lang('SuperAdmin/backend.no_details_available')
                                    @endif
                                </td>
                                <td>
                                    @if(!($course->accomodations()->get()->isEmpty()))
                                        <a type="button" href="{{route('branch_admin.accomodation_details', $course->unique_id)}}" class="btn btn-sm btn-primary">@lang('SuperAdmin/backend.click_here')</a>
                                    @else
                                        @lang('SuperAdmin/backend.no_details_available')
                                    @endif
                                </td>
                                <td>
                                    @if(!($course->airports()->get()->isEmpty()))
                                        <a type="button" href="{{route('branch_admin.airport_details', $course->unique_id)}}" class="btn btn-sm btn-primary">@lang('SuperAdmin/backend.click_here')</a>
                                    @else
                                        @lang('SuperAdmin/backend.no_details_available')
                                    @endif
                                </td>
                                <td>
                                    @if(!($course->medicals()->get()->isEmpty()))
                                        <a type="button" href="{{route('branch_admin.medical_details', $course->unique_id)}}" class="btn btn-sm btn-primary">@lang('SuperAdmin/backend.click_here')</a>
                                    @else
                                        @lang('SuperAdmin/backend.no_details_available')
                                    @endif
                                </td>
                                <td>
                                    @can('can_edit_course')
                                    <div class="btn-group">
                                        <a onclick="tinymceInit()" class="btn btn-primary btn-sm fa fa-pencil" data-toggle="modal" data-target="#edit_modal{{$course->unique_id}}"></a>
                                    </div>
                                    @endcan
                                </td>
                                <td>{{$course->created_at->diffForHumans()}}</td>
                            </tr>

                            <div class="modal fade" id="edit_modal{{$course->unique_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('branch_admin.course_update')}}">
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
                                                        @if(isset($course->school->getCityCountryStateAuth()->branch))
                                                            @foreach($course->school->getCityCountryStateAuth()->branch as $branches)
                                                                <option multiple="" value="{{$branches}}" {{in_array($branches, $course->branch ?? []) ? 'selected' : ''}} >{{get_language() == 'en' ? $branches : $branches }}</option>
                                                            @endforeach
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
                                                    <label class="">{{__('SuperAdmin/backend.about_program')}} {{__('SuperAdmin/backend.in_english')}} </label>
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
                                                <button
                                                    onclick="getContent('textarea_about_program_ar', 'input_about_courier_ar'); getContent('textarea_about_program', 'input_about_courier)"
                                                    type="submit" class="btn btn-success">Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection