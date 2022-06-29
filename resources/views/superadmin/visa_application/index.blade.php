@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('Admin/backend.visa_application.application_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Visa Center</th>
                        <th>Other Field Details</th>
                        <th>Applying From</th>
                        <th>No. of People</th>
                        <th>Visa Type</th>
                        <th>Travelling To</th>
                        <th>Nationality</th>

                        <th>Paid Amount</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($visas as $visa)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ucwords($visa->user->{'first_name_'. get_language()} )}}  {{ucwords($visa->user->{'last_name_'. get_language()} )}}</td>
                            <td>{{ucwords($visa->visaCenter->{'application_center_' .get_language() } )}}</td>
                            <td><a href="{{route('superadmin.visa.otherfields', $visa->id)}}"class  ="btn btn-primary btn-sm">@lang('Admin/backend.click_here') </a></td>
                            <td>{{ucwords($visa->applyingFrom->{'apply_from_'.get_language()})}}</td>
                            <td>{{ucwords($visa->people)}}</td>
                            <td>{{ucwords($visa->typeOfVisa->{'visa_' . get_language()})}}</td>
                            <td>{{ucwords($visa->whereToTravel->{'travel_' . get_language() } )}}</td>
                            <td>{{ucwords($visa->getNationality->{'nationality_'.get_language()})}}</td>
                            <td>{{$visa->paid_amount}}</td>




                            <td>{{$visa->created_at->diffForHumans()}}</td><td>
                                {{--<div class="btn-group">
                                    <a href  = "{{route('visa.edit', $visa->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                    <form action="{{route('visa.destroy', $visa->id)}}" method="post">
                                        @csrf
                                        {{ method_field('delete') }}

                                        <button type="submit" onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>
                                    </form>

                                </div>--}}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
