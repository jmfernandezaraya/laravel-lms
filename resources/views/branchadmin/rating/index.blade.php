@extends('branchadmin.layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;"><h1 class="card-title">@lang('SuperAdmin/backend.rating_details')</h1></div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> @lang('SuperAdmin/backend.name')</th>
                            <th> @lang('SuperAdmin/backend.comments')</th>
                            <th> @lang('SuperAdmin/backend.user_name')</th>
                            <th>{{__('SuperAdmin/backend.rated')}}</th>
                            <th>{{__('SuperAdmin/backend.created_on')}}</th>
                            <th>{{__('SuperAdmin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\Ghanem\Rating\Models\Rating::with('schools')->with('users')->get() as $rating)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ucwords($rating->schools->name)}}</td>
                                <td>{{$rating->comments == null ? __('Frontend.no_comments') : $rating->comments}}</td>
                                <td>{{ $rating->users->{'first_name_' . app()->getLocale() } . " "  .$rating->users->{'last_name_'.app()->getLocale() } }}</td>
                                <td>{{$rating->rating}}</td>
                                <td>{{$rating->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        @if(!$rating->approved)
                                            <a href="{{route('branch_admin.rating.approve', $rating->id)}}" class="btn btn-info btn-sm fa fa-check"></a>
                                        @else
                                            <button type="button" class="btn btn-success btn-sm">{{__('SuperAdmin/backend.approved')}}</button>
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