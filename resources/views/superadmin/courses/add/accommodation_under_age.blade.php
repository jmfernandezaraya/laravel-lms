
@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.add_accommodation_under_age')}}
@endsection

@section('content')
    @include('superadmin.courses.scripts')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                <h1 class="card-title">{{__('SuperAdmin/backend.add_accommodation_under_age')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                @include('superadmin.include.alert')

                <div id="show_form"></div>

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.store")}}" id="accommodation_under_age_form">
                    {{csrf_field()}}

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('SuperAdmin/backend.accommodation_id')}}</label>
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
                                    <label for="age_range">{{__('SuperAdmin/backend.age_range')}}:
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
                                    <label>{{__('SuperAdmin/backend.under_age_fee_per_week')}}:</label>
                                    <input class="form-control" type="number" value="" name="under_age_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.under_age_fee_per_week')}}">
                                </div>
                                <div class="form-group col-md-4 mt-4 pt-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="accom_plus_button" onclick="addAccommodationFormUnderAge($(this))"></i>
                                    <i class="fa fa-minus" onclick="deleteAccommodationUnderAge($(this))" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="submitAccommodationUnderAgeForm($(this), 1)">{{__('SuperAdmin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                @if($course_id)
                                    <a href="{{route('superadmin.course.airport_medical.edit')}}"  class="btn btn-primary pull-right" type="button">{{__('SuperAdmin/backend.next')}}</a>
                                @else
                                    <a href="{{route('superadmin.course.airport_medical')}}"  class="btn btn-primary pull-right" type="button">{{__('SuperAdmin/backend.next')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('superadmin.courses.modals')
@endsection