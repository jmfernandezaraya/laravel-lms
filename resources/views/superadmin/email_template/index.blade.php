@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.email_templates')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.email_templates')}}</h1>
                </div>
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
                            <th>{{__('Admin/backend.name')}}</th>
                            <th>{{__('Admin/backend.sender_name')}}</th>
                            <th>{{__('Admin/backend.sender_email')}}</th>
                            <th>{{__('Admin/backend.subject')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($email_templates as $email_template)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $email_template->name }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $email_template->sender_name : $email_template->sender_name_ar }}</td>
                                <td>{{ $email_template->sender_email }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $email_template->subject : $email_template->subject_ar }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.email_template.edit', $email_template->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
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