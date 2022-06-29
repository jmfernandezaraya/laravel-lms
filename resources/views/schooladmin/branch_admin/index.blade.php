@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">

                <center><h1 class="card-title">{{__('Admin/backend.branch_admin_details')}}</h1></center>
                <a href="{{route('schooladmin.branch_admin.create')}}" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;{{__('Admin/backend.add')}}</a>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Admin/backend.first_name')}}</th>
                        <th>{{__('Admin/backend.last_name')}}</th>
                        <th>{{__('Admin/backend.email')}}</th>
                        <th>{{__('Admin/backend.contact_no')}}</th>
                        <th>{{__('Admin/backend.profile_image')}}</th>
                        <th>Permissions Given</th>
                        <th>{{__('Admin/backend.created_on')}}</th>
                        <th>{{__('Admin/backend.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schools as $school)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>

                                {{ucwords($school->{'first_name_'.get_language()})}}</td>
                            <td>{{ucwords($school->{'last_name_'.get_language()})}}</td>
                            <td>{{$school->email == null ? '-----' : $school->email }}</td>




                            <td>{{ucwords($school->contact)}}</td>
                            <td>
                                @if($school->image != null || $school->image != '')
                                    <img width = "200px" height = "200px" src = "{{asset($school->image)}}">
                                @else
                                    <img width = "200px" height = "200px" src = "{{ asset('/assets/images/no-image.jpg') }}">

                                @endif




                            </td>
                            @php
                                $buttons = optional($school->editCoursePermission)->add == 1 ? "<button class = 'btn btn-success btn-sm'>Add</button>" : "<button class = 'btn btn-danger btn-sm'>Add</button>";
                                $buttons .= "&nbsp;" . optional($school->editCoursePermission)->edit == 1 ? "<button class = 'btn btn-success btn-sm'>Edit</button>" : "<button class = 'btn btn-danger btn-sm'>Edit</button>";
                                $buttons .= "&nbsp;" .optional($school->editCoursePermission)->delete == 1 ? "<button class = 'btn btn-success btn-sm'>Delete</button>" : "<button class = 'btn btn-danger btn-sm'>Delete</button>";

                            @endphp


                            <td><div class="btn-group">{!! $buttons !!}
                                </div>
                            </td>
                            <td>{{$school->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href  = "{{route('admin.school_admin.edit', $school->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                    <form action="{{route('admin.school_admin.destroy', $school->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>

                                    </form>
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
