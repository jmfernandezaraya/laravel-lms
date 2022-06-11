@extends('superadmin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.currencies')}}</h1>
                </div>

                @if (auth('superadmin')->user()->permission['course_manager'])
                    <a href="{{route('superadmin.setting.currency.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('SuperAdmin/backend.currency')}}</th>
                            <th>{{__('SuperAdmin/backend.exchange_rate')}}</th>
                            <th>{{__('SuperAdmin/backend.default')}}</th>
                            <th>{{__('SuperAdmin/backend.created_on')}}</th>
                            @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['currency_deit'])
                                <th>{{__('SuperAdmin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($currencies as $currency)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->exchange_rate }}</td>
                                <td>{{ $currency->is_default ? __('SuperAdmin/backend.default') : '' }}</td>
                                <td>{{ $currency->created_at->diffForHumans() }}</td>
                                @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['currency_deit'])
                                    <td>
                                        <div class="btn-group">
                                            @if (auth('superadmin')->user()->permission['course_manager'] || auth('superadmin')->user()->permission['currency_deit'])
                                                <a href="{{route('superadmin.setting.currency.edit', $currency->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                            @endif
                                            
                                            @if (auth('superadmin')->user()->permission['course_manager'])
                                                @if(!$currency->is_default)
                                                    <form action="{{route('superadmin.setting.currency.set_default', $currency->id)}}" method="POST">
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('{{__('SuperAdmin/backend.confirm_set_default')}}')" class="btn btn-primary btn-sm fa fa-check"></button>
                                                    </form>
                                                @endif

                                                <form action="{{route('superadmin.setting.currency.destroy', $currency->id)}}" method="POST">
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

    @section('js')
        <script>
            var maxLength = 100;
            $(".show-read-more").each(function() {
                var myStr = $(this).text();
                if ($.trim(myStr).length > maxLength) {
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                    $(this).empty().html(newStr);
                    $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
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