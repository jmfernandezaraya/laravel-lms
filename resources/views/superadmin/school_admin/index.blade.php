@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.school_admin_details')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.school_admin_details')}}</h1>
                </div>

                @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_add'])
                    <a href="{{route('superadmin.user.school_admin.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="page-content">
        <div class="card">
            <div class="card-body table table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('SuperAdmin/backend.first_name')}}</th>
                            <th>{{__('SuperAdmin/backend.last_name')}}</th>
                            <th>{{__('SuperAdmin/backend.email')}}</th>
                            <th>{{__('SuperAdmin/backend.contact_no')}}</th>
                            <th>{{__('SuperAdmin/backend.profile_image')}}</th>
                            <th>{{__('SuperAdmin/backend.permissions_given')}}</th>
                            <th>{{__('SuperAdmin/backend.created_on')}}</th>
                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'])
                                <th>{{__('SuperAdmin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($school_admins as $school_admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($school_admin->{'first_name_'.get_language()}) }}</td>
                                <td>{{ ucwords($school_admin->{'last_name_'.get_language()}) }}</td>
                                <td>{{ $school_admin->email == null ? '-----' : $school_admin->email }}</td>
                                <td>{{ ucwords($school_admin->contact) }}</td>
                                <td>
                                    @if ($school_admin->image != null || $school_admin->image != '')
                                        <img width="200px" height="200px" src="{{ asset($school_admin->image) }}">
                                    @else
                                        <img width="200px" height="200px" src="{{ asset('/assets/images/no-image.jpg') }}">
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if (optional($school_admin->editCoursePermission)->add == 1)
                                            <button class='btn btn-success btn-sm'>{{__('SuperAdmin/backend.add')}}</button>
                                        @else
                                            <button class='btn btn-danger btn-sm'>{{__('SuperAdmin/backend.add')}}</button>
                                        @endif
                                        @if (optional($school_admin->editCoursePermission)->edit == 1)
                                            <button class='btn btn-success btn-sm'>{{__('SuperAdmin/backend.edit')}}</button>
                                        @else
                                            <button class='btn btn-danger btn-sm'>{{__('SuperAdmin/backend.edit')}}</button>
                                        @endif
                                        @if (optional($school_admin->editCoursePermission)->delete == 1)
                                            <button class='btn btn-success btn-sm'>{{__('SuperAdmin/backend.delete')}}</button>
                                        @else
                                            <button class='btn btn-danger btn-sm'>{{__('SuperAdmin/backend.delete')}}</button>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $school_admin->created_at->diffForHumans() }}</td>
                                @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'])
                                    <td>
                                        <div class="btn-group">
                                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'])
                                                <a href="{{route('superadmin.user.school_admin.edit', $school_admin->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            
                                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_delete'])
                                                <form action="{{route('superadmin.user.school_admin.destroy', $school_admin->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection