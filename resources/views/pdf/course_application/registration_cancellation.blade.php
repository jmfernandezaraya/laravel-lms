<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{__('Frontend.regsitration_form')}}</title>

    @if (app()->getLocale() != 'en')
        <style> 
            * { font-family: 'DejaVu Sans', sans-serif; }
        </style>
    @endif
    <style>
        .study {
            box-shadow: 0px 0px 2px 1px #ccc;
            padding: 15px 15px;
        }
        .m-2 {
            margin: 0.5rem!important;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }
        .h2, h2 {
            font-size: 2rem;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
        img {
            vertical-align: middle;
            border-style: none;
        }
        .table {
            width: 100%;
            max-width: 100%;
            color: #212529;
            border-collapse: collapse;
            table-layout: fixed;
            overflow-wrap: break-word;
            margin-bottom: 1rem;
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
    </style>
</head>

<body>
    <div class="registration-cancellation-conditions course-details">
        <div class="study m-2">
            <table class="table">
                <tbody>
                    <tr>
                        <th><img src="{{asset('public/frontend/assets/img/logo.png')}}" class="img-fluid" alt="" /></th>
                        <th colspan="4"><h2>{{__('Frontend.registration_cancelation_conditions')}}</h2></th>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr>
                        <td><p>{{__('Frontend.registration_cancelation_conditions_description')}}</p></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="student_guardian_full_name" class="col-form-label"><strong>{{__('Frontend.student_guardian_full_name')}}</strong>:</label>
                            <p>{{ $course_booked_detail->guardian_full_name }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>{{__('Frontend.date')}}:</strong></td>
                        <td colspan="3">{{ $today }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>{{__('Frontend.signature')}}:</strong></td>
                        <td colspan="3"><img src="{{ $course_booked_detail->signature }}" class="img-fluid"/></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>