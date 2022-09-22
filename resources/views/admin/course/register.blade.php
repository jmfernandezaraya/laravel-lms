@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.edit_registration')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.edit_registration')}}</h1>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="course-details border-bottom">
                    <form id="course_form_register" enctype="multipart/form-data" action="{{ auth('superadmin')->check() ? route('superadmin.course_application.register.update') : route('schooladmin.course_application.register.update') }}" method="POST">
                        {{csrf_field()}}

                        <input hidden id="get_country" value="{{ $course_country }}" />

                        <input type="hidden" value="{{ $course_application->id }}" required name="id">

                        <h3>{{__('Admin/backend.personal_info')}}:</h3>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname" class="col-form-label">{{__('Admin/backend.first_name')}}*</label>
                                        <input type="text" value="{{ $course_application->fname }}" required class="form-control" id="fname" name="fname" placeholder="{{__('Admin/backend.first_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mname" class="col-form-label">{{__('Admin/backend.middle_name')}}</label>
                                        <input type="mname" value="{{ $course_application->mname }}" name="mname" class="form-control" id="mname" placeholder="{{__('Admin/backend.middle_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lname" class="col-form-label">{{__('Admin/backend.last_name')}}*</label>
                                        <input type="text" value="{{ $course_application->lname }}" required class="form-control" id="lname" name="lname" placeholder="{{__('Admin/backend.last_name')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">{{__('Admin/backend.place_of_birth')}}*</label>
                                        <input type="text" value="{{ $course_application->place_of_birth }}" required class="form-control" name="place_of_birth" id="place_of_birth" placeholder="{{__('Admin/backend.city_country')}}*">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender" class="col-form-label">{{__('Admin/backend.gender')}}*</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="">{{__('Admin/backend.please_select')}}</option>
                                            <option value="male" {{ $course_application->gender == 'male' ? 'selected' : '' }}>{{__('Admin/backend.male')}}</option>
                                            <option value="female" {{ $course_application->gender == 'female' ? 'selected' : '' }}>{{__('Admin/backend.female')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dob" class="col-form-label">{{__('Admin/backend.date_of_birth')}}*</label>
                                        <input class="form-control" value="{{ $course_application->dob }}" required type="date" name="dob">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nationality" class="col-form-label">{{__('Admin/backend.nationality')}}*</label>
                                        <select required name="nationality" class="form-control" id="nationality">
                                            @foreach (getNationalityList() as $nationality)
                                                <option value="{{ $nationality }}" {{ $course_application->nationality == $nationality ? 'selected' : '' }}>{{ $nationality }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_number" class="col-form-label">{{__('Admin/backend.id_iqama_number')}}*</label>
                                        <input type="text" value="{{ $course_application->id_number }}" name="id_number" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Passport" class="col-form-label">{{__('Admin/backend.passport_no')}}*</label>
                                        <input value="{{ $course_application->passport_number }}" required type="text" name="passport_number" class="form-control" placeholder="{{__('Admin/backend.passport_no')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="portdate" class="col-form-label">{{__('Admin/backend.passport_date_of_issue')}}*</label>
                                        <input value="{{ $course_application->passport_date_of_issue }}" required class="form-control" type="date" name="passport_date_of_issue">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edate" class="col-form-label">{{__('Admin/backend.passport_date_of_expiry')}}*</label>
                                        <input value="{{ $course_application->passport_date_of_expiry }}" required class="form-control" type="date" name="passport_date_of_expiry">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fname" class="col-form-label">{{__('Admin/backend.upload_passport_copy')}}*</label>
                                        <input type="file" name="passport_copy" class="form-control">
                                        @if ($course_application->passport_copy)
                                            <img src="{{ '/storage/app/public' . $course_application->passport_copy }}" class="img-fluid" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="level_of_language" class="col-form-label">{{__('Admin/backend.your_level_of_language')}}</label>
                                        <select name="level_of_language" class="form-control" id="level_of_language">
                                            <option value="">{{__('Admin/backend.please_select')}}</option>
                                            <option value="beginner_a1" {{ $course_application->level_of_language == 'beginner_a1' ? 'selected' : '' }}>{{__('Admin/backend.beginner_a1')}}</option>
                                            <option value="elementary_a2" {{ $course_application->level_of_language == 'elementary_a2' ? 'selected' : '' }}>{{__('Admin/backend.elementary_a2')}}</option>
                                            <option value="intermediate_b1" {{ $course_application->level_of_language == 'intermediate_b1' ? 'selected' : '' }}>{{__('Admin/backend.intermediate_b1')}}</option>
                                            <option value="upper_intermediate_b2" {{ $course_application->level_of_language == 'upper_intermediate_b2' ? 'selected' : '' }}>{{__('Admin/backend.upper_intermediate_b2')}}</option>
                                            <option value="advanced_c1" {{ $course_application->level_of_language == 'advanced_c1' ? 'selected' : '' }}>{{__('Admin/backend.advanced_c1')}}</option>
                                            <option value="proficient_c2" {{ $course_application->level_of_language == 'proficient_c2' ? 'selected' : '' }}>{{__('Admin/backend.proficient_c2')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="col-form-label">{{__('Admin/backend.study_finance')}}*</label>
                                        <select name="study_finance" class="form-control" id="study_finance" onchange="checkFinancialGurantee()">
                                            <option value="">{{__('Admin/backend.please_select')}}</option>
                                            <option value="personal" {{ $course_application->study_finance == 'personal' ? 'selected' : '' }}>{{__('Admin/backend.personal')}}</option>
                                            <option value="scholarship" {{ $course_application->study_finance == 'scholarship' ? 'selected' : '' }}>{{__('Admin/backend.scholarship')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="financial_guarantee">
                                    <div class="form-group">
                                        <label for="financial_guarantee" class="col-form-label">{{__('Admin/backend.upload_financial_gurantee')}}</label>
                                        <input type="file" name="financial_guarantee" class="form-control">
                                        @if ($course_application->financial_guarantee)
                                            <img src="{{ '/storage/app/public' . $course_application->financial_guarantee }}" class="img-fluid" />
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4" id="bank_statement">
                                    <div class="form-group">
                                        <label for="bank_statement" class="col-form-label">{{__('Admin/backend.upload_bank_statement')}}</label>
                                        <input type="file" name="bank_statement" class="form-control">
                                        @if ($course_application->bank_statement)
                                            <img src="{{ '/storage/app/public' . $course_application->bank_statement }}" class="img-fluid" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="best">{{__('Admin/backend.contact_details')}}:</h3>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile" class="col-form-label">{{__('Admin/backend.mobile')}}*</label>
                                        <input value="{{ $course_application->mobile }}" type="mobile" name="mobile" class="form-control" id="mobile" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tel" class="col-form-label">{{__('Admin/backend.tel')}}</label>
                                        <input value="{{ $course_application->telephone }}" type="tel" name="telephone" class="form-control" id="telephone" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Email" class="col-form-label">{{__('Admin/backend.email')}}*</label>
                                        <input value="{{ $course_application->email }}" type="email" name="email" class="form-control" id="email" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="Address" class="col-form-label">{{__('Admin/backend.address')}}*</label>
                                        <input value="{{ $course_application->address }}" type="text" name="address" class="form-control" id="address" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Post" class="col-form-label">{{__('Admin/backend.post_code')}}*</label>
                                        <input value="{{ $course_application->post_code }}" type="text" name="post_code" class="form-control" id="post_code" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city_contact" class="col-form-label">{{__('Admin/backend.city')}}*</label>
                                        <input value="{{ $course_application->city_contact }}" type="text" name="city_contact" class="form-control" id="city_contact" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="province_region" class="col-form-label">{{__('Admin/backend.province_region')}}</label>
                                        <input value="{{ $course_application->province_region }}" type="text" name="province_region" class="form-control" id="province_region" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country_contact" class="col-form-label">{{__('Admin/backend.country')}}*</label>
                                        <input value="{{ $course_application->country_contact }}" type="text" name="country_contact" class="form-control" id="country_contact" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="best">{{__('Admin/backend.emergency_contact_details')}}:</h3>
                        <div class="study m-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="full_name_emergency" class="col-form-label">{{__('Admin/backend.full_name')}}*</label>
                                        <input value="{{ $course_application->full_name_emergency }}" type="text" name="full_name_emergency" class="form-control" id="full_name_emergency" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="relative_emergency" class="col-form-label">{{__('Admin/backend.relative')}}*</label>
                                        <input value="{{ $course_application->relative_emergency }}" type="text" name="relative_emergency" class="form-control" id="relative_emergency" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_emergency" class="col-form-label">{{__('Admin/backend.mobile')}}*</label>
                                        <input value="{{ $course_application->mobile_emergency }}" type="mobile" name="mobile_emergency" class="form-control" id="mobile_emergency" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telephone_emergency" class="col-form-label">{{__('Admin/backend.tel')}}</label>
                                        <input value="{{ $course_application->telephone_emergency }}" type="tel" name="telephone_emergency" class="form-control" id="telephone_emergency" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email_emergency" class="col-form-label">{{__('Admin/backend.email')}}*</label>
                                        <input value="{{ $course_application->email_emergency }}" type="email" name="email_emergency" class="form-control" id="email_emergency" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="best">{{str_replace("###SITE_NAME", __('Admin/backend.how_you_heard_about_site_name'), __('Admin/backend.site_name'))}}</h3>
                        <div class="study m-2">
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_google" value="Google" {{ in_array('Google', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_google">{{__('Admin/backend.google')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_twitter" value="Twitter" {{ in_array('Twitter', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_twitter">{{__('Admin/backend.twitter')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_instagram" value="Instagram" {{ in_array('Instagram', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_instagram">{{__('Admin/backend.instagram')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_snapchat" value="Snapchat" {{ in_array('Snapchat', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_snapchat">{{__('Admin/backend.snapchat')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_tiktok" value="Tiktok" {{ in_array('Tiktok', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_tiktok">{{__('Admin/backend.tiktok')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_youtube" value="YouTube" {{ in_array('YouTube', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_youtube">{{__('Admin/backend.youtube')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="heard_where[]" class="form-check-input" type="checkbox" id="heard_where_friend" value="Friend" {{ in_array('Friend', $course_application->heard_where) ? 'checked' : '' }}>
                                <label class="form-check-label" for="heard_where_friend">{{__('Admin/backend.friend')}}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="other">{{__('Admin/backend.other')}}</label>
                                <input value="{{ $course_application->other }}" name="other" type="text" class="form-control ml-3" id="other" placeholder="">
                            </div>
                        </div>

                        <h3 class="best">{{__('Admin/backend.comment')}}</h3>
                        <div class="study m-2">
                            <textarea name="comments" class="form-control" id="comment" rows="3">{!! $course_application->comments !!}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary px-5 py-3" onclick="doRegister($(this))">{{__('Admin/backend.update')}}</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary px-5 py-3 pull-right" onclick="backCourseDetail($(this))">{{__('Admin/backend.cancel')}}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    function backCourseDetail(object) {
                        @if (auth('superadmin')->check())
                            window.location.href = "{{ route('superadmin.course_application.edit', $course_application->id) }}";
                        @elseif (auth('schooladmin')->check())
                            window.location.href = "{{ route('schooladmin.course_application.edit', $course_application->id) }}";
                        @endif
                    }
                </script>
            </div>
        </div>
    </div>
@endsection