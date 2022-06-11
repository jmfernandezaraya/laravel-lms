@extends('frontend.layouts.app')

@section('content')
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs" data-aos="fade-in">
            <div class="container">
                <h2>{{__('Frontend.register')}}</h2>
                <p>{{__('Frontend.register_description')}}</p>
            </div>
        </div>
        <!-- ======= End Breadcrumbs ======= -->

        <!-- ======= Register Section ======= -->
        <div class="container mt-5 mb-5">
            <div class="register-area ptb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="register-content">
                                <div class="heading">{{__('Frontend.register')}}</div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        <ul>
                                            {{ session()->get('message') }}
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user_register_post') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{old('first_name_en')}}" name="first_name_en" placeholder="{{__('Frontend.first_name')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="text" name='last_name_en' value="{{old('last_name_en')}}" class="form-control" placeholder="{{__('Frontend.last_name')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="{{__('Frontend.email_address')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="{{__('Frontend.password')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{__('Frontend.confirm_password')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label for="remember_me" class="col-sm-2 col-form-label agree"><input type="checkbox" class="form-check-input" id="remember_me"></label>
                                                <label class="form-check-label" for="remember_me">{{__('Frontend.remember_me')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <button class="btn btn-primary" type="submit">{{__('Frontend.sign_up')}}</button>
                                        </div>
                                    </div>
                                </form>
                                <h4>{{__('Frontend.are_you_member')}}? <a href="{{route('login')}}">{{__('Frontend.login_now')}}!</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ======= End Register Section ======= -->

        <!-- Modal -->
        <div class="modal fade" id="mobilePhoneVerificationModal" tabindex="-1" role="dialog" aria-labelledby="MobilePhoneVerificationLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MobilePhoneVerificationLabel">{{__('Frontend.mobile_phone_verification')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{__('Frontend.enter_the_code_send_on_mobile_phone')}} +91 86684833</p>
                        <form class="sub-inputbox">
                            <div class="d-flex flex-row ">
                                <input type="text" class="form-control" autofocus="">
                                <input type="text" class="form-control">
                                <input type="text" class="form-control">
                                <input type="text" class="form-control">
                            </div>
                        </form>
                        <div class="text-center mt-5">
                            <span class="d-block mobile-text">{{__('Frontend.do_not_receive_the_code')}}</span>
                            <span class="font-weight-bold cursor">{{__('Frontend.resend')}}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Frontend.close')}}</button>
                        <button type="button" class="btn btn-primary">{{__('Frontend.save_changes')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
