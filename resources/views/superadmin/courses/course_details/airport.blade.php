@extends('superadmin.layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">@lang('SuperAdmin/backend.airport_details')</h1>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('SuperAdmin/backend.airport_name') </th>
                            <th> @lang('SuperAdmin/backend.airport_service_name') </th>
                            <th> @lang('SuperAdmin/backend.service_fee') </th>
                            <th> {{ucwords( __('SuperAdmin/backend.x_week_selected')) }}  </th>
                            <th> @lang("SuperAdmin/backend.created_on") </th>
                            <th> @lang("SuperAdmin/backend.action") </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($airports as  $airport)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$airport->{'airport_name_'.get_language() } }}</td>
                                <td>{{$airport->{'airport_service_name_'.get_language()}}}</td>
                                <td>{{$airport->service_fee}}</td>
                                <td>{{$airport->week_selected_fee}}</td>
                                <td>{{$airport->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class ="btn-group">
                                        <form method="post" action="{{route('superadmin.course.airport.delete', $airport->unique_id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('{{__('SuperAdmin/backend.are_you_sure_delete')}}')" class="btn btn-danger btn-sm fa fa-trash"></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="airport_modal{{$airport->unique_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel5">@lang('SuperAdmin/backend.update_airport_fees')</h5>
                                            <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post"  action="{{route('superadmin.airport_update')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.airport_name') @lang('SuperAdmin/backend.in_english')</label>
                                                    <input hidden name="id" value="{{$airport->unique_id}}">
                                                    <input type="text" value="{{$airport->name_en}}" name="name_en" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.airport_name') @lang('SuperAdmin/backend.in_arabic')</label>
                                                    <input type="text" value="{{$airport->name_ar}}" name="name_ar" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.airport_service_name') @lang('SuperAdmin/backend.in_english')</label>
                                                    <input type="text" value="{{$airport->service_name_en}}" name="service_name_en" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.airport_service_name') @lang('SuperAdmin/backend.in_arabic')</label>
                                                    <input type="text" value="{{$airport->service_name_ar}}" name="service_name_ar" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.service_fee')</label>
                                                    <input type="text" value="{{$airport->service_fee}}" name="service_fee" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>@lang('SuperAdmin/backend.x_week_selected')</label>
                                                    <input type="text" name="week_selected_fee" value="{{$airport->week_selected_fee}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('SuperAdmin/backend.close')</button>
                                                <button type="submit" class="btn btn-primary">@lang('SuperAdmin/backend.update_changes')</button>
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