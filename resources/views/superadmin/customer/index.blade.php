@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.customers')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.customers')}}</h1>
                </div>
                @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_add'])
                    <a href="{{ route('superadmin.user.customer.create') }}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('SuperAdmin/backend.customer_number')}}</th>
                            <th>{{__('SuperAdmin/backend.date_created')}}</th>
                            <th>{{__('SuperAdmin/backend.name')}}</th>
                            <th>{{__('SuperAdmin/backend.email')}}</th>
                            <th>{{__('SuperAdmin/backend.mobile')}}</th>
                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'])
                                <th>{{__('SuperAdmin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>{{ ucwords(get_language() == 'en' ? $customer->first_name_en : $customer->first_name_ar) }}&nbsp;{{ ucwords(get_language() == 'en' ? $customer->last_name_en : $customer->last_name_ar) }}</td>
                                <td>{{ ucwords(get_language() == 'en' ? $customer->email : $customer->email_ar) }}</td>
                                <td>{{ $customer->contact }}</td>
                                @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'] || auth('superadmin')->user()->permission['user_delete'])
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('superadmin.course.list.customer', $customer->id)}}" class="btn btn-primary btn-sm fa fa-eye"></a>
                                            <a href="{{route('superadmin.manage_application.list.customer', $customer->id)}}" class="btn btn-success btn-sm fa fa-eye"></a>
                                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_edit'])
                                                <a href="{{route('superadmin.user.customer.edit', $customer->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            @if (auth('superadmin')->user()->permission['user_manager'] || auth('superadmin')->user()->permission['user_delete'])
                                                <form action="{{route('superadmin.user.customer.destroy', $customer->id)}}" method="POST">
                                                    @csrf @method('DELETE')
                                                    
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
    
    @section('js')
        <script>
            var maxLength = 100;
            $(".show-read-more").each(function() {
                var myStr = $(this).text();
                if ($.trim(myStr).length > maxLength) {
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                    $(this).empty().html(newStr);
                    $(this).append('<a href="javascript:void(0);" class="read-more"> read more... </a>');
                    $(this).append('<span class="more-text">' + removedStr + '</span>');
                }
            });
            $(".read-more").click(function() {
                $(this).siblings(".more-text").contents().unwrap();
                $(this).remove();
            });
        </script>
    @endsection
@endsection