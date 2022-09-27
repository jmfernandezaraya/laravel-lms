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
                <form id="formaction" class="forms-sample" method="post" action="{{route('superadmin.payment_method.store')}}">
                    {{csrf_field()}}
                    
                    <div id="form1">
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
                            <div class="form-group col-md-12">
                                <label for="name">{{__('Admin/backend.payment_method')}}</label>
                                <div class="english">
                                    <input value="{{old('name')}}" name="name" type="text" class="form-control" placeholder="{{__('Admin/backend.payment_method')}}">
                                </div>
                                <div class="arabic">
                                    <input  value="{{old('name_ar')}}" name="name_ar" type="text" class="form-control" placeholder="{{__('Admin/backend.payment_method')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{route('superadmin.payment_method.index')}}">{{__('Admin/backend.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection