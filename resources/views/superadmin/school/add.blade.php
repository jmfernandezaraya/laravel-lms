@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.add_school')}}
@endsection

@section('content')
    @section('js')
        <script src="{{asset('assets/js/tag/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>
        <script src="{{asset('assets/js/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('#menu ul li a').click(function (ev) {
                    $('#menu ul li').removeClass('selected');
                    $(ev.currentTarget).parent('li').addClass('selected');
                });
                $("#videoUrl").tagit({
                    fieldName: "video_url[]"
                });
            });
            var addschoolurl = "{{route('superadmin.school.store')}}";
            var in_arabic = "{{__('SuperAdmin/backend.in_arabic')}}";
            var in_english = "{{__('SuperAdmin/backend.in_english')}}";
        </script>
    @endsection

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.add_school')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                @include('superadmin.include.alert')

                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                <form id="schoolForm" enctype="multipart/form-data" action="{{route('superadmin.school.store')}}" method="post">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('SuperAdmin/backend.name')}}</label>
                            <div class="english">
                                <input name="name" type="text" class="form-control" id="name" placeholder="{{__('SuperAdmin/backend.name')}}">
                            </div>
                            <div class="arabic">
                                <input name="name_ar" type="text" class="form-control" id="name_ar" placeholder="{{__('SuperAdmin/backend.name')}}">
                            </div>
                            @if ($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">{{__('SuperAdmin/backend.email_address')}}</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="{{__('SuperAdmin/backend.email_address')}}">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact">{{__('SuperAdmin/backend.contact_number')}}</label>
                            <input name="contact" class="form-control" id="contact" placeholder="{{__('SuperAdmin/backend.contact_number')}}" type="text">
                            @if ($errors->has('contact'))
                                <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emergency_number">{{__('SuperAdmin/backend.emergency_number')}}</label>
                            <input name="emergency_number" type="text" class="form-control" id="emergency_number" placeholder="{{__('SuperAdmin/backend.emergency_number')}}">
                            @if ($errors->has('emergency_number'))
                                <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="branch_name">{{__('SuperAdmin/backend.branch_name')}}</label>
                            <div class="english">
                                <input name="branch_name" class="form-control" id="branch_name" placeholder="{{__('SuperAdmin/backend.branch_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input name="branch_name_ar" class="form-control" id="branch_name_ar" placeholder="{{__('SuperAdmin/backend.branch_name')}}" type="text">
                            </div>
                            @if ($errors->has('branch_name'))
                                <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="capacity">{{__('SuperAdmin/backend.capacity')}}</label>
                            <input name="capacity" type="text" class="form-control" id="capacity" placeholder="{{__('SuperAdmin/backend.capacity')}}">
                            @if ($errors->has('capacity'))
                                <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="facilities">{{__('SuperAdmin/backend.facilities')}}</label>
                            <div class="english">
                                <textarea name="facilities" class="form-control ckeditor-input" id="facilities_textarea" rows="4"></textarea>
                            </div>
                            <div class="arabic">
                                <textarea name="facilities_ar" class="form-control ckeditor-input" id="facilities_ar_textarea" rows="4"></textarea>
                            </div>
                            @if ($errors->has('facilities'))
                                <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="class_size">{{__('SuperAdmin/backend.class_size')}}</label>
                            <div class="english">
                                <input name="class_size" type="text" class="form-control" id="class_size" placeholder="{{__('SuperAdmin/backend.class_size')}}">
                            </div>
                            <div class="arabic">
                                <input name="class_size_ar" type="text" class="form-control" id="class_size_ar" placeholder="{{__('SuperAdmin/backend.class_size')}}">
                            </div>
                            @if ($errors->has('class_size'))
                                <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="year_opened">{{__('SuperAdmin/backend.year_opened')}}</label>
                            <input name="opened" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.year_opened')}}">                                
                            @if ($errors->has('opened'))
                                <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="opening_hours">{{__('SuperAdmin/backend.opening_hours')}}</label>
                            <input name="opening_hours" type="text" class="form-control" id="opening_hours" placeholder="{{__('SuperAdmin/backend.opening_hours')}}">
                            @if ($errors->has('opening_hours'))
                                <div class="alert alert-danger">{{$errors->first('opening_hours')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="number_of_classrooms">{{__('SuperAdmin/backend.number_of_classrooms')}}</label>
                            <input name="number_of_classrooms" type="text" class="form-control" id="number_of_classrooms" placeholder="{{__('SuperAdmin/backend.number_of_classrooms')}}">
                            @if ($errors->has('number_of_classrooms'))
                                <div class="alert alert-danger">{{$errors->first('number_of_classrooms')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="about_the_school">{{__('SuperAdmin/backend.about_the_school')}}</label>
                            <div class="english">
                                <textarea name="about" class="form-control ckeditor-input" id="about_textarea" rows="4"></textarea>
                            </div>
                            <div class="arabic">
                                <textarea name="about_ar" class="form-control ckeditor-input" id="about_ar_textarea" rows="4"></textarea>
                            </div>
                            @if ($errors->has('about'))
                                <div class="alert alert-danger">{{$errors->first('about')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="address">{{__('SuperAdmin/backend.address')}}</label>
                            <input name="address" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.address_map_location')}}">
                            @if ($errors->has('address'))
                                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="city">{{__('SuperAdmin/backend.city')}}</label>
                            <div class="english">
                                <input name="city" type="text" class="form-control" id="city" placeholder="{{__('SuperAdmin/backend.city')}}">
                            </div>
                            <div class="arabic">
                                <input name="city_ar" type="text" class="form-control" id="city_ar" placeholder="{{__('SuperAdmin/backend.enter_city')}}">
                            </div>
                            @if ($errors->has('city'))
                                <div class="alert alert-danger">{{$errors->first('city')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">{{__('SuperAdmin/backend.country')}}</label>
                            <div class="english">
                                <input name="country" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.country')}}">
                            </div>
                            <div class="arabic">
                                <input name="country_ar" type="text" class="form-control" id="country_ar" placeholder="{{__('SuperAdmin/backend.enter_country')}}">
                            </div>
                            @if ($errors->has('country'))
                                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="logos">{{__('SuperAdmin/backend.accreditations_logos')}}</label>
                            <input name="logos[]" multiple type="file" onchange="$('#logos_id').hide()" class="form-control" id="logos" accept="image/*">
                            @if ($errors->has('logos'))
                                <div class="alert alert-danger">{{$errors->first('logos')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="logo">{{__('SuperAdmin/backend.logo')}}</label>
                            <input name="logo" type="file" onchange="$('#logo_id').hide()" class="form-control" id="logo" accept="image/*">
                            @if ($errors->has('logo'))
                                <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="video">{{__('SuperAdmin/backend.video')}}</label>
                            <ul id="videoUrl"></ul>
                            @if ($errors->has('video_url'))
                                <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="photos">{{__('SuperAdmin/backend.photos')}}</label>
                            <input name="multiple_photos[]" multiple type="file" class="form-control" id="photos" accept="image/*">
                            @if ($errors->has('multiple_photos'))
                                <div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
                            @endif
                        </div>
                    </div>

                    <button type="button" onclick="submitForm($(this).parents().find('#schoolForm'))" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection