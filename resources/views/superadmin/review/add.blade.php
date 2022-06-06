@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.add_rating_review')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.add_rating_review')}}</h1>
                </div>

                @include('superadmin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="reviewForm" class="forms-sample" method="post" action="{{route('superadmin.review.store')}}">
                    {{csrf_field()}}
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h3>{{__('SuperAdmin/backend.school_and_teaching')}}</h3>

                            <div class="form-group">
                                <label for="quality_of_teaching" class="col-form-label">{{__('SuperAdmin/backend.quality_of_teaching')}}</label>
                                <input type="hidden" name="quality_teaching" value="0" />
                                <div class="rating-input quality-teaching" data-name="quality_teaching" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="school_facilities" class="col-form-label">{{__('SuperAdmin/backend.school_facilities')}}</label>
                                <input type="hidden" name="school_facilities" value="0" />
                                <div class="rating-input school-facilities" data-name="school_facilities" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="social_activities" class="col-form-label">{{__('SuperAdmin/backend.social_activities')}}</label>
                                <input type="hidden" name="social_activities" value="0" />
                                <div class="rating-input social-activities" data-name="social_activities" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="school_location" class="col-form-label">{{__('SuperAdmin/backend.school_location')}}</label>
                                <input type="hidden" name="school_location" value="0" />
                                <div class="rating-input school-location" data-name="school_location" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="satisfied_teaching" class="col-form-label">{{__('SuperAdmin/backend.satisfied_teaching')}}</label>
                                <input type="hidden" name="satisfied_teaching" value="0" />
                                <div class="rating-input satisfied-teaching" data-name="satisfied_teaching" data-value="0"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h3>{{__('SuperAdmin/backend.accommodation')}}</h3>

                            <div class="form-group">
                                <label for="level_of_cleanliness" class="col-form-label">{{__('SuperAdmin/backend.level_of_cleanliness')}}</label>
                                <input type="hidden" name="level_cleanliness" value="{{ $review ? $review->level_cleanliness : 0 }}" />
                                <div class="rating-input level-of-cleanliness" data-name="level_cleanliness" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="distance_accommodation_school" class="col-form-label">{{__('SuperAdmin/backend.distance_accommodation_school')}}</label>
                                <input type="hidden" name="distance_accommodation_school" value="0" />
                                <div class="rating-input distance-accommodation-school" data-name="distance_accommodation_school" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="satisfied_accommodation" class="col-form-label">{{__('SuperAdmin/backend.satisfied_accommodation')}}</label>
                                <input type="hidden" name="satisfied_accommodation" value="0" />
                                <div class="rating-input satisfied-accommodation" data-name="satisfied_accommodation" data-value="0"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h3>{{__('SuperAdmin/backend.others')}}</h3>
                            
                            <div class="form-group">
                                <label for="airport_transfer" class="col-form-label">{{__('SuperAdmin/backend.airport_transfer')}}</label>
                                <input type="hidden" name="airport_transfer" value="0" />
                                <div class="rating-input airport-transfer" data-name="airport_transfer" data-value="0"></div>
                            </div>
                            <div class="form-group">
                                <label for="city_activities" class="col-form-label">{{__('SuperAdmin/backend.city_activities')}}</label>
                                <input type="hidden" name="city_activities" value="0" />
                                <div class="rating-input city-activities" data-name="city_activities" data-value="0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="would_you_recommend_this_school" class="">{{__('SuperAdmin/backend.would_you_recommend_this_school')}}</label>
                                <input type="radio" value="1" name="recommend_this_school" checked>
                                <label for="recommend_this_school_yes">
                                    {{__('SuperAdmin/backend.yes')}}
                                </label>
                                <input type="radio" value="0" name="recommend_this_school">
                                <label for="recommend_this_school_no">
                                    {{__('SuperAdmin/backend.no')}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="write_a_review" class="col-form-label">{{__('SuperAdmin/backend.write_a_review')}}</label>
                                <textarea name="review" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="use_my_full_name_for_the_rating_and_review" class="">{{__('SuperAdmin/backend.use_my_full_name_for_the_rating_and_review')}}</label>
                                <input type="radio" value="1" name="use_full_name" checked>
                                <label for="use_full_name_yes">
                                    {{__('SuperAdmin/backend.yes')}}
                                </label>
                                <input type="radio" value="0" name="use_full_name">
                                <label for="use_full_name_no">
                                    {{__('SuperAdmin/backend.no')}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{ url()->previous() }}">{{__('SuperAdmin/backend.cancel')}}</a>
                    <button type="button" onclick="submitForm($(this).parents().find('#reviewForm'))" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection