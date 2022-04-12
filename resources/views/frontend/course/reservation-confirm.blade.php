@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.reservation_details')}}
@endsection

@section('css')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        #sig-canvas {
            border: 2px solid #CCCCCC;
            border-radius: 5px;
            cursor: crosshair;
            height: 150px;
        }

        .border-top-bottom {
            border-top: 3px solid #97d0db;
            border-bottom: 3px solid #97d0db;
            padding: 15px 0;
        }

        .btn-submit {
            width: 100%;
            padding: 15px 25px;
        }
        
        form > * {
            margin: 10px;
        }
    </style>
@endsection

@section('breadcrumbs')
    <div class="container">
        <h1>{{__('Frontend.registration_cancelation_conditions')}}</h1>
    </div>
@endsection

@section('content')
    <!-- Reservation -->
    <div class="container">
        <div class="inter-full mt-3">
            <div class="course-details border-bottom">

                @include('schooladmin.include.alert')

                <form id="course_reversation_confirm" enctype="multipart/form-data" action="{{route('payment-gateway')}}" method="POST">
                    {{csrf_field()}}

                    @foreach ($course_details as $course_detail_key => $course_detail_val)
                        <input hidden name="{{ $course_detail_key }}" value="{{ $course_detail_val }}" />
                    @endforeach

                    @foreach ($course_register_details as $course_register_detail_key => $course_register_detail_val)
                        <input hidden name="{{ $course_register_detail_key }}" value="{{ $course_register_detail_val }}" />
                    @endforeach

                    <div class="study m-2">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="" />
                            </div>
                            <div class="col-md-9">
                                <h2>{{__('Frontend.registration_cancelation_conditions')}}</h2>
                            </div>
                        </div>
                        <div class="row border-top-bottom form-group">
                            <div class="col-md-12">
                                <p>{{__('Frontend.registration_cancelation_conditions_description')}}</p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="student_guardian_full_name" class="col-form-label"><strong>{{__('Frontend.student_guardian_full_name')}}</strong>:</label>
                                <input type="text" name="student_guardian_full_name" class="form-control" id="student_guardian_full_name" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label class="col-form-label"><strong>{{__('Frontend.date')}}:</strong></label>
                            </div>
                            <div class="col-md-10">
                                <label class="col-form-label">{{ $today }}</label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label class="col-form-label"><strong>{{__('Frontend.signature')}}:</strong></label>
                            </div>
                            <div class="col-md-10">
                                <canvas id="sig-canvas" width="1000" height="150"></canvas>
                                <textarea name="signature" hidden id="sig-dataUrl" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-danger" id="sig-clearBtn">Clear Signature</button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input name="registraion_terms_conditions_privacy_policy" class="form-check-input" type="checkbox" value="registraion_terms_conditions_privacy_policy">
                                    <label class="form-check-label">
                                        {{__('Frontend.i_read_and_agreed_to_the')}} (<a href="{{$school->website_link}}">{{__('Frontend.registration_conditions')}}</a>, <a href="{{$school->website_link}}">{{__('Frontend.terms_and_conditions')}}</a> & <a href="{{$school->website_link}}">{{__('Frontend.private_policy')}}</a>) {{__('Frontend.of_link_for_study_abroad')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input name="terms" class="form-check-input" type="checkbox" value="terms">
                                    <label class="form-check-label">
                                        {{__('Frontend.i_read_and_agreed_to_the')}} <a href="{{$school->website_link}}">{{__('Frontend.terms_and_conditions')}}</a> {{__('Frontend.of_the_school_institute')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <button type="submit" onclick="register_now($(this))" class="btn btn-primary btn-submit">{{__('Frontend.confirm_registration')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function register_now(object) {
            var canvas = document.getElementById("sig-canvas");
            var sigText = document.getElementById("sig-dataUrl");
            var dataUrl = canvas.toDataURL();
            sigText.innerHTML = dataUrl;
            var formdata = new FormData($(object).parents().find('#course_reversation_confirm')[0]);
            var urlname = ($(object).parents().find('#course_reversation_confirm').attr('action'));
            $("#loader").show();

            $.ajax({
                type: 'POST',
                url: urlname,
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#loader").hide();
                    console.log(data);
                    if(data.success == true) {
                        $('.alert-success').show();
                        $('.alert-success p').html(data.data);
                        document.documentElement.scrollTop = 0;

                        window.location.href = data.url;
                    } else if(data.errors) {
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        document.documentElement.scrollTop = 0;
                        for(var error in data.errors) {
                            $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                        }
                    }
                }
            });
        }

        (function() {
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            var canvas = document.getElementById("sig-canvas");
            canvas.setAttribute("width", canvas.parentElement.clientWidth);
            canvas.setAttribute("height", canvas.parentElement.clientHeight);
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;

            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;

            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);

            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
            }, false);

            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Add touch event support for mobile
            canvas.addEventListener("touchstart", function(e) {
            }, false);

            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var me = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var me = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchend", function(e) {
                var me = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(me);
            }, false);

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                }
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                }
            }

            function renderCanvas() {
                if(drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if(e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if(e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if(e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigText.innerHTML = "Data URL for your signature will go here!";
                sigImage.setAttribute("src", "");
            }, false);
        })();
    </script>
@endsection