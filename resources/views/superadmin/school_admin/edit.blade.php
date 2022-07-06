@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.edit_school_admin')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.edit_school_admin')}}</h1>
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
                <form id="SchoolAdminForm" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.user.school_admin.update', $school_admin->id)}}" method="post">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">{{__('Admin/backend.first_name')}}</label>
                            <div class="english">
                                <input value="{{ $school_admin->first_name_en }}" name="first_name_en" class="form-control" id="first_name_en" placeholder="{{__('Admin/backend.first_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{ $school_admin->first_name_ar }}" name="first_name_ar" class="form-control" id="first_name_ar" placeholder="{{__('Admin/backend.first_name')}}" type="text">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">{{__('Admin/backend.last_name')}}</label>
                            <div class="english">
                                <input value="{{ $school_admin->last_name_en }}" name="last_name_en" class="form-control" id="last_name_en" placeholder="{{__('Admin/backend.last_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{ $school_admin->last_name_ar }}" name="last_name_ar" class="form-control" id="last_name_ar" placeholder="{{__('Admin/backend.last_name')}}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">{{__('Admin/backend.email')}}</label>
                            <input value="{{ $school_admin->email }}" name="email" class="form-control" id="email" placeholder="{{__('Admin/backend.email')}}" type="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="enter_password">{{__('Admin/backend.enter_password')}}</label>
                            <input value="" name="password" class="form-control" id="password" placeholder="{{__('Admin/backend.enter_password')}}" type="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact_no">{{__('Admin/backend.contact_no')}}</label>
                            <input value="{{ $school_admin->contact }}" name="contact" class="form-control" id="contact" placeholder="{{__('Admin/backend.contact_no')}}" type="number">
                        </div>
                        <div class="form-group col-md-6">
                            @if($school_admin->image == null || $school_admin->image == '')
                                <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            @else
                                <img src="{{asset($school_admin->image)}}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            @endif
                            <label>{{__('Admin/backend.profile_image_if_any')}}</label>
                            <input type="file" onchange="previewFile(this)" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('Admin/backend.choose_school')}}:</label>
                            <select onchange="changeSchool()" class="form-control" id="school_name" name="school_name">
                                <option value="">{{__('Admin/backend.select_school')}}</option>
                                @foreach ($choose_schools as $choose_school)
                                    <option value="{{ $choose_school }}" {{ $choose_school == $school_name ? 'selected' : '' }}>{{ $choose_school }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_name">{{__('Admin/backend.choose_country')}}:</label>
                            <select onchange="changeCountry()" class="3col active" id="country_name" name="country[]" multiple="multiple">
                                @foreach ($choose_countries as $choose_country)
                                    <option value="{{ $choose_country->id }}" {{ in_array($choose_country->id, $school_admin->country) ? 'selected' : '' }}>{{ app()->getLocale() == 'en' ?  $choose_country->name : $choose_country->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="city_name">{{__('Admin/backend.choose_city')}}:</label>
                            <select onchange="changeCity()" class="3col active" id="city_name" name="city[]" multiple="multiple">
                                @foreach ($choose_cities as $choose_city)
                                    <option value="{{ $choose_city->id }}" {{ in_array($choose_city->id, $school_admin->city) ? 'selected' : '' }}>{{ app()->getLocale() == 'en' ? $choose_city->name : $choose_city->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="branch">{{__('Admin/backend.add_branch_if_applicable')}}</label>
                            <select class="3col active" name="branch[]" id="branch_choose" multiple="multiple" class="3col active">
                                @foreach ($choose_branches as $choose_branch)
                                    <option value="{{ $choose_branch }}" {{ (app()->getLocale() == 'en' && in_array($choose_branch, $school_admin->branch) || app()->getLocale() != 'en' && in_array($choose_branch, $school_admin->branch_ar)) ? 'selected' : '' }}>{{ $choose_branch }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    @if (can_manage_user() || can_permission_user())
                        <div class="row">
                            <div class="form-group col-md-12">
                                <h4>{{__('Admin/backend.permissions')}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="school_permission">{{__('Admin/backend.school')}}</label>
                                <select name="school_permission" id="school_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($school_admin->permission && !$school_admin->permission->school_manager && ($school_admin->permission->school_add || $school_admin->permission->school_edit)) ? 'selected' : '' }}>{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($school_admin->permission && $school_admin->permission->school_manager) ? 'selected' : '' }}>{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="school-permissions" style="display: {{ ($school_admin->permission && !$school_admin->permission->school_manager && ($school_admin->permission->school_add || $school_admin->permission->school_edit)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="school_add" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->school_add) ? 'checked' : '' }}>
                                        <label for="school_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="school_edit" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->school_edit) ? 'checked' : '' }}>
                                        <label for="school_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="course_permission">{{__('Admin/backend.course')}}</label>
                                <select name="course_permission" id="course_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($school_admin->permission && !$school_admin->permission->course_manager && ($school_admin->permission->course_add || $school_admin->permission->course_edit || $school_admin->permission->course_display || $school_admin->permission->course_delete)) ? 'selected' : '' }}>{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($school_admin->permission && $school_admin->permission->course_manager) ? 'selected' : '' }}>{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="course-permissions" style="display: {{ ($school_admin->permission && !$school_admin->permission->course_manager && ($school_admin->permission->course_add || $school_admin->permission->course_edit || $school_admin->permission->course_display || $school_admin->permission->course_delete)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="course_add" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_add) ? 'checked' : '' }}>
                                        <label for="course_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_edit" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_edit) ? 'checked' : '' }}>
                                        <label for="course_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_display" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_display) ? 'checked' : '' }}>
                                        <label for="course_display">{{__('Admin/backend.display')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_delete" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_delete) ? 'checked' : '' }}>
                                        <label for="course_delete">{{__('Admin/backend.delete')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_application_permission">{{__('Admin/backend.course_application')}}</label>
                                <select name="course_application_permission" id="course_application_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($school_admin->permission && !$school_admin->permission->course_application_manager && ($school_admin->permission->course_application_edit || $school_admin->permission->course_application_chanage_status || $school_admin->permission->course_application_payment_refund || $school_admin->permission->course_application_contact_student || $school_admin->permission->course_application_contact_school)) ? 'selected' : '' }}>{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($school_admin->permission && $school_admin->permission->course_application_manager) ? 'selected' : '' }}>{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="course-application-permissions" style="display: {{ ($school_admin->permission && !$school_admin->permission->course_application_manager && ($school_admin->permission->course_application_edit || $school_admin->permission->course_application_chanage_status || $school_admin->permission->course_application_payment_refund || $school_admin->permission->course_application_contact_student || $school_admin->permission->course_application_contact_school)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="course_application_edit" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_application_edit) ? 'checked' : '' }}>
                                        <label for="course_application_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_chanage_status" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_application_chanage_status) ? 'checked' : '' }}>
                                        <label for="course_application_chanage_status">{{__('Admin/backend.chanage_status')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_payment_refund" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_application_payment_refund) ? 'checked' : '' }}>
                                        <label for="course_application_payment_refund">{{__('Admin/backend.payments_refunds_statement')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_contact_student" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_application_contact_student) ? 'checked' : '' }}>
                                        <label for="course_application_contact_student">{{__('Admin/backend.contact_center_student')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_contact_school" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->course_application_contact_school) ? 'checked' : '' }}>
                                        <label for="course_application_contact_school">{{__('Admin/backend.contact_center_school')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="review_permission">{{__('Admin/backend.review')}}</label>
                                <select name="review_permission" id="review_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($school_admin->permission && !$school_admin->permission->review_manager && ($school_admin->permission->review_add || $school_admin->permission->review_edit || $school_admin->permission->review_delete || $school_admin->permission->review_permission)) ? 'selected' : '' }}>{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($school_admin->permission && $school_admin->permission->review_manager) ? 'selected' : '' }}>{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="review-permissions" style="display: {{ ($school_admin->permission && !$school_admin->permission->review_manager && ($school_admin->permission->review_add || $school_admin->permission->review_edit || $school_admin->permission->review_delete || $school_admin->permission->review_permission)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="review_edit" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->review_edit) ? 'checked' : '' }}>
                                        <label for="review_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="review_approve" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->review_approve) ? 'checked' : '' }}>
                                        <label for="review_approve">{{__('Admin/backend.approve')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="review_delete" type="checkbox" class="form-check-inline" value='1' {{ ($school_admin->permission && $school_admin->permission->review_delete) ? 'checked' : '' }}>
                                        <label for="review_delete">{{__('Admin/backend.delete')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button onclick="submitForm($(this).parents().find('#SchoolAdminForm'))" type="button" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
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