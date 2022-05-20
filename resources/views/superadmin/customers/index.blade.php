@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.customers')}}
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.customers')}}</h1>
                </div>
                <a href="{{ route('superadmin.customers.create') }}" type="button" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                </a>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('SuperAdmin/backend.customer_number')}}</th>
                            <th>{{__('SuperAdmin/backend.date_created')}}</th>
                            <th>{{__('SuperAdmin/backend.name')}}</th>
                            <th>{{__('SuperAdmin/backend.email')}}</th>
                            <th>{{__('SuperAdmin/backend.mobile')}}</th>
                            <th>{{__('SuperAdmin/backend.action')}}</th>
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
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.customers.edit', $customer->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        <form action="{{route('superadmin.customers.destroy', $customer->id)}}" method="POST">
                                            @csrf @method('DELETE')
                                            
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

    @section('css')
        <style>
            .show-read-more .more-text {
                display: none;
            }
        </style>
    @endsection
    
    @section('js')
    <script>
        var maxLength = 100;
        $(".show-read-more").each(function() {
            var myStr = $(this).text();
            if ($.trim(myStr).length > maxLength) {
                var newStr = myStr.substring(0, maxLength);
                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                $(this).empty().html(newStr);
                $(this).append('  < a href="javascript:void(0);" class = "read-more" > read more... < /a>');
                $(this).append(' < span class = "more-text" > ' + removedStr + ' < /span>');
            }
        });
        $(".read-more").click(function() {
            $(this).siblings(".more-text").contents().unwrap();
            $(this).remove();
        });
    </script>
    @endsection
@endsection