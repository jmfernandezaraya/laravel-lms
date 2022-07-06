
@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_accommodation_under_age')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_accommodation_under_age')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ auth('superadmin')->check() ? route('superadmin.course.store') : route('schooladmin.course.store') }}" id="accommodation_under_age_form" data-mode="create">
                    {{csrf_field()}}

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.accommodation_id')}}</label>
                                <select class="3col active" name="accom_id[]" multiple="multiple">
                                    @foreach($accomodations as $accomodation)
                                        <option value="{{$accomodation->unique_id}}">{{$accomodation->unique_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            
                        <input hidden id="accomunderageincrement" name="accomunderageincrement" value="0">

                        <div id="accommodation_under_age_clone0" class="accommodation-under-age-clone clone">
                            <input type="hidden" value="" name="accom_under_age_id[]">
                            <div class="row">
                                <div class="form-group col-md-4 under_age">
                                    <label for="age_range">{{__('Admin/backend.age_range')}}:
                                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i>
                                        <i onclick="deleteAccommUnderAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                    </label>
                                    <select name="under_age[0][]" id="under_age_choose0" multiple="multiple" class="3col active">
                                        @foreach($choose_accomodation_under_ages as $choose_accomodation_under_age)
                                            <option value="{{$choose_accomodation_under_age->unique_id}}">{{$choose_accomodation_under_age->age}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mt-4">
                                    <label>{{__('Admin/backend.under_age_fee_per_week')}}:</label>
                                    <input class="form-control" type="number" value="" name="under_age_fee_per_week[]" placeholder="{{__('Admin/backend.under_age_fee_per_week')}}">
                                </div>
                                <div class="form-group col-md-4 mt-4 pt-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="accom_plus_button" onclick="addAccommodationFormUnderAge($(this))"></i>
                                    <i class="fa fa-minus" onclick="deleteAccommodationUnderAge($(this))" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="submitAccommodationUnderAgeForm($(this), 1)">{{__('Admin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                @if ($course_id)
                                    <a href="{{ auth('superadmin')->check() ? route('superadmin.course.other_service.edit') : route('schooladmin.course.other_service.edit') }}"  class="btn btn-primary pull-right" type="button">{{__('Admin/backend.next')}}</a>
                                @else
                                    <a href="{{ auth('superadmin')->check() ? route('superadmin.course.other_service') : route('schooladmin.course.other_service') }}"  class="btn btn-primary pull-right" type="button">{{__('Admin/backend.next')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('admin.include.modals')
@endsection