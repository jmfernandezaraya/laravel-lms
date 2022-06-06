@extends('schooladmin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.accommodation_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('SuperAdmin/backend.accommodation_type') </th>
                            <th> @lang('SuperAdmin/backend.room_type') </th>
                            <th> @lang('SuperAdmin/backend.meal_type') </th>
                            <th> @lang('SuperAdmin/backend.age_range') </th>
                            <th> @lang('SuperAdmin/backend.accommodation_placement_fee') </th>
                            <th> @lang('SuperAdmin/backend.program_duration') </th>
                            <th> @lang('SuperAdmin/backend.accommodation_deposit_fee') </th>

                            <th> @lang('SuperAdmin/backend.special_diet_fee') </th>
                            <th> @lang('SuperAdmin/backend.special_diet_note') </th>

                            <th> @lang('SuperAdmin/backend.accommodation_fee') </th>
                            <th> @lang('SuperAdmin/backend.accommodation_start_week') </th>
                            <th> @lang('SuperAdmin/backend.accommodation_end_week') </th>
                            <th> @lang('SuperAdmin/backend.accommodation_start_date')</th>
                            <th> @lang('SuperAdmin/backend.accommodation_end_date')</th>

                            <th> @lang('SuperAdmin/backend.discount_per_week') </th>
                            <th> @lang('SuperAdmin/backend.discount_start_date') </th>

                            <th> @lang('SuperAdmin/backend.discount_end_date') </th>
                            <th> @lang('SuperAdmin/backend.summer_fee_per_week') </th>
                            <th> @lang('SuperAdmin/backend.summer_fee_start_date') </th>
                            <th> @lang('SuperAdmin/backend.summer_fee_end_date') </th>
                            <th> @lang('SuperAdmin/backend.peak_time_fee_per_week') </th>
                            <th> @lang('SuperAdmin/backend.peak_time_start_date') </th>

                            <th> @lang('SuperAdmin/backend.peak_time_end_date') </th>

                            <th> @lang('SuperAdmin/backend.christmas_fee_per_week') </th>
                            <th> @lang('SuperAdmin/backend.christmas_start_date')</th>

                            <th> @lang('SuperAdmin/backend.christmas_end_date')</th>
                            <th> @lang("SuperAdmin/backend.created_on") </th>
                            <th> @lang('SuperAdmin/backend.accommodation_underage') </th>
                            <th> @lang("SuperAdmin/backend.action") </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accomodations as  $accomodation)
                            <tr>
                                <td>{{$loop->iteration}}  </td>
                                <td>{{$accomodation->type}}</td>
                                <td>{{$accomodation->room_type}}</td>
                                <td>{{$accomodation->meal}}</td>
                                <td>{{ is_null($accomodation->age_range) ? '-' : implode(", ", $accomodation->age_range) ?? $accomodation->age_range}}</td>
                                <td>{{$accomodation->placement_fee}}</td>
                                <td>{{$accomodation->program_duration}}</td>
                                <td>{{$accomodation->deposit_fee}}</td>
                                <td>{{$accomodation->special_diet_fee}}</td>
                                <td>{!! $accomodation->special_diet_note !!}</td>
                                <td>{{$accomodation->fee_per_week}}</td>
                                <td>{{$accomodation->start_week}}</td>
                                <td>{{$accomodation->end_week}}</td>
                                <td>{{$accomodation->start_date}}</td>

                                <td>{{$accomodation->end_date}}</td>
                                <td>{{$accomodation->discount_per_week}} </td>
                                <td>{{$accomodation->discount_start_date}}</td>
                                <td>{{$accomodation->discount_end_date}}</td>

                                <td>{{$accomodation->summer_fee_per_week}}</td>
                                <td>{{$accomodation->summer_fee_start_date}}</td>
                                <td>{{$accomodation->summer_fee_end_date}}</td>
                                <td>{{$accomodation->peak_time_fee_per_week}}</td>

                                <td>{{$accomodation->peak_time_fee_start_date}}</td>
                                <td>{{$accomodation->peak_time_fee_end_date}}</td>
                                <td>{{$accomodation->christmas_fee_per_week}}</td>
                                <td>{{$accomodation->christmas_fee_start_date}}</td>

                                <td>{{$accomodation->christmas_fee_end_date}}</td>

                                <td>{{$accomodation->created_at->diffForHumans()}}</td>
                                <td>
                                    @if(!($accomodation->AccommodationUnderAges()->get()->isEmpty()))
                                        <a type="button" href="{{route('superadmin.accomodation_underage_details', $accomodation->unique_id)}}" class="btn btn-sm btn-primary">@lang('SuperAdmin/backend.click_here')</a>
                                    @else
                                        {{__('SuperAdmin/backend.no_details_available')}}
                                    @endif
                                </td>
                                <td>
                                    <div class ="btn-group">
                                        <a type="button" data-toggle="modal" onclick="tinymceInit()" data-target="#edit_modal{{$accomodation->unique_id}}" class="btn btn-sm btn-primary fa fa-pencil"> </a>
                                        @php
                                            $confirm = __('SuperAdmin/backend.are_you_sure_delete');
                                        @endphp
                                        <a type="button" onclick="return confirm('<?= $confirm ?>')" href="{{route('superadmin.airport_delete', $accomodation->unique_id)}}" class="btn btn-sm btn-danger fa fa-trash"> </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit_modal{{$accomodation->unique_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('superadmin.accommodation_update')}}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('SuperAdmin/backend.update_accommodation_price')</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <input hidden name="id" value="{{$accomodation->unique_id}}" >

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_type')}}</label>
                                                    <input type="text" class="form-control" name='type' value="{{$accomodation->type}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.room_type')}}</label>
                                                    <input type="text" class="form-control" name='room_type' value="{{$accomodation->room_type}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.meal')}}</label>
                                                    <input type="text" class="form-control" name='meal' value="{{$accomodation->meal}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.special_diet_fee')}}</label>
                                                    <input type="number" class="form-control" name='special_diet_fee' value="{{$accomodation->special_diet_fee}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_type')}}</label>
                                                    <select name="age_range[]" class="form-control" >
                                                        @foreach(\App\Models\SuperAdmin\Choose_Accommodation_Age_Range::all() as $ages)
                                                            <option value="{{$ages->age}}" {{in_array($ages->age, (array)$accomodation->age_range) ? 'selected' : ''}} >{{$ages->age }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_placement_fee')}}</label>
                                                    <input type="text" class="form-control" name='placement_fee' value="{{$accomodation->placement_fee}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.program_duration')}}</label>
                                                    <input type="number" class="form-control" name='program_duration' value="{{$accomodation->program_duration}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_deposit_fee')}}</label>
                                                    <input type="text" class="form-control" name='deposit_fee' value="{{$accomodation->deposit_fee}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.special_diet_note')}} {{__('SuperAdmin/backend.in_english')}} </label>
                                                    <textarea id="textarea_en">{{$accomodation->special_diet_note}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.special_diet_note')}} {{__('SuperAdmin/backend.in_arabic')}}</label>
                                                    <textarea id="textarea_ar">{{$accomodation->special_diet_note_ar}}</textarea>
                                                </div>

                                                <input hidden name="special_diet_note" id ="input_ar">

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_fee')}}</label>
                                                    <input type="number" class="form-control" name='fee_per_week' value="{{$accomodation->fee_per_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_start_week')}}</label>
                                                    <input type="number" class="form-control" name='start_week' value="{{$accomodation->start_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_end_week')}}</label>
                                                    <input type="number" class="form-control" name='end_week' value="{{$accomodation->end_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_start_date')}}</label>
                                                    <input type="date" class="form-control" name='start_date' value="{{$accomodation->start_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.accommodation_end_date')}}</label>
                                                    <input type="date" class="form-control" name='end_date' value="{{$accomodation->end_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.discount_per_week')}}</label>
                                                    <input type="number" class="form-control" name='discount_per_week' value="{{explode(" ", $accomodation->discount_per_week)[0]}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.discount_symbol')}}</label>
                                                    <input type="text" class="form-control" name='discount_per_week_symbol' value="{{explode(" ", $accomodation->discount_per_week)[1]}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.discount_start_date')}}</label>
                                                    <input type="date" class="form-control" name='discount_start_date' value="{{$accomodation->discount_start_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.discount_end_date')}}</label>
                                                    <input type="date" class="form-control" name='discount_end_date' value="{{$accomodation->discount_end_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.summer_fee_per_week')}}</label>
                                                    <input type="number" class="form-control" name='summer_fee_per_week' value="{{$accomodation->summer_fee_per_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.summer_fee_start_date')}}</label>
                                                    <input type="date" class="form-control" name='summer_fee_start_date' value="{{$accomodation->summer_fee_start_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.summer_fee_end_date')}}</label>
                                                    <input type="date" class="form-control" name='summer_fee_end_date' value="{{$accomodation->summer_fee_end_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.peak_time_fee_per_week')}}</label>
                                                    <input type="number" class="form-control" name='peak_time_fee_per_week' value="{{$accomodation->peak_time_fee_per_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.peak_time_start_date')}}</label>
                                                    <input type="date" class="form-control" name='peak_time_fee_start_date' value="{{$accomodation->peak_time_fee_start_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.peak_time_end_date')}}</label>
                                                    <input type="date" class="form-control" name='peak_time_fee_end_date' value="{{$accomodation->peak_time_fee_end_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.christmas_fee_per_week')}}</label>
                                                    <input type="number" class="form-control" name='christmas_fee_per_week' value="{{$accomodation->christmas_fee_per_week}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.christmas_fee_start_date')}}</label>
                                                    <input type="date" class="form-control" name='christmas_fee_start_date' value="{{$accomodation->christmas_fee_start_date}}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="">{{__('SuperAdmin/backend.christmas_fee_end_date')}}</label>
                                                    <input type="date" class="form-control" name='christmas_fee_end_date' value="{{$accomodation->christmas_fee_end_date}}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-info">Close</button>
                                                <input type="hidden" id="getvalue" name="formvalue">
                                                <button onclick="getContent('textarea_ar', 'input_ar'); getContent('textarea_en', 'input_en')" type="submit" class="btn btn-success">Submit</button>
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