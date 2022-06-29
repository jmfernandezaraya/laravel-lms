@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.front_pages')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.front_pages')}}</h1>
                </div>
                <a href="{{route('superadmin.setting.front_page.create')}}" type="button" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i>&nbsp;{{__('Admin/backend.add')}}
                </a>
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
                            <th>{{__('Admin/backend.title')}}</th>
                            <th>{{__('Admin/backend.slug')}}</th>
                            <th>{{__('Admin/backend.route')}}</th>
                            <th>{{__('Admin/backend.display')}}</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($front_pages as $front_page)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</td>
                                <td>{{ $front_page->slug }}</td>
                                <td>
                                    @if ($front_page->route)
                                        <i class="btn btn-info btn-sm fa fa-check"></i>
                                    @else
                                        <i class="btn btn-danger btn-sm fa fa-times"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($front_page->display)
                                        <i class="btn btn-info btn-sm fa fa-check"></i>
                                    @else
                                        <i class="btn btn-danger btn-sm fa fa-times"></i>
                                    @endif
                                </td>
                                <td>{{ $front_page->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.setting.front_page.edit', $front_page->id)}}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        
                                        @if ($front_page->display)
                                            <form method="post" action="{{route('superadmin.setting.front_page.pause', $front_page->id)}}">
                                                @csrf
                                                <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_pause')}}')" class="btn btn-secondary btn-sm fa fa-pause"></button>
                                            </form>
                                        @else
                                            <form method="post" action="{{route('superadmin.setting.front_page.play', $front_page->id)}}">
                                                @csrf
                                                <button onclick="return confirm('{{__('Admin/backend.are_you_sure_you_wanna_play')}}')" class="btn btn-success btn-sm fa fa-play"></button>
                                            </form>
                                        @endif

                                        <form action="{{route('superadmin.setting.front_page.destroy', $front_page->id)}}" method="POST">
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
@endsection