@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.school_coutries_cities')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.school_coutries_cities')}}</h1>
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
                    <ul class="lang text-right current_page_itemm">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('admin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="countryCityForm" class="forms-sample" enctype="multipart/form-data" action="{{ auth('superadmin')->check() ? route('superadmin.school.country_city.update') : route('schooladmin.school.country_city.update') }}" method="post">
                    {{csrf_field()}}

                    <script>
                        window.addEventListener('load', function() {
                            school_country_clone = {{$countries && $countries->count() ? $countries->count() - 1 : 0}};
                        }, false );
                    </script>

                    <input hidden id="country_increment" name="country_increment" value="{{ $countries && $countries->count() ? $countries->count() - 1 : 0 }}">
                    @forelse ($countries as $country)
                        <div id="country_clone{{$loop->iteration - 1}}" class="country-clone clone">
                            <input type="hidden" value="{{ $country->id }}" type="text" id="country_id{{ $loop->iteration - 1 }}" name="country_id[]">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{__('Admin/backend.country')}}</h3>
                                    <div class="english">
                                        <input value="{{$country->name}}" class="form-control" type="text" name="name[]" placeholder="{{__('Admin/backend.name')}}">
                                    </div>
                                    <div class="arabic">
                                        <input value="{{$country->name_ar}}" class="form-control" type="text" name="name_ar[]" placeholder="{{__('Admin/backend.name')}}">
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <h3>{{__('Admin/backend.city')}}</h3>
                                    <input hidden name="city_increment[]" value="{{$country->cities->count() ? $country->cities->count() - 1 : 0}}">
                                    @forelse ($country->cities as $city)
                                        <div id="city{{$loop->parent->iteration - 1}}_clone{{$loop->iteration - 1}}" class="city-clone clone form-group">
                                            <input type="hidden" value="{{ $city->id }}" type="text" id="city{{$loop->parent->iteration - 1}}_id{{ $loop->iteration - 1 }}" name="city_id[{{$loop->parent->iteration - 1}}][]">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="english">
                                                        <input value="{{$city->name}}" class="form-control" type="text" name="city_name[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('Admin/backend.name')}}">
                                                    </div>
                                                    <div class="arabic">
                                                        <input value="{{$city->name_ar}}" class="form-control" type="text" name="city_name_ar[{{$loop->parent->iteration - 1}}][]" placeholder="{{__('Admin/backend.name')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addSchoolCityForm($(this))"></i>
                                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteSchoolCityForm($(this))"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div id="city{{$loop->iteration - 1}}_clone0" class="city-clone clone form-group">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="english">
                                                        <input value="" class="form-control" type="text" name="city_name[{{$loop->iteration - 1}}][]" placeholder="{{__('Admin/backend.name')}}">
                                                    </div>
                                                    <div class="arabic">
                                                        <input value="" class="form-control" type="text" name="city_name_ar[{{$loop->iteration - 1}}][]" placeholder="{{__('Admin/backend.name')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addSchoolCityForm($(this))"></i>
                                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteSchoolCityForm($(this))"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                    
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">
                                    <button class="btn btn-primary fa fa-plus-circle" type="button" onclick="addSchoolCountryForm($(this))"></button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteSchoolCountryForm($(this))"></button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="country_clone0" class="country-clone clone">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{__('Admin/backend.country')}}</h3>
                                    <div class="english">
                                        <input value="" class="form-control" type="text" name="name[]" placeholder="{{__('Admin/backend.name')}}">
                                    </div>
                                    <div class="arabic">
                                        <input value="" class="form-control" type="text" name="name_ar[]" placeholder="{{__('Admin/backend.name')}}">
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <h3>{{__('Admin/backend.city')}}</h3>
                                    <input hidden name="city_increment[]" value="0">
                                    <div id="city0_clone0" class="city-clone clone form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="english">
                                                    <input value="" class="form-control" type="text" name="city_name[0][]" placeholder="{{__('Admin/backend.name')}}">
                                                </div>
                                                <div class="arabic">
                                                    <input value="" class="form-control" type="text" name="city_name_ar[0][]" placeholder="{{__('Admin/backend.name')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <i class="fa fa-plus-circle" aria-hidden="true" onclick="addSchoolCityForm($(this))"></i>
                                                <i class="fa fa-minus" aria-hidden="true" onclick="deleteSchoolCityForm($(this))"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">
                                    <button class="btn btn-primary fa fa-plus-circle" type="button" onclick="addSchoolCountryForm($(this))"></button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteSchoolCountryForm($(this))"></button>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    <button type="button" onclick="submitForm($(this).parents().find('#countryCityForm'))" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection