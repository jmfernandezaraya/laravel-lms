@extends('branchadmin.layouts.app')

@section('content')
    @section('css')
        <style>
            .study {
                box-shadow: 0px 0px 2px 1px #ccc;
                padding: 15px 15px;
            }

            .accordion .card-header:after {
                font-family: 'FontAwesome';
                content: "\f068";
                float: right;
            }

            .accordion .card-header.collapsed:after {
                /* symbol for "collapsed" panels */
                content: "\f067";
                cursor: pointer;
            }

            .table {
                border: 1px solid #ccc;
                box-shadow: 0px -1px 4px 1px #ece7e7;
                background: #fff;
            }

            .content-wrapper {
                background: #ffffff;
                border: 1px solid #ccc;
            }

            .diff-tution {
                color: #b94443;
            }

            .form-check {
                position: relative;
                display: block;
                padding-left: 1.25rem;
            }

            .form-check-input {
                position: absolute;
                margin-top: .3rem;
                margin-left: -1.25rem;
            }

            .best {
                font-size: 16px;
                font-weight: 600;
            }
        </style>
    @endsection

    <center><h3>Reservation Details</h3></center>
    <div class="row">
        <div class="col-lg-12" style="display: inline; float:left">
            <form enctype="multipart/form-data" method="post" action="{{route('branch_admin.manage_application.send_message_to_super_admin')}}" id="sendschoolmessage">
                {{csrf_field()}}
                <center><h5>Message Received From SuperAdmin</h5></center>
                <div class="p-2 mb-2" style="background: lightgray; color:black">
                    <h6 style="color:black; margin-top: 10px"><b>From
                            : </b> {{\App\Models\User::where('user_type', 'super_admin')->first()['email']}}</h6>
                    <h6 style="color:black; margin-top: 10px"><b>Subject : </b>{{$chatMessage->subject}}</h6>
                    <h6 style="color:black; margin-top: 10px"><b>Message : </b>{!! $chatMessage->message !!}</h6>
                    <h6 style="text-align: right;color:black"><b>{{$chatMessage->created_at->format('d M Y')}}</b></h6>
                    {{--<h6 style="text-align: right;color:black"><b>+</b></h6>--}}
                </div>
                <hr>
                <div style="margin-left: 5px">
                    <h5>Subject</h5>
                    <input class="form-control" style="" name="subject">
                    <h5>Add Attachments</h5>
                    <input class="form-control" type="file" multiple="" name="attachment[]">
                    <h4> Message </h4>
                    <!--<textarea cols="70%" rows="10"></textarea>-->
                    <textarea class="form-control" rows="3" id="textareaid2" aria-hidden="true"></textarea>
                    <input hidden value="{{$chatMessage->id}}" name="send_school_message_id">
                    <input hidden="" name="message" id="messageid2">
                    <input hidden="" name="to_email" value="{{\App\Models\User::where('user_type', 'super_admin')->first()['email']}}">
                    <input hidden="" name="user_id" value="{{\App\Models\User::where('user_type', 'super_admin')->first()['id']}}">
                </div>
                <button type="button" onclick="getContent('textareaid2', 'messageid2'); sendMessage('sendschoolmessage')" class="btn btn-primary mt-1 choose">{{__('SuperAdmin/backend.submit')}}</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"
            integrity="sha512-RnlQJaTEHoOCt5dUTV0Oi0vOBMI9PjCU7m+VHoJ4xmhuUNcwnB5Iox1es+skLril1C3gHTLbeRepHs1RpSCLoQ=="
            crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script>
        $(document).ready(function () {
            tinymceInit();
        });
    </script>
@endsection

@section('js')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="{{asset('assets/js/tag/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        $("#myTags1").tagit({

            fieldName: "heard_where[]"
        });
    </script>
@endsection