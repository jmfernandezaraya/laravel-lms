@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.affiliate_information')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{route('frontend.dashboard')}}" class="breadcrumb-home">
            <i class="bx bxs-dashboard"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.affiliate_information')}}</h1>
    </div>
@endsection

@section('content')
    <div class="dashboard">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.first_name')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->{'first_name_' . get_language()} }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.last_name')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->{'last_name_' . get_language()} }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.email')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->email }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.telephone')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->telephone }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.mobile')}}</label>
                    <input class="form-control" value="{{ $affiliate->mobile }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.another_mobile')}}</label>
                    <input class="form-control" value="{{ $affiliate->another_mobile }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    @if($affiliate->image == null || $affiliate->image == '')
                        <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
                    @else
                        <img src="{{ asset($affiliate->image) }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;" />
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
                    <label>{{__('Frontend.instagram')}}</label>
                    <input class="form-control" value="{{ $affiliate->instagram }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.twitter')}}</label>
                    <input class="form-control" value="{{ $affiliate->twitter }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.snapchat')}}</label>
                    <input class="form-control" value="{{ $affiliate->snapchat }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.tiktok')}}</label>
                    <input class="form-control" value="{{ $affiliate->tiktok }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.facebook')}}</label>
                    <input class="form-control" value="{{ $affiliate->facebook }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.youtube')}}</label>
                    <input class="form-control" value="{{ $affiliate->youtube }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.pinterest')}}</label>
                    <input class="form-control" value="{{ $affiliate->pinterest }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.skype')}}</label>
                    <input class="form-control" value="{{ $affiliate->skype }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.linkedin')}}</label>
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
                    <label>{{__('Frontend.address')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->address }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.post_code')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->post_code }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.country')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->country }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.city')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->city }}" readonly />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label><h3>{{__('Frontend.payment_information')}}</h3></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.commission_rate')}} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input class="form-control" value="{{ $affiliate->commission_rate }}" readonly />
                        <div class="input-group-prepend">
                            <label class="input-group-text">{{ $affiliate->commission_rate_type == 'percent' ? '%' : __('Frontend.fixed') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.tax_id')}}</label>
                    <input class="form-control" value="{{ $affiliate->tax_id }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.bank_name')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->bank_name }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.bank_address')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->bank_address }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.iban')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->iban }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.swift_code')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->swift_code }}" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.account_name')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->account_name }}" readonly />
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('Frontend.account_number')}} <span class="text-danger">*</span></label>
                    <input class="form-control" value="{{ $affiliate->account_number }}" readonly />
                </div>
            </div>
        </div>
    </div>
@endsection