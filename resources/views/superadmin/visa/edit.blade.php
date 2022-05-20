@extends('superadmin.layouts.app')

@section('css')
    <style>
        .form-control {
            height: 50px;
            padding: 15px;
            font-size: 16px;
            border-radius: 5px;
            font-weight: 400;
        }
        
        #visa-form .form-control {
            border: 1px solid #eee;
        }
        
        #visa-form .btn {
            display: block;
            width: 100%;
        }
        
        .agree {
            text-align: center;
        }
        
        .submit1 {
            width: 30%;
            margin: 0 auto;
        }
        
        .form-row,
        .form-group {
            margin-left: 0px !important;
        }
        
        form#visa-form {
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 30px 0 rgb(0 0 0 / 10%);
            max-width: 1000px;
            margin: 0 auto;
        }
        
        form#form_builder_visa {
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
        
        #form_builder_visa .heading {
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            padding: 15px 0;
            background: #96cfda;
            font-weight: 600;
            font-size: 25px;
        }
        
        #form_builder_visa .left {
            padding: 30px;
        }
        
        i.fa.fa-plus {
            background: #96cfda !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
            cursor: pointer;
        }
        
        i.fa.fa-trash {
            background: #96cfda !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<script>
    tinymceInit();
</script>
@include('superadmin.courses.modals')
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h1 align="center">Visa Form</h1>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<div class="container mt-5 mb-5">
    <form id="visa-form" method="post" enctype="multipart/form-data" action="{{route('superadmin.visa_form_update', $visaforms->id)}}">
        @csrf
        <div class="heading">visa form</div>
        <br>
        <br> @include('superadmin.include.alert')
        <div class="left">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputapply">I'm applying from <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ApplyFromModal" aria-hidden="true"></i> <i class="fa fa-trash pl-3" data-url="{{route(" superadmin.delete_applying_from ")}}" onclick="deleteApplyFrom($(this))" aria-hidden="true"></i></label>
                    <select name="applying_from" class="form-control" id="applying_from">
                        <option value="">@lang('SuperAdmin/backend.select_option')</option>
                        @foreach(\App\Models\SuperAdmin\ApplyFrom::all() as $applyform)
                            <option value="{{$applyform->id}}" {{$applyform->id == $visaforms->applyFrom->id ? 'selected' : ''}} >{{$applyform->{'apply_from_' . get_language() } }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputappliccation">Choose visa appliccation center
                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#application_center_modal" aria-hidden="true"></i>
                        <i class="fa fa-trash pl-3" data-url="{{route('superadmin.delete_application_center')}}" onclick="deleteApplicationCenter($(this))" aria-hidden="true"></i></label>
                    <br>

                    <select id="application_center" name="application_center" class="form-control">
                        <option value="">@lang('SuperAdmin/backend.select_option') </option>
                        @foreach (\App\Models\SuperAdmin\VisaApplicationCenter::all() as $visa)
                            <option {{$visa->id == $visaforms->applicationCenter->id ? 'selected' : ''}} value="{{$visa->id}}">{{$visa->{'application_center_' . get_language() } }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputvisa1">What is your Nationality
                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#nationality_modal" aria-hidden="true"></i>
                        <i class="fa fa-trash pl-3" onclick="deleteNationality($(this))" data-url="{{route('superadmin.delete_nationality')}}" aria-hidden="true"></i></label>
                    <select id="nationality_select" name="nationality" class="form-control">
                        <option value=''>@lang('SuperAdmin/backend.select_option') </option>
                        @foreach (\App\Models\SuperAdmin\addNationality::all() as $nationality)
                        <option {{$nationality->id == $visaforms->getNationality->id ? 'selected' : ''}} value='{{$nationality->id}}'>{{$nationality->{'nationality_' . get_language() } }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputtravel">where do you want to travel?
                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#to_travel_modal" aria-hidden="true"></i>
                        <i class="fa fa-trash pl-3" onclick="deleteTravel($(this))" data-url="{{route('superadmin.delete_travel')}}" aria-hidden="true"></i>
                    </label>
                    <select name="to_travel" class="form-control" id="to_travel">
                        <option value=''>@lang('SuperAdmin/backend.select_option') </option>
                        @foreach (\App\Models\SuperAdmin\AddWhereToTravel::all() as $travel)
                            <option {{$travel->id == $visaforms->whereToTravel->id ? 'selected' : ''}} value='{{$travel->id}}'>{{$travel->{'travel_' . get_language() } }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputvisa3">Type of visa
                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#type_of_visa_modal" aria-hidden="true"></i>
                        <i class="fa fa-trash pl-3" onclick="deleteTypeOfVisa($(this))" data-url="{{route('superadmin.delete_type_of_visa')}}" aria-hidden="true"></i></label>
                    <select name="type_of_visa" class="form-control" id="type_of_visa">
                        <option value=''>@lang('SuperAdmin/backend.select_option') </option>
                        @foreach (\App\Models\SuperAdmin\AddTypeOfVisa::all() as $travel)
                            <option {{$travel->id == $visaforms->TypeOfVisa->id ? 'selected' : ''}} value='{{$travel->id}}'>{{$travel->{'visa_'. get_language()} }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label for="inputvisa4">Visa information and requirement {{__('SuperAdmin/backend.in_english')}}</label>
                    <textarea name="visa_information_en" class="form-control ckeditor-input " id="requirement" rows="3">{!! $visaforms->visa_information_en !!}</textarea>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label for="inputvisa4">Visa information and requirement {{__('SuperAdmin/backend.in_arabic')}} </label>
                    <textarea name="visa_information_ar" class="form-control ckeditor-input" id="requirement_ar" rows="3">{!! $visaforms->visa_information_ar !!}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Visa Fee</label>
                    <input type="number" name="visa_fee" class="form-control" id="inputvisa5" value="{{$visaforms->visa_fee}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Insurance Fee</label>
                    <input type="number" name="insurance_fee" class="form-control" id="inputvisa6" value="{{$visaforms->insurance_fee}}">
                </div>
            </div>

            @foreach($visaforms->visaOtherFees as $visafees)
                <div class="clone_visa{{$loop->iteration - 1}}">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Other visa fee</label>
                            <input type="text" name="other_visa_name[]" class="form-control" id="inputvisa7" value="{{$visafees->other_visa_name}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Other visa price</label>
                            <input type="number" name="other_visa_price[]" class="form-control" id="inputvisa8" value="{{$visafees->other_visa_price}}">
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="form-row">
                <div class="form-group col-md-6">
                    <!--<button type="button" onclick="cloneAnotherVisa($(this))" class="btn btn-primary">add another visa fee</button>-->
                </div>
                <div class="form-group col-md-6">
                    <div class="pull-left">
                        <button type="button" onclick="RemoveAnotherVisa($(this))" class="btn btn-sm btn-danger fa fa-minus"></button>
                    </div>
                    <div class="pull-right">
                        <button type="button" onclick="cloneAnotherVisa($(this))" class="btn btn-sm btn-primary fa fa-plus"></button>
                    </div>
                </div>
            </div>

            @foreach($visaforms->visaServiceFees as $visaservicefee)
                <div class="clone_visa_service{{$loop->iteration - 1}}">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Visa Services fee</label>
                            <input type="number" name="visa_service_fee[]" class="form-control" id="inputVisa9" value="{{$visaservicefee->visa_service_fee}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Tax Fee</label>
                            <input type="number" name="tax_fee[]" class="form-control" id="inputVisa11" value="{{$visaservicefee->tax_fee}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Travelers Number Start</label>
                            <input type="number" name="travelers_number_start[]" class="form-control" id="inputVisa12" value="{{$visaservicefee->travelers_number_start}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Travelers Number End</label>
                            <input type="number" name="travelers_number_end[]" class="form-control" id="inputVisa13" value="{{$visaservicefee->travelers_number_end}}">
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="form-row">
                <div class="form-group col-md-6">
                    <!--<button type="button" onclick="CloneAnotherVisa_service($(this))" class="btn btn-primary">Add another visa services fee</button>-->
                </div>
                <div class="form-group col-md-6 mt-3">
                    <div class="pull-left">
                        <button type="button" onclick="RemoveAnotherVisa_service($(this))" class="btn btn-sm btn-danger fa fa-minus"></button>
                    </div>
                    <div class="pull-right">
                        <button type="button" onclick="CloneAnotherVisa_service($(this))" class="btn btn-sm btn-primary fa fa-plus"></button>
                    </div>

                </div>
                <div class="pull-right">
                    <button onclick="submitVisaApplication($(this))" type="button" class="btn btn-primary btn-sm">{{__('SuperAdmin/backend.submit')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection