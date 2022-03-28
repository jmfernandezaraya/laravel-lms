@extends('schooladmin.layouts.app')
@section('content')
    <style>

        textarea {
           resize:both;
        }
    </style>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SchoolAdmin.customer_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th> @lang('SuperAdmin/backend.first_name')</th>
                        <th>{{__('SuperAdmin/backend.last_name')}}</th>
                        <th>{{__('SuperAdmin/backend.email')}}</th>
                        <th>{{__('SuperAdmin/backend.created_on')}}</th>
                        <th>{{__('SuperAdmin/backend.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allcustomers as $customer)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ucwords($customer->{'first_name_' . get_language() } )}}</td>
                            <td>{{ucwords($customer->{'last_name_'. get_language() } )}}</td>

                            <td>{{$customer->email}}</td>
                            <td>{{$customer->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href  = "#" data-toggle="modal" data-target="#SendMessageModal{{$customer->id}}" class="btn btn-info btn-sm fa fa-telegram"></a>


                                </div>
                            </td>

                        </tr>

                        {{--

Modal Send Message STarts


--}}


                        <div class="modal fade" id="SendMessageModal{{$customer->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="{{route('schooladmin.send_message.sendmessage')}}" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="exampleModalLabel">@lang('SchoolAdmin.send_message_student') </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                            @csrf

                                        <div class="form-group">
                                            <label
                                                for="exampleInputname">@lang('SuperAdmin/backend.email')</label>
                                            <input type="name" class="form-control" id="study_english"
                                                   aria-describedby="emailHelp"
                                                   value="{{$customer->email}}" name="email" readonly
                                                   placeholder="@lang('SuperAdmin/backend.email')">
                                            <br>



                                            <label
                                                for="exampleInputname">@lang('SuperAdmin/backend.subject')</label>
                                            <input type="name" class="form-control" id="study_english"
                                                   aria-describedby="emailHelp"
                                                   name="subject"
                                                   placeholder="@lang('SuperAdmin/backend.subject')">
                                            <br>

                                            <label
                                                for="exampleFormControlTextarea1">@lang('SuperAdmin/backend.message')</label>
                                            <textarea rows="3" id="exampleFormControlTextarea1" name="message" class="form-control"></textarea>
                                            <br>


                                                    <label
                                                for="exampleInputname">@lang('SchoolAdmin.send_attachment')</label>
                                            <input type="file" name="file" class="form-control" id="study_english"
                                                   aria-describedby="emailHelp">


                                            <br>

                                        </div>

                                    </div>
                                    <div class="modal-footer pt-0">
                                        <button
                                            type="submit"
                                          class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
                                    </div>

                                </div>
                                </form>
                            </div>
                        </div>
                        {{--

                        Modal Send Message Ends


                        --}}
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @include('superadmin.courses.modals')
@endsection
