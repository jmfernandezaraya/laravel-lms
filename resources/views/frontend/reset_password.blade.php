@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.forgot_password')}}
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <form id="login-form" method="post" action="{{route('reset-password-post')}}">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <div class="heading">{{__('Frontend.forgot_password')}}</div>
            <div class="left">
                <div class="form-group">
                    <input autofocus name="email" type="hidden" class="form-control" placeholder="{{__('Frontend.email_phone')}}" value="{{ $_GET['email'] }}">
                    <label>{{__('Frontend.password')}}</label>
                    <input autofocus name="password" type="password" class="form-control" placeholder="{{__('Frontend.password')}}">
                    <label>{{__('Frontend.confirm_password')}}</label>
                    <input name="password_confirmation" type="password" class="form-control" placeholder="{{__('Frontend.confirm_password')}}">
                </div>
                <button type="submit" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
            </div>
        </form>
    </div>
@endsection