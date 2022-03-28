@extends('superadmin.layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body table table-responsive">
<div style="text-align: center;"><h1 class="card-title">Course Application Details</h1></div>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <td>Date Created</td>
            {{--@foreach($booked_details as $booked)


                --}}{{--{{dd($booked->getAttributesName())}}--}}{{--

                @if($loop->iteration == 1)

                    @foreach($booked->getAttributesName() as $key => $attribute)


                        <th>{{ucwords(str_replace('mname', 'Middle Name', str_replace('fname', 'Frist Name', str_replace('dob', 'Date Of Birth', str_replace('lname', 'Last Name', str_replace('_', ' ', $key))))))}}</th>
                @endforeach
            @endif
        @endforeach--}}
        <th>Name</th>

            <th>Email</th>
            <th>Mobile</th>
            <th>School Name</th>
            <th>City</th>
            <th>Country</th>
            <th>Programme Name</th>
            <th>Start Date</th>
            <th>Duration</th>
            <th>Course Cost</th>
            <th>Amount paid</th>
            <th>Application Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($booked_details as $details)
          {{--  @if(!isset($details->course) || !isset($details->course->school))
                @php continue; @endphp

            @endif--}}
            <tr>

                <td>{{$loop->iteration}}</td>
                <td>{{$details->created_at}}</td>
                <td>{{ucwords($details->fname) }} {{ucwords($details->lname) }}</td>

                <td>{{ ucwords($details->userBookDetailsApproved->email ?? $details->email)  }}</td>
                <td>{{ ucwords($details->userBookDetailsApproved->mobile ?? $details->mobile)  }}</td>
                <td>{{ ucwords(get_language() == 'en' ? $details->course->school->name : $details->course->school->name_ar )  }}</td>
                <td>{{ ucwords( $details->course->school->city)  }}</td>
                <td>{{ ucwords($details->course->school->country)  }}</td>
                <td>{{ ucwords($details->course->program_name )  }}</td>
                <td>{{ ucwords($details->start_date )  }}</td>
                <td>{{ ucwords($details->program_duration )  }}</td>
                <td>{{ ucwords($details->other_currency )  }}</td>
                <td>{{ ucwords($details->paid_amount )  }}</td>

                <td>{{ isset($details->userBookDetailsApproved->approve) ? ucwords($details->userBookDetailsApproved->approve  == 1 ? 'Application Recevived' : 'Send To School Admin' ) : 'Application Recevived'  }}</td>



                                        <td>
                                            <div class="btn-group">
                                                <a href="{{route('superadmin.manage_application.edit', $details->id)}}" class="btn btn-info btn-sm fa fa-eye"></a>

                                                @if(isset($details->userBookDetailsApproved->approved))
                                                    @if($details->userBookDetailsApproved->approved == 1)
                                                <a href="{{route('superadmin.manage_application.approve', ['id' => $details->id, 'value' => 0])}}" class="btn btn-success btn-sm fa fa-check"></a>
                                                @else
                                                <a href="{{route('superadmin.manage_application.approve', ['id' => $details->id, 'value' => 1])}}" class="btn btn-danger btn-sm fa fa-window-close"></a>
                                                    @endif

                                                @endif
                                            </div>
                                        </td>

            </tr>

        @endforeach
        </tbody>
    </table>
</div>
</div>
</div>



@endsection



