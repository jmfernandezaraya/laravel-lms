@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.rating_review')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.rating_review')}}</h1>
                </div>
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
                            <td>{{__('Admin/backend.name')}}</td>
                            <th>{{__('Admin/backend.comments')}}</th>
                            <th>{{__('Admin/backend.user_name')}}</th>
                            <th>{{__('Admin/backend.rated')}}</th>
                            <th>{{__('Admin/backend.approved')}}</th>
                            <th>{{__('Admin/backend.created_at')}}</th>
                            <th>{{__('Admin/backend.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ isset($review->course_applications->school->name) ? (app()->getLocale() == 'en' ? $review->course_applications->school->name->name : $review->course_applications->school->name->name_ar) : '-' }}</td>
                                <td>{{ $review->review }}</td>
                                <td>{{ app()->getLocale() == 'en' ? $review->user->first_name_en . ' ' . $review->user->last_name_en : $review->user->first_name_ar . ' ' . $review->user->last_name_ar }}</td>
                                <td>{{ toFixedNumber($review->average_point) }}</td>
                                <td>
                                    @if ($review->approved == 1)
                                        <button class="btn btn-success btn-sm fa fa-check"></button>
                                    @else
                                        <button class="btn btn-danger btn-sm fa fa-window-close"></button>
                                    @endif
                                </td>
                                <td>{{ $review->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ auth('superadmin')->check() ? route('superadmin.review.edit', $review->id) : route('schooladmin.review.edit', $review->id) }}" class="btn btn-info btn-sm fa fa-pencil"></a>
                                        @if ($review->approved == 1)
                                            <a href="{{ auth('superadmin')->check() ? route('superadmin.review.disapprove', ['id' => $review->id]) : route('schooladmin.review.disapprove', ['id' => $review->id]) }}" class="btn btn-danger btn-sm fa fa-window-close"></a>
                                        @else
                                            <a href="{{ auth('superadmin')->check() ? route('superadmin.review.approve', ['id' => $review->id]) : route('schooladmin.review.approve', ['id' => $review->id]) }}" class="btn btn-success btn-sm fa fa-check"></a>
                                        @endif
                                        <form action="{{ auth('superadmin')->check() ? route('superadmin.review.destroy', $review->id) : route('schooladmin.review.destroy', $review->id) }}" method="post">
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
@endsection