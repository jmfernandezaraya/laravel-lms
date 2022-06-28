@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_site_setting')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_site_setting')}}</h1>
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
                    <ul class="lang text-right">
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
                <form id="siteForm" class="forms-sample" enctype="multipart/form-data" method="POST" action="{{route('superadmin.setting.site.update')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><h4>{{__('SuperAdmin/backend.email')}}</h4></label>
                            <input name="email" type="email" class="form-control" value="{{ isset($setting_value['email']) ? $setting_value['email'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label><h4>{{__('SuperAdmin/backend.phone_number')}}</h4></label>
                            <input name="phone" type="text" class="form-control" value="{{ isset($setting_value['phone']) ? $setting_value['phone'] : '' }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><h4>{{__('SuperAdmin/backend.registration_cancelation_conditions')}}</h4></label>
                            <select name="registration_cancelation_conditions" class="form-control">
                                <option value="">{{__('SuperAdmin/backend.select_option')}}</option>
                                @foreach ($front_pages as $front_page)
                                    <option value="{{ $front_page->id }}" {{$front_page->id == (isset($setting_value['registration_cancelation_conditions']) ? $setting_value['registration_cancelation_conditions'] : '') ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('SuperAdmin/backend.newsletter')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><h4>{{__('SuperAdmin/backend.title')}}</h4></label>
                            <div class="english">
                                <input name="newsletter_title" type="text" class="form-control" value="{{ isset($setting_value['newsletter']['title']) ? $setting_value['newsletter']['title'] : '' }}" />
                            </div>
                            <div class="arabic">
                                <input name="newsletter_title_ar" type="text" class="form-control" value="{{ isset($setting_value['newsletter']['title_ar']) ? $setting_value['newsletter']['title_ar'] : '' }}" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label><h4>{{__('SuperAdmin/backend.description')}}</h4></label>
                            <div class="english">
                                <textarea class="form-control ckeditor-input" name="newsletter_description" id="newsletter_description" placeholder="{{__('SuperAdmin/backend.description')}}">{!! isset($setting_value['newsletter']['description']) ? $setting_value['newsletter']['description'] : '' !!}</textarea>
                            </div>
                            <div class="arabic">
                                <textarea class="form-control ckeditor-input" name="newsletter_description_ar" id="newsletter_description_ar" placeholder="{{__('SuperAdmin/backend.description')}}">{!! isset($setting_value['newsletter']['description_ar']) ? $setting_value['newsletter']['description_ar'] : '' !!}</textarea>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('SuperAdmin/backend.social')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.twitter')}}:</label>
                            <input type="text" class="form-control" name="social_twitter" value="{{ isset($setting_value['social']['twitter']) ? $setting_value['social']['twitter'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.facebook')}}:</label>
                            <input type="text" class="form-control" name="social_facebook" value="{{ isset($setting_value['social']['facebook']) ? $setting_value['social']['facebook'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.instagram')}}:</label>
                            <input type="text" class="form-control" name="social_instagram" value="{{ isset($setting_value['social']['instagram']) ? $setting_value['social']['instagram'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.snapchat')}}:</label>
                            <input type="text" class="form-control" name="social_snapchat" value="{{ isset($setting_value['social']['snapchat']) ? $setting_value['social']['snapchat'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.youtube')}}:</label>
                            <input type="text" class="form-control" name="social_youtube" value="{{ isset($setting_value['social']['youtube']) ? $setting_value['social']['youtube'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.tiktok')}}:</label>
                            <input type="text" class="form-control" name="social_tiktok" value="{{ isset($setting_value['social']['tiktok']) ? $setting_value['social']['tiktok'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.pinterest')}}:</label>
                            <input type="text" class="form-control" name="social_pinterest" value="{{ isset($setting_value['social']['pinterest']) ? $setting_value['social']['pinterest'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.skype')}}:</label>
                            <input type="text" class="form-control" name="social_skype" value="{{ isset($setting_value['social']['skype']) ? $setting_value['social']['skype'] : '' }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.linkedin')}}:</label>
                            <input type="text" class="form-control" name="social_linkedin" value="{{ isset($setting_value['social']['linkedin']) ? $setting_value['social']['linkedin'] : '' }}" />
                        </div>
                    </div>

                    <button type="button" onclick="submitFormAction('siteForm')" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection