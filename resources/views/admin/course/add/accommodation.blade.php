@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.accommodation_cost')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.accommodation_cost')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                <div id="menu">
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ auth('superadmin')->check() ? route('superadmin.course.store') : route('schooladmin.course.store') }}" id="courseform" data-mode="create">
                    {{csrf_field()}}
                    
                    <div id="accommodation_clone0" class="accommodation-clone clone">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label><h3>{{__('Admin/backend.accommodation')}}</h3></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.accommodation_id')}}:</label>
                                <input readonly class="form-control" value="{{time() . rand(000, 999)}}" type="text" id="accommodation_id0" name="accommodation_id[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="type">{{__('Admin/backend.type')}}:</label>
                                <div class="english">
                                    <input class="form-control" type="text" name="type[]" placeholder="{{__('Admin/backend.type')}}">
                                </div>
                                <div class="arabic">
                                    <input class="form-control" type="text" name="type_ar[]" placeholder="{{__('Admin/backend.type')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.room_type')}}:</label>
                                <div class="english">
                                    <input class="form-control" type="text" name="room_type[]" placeholder="{{__('Admin/backend.room_type')}}">
                                </div>
                                <div class="arabic">
                                    <input class="form-control" type="text" name="room_type_ar[]" placeholder="{{__('Admin/backend.room_type')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.meal')}}:</label>
                                <div class="english">
                                    <input class="form-control" type="text" name="meal[]" placeholder="{{__('Admin/backend.meal')}}">
                                </div>
                                <div class="arabic">
                                    <input class="form-control" type="text" name="meal_ar[]" placeholder="{{__('Admin/backend.meal')}}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-4 age_range">
                                <label for="age_range">{{__('Admin/backend.age_range')}}:</label>
                                <select id="accom_age_choose0" name="age_range[0][]" multiple="multiple" class="3col active">
                                    @foreach($accommodation_age_ranges as $accommodation_age_range)
                                        <option value="{{$accommodation_age_range->unique_id}}">{{$accommodation_age_range->age}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.placement_fee')}}:</label>
                                <input class="form-control" type="number" name="placement_fee[]" placeholder="{{__('Admin/backend.placement_fee')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.program_duration')}}:</label>
                                <input class="form-control" type="number" name="program_duration[]" placeholder="{{__('Admin/backend.if_program_duration')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.deposit_fee')}}:</label>
                                <input class="form-control" type="number" name="deposit_fee[]" placeholder="{{__('Admin/backend.deposit_fee')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.special_diet_fee')}}:</label>
                                <input class="form-control" type="number" name="special_diet_fee[]" placeholder="{{__('Admin/backend.special_diet_fee')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{__('Admin/backend.special_diet_note')}}:</label>
                                <div class="english">
                                    <textarea class="form-control ckeditor-input" name="special_diet_note[]" placeholder="{{__('Admin/backend.special_diet_note')}}" id="special_diet_note0"></textarea>
                                </div>
                                <div class="arabic">
                                    <textarea class="form-control ckeditor-input" name="special_diet_note_ar[]" placeholder="{{__('Admin/backend.special_diet_note')}}" id="special_diet_note_ar0"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.fee_per_week')}}:</label>
                                <input class="form-control" type="number" name="fee_per_week[]" placeholder="{{__('Admin/backend.fee_per_week')}} ">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.start_week')}}:</label>
                                <input class="form-control" type="number" name="start_week[]" placeholder="{{__('Admin/backend.duration_start')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.end_week')}}:</label>
                                <input class="form-control" type="number" name="end_week[]" placeholder="{{__('Admin/backend.duration_end')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.available_dates')}}:</label>
                                <select class="form-control available_date" name="available_date[]">
                                    <option value="all_year_round" selected>{{__('Admin/backend.all_year_round')}}</option>
                                    <option value="selected_dates">{{__('Admin/backend.selected_dates')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 available_days" style="display: none">
                                <label>{{__('Admin/backend.available_days')}}:</label>
                                <input class="form-control yeardatepicker" data-index="0" name="available_days[]">
                            </div>
                            <div class="form-group col-md-4 start_date">
                                <label>{{__('Admin/backend.start_date')}}:</label>
                                <input class="form-control" type="date" name="start_date[]">
                            </div>
                            <div class="form-group col-md-4 end_date">
                                <label>{{__('Admin/backend.end_date')}}:</label>
                                <input class="form-control" type="date" name="end_date[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.discount_per_week')}}:</label>
                                <input class="form-control" type="number" name="discount_per_week[]" placeholder="{{__('Admin/backend.discount_per_week')}} ">
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.discount_symbol')}}:</label>
                                <select class="form-control" name="discount_per_week_symbol[]">
                                    <option value="%" selected>%</option>
                                    <option value="-">-</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.discount_start_date')}}:</label>
                                <input class="form-control" type="date" name="discount_start_date[]">
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.discount_end_date')}}:</label>
                                <input class="form-control" type="date" name="discount_end_date[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.summer_fee_per_week')}}:</label>
                                <input class="form-control" type="number" name="summer_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.summer_fee_start_date')}}:</label>
                                <input class="form-control" type="date" name="summer_fee_start_date[]">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.summer_fee_end_date')}}:</label>
                                <input class="form-control" type="date" name="summer_fee_end_date[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.peak_time_fee_per_week')}}:</label>
                                <input class="form-control" type="number" name="peak_time_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.peak_time_start_date')}}:</label>
                                <input class="form-control" type="date" name="peak_time_fee_start_date[]" placeholder="{{__('Admin/backend.peak_time_start_date')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.peak_time_end_date')}}:</label>
                                <input class="form-control" type="date" name="peak_time_fee_end_date[]" placeholder="{{__('Admin/backend.peak_time_end_date')}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.christmas_fee')}}:</label>
                                <input class="form-control" type="number" name="christmas_fee_per_week[]"
                                    placeholder="{{__('Admin/backend.christmas_fee_per_week')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.christmas_start_fee')}}:</label>
                                <input class="form-control" type="date" name="christmas_fee_start_date[]">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.christmas_end_fee')}}:</label>
                                <input class="form-control" type="date" name="christmas_fee_end_date[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.x_week_selected')}}:</label>
                                <input class="form-control" type="number" name="x_week_selected[]" placeholder="{{__('Admin/backend.every_week')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.free_week')}}:</label>
                                <select class="form-control" name="how_many_week_free[]">
                                    <option value="1" selected>{{__('Admin/backend.1_week_free')}} </option>
                                    <option value="2">{{__('Admin/backend.2_week_free')}}</option>
                                    <option value="3">{{__('Admin/backend.3_week_free')}}</option>
                                    <option value="4">{{__('Admin/backend.4_week_free')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4"></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.x_week_start_date')}}:</label>
                                <input class="form-control" type="date" name="x_week_start_date[]">
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.x_week_end_date')}}:</label>
                                <input class="form-control" type="date" name="x_week_end_date[]">
                            </div>
                            <div class="form-group col-md-4"></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary fa fa-plus" type="button" onclick="addAccommodation($(this))"></button>
                            </div>
                            <div class="pull-rights">
                                <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteAccommodation($(this))"></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <a class="btn btn-primary" type="button" onclick="submitAccommodationForm($(this))">{{__('Admin/backend.submit')}}</a>
                        </div>
                        <div class="form-group col-md-6">
                            <a href="{{ auth('superadmin')->check() ? route('superadmin.course.accomm_under_age') : route('schooladmin.course.accomm_under_age') }}" class="btn btn-primary pull-right" type="button">{{__('Admin/backend.next')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('admin.include.modals')

    @section('js')
        <script>
            var uploadFileOption = "{{ auth('superadmin')->check() ? route('superadmin.course.upload', ['_token' => csrf_token() ]) : route('schooladmin.course.upload', ['_token' => csrf_token() ]) }}";
        </script>
    @endsection
@endsection