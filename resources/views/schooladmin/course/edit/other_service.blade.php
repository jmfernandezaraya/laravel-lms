@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.other_services')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.other_services')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                @php $airport_note =[]; @endphp
                @php $medical_note =[]; @endphp

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

                @include('superadmin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{route("superadmin.course.update", $course_id)}}" id="courseform">
                    {{csrf_field()}}
                    @method('PUT')

                    <script>
                        window.addEventListener('load', function() {
                            airport_clone = {{$airports && $airports->count() ? $airports->count() - 1 : 0}};
                        }, false );
                    </script>
                    <input hidden id="airportincrement" name="airportincrement" value="{{$airports && $airports->count() ? $airports->count() - 1 : 0}}">
                    @forelse ($airports as $airport)
                        <div id="airport_clone{{$loop->iteration - 1}}" class="airport-clone clone">
                            <input hidden value="{{$airport->unique_id}}" name="airport_id[]">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.airport_fee')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.service_provider')}}:</label>
                                    <div class="english">
                                        <input class="form-control" type="text" value="{{$airport->service_provider}}" name="airport_service_provider[]" placeholder="{{__('SuperAdmin/backend.service_provider')}}">
                                    </div>
                                    <div class="arabic">
                                        <input class="form-control" type="text" value="{{$airport->service_provider_ar}}" name="airport_service_provider_ar[]" placeholder="{{__('SuperAdmin/backend.service_provider')}}">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.airport_week_selected_fee')}}:</label>
                                    <input class="form-control" type="number" value="{{$airport->week_selected_fee}}" name="airport_week_selected_fee[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_airport_fee')}}">
                                </div>
                            </div>

                            <input hidden name="airportfeeincrement[]" value="{{$airport->fees->count() ? $airport->fees->count() - 1 : 0}}">
                            @if ($airport->fees->count())
                                @foreach ($airport->fees as $airport_fee)
                                    <div class="row airport-fee-clone clone" id="airport{{$loop->parent->iteration - 1}}_fee_clone{{$loop->iteration - 1}}">
                                        <input hidden value="{{$airport_fee->unique_id}}" name="airport_fee_id[{{$loop->parent->iteration - 1}}][]">
                                        <div class="form-group col-md-3">
                                            <label>{{__('SuperAdmin/backend.airport_name')}}:</label>
                                            <div class="english">
                                                <input class="form-control" type="text" value="{{$airport_fee->name}}" name="airport_name[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                                            </div>
                                            <div class="arabic">
                                                <input class="form-control" type="text" value="{{$airport_fee->name_ar}}" name="airport_name_ar[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>{{__('SuperAdmin/backend.type_of_service')}}:</label>
                                            <div class="english">
                                                <input class="form-control" type="text" value="{{$airport_fee->service_name}}" name="airport_service_name[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.type_of_service')}}">
                                            </div>
                                            <div class="arabic">
                                                <input class="form-control" type="text" value="{{$airport_fee->service_name_ar}}" name="airport_service_name_ar[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.type_of_service')}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>{{__('SuperAdmin/backend.airport_service_fee')}}:</label>
                                            <input class="form-control" type="number" value="{{$airport_fee->service_fee}}" name="airport_service_fee[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.if_program_duration_airport_fee')}}">
                                        </div>
                                        <div class="form-group col-md-3 mt-4">
                                            <i class="fa fa-plus-circle" aria-hidden="true" onclick="addAirportFeeForm($(this))"></i>
                                            <i class="fa fa-minus" aria-hidden="true" onclick="deleteAirportFeeForm($(this))"></i>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row airport-fee-clone clone" id="airport{{$loop->iteration - 1}}_fee_clone0">
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.airport_name')}}:</label>
                                        <div class="english">
                                            <input class="form-control" type="text" name="airport_name[{{$loop->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.airport_name')}}" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                                        </div>
                                        <div class="arabic">
                                            <input class="form-control" type="text" name="airport_name_ar[{{$loop->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.airport_name')}}" placeholder="{{__('SuperAdmin/backend.airport_name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.type_of_service')}}:</label>
                                        <div class="english">
                                            <input class="form-control" type="text" name="airport_service_name[{{$loop->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.type_of_service')}}" placeholder="{{__('SuperAdmin/backend.type_of_service')}}">
                                        </div>
                                        <div class="arabic">
                                            <input class="form-control" type="text" name="airport_service_name_ar[{{$loop->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.type_of_service')}}" placeholder="{{__('SuperAdmin/backend.type_of_service')}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.airport_service_fee')}}:</label>
                                        <input class="form-control" type="number" name="airport_service_fee[{{$loop->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.airport_service_fee')}}" placeholder="{{__('SuperAdmin/backend.if_program_duration_airport_fee')}}">
                                    </div>
                                    <div class="form-group col-md-3 mt-4">
                                        <i class="fa fa-plus-circle" aria-hidden="true" onclick="addAirportFeeForm($(this))"></i>
                                        <i class="fa fa-minus" aria-hidden="true" onclick="deleteAirportFeeForm($(this))"></i>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>{{__('SuperAdmin/backend.airport_insurance_note')}}:</label>
                                    <div class="english">
                                        <textarea class="form-control ckeditor-input" name="airport_note[]" placeholder="{{__('SuperAdmin/backend.airport_insurance_note')}}" id="airport_note{{$loop->iteration - 1}}">{!! $airport->note !!}</textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="airport_note_ar[]" placeholder="{{__('SuperAdmin/backend.airport_insurance_note')}}" id="airport_note_ar{{$loop->iteration - 1}}">{!! $airport->note_ar !!}</textarea>
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
                    @empty
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
                                    <label>{{__('SuperAdmin/backend.airport_week_selected_fee')}}:</label>
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
                                        <textarea class="form-control ckeditor-input" name="airport_note[]" placeholder="{{__('SuperAdmin/backend.airport_insurance_note')}}" id="airport_note0"></textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="airport_note_ar[]" placeholder="{{__('SuperAdmin/backend.airport_insurance_note')}}" id="airport_note_ar0"></textarea>
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
                    @endforelse

                    <script>
                        window.addEventListener('load', function() {
                            medical_clone = {{$medicals && $medicals->count() ? $medicals->count() - 1 : 0}};
                        }, false );
                    </script>
                    <input hidden id="medicalincrement" name="medicalincrement" value="{{$medicals && $medicals->count() ? $medicals->count() - 1 : 0}}">
                    @forelse ($medicals as $medical)
                        <div id="medical_clone{{$loop->iteration - 1}}" class="medical-clone clone">
                            <input hidden value="{{$medical->unique_id}}" name="medical_id[]">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.medical_insurance_cost')}}</h4></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.company_name')}}:</label>
                                    <div class="english">
                                        <input class="form-control" type="text" value="{{$medical->company_name}}" name="medical_company_name[]" placeholder="{{__('SuperAdmin/backend.company_name')}}">
                                    </div>
                                    <div class="arabic">
                                        <input class="form-control" type="text" value="{{$medical->company_name_ar}}" name="medical_company_name_ar[]" placeholder="{{__('SuperAdmin/backend.company_name')}}">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.deductible_up_to')}}:</label>
                                    <input class="form-control" type="text" value="{{$medical->deductible}}" name="medical_deductible[]" placeholder="{{__('SuperAdmin/backend.deductible_up_to')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.week_selected_fee')}}:</label>
                                    <input class="form-control" type="number" value="{{$medical->week_selected_fee}}" name="medical_week_selected_fee[]" placeholder="{{__('SuperAdmin/backend.if_program_duration_medical_fee')}}">
                                </div>
                            </div>

                            <input hidden name="medicalfeeincrement[]" value="{{$medical->fees->count() ? $medical->fees->count() - 1 : 0}}">
                            @if ($medical->fees->count())
                                @foreach ($medical->fees as $medical_fee)
                                    <div class="row medical-fee-clone clone" id="medical{{$loop->parent->iteration - 1}}_fee_clone{{$loop->iteration - 1}}">
                                        <input hidden value="{{$medical_fee->unique_id}}" name="medical_fee_id[{{$loop->parent->iteration - 1}}][]">
                                        <div class="form-group col-md-3">
                                            <label>{{__('SuperAdmin/backend.insurance_fee')}}:</label>
                                            <input class="form-control" type="number" value="{{$medical_fee->fees_per_week}}" name="medical_fees_per_week[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.insurance_fee')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                            <input class="form-control" type="number" value="{{$medical_fee->start_date}}" name="medical_start_date[{{$loop->parent->iteration - 1}}][]">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                            <input class="form-control" type="number" value="{{$medical_fee->end_date}}" name="medical_end_date[{{$loop->parent->iteration - 1}}][]">
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <i class="fa fa-plus-circle" aria-hidden="true" onclick="addMedicalFeeForm($(this))"></i>
                                            <i class="fa fa-minus" aria-hidden="true" onclick="deleteMedicalFeeForm($(this))"></i>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row medical-fee-clone clone" id="medical{{$loop->iteration - 1}}_fee_clone0">
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.insurance_fee')}}:</label>
                                        <input class="form-control" type="number" name="medical_fees_per_week[{{$loop->iteration - 1}}][]" placeholder="{{__('SuperAdmin/backend.insurance_fee')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input class="form-control" type="number" name="medical_start_date[{{$loop->iteration - 1}}][]">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input class="form-control" type="number" name="medical_end_date[{{$loop->iteration - 1}}][]">
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <i class="fa fa-plus-circle" aria-hidden="true" onclick="addMedicalFeeForm($(this))"></i>
                                        <i class="fa fa-minus" aria-hidden="true" onclick="deleteMedicalFeeForm($(this))"></i>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>{{__('SuperAdmin/backend.medical_insurance_note')}}:</label>
                                    <div class="english">
                                        <textarea class="form-control ckeditor-input" name="medical_note[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_note')}}" id="medical_note{{$loop->iteration - 1}}">{!! $medical->note !!}</textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="medical_note_ar[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_note')}}" id="medical_note_ar{{$loop->iteration - 1}}">{!! $medical->note_ar !!}</textarea>
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
                    @empty
                        <div id="medical_clone0" class="medical-clone clone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.medical_insurance_cost')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{__('SuperAdmin/backend.company_name')}}:</label>
                                    <div class="english">
                                        <input class="form-control" type="text" name="medical_company_name[]" placeholder="{{__('SuperAdmin/backend.company_name')}}">
                                    </div>
                                    <div class="arabic">
                                        <input class="form-control" type="text" name="medical_company_name_ar[]" placeholder="{{__('SuperAdmin/backend.company_name')}}">
                                    </div>
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
                                        <textarea class="form-control ckeditor-input" name="medical_note[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_note')}}" id="medical_note0"></textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="medical_note_ar[]" placeholder="{{__('SuperAdmin/backend.medical_insurance_note')}}" id="medical_note_ar0"></textarea>
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
                    @endforelse
                    
                    <script>
                        window.addEventListener('load', function() {
                            custodian_clone = {{$custodians && $custodians->count() ? $custodians->count() - 1 : 0}};
                        }, false );
                    </script>
                    <input hidden id="custodianincrement" name="custodianincrement" value="{{$custodians && $custodians->count() ? $custodians->count() - 1 : 0}}">
                    @forelse ($custodians as $custodian)
                        <div id="custodian_clone{{$loop->iteration - 1}}" class="custodian-clone clone">
                            <input hidden value="{{$custodian->unique_id}}" name="custodian_id[]">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.custodian_fee')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4 pt-3">
                                    <label>{{__('SuperAdmin/backend.fee')}}:</label>
                                    <input value="{{ $custodian->fee }}" class="form-control" type="number" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.custodian_fee')}}">
                                </div>
                                <div class="form-group col-md-4 custodian_age_range">
                                    <label>
                                        {{__('SuperAdmin/backend.age_range')}}
                                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeModal" aria-hidden="true"></i>
                                        <i onclick="deleteCustodianAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                    </label>

                                    <select name="custodian_age_range[{{ $loop->iteration - 1 }}][]" id="custodian_age_range_choose{{ $loop->iteration - 1 }}" multiple="multiple" class="3col active">
                                        @foreach($custodian_under_ages as $custodian_under_age)
                                            <option {{in_array($custodian_under_age->unique_id, (array)$custodian->age_range ?? []) ? 'selected' : ''}} value="{{ $custodian_under_age->unique_id }}">{{ $custodian_under_age->age }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 pt-3">
                                    <label>{{__('SuperAdmin/backend.condition')}}:</label>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="radio" value="required" name="custodian_condition[{{ $loop->iteration - 1 }}]" {{$custodian->condition == 'required' ? 'checked' : ''}}>&nbsp;
                                            <label>{{__('SuperAdmin/backend.required')}}</label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="radio" value="optional" name="custodian_condition[{{ $loop->iteration - 1 }}]" {{$custodian->condition == 'optional' ? 'checked' : ''}}>&nbsp;
                                            <label>{{__('SuperAdmin/backend.optional')}}</label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="radio" value="invisible" name="custodian_condition[{{ $loop->iteration - 1 }}]" {{$custodian->condition == 'invisible' ? 'checked' : ''}}>&nbsp;
                                            <label>{{__('SuperAdmin/backend.invisible')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <button class="btn btn-primary fa fa-plus-circle"type="button" onclick="addCustodianForm($(this))"></button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteCustodianForm($(this))"></button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="custodian_clone0" class="custodian-clone clone">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('SuperAdmin/backend.custodian_fee')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4 pt-3">
                                    <label>{{__('SuperAdmin/backend.fee')}}:</label>
                                    <input value="" class="form-control" type="number" name="custodian_fee[]" placeholder="{{__('SuperAdmin/backend.custodian_fee')}}">
                                </div>
                                <div class="form-group col-md-4 custodian_age_range">
                                    <label>
                                        {{__('SuperAdmin/backend.age_range')}}
                                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#CustodianAgeRangeModal" aria-hidden="true"></i>
                                        <i onclick="deleteCustodianAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                    </label>

                                    <select id="custodian_age_range_choose0" name="custodian_age_range[0][]" multiple="multiple" class="3col active">
                                        @foreach($custodian_under_ages as $custodian_under_age)
                                            <option value="{{$custodian_under_age->unique_id}}">{{$custodian_under_age->age}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 pt-3">
                                    <label>{{__('SuperAdmin/backend.condition')}}:</label>
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
                                <div class="form-group col-md-6">
                                    <button class="btn btn-primary fa fa-plus-circle"type="button" onclick="addCustodianForm($(this))"></button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteCustodianForm($(this))"></button>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    <div class="row">
                        <div class="form-group col-md-6">
                            <button type="button" onclick="submitOtherServiceForm($(this))" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
                        </div>
                        <div class="form-group col-md-6">
                            <a href="{{route('superadmin.course.index')}}" class="btn btn-primary pull-right" type="button" name="####">{{__('SuperAdmin/backend.back')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('superadmin.include.modals')

    @section('js')
        <script>
            var uploadFileOption = "{{route('superadmin.course.upload', ['_token' => csrf_token() ])}}";
        </script>
    @endsection
@endsection