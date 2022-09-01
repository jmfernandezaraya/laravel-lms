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

                @if (can_manage_email_template() || can_add_email_template())
                    <a href="{{route('superadmin.email_template.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-plus"></i>&nbsp;{{__('Admin/backend.add')}}
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
                            <th>{{__('Admin/backend.name')}}</th>
                            <th>{{__('Admin/backend.smtp_server')}}</th>
                            <th>{{__('Admin/backend.smtp_user_name')}}</th>
                            <th>{{__('Admin/backend.sender_name')}}</th>
                            <th>{{__('Admin/backend.sender_email')}}</th>
                            <th>{{__('Admin/backend.subject')}}</th>
                            @if (can_manage_email_template() || can_edit_email_template() || can_delete_email_template())
                                <th>{{__('Admin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($email_templates as $email_template)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $email_template->name }}</td>
                                <td>{{ $email_template->smtp_server ?? '-' }}</td>
                                <td>{{ $email_template->smtp_user_name ?? '-' }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $email_template->sender_name : $email_template->sender_name_ar }}</td>
                                <td>{{ $email_template->sender_email }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $email_template->subject : $email_template->subject_ar }}</td>                                
                                @if (can_manage_email_template() || can_edit_email_template() || can_delete_email_template())
                                    <td>
                                        <div class="btn-group">
                                            @if (can_manage_email_template() || can_edit_email_template())
                                                <a href="{{route('superadmin.email_template.edit', $email_template->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif                                                
                                                
                                            @if (can_manage_email_template() || can_delete_email_template())
                                                <form action="{{route('superadmin.email_template.destroy', $email_template->id)}}" method="post">
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