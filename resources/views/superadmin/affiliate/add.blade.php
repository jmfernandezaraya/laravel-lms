@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_affiliate')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_affiliate')}}</h1>
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
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ route('superadmin.user.affiliate.store') }}" id="affiliateForm">
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
                            <label>{{__('Admin/backend.first_name')}} <span class="text-danger">*</span></label>
                            <div class="english">
                                <input class="form-control" value="{{old('first_name_en')}}" type="text" name="first_name_en" placeholder="{{__('Admin/backend.first_name')}}">
                            </div>
                            <div class="arabic">
                                <input class="form-control" value="{{old('first_name_ar')}}" type="text" name="first_name_ar" placeholder="{{__('Admin/backend.first_name')}}">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.last_name')}} <span class="text-danger">*</span></label>
                            <div class="english">
                                <input class="form-control" value="{{old('last_name_en')}}" type="text" name="last_name_en" placeholder="{{__('Admin/backend.last_name')}}">
                            </div>
                            <div class="arabic">
                                <input class="form-control" value="{{old('last_name_ar')}}" type="text" name="last_name_ar" placeholder="{{__('Admin/backend.last_name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.email')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('email')}}" type="email" name="email" placeholder="{{__('Admin/backend.email')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">{{__('Admin/backend.enter_password')}}</label>
                            <input name="password" value="{{old('password')}}" class="form-control" id="password" placeholder="{{__('Admin/backend.enter_password')}}" type="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.telephone')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('telephone')}}" type="tel" name="telephone" placeholder="{{__('Admin/backend.telephone')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.mobile')}}</label>
                            <input class="form-control" value="{{old('mobile')}}" type="tel" name="mobile" placeholder="{{__('Admin/backend.mobile')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.another_mobile')}}</label>
                            <input class="form-control" value="{{old('another_mobile')}}" type="tel" name="another_mobile" placeholder="{{__('Admin/backend.another_mobile')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                            <label>{{__('Admin/backend.profile_image_if_any')}}</label>
                            <input type="file" onchange="previewFile(this)" class="form-control" name="image">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.socials')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.instagram')}}</label>
                            <input class="form-control" value="{{old('instagram')}}" type="text" name="instagram" placeholder="{{__('Admin/backend.instagram')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.twitter')}}</label>
                            <input class="form-control" value="{{old('twitter')}}" type="text" name="twitter" placeholder="{{__('Admin/backend.twitter')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.snapchat')}}</label>
                            <input class="form-control" value="{{old('snapchat')}}" type="text" name="snapchat" placeholder="{{__('Admin/backend.snapchat')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.tiktok')}}</label>
                            <input class="form-control" value="{{old('tiktok')}}" type="text" name="tiktok" placeholder="{{__('Admin/backend.tiktok')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.facebook')}}</label>
                            <input class="form-control" value="{{old('facebook')}}" type="text" name="facebook" placeholder="{{__('Admin/backend.facebook')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.youtube')}}</label>
                            <input class="form-control" value="{{old('youtube')}}" type="text" name="youtube" placeholder="{{__('Admin/backend.youtube')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.pinterest')}}</label>
                            <input class="form-control" value="{{old('pinterest')}}" type="text" name="pinterest" placeholder="{{__('Admin/backend.pinterest')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.skype')}}</label>
                            <input class="form-control" value="{{old('skype')}}" type="text" name="skype" placeholder="{{__('Admin/backend.skype')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.linkedin')}}</label>
                            <input class="form-control" value="{{old('linkedin')}}" type="text" name="linkedin" placeholder="{{__('Admin/backend.linkedin')}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.address')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.address')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('address')}}" type="text" name="address" placeholder="{{__('Admin/backend.address')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.post_code')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('post_code')}}" type="text" name="post_code" placeholder="{{__('Admin/backend.post_code')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.country')}} <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="country" placeholder="{{__('Admin/backend.country')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.city')}} <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="city" placeholder="{{__('Admin/backend.city')}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h3>{{__('Admin/backend.payment_information')}}</h3></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.commission_rate')}} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" value="{{old('commission_rate')}}" type="text" name="commission_rate" placeholder="{{__('Admin/backend.commission_rate')}}">
                                <div class="input-group-prepend">
                                    <select class="input-group-text" name="commission_rate_type">
                                        <option value="percent">%</option>
                                        <option value="fixed">{{__('Admin/backend.fixed')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.tax_id')}}</label>
                            <input class="form-control" value="{{old('tax_id')}}" type="text" name="tax_id" placeholder="{{__('Admin/backend.tax_id')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.bank_name')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('bank_name')}}" type="text" name="bank_name" placeholder="{{__('Admin/backend.bank_name')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.bank_address')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('bank_address')}}" type="text" name="bank_address" placeholder="{{__('Admin/backend.bank_address')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.iban')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('iban')}}" type="text" name="iban" placeholder="{{__('Admin/backend.iban')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.swift_code')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('swift_code')}}" type="text" name="swift_code" placeholder="{{__('Admin/backend.swift_code')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.account_name')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('account_name')}}" type="text" name="account_name" placeholder="{{__('Admin/backend.account_name')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('Admin/backend.account_number')}} <span class="text-danger">*</span></label>
                            <input class="form-control" value="{{old('account_number')}}" type="text" name="account_number" placeholder="{{__('Admin/backend.account_number')}}">
                        </div>
                    </div>

                    <button class="btn btn-primary pull-right" type="submit">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection