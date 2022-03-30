@extends('superadmin.layouts.app')

@section('content')
    @include('superadmin.courses.scripts')
    
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.add_airport_medical_fee')}}</h1>
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

                <div class="first-form">
                    <form class="forms-sample" method="POST" action="{{route("superadmin.course.store")}}" id="courseform">
                        {{csrf_field()}}

                        <input hidden id="airportincrement" name="airportincrement" value="0">
                        <div id="airport_clone0" class="airport-clone clone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.airport_fee')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.service_provider')}}:</label>
                                    <input class="form-control" type="text" name="airport_service_provider[]" placeholder="{{__('SuperAdmin/backend.service_provider')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.week_selected_fee')}}:</label>
                                    <input class="form-control" type="number" name="airport_week_selected_fee[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_airport_fee')}}">
                                </div>
                            </div>

                            <input hidden name="airportfeeincrement[]" value="0">
                            <div class="row airport-fee-clone clone" id="airport0_fee_clone0">
                                <div class="form-group col-md-3">
                                    <label>{{__('SuperAdmin/backend.airport_name')}}:</label>
                                    <input class="form-control" type="text" name="airport_name[0][]" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>{{__('SuperAdmin/backend.type_of_service')}}:</label>
                                    <input class="form-control" type="text" name="airport_service_name[0][]" placeholder="{{__('SuperAdmin/backend.type_of_service')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>{{__('SuperAdmin/backend.airport_service_fee')}}:</label>
                                    <input class="form-control" type="number" name="airport_service_fee[0][]" placeholder="{{__('SuperAdmin/backend.airport_service_fee')}}">
                                </div>
                                <div class="form-group col-md-3 mt-4">
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addAirportFeeForm($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteAirportFeeForm($(this))"></i>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>{{__('SuperAdmin/backend.airport_insurance_note')}}:</label>
                                    <div class="english">
                                        <textarea class="form-control" name="airport_note[]" placeholder="{{__('SuperAdmin/backend.airport_insurance_note')}}" id="airport_note0"></textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control" name="airport_note_ar[]" placeholder="{{__('SuperAdmin/backend.airport_insurance_note')}}" id="airport_note_ar0"></textarea>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <button class="btn btn-primary fa fa-plus-circle"type="button" onclick="addAirportForm($(this))"></button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteAirportForm($(this))"></button>
                                </div>
                            </div>
                        </div>

                        <input hidden id="medicalincrement" name="medicalincrement" value="0">
                        <div id="medical_clone0" class="medical-clone clone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.medical_insurance_cost')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.company_name')}}:</label>
                                    <input class="form-control" type="text" name="medical_company_name[]" placeholder="{{__('SuperAdmin/backend.company_name')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.deductible_up_to')}}:</label>
                                    <input class="form-control" type="text" name="medical_deductible[]" placeholder="{{__('SuperAdmin/backend.deductible_up_to')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.week_selected_fee')}}:</label>
                                    <input class="form-control" type="number" name="medical_week_selected_fee[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_medical_fee')}}">
                                </div>
                            </div>

                            <input hidden name="medicalfeeincrement[]" value="0">
                            <div class="row medical-fee-clone clone" id="medical0_fee_clone0">
                                <div class="form-group col-md-3">
                                    <label>{{__('SuperAdmin/backend.insurance_fee')}}:</label>
                                    <input class="form-control" type="number" name="medical_fees_per_week[0][]" placeholder="{{__('SuperAdmin/backend.insurance_fee')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                    <input class="form-control" type="number" name="medical_start_date[0][]">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                    <input class="form-control" type="number" name="medical_end_date[0][]">
                                </div>
                                <div class="col-md-3 mt-4">
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addMedicalFeeForm($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteMedicalFeeForm($(this))"></i>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>{{__('SuperAdmin/backend.medical_insurance_note')}}:</label>
                                    <div class="english">
                                        <textarea class="form-control" name="medical_note[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_note')}}" id="medical_note0"></textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control" name="medical_note_ar[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_note')}}" id="medical_note_ar0"></textarea>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <button class="btn btn-primary fa fa-plus-circle"type="button" onclick="addMedicalForm($(this))"></button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteMedicalForm($(this))"></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button type="button" onclick="getAirpotMedicalContents(); submitAirportMedicalForm($(this))" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                <a href="{{route('superadmin.course.index')}}" class="btn btn-primary pull-right" type="button" name="####">{{__('SuperAdmin/backend.back')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('superadmin.courses.modals')
@endsection