@extends('branchadmin.layouts.app')

<style>
    .multiselect
    {
        color:#fff;
        background-color: #fff;
        display: none;
    }
</style>

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.course_program_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('SuperAdmin/backend.program_under_age_fee') </th>
                            <th> {{ucwords(__('SuperAdmin/backend.underage_fee_per_week'))}} </th>
                            <th> @lang("SuperAdmin/backend.created_on") </th>
                            <th> @lang("SuperAdmin/backend.action") </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as  $program)
                            <tr>
                                <td>{{$loop->iteration}}  </td>
                                <td>{{is_array($program->under_age) && $program->under_age != null ? implode(', ', $program->under_age) : '-'}}</td>
                                <td>{{$program->underage_fee_per_week}}</td>
                                <td>{{$program->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="btn-group">
                                        &nbsp;
                                        <a href ="javascript:void(0)" data-toggle="modal" data-target="#program_under_age_edit{{$program->id}}"  type="button" class ="btn btn-primary btn-sm fa fa-pencil"></a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="program_under_age_edit{{$program->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('superadmin.course_program_edit')}}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('SuperAdmin/backend.edit_course_program_price')</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <input hidden  name="id" value="{{$program->id}}" >
                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.program_under_age_fee')}}</label>
                                                    <select name="under_age[]" multiple="multiple" class="form-control" >
                                                        @foreach(\App\Models\SuperAdmin\Choose_Program_Age_Range::all() as $under_age)
                                                            <option multiple="" value="{{$under_age->age}}" {{in_array($under_age->age, $program->under_age) ? 'selected' : ''}} >{{$under_age->age }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{ucwords(__('SuperAdmin/backend.underage_fee_per_week'))}}</label>
                                                    <input type="number" class="form-control" name="under_age_fee_per_week" value="{{$program->underage_fee_per_week}}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-info">Close</button>
                                                <input type="hidden" id="getvalue" name="formvalue">
                                                <button type="submit" class="btn btn-success">Submit</button>
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