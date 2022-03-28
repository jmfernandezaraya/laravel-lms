@extends('superadmin.layouts.app')
@section('content')
    @include('superadmin.courses.scripts')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.accommodation_cost')}}</h1>
                    <change>
                        @if(app()->getLocale() == 'en')
                            {{__('SuperAdmin/backend.in_english')}}
                        @endif
                        @if(app()->getLocale() == 'ar')
                            {{__('SuperAdmin/backend.in_arabic')}}
                        @endif
                    </change>
                </div>
                @include('superadmin.include.alert')
                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="current_page_item selected">
                            <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                                <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                                <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}
                            </a>
                        </li>
                    </ul>
                </div>

                <div id="show_form"></div>

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.update", $course_id)}}" id="courseform">
                    {{csrf_field()}}
                    @method("PUT")
                    <div class="first-form">
                        @php $loopnum = ''; @endphp
                        @forelse($accomodations as $accommodation)
                            <div id="accommodation_clone{{$loop->iteration - 1}}" class="accommodation-clone clone">
                                @php
                                    $loopnum .= ",";
                                    $loopnum .= $loop->iteration - 1;
                                @endphp
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.accommodation')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.accommodation_id')}}:</label>
                                        <input readonly class="form-control" value="{{$accommodation->unique_id}}" type="text" id="accommodation_id{{$loop->iteration - 1}}" name="accommodation_id[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="type">{{__('SuperAdmin/backend.type')}}:</label>
                                        <input value="{{$accommodation->type}}" class="form-control" type="text" name="type[]" placeholder="{{__('SuperAdmin/backend.type')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.room_type')}}:</label>
                                        <input class="form-control" value="{{$accommodation->room_type}}" type="text" name="room_type[]" placeholder="{{__('SuperAdmin/backend.room_type')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.meal')}}:</label>
                                        <input class="form-control" type="text"  value="{{$accommodation->meal}}" name="meal[]" placeholder="{{__('SuperAdmin/backend.meal')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 age_range">
                                        <label for="age_range">{{__('SuperAdmin/backend.age_range')}} :
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccommodationAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select id="accom_age_choose{{$loop->iteration - 1}}" name="age_range[{{$loop->iteration - 1}}][]" multiple="multiple" class="3col active">
                                            @foreach($accommodation_age_ranges as $accommodation_age_range)
                                                <option {{in_array($accommodation_age_range->unique_id, (array)$accommodation->age_range ?? []) ? 'selected' : ''}} value="{{$accommodation_age_range->unique_id}}">{{$accommodation_age_range->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.placement_fee')}}:</label>
                                        <input value="{{$accommodation->placement_fee}}" class="form-control" type="number" name="placement_fee[]" placeholder="{{__('SuperAdmin/backend.placement_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input value="{{$accommodation->program_duration}}" class="form-control" type="number" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.deposit_fee')}}:</label>
                                        <input value="{{$accommodation->deposit_fee}}" class="form-control" type="number" name="deposit_fee[]" placeholder="{{__('SuperAdmin/backend.deposit_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_fee')}}:</label>
                                        <input value="{{$accommodation->custodian_fee}}" class="form-control" type="number" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.custodian_fee')}}">
                                    </div>
                                    <div class="form-group col-md-4 age_range_for_custodian">
                                        <label>
                                            {{__('SuperAdmin/backend.custodian_age_range')}}
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeAcoomModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommCustodianAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>

                                        <select name="age_range_for_custodian[{{$loop->iteration - 1}}][]" id="custodian_age_range_choose{{$loop->iteration - 1}}" multiple="multiple" class="3col active">
                                            @foreach($custodian_under_ages as $custodian_under_age)
                                                <option {{in_array($custodian_under_age->unique_id, (array)$accommodation->custodian_age_range ?? []) ? 'selected' : ''}} value="{{$custodian_under_age->unique_id}}">{{$custodian_under_age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_condition')}}:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="radio" name="custodian_condition[]" {{$accommodation->custodian_condition ? 'required' : ''}}>&nbsp;
                                                <label>{{__('SuperAdmin/backend.required')}}</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="radio" name="custodian_condition[]" {{$accommodation->custodian_condition ? 'optional' : ''}}>&nbsp;
                                                <label>{{__('SuperAdmin/backend.optional')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.special_diet_fee')}}:</label>
                                        <input value="{{$accommodation->special_diet_fee}}" class="form-control" type="number" name="special_diet_fee[]" placeholder="{{__('SuperAdmin/backend.special_diet_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.special_diet_note')}}:</label>
                                        <textarea class="form-control" name="special_diet_note[]" id="special_diet_note{{$loop->iteration - 1}}" placeholder="{{__('SuperAdmin/backend.special_diet_note')}}">{!! $accommodation->special_diet_note !!}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.fee_per_week')}}:</label>
                                        <input class="form-control" type="number" name="fee_per_week[]" value="{{$accommodation->fee_per_week }}"  placeholder="{{__('SuperAdmin/backend.fee')}} ">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.start_week')}}:</label>
                                        <input class="form-control" type="number" name="start_week[]" value="{{$accommodation->start_week }}"  placeholder="{{__('SuperAdmin/backend.duration_start')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.end_week')}}:</label>
                                        <input class="form-control" type="number" name="end_week[]" value="{{$accommodation->end_week }}"  placeholder="{{__('SuperAdmin/backend.duration_end')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input value="{{$accommodation->start_date }}" class="form-control" type="date" name="start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input value="{{$accommodation->end_date }}" class="form-control" type="date" name="end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input value="{{ isset(explode(" ", $accommodation->discount_per_week)[0]) ?? '' }}" class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_symbol')}}:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            @php
                                                $symbol = isset(explode(" ", $accommodation->discount_per_week)[1]) ? explode(" ", $accommodation->discount_per_week)[1] : '';
                                            @endphp
                                            <option {{ $symbol == "%" ? 'selected' : ''}} value="%">%</option>
                                            <option {{$symbol == "-" ? 'selected' :'' }} value = '-'>-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_start_date')}}:</label>
                                        <input value="{{$accommodation->discount_start_date }}" class="form-control" type="date" name="discount_start_date[]">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_end_date')}}:</label>
                                        <input  value="{{$accommodation->discount_end_date }}" class="form-control" type="date" name="discount_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_per_week')}}:</label>
                                        <input value="{{$accommodation->summer_fee_per_week }}" class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_start_date')}}:</label>
                                        <input value="{{$accommodation->summer_fee_start_date }}" class="form-control" type="date" name="summer_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_end_date')}}:</label>
                                        <input value="{{$accommodation->summer_fee_end_date }}" class="form-control" type="date" name="summer_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_fee_per_week')}}:</label>
                                        <input value="{{$accommodation->fee_per_week }}" class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_start_date')}}:</label>
                                        <input value="{{$accommodation->peak_time_fee_per_week }}" class="form-control" type="date" name="peak_time_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_end_date')}}:</label>
                                        <input value="{{$accommodation->peak_time_fee_start_date }}" class="form-control" type="date" name="peak_time_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_fee')}}:</label>
                                        <input value="{{$accommodation->christmas_fee_per_week }}" class="form-control" type="number" name="christmas_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.christmas_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_start_fee')}}:</label>
                                        <input value="{{$accommodation->christmas_fee_start_date }}" class="form-control" type="date" name="christmas_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_end_fee')}}:</label>
                                        <input value="{{$accommodation->christmas_fee_end_date }}" class="form-control" type="date" name="christmas_fee_end_date[]">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addAccommodationForm($(this))"></button>
                                    </div>
                                    <div class="pull-rights">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteAccommodationForm($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="accommodation_clone0" class="accommodation-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.accommodation')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.accommodation_id')}}:</label>
                                        <input readonly class="form-control" value="{{time() . rand(00,99)}}" type="text" id="accommodation_id0" name="accommodation_id[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="type">{{__('SuperAdmin/backend.type')}}:</label>
                                        <input class="form-control" type="text" name="type[]" placeholder="{{__('SuperAdmin/backend.type')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.room_type')}}:</label>
                                        <input class="form-control" type="text" name="room_type[]" placeholder="{{__('SuperAdmin/backend.room_type')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.meal')}}:</label>
                                        <input class="form-control" type="text" name="meal[]" placeholder="{{__('SuperAdmin/backend.meal')}}">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-4 age_range">
                                        <label for="age_range">{{__('SuperAdmin/backend.age_range')}} :
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccommodationAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select id="accom_age_choose0" name="age_range[0][]" multiple="multiple" class="3col active">
                                            @foreach($accommodation_age_ranges as $accommodation_age_range)
                                                <option value="{{$accommodation_age_range->unique_id}}">{{$accommodation_age_range->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.placement_fee')}}:</label>
                                        <input class="form-control" type="number" name="placement_fee[]" placeholder="{{__('SuperAdmin/backend.placement_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input class="form-control" type="number" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.deposit_fee')}}:</label>
                                        <input class="form-control" type="number" name="deposit_fee[]" placeholder="{{__('SuperAdmin/backend.deposit_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_fee')}}:</label>
                                        <input value="{{$accommodation->custodian_fee}}" class="form-control" type="number" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.custodian_fee')}}">
                                    </div>
                                    <div class="form-group col-md-4 age_range_for_custodian">
                                        <label>
                                            {{__('SuperAdmin/backend.custodian_age_range')}}
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeAcoomModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommCustodianAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>

                                        <select id="custodian_age_range_choose0" name="age_range_for_custodian[0][]" multiple="multiple" class="3col active">
                                            @foreach($custodian_under_ages as $custodian_under_age)
                                                <option value="{{$custodian_under_age->unique_id}}">{{$custodian_under_age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_condition')}}:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="radio" name="custodian_condition[]">&nbsp;
                                                <label>{{__('SuperAdmin/backend.required')}}</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="radio" name="custodian_condition[]">&nbsp;
                                                <label>{{__('SuperAdmin/backend.optional')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.special_diet_fee')}}:</label>
                                        <input class="form-control" type="number" name="special_diet_fee[]" placeholder="{{__('SuperAdmin/backend.special_diet_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.special_diet_note')}}:</label>
                                        <textarea class="form-control" name="special_diet_note[]" id="special_diet_note0" placeholder="{{__('SuperAdmin/backend.special_diet_note')}}"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.fee_per_week')}}:</label>
                                        <input class="form-control" type="number" name="fee_per_week[]" placeholder="{{__('SuperAdmin/backend.fee_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.start_week')}}:</label>
                                        <input class="form-control" type="number" name="start_week[]" placeholder="{{__('SuperAdmin/backend.duration_start')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.end_week')}}:</label>
                                        <input class="form-control" type="number" name="end_week[]" placeholder="{{__('SuperAdmin/backend.duration_end')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input class="form-control" type="date" name="start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input class="form-control" type="date" name="end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Accommodation-symbol:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            <option>%</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_start_date')}}:</label>
                                        <input class="form-control" type="date" name="discount_start_date[]">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_end_date')}}:</label>
                                        <input class="form-control" type="date" name="discount_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_per_week')}}:</label>
                                        <input class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_start_date')}}:</label>
                                        <input class="form-control" type="date" name="summer_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_end_date')}}:</label>
                                        <input class="form-control" type="date" name="summer_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_fee_per_week')}}:</label>
                                        <input class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_start_date')}}:</label>
                                        <input class="form-control" type="date" name="peak_time_fee_start_date[]" placeholder="{{__('SuperAdmin/backend.peak_time_start_date')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_end_date')}}:</label>
                                        <input class="form-control" type="date" name="peak_time_fee_end_date[]" placeholder="{{__('SuperAdmin/backend.peak_time_end_date')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_fee')}}:</label>
                                        <input class="form-control" type="number" name="christmas_fee_per_week[]"
                                            placeholder="{{__('SuperAdmin/backend.christmas_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_start_fee')}}:</label>
                                        <input class="form-control" type="date" name="christmas_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_end_fee')}}:</label>
                                        <input class="form-control" type="date" name="christmas_fee_end_date[]">
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addAccommodationForm($(this))"></button>
                                    </div>
                                    <div class="pull-rights">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteAccommodationForm($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @endforelse

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="getAccommodationContents(); addAccommodation($(this))">{{__('SuperAdmin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                <a href="{{route('superadmin.course.accomm_under_age.edit')}}" class="btn btn-primary pull-right" type="button">{{__('SuperAdmin/backend.next')}}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('superadmin.courses.modals')
@endsection