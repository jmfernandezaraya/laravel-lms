@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_customer')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_customer')}}</h1>
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
                <form class="forms-sample" method="POST" action="{{ route('superadmin.user.customer.update', $customer->id) }}" id="customerForm">
                    {{csrf_field()}}
                    @method('PUT')
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.first_name')}}:</label>
                            <div class="english">
                                <input class="form-control" value="{{$customer->first_name_en}}" type="text" name="first_name_en" placeholder="{{__('SuperAdmin/backend.first_name')}}">
                            </div>
                            <div class="arabic">
                                <input class="form-control" value="{{$customer->first_name_ar}}" type="text" name="first_name_ar" placeholder="{{__('SuperAdmin/backend.first_name')}}">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.last_name')}}:</label>
                            <div class="english">
                                <input class="form-control" value="{{$customer->last_name_en}}" type="text" name="last_name_en" placeholder="{{__('SuperAdmin/backend.last_name')}}">
                            </div>
                            <div class="arabic">
                                <input class="form-control" value="{{$customer->last_name_ar}}" type="text" name="last_name_ar" placeholder="{{__('SuperAdmin/backend.last_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.email')}}:</label>
                            <input class="form-control" value="{{$customer->email}}" type="email" name="email" placeholder="{{__('SuperAdmin/backend.email')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('SuperAdmin/backend.mobile')}}:</label>
                            <input class="form-control" value="{{$customer->contact}}" type="text" name="contact" placeholder="{{__('SuperAdmin/backend.mobile')}}">
                        </div>
                    </div>

                    <button onclick="submitForm($(this).parents().find('#customerForm'))" class="btn btn-primary pull-right" type="button">{{__('SuperAdmin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection