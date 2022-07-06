@extends('admin.layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">{{__('Admin/backend.course_accommodation_underage_details')}}</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Admin/backend.accommodation_underage')}}</th>
                            <th>{{ucwords(__('Admin/backend.under_age_fee_per_week'))}}}}</th>
                            <th>{{__("Admin/backend.created_on")}}</th>
                            <th>{{__("Admin/backend.action")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($underages as $underage)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{is_array($underage->under_age) && $underage->under_age != null ? implode(', ', $underage->under_age) : '-' ?? $underage->under_age}}</td>
                                <td>{{$underage->under_age_fee_per_week}}</td>
                                <td>{{$underage->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="btn-group">
                                        &nbsp;
                                        <a href ="javascript:void(0)" data-toggle="modal" data-target="#edit_modal{{$underage->id}}"  type="button" class ="btn btn-primary btn-sm fa fa-pencil"></a>
                                        @php $confirm = __('Admin/backend.are_you_sure_delete'); @endphp
                                        <a type="button" onclick="return confirm('<?= $confirm ?>')" href="{{ auth('superadmin')->check() ? route('superadmin.course_accommodation_under_age_delete', $underage->id) : route('schooladmin.course_accommodation_under_age_delete', $underage->id) }}" class="btn btn-sm btn-danger fa fa-trash"> </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit_modal{{$underage->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ auth('superadmin')->check() ? route('superadmin.course_accommodation_underage_edit') : route('schooladmin.course_accommodation_underage_edit') }}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{__('Admin/backend.edit_course_program_price')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('Admin/backend.close')}}">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <input hidden  name="id" value="{{$underage->id}}">
                                                <div class="form-group">
                                                    <label class="">{{__('Admin/backend.program_under_age_fee')}}</label>
                                                    <select name="under_age[]" multiple="multiple" class="form-control">
                                                        @foreach(\App\Models\SuperAdmin\Choose_Accommodation_Under_Age::all() as $undesr_age)
                                                            <option multiple="" value="{{$undesr_age->age}}" {{in_array($undesr_age->age, $underage->under_age) ? 'selected' : ''}} >{{$undesr_age->age }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{ucwords(__('Admin/backend.under_age_fee_per_week'))}}</label>
                                                    <input type="number" class="form-control" name="under_age_fee_per_week" value="{{$underage->under_age_fee_per_week}}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-info">{{__('Admin/backend.close')}}</button>
                                                <input type="hidden" id="getvalue" name="formvalue">
                                                <button type="submit" class="btn btn-success">{{__('Admin/backend.submit')}}</button>
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