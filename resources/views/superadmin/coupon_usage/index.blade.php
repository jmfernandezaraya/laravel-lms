@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.coupons')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.coupons')}}</h1>
                </div>

                @if (can_manage_coupon() || can_add_coupon())
                    <a href="{{route('superadmin.coupon.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('Admin/backend.coupon_name')}}</th>
                            <th>{{__('Admin/backend.code')}}</th>
                            <th>{{__('Admin/backend.discount_code')}}</th>
                            <th>{{__('Admin/backend.start_date')}}</th>
                            <th>{{__('Admin/backend.end_date')}}</th>
                            <th>{{__('Admin/backend.type')}}</th>
                            @if (can_manage_course() || can_edit_course())
                                <th>{{__('Admin/backend.action')}}</th>
                            @endif
                            <th>{{__('Admin/backend.created_on')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ get_language() == 'en' ? $coupon->name : $coupon->name_ar }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->discount }}</td>
                                <td>{{ $coupon->start_date }}</td>
                                <td>{{ $coupon->end_date }}</td>
                                <td>{{ $coupon->type }}</td>
                                @if (can_manage_coupon() || can_edit_coupon() || can_delete_coupon())
                                    <td>
                                        <div class="btn-group">
                                            @if (can_manage_coupon() || can_edit_coupon())
                                                <a href="{{route('superadmin.coupon.edit', $coupon->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            
                                            @if (can_manage_coupon() || can_delete_coupon())
                                                @if (can_manage_coupon())
                                                    @if(!$coupon->is_default)
                                                        <form action="{{route('superadmin.coupon.set_default', $coupon->id)}}" method="POST">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('{{__('Admin/backend.confirm_set_default')}}')" class="btn btn-primary btn-sm fa fa-check"></button>
                                                        </form>
                                                    @endif
                                                @endif

                                                <form action="{{route('superadmin.coupon.destroy', $coupon->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                <td>{{ $coupon->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection