@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.reservation_details')}}
@endsection

@section('css')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{ url('/') }}" class="breadcrumb-home">
            <i class="bx bx-home"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.registration_cancelation_conditions')}}</h1>
    </div>
@endsection

@section('content')
    <!-- Reservation -->
    <div class="container">
        <div class="inter-full mt-3">
            <div class="course-details border-bottom">

                @include('common.include.alert')

                <form id="course_reversation_confirm" enctype="multipart/form-data" action="{{route('frontend.course.reservation_confirm')}}" method="POST">
                    {{csrf_field()}}

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
                                <p>{!! $registration_cancel_description !!}</p>
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
                                <button type="button" class="btn btn-danger" id="sig-clearBtn">{{__('Frontend.clear_signature')}}</button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input name="registraion_terms_conditions_privacy_policy" class="form-check-input" type="checkbox" value="registraion_terms_conditions_privacy_policy">
                                    <label class="form-check-label">
                                        {{__('Frontend.i_read_and_agreed_to_the')}} (<a href="{{ isset($reservation_links['registration_conditions']) ? $reservation_links['registration_conditions'] : $school->website_link }}">{{__('Frontend.registration_conditions')}}</a>, <a href="{{ isset($reservation_links['terms_and_conditions']) ? $reservation_links['terms_and_conditions'] : $school->website_link }}">{{__('Frontend.terms_and_conditions')}}</a> & <a href="{{ isset($reservation_links['private_policy']) ? $reservation_links['private_policy'] : $school->website_link }}">{{__('Frontend.private_policy')}}</a>) {{__('Frontend.of_link_for_study_abroad')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input name="terms" class="form-check-input" type="checkbox" value="terms" />
                                    <label class="form-check-label">
                                        {{__('Frontend.i_read_and_agreed_to_the')}} <a href="{{ $school->website_link }}">{{__('Frontend.terms_and_conditions')}}</a> {{__('Frontend.of_the_school_institute')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <button type="button" onclick="confirmReservation($(this))" class="btn btn-primary btn-submit">{{__('Frontend.confirm_registration')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmReservation(object) {
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
                    if (data.success == true) {
                        document.documentElement.scrollTop = 0;

                        window.location.href = data.url;
                    } else if (data.errors) {
                        document.documentElement.scrollTop = 0;
                        var alert_messages = '';
                        if (typeof data.errors === 'object') {
                            for (const [error_key, error_value] of Object.entries(data.errors)) {
                                alert_messages += error_value + '\n';
                            }
                        } else if (typeof data.errors === 'array') {
                            for (let error_index = 0; error_index < data.errors.length; error_index++) {
                                alert_messages += data.errors[error_index] + '\n';
                            }
                        } else {
                            alert_messages += error + '\n';
                        }
                        alert(alert_messages);
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