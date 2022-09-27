@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.payment_methods')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.payment_methods')}}</h1>
                </div>

                @if (can_manage_payment_method() || can_add_payment_method())
                    <a href="{{route('superadmin.payment_method.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('Admin/backend.default')}}</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            @if (can_manage_currency() || can_edit_currency())
                                <th>{{__('Admin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payment_methods as $payment_method)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ get_language() == 'en' ? $payment_method->name : $payment_method->name_ar }}</td>
                                <td>{{ $payment_method->is_default ? __('Admin/backend.default') : '' }}</td>
                                <td>{{ $payment_method->created_at->diffForHumans() }}</td>
                                @if (can_manage_payment_method() || can_edit_payment_method() || can_delete_payment_method())
                                    <td>
                                        <div class="btn-group">
                                            @if (can_manage_payment_method() || can_edit_payment_method())
                                                <a href="{{route('superadmin.payment_method.edit', $payment_method->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            
                                            @if (can_manage_payment_method() || can_delete_payment_method())
                                                @if (can_manage_payment_method())
                                                    @if(!$payment_method->is_default)
                                                        <form action="{{route('superadmin.payment_method.set_default', $payment_method->id)}}" method="POST">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('{{__('Admin/backend.confirm_set_default')}}')" class="btn btn-primary btn-sm fa fa-check"></button>
                                                        </form>
                                                    @endif
                                                @endif

                                                <form action="{{route('superadmin.payment_method.destroy', $payment_method->id)}}" method="POST">
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