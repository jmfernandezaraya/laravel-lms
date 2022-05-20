@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.blog_details')}}
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.blog_details')}}</h1>
                </div>
                <a href="{{route('superadmin.blogs.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i>&nbsp;{{__('SuperAdmin/backend.add')}}
                </a>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('SuperAdmin/backend.blog_title')}}</th>
                            <th>{{__('SuperAdmin/backend.blog_description')}}</th>
                            <th>{{__('SuperAdmin/backend.created_on')}}</th>
                            <th>{{__('SuperAdmin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($blog->{'title_' . get_language()}) }}</td>
                                <td class="show-read-more">
                                    <p>{!! ucwords($blog->{'description_'. get_language()}) !!}</p>
                                </td>
                                <td>{{ $blog->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.blogs.edit', $blog->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        <form action="{{route('superadmin.blogs.destroy', $blog->id)}}" method="POST">
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