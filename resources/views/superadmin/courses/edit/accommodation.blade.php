@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.accommodation_cost')}}
@endsection

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
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                <div id="show_form"></div>

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.update", $course_id)}}" id="courseform">
                    {{csrf_field()}}
                    @method("PUT")
                    <div class="first-form">
                        <script>
                            window.addEventListener('load', function() {
                                accommodation_clone = {{$accomodations && $accomodations->count() ? $accomodations->count() - 1 : 0}};
                            }, false );
                        </script>

                        @forelse($accomodations as $accommodation)
                            <div id="accommodation_clone{{ $loop->iteration - 1 }}" class="accommodation-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.accommodation')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.accommodation_id')}}:</label>
                                        <input readonly class="form-control" value="{{ $accommodation->unique_id }}" type="text" id="accommodation_id{{ $loop->iteration - 1 }}" name="accommodation_id[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="type">{{__('SuperAdmin/backend.type')}}:</label>
                                        <div class="english">
                                            <input value="{{ $accommodation->type }}" class="form-control" type="text" name="type[]" placeholder="{{__('SuperAdmin/backend.type')}}">
                                        </div>
                                        <div class="arabic">
                                            <input value="{{ $accommodation->type_ar }}" class="form-control" type="text" name="type_ar[]" placeholder="{{__('SuperAdmin/backend.type')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.room_type')}}:</label>
                                        <div class="english">
                                            <input class="form-control" value="{{ $accommodation->room_type }}" type="text" name="room_type[]" placeholder="{{__('SuperAdmin/backend.room_type')}}">
                                        </div>
                                        <div class="arabic">
                                            <input class="form-control" value="{{ $accommodation->room_type_ar }}" type="text" name="room_type_ar[]" placeholder="{{__('SuperAdmin/backend.room_type')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.meal')}}:</label>
                                        <div class="english">
                                            <input class="form-control" type="text" value="{{ $accommodation->meal }}" name="meal[]" placeholder="{{__('SuperAdmin/backend.meal')}}">
                                        </div>
                                        <div class="arabic">
                                            <input class="form-control" type="text" value="{{ $accommodation->meal_ar }}" name="meal_ar[]" placeholder="{{__('SuperAdmin/backend.meal')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 age_range">
                                        <label for="age_range">{{__('SuperAdmin/backend.age_range')}} :
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccommodationAgeRangeModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select id="accom_age_choose{{ $loop->iteration - 1 }}" name="age_range[{{ $loop->iteration - 1 }}][]" multiple="multiple" class="3col active">
                                            @foreach($accommodation_age_ranges as $accommodation_age_range)
                                                <option {{in_array($accommodation_age_range->unique_id, (array)$accommodation->age_range ?? []) ? 'selected' : ''}} value="{{ $accommodation_age_range->unique_id }}">{{ $accommodation_age_range->age }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.placement_fee')}}:</label>
                                        <input value="{{ $accommodation->placement_fee }}" class="form-control" type="number" name="placement_fee[]" placeholder="{{__('SuperAdmin/backend.placement_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.program_duration')}}:</label>
                                        <input value="{{ $accommodation->program_duration }}" class="form-control" type="number" name="program_duration[]" placeholder="{{__('SuperAdmin/backend.if_program_duration')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.deposit_fee')}}:</label>
                                        <input value="{{ $accommodation->deposit_fee }}" class="form-control" type="number" name="deposit_fee[]" placeholder="{{__('SuperAdmin/backend.deposit_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_fee')}}:</label>
                                        <input value="{{ $accommodation->custodian_fee }}" class="form-control" type="number" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.custodian_fee')}}">
                                    </div>
                                    <div class="form-group col-md-4 age_range_for_custodian">
                                        <label>
                                            {{__('SuperAdmin/backend.custodian_age_range')}}
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeAcoomModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommCustodianAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>

                                        <select name="age_range_for_custodian[{{ $loop->iteration - 1 }}][]" id="custodian_age_range_choose{{ $loop->iteration - 1 }}" multiple="multiple" class="3col active">
                                            @foreach($custodian_under_ages as $custodian_under_age)
                                                <option {{in_array($custodian_under_age->unique_id, (array)$accommodation->custodian_age_range ?? []) ? 'selected' : ''}} value="{{ $custodian_under_age->unique_id }}">{{ $custodian_under_age->age }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_condition')}}:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="radio" value="required" name="custodian_condition[{{ $loop->iteration - 1 }}]" {{$accommodation->custodian_condition == 'required' ? 'checked' : ''}}>&nbsp;
                                                <label>{{__('SuperAdmin/backend.required')}}</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="radio" value="optional" name="custodian_condition[{{ $loop->iteration - 1 }}]" {{$accommodation->custodian_condition == 'optional' ? 'checked' : ''}}>&nbsp;
                                                <label>{{__('SuperAdmin/backend.optional')}}</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="radio" value="invisible" name="custodian_condition[{{ $loop->iteration - 1 }}]" {{$accommodation->custodian_condition == 'invisible' ? 'checked' : ''}}>&nbsp;
                                                <label>{{__('SuperAdmin/backend.invisible')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.special_diet_fee')}}:</label>
                                        <input value="{{ $accommodation->special_diet_fee }}" class="form-control" type="number" name="special_diet_fee[]" placeholder="{{__('SuperAdmin/backend.special_diet_fee')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.special_diet_note')}}:</label>
                                        <div class="english">
                                            <textarea class="form-control" name="special_diet_note[]" placeholder="{{__('SuperAdmin/backend.special_diet_note')}}" id="special_diet_note{{ $loop->iteration - 1 }}">{!! $accommodation->special_diet_note !!}</textarea>
                                        </div>
                                        <div class="arabic">
                                            <textarea class="form-control" name="special_diet_note_ar[]" placeholder="{{__('SuperAdmin/backend.special_diet_note')}}" id="special_diet_note_ar{{ $loop->iteration - 1 }}">{!! $accommodation->special_diet_note_ar !!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.fee_per_week')}}:</label>
                                        <input value="{{ $accommodation->fee_per_week }}" class="form-control" type="number" name="fee_per_week[]" placeholder="{{__('SuperAdmin/backend.fee')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.start_week')}}:</label>
                                        <input value="{{ $accommodation->start_week }}" class="form-control" type="number" name="start_week[]" placeholder="{{__('SuperAdmin/backend.duration_start')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.end_week')}}:</label>
                                        <input value="{{ $accommodation->end_week }}" class="form-control" type="number" name="end_week[]" placeholder="{{__('SuperAdmin/backend.duration_end')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.available_dates')}}:</label>
                                        <select class="form-control available_date" name="available_date[]">
                                            <option value="all_year_round" {{$accommodation->available_date == 'all_year_round' ? 'selected' : ''}}>{{__('SuperAdmin/backend.all_year_round')}}</option>
                                            <option value="selected_dates" {{$accommodation->available_date == 'selected_dates' ? 'selected' : ''}}>{{__('SuperAdmin/backend.selected_dates')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 available_days" {{$accommodation->available_date == 'all_year_round' ? 'style=display:none' : ''}}>
                                        <label>{{__('SuperAdmin/backend.available_days')}}:</label>
                                        <input class="form-control available_days yeardatepicker" data-index="{{ $loop->iteration - 1 }}" value="{{$accommodation->available_days}}" name="available_days[]">
                                    </div>
                                    <div class="form-group col-md-4 start_date" {{$accommodation->available_date == 'selected_dates' ? 'style=display:none' : ''}}>
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input value="{{ $accommodation->start_date }}" class="form-control" type="date" name="start_date[]">
                                    </div>
                                    <div class="form-group col-md-4 end_date" {{$accommodation->available_date == 'selected_dates' ? 'style=display:none' : ''}}>
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input value="{{ $accommodation->end_date }}" class="form-control" type="date" name="end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    @php $accommodation_discounts = explode(" ", $accommodation->discount_per_week); @endphp
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input value="{{ isset($accommodation_discounts[0]) ? $accommodation_discounts[0] : '' }}" class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_symbol')}}:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            @php
                                                $symbol = isset($accommodation_discounts[1]) ? $accommodation_discounts[1] : '';
                                            @endphp
                                            <option {{ $symbol == "%" ? 'selected' : '' }} value="%">%</option>
                                            <option {{ $symbol == "-" ? 'selected' : '' }} value='-'>-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_start_date')}}:</label>
                                        <input value="{{ $accommodation->discount_start_date }}" class="form-control" type="date" name="discount_start_date[]">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_end_date')}}:</label>
                                        <input  value="{{ $accommodation->discount_end_date }}" class="form-control" type="date" name="discount_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_per_week')}}:</label>
                                        <input value="{{ $accommodation->summer_fee_per_week }}" class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.summer_fee_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_start_date')}}:</label>
                                        <input value="{{ $accommodation->summer_fee_start_date }}" class="form-control" type="date" name="summer_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.summer_fee_end_date')}}:</label>
                                        <input value="{{ $accommodation->summer_fee_end_date }}" class="form-control" type="date" name="summer_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_fee_per_week')}}:</label>
                                        <input value="{{ $accommodation->peak_time_fee_per_week }}" class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.peak_time_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_start_date')}}:</label>
                                        <input value="{{ $accommodation->peak_time_start_date }}" class="form-control" type="date" name="peak_time_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.peak_time_end_date')}}:</label>
                                        <input value="{{ $accommodation->peak_time_end_date }}" class="form-control" type="date" name="peak_time_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_fee')}}:</label>
                                        <input value="{{ $accommodation->christmas_fee_per_week }}" class="form-control" type="number" name="christmas_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.christmas_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_start_fee')}}:</label>
                                        <input value="{{ $accommodation->christmas_fee_start_date }}" class="form-control" type="date" name="christmas_fee_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.christmas_end_fee')}}:</label>
                                        <input value="{{ $accommodation->christmas_fee_end_date }}" class="form-control" type="date" name="christmas_fee_end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_selected')}}:</label>
                                        <input value="{{ $accommodation->x_week_selected }}" class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('SuperAdmin/backend.every_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.free_week')}}:</label>
                                        <select class="form-control" name="how_many_week_free[]">
                                            <option value="1" {{$accommodation->how_many_week_free == 1 ? 'selected' : ''}}>{{__('SuperAdmin/backend.1_week_free')}} </option>
                                            <option value="2" {{$accommodation->how_many_week_free == 2 ? 'selected' : ''}}>{{__('SuperAdmin/backend.2_week_free')}}</option>
                                            <option value="3" {{$accommodation->how_many_week_free == 3 ? 'selected' : ''}}>{{__('SuperAdmin/backend.3_week_free')}}</option>
                                            <option value="4" {{$accommodation->how_many_week_free == 4 ? 'selected' : ''}}>{{__('SuperAdmin/backend.4_week_free')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_start_date')}}:</label>
                                        <input value="{{ $accommodation->x_week_start_date }}" class="form-control" type="date" name="x_week_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_end_date')}}:</label>
                                        <input value="{{ $accommodation->x_week_end_date }}" class="form-control" type="date" name="x_week_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <script>
                                    window.addEventListener('load', function() {
                                        yeardatepicker_days.push("{{$accommodation->available_days ? $accommodation->available_days : ''}}".split(","));
                                        yeardatepicker_months.push([]);
                                    }, false );
                                </script>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addAccommodation($(this))"></button>
                                    </div>
                                    <div class="pull-rights">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteAccommodation($(this))"></button>
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
                                        <input readonly class="form-control" value="{{time() . rand(000, 999)}}" type="text" id="accommodation_id0" name="accommodation_id[]">
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
                                                <option value="{{ $accommodation_age_range->unique_id}}">{{ $accommodation_age_range->age}}</option>
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
                                        <input value="" class="form-control" type="number" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.custodian_fee')}}">
                                    </div>
                                    <div class="form-group col-md-4 age_range_for_custodian">
                                        <label>
                                            {{__('SuperAdmin/backend.custodian_age_range')}}
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeAcoomModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommCustodianAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>

                                        <select id="custodian_age_range_choose0" name="age_range_for_custodian[0][]" multiple="multiple" class="3col active">
                                            @foreach($custodian_under_ages as $custodian_under_age)
                                                <option value="{{ $custodian_under_age->unique_id }}">{{ $custodian_under_age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <label>{{__('SuperAdmin/backend.custodian_condition')}}:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="radio" value="required" name="custodian_condition[0]">&nbsp;
                                                <label>{{__('SuperAdmin/backend.required')}}</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="radio" value="optional" name="custodian_condition[0]">&nbsp;
                                                <label>{{__('SuperAdmin/backend.optional')}}</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="radio" value="invisible" name="custodian_condition[0]" checked>&nbsp;
                                                <label>{{__('SuperAdmin/backend.invisible')}}</label>
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
                                        <div class="english">
                                            <textarea class="form-control" name="special_diet_note[]" placeholder="{{__('SuperAdmin/backend.special_diet_note')}}" id="special_diet_note0"></textarea>
                                        </div>
                                        <div class="arabic">
                                            <textarea class="form-control" name="special_diet_note_ar[]" placeholder="{{__('SuperAdmin/backend.special_diet_note')}}" id="special_diet_note_ar0"></textarea>
                                        </div>
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
                                        <label>{{__('SuperAdmin/backend.available_dates')}}:</label>
                                        <select class="form-control available_date" name="available_date[]">
                                            <option value="all_year_round" selected>{{__('SuperAdmin/backend.all_year_round')}}</option>
                                            <option value="selected_dates">{{__('SuperAdmin/backend.selected_dates')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 available_days" style="display: none">
                                        <label>{{__('SuperAdmin/backend.available_days')}}:</label>
                                        <input class="form-control yeardatepicker" data-index="0" name="available_days[]">
                                    </div>
                                    <div class="form-group col-md-4 start_date">
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input class="form-control" type="date" name="start_date[]">
                                    </div>
                                    <div class="form-group col-md-4 end_date">
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input class="form-control" type="date" name="end_date[]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_per_week')}}:</label>
                                        <input class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('SuperAdmin/backend.discount_per_week')}} ">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.discount_symbol')}}:</label>
                                        <select class="form-control" name="discount_per_week_symbol[]">
                                            <option value="%" selected>%</option>
                                            <option value="%">-</option>
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
                                        <input class="form-control" type="number" name="christmas_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.christmas_fee_per_week')}}">
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
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_selected')}}:</label>
                                        <input class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('SuperAdmin/backend.every_week')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.free_week')}}:</label>
                                        <select class="form-control" name="how_many_week_free[]">
                                            <option value="1" selected>{{__('SuperAdmin/backend.1_week_free')}} </option>
                                            <option value="2">{{__('SuperAdmin/backend.2_week_free')}}</option>
                                            <option value="3">{{__('SuperAdmin/backend.3_week_free')}}</option>
                                            <option value="4">{{__('SuperAdmin/backend.4_week_free')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_start_date')}}:</label>
                                        <input class="form-control" type="date" name="x_week_start_date[]">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.x_week_end_date')}}:</label>
                                        <input class="form-control" type="date" name="x_week_end_date[]">
                                    </div>
                                    <div class="form-group col-md-4"></div>
                                </div>

                                <script>
                                    window.addEventListener('load', function() {
                                        yeardatepicker_days.push([]);
                                        yeardatepicker_months.push([]);
                                    }, false );
                                </script>
                            
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addAccommodation($(this))"></button>
                                    </div>
                                    <div class="pull-rights">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteAccommodation($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="getAccommodationContents(); submitAccommodationForm($(this))">{{__('SuperAdmin/backend.submit')}}</button>
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