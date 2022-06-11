@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.your_review')}}
@endsection

@section('breadcrumbs')
    <h1>{{__('Frontend.your_review')}}</h1>
@endsection

@section('content')
    <div class="dashboard">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-md-12">
                    <h3>{{__('Frontend.your_bookings')}}</h3>
                    @foreach ($course_booked_details as $course_booked_detail)
                        <div class="review-box">
                            <div class="review-head">
                                <div class="review-dates">
                                    <div class="review-date">
                                        <label>{{__('Frontend.booking_date')}}</label>
                                        <p>{{ $course_booked_detail->created_at->format('d F Y') }}</p>
                                    </div>
                                    <div class="review-date">
                                        <label>{{__('Frontend.complete_date')}}</label>
                                        <p>{{ $course_booked_detail->updated_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                                <a href="{{route('dashboard.course_application', $course_booked_detail->id)}}">
                                    <button type="button" class="btn btn-primary float-right px-3">
                                        {{__('Frontend.view_your_booking')}}
                                    </button>
                                </a>
                            </div>
                            <div class="review-body">
                                <div class="row">
                                    <div class="review-logo col-md-3">
                                        <img src="{{ $course_booked_detail->school->logo }}" alt="School"  class="img-fluid"/>
                                    </div>
                                    <div class="review-content col-md-6">
                                        <p>
                                            <label class="review-no">
                                                {{__('Frontend.booking_number')}}: {{ $course_booked_detail->id }}
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                {{__('Frontend.name')}}:
                                                @if (app()->getLocale() == 'en')
                                                    {{ $course_booked_detail->school->name }}
                                                @else
                                                    {{ $course_booked_detail->school->name_ar }}
                                                @endif
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                {{__('Frontend.city')}}:
                                                @if (app()->getLocale() == 'en')
                                                    {{ $course_booked_detail->school->city }}
                                                @else
                                                    {{ $course_booked_detail->school->city_ar }}
                                                @endif
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                {{__('Frontend.country')}}:
                                                @if (app()->getLocale() == 'en')
                                                    {{ $course_booked_detail->school->country }}
                                                @else
                                                    {{ $course_booked_detail->school->country_ar }}
                                                @endif
                                            </label>
                                        </p>
                                    </div>
                                    <div class="review-actions col-md-3">
                                        @if ($course_booked_detail->status != 'cancelled' && $course_booked_detail->status != 'request_cancellation' && $course_booked_detail->status != 'application_cancelled')
                                            @if ($course_booked_detail->review)
                                                <a href="{{route('dashboard.review', $course_booked_detail->id)}}">
                                                    <button type="button" class="btn btn-primary float-right px-3">
                                                        {{__('Frontend.edit_the_review')}}
                                                    </button>
                                                </a>
                                            @else
                                                <a href="{{route('dashboard.review', $course_booked_detail->id)}}">
                                                    <button type="button" class="btn btn-primary float-right px-3">
                                                        {{__('Frontend.rate_write_a_review')}}
                                                    </button>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection