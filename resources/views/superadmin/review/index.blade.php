@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.rating_review')}}
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body table table-responsive">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.rating_review')}}</h1>
                </div>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <td>{{__('SuperAdmin/backend.name')}}</td>
                            <th>{{__('SuperAdmin/backend.comments')}}</th>
                            <th>{{__('SuperAdmin/backend.user_name')}}</th>
                            <th>{{__('SuperAdmin/backend.rated')}}</th>
                            <th>{{__('SuperAdmin/backend.created_at')}}</th>
                            <th>{{__('SuperAdmin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ isset($review->course_booked_details->school) ? (app()->getLocale() == 'en' ? $review->course_booked_details->school->name : $review->course_booked_details->school->name_ar) : '-' }}</td>
                                <td>{{ $review->review }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $review->user->first_name_en . ' ' . $review->user->last_name_en : $review->user->first_name_ar . ' ' . $review->user->last_name_ar }}</td>
                                <td>{{ toFixedNumber($review->rated()) }}</td>
                                <td>{{ $review->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('superadmin.review.edit', $review->id)}}" class="btn btn-info btn-sm fa fa-eye"></a>
                                        @if ($review->approved == 1)
                                            <a href="{{route('superadmin.review.approve', ['id' => $review->id])}}" class="btn btn-success btn-sm fa fa-check"></a>
                                        @else
                                            <a href="{{route('superadmin.review.disapprove', ['id' => $review->id])}}" class="btn btn-danger btn-sm fa fa-window-close"></a>
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