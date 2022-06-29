@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.edit_rating_review')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.edit_rating_review')}}</h1>
                </div>

                @include('admin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="reviewForm" class="forms-sample" method="post" action="{{route('admin.review.update', $review->id)}}">
                    {{csrf_field()}}
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h3>{{__('Admin/backend.school_and_teaching')}}</h3>

                            <div class="form-group">
                                <label for="quality_of_teaching" class="col-form-label">{{__('Admin/backend.quality_of_teaching')}}</label>
                                <input type="hidden" name="quality_teaching" value="{{ $review ? $review->quality_teaching : 0 }}" />
                                <div class="rating-input quality-teaching" data-name="quality_teaching" data-value="{{ $review ? floatval($review->quality_teaching) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="school_facilities" class="col-form-label">{{__('Admin/backend.school_facilities')}}</label>
                                <input type="hidden" name="school_facilities" value="{{ $review ? $review->school_facilities : 0 }}" />
                                <div class="rating-input school-facilities" data-name="school_facilities" data-value="{{ $review ? floatval($review->school_facilities) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="social_activities" class="col-form-label">{{__('Admin/backend.social_activities')}}</label>
                                <input type="hidden" name="social_activities" value="{{ $review ? $review->social_activities : 0 }}" />
                                <div class="rating-input social-activities" data-name="social_activities" data-value="{{ $review ? floatval($review->social_activities) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="school_location" class="col-form-label">{{__('Admin/backend.school_location')}}</label>
                                <input type="hidden" name="school_location" value="{{ $review ? $review->school_location : 0 }}" />
                                <div class="rating-input school-location" data-name="school_location" data-value="{{ $review ? floatval($review->school_location) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="satisfied_teaching" class="col-form-label">{{__('Admin/backend.satisfied_teaching')}}</label>
                                <input type="hidden" name="satisfied_teaching" value="{{ $review ? $review->satisfied_teaching : 0 }}" />
                                <div class="rating-input satisfied-teaching" data-name="satisfied_teaching" data-value="{{ $review ? floatval($review->satisfied_teaching) : 0 }}"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h3>{{__('Admin/backend.accommodation')}}</h3>

                            <div class="form-group">
                                <label for="level_of_cleanliness" class="col-form-label">{{__('Admin/backend.level_of_cleanliness')}}</label>
                                <input type="hidden" name="level_cleanliness" value="{{ $review ? $review->level_cleanliness : 0 }}" />
                                <div class="rating-input level-of-cleanliness" data-name="level_cleanliness" data-value="{{ $review ? floatval($review->level_cleanliness) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="distance_accommodation_school" class="col-form-label">{{__('Admin/backend.distance_accommodation_school')}}</label>
                                <input type="hidden" name="distance_accommodation_school" value="{{ $review ? $review->distance_accommodation_school : 0 }}" />
                                <div class="rating-input distance-accommodation-school" data-name="distance_accommodation_school" data-value="{{ $review ? floatval($review->distance_accommodation_school) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="satisfied_accommodation" class="col-form-label">{{__('Admin/backend.satisfied_accommodation')}}</label>
                                <input type="hidden" name="satisfied_accommodation" value="{{ $review ? $review->satisfied_accommodation : 0 }}" />
                                <div class="rating-input satisfied-accommodation" data-name="satisfied_accommodation" data-value="{{ $review ? floatval($review->satisfied_accommodation) : 0 }}"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h3>{{__('Admin/backend.others')}}</h3>
                            
                            <div class="form-group">
                                <label for="airport_transfer" class="col-form-label">{{__('Admin/backend.airport_transfer')}}</label>
                                <input type="hidden" name="airport_transfer" value="{{ $review ? $review->airport_transfer : 0 }}" />
                                <div class="rating-input airport-transfer" data-name="airport_transfer" data-value="{{ $review ? floatval($review->airport_transfer) : 0 }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="city_activities" class="col-form-label">{{__('Admin/backend.city_activities')}}</label>
                                <input type="hidden" name="city_activities" value="{{ $review ? $review->city_activities : 0 }}" />
                                <div class="rating-input city-activities" data-name="city_activities" data-value="{{ $review ? floatval($review->city_activities) : 0 }}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="would_you_recommend_this_school" class="">{{__('Admin/backend.would_you_recommend_this_school')}}</label>
                                <input type="radio" value="1" name="recommend_this_school" {{ $review ? ($review->recommend_this_school ? 'checked' : '') : 'checked' }}>
                                <label for="recommend_this_school_yes">
                                    {{__('Admin/backend.yes')}}
                                </label>
                                <input type="radio" value="0" name="recommend_this_school" {{ $review ? ($review->recommend_this_school ? '' : 'checked') : '' }}>
                                <label for="recommend_this_school_no">
                                    {{__('Admin/backend.no')}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="write_a_review" class="col-form-label">{{__('Admin/backend.write_a_review')}}</label>
                                <textarea name="review" class="form-control" rows="5">{{ $review ? $review->review : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="use_my_full_name_for_the_rating_and_review" class="">{{__('Admin/backend.use_my_full_name_for_the_rating_and_review')}}</label>
                                <input type="radio" value="1" name="use_full_name" {{ $review ? ($review->use_full_name ? 'checked' : '') : 'checked' }}>
                                <label for="use_full_name_yes">
                                    {{__('Admin/backend.yes')}}
                                </label>
                                <input type="radio" value="0" name="use_full_name" {{ $review ? ($review->use_full_name ? '' : 'checked') : '' }}>
                                <label for="use_full_name_no">
                                    {{__('Admin/backend.no')}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{ url()->previous() }}">{{__('Admin/backend.cancel')}}</a>
                    <button type="button" onclick="submitForm($(this).parents().find('#reviewForm'))" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection