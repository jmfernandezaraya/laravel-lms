@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_payment_method')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_payment_method')}}</h1>
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
                <form id="paymentMethodForm" class="forms-sample" method="post" action="{{route('superadmin.payment_method.store')}}">
                    {{csrf_field()}}
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="key">{{__('Admin/backend.payment_method')}}</label>
                            <select name="key" class="form-control">
                                @foreach ($payment_method_list as $method_key => $method_value)
                                    <option value="{{ $method_key }}" data-logo="{{ $method_value['logo'] }}">{{ app()->getLocale() == 'en' ? $method_value['en'] : $method_value['ar'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <img class="logo img-fluid" src="" style="width: 200px" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 store-id">
                            <label for="store_id">{{__('Admin/backend.store_id')}}</label>
                            <input class="form-control" value="" type="text" name="store_id" placeholder="{{__('Admin/backend.store_id')}}">
                        </div>
                        <div class="form-group col-md-6 store-auth-key">
                            <label for="store_auth_key">{{__('Admin/backend.store_auth_key')}}</label>
                            <input class="form-control" value="" type="text" name="store_auth_key" placeholder="{{__('Admin/backend.store_auth_key')}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 store-secret-key">
                            <label for="store_secret_key">{{__('Admin/backend.store_secret_key')}}</label>
                            <input class="form-control" value="" type="text" name="store_secret_key" placeholder="{{__('Admin/backend.store_secret_key')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mode">{{__('Admin/backend.mode')}}</label>
                            <select name="test_mode" class="form-control">
                                <option value="0" selected>{{__('Admin/backend.real_mode')}}</option>
                                <option value="1">{{__('Admin/backend.test_mode')}}</option>
                            </select>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{route('superadmin.payment_method.index')}}">{{__('Admin/backend.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection