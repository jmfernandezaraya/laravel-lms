@extends('frontend.layouts.app')
@section('content')
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs" data-aos="fade-in">
        <div class="container">
            <h2>@lang('Frontend.enquiry_form')</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= login Section ======= -->
    <form id="login-form" method="post" action ="{{route('enquiry.submit')}}">
        {{csrf_field()}}

        <div class="heading">@lang('Frontend.enquiry_form')</div>
        <div class="container mt-5 mb-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="left">
                <div class="form-group">
                    <label>{{__('SuperAdmin/backend.first_name')}}</label>
                    <input type="text" name="first_name" class="form-control" placeholder="{{__('SuperAdmin/backend.first_name')}}">
                </div>
                <div class="form-group">
                    <label>{{__('SuperAdmin/backend.last_name')}}</label>
                    <input type="text" name="last_name" class="form-control" placeholder="{{__('SuperAdmin/backend.last_name')}}">
                </div>
                <div class="form-group">
                    <label>{{__('SuperAdmin/backend.email')}}</label>
                    <input type="email" name="email" class="form-control" placeholder="{{__('SuperAdmin/backend.email')}}">
                </div>
                <div class="form-group">
                    <label>@lang('Frontend.phone')</label>
                    <input type="number" name="phone" class="form-control" placeholder="1234567890">
                </div>
                <div class="form-group">
                    <label>@lang('Frontend.message')</label>
                    <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    <div class="validate"></div>
                </div>
                <div class="text-center"><button type="submit" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button></div>
            </div>
        </div>
    </form>
@endsection
