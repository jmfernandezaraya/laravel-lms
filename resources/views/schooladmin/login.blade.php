@extends('frontend.layouts.app')

@section('title')
    {{__('Admin/backend.login')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Admin/backend.login')}}</h1>
    <p>{{__('Admin/backend.login_description')}}</p>
@endsection

@section('content')
    <!-- ======= Login Section ======= -->
    <div class="container mt-5 mb-5">
        <form id="login-form" method="post" action="{{route('school_admin_login_post')}}">
            @csrf
            <div class="heading">{{__('Admin/backend.login')}}</div>

            <div class="left">
                <div class="form-group">
                    @if (session()->has('message'))
                        <div class="alert alert-success">{!! session()->get('message') !!}</div>
                    @endif
                    @if (session()->has('error_message_for_login'))
                        <div class="alert alert-danger">{!! session()->get('error_message_for_login') !!}</div>
                    @enderror
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label>{{__('Admin/backend.email_phone')}}</label>
                    <input autofocus name="email" type="text" class="form-control" placeholder="{{__('Admin/backend.email_phone')}}" value="{{old('email')}}" />
                </div>
                <div class="form-group">
                    <label>{{__('Admin/backend.password')}}</label>
                    <input type="password" name="password" class="form-control" placeholder="{{__('Admin/backend.password')}}">
                </div>
                <div class="form-group">
                    <input type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">{{__('Admin/backend.remember_me')}}</label>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
                <p class="text-center mt-3">
                    <label class="">{{__('Admin/backend.do_not_have_an_account')}}</label>
                    <a href="{{route('register_user')}}">{{__('Admin/backend.sign_up')}}</a>
                </p>
                <div class="text-center">
                    <a href="#" type="button" data-toggle="modal" data-target="#forgotPasssword">
                        <p>{{__('Admin/backend.forgot_password')}}</p>
                    </a>
                </div>
            </div>
        </form>
    </div>
    <!-- End login Section -->

    <!-- Modal -->
    <div class="modal fade" id="forgotPasssword" tabindex="-1" role="dialog" aria-labelledby="forgotPassswordTitle" aria-hidden="true">
        <form method="post" action="{{route('forgot-password-post')}}">
            @csrf
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPassswordTitle">{{__('Admin/backend.recovery_email')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{__('Admin/backend.email_phone')}}</label>
                            <input type="text" name="email" class="form-control" placeholder="{{__('Admin/backend.email_phone')}}">
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button class="btn btn-primary submit1" type="submit">{{__('Admin/backend.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection