@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_coupon')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_coupon')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>
                
                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="formaction" class="forms-sample" method="post" action="{{route('superadmin.coupon.store')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('Admin/backend.coupon_name')}} <span class="text-danger">*</span></label>
                            <input name="name" type="text" class="form-control" placeholder="{{__('Admin/backend.coupon_name')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="code">{{__('Admin/backend.discount_code')}} <span class="text-danger">*</span></label>
                            <input name="code" type="text" class="form-control" placeholder="{{__('Admin/backend.discount_code')}}">
                            <small class="form-text text-muted">{{__('Admin/backend.discount_code_description')}}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="discount">{{__('Admin/backend.discount_value')}} <span class="text-danger">*</span></label>
                            <input name="discount" type="text" class="form-control" placeholder="{{__('Admin/backend.discount_value')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">{{__('Admin/backend.discount_type')}} <span class="text-danger">*</span></label>
                            <select class="form-control" name="type">
                                <option value="percent" selected>{{__('Admin/backend.percentage')}}</option>
                                <option value="fixed">{{__('Admin/backend.fixed_amount')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="number_of_weeks">{{__('Admin/backend.usage_rules')}} <span class="text-danger">*</span></label>
                            <input name="number_of_weeks" type="number" class="form-control" placeholder="{{__('Admin/backend.number_of_weeks')}}">
                            <small class="form-text text-muted">{{__('Admin/backend.usage_rules_description')}}</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label><h4>{{__('Admin/backend.activate_dates')}}</h4></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="start_date">{{__('Admin/backend.start_date')}}</label>
                            <input name="start_date" type="date" class="form-control" placeholder="{{__('Admin/backend.start_date')}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">{{__('Admin/backend.end_date')}}</label>
                            <input name="end_date" type="date" class="form-control" placeholder="{{__('Admin/backend.end_date')}}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="affiliate">{{__('Admin/backend.affiliate')}}</label>
                            <select class="form-control" name="affiliate_id">
                                <option value="">{{__('Admin/backend.none_option')}}</option>
                                @foreach($affiliates as $affiliate)
                                    <option value="{{ $affiliate->id }}">{{ $affiliate->{'first_name_' . get_language()} }}&nbsp;{{ $affiliate->{'last_name_' . get_language()} }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="affiliate"><h4>{{__('Admin/backend.applies_to')}}</h4></label>
                            </div>
                            <div class="form-group">
                                <input type="radio" value="1" name="applies_to">
                                <label for="all_schools_courses">
                                    {{__('Admin/backend.all_schools_courses')}}
                                </label>
                            </div>
                            <div class="form-group">
                                <input type="radio" value="0" name="applies_to" checked>
                                <label for="specific_schools_courses">
                                    {{__('Admin/backend.specific_schools_courses')}}
                                </label>
                            </div>

                            <input value="" name="course_unique_ids" type="hidden">

                            <div class="card">
                                <div class="card-body table table-responsive courses-table">
                                    <table class="table table-hover table-bordered table-filtered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-filter="checkbox">{{__('Admin/backend.select')}}</th>

                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["languages"])}}">{{__('Admin/backend.language')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["program_types"])}}">{{__('Admin/backend.program_type')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["study_modes"])}}">{{__('Admin/backend.study_mode')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["school_names"])}}">{{__('Admin/backend.school_name')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["school_cities"])}}">{{__('Admin/backend.city')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["school_countries"])}}">{{__('Admin/backend.country')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["branch_names"])}}">{{__('Admin/backend.branch_name')}}</th>
                                                <th data-filter="select" data-select="{{implode(",", $choose_fields["currencies"])}}">{{__('Admin/backend.currency')}}</th>

                                                <th>{{__('Admin/backend.program_name')}}</th>
                                                <th>{{__('Admin/backend.program_level')}}</th>
                                                <th>{{__('Admin/backend.lessons_per_week')}}</th>
                                                <th>{{__('Admin/backend.hours_per_week')}}</th>
                                                <th>{{__('Admin/backend.study_time')}}</th>
                                                <th>{{__('Admin/backend.start_dates')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($courses as $course)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><input type="checkbox" data-id="{{$course->unique_id}}" /></td>
                                                    <td>{{ implode(", ", getCourseLanguageNames($course->language)) }}</td>
                                                    <td>{{ implode(", ", getCourseProgramTypeNames($course->program_type)) }}</td>
                                                    <td>{{ implode(", ", getCourseStudyModeNames($course->study_mode)) }}</td>
                                                    <td>{{ $course->school && $course->school->name ? (get_language() == 'en' ? $course->school->name->name : $course->school->name->name_ar) : '-' }}</td>
                                                    <td>{{ $course->school && $course->school->city ? (get_language() == 'en' ? $course->school->city->name : $course->school->city->name_ar) : '-' }}</td>
                                                    <td>{{ $course->school && $course->school->country ? (get_language() == 'en' ? $course->school->country->name : $course->school->country->name_ar) : '-' }}</td>
                                                    <td>{{ $course->branch }}</td>
                                                    <td>{{ is_null($course->getCurrency) ? '-' : (app()->getLocale() == 'en' ? $course->getCurrency->name : $course->getCurrency->name_ar) }}</td>
                                                    <td>{{ app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar }}</td>
                                                    <td>{{ $course->program_level }}</td>
                                                    <td>{{ $course->lessons_per_week }}</td>
                                                    <td>{{ $course->hours_per_week }}</td>
                                                    <td>{{ implode(", ", getCourseStudyTimeNames($course->study_time)) }}</td>
                                                    <td>{{ implode(", ", getCourseStartDateNames($course->start_date)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{route('superadmin.coupon.index')}}">{{__('Admin/backend.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        var course_ids = {!! json_encode($coupon->course_unique_ids ?? []) !!};
        $(".courses-table tr td input[type='checkbox']").click(function() {
            var course_unique_id = '' + $(this).data("id");
            var course_id_index = course_ids.indexOf(course_unique_id);
            if ($(this).is(':checked')) {
                if (course_id_index == -1) course_ids.push(course_unique_id);
            } else {
                if (course_id_index != -1) course_ids.splice(course_id_index, 1);
            }
            $("input[name='course_unique_ids']").val(course_ids.join(","));
        });
        $("input[name='applies_to']").change(function() {
            if ($(this).val()) {
                $(".courses-table tr td input[type='checkbox']").each(function() {
                    if (!$(this).is(':checked')) {
                        $(this).prop('checked', true);
                    }
                });
            }
            $(".courses-table tr td input[type='checkbox']").each(function() {
                var course_unique_id = '' + $(this).data("id");
                var course_id_index = course_ids.indexOf(course_unique_id);
                if ($(this).is(':checked')) {
                    if (course_id_index == -1) course_ids.push(course_unique_id);
                } else {
                    if (course_id_index != -1) course_ids.splice(course_id_index, 1);
                }
            });
            $("input[name='course_unique_ids']").val(course_ids.join(","));
        });
    </script>
@endsection