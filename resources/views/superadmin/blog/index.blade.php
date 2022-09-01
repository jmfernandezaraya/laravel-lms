@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.blog_details')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.blog_details')}}</h1>
                </div>
                
                @if (can_manage_blog() || can_add_blog())
                    <a href="{{route('superadmin.blog.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
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
                            <th>{{__('Admin/backend.blog_title')}}</th>
                            <th>{{__('Admin/backend.blog_description')}}</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            @if (can_manage_blog() || can_edit_blog() || can_delete_blog())
                                <th>{{__('Admin/backend.action')}}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($blog->{'title_' . get_language()}) }}</td>
                                <td class="show-read-more">
                                    <p>{!! $blog->{'description_'. get_language()} !!}</p>
                                </td>
                                <td>{{ $blog->created_at }}</td>
                                @if (can_manage_blog() || can_edit_blog() || can_delete_blog())
                                    <td>
                                        <div class="btn-group">
                                            @if (can_manage_blog() || can_edit_blog())
                                                <a href="{{route('superadmin.blog.edit', $blog->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                                
                                                @if ($blog->display)
                                                    <form method="post" action="{{route('superadmin.blog.pause', $blog->id)}}">
                                                        @csrf
                                                        <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_pause')}}')" class="btn btn-secondary btn-sm fa fa-pause"></button>
                                                    </form>
                                                @else
                                                    <form method="post" action="{{route('superadmin.blog.play', $blog->id)}}">
                                                        @csrf
                                                        <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_play')}}')" class="btn btn-success btn-sm fa fa-play"></button>
                                                    </form>
                                                @endif
                                            @endif

                                            @if (can_manage_blog() || can_delete_blog())
                                                <form action="{{route('superadmin.blog.destroy', $blog->id)}}" method="POST">
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
                    $(this).append(' <a href="javascript:void(0);" class="read-more">' + '{{__("Admin/backend.read_more")}}' + '...</a>');
                    $(this).append('<span class="more-text"> ' + removedStr + ' </span>');
                    }
                });
                $(".read-more").click(function() {
                    $(this).siblings(".more-text").contents().unwrap();
                    $(this).remove();
                });
        </script>
    @endsection
@endsection