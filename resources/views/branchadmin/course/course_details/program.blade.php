@extends('branchadmin.layouts.app')

@section('content')
    <style>
        .modal-body {
            overflow: auto;
        }
    </style>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1
                      class="card-title">@lang('SuperAdmin/backend.course_program_details')</h1>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('SuperAdmin/backend.program_registration_free') </th>
                            <th> @lang('SuperAdmin/backend.program_duration') </th>
                            <th> @lang('SuperAdmin/backend.age_range') </th>
                            <th> @lang('SuperAdmin/backend.courier_fee') </th>
                            <th> @lang('SuperAdmin/backend.about_courier') </th>
                            <th> @lang('SuperAdmin/backend.program_cost') </th>

                            <th> @lang('SuperAdmin/backend.program_duration_start') </th>
                            <th> @lang('SuperAdmin/backend.program_duration_end') </th>
                            <th> @lang('SuperAdmin/backend.program_start_date') </th>
                            <th> @lang('SuperAdmin/backend.program_end_date') </th>
                            <th> @lang('SuperAdmin/backend.discount_per_week') </th>
                            <th> @lang('SuperAdmin/backend.discount_start_date') </th>

                            <th> @lang('SuperAdmin/backend.discount_end_date') </th>

                            <th> @lang("SuperAdmin/backend.x_week_selected") </th>
                            <th> @lang('SuperAdmin/backend.week_start_date')</th>
                            <th> @lang('SuperAdmin/backend.week_end_date')</th>
                            <th> @lang('SuperAdmin/backend.week_free')</th>
                            <th> @lang('SuperAdmin/backend.summer_fee_per_week')</th>
                            <th> @lang('SuperAdmin/backend.summer_fee_start_date')</th>
                            <th> @lang('SuperAdmin/backend.summer_fee_end_date')</th>

                            <th> @lang('SuperAdmin/backend.peak_time_fee_per_week')</th>
                            <th> @lang("SuperAdmin/backend.peak_time_start_date") </th>
                            <th> @lang("SuperAdmin/backend.peak_time_end_date") </th>
                            <th> @lang('SuperAdmin/backend.program_under_age_fee') </th>
                            <th> @lang("SuperAdmin/backend.action") </th>
                            <th> @lang("SuperAdmin/backend.created_on") </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course_programs as  $course_program)
                            <tr>
                                <td>{{$loop->iteration}}  </td>
                                <td>{{$course_program->program_registration_fee}}</td>

                                <td>{{$course_program->program_duration}}</td>
                                @if(is_array($course_program->program_age_range))
                                    <td>{{is_null($course_program->program_age_range) ? '-'  : implode(", ", $course_program->program_age_range)}}</td>
                                @else
                                    <td>{{$course_program->program_age_range}}</td>
                                @endif
                                <td>{{$course_program->courier_fee}}</td>
                                <td>{!! get_language() =='en' ?  $course_program->about_courier : $course_program->about_courier_ar !!}</td>
                                <td>{{$course_program->program_cost}}</td>
                                <td>{{$course_program->program_duration_start}}</td>
                                <td>{{$course_program->program_duration_end}}</td>

                                <td>{{$course_program->program_start_date}}</td>
                                <td>{{$course_program->program_end_date}}</td>
                                <td>{{$course_program->discount_per_week}}</td>
                                <td>{{$course_program->discount_start_date}}</td>
                                <td>{{$course_program->discount_end_date}}</td>
                                <td>{{$course_program->x_week_selected   }}</td>
                                <td>{{$course_program->x_week_start_date}}</td>
                                <td>{{$course_program->x_week_end_date}}</td>
                                <td>{{ $course_program->how_many_week_free }}</td>
                                <td>{{ $course_program->summer_fee_per_week }}</td>
                                <td>{{ $course_program->summer_fee_start_date }}</td>
                                <td>{{ $course_program->summer_fee_end_date }}</td>
                                <td>{{ $course_program->peak_time_fee_per_week  }}</td>
                                <td>{{ $course_program->peak_time_start_date }}</td>
                                <td>{{ $course_program->peak_time_end_date }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" type="button" href="{{route("superadmin.course_program_underage_details", $course_program->unique_id)}}">@lang("SuperAdmin/backend.click_here") </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        &nbsp;
                                        <a href="javascript:void(0)" onclick="tinymceInit();" data-toggle="modal"
                                        data-target="#edit_modal{{$course_program->unique_id}}" type="button"
                                        class="btn btn-primary btn-sm fa fa-pencil">
                                        </a>
                                        &nbsp;
                                        <a href="{{route('superadmin.course_program_delete', $course_program->unique_id)}}"
                                        type="button" class="btn btn-danger btn-sm fa fa-trash">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$course_program->created_at->diffForHumans()}}</td>
                            </tr>
                            <div class="modal fade" id="edit_modal{{$course_program->unique_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="exampleModalLabel5">@lang('SuperAdmin/backend.course_program_update')</h5>
                                            <button type="button" id="close_this" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="{{route('superadmin.course_program_update')}}" id ="submit_form">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_registration_free')</label>
                                                    <input hidden name="id" value="{{$course_program->unique_id}}">
                                                    <input type="number"
                                                        value="{{$course_program->program_registration_fee}}"
                                                        name="program_registration_fee" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_duration')</label>
                                                    <input type="number" value="{{$course_program->program_duration}}"
                                                        name="program_duration" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.age_range')</label>
                                                    <select type="text" multiple name="program_age_range" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Program_Age_Range::all() as $ages)
                                                            <option value="{{$ages->age}}" {{ in_array($ages->age, is_array($course_program->program_age_range) ? $course_program->program_age_range : [] ) ? 'selected' : '' }}>{{$ages->age}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.courier_fee')</label>
                                                    <input type="number" name="courier_fee"
                                                        value="{{$course_program->courier_fee}}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.about_courier') @lang('SuperAdmin/backend.in_english')</label>
                                                    <textarea id="about_couriers_textarea" class="form-control">{{$course_program->about_courier}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.about_courier') @lang('SuperAdmin/backend.in_arabic')</label>
                                                    <textarea id="inondhu" name="" class="form-control">{{$course_program->about_courier_ar}}</textarea>
                                                    <input hidden name="about_courier" value="" id="input_about_courier">
                                                    <input hidden name="about_courier_ar" value="" id="nandhu">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_cost') </label>
                                                    <input type="text" value="{{$course_program->program_cost}}"
                                                        name="program_cost" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_duration_start')</label>
                                                    <input type="text"
                                                        value="{{$course_program->program_duration_start}}"
                                                        name="program_duration_start" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_duration_end')</label>
                                                    <input type="number" value="{{$course_program->program_duration_end}}"
                                                        name="program_duration_end" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_start_week')</label>
                                                    <input type="date" name="program_start_date"
                                                        value="{{$course_program->program_start_date}}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.program_end_week')</label>
                                                    <input type="date" name="program_end_date"
                                                        value="{{$course_program->program_end_date}}"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.discount_per_week')</label>
                                                    <input type="text"
                                                        value="{{$course_program->discount_per_week}}"
                                                        name="discount_per_week" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.discount_start_date')</label>
                                                    <input type="date"
                                                        value="{{$course_program->discount_start_date}}"
                                                        name="discount_start_date" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.discount_end_date')</label>
                                                    <input type="date" value="{{$course_program->discount_end_date}}"
                                                        name="discount_end_date" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.x_week_selected')</label>
                                                    <input type="number" name="x_week_selected"
                                                        value="{{$course_program->x_week_selected}}"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.x_week_start_date')</label>
                                                    <input type="date" name="x_week_start_date" value="{{$course_program->x_week_start_date}}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.x_week_end_date')</label>
                                                    <input type="date" value="{{$course_program->x_week_end_date}}" name="x_week_end_date" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.how_many_week_free')</label>
                                                    <input type="number" value="{{$course_program->how_many_week_free}}" name="how_many_week_free" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.summer_fee_per_week')</label>
                                                    <input type="number" value="{{$course_program->summer_fee_per_week}}" name="summer_fee_per_week" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.summer_fee_start_date')</label>
                                                    <input type="date" name="summer_fee_start_date" value="{{$course_program->summer_fee_start_date}}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.summer_fee_end_date')</label>
                                                    <input type="date" name="summer_fee_end_date" value="{{$course_program->summer_fee_end_date}}" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.peak_time_fee_per_week')</label>
                                                    <input type="number" value="{{$course_program->peak_time_fee_per_week}}" name="peak_time_fee_per_week" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.peak_time_start_date')</label>
                                                    <input type="date" value="{{$course_program->peak_time_start_date}}" name="peak_time_start_date" class="form-control">
                                                </div>


                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.peak_time_end_date')</label>
                                                    <input type="date" value="{{$course_program->peak_time_end_date}}" name="peak_time_end_date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('SuperAdmin/backend.close') </button>
                                                <button id="magic" onclick="getContent('inondhu', 'nandhu'); submit_courseprogram($(this))" type="button"
                                                    class="btn btn-primary">@lang('SuperAdmin/backend.update_changes')</button>
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
<script>
    function submit_courseprogram(object){
        getContent('about_couriers_textarea', 'input_about_courier');

        var urlname = $(object).parents().find('#submit_form').attr('action');
        var formdata = new FormData($(object).parents().find('#submit_form')[0]);

        $.ajax({
            type: 'POST',
            url: urlname,
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                window.location.reload();
            }
        });
    }
</script>
@endsection