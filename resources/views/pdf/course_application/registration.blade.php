<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{__('Frontend.regsitration_form')}}</title>
    
    @php $show_images = false; @endphp

    <style>
        @if (app()->getLocale() != 'en')
            * { font-family: 'DejaVu Sans', sans-serif; }
            body { direction: rtl; text-align: right; }
        @endif

        .registration-form {
            padding: 0 15px;
        }
        .course-details h3 {
            position: relative;
            font-size: 24px;
            font-weight: 700;
            text-align: left;
            padding-bottom: 5px;
            border-bottom: 1px solid #97d0db;
            margin: 0;
        }
        .study {
            box-shadow: 0px 0px 2px 1px #ccc;
            padding: 15px 15px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto,
        .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto,
        .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto,
        .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto,
        .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            position: relative;
            width: 100%;
        }
        @media (min-width: 768px) {
            .col-md-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%;
            }
            .col-md-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }            
            .col-md-9 {
                -ms-flex: 0 0 75%;
                flex: 0 0 75%;
                max-width: 75%;
            }
        }
        .align-items-center {
            -ms-flex-align: center!important;
            align-items: center!important;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .col-form-label {
            padding-top: calc(0.375rem + 1px);
            padding-bottom: calc(0.375rem + 1px);
            margin-bottom: 0;
            font-size: inherit;
            line-height: 1.5;
        }
        .registration-form .col-form-label {
            font-weight: bold;
        }
        .form-group label {
            color: #000;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin: 0;
            color: #212529;
            border-collapse: collapse;
            table-layout: fixed;
            overflow-wrap: break-word;
        }
        .table.table-shadow {
            border: 1px solid #dee2e6;
            box-shadow: 0px 0px 2px 1px #ccc;
        }
        .table tr, .table tr td {
            border: none;
            align-items: top;
            vertical-align: top;
        }
        .table tr td {
            padding: 5px 15px;
        }
        .table tr td label {
            padding: 0;
        }
        .table tr td p {
            margin: 0px;
        }
        .mt-1 {
            margin-top: 0.3rem!important;
        }
        .mt-2 {
            margin-top: 0.6rem!important;
        }
        .img-fulid {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="registration-form course-details">
        <table class="table">
            <tbody>
                <tr>
                    <th><h3>{{__('Frontend.personal_info')}}:</h3></th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-shadow mt-1">
            <tbody>
                <tr>
                    <td>
                        <label for="fname" class="col-form-label">{{__('Frontend.first_name')}}</label>
                        <p>{{ $course_application->fname }}</p>
                    </td>
                    <td>
                        <label for="mname" class="col-form-label">{{__('Frontend.middle_name')}}</label>
                        <p>{{ $course_application->mname }}</p>
                    </td>
                    <td>
                        <label for="lname" class="col-form-label">{{__('Frontend.last_name')}}</label>
                        <p>{{ $course_application->lname }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="city" class="col-form-label">{{__('Frontend.place_of_birth')}}</label>
                        <p>{{ $course_application->place_of_birth }}</p>
                    </td>
                    <td>
                        <label for="gender" class="col-form-label">{{__('Frontend.gender')}}</label>
                        <p>{{ $course_application->gender }}</p>
                    </td>
                    <td>
                        <label for="dob" class="col-form-label">{{__('Frontend.date_of_birth')}}</label>
                        <p>{{ $course_application->dob }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nat" class="col-form-label">{{__('Frontend.nationality')}}</label>
                        <p>{{ $course_application->nationality }}</p>
                    </td>
                    <td>
                        <label for="nat" class="col-form-label">{{__('Frontend.id_iqama_number')}}</label>
                        <p>{{ $course_application->id_number }}</p>
                    </td>
                    <td>
                        <label for="Passport" class="col-form-label">{{__('Frontend.passport_no')}}</label>
                        <p>{{ $course_application->passport_number }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="portdate" class="col-form-label">{{__('Frontend.passport_date_of_issue')}}</label>
                        <p>{{ $course_application->passport_date_of_issue }}</p>
                    </td>
                    <td>
                        <label for="edate" class="col-form-label">{{__('Frontend.passport_date_of_expiry')}}</label>
                        <p>{{ $course_application->passport_date_of_expiry }}</p>
                    </td>
                    @if ($show_images)
                        <td>
                            @if ($course_application->passport_copy)
                                <label for="fname" class="col-form-label">{{__('Frontend.upload_passport_copy')}}</label>
                                <img src="{{ url('storage/app/public') . $course_application->passport_copy }}" class="img-fulid" />
                            @endif
                        </td>
                    @endif
                </tr>
                <tr>
                    <td>
                        <label for="nat" class="col-form-label">{{__('Frontend.your_level_of_language')}}</label>
                        <p>
                            @if ($course_application->level_of_language == 'beginner_a1')
                                {{__('Frontend.beginner_a1')}}
                            @elseif ($course_application->level_of_language == 'elementary_a2')
                                {{__('Frontend.elementary_a2')}}
                            @elseif ($course_application->level_of_language == 'intermediate_b1')
                                {{__('Frontend.intermediate_b1')}}
                            @elseif ($course_application->level_of_language == 'upper_intermediate_b2')
                                {{__('Frontend.upper_intermediate_b2')}}
                            @elseif ($course_application->level_of_language == 'advanced_c1')
                                {{__('Frontend.advanced_c1')}}
                            @elseif ($course_application->level_of_language == 'proficient_c2')
                                {{__('Frontend.proficient_c2')}}
                            @endif
                        </p>
                    </td>
                    <td>
                        <label for="city" class="col-form-label">{{__('Frontend.study_finance')}}</label>
                        <p>
                            @if ($course_application->study_finance == 'personal')
                                {{__('Frontend.personal')}}
                            @elseif ($course_application->study_finance == 'scholarship')
                                {{__('Frontend.scholarship')}}
                            @endif
                        </p>
                    </td>
                    @if ($show_images)
                        <td>
                            @if ($course_application->financial_guarantee)
                                <label for="nat" class="col-form-label">{{__('Frontend.upload_financial_gurantee')}}</label>
                                <img src="{{ url('storage/app/public') . $course_application->financial_guarantee }}" class="img-fulid" />
                            @endif
                        </td>
                    @endif
                </tr>
                @if ($show_images)
                    <tr>
                        <td>
                            @if ($course_application->bank_statement)
                                <label for="nat" class="col-form-label">{{__('Frontend.upload_bank_statement')}}</label>
                                <img src="{{ url('storage/app/public') . $course_application->bank_statement }}" class="img-fulid" />
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table class="table mt-2">
            <tbody>
                <tr>
                    <th><h3>{{__('Frontend.contact_details')}}:</h3></th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-shadow mt-1">
            <tbody>
                <tr>
                    <td>
                        <label for="mobile" class="col-form-label">{{__('Frontend.mobile')}}</label>
                        <p>{{ $course_application->mobile }}</p>
                    </td>
                    <td>
                        <label for="Tel" class="col-form-label">{{__('Frontend.tel')}}</label>
                        <p>{{ $course_application->telephone }}</p>
                    </td>
                    <td>
                        <label for="Email" class="col-form-label">{{__('Frontend.email')}}</label>
                        <p>{{ $course_application->email }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="Address" class="col-form-label">{{__('Frontend.address')}}</label>
                        <p>{{ $course_application->address }}</p>
                    </td>
                    <td>
                        <label for="Post" class="col-form-label">{{__('Frontend.post_code')}}</label>
                        <p>{{ $course_application->post_code }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="city_contact" class="col-form-label">{{__('Frontend.city')}}</label>
                        <p>{{ $course_application->city_contact }}</p>
                    </td>
                    <td>
                        <label for="province_region" class="col-form-label">{{__('Frontend.province_region')}}</label>
                        <p>{{ $course_application->province_region }}</p>
                    </td>
                    <td>
                        <label for="country_contact" class="col-form-label">{{__('Frontend.country')}}</label>
                        <p>{{ $course_application->country_contact }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-2">
            <tbody>
                <tr>
                    <th><h3>{{__('Frontend.emergency_contact_details')}}:</h3></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-shadow mt-1">
            <tbody>
                <tr>
                    <td colspan="2">
                        <label for="full_name_emergency" class="col-form-label">{{__('Frontend.full_name')}}</label>
                        <p>{{ $course_application->full_name_emergency }}</p>
                    </td>
                    <td>
                        <label for="relative_emergency" class="col-form-label">{{__('Frontend.relative')}}</label>
                        <p>{{ $course_application->relative_emergency }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mobile_emergency" class="col-form-label">{{__('Frontend.mobile')}}</label>
                        <p>{{ $course_application->mobile_emergency }}</p>
                    </td>
                    <td>
                        <label for="telephone_emergency" class="col-form-label">{{__('Frontend.tel')}}</label>
                        <p>{{ $course_application->telephone_emergency }}</p>
                    </td>
                    <td>
                        <label for="email_emergency" class="col-form-label">{{__('Frontend.email')}}</label>
                        <p>{{ $course_application->email_emergency }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-2">
            <tbody>
                <tr>
                    <th><h3>{{ str_replace("###SITE_NAME", __('Frontend.how_you_heard_about_site_name'), __('Frontend.site_name')) }}:</h3></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-shadow mt-1">
            <tbody>
                <tr>
                    <td>
                        <p>{{ implode($course_application->heard_where, ", ") }}</p>
                        <p>{{ $course_application->other }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table mt-2">
            <tbody>
                <tr>
                    <th><h3>{{__('Frontend.comment')}}:</h3></th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        <table class="table table-shadow mt-1">
            <tbody>
                <tr>
                    <td>
                        <p>{{ $course_application->comments }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>