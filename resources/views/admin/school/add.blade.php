@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_school')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_school')}}</h1>
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

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="schoolForm" class="forms-sample" enctype="multipart/form-data" action="{{ auth('superadmin')->check() ? route('superadmin.school.store') : route('schooladmin.school.store') }}" method="post">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name_id">{{__('Admin/backend.name')}}</label>
                            <select onchange="changeSchool()" name="name_id" id="school_name" class="form-control">
                                <option value="">{{__('Admin/backend.select')}}</option>
                                @foreach ($school_names as $school_name)
                                    <option value="{{app()->getLocale() == 'en' ? $school_name->name : $school_name->name_ar}}">{{app()->getLocale() == 'en' ? $school_name->name : $school_name->name_ar}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_id">{{__('Admin/backend.country')}}</label>
                            <select onchange="changeSchoolCountry()" name="country_id" id="country_ids" class="form-control">
                                <option value="">{{__('Admin/backend.select')}}</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{app()->getLocale() == 'en' ? $country->name : $country->name_ar}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <div class="alert alert-danger">{{$errors->first('country')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="city_id">{{__('Admin/backend.city')}}</label>
                            <select name="city_id" id="city_ids" class="form-control">
                                <option value="">{{__('Admin/backend.select')}}</option>
                            </select>
                            @if ($errors->has('city'))
                                <div class="alert alert-danger">{{$errors->first('city')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="branch_name">{{__('Admin/backend.branch_name')}}</label>
                            <div class="english">
                                <input name="branch_name" class="form-control" id="branch_name" placeholder="{{__('Admin/backend.branch_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input name="branch_name_ar" class="form-control" id="branch_name_ar" placeholder="{{__('Admin/backend.branch_name')}}" type="text">
                            </div>
                            @if ($errors->has('branch_name'))
                                <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">{{__('Admin/backend.email_address')}}</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="{{__('Admin/backend.email_address')}}">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact">{{__('Admin/backend.contact_number')}}</label>
                            <input name="contact" class="form-control" id="contact" placeholder="{{__('Admin/backend.contact_number')}}" type="text">
                            @if ($errors->has('contact'))
                                <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="emergency_number">{{__('Admin/backend.emergency_number')}}</label>
                            <input name="emergency_number" type="text" class="form-control" id="emergency_number" placeholder="{{__('Admin/backend.emergency_number')}}">
                            @if ($errors->has('emergency_number'))
                                <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="capacity">{{__('Admin/backend.capacity')}}</label>
                            <input name="capacity" type="text" class="form-control" id="capacity" placeholder="{{__('Admin/backend.capacity')}}">
                            @if ($errors->has('capacity'))
                                <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="facilities">{{__('Admin/backend.facilities')}}</label>
                            <div class="english">
                                <textarea name="facilities" class="form-control ckeditor-input" id="facilities_textarea" rows="4"></textarea>
                            </div>
                            <div class="arabic">
                                <textarea name="facilities_ar" class="form-control ckeditor-input" id="facilities_ar_textarea" rows="4"></textarea>
                            </div>
                            @if ($errors->has('facilities'))
                                <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="class_size">{{__('Admin/backend.class_size')}}</label>
                            <div class="english">
                                <input name="class_size" type="text" class="form-control" id="class_size" placeholder="{{__('Admin/backend.class_size')}}">
                            </div>
                            <div class="arabic">
                                <input name="class_size_ar" type="text" class="form-control" id="class_size_ar" placeholder="{{__('Admin/backend.class_size')}}">
                            </div>
                            @if ($errors->has('class_size'))
                                <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="year_opened">{{__('Admin/backend.year_opened')}}</label>
                            <input name="opened" type="text" class="form-control" placeholder="{{__('Admin/backend.year_opened')}}">
                            @if ($errors->has('opened'))
                                <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="opening_hours">{{__('Admin/backend.opening_hours')}}</label>
                            <div class="english">
                                <input name="opening_hours" type="text" class="form-control" id="opening_hours" placeholder="{{__('Admin/backend.opening_hours')}}">
                            </div>
                            <div class="arabic">
                                <input name="opening_hours_ar" type="text" class="form-control" id="opening_hours_ar" placeholder="{{__('Admin/backend.opening_hours')}}">
                            </div>
                            @if ($errors->has('opening_hours'))
                                <div class="alert alert-danger">{{$errors->first('opening_hours')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="number_of_classrooms">{{__('Admin/backend.number_of_classrooms')}}</label>
                            <input name="number_of_classrooms" type="text" class="form-control" id="number_of_classrooms" placeholder="{{__('Admin/backend.number_of_classrooms')}}">
                            @if ($errors->has('number_of_classrooms'))
                                <div class="alert alert-danger">{{$errors->first('number_of_classrooms')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <h3>{{__('Admin/backend.nationality_mix')}}</h3>
                        </div>

                        <input hidden id="nationality_increment" name="nationality_increment" value="0">
                        <div id="nationality_clone0" class="nationality-clone clone form-group col-md-12">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6 nationality">
                                            <label for="choose_nationality">
                                                {{__('Admin/backend.choose_nationality')}}:
                                            </label>
                                            <select name="nationality[]" id="school_nationality_choose0" class="form-control" onchange="changeSchoolNationality($(this))">
                                                <option value="">{{__('Admin/backend.select')}}</option>
                                                @foreach ($choose_nationalities as $choose_nationality)
                                                    <option value="{{ $choose_nationality->unique_id }}">{{ app()->getLocale() == 'en' ? $choose_nationality->name : $choose_nationality->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="choose_nationality">{{__('Admin/backend.mix')}}:</label>
                                            <input name="nationality_mix[]" onchange="changeShcoolNationalityMix($(this))" type="number" class="form-control" id="nationality_mix0" placeholder="{{__('Admin/backend.mix')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4 pt-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addSchoolNationalityForm($(this))"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteSchoolNationalityForm($(this))"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="about_the_school">{{__('Admin/backend.about_the_school')}}</label>
                            <div class="english">
                                <textarea name="about" class="form-control ckeditor-input" id="about_textarea" rows="4"></textarea>
                            </div>
                            <div class="arabic">
                                <textarea name="about_ar" class="form-control ckeditor-input" id="about_ar_textarea" rows="4"></textarea>
                            </div>
                            @if ($errors->has('about'))
                                <div class="alert alert-danger">{{$errors->first('about')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="address">{{__('Admin/backend.address')}}</label>
                            <input name="address" class="form-control" id="address" placeholder="{{__('Admin/backend.address_map_location')}}" type="text">
                            @if ($errors->has('address'))
                                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="logos">{{__('Admin/backend.accreditations_logos')}}</label>
                            <input name="logos[]" multiple type="file" class="form-control" id="logos" accept="image/*">
                            @if ($errors->has('logos'))
                                <div class="alert alert-danger">{{$errors->first('logos')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="logo">{{__('Admin/backend.logo')}}</label>
                            <input name="logo" type="file" class="form-control" id="logo" accept="image/*">
                            @if ($errors->has('logo'))
                                <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="video">{{__('Admin/backend.video')}}</label>
                            <ul id="videoUrl"></ul>
                            @if ($errors->has('video_url'))
                                <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="website_link">{{__('Admin/backend.website_link')}}</label>
                            <input name="website_link" type="text" class="form-control" id="website_link" placeholder="{{__('Admin/backend.website_link')}}">
                            @if ($errors->has('website_link'))
                                <div class="alert alert-danger">{{$errors->first('website_link')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="photos">{{__('Admin/backend.photos')}}</label>
                            <input name="multiple_photos[]" multiple type="file" class="form-control" id="photos" accept="image/*">
                            @if ($errors->has('multiple_photos'))
                                <div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
                            @endif
                        </div>
                    </div>

                    <button type="button" onclick="submitForm($(this).parents().find('#schoolForm'))" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>

    @include('admin.include.modals')
    
    @section('js')
        <script>
            var uploadFileOption = "{{ auth('superadmin')->check() ? route('superadmin.school.upload', ['_token' => csrf_token() ]) : route('schooladmin.school.upload', ['_token' => csrf_token() ]) }}";
            $(document).ready(function () {
                $("#videoUrl").tagit({
                    fieldName: "video_url[]"
                });
            });
        </script>
    @endsection
@endsection