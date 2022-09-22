@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.edit_site_setting')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.edit_site_setting')}}</h1>
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
                    <ul class="lang text-right">
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
                <form id="siteForm" class="forms-sample" enctype="multipart/form-data" method="POST" action="{{route('superadmin.setting.site.update')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.location')}}</h4></label>
                            <input name="location" type="text" class="form-control" value="{{ isset($setting_value['location']) ? $setting_value['location'] : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.email')}}</h4></label>
                            <input name="email" type="email" class="form-control" value="{{ isset($setting_value['email']) ? $setting_value['email'] : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.phone_number')}}</h4></label>
                            <input name="phone" type="text" class="form-control" value="{{ isset($setting_value['phone']) ? $setting_value['phone'] : '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.smtp')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.server')}}</h4></label>
                            <input name="smtp_server" type="text" class="form-control" value="{{ isset($setting_value['smtp']['server']) ? $setting_value['smtp']['server'] : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.user_name')}}</h4></label>
                            <input name="smtp_user_name" type="text" class="form-control" value="{{ isset($setting_value['smtp']['user_name']) ? $setting_value['smtp']['user_name'] : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.password')}}</h4></label>
                            <input name="smtp_password" type="password" class="form-control" value="" />
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.port')}}</h4></label>
                            <input name="smtp_port" type="text" class="form-control" value="{{ isset($setting_value['smtp']['port']) ? $setting_value['smtp']['port'] : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.crypto')}}</h4></label>
                            <select name="smtp_crypto" class="form-control">
                                <option value="tls" {{ (isset($setting_value['smtp']['crypto']) && $setting_value['smtp']['crypto'] == 'tls') ? 'selected' : ''}}>{{__('Admin/backend.tls')}}</option>
                                <option value="ssl" {{ (isset($setting_value['smtp']['crypto']) && $setting_value['smtp']['crypto'] == 'ssl') ? 'selected' : ''}}>{{__('Admin/backend.ssl')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.default_sender_email')}}</h4></label>
                            <input name="smtp_default_sender_email" type="email" class="form-control" value="{{ isset($setting_value['smtp']['default_sender_email']) ? $setting_value['smtp']['default_sender_email'] : '' }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label><h4>{{__('Admin/backend.default_sender_email')}}</h4></label>
                            <div class="english">
                                <input name="smtp_default_sender_name" type="text" class="form-control" value="{{ isset($setting_value['smtp']['default_sender_name']) ? $setting_value['smtp']['default_sender_name'] : '' }}" />
                            </div>
                            <div class="arabic">
                                <input name="smtp_default_sender_name_ar" type="text" class="form-control" value="{{ isset($setting_value['smtp']['default_sender_name_ar']) ? $setting_value['smtp']['default_sender_name_ar'] : '' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.newsletter')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><h4>{{__('Admin/backend.title')}}</h4></label>
                            <div class="english">
                                <input name="newsletter_title" type="text" class="form-control" value="{{ isset($setting_value['newsletter']['title']) ? $setting_value['newsletter']['title'] : '' }}" />
                            </div>
                            <div class="arabic">
                                <input name="newsletter_title_ar" type="text" class="form-control" value="{{ isset($setting_value['newsletter']['title_ar']) ? $setting_value['newsletter']['title_ar'] : '' }}" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label><h4>{{__('Admin/backend.description')}}</h4></label>
                            <div class="english">
                                <textarea class="form-control ckeditor-input" name="newsletter_description" id="newsletter_description" placeholder="{{__('Admin/backend.description')}}">{!! isset($setting_value['newsletter']['description']) ? $setting_value['newsletter']['description'] : '' !!}</textarea>
                            </div>
                            <div class="arabic">
                                <textarea class="form-control ckeditor-input" name="newsletter_description_ar" id="newsletter_description_ar" placeholder="{{__('Admin/backend.description')}}">{!! isset($setting_value['newsletter']['description_ar']) ? $setting_value['newsletter']['description_ar'] : '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.social')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.twitter')}}:</label>
                            <input type="text" class="form-control" name="social_twitter" value="{{ isset($setting_value['social']['twitter']) ? $setting_value['social']['twitter'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.facebook')}}:</label>
                            <input type="text" class="form-control" name="social_facebook" value="{{ isset($setting_value['social']['facebook']) ? $setting_value['social']['facebook'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.instagram')}}:</label>
                            <input type="text" class="form-control" name="social_instagram" value="{{ isset($setting_value['social']['instagram']) ? $setting_value['social']['instagram'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.snapchat')}}:</label>
                            <input type="text" class="form-control" name="social_snapchat" value="{{ isset($setting_value['social']['snapchat']) ? $setting_value['social']['snapchat'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.youtube')}}:</label>
                            <input type="text" class="form-control" name="social_youtube" value="{{ isset($setting_value['social']['youtube']) ? $setting_value['social']['youtube'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.tiktok')}}:</label>
                            <input type="text" class="form-control" name="social_tiktok" value="{{ isset($setting_value['social']['tiktok']) ? $setting_value['social']['tiktok'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.pinterest')}}:</label>
                            <input type="text" class="form-control" name="social_pinterest" value="{{ isset($setting_value['social']['pinterest']) ? $setting_value['social']['pinterest'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.skype')}}:</label>
                            <input type="text" class="form-control" name="social_skype" value="{{ isset($setting_value['social']['skype']) ? $setting_value['social']['skype'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.linkedin')}}:</label>
                            <input type="text" class="form-control" name="social_linkedin" value="{{ isset($setting_value['social']['linkedin']) ? $setting_value['social']['linkedin'] : '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.course_reservation_links')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>{{__('Admin/backend.registration_conditions')}}:</label>
                            <select name="course_reservation_registration_conditions" class="form-control">
                                <option value="">{{__('Admin/backend.select_option')}}</option>
                                @foreach ($front_pages as $front_page)
                                    <option value="{{ $front_page->id }}" {{$front_page->id == (isset($setting_value['course_reservation_links']['registration_conditions']) ? $setting_value['course_reservation_links']['registration_conditions'] : '') ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>{{__('Admin/backend.terms_and_conditions')}}:</label>
                            <select name="course_reservation_terms_and_conditions" class="form-control">
                                <option value="">{{__('Admin/backend.select_option')}}</option>
                                @foreach ($front_pages as $front_page)
                                    <option value="{{ $front_page->id }}" {{$front_page->id == (isset($setting_value['course_reservation_links']['terms_and_conditions']) ? $setting_value['course_reservation_links']['terms_and_conditions'] : '') ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>{{__('Admin/backend.private_policy')}}:</label>
                            <select name="course_reservation_private_policy" class="form-control">
                                <option value="">{{__('Admin/backend.select_option')}}</option>
                                @foreach ($front_pages as $front_page)
                                    <option value="{{ $front_page->id }}" {{$front_page->id == (isset($setting_value['course_reservation_links']['private_policy']) ? $setting_value['course_reservation_links']['private_policy'] : '') ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.payments')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>{{__('Admin/backend.course_application_order_number_prefix')}}:</label>
                            <input type="text" name="ca_order_number_prefix" class="form-control" value="{{ isset($setting_value['course_application']['order_number_prefix']) ? $setting_value['course_application']['order_number_prefix'] : '' }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>{{__('Admin/backend.course_application_order_number_digits')}}:</label>
                            <input type="number" name="ca_order_number_digits" class="form-control" value="{{ isset($setting_value['course_application']['order_number_digits']) ? $setting_value['course_application']['order_number_digits'] : '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.recaptcha')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.site_key')}}:</label>
                            <input type="text" name="recaptcha_site_key" class="form-control" value="{{ isset($setting_value['recaptcha']['site_key']) ? $setting_value['recaptcha']['site_key'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.secret_key')}}:</label>
                            <input type="text" name="recaptcha_secret_key" class="form-control"value="{{ isset($setting_value['recaptcha']['secret_key']) ? $setting_value['recaptcha']['secret_key'] : '' }}" />
                        </div>
                    </div>

                    <button type="button" onclick="submitFormAction('siteForm')" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection