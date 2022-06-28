@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_school_admin')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_school_admin')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
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
                <form id="SchoolAdminForm" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.user.school_admin.update', $school_admin->id)}}" method="post">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">{{__('SuperAdmin/backend.first_name')}}</label>
                            <div class="english">
                                <input value="{{ $school_admin->first_name_en }}" name="first_name_en" class="form-control" id="first_name_en" placeholder="{{__('SuperAdmin/backend.first_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{ $school_admin->first_name_ar }}" name="first_name_ar" class="form-control" id="first_name_ar" placeholder="{{__('SuperAdmin/backend.first_name')}}" type="text">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">{{__('SuperAdmin/backend.last_name')}}</label>
                            <div class="english">
                                <input value="{{ $school_admin->last_name_en }}" name="last_name_en" class="form-control" id="last_name_en" placeholder="{{__('SuperAdmin/backend.last_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{ $school_admin->last_name_ar }}" name="last_name_ar" class="form-control" id="last_name_ar" placeholder="{{__('SuperAdmin/backend.last_name')}}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">{{__('SuperAdmin/backend.email')}}</label>
                            <input value="{{ $school_admin->email }}" name="email" class="form-control" id="email" placeholder="{{__('SuperAdmin/backend.email')}}" type="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="enter_password">{{__('SuperAdmin/backend.enter_password')}}</label>
                            <input value="" name="password" class="form-control" id="password" placeholder="{{__('SuperAdmin/backend.enter_password')}}" type="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact_no">{{__('SuperAdmin/backend.contact_no')}}</label>
                            <input value="{{ $school_admin->contact }}" name="contact" class="form-control" id="contact" placeholder="{{__('SuperAdmin/backend.contact_no')}}" type="number">
                        </div>
                        <div class="form-group col-md-6">
                            @if($school_admin->image == null || $school_admin->image == '')
                                <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            @else
                                <img src="{{asset($school_admin->image)}}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            @endif
                            <label>{{__('SuperAdmin/backend.profile_image_if_any')}}</label>
                            <input type="file" onchange="previewFile(this)" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('SuperAdmin/backend.choose_school')}}:</label>
                            <select onchange="changeSchool()" class="form-control" id="school_name" name="school_name">
                                <option value="">{{__('SuperAdmin/backend.select_school')}}</option>
                                @foreach ($choose_schools as $choose_school)
                                    <option value="{{ $choose_school }}" {{ $choose_school == $school_name ? 'selected' : '' }}>{{ $choose_school }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_name">{{__('SuperAdmin/backend.choose_country')}}:</label>
                            <select onchange="changeCountry()" class="3col active" id="country_name" name="country[]" multiple="multiple">
                                @foreach ($choose_countries as $choose_country)
                                    <option value="{{ $choose_country->id }}" {{ in_array($choose_country->id, $school_admin->country) ? 'selected' : '' }}>{{ app()->getLocale() == 'en' ?  $choose_country->name : $choose_country->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="city_name">{{__('SuperAdmin/backend.choose_city')}}:</label>
                            <select onchange="changeCity()" class="3col active" id="city_name" name="city[]" multiple="multiple">
                                @foreach ($choose_cities as $choose_city)
                                    <option value="{{ $choose_city->id }}" {{ in_array($choose_city->id, $school_admin->city) ? 'selected' : '' }}>{{ app()->getLocale() == 'en' ? $choose_city->name : $choose_city->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="branch">{{__('SuperAdmin/backend.add_branch_if_applicable')}}</label>
                            <select class="3col active" name="branch[]" id="branch_choose" multiple="multiple" class="3col active">
                                @foreach ($choose_branches as $choose_branch)
                                    <option value="{{ $choose_branch }}" {{ (app()->getLocale() == 'en' && in_array($choose_branch, $school_admin->branch) || app()->getLocale() != 'en' && in_array($choose_branch, $school_admin->branch_ar)) ? 'selected' : '' }}>{{ $choose_branch }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_permission'])
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input {{$school_admin->editCoursePermission->add == 1 ? 'checked' : ''}} name="can_add_course" type="checkbox" class="form-check-input" id="can_add_course" value='1'>
                                    <label for="can_add_course">{{__('SuperAdmin/backend.can_add_course')}}</label>
                                </div>
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input {{$school_admin->editCoursePermission->edit == 1 ? 'checked' : ''}} name="can_edit_course" type="checkbox" class="form-check-input" id="can_edit_course" value='1'>
                                    <label for="can_edit_course">{{__('SuperAdmin/backend.can_edit_course')}}</label>
                                </div>
                                <div class="form-check">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input {{$school_admin->editCoursePermission->delete == 1 ? 'checked' : ''}} name="can_delete_course" type="checkbox" class="form-check-input" id="can_delete_course" value='1'>
                                    <label for="can_delete_course">{{__('SuperAdmin/backend.can_delete_course')}}</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button onclick="submitForm($(this).parents().find('#SchoolAdminForm'))" type="button" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>
@endsection