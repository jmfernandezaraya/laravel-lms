@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_super_admin')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_super_admin')}}</h1>
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
                <form id="SuperAdminForm" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.user.super_admin.update', $super_admin->id)}}" method="post">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">{{__('SuperAdmin/backend.first_name')}}</label>
                            <div class="english">
                                <input value="{{ $super_admin->first_name_en }}" name="first_name_en" class="form-control" id="first_name_en" placeholder="{{__('SuperAdmin/backend.first_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{ $super_admin->first_name_ar }}" name="first_name_ar" class="form-control" id="first_name_ar" placeholder="{{__('SuperAdmin/backend.first_name')}}" type="text">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">{{__('SuperAdmin/backend.last_name')}}</label>
                            <div class="english">
                                <input value="{{ $super_admin->last_name_en }}" name="last_name_en" class="form-control" id="last_name_en" placeholder="{{__('SuperAdmin/backend.last_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{ $super_admin->last_name_ar }}" name="last_name_ar" class="form-control" id="last_name_ar" placeholder="{{__('SuperAdmin/backend.last_name')}}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">{{__('SuperAdmin/backend.email')}}</label>
                            <input value="{{ $super_admin->email }}" name="email" class="form-control" id="email" placeholder="{{__('SuperAdmin/backend.email')}}" type="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="enter_password">{{__('SuperAdmin/backend.enter_password')}}</label>
                            <input value="" name="password" class="form-control" id="password" placeholder="{{__('SuperAdmin/backend.email')}}" type="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact_no">{{__('SuperAdmin/backend.contact_no')}}</label>
                            <input value="{{ $super_admin->contact }}" name="contact" class="form-control" id="contact" placeholder="{{__('SuperAdmin/backend.contact_no')}}" type="number">
                        </div>
                        <div class="form-group col-md-6">
                            @if ($super_admin->image == null || $users->image == '')
                                <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            @else
                                <img src="{{asset($super_admin->image)}}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            @endif
                            <label>{{__('SuperAdmin/backend.profile_image_if_any')}}</label>
                            <input type="file" onchange="previewFile(this)" class="form-control" name="image">
                        </div>
                    </div>
                    @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_permission'])
                        <div class="row">
                            <div class="form-group col-md-12">
                                <h4>{{__('SuperAdmin/backend.permissions')}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="blog_permission">{{__('SuperAdmin/backend.blog')}}</label>
                                <select name="blog_permission" id="blog_permission" class="form-control">
                                    <option value="">{{__('SuperAdmin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($super_admin->permission && !$super_admin->permission->blog_manager && ($super_admin->permission->blog_add || $super_admin->permission->blog_edit)) ? 'selected' : '' }}>{{__('SuperAdmin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($super_admin->permission && $super_admin->permission->blog_manager) ? 'selected' : '' }}>{{__('SuperAdmin/backend.manager')}}</option>
                                </select>
                                <div class="blog-permissions" style="display: {{ ($super_admin->permission && !$super_admin->permission->blog_manager && ($super_admin->permission->blog_add || $super_admin->permission->blog_edit)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="blog_add" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->blog_add) ? 'checked' : '' }}>
                                        <label for="blog_add">{{__('SuperAdmin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="blog_edit" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->blog_edit) ? 'checked' : '' }}>
                                        <label for="blog_edit">{{__('SuperAdmin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="school_permission">{{__('SuperAdmin/backend.school')}}</label>
                                <select name="school_permission" id="school_permission" class="form-control">
                                    <option value="">{{__('SuperAdmin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($super_admin->permission && !$super_admin->permission->school_manager && ($super_admin->permission->school_add || $super_admin->permission->school_edit)) ? 'selected' : '' }}>{{__('SuperAdmin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($super_admin->permission && $super_admin->permission->school_manager) ? 'selected' : '' }}>{{__('SuperAdmin/backend.manager')}}</option>
                                </select>
                                <div class="school-permissions" style="display: {{ ($super_admin->permission && !$super_admin->permission->school_manager && ($super_admin->permission->school_add || $super_admin->permission->school_edit)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="school_add" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->school_add) ? 'checked' : '' }}>
                                        <label for="school_add">{{__('SuperAdmin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="school_edit" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->school_edit) ? 'checked' : '' }}>
                                        <label for="school_edit">{{__('SuperAdmin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_permission">{{__('SuperAdmin/backend.course')}}</label>
                                <select name="course_permission" id="course_permission" class="form-control">
                                    <option value="">{{__('SuperAdmin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($super_admin->permission && !$super_admin->permission->course_manager && ($super_admin->permission->course_add || $super_admin->permission->course_edit || $super_admin->permission->course_display || $super_admin->permission->course_delete)) ? 'selected' : '' }}>{{__('SuperAdmin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($super_admin->permission && $super_admin->permission->course_manager) ? 'selected' : '' }}>{{__('SuperAdmin/backend.manager')}}</option>
                                </select>
                                <div class="course-permissions" style="display: {{ ($super_admin->permission && !$super_admin->permission->course_manager && ($super_admin->permission->course_add || $super_admin->permission->course_edit || $super_admin->permission->course_display || $super_admin->permission->course_delete)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="course_add" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_add) ? 'checked' : '' }}>
                                        <label for="course_add">{{__('SuperAdmin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_edit" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_edit) ? 'checked' : '' }}>
                                        <label for="course_edit">{{__('SuperAdmin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_display" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_display) ? 'checked' : '' }}>
                                        <label for="course_display">{{__('SuperAdmin/backend.display')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_delete" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_delete) ? 'checked' : '' }}>
                                        <label for="course_delete">{{__('SuperAdmin/backend.delete')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="currency_permission">{{__('SuperAdmin/backend.currency')}}</label>
                                <select name="currency_permission" id="currency_permission" class="form-control">
                                    <option value="">{{__('SuperAdmin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($super_admin->permission && !$super_admin->permission->currency_manager && $super_admin->permission->currency_edit) ? 'selected' : '' }}>{{__('SuperAdmin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($super_admin->permission && $super_admin->permission->currency_manager) ? 'selected' : '' }}>{{__('SuperAdmin/backend.manager')}}</option>
                                </select>
                                <div class="currency-permissions" style="display: {{ ($super_admin->permission && !$super_admin->permission->currency_manager && $super_admin->permission->currency_edit) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="currency_edit" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->currency_edit) ? 'checked' : '' }}>
                                        <label for="currency_edit">{{__('SuperAdmin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_application_permission">{{__('SuperAdmin/backend.course_application')}}</label>
                                <select name="course_application_permission" id="course_application_permission" class="form-control">
                                    <option value="">{{__('SuperAdmin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($super_admin->permission && !$super_admin->permission->course_application_manager && ($super_admin->permission->course_application_edit || $super_admin->permission->course_application_chanage_status || $super_admin->permission->course_application_payment_refund || $super_admin->permission->course_application_contact_student || $super_admin->permission->course_application_contact_school)) ? 'selected' : '' }}>{{__('SuperAdmin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($super_admin->permission && $super_admin->permission->course_application_manager) ? 'selected' : '' }}>{{__('SuperAdmin/backend.manager')}}</option>
                                </select>
                                <div class="course-application-permissions" style="display: {{ ($super_admin->permission && !$super_admin->permission->course_application_manager && ($super_admin->permission->course_application_edit || $super_admin->permission->course_application_chanage_status || $super_admin->permission->course_application_payment_refund || $super_admin->permission->course_application_contact_student || $super_admin->permission->course_application_contact_school)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="course_application_edit" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_application_edit) ? 'checked' : '' }}>
                                        <label for="course_application_edit">{{__('SuperAdmin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_chanage_status" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_application_chanage_status) ? 'checked' : '' }}>
                                        <label for="course_application_chanage_status">{{__('SuperAdmin/backend.chanage_status')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_payment_refund" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_application_payment_refund) ? 'checked' : '' }}>
                                        <label for="course_application_payment_refund">{{__('SuperAdmin/backend.payments_refunds_statement')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_contact_student" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_application_contact_student) ? 'checked' : '' }}>
                                        <label for="course_application_contact_student">{{__('SuperAdmin/backend.contact_center_student')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_contact_school" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->course_application_contact_school) ? 'checked' : '' }}>
                                        <label for="course_application_contact_school">{{__('SuperAdmin/backend.contact_center_school')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_permission">{{__('SuperAdmin/backend.user')}}</label>
                                <select name="user_permission" id="user_permission" class="form-control">
                                    <option value="">{{__('SuperAdmin/backend.select_role')}}</option>
                                    <option value="subscriber" {{ ($super_admin->permission && !$super_admin->permission->user_manager && ($super_admin->permission->user_add || $super_admin->permission->user_edit || $super_admin->permission->user_delete || $super_admin->permission->user_permission)) ? 'selected' : '' }}>{{__('SuperAdmin/backend.subscriber')}}</option>
                                    <option value="manager" {{ ($super_admin->permission && $super_admin->permission->user_manager) ? 'selected' : '' }}>{{__('SuperAdmin/backend.manager')}}</option>
                                </select>
                                <div class="user-permissions" style="display: {{ ($super_admin->permission && !$super_admin->permission->user_manager && ($super_admin->permission->user_add || $super_admin->permission->user_edit || $super_admin->permission->user_delete || $super_admin->permission->user_permission)) ? 'display' : 'none' }}">
                                    <div class="form-check">
                                        <input name="user_add" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->user_add) ? 'checked' : '' }}>
                                        <label for="user_add">{{__('SuperAdmin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="user_edit" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->user_edit) ? 'checked' : '' }}>
                                        <label for="user_edit">{{__('SuperAdmin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="user_delete" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->user_delete) ? 'checked' : '' }}>
                                        <label for="user_delete">{{__('SuperAdmin/backend.delete')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="user_permissions" type="checkbox" class="form-check-inline" value='1' {{ ($super_admin->permission && $super_admin->permission->user_permission) ? 'checked' : '' }}>
                                        <label for="user_permissions">{{__('SuperAdmin/backend.permission')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button onclick="submitForm($(this).parents().find('#SuperAdminForm'))" type="button" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
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

        $('#blog_permission').change(function() {
            if ($('#blog_permission').val() == 'subscriber') {
                $('.blog-permissions').show();
            } else {
                $('.blog-permissions').hide();
            }
        });

        $('#school_permission').change(function() {
            if ($('#school_permission').val() == 'subscriber') {
                $('.school-permissions').show();
            } else {
                $('.school-permissions').hide();
            }
        });

        $('#course_permission').change(function() {
            if ($('#course_permission').val() == 'subscriber') {
                $('.course-permissions').show();
            } else {
                $('.course-permissions').hide();
            }
        });

        $('#currency_permission').change(function() {
            if ($('#currency_permission').val() == 'subscriber') {
                $('.currency-permissions').show();
            } else {
                $('.currency-permissions').hide();
            }
        });

        $('#course_application_permission').change(function() {
            if ($('#course_application_permission').val() == 'subscriber') {
                $('.course-application-permissions').show();
            } else {
                $('.course-application-permissions').hide();
            }
        });

        $('#user_permission').change(function() {
            if ($('#user_permission').val() == 'subscriber') {
                $('.user-permissions').show();
            } else {
                $('.user-permissions').hide();
            }
        });
    </script>
@endsection