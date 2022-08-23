@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_email_template')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_email_template')}}</h1>
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
                <form id="emailTemplateForm" class="forms-sample" method="post" action="{{route('superadmin.email_template.store')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-12 mb-0">
                            <h3 class="mb-0">{{__('Admin/backend.template')}}</h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group col-md-4">
                            <label for="name">{{__('Admin/backend.name')}}</label>
                            <input name="name" type="text" class="form-control" placeholder="{{__('Admin/backend.name')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="template">{{__('Admin/backend.template')}}</label>
                            <input name="template" type="email" class="form-control" placeholder="{{__('Admin/backend.template')}}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-12 mb-0">
                            <h3 class="mb-0">{{__('Admin/backend.smtp')}}</h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group col-md-4">
                            <label for="smtp_server">{{__('Admin/backend.smtp_server')}}</label>
                            <input value="{{$smtp_setting->server}}" name="smtp_server" type="text" class="form-control" placeholder="{{__('Admin/backend.smtp_server')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="smtp_user_name">{{__('Admin/backend.smtp_user_name')}}</label>
                            <input value="{{$smtp_setting->user_name}}" name="smtp_user_name" type="email" class="form-control" placeholder="{{__('Admin/backend.smtp_user_name')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="smtp_password">{{__('Admin/backend.smtp_password')}}</label>
                            <input value="" name="smtp_password" type="password" class="form-control" placeholder="{{__('Admin/backend.smtp_password')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group col-md-4">
                            <label for="smtp_port">{{__('Admin/backend.smtp_port')}}</label>
                            <input value="{{$smtp_setting->port}}" name="smtp_port" type="number" class="form-control" placeholder="{{__('Admin/backend.smtp_port')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sender_name">{{__('Admin/backend.sender_name')}}</label>
                            <div class="english">
                                <input value="{{$smtp_setting->default_sender_name}}" name="sender_name" type="text" class="form-control" placeholder="{{__('Admin/backend.sender_name')}}">
                            </div>
                            <div class="arabic">
                                <input value="{{$smtp_setting->default_sender_name_ar}}" name="sender_name_ar" type="text" class="form-control" placeholder="{{__('Admin/backend.sender_name')}}">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sender_email">{{__('Admin/backend.sender_email')}}</label>
                            <input value="{{$smtp_setting->default_sender_email}}" name="sender_email" type="email" class="form-control" placeholder="{{__('Admin/backend.sender_email')}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 mb-0">
                            <h3 class="mb-0">{{__('Admin/backend.keywords')}}</h3>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="form-group col-md-12">
                            <label for="keywords">{{__('Admin/backend.prereserved_keywords')}}</label>
                            <div class="form-control">
                                <span class="mx-2">[website_link]</span>
                                <span class="mx-2">[app_name]</span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="keywords">{{__('Admin/backend.keywords')}}</label>
                            <div class="form-control keywords-string">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="button" class="btn btn-primary btn-expand">{{__('Admin/backend.expand')}}</button>
                            <button type="button" class="btn btn-primary btn-collapse" style="display: none">{{__('Admin/backend.collapse')}}</button>
                        </div>
                        <div class="form-group col-md-12 keywords" style="display: none">
                            <input hidden name="emailtemplatekeywordincrement" value="0">
                            <div id="keyword_clone0" class="keyword-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input class="form-control" type="text" name="keywords[]" value="" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus-circle"type="button" onclick="addEmailTemplateKeyword($(this))"></button>
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="deleteEmailTemplateKeyword($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 mb-0">
                            <h3 class="mb-0">{{__('Admin/backend.email_template')}}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="subject">{{__('Admin/backend.subject')}}</label>
                            <div class="english">
                                <input name="subject" type="text" class="form-control" placeholder="{{__('Admin/backend.subject')}}">
                            </div>
                            <div class="arabic">
                                <input name="subject_ar" type="text" class="form-control" placeholder="{{__('Admin/backend.subject')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="content">{{__('Admin/backend.content')}}</label>
                            <div class="english">
                                <textarea id="content" name="content" class="form-control ckeditor-input" placeholder="{{__('Admin/backend.content')}}"></textarea>
                            </div>
                            <div class="arabic">
                                <textarea id="content_ar" name="content_ar" class="form-control ckeditor-input" placeholder="{{__('Admin/backend.content')}}"></textarea>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                    <button type="button" onclick="submitForm($(this).parents().find('#emailTemplateForm'))" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $('.btn-expand').click(function() {
                $('.keywords').show();
                $('.btn-expand').hide();
                $('.btn-collapse').show();
            });

            $('.btn-collapse').click(function() {
                $('.keywords').hide();
                $('.btn-expand').show();
                $('.btn-collapse').hide();
            });
        </script>
    @endsection
@endsection