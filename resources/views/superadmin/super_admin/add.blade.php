@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_super_admin')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_super_admin')}}</h1>
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
                <form id="SuperAdminForm" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.user.super_admin.store')}}" method="post">
                    {{csrf_field()}}
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">{{__('Admin/backend.first_name')}}</label>
                            <div class="english">
                                <input name="first_name_en" value="{{old('first_name_en')}}" class="form-control" id="first_name_en" placeholder="{{__('Admin/backend.first_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input name="first_name_ar" value="{{old('first_name_ar')}}" class="form-control" id="first_name_ar" placeholder="{{__('Admin/backend.first_name')}}" type="text">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">{{__('Admin/backend.last_name')}}</label>
                            <div class="english">
                                <input name="last_name_en" value="{{old('last_name_en')}}" class="form-control" id="last_name_en" placeholder="{{__('Admin/backend.last_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input name="last_name_ar" value="{{old('last_name_ar')}}" class="form-control" id="last_name_ar" placeholder="{{__('Admin/backend.last_name')}}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">{{__('Admin/backend.email')}}</label>
                            <input name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="{{__('Admin/backend.first_name')}}" type="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">{{__('Admin/backend.enter_password')}}</label>
                            <input name="password" value="{{old('password')}}" class="form-control" id="password" placeholder="{{__('Admin/backend.enter_password')}}" type="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact_no">{{__('Admin/backend.contact_no')}}</label>
                            <input value="{{old('contact')}}" name="contact" class="form-control" id="exampleSelectGender" placeholder="{{__('Admin/backend.contact_no')}}" type="number">
                        </div>
                        <div class="form-group col-md-6">
                            <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            <label>{{__('Admin/backend.profile_image_if_any')}}</label>
                            <input type="file" onchange="previewFile(this)" class="form-control" name="image">
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
                                <label for="blog_permission">{{__('Admin/backend.blog')}}</label>
                                <select name="blog_permission" id="blog_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber">{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager">{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="blog-permissions" style="display: none">
                                    <div class="form-check">
                                        <input name="blog_add" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="blog_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="blog_edit" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="blog_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="school_permission">{{__('Admin/backend.school')}}</label>
                                <select name="school_permission" id="school_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber">{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager">{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="school-permissions" style="display: none">
                                    <div class="form-check">
                                        <input name="school_add" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="school_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="school_edit" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="school_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_permission">{{__('Admin/backend.course')}}</label>
                                <select name="course_permission" id="course_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber">{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager">{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="course-permissions" style="display: none">
                                    <div class="form-check">
                                        <input name="course_add" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_edit" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_display" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_display">{{__('Admin/backend.display')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_delete" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_delete">{{__('Admin/backend.delete')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="currency_permission">{{__('Admin/backend.currency')}}</label>
                                <select name="currency_permission" id="currency_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber">{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager">{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="currency-permissions" style="display: none">
                                    <div class="form-check">
                                        <input name="currency_add" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="currency_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="currency_edit" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="currency_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_application_permission">{{__('Admin/backend.course_application')}}</label>
                                <select name="course_application_permission" id="course_application_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber">{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager">{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="course-application-permissions" style="display: none">
                                    <div class="form-check">
                                        <input name="course_application_edit" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_application_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_chanage_status" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_application_chanage_status">{{__('Admin/backend.chanage_status')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_payment_refund" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_application_payment_refund">{{__('Admin/backend.payments_refunds_statement')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_contact_student" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_application_contact_student">{{__('Admin/backend.contact_center_student')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="course_application_contact_school" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="course_application_contact_school">{{__('Admin/backend.contact_center_school')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_permission">{{__('Admin/backend.user')}}</label>
                                <select name="user_permission" id="user_permission" class="form-control">
                                    <option value="">{{__('Admin/backend.select_role')}}</option>
                                    <option value="subscriber">{{__('Admin/backend.subscriber')}}</option>
                                    <option value="manager">{{__('Admin/backend.manager')}}</option>
                                </select>
                                <div class="user-permissions" style="display: none }}">
                                    <div class="form-check">
                                        <input name="user_add" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="user_add">{{__('Admin/backend.add')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="user_edit" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="user_edit">{{__('Admin/backend.edit')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="user_delete" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="user_delete">{{__('Admin/backend.delete')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="user_permissions" type="checkbox" class="form-check-inline" value='1'>
                                        <label for="user_permissions">{{__('Admin/backend.permission')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button onclick="submitForm($(this).parents().find('#SuperAdminForm'))" type="button" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                </div>
            </div>
        </form>
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