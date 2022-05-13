@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.login_password')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.login_password')}}</h1>
@endsection

@section('content')
    <section class="login-password">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3">
                    <form class="login-password-form" method="POST" action="{{route('dashboard.login_password.update')}}" id="LoginPasswordForm">
                        {{csrf_field()}}

                        <div class="alert-success" style="display: none">
                            <p></p>
                        </div>
                        
                        <div class="alert-danger" style="display: none">
                            <ul></ul>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <label><strong>{{__('Frontend.name')}}</strong></label>
                                        <div class="show-area show">
                                            <p>{{ $first_name }} {{ $last_name }}</p>
                                        </div>
                                        <div class="editable-area">
                                            <input type="text" name="first_name" class="form-control mb-2" value="{{ $first_name }}" />
                                            <input type="text" name="last_name" class="form-control" value="{{ $last_name }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <button type="button" class="btn btn-primary btn-full-width show btn-edit">{{__('Frontend.edit')}}</button>
                                        <button type="button" class="btn btn-primary btn-full-width btn-save">{{__('Frontend.save')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <label><strong>{{__('Frontend.email')}}</strong></label>
                                        <p>{{ $email }}</p>
                                        <div class="editable-area">
                                            <input type="text" name="email" class="form-control" value="{{ $email }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <button type="button" class="btn btn-primary btn-full-width verify-email">{{__('Frontend.verify')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <label><strong>{{__('Frontend.mobile_phone_number')}}</strong></label>
                                        <div class="show-area show">
                                            <p>{{ $contact }}</p>
                                        </div>
                                        <div class="editable-area">
                                            <input type="text" name="contact" class="form-control" value="{{ $contact }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <button type="button" class="btn btn-primary btn-full-width mb-2 show btn-edit">{{__('Frontend.edit')}}</button>
                                        <button type="button" class="btn btn-primary btn-full-width btn-save">{{__('Frontend.save')}}</button>
                                        <button type="button" class="btn btn-primary btn-full-width phone-verify">{{__('Frontend.verify')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <label><strong>{{__('Frontend.password')}}</strong></label>
                                        <div class="show-area show">
                                            <p>******</p>
                                        </div>
                                        <div class="editable-area">
                                            <input type="password" name="password" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <button type="button" class="btn btn-primary btn-full-width show btn-edit">{{__('Frontend.edit')}}</button>
                                        <button type="button" class="btn btn-primary btn-full-width btn-save">{{__('Frontend.save')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary float-right mt-3" onclick="updateAccount()">{{__('Frontend.update_save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        window.addEventListener('load', (event) => {
            $('.login-password-form .btn').click(function() {
                if ($(this).hasClass('btn-edit')) {
                    $(this).parent().find('.btn-save').addClass('show');
                    $(this).closest('.row').find('.show-area').removeClass('show');
                    $(this).closest('.row').find('.editable-area').addClass('show');
                    $(this).removeClass('show');
                } else if ($(this).hasClass('btn-save')) {
                    $(this).parent().find('.btn-edit').addClass('show');
                    $(this).closest('.row').find('.editable-area').removeClass('show');
                    let editable_inputs_val = '';
                    let editable_inputs = $(this).closest('.row').find('.editable-area input');
                    for (let input_index = 0; input_index < editable_inputs.length; input_index++) {
                        if (editable_inputs_val) editable_inputs_val = editable_inputs_val + " ";
                        editable_inputs_val = editable_inputs_val + $(editable_inputs[input_index]).val();
                    }
                    $(this).closest('.row').find('.show-area p').html(editable_inputs_val);
                    $(this).closest('.row').find('.show-area').addClass('show');  
                    $(this).removeClass('show');
                } else if ($(this).hasClass('verify-email')) {
                    $.ajax({
                        url: "route('dashboard.verify_email')",
                        method: 'POST',
                        data: { email: $('input[name="email"]').val() },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#loader").hide();

                            if (data.success) {
                                $('.alert-success').show();
                                $('.alert-success p').html(data.data);
                                document.documentElement.scrollTop = 0;
                            } else if (data.errors) {
                                $('.alert-danger').show();
                                $('.alert-danger ul').html('');
                                for (var error in data.errors) {
                                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                                }
                            } else if (data.message) {
                                $('.alert-danger').show();
                                $('.alert-danger ul').html('');
                                for (var error in data.errors) {
                                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                                }
                            }
                        },
                        error: function (data) {
                            $("#loader").hide();
                        }
                    });
                } else if ($(this).hasClass('phone-verify')) {
                    $.ajax({
                        url: "route('dashboard.verify_phone')",
                        method: 'POST',
                        data: { email: $('input[name="email"]').val() },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $("#loader").hide();

                            if (data.success) {
                                $('.alert-success').show();
                                $('.alert-success p').html(data.data);
                                document.documentElement.scrollTop = 0;
                            } else if (data.errors) {
                                $('.alert-danger').show();
                                $('.alert-danger ul').html('');
                                for (var error in data.errors) {
                                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                                }
                            } else if (data.message) {
                                $('.alert-danger').show();
                                $('.alert-danger ul').html('');
                                for (var error in data.errors) {
                                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                                }
                            }
                        },
                        error: function (data) {
                            $("#loader").hide();
                        }
                    });
                }
            });
        });

        function updateAccount() {
            var formdata = new FormData($('#LoginPasswordForm')[0]);
            
            $.ajax({
                url: "{{route('dashboard.login_password.update')}}",
                method: 'POST',
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loader").hide();

                    if (data.success) {
                        $('.alert-success').show();
                        $('.alert-success p').html(data.data);
                        document.documentElement.scrollTop = 0;
                    } else if (data.errors) {
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        for (var error in data.errors) {
                            $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                        }
                    } else if (data.message) {
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        for (var error in data.errors) {
                            $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                        }
                    }
                },
                error: function (data) {
                    $("#loader").hide();
                }
            });
        }
    </script>
@endsection