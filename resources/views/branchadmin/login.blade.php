@extends('frontend.layouts.app')
@section('content')


    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs" data-aos="fade-in">
        <div class="container">
            <h2>Login</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
        </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= login Section ======= -->
    <div class="container mt-5 mb-5">
        <form id="login-form" method="post" action="{{route('branchlogin.submit')}}">
            @csrf
            <div class="heading">Login</div>

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
                    <label>Email/phone</label>
                    <input autofocus name  ="email" type="text" class="form-control" placeholder="Email/phone"
                    value="{{old('email')}}"
                    >


                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group row">
                    <label for="inputmobile" class="col-sm-2 col-form-label agree"><input type="checkbox" class="form-check-input" id="exampleCheck1"></label>
                    <div class="col-sm-10">
                        <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
                <p class="text-center mt-3">Don't Have an account?<a href="{{route('register_user')}}">Sign Up</a></p>
                <div class="text-center">
                    <a href="#" type="button" data-toggle="modal" data-target="#forgotPasssword"><p >forgot password</p></a>
                </div>
            </div>
        </form>
    </div>
    <!-- End login Section -->


    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
      Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="forgotPasssword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <form method="post" action="{{route('forgot-password-post')}}">
            @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('Frontend.recovery_email')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{__('Frontend.email_phone')}}</label>
                        <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="mb-3 text-center">
                    <button class="btn btn-primary submit1" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
