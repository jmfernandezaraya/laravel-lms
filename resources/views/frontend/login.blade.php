@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.login')}}
@endsection

@section('content')
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs" data-aos="fade-in">
        <div class="container">
            <h2>{{__('Frontend.login')}}</h2>
            <p>{{__('Frontend.login_description')}}</p>
        </div>
    </div>
    <!-- ======= End Breadcrumbs ======= -->

    <!-- ======= Login Section ======= -->
    <div class="container mt-5 mb-5">
        <form id="login-form" method="post" action = "{{route('user_login_post')}}">
            @csrf
            <div class="heading">{{__('Frontend.login')}}</div>

            <div class="left">
                <div class="form-group">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{!! session()->get('message') !!}</div>
                    @enderror
                    @if(session()->has('error_message_for_login'))
                        <div class="alert alert-danger">{!! session()->get('error_message_for_login') !!}</div>
                    @enderror
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>{{__('Frontend.email_phone')}}</label>
                    <input autofocus name  ="email" type="text" class="form-control" placeholder="{{__('Frontend.email_phone')}}" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label>{{__('Frontend.password')}}</label>
                    <input type="password" name="password" class="form-control" placeholder="{{__('Frontend.password')}}">
                </div>
                <div class="form-group row">
                    <label for="remember_me" class="col-sm-2 col-form-label agree">
                        <input type="checkbox" class="form-check-input" id="remember_me">
                    </label>
                    <div class="col-sm-10">
                        <label class="form-check-label" for="remember_me">{{__('Frontend.remember_me')}}</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{__('Frontend.login')}}</button>
                <p class="text-center mt-3">{{__('Frontend.do_not_have_an_account')}}<a href="{{route('register_user')}}">{{__('Frontend.sign_up')}}</a></p>
                <div class="text-center">
                    <a href="#" type="button" data-toggle="modal" data-target="#forgotPasssword">
                        <p>{{__('Frontend.forgot_password')}}</p>
                    </a>
                </div>
            </div>
        </form>
    </div>
    <!-- ======= End Login Section ======= -->

    <!-- Modal -->
    <div class="modal fade" id="forgotPasssword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <form method="post" action="{{ route('forgot-password-post') }}">
            @csrf
            
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Frontend.recovery_email')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{__('Frontend.close')}}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{__('Frontend.email_phone')}}</label>
                            <input type="text" name="email" class="form-control" placeholder="{{__('Frontend.email_phone')}}" />
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button class="btn btn-primary submit1" type="submit">{{__('Frontend.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection