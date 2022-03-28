@extends('superadmin.layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div class="row">
                    <div class="form-group col-md-12">
                        <center>
                            <h1 class="card-title">{{__('SuperAdmin/backend.currencies')}}</h1>
                        </center>
                    </div>
                </div>

                <a href="{{route('superadmin.currency.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                </a>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('SuperAdmin/backend.currency')}}</th>
                            <th>{{__('SuperAdmin/backend.exchange_rate')}}</th>
                            <th>{{__('SuperAdmin/backend.default')}}</th>
                            <th>{{__('SuperAdmin/backend.created_on')}}</th>
                            <th>{{__('SuperAdmin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($currencies as $currency)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$currency->name}}</td>
                                <td>{{$currency->exchange_rate}}</td>
                                <td>{{$currency->is_default ? __('SuperAdmin/backend.default') : ''}}</td>
                                <td>{{$currency->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.currency.edit', $currency->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        @if(!$currency->is_default)
                                            <form action="{{route('superadmin.currency.set_default', $currency->id)}}" method="POST">
                                                @csrf
                                                <button type="submit" onclick="return confirm('{{__('SuperAdmin/backend.confirm_set_default')}}')" class="btn btn-primary btn-sm fa fa-check"></button>
                                            </form>
                                        @endif
                                        <form action="{{route('superadmin.currency.destroy', $currency->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
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
            .show-read-more .more-text{
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