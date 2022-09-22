@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('Admin/backend.enquiry_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th> @lang('Admin/backend.first_name')</th>
                        <th> @lang('Admin/backend.last_name')</th>
                        <th> @lang('Admin/backend.email_address')</th>
                        <th>{{__('Frontend.phone')}}</th>
                        <th>{{__('Frontend.message')}}</th>
                        <th>{{__('Admin/backend.replied')}}</th>

                        <th>{{__('Admin/backend.created_on')}}</th>
                        <th>{{__('Admin/backend.action')}}</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($enquiries as $enquiry)

                        <tr>
                            <td>{{$loop->iteration   }}</td>
                            <td>{{ucwords($enquiry->first_name) }}</td>
                            <td>{{ucwords($enquiry->last_name)}}</td>
                            <td class="email_id_this">{{ucwords($enquiry->email)}}</td>
                            <td>{{ucwords($enquiry->phone)}}</td>
                            <td>{{ucwords($enquiry->message)}}</td>
                            <td>{{ucwords($enquiry->replied ? __('Admin/backend.yes') : __('Admin/backend.no'))}}</td>
                            <td>
                                {{$enquiry->created_at}}
                            </td>

                            <td>
                                <div class="btn-group">
                                    <a data-toggle="modal" data-target="#EnquiryModal{{$loop->iteration}}" href="javascript:void(0);" class="btn btn-info btn-sm fa fa-send"></a>


                                </div>
                            </td>

                        </tr>

                        {{--
                        Enquiry Reply Modal
                        --}}
                        <div class="modal fade" id="EnquiryModal{{$loop->iteration}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog" role="document">

                                <div class="modal-content">
                                    <form method="Post" action="{{route('enquiry.store')}}">
                                        @csrf
                                        <div class="modal-header">

                                            <center><h5 class="modal-title" id="exampleModalLabel">{{__('Admin/backend.reply_to_email')}}</h5> </center>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                <span aria-hidden="true">&times;</span>

                                            </button>

                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-group">{{__('Admin/backend.subject')}}</label>
                                                <input type  = "text" name="subject" class="form-control">

                                                <label class="form-group">{{__('Admin/backend.message')}}</label>
                                                <textarea id="message" rows="4" cols="50" name="message" class="form-control"></textarea>
                                                <input id="get_email_id" hidden value="{{$enquiry->email}}" name="email">
                                                <input hidden value="{{$enquiry->id}}" name="id">
                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                            <button type="submit" class="btn btn-primary">{{__('Admin/backend.send')}} </button>

                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('js')
<script>
function get_email(email){

    $('#get_email_id').val(email);

}

</script>
    @endsection
@endsection
