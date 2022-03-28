@extends('frontend.layouts.app')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h2>@lang('Frontend.forgot_password')</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- ======= login Section ======= -->
<div class="container mt-5 mb-5">
    <form id="login-form" method="post" action="{{route('reset-password-post')}}">
        @csrf
        <input type="hidden" name="token" value="{{$token}}">
        <div class="heading">@lang('Frontend.forgot_password')</div>
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
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label>@lang('Frontend.email_phone')</label>
                <input autofocus name="email" type="text" class="form-control" placeholder="@lang('Frontend.email_phone')" value="{{old('email')}}">
                <label>@lang('Frontend.password')</label>
                <input name="password" type="password" class="form-control" placeholder="@lang('Frontend.password')">
                <label>@lang('Frontend.confirm_password')</label>
                <input name="password_confirmation" type="password" class="form-control" placeholder="@lang('Frontend.confirm_password')">
            </div>
            <button type="submit" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
        </div>
    </form>
</div>
@endsection