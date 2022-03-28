@extends('frontend.layouts.app')

@section('css')
    <style>
        .form-control {
            height: 50px;
            padding: 15px;
            font-size: 16px;
            /*border: none;*/
            border-radius: 5px;
            font-weight: 400;
        }

        #visa-form .form-control {
            border: 1px solid #eee;
        }

        #visa-form .btn {
            text-transform: uppercase;
            display: block;
            width: 100%;
            margin-top: 23px;
        }

        .agree {
            text-align: center;
        }

        .submit1 {
            width: 30%;
            margin: 0 auto;
        }

        .form-row, .form-group {

            margin-left: 0px !important;
        }

        .form-col, .form-group {
            position: relative;
            padding-left: 40px;!important;
        }

        form#visa-form {
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 30px 0 rgb(0 0 0 / 10%);
            max-width: 1000px;
            margin: 0 auto;
        }

        #visa-form .heading {
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            padding: 15px 0;
            background: #96cfda;
            font-weight: 600;
            font-size: 25px;
        }

        #visa-form .left {
            padding: 30px;
        }
        #medical_insurance_fee{
            display:none;
        }

        #other_service_fee{
            display:none;
        }
    </style>
@endsection

@if(!session()->has('visa_form'))
    @include('frontend.apply_visa_fetch_view.apply_visa_form1')
@else
    @include('frontend.apply_visa_fetch_view.apply_visa_form2')
@endif
