@extends('branchadmin.layouts.app')
@section('content')
@section('css')
<style>
    .pl-3:hover {
        cursor: pointer;
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

@include('superadmin.courses.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h4 class="card-title">@lang('SuperAdmin/backend.add_airport_fee') </h4>
                <change>{{__('SuperAdmin/backend.in_english')}}</change>
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

            <div class="first-form">
                <form class="forms-sample" method="POST" action="{{route("superadmin.course.store")}}" id="courseform">
                    {{csrf_field()}}
                    <div id="accom_program_duration_clone">
                        <input hidden id="airportincrement" name="airportincrement" value=0>
                        <div class="form-group">
                            <label>
                                <h2>{{__('SuperAdmin/backend.airport_fee')}}</h2></label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{__('SuperAdmin/backend.airport_name')}}:</label>
                                    <input class="form-control" type="text" name="name_en[]" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('SuperAdmin/backend.airport_service_name'):</label>
                                    <input class="form-control" type="text" name="service_name_en[]" placeholder="{{__('SuperAdmin/backend.service_name')}}">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('SuperAdmin/backend.airport_service_fee'):</label>
                                    <input class="form-control" type="number" name="service_fee[]" placeholder="{{__('SuperAdmin/backend.airport_service_fee')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@lang('SuperAdmin/backend.program_duration'):</label>
                                    <input class="form-control" type="text" name="week_selected_fee[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_airport_fee')}}">
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="medical_clone">
                        <input id="medicalincrement" hidden value=0 name="medicalincrement">
                        <div class="form-group">
                            <label>
                                <h2>{{__('SuperAdmin/backend.medical_insurance_cost')}}</h2></label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@lang('SuperAdmin/backend.medical_insurance_fee'):</label>
                                    <input class="form-control" type="text" name="medical_fees_per_week[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_fee_pw')}}" style="width:200px">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('SuperAdmin/backend.medical_insurance_duration_start'):</label>
                                    <input class="form-control" type="number" name="medical_start_date[]" placeholder="@lang('SuperAdmin/backend.medical_insurance_duration_end')">
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('SuperAdmin/backend.medical_end_date'):</label>
                                    <input class="form-control" type="number" name="medical_end_date[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_duration_end')}}">
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.medical_insurance_note'):</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input value="" hidden id="medical_insurance_note_value" name="medical_insurance_note_en" value="">
                                <textarea class="form-control" name="" id="medical_insurance_note" placeholder="@lang('SuperAdmin/backend.medical_insurance_note')"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" onclick="getContent('medical_insurance_note', 'medical_insurance_note_value'); submitAirportMedicalForm($(this))" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection