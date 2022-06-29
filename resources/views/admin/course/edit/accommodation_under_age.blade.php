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

                @include('admin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ auth('superadmin')->check() ? route("superadmin.course.update", $course_id) : route("schooladmin.course.update", $course_id) }}" id="accommodation_under_age_form">
                    {{csrf_field()}}
                    @method("PUT")

                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.accommodation_id')}}</label>
                                <select onchange="fetchAccommodationUnderAge(this.value)" class="form-control" name="accom_id">
                                    @foreach($accomodations as $accomodation)
                                        <option {{$accom_id == $accomodation->unique_id ? 'selected' : ''}} value="{{$accomodation->unique_id}}">{{$accomodation->unique_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <script>
                            window.addEventListener('load', function() {
                                accommodation_under_age_clone = {{$accomodation_under_ages && $accomodation_under_ages->count() ? $accomodation_under_ages->count() - 1 : 0}};
                            }, false );
                        </script>

                        <input hidden id="accomunderageincrement" name="accomunderageincrement" value="{{$accomodation_under_ages && $accomodation_under_ages->count() ? $accomodation_under_ages->count() - 1 : 0}}">

                        @forelse($accomodation_under_ages as $accomodation_under_age)
                            <div id="accommodation_under_age_clone{{ $loop->iteration - 1 }}" class="accommodation-under-age-clone clone">
                                <input type="hidden" value="{{$accomodation_under_age->id}}" name="accom_under_age_id[]">
                                <div class="row">
                                    <div class="form-group col-md-4 under_age">
                                        <label for="age_range">{{__('Admin/backend.age_range')}}:
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i>
                                            <i onclick="deleteAccommUnderAgeRange($(this))" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                        </label>
                                        <select name="under_age[{{$loop->iteration - 1}}][]" id="under_age_choose0" multiple="multiple" class="3col active">
                                            @foreach($choose_accomodation_under_ages as $choose_accomodation_under_age)
                                                <option {{in_array($choose_accomodation_under_age->unique_id, (array)$accomodation_under_age->under_age ?? []) ? 'selected' : ''}} value="{{$choose_accomodation_under_age->unique_id}}">{{$choose_accomodation_under_age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 mt-4">
                                        <label>{{__('Admin/backend.under_age_fee_per_week')}}:</label>
                                        <input class="form-control" type="number" value="{{$accomodation_under_age->under_age_fee_per_week}}" name="under_age_fee_per_week[]" placeholder="{{__('Admin/backend.under_age_fee_per_week')}}">
                                    </div>
                                    <div class="form-group col-md-4 mt-4 pt-3">
                                        <i class="fa fa-plus-circle" aria-hidden="true" id="accom_plus_button" onclick="addAccommodationFormUnderAge($(this))"></i>
                                        <i class="fa fa-minus" onclick="deleteAccommodationUnderAge($(this))" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
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
                        @endforelse
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary" type="button" onclick="submitAccommodationUnderAgeForm($(this))">{{__('Admin/backend.submit')}}</button>
                            </div>
                            <div class="form-group col-md-6">
                                <a href="{{route('admin.course.other_service.edit')}}" class="btn btn-primary pull-right" type="button">{{__('Admin/backend.next')}}</a>
                            </div>
                        </div>
                    </div>

                    <script>
                        function fetchAccommodationUnderAge(value) {
                            $.post("{{route('admin.course.accomm_under_age.fetch')}}", {
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

    @include('admin.include.modals')
@endsection