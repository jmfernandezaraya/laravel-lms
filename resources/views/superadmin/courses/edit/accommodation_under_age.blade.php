@extends('superadmin.layouts.app')
@section('content')
    @include('superadmin.courses.scripts')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.add_accommodation_under_age')}}</h1>
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

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.update", $accomodation->accom_id)}}" id="courseform">
                    {{csrf_field()}}
                    @method("PUT")
                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>@lang('SuperAdmin/backend.accommodation_id')</label>
                                <select onchange="fetchAccommodationUnderAge(this.value)" class="form-control" name="accom_id[]" style="width:100%">
                                    @foreach($accomodation_under_age as $accomodation_under_all_age)
                                        <option {{$accomodation_under_age->accom_id == $accomodation_under_all_age->accom_id ? 'selected' : ''}} value="{{$accomodation_under_all_age->accom_id}}">{{$accomodation_under_all_age->accom_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @foreach ($accomodation_under_all_ages as $accomodation_under_all_age)
                            <script>
                                var rowNums = {
                                    { $accomodation_under_all_ages-> count() - 1 }
                                };
                                var inondhu = {
                                    { $accomodation_under_all_ages-> count() - 1 }
                                };
                                var accomunderagecloneselects = {
                                    { $accomodation_under_all_ages-> count() - 1 }
                                };
                            </script>
                            <div class="accomoe{{$loop->iteration - 1}}">
                                <input type="hidden" value="{{$accomodation_under_all_age->id}}" name="accom_id[]">
                                <div class="row" id="accom_under_age_clone{{$loop->iteration - 1}}">
                                    <div class="form-group col-md-4">
                                        <label for="accommodation_underage_fee">{{__('SuperAdmin/backend.age_range')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommUnderAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select name="under_age[age][{{$loop->iteration - 1}}][]" id="under_age_choose0" multiple="multiple" class="3col active">
                                            @foreach($choose_accomodation_under_ages as $choose_accomodation_under_age)
                                                <option {{in_array($choose_accomodation_under_age->unique_id, (array)$accomodation_under_all_age->under_age ?? []) ? 'selected' : ''}} value="{{$choose_accomodation_under_age->unique_id}}">{{$choose_accomodation_under_age->age}}</option>
                                            @endforeach
                                        </select>
                                        <input id="accom_increment" name="accom_increment" hidden value='{{$loop->iteration - 1}}'>
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <label>@lang('SuperAdmin/backend.add_week'):</label>
                                        <input class="form-control" type="text" value="{{$accomodation_under_all_age->under_age_fees}}" name="under_age_fee_per_week[]" placeholder="@lang('SuperAdmin/backend.add_week')">
                                    </div>
                                    <div class="form-group col-md-4 mt-4 pt-3">
                                        <i class="fa fa-plus-circle" aria-hidden="true" id="accom_plus_button" data-id="0" onclick="addAccommodationUnderAgeWeek($(this))"></i>
                                        <i class="fa fa-minus" onclick="deleteAccommodationUnderAgeWeek($(this))" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="addAccommodationUnderAge($(this), 1)" name="####">{{__('SuperAdmin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                <a href="{{route('superadmin.course.airport_medical.edit')}}" class="btn btn-primary pull-right" type="button" name="####">{{__('SuperAdmin/backend.next')}}</a>
                            </div>
                        </div>
                    </div>

                    <script>
                        function fetchAccommodationUnderAge(value) {
                            $.post("{{route('superadmin.course.accommodation_under_age.fetch')}}", {
                                _token: "{{csrf_token()}}",
                                value: value
                            }, function(data) {
                                window.location.replace(data.url);
                            });
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.courses.modals')
@endsection