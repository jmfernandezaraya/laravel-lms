@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.affiliate_information')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.affiliate_information')}}</h1>
@endsection

@section('content')
    <div class="dashboard">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-lg-12">
                    <h3>{{__('Frontend.affiliate_information')}}</h3>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.first_name')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->{'first_name_' . get_language()} }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.last_name')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->{'last_name_' . get_language()} }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.email')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->email }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.telephone')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->telephone }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.mobile')}}:</label>
                    <input class="form-control" value="{{ $affiliate->mobile }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.another_mobile')}}:</label>
                    <input class="form-control" value="{{ $affiliate->another_mobile }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    @if($affiliate->image == null || $affiliate->image == '')
                        <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                    @else
                        <img src="{{asset($affiliate->image)}}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label><h3>{{__('Frontend.socials')}}</h3></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.instagram')}}:</label>
                    <input class="form-control" value="{{ $affiliate->instagram }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.twitter')}}:</label>
                    <input class="form-control" value="{{ $affiliate->twitter }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.snapchat')}}:</label>
                    <input class="form-control" value="{{ $affiliate->snapchat }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.tiktok')}}:</label>
                    <input class="form-control" value="{{ $affiliate->tiktok }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.facebook')}}:</label>
                    <input class="form-control" value="{{ $affiliate->facebook }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.youtube')}}:</label>
                    <input class="form-control" value="{{ $affiliate->youtube }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.pinterest')}}:</label>
                    <input class="form-control" value="{{ $affiliate->pinterest }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.skype')}}:</label>
                    <input class="form-control" value="{{ $affiliate->skype }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.linkedin')}}:</label>
                    <input class="form-control" value="{{ $affiliate->linkedin }}" readonly />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label><h3>{{__('Frontend.address')}}</h3></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.address')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->address }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.post_code')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->post_code }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.country')}}*:</label>
                    <input class="form-control" value="{{ $country_name }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.city')}}*:</label>
                    <input class="form-control" value="{{ $city_name }}" readonly />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label><h3>{{__('Frontend.payment_information')}}</h3></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.commission_rate')}}*:</label>
                    <div class="input-group">
                        <input class="form-control" value="{{ $affiliate->commission_rate }}" readonly />
                        <div class="input-group-prepend">
                            <label class="input-group-text">{{ $affiliate->commission_rate_type == 'percent' ? '%' : __('Frontend.fixed') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.tax_id')}}:</label>
                    <input class="form-control" value="{{ $affiliate->tax_id }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.bank_name')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->bank_name }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.bank_address')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->bank_address }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.iban')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->iban }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.swift_code')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->swift_code }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.account_name')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->account_name }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.account_number')}}*:</label>
                    <input class="form-control" value="{{ $affiliate->account_number }}" readonly />
                </div>
            </div>
        </div>
    </div>
@endsection