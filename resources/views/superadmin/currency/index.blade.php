@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.currencies')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.currencies')}}</h1>
                </div>

                @if (can_manage_currency() || can_add_currency())
                    <a href="{{route('superadmin.currency.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('Admin/backend.currency')}}</th>
                            <th>{{__('Admin/backend.exchange_rate')}}</th>
                            <th>{{__('Admin/backend.default')}}</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            @if (can_manage_currency() || can_edit_currency())
                                <th>{{__('Admin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($currencies as $currency)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ get_language() == 'en' ? $currency->name : $currency->name_ar }}</td>
                                <td>{{ $currency->exchange_rate }}</td>
                                <td>{{ $currency->is_default ? __('Admin/backend.default') : '' }}</td>
                                <td>{{ $currency->created_at->diffForHumans() }}</td>
                                @if (can_manage_currency() || can_edit_currency() || can_delete_currency())
                                    <td>
                                        <div class="btn-group">
                                            @if (can_manage_currency() || can_edit_currency())
                                                <a href="{{route('superadmin.currency.edit', $currency->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            
                                            @if (can_manage_currency() || can_delete_currency())
                                                @if (can_manage_currency())
                                                    @if(!$currency->is_default)
                                                        <form action="{{route('superadmin.currency.set_default', $currency->id)}}" method="POST">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('{{__('Admin/backend.confirm_set_default')}}')" class="btn btn-primary btn-sm fa fa-check"></button>
                                                        </form>
                                                    @endif
                                                @endif

                                                <form action="{{route('superadmin.currency.destroy', $currency->id)}}" method="POST">
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