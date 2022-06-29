@extends('branchadmin.layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.school_details')}}</h1>
                </div>
                <a href="{{route('school.create')}}" type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;{{__('Admin/backend.add')}}</a>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> {{__('Admin/backend.name')}}</th>
                            <th> {{__('Admin/backend.email_address')}}</th>
                            <th> {{__('Admin/backend.contact_number')}}</th>
                            <th> {{__('Admin/backend.branch_name')}}</th>
                            <th>{{__('Admin/backend.city')}}</th>
                            <th>{{__('Admin/backend.country')}}</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ucwords($school->name)}}</td>
                                <td>{{$school->email}}</td>
                                <td>{{$school->contact}}</td>
                                <td>{{implode(", ", $school->branch_name)}}</td>
                                <td>{{ucwords($school->city)}}</td>
                                <td>{{ucwords($school->country)}}</td>
                                <td>{{$school->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href  = "{{route('school.edit', $school->unique_id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        <form action="{{route('school.destroy', $school->unique_id)}}" method="post">
                                            @csrf
                                            {{ method_field('delete') }}
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