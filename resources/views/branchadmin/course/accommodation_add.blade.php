@extends('branchadmin.layouts.app')
@section('content')
@section('css')
    <style>
        .pl-3:hover {
            cursor: pointer;
        }
        
        .pull-rights {
            margin-left: 700px !important;
            margin-top: -50px !important;
        }
        
        .fa {
            cursor: pointer;
        }
        
        .tox .tox-notification--warn,
        .tox .tox-notification--warning {
            display: none !important;
        }
        
        #ms-list-1,
        #ms-list-2,
        #ms-list-3,
        #ms-list-4,
        #ms-list-5,
        #ms-list-6,
        #ms-list-7,
        #ms-list-8,
        #ms-list-9,
        #ms-list-11,
        #ms-list-10 {
            padding: 10px 8px;
            border: 1px solid #ebedf2;
        }
        
        .ms-options-wrap > .ms-options {
            left: 21px;
            width: 87%;
        }
        
        button {
            border: none !important;
        }
        
        i.fa.fa-plus-circle {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 15px 15px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
        }
        
        i.fa.fa-minus {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 15px 15px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
        }
        
        i.fa.fa-plus {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
        }
        
        i.fa.fa-trash {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
        }
        
        ul.multiselect-container.dropdown-menu.show {
            width: 100%;
        }
        
        .multiselect-native-select .btn-group {
            width: 100%;
        }
        
        button.multiselect.dropdown-toggle.btn.btn-default {
            outline: 1px solid #ebedf2;
            color: #c9c8c8;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
        }
        
        span.multiselect-selected-text {
            font-size: 12px;
            font-family: sans-serif;
        }
    </style>
@endsection

@include('admin.course.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h2>@lang('Admin/backend.accommodation_cost') </h2>
                <change>{{__('Admin/backend.in_english')}}</change>
            </div>
            @include('superadmin.include.alert')
            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                        </a>
                    </li>
                </ul>
            </div>

            <div id="show_form"></div>

            <form class="forms-sample" method="POST" action="{{route("admin.course.store")}}" id="courseform">
                {{csrf_field()}}
                <div class="first-form">
                    <div id="clone_accommodation_form0">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.accommodation_id')</label>

                                    <input readonly class="form-control" value="{{time().rand(00,99)}}" type="text" id="accommodation_id" name="accommodation_id[]">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="type">{{__('Admin/backend.accommodation_type')}}:</label>
                                    <input class="form-control" type="text" name="type[]" placeholder="{{__('Admin/backend.accommodation_type')}}" style="width:250px">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.room_type'):</label>
                                    <input class="form-control" type="text" name="room_type[]" placeholder="{{__('Admin/backend.room_type')}}" style="width:250px">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.meal'):</label>
                                    <input class="form-control" type="text" name="meal[]" placeholder="{{__('Admin/backend.Meal')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="age_range">{{__('Admin/backend.age_range')}} :<i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccommodationAgeRangeModal" aria-hidden="true"></i><i onclick="DeleteAccomAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i></label>
                            <div class="row">
                                <div class="col-md-4" id="remove_accom_accom0">
                                    <select id="accom_age_choose0" name="age_range[0][]" multiple="multiple" class="3col active">
                                        @foreach(\App\Models\SuperAdmin\Choose_Accommodation_Age_Range::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all() as $option)
                                            <option value="{{$option->age}}">{{$option->age}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{__('Admin/backend.accommodation_placement_fee')}}:</label>
                                    <input class="form-control" type="text" name="placement_fee[]" placeholder="{{__('Admin/backend.accommodation_placement_fee')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.accommodation_program_duration') </label>
                                    <input class="form-control" type="text" name="program_duration[]" placeholder="{{__('Admin/backend.if_program_duration')}}">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{__('Admin/backend.accommodation_deposit_fee')}}:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="deposit_fee[]" placeholder="{{__('Admin/backend.accommodation_deposit_fee')}}">
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{__('Admin/backend.special_diet_fee')}}:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="special_diet_fee[]" placeholder="{{__('Admin/backend.special_diet_fee_pw')}}">
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Admin/backend.special_diet_note'):</label>
                            <textarea class="form-control" type="text" name="special_diet_note" placeholder="special diet note" id="special_diet_note"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.accommodation_fee'):</label>
                                    <input class="form-control" type="text" name="fee_per_week[]" placeholder="{{__('Admin/backend.accommodation_fee')}} ">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.accommodation_start_week'):</label>
                                    <input class="form-control" type="text" name="start_week[]" placeholder="{{__('Admin/backend.accommodation_duration_start')}}">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.accommodation_end_week'):</label>
                                    <input class="form-control" type="text" name="end_week[]" placeholder="{{__('Admin/backend.accommodation_duration_end')}}">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.accommodation_start_date'):</label>
                                    <input class="form-control" type="date" name="start_date[]">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.accommodation_end_date'):</label>
                                    <input class="form-control" type="date" name="end_date[]">
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.discount_per_week'):</label>
                                    <input class="form-control" type="text" name="discount_per_week[]" placeholder="{{__('Admin/backend.discount_per_week')}} ">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.discount_symbol'):</label>
                                    <select class="form-control" name="discount_per_week_symbol[]">
                                        <option>%</option>
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.discount_start_date'):</label>
                                    <input class="form-control" type="date" name="discount_start_date[]">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Admin/backend.discount_end_date'):</label>
                                    <input class="form-control" type="date" name="discount_end_date[]">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_per_week'):</label>
                                    <input class="form-control" type="text" name="summer_fee_per_week[]" placeholder="{{__('Admin/backend.summer_fee_per_week')}} ">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_start_date'):</label>
                                    <input class="form-control" type="date" name="summer_fee_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.summer_fee_end_date'):</label>
                                    <input class="form-control" type="date" name="summer_fee_end_date[]">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_fee_per_week') </label>
                                    <input class="form-control" type="text" name="peak_time_fee_per_week[]" placeholder="{{__('Admin/backend.peak_time_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_start_date') </label>
                                    <input class="form-control" type="date" name="peak_time_fee_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.peak_time_end_date') </label>
                                    <input class="form-control" type="date" name="peak_time_fee_end_date[]">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.christmas_fee'):</label>
                                    <input class="form-control" type="text" name="christmas_fee_per_week[]" placeholder="{{__('Admin/backend.christmas_fee_per_week')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.christmas_start_fee'):</label>
                                    <input class="form-control" type="date" name="christmas_fee_start_date[]">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('Admin/backend.christmas_end_fee'):</label>
                                    <input class="form-control" type="date" name="christmas_fee_end_date[]">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary fa fa-plus" type="button" id="add_another_accomodation0" name="####"></button>
                                </div>
                                <div class="pull-rights">
                                    <button class="btn btn-danger fa fa-minus" id="remove_another_accomodation0" type="button" onclick="remove_another_accomodation($(this))" name="####"></button>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="button" onclick="submitAccommodationForm($(this))" name="####">{{__('Admin/backend.submit')}}</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('accom_under_age_page')}}" class="btn btn-primary pull-right" type="button" name="####">{{__('Admin/backend.next')}}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@include('admin.course.modals')
@endsection