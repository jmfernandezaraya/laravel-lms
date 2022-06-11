@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.super_admin_details')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.super_admin_details')}}</h1>
                </div>

                @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_add'])
                    <a href="{{route('superadmin.user.super_admin.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('SuperAdmin/backend.created_on')}}</th>
                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'])
                                <th>{{__('SuperAdmin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($super_admins as $super_admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($super_admin->{'first_name_' . get_language()}) }}</td>
                                <td>{{ ucwords($super_admin->{'last_name_' . get_language()}) }}</td>
                                <td>{{ $super_admin->email == null ? '-----' : $super_admin->email }}</td>
                                <td>{{ ucwords($super_admin->contact) }}</td>
                                <td>
                                    @if ($super_admin->image != null || $super_admin->image != '')
                                        <img width="200px" height="200px" src="{{ asset($super_admin->image) }}">
                                    @else
                                        <img width="200px" height="200px" src="{{ asset('/assets/images/no-image.jpg') }}">
                                    @endif
                                </td>
                                <td>{{ $super_admin->created_at->diffForHumans() }}</td>
                                @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'])
                                    <td>
                                        <div class="btn-group">
                                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'])
                                                <a href="{{route('superadmin.user.super_admin.edit', $super_admin->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            
                                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_delete'])
                                                <form action="{{route('superadmin.user.super_admin.destroy', $super_admin->id)}}" method="post">
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