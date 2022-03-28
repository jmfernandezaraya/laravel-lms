
@extends('superadmin.layouts.app')
@section('content')
    @include('superadmin.courses.scripts')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                <h1 class="card-title">@lang('SuperAdmin/backend.add_accommodation_under_age')</h1>
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

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.store")}}" id="courseform">
                    {{csrf_field()}}

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>@lang('SuperAdmin/backend.accommodation_id')</label>
                                <select class="3col active" name="accom_id[]" style="width:100%"  multiple="multiple">
                                    @foreach ($accomodations as $accomodation)
                                        <option value="{{$accomodation->unique_id}}">{{$accomodation->unique_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="accomoe0">
                            <div class="row" id="accom_under_age_clone0">
                                <div class="form-group col-md-4">
                                    <label for="accommodation_underage_fee">{{ucwords(__('SuperAdmin/backend.age_range'))}}:
                                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i>
                                        <i onclick="deleteAccommUnderAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                    </label>
                                    <select name="under_age[age][0][]" id="under_age_choose0" multiple="multiple" class="3col active">
                                        @foreach($accomodation_under_ages as $accomodation_under_age)
                                            <option value="{{$accomodation_under_age->unique_id}}">{{$accomodation_under_age->age}}</option>
                                        @endforeach
                                    </select>
                                    <input id="accom_increment" name="accom_increment" hidden value="1">
                                </div>

                                <div class="form-group col-md-4 mt-4">
                                    <label>@lang('SuperAdmin/backend.course_week'): </label>
                                    <input class="form-control" type="text" name="under_age_fee_per_week[]" placeholder="@lang('SuperAdmin/backend.course_week')">
                                </div>
                                <div class="form-group col-md-4 mt-4 pt-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="accom_plus_button" data-id="0" onclick="addAccommodationUnderAgeWeek($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="addAccommodationUnderAge($(this))" name="####">{{__('SuperAdmin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                <a href="{{route('superadmin.course.airport_medical')}}"  class="btn btn-primary pull-right" type="button" name="####">{{__('SuperAdmin/backend.next')}}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('superadmin.courses.modals')
@endsection
