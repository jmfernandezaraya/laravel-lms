@extends('superadmin.layouts.app')

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
                    <h1 class="card-title">{{__('SuperAdmin/backend.update_school')}}</h1>
                    <change>
                        @if(app()->getLocale() == 'en')
                            {{__('SuperAdmin/backend.in_english')}}
                        @endif
                        @if(app()->getLocale() == 'ar')
                            {{__('SuperAdmin/backend.in_arabic')}}
                        @endif
                    </change>
                </div>

                @include('superadmin.include.alert')

                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a href="#" onclick="changeLanguage('english', 'arabic')">
                                <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}
                            </a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a href="#" onclick="changeLanguage('arabic', 'english')">
                                <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}
                            </a>
                        </li>
                    </ul>
                </div>

                <form id="form2store" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.school.update', $schools->id)}}" method="post">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{__('SuperAdmin/backend.school_name')}}</label>
                            <div class="english">
                                <input name="name" type="text" value="{{$schools->name}}" class="form-control" id="name" placeholder="{{__('SuperAdmin/backend.school_name')}}">
                            </div>
                            <div class="arabic">
                                <input name="name_ar" type="text" value="{{$schools->name_ar}}" class="form-control" id="name_ar" placeholder="{{__('SuperAdmin/backend.school_name')}}">
                            </div>
                            @if($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">{{__('SuperAdmin/backend.school_email_address')}}</label>
                            <input value="{{$schools->email}}" name="email" type="text" class="form-control" id="email" placeholder="{{__('SuperAdmin/backend.school_email_address')}}">
                            @if($errors->has('email'))
                                <div class="alert alert-danger">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="contact">{{__('SuperAdmin/backend.school_contact_number')}}</label>
                            <input value="{{$schools->contact}}" name="contact" class="form-control" id="contact" placeholder="{{__('SuperAdmin/backend.school_contact_number')}}" type="text">
                            @if($errors->has('contact'))
                                <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emergency_number">{{__('SuperAdmin/backend.school_emergency_number')}}</label>
                            <input name="emergency_number" type="text" class="form-control" id="emergency_number" value="{{$schools->emergency_number}}" placeholder="{{__('SuperAdmin/backend.school_emergency_number')}}">
                            @if($errors->has('emergency_number'))
                                <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="branch_name">{{__('SuperAdmin/backend.school_branch_name')}}</label>
                            <div class="english">
                                <input value="{{$schools->branch_name}}" name="branch_name" class="form-control" id="branch_name" placeholder="{{__('SuperAdmin/backend.branch_name')}}" type="text">
                            </div>
                            <div class="arabic">
                                <input value="{{$schools->branch_name_ar}}" name="branch_name_ar" class="form-control" id="branch_name_ar" placeholder="{{__('SuperAdmin/backend.branch_name')}}" type="text">
                            </div>
                            @if($errors->has('branch_name'))
                                <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="school_capacity">{{__('SuperAdmin/backend.school_capacity')}}</label>
                            <input name="school_capacity" type="text" class="form-control" id="school_capacity" value="{{$schools->school_capacity}}" placeholder="{{__('SuperAdmin/backend.school_capacity')}}">
                            @if($errors->has('school_capacity'))
                                <div class="alert alert-danger">{{$errors->first('school_capacity')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="facilities">{{__('SuperAdmin/backend.facilities')}}</label>
                            <div class="english">
                                <textarea name="facilities" class="form-control ckeditor-input" id="facilities_textarea" rows="4">{!! $schools->facilities !!}</textarea>
                            </div>
                            <div class="arabic">
                                <textarea name="facilities_ar" class="form-control ckeditor-input" id="facilities_ar_textarea" rows="4">{!! $schools->facilities_ar !!}</textarea>
                            </div>
                            @if($errors->has('facilities'))
                                <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="class_size">{{__('SuperAdmin/backend.class_size')}}</label>
                            <div class="english">
                                <input name="class_size" type="text" class="form-control" id="class_size" value="{{$schools->class_size}}" placeholder="{{__('SuperAdmin/backend.class_size')}}">
                            </div>
                            <div class="arabic">
                                <input name="class_size_ar" type="text" class="form-control" id="class_size_ar" value="{{$schools->class_size_ar}}" placeholder="{{__('SuperAdmin/backend.class_size')}}">
                            </div>
                            @if($errors->has('class_size'))
                                <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="year_opened">{{__('SuperAdmin/backend.year_opened')}}</label>
                            <input name="opened" type="text" class="form-control" value="{{$schools->opened}}" placeholder="{{__('SuperAdmin/backend.year_opened')}}">                                
                            @if($errors->has('opened'))
                                <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="about_the_school">{{__('SuperAdmin/backend.about_the_school')}}</label>
                            <div class="english">
                                <textarea name="about" class="form-control ckeditor-input" id="about_textarea" rows="4">{!! $schools->about !!}</textarea>
                            </div>
                            <div class="arabic">
                                <textarea name="about_ar" class="form-control ckeditor-input" id="about_ar_textarea" rows="4">{!! $schools->about_ar !!}</textarea>
                            </div>
                            @if($errors->has('about'))
                                <div class="alert alert-danger">{{$errors->first('about')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="address">{{__('SuperAdmin/backend.address')}}</label>
                            <input name="address" type="text" class="form-control" value="{{$schools->address}}" placeholder="{{__('SuperAdmin/backend.address_map_location')}}">
                            @if($errors->has('address'))
                                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="city">{{__('SuperAdmin/backend.city')}}</label>
                            <div class="english">
                                <input name="city" type="text" class="form-control" id="city" value="{{$schools->city}}" placeholder="{{__('SuperAdmin/backend.city')}}">
                            </div>
                            <div class="arabic">
                                <input name="city_ar" type="text" class="form-control" id="city_ar" value="{{$schools->city_ar}}" placeholder="{{__('SuperAdmin/backend.enter_city')}}">
                            </div>
                            @if($errors->has('city'))
                                <div class="alert alert-danger">{{$errors->first('city')}}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">{{__('SuperAdmin/backend.country')}}</label>
                            <div class="english">
                                <input name="country" type="text" class="form-control" value="{{$schools->country}}" placeholder="{{__('SuperAdmin/backend.country')}}">
                            </div>
                            <div class="arabic">
                                <input name="country_ar" type="text" class="form-control" id="country_ar" value="{{$schools->country_ar}}" placeholder="{{__('SuperAdmin/backend.enter_country')}}">
                            </div>
                            @if($errors->has('country'))
                                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="logos">{{__('SuperAdmin/backend.accreditations_logos')}}</label>
                            <input name="logos[]" multiple type="file" onchange="$('#logos_id').hide()" class="form-control" id="logos" accept="image/*">
                            @if(!empty($schools->logos))
                                @foreach($schools->logos as $logos)
                                    <img id="logos_id" height="200px" width="200px" src="{{$schools->getStorageImages('school_images', $logos)}}" class="img-fluid img-thumbnail" alt="...">
                                @endforeach
                            @endif
                            @if($errors->has('logos'))
                                <div class="alert alert-danger">{{$errors->first('logos')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="school_logo">{{__('SuperAdmin/backend.school_logo')}}</label>
                            <input name="logo" type="file" onchange="$('#logo_id').hide()" class="form-control" id="school_logo" accept="image/*">
                            @if(!is_null($schools->logo))
                                <img height="200px" id="logo_id" width="200px" src="{{$schools->logo}}" class="img-fluid img-thumbnail" alt="...">
                            @endif
                            @if($errors->has('logo'))
                                <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="school_video">{{__('SuperAdmin/backend.school_video')}}</label>
                            <ul id="videoUrl">
                                @foreach((array)$schools->school_video as $videos)
                                    <li>{{$videos}}</li>
                                @endforeach
                            </ul>
                            @if($errors->has('video_url'))
                                <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="school_photos">{{__('SuperAdmin/backend.school_photos')}}</label>
                            <input name="multiple_photos[]" multiple type="file" class="form-control" id="school_photos" accept="image/*">
                            @if($errors->has('multiple_photos'))
                                <div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
                            @endif
                        </div>
                    </div>

                    <button type="button" onclick="submitForm($(this).parents().find('#form2store'))" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection