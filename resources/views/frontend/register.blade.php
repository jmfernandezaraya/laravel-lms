@extends('frontend.layouts.app')
@section('content')
    @section('css')
        <style>
            .register-content .form-control {
                border: 1px solid #eee;
            }
            .register-content .heading {
                color: #fff;
                text-align: center;
                text-transform: uppercase;
                padding: 15px 0;
                background: #97d0db;
                font-weight: 600;
                font-size: 25px;
                margin-bottom: 30px;
            }
            .register-content {
                padding: 25px;
                text-align: center;
                box-shadow: 0 15px 30px 0 rgb(0 0 0 / 10%);
                max-width: 550px;
                background-color: #fff;
                margin: 0 auto;
            }
            .form-control {
                height: 50px;
                padding: 15px;
                font-size: 16px;
                /*border: none;*/
                border-radius: 5px;
                font-weight: 400;
            }
            .register-content h4 {
                color: #777;
                margin-top: 20px;
                font-size: 18px;
                font-weight: 400;
            }
            .register-content h4 {
                color: #777;
                margin-top: 20px;
                font-size: 14px;
                font-weight: 600;
            }
            .register-content .btn {
                display: block;
                width: 100%;
                text-transform: uppercase;
            }
        </style>
    @endsection

    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs" data-aos="fade-in">
            <div class="container">
                <h2>REGISTER</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
            </div>
        </div><!-- End Breadcrumbs -->

        <!-- ======= login Section ======= -->
        <div class="container mt-5 mb-5">
            <div class="register-area ptb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="register-content">
                                <div class="heading">Register</div>
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
                                <form method="post" action = "{{route('user_register_post')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{old('first_name_en')}}" name="first_name_en" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="text" name='last_name_en' value="{{old('last_name_en')}}" class="form-control" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{old("email")}}" class="form-control" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label for="inputmobile" class="col-sm-2 col-form-label agree"><input type="checkbox" class="form-check-input" id="exampleCheck1"></label>
                                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <button class="btn btn-primary"{{-- data-toggle="modal" data-target="#exampleModal"--}} type="submit">Sign Up</button>
                                        </div>
                                    </div>
                                </form>
                                <h4>@lang('Frontend.are_you_member')? <a href="{{route('login')}}">Login Now!</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End login Section -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mobile phone verification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Enter the code we just send on your mobile phone +91 86684833</p>
                        <form class="sub-inputbox">
                            <div class="d-flex flex-row "><input type="text" class="form-control" autofocus=""><input type="text" class="form-control"><input type="text" class="form-control"><input type="text" class="form-control"></div>
                        </form>
                        <div class="text-center mt-5"><span class="d-block mobile-text">Don't receive the code?</span><span class="font-weight-bold cursor">Resend</span></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
