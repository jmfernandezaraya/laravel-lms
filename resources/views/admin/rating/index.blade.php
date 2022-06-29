@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.rating_details')}}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Admin/backend.name')}}</th>
                            <th>{{__('Admin/backend.comments')}}</th>
                            <th>{{__('Admin/backend.user_name')}}</th>
                            <th>{{__('Admin/backend.rated')}}</th>
                            <th>{{__('Admin/backend.created_on')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\Ghanem\Rating\Models\Rating::all() as $rating)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ucwords($rating->schools->name)}}</td>
                                <td>
                                    {{$rating->comments == null ? __('Frontend.no_comments') : $rating->comments}}
                                </td>
                                <td>{{ $rating->users->{'first_name_' . app()->getLocale() } . " "  . $rating->users->{'last_name_'.app()->getLocale() } }}</td>
                                <td>
                                    {{$rating->rating}}
                                </td>
                                <td>
                                    {{$rating->created_at}}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if(!$rating->approved)
                                            <a href="{{route('admin.rating.approve', $rating->id)}}" class="btn btn-info btn-sm fa fa-check"></a>
                                        @else
                                            <button type="button" class="btn btn-success btn-sm">{{__('Admin/backend.approved')}}</button>
                                        @endif

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