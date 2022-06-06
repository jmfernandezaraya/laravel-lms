@extends('superadmin.layouts.app')

@section('content')
    @php
        $schoolupdateurl = route('school.update', $school_ar->unique_id);
        if (env('APP_ENV') == 'local'):
            echo '<pre>';
            //print_r($school_en);
            echo '</pre>';
        endif;
    @endphp

    <div class="page-header">
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

                @include('superadmin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="form1" class="forms-sample" enctype="multipart/form-data" action="{{route('school.store')}}" method="post">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.name')}}</label>
                        <input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.name')}}" value="{{$school_en->name}}">
                    </div>
                    @if($errors->has('name'))
                        <div class="alert alert-danger">{{$errors->first('name')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.email_address')}}</label>
                        <input value="{{$school_en->email}}" name="email" type="text" class="form-control" id="exampleInputEmail3" placeholder="{{__('SuperAdmin/backend.email_address')}}">
                    </div>
                    @if($errors->has('email'))
                        <div class="alert alert-danger">{{$errors->first('email')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleSelectGender">{{__('SuperAdmin/backend.contact_number')}}</label>
                        <input value="{{$school_en->contact}}" name="contact" class="form-control" id="exampleSelectGender" placeholder="{{__('SuperAdmin/backend.contact_number')}}" type="text">
                    </div>
                    @if($errors->has('contact'))
                        <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.emergency_number')}}</label>
                        <input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.emergency_number')}}" value="{{$school_en->emergency_number}}">
                    </div>
                    @if($errors->has('emergency_number'))
                        <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.branch_name')}}</label>
                        <input name="branch_name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.branch_name')}}" value="{{$school_en->branch_name}}">
                    </div>
                    @if($errors->has('branch_name'))
                        <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.capacity')}}</label>
                        <input name="capacity" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.capacity')}}" value="{{$school_en->capacity}}">
                    </div>
                    @if($errors->has('capacity'))
                        <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.facilities')}}</label>
                        <textarea name="facilities" class="form-control" id="exampleTextarea1" rows="4">{{$school_en->facilities}}</textarea>
                    </div>
                    @if($errors->has('facilities'))
                        <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.class_size')}}</label>
                        <input name="class_size" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.class_size')}}" value="{{$school_en->class_size}}">
                    </div>
                    @if($errors->has('class_size'))
                        <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.year_opened')}}</label>
                        <input name="opened" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.year_opened')}}" value="{{$school_en->opened}}">
                    </div>
                    @if($errors->has('opened'))
                        <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.about_the_school')}}</label>
                        <textarea name="about" class="form-control" id="exampleTextarea1" rows="4">{{$school_en->about}}</textarea>
                    </div>
                    @if($errors->has('about'))
                        <div class="alert alert-danger">{{$errors->first('about')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.address')}}</label>
                        <input name="address" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.address_map_location')}}" value="{{$school_en->address}}">
                    </div>
                    @if($errors->has('address'))
                        <div class="alert alert-danger">{{$errors->first('address')}}</div>
                    @endif
				
                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.enter_city')}}</label>
                        <input name="city" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.enter_city')}}" value="{{$school_en->city}}">
                    </div>
                    @if($errors->has('city'))
                        <div class="alert alert-danger">{{$errors->first('city')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.enter_country')}}</label>
                        <input name="country" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.enter_country')}}" value="{{$school_en->country}}">
                    </div>
                    @if($errors->has('country'))
                        <div class="alert alert-danger">{{$errors->first('country')}}</div>
                    @endif

                    <input hidden name="en" value='1'>
                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.accreditations_logos')}}</label>
                        <input name="logos[]" multiple type="file" class="form-control" id="exampleInputName1" accept="image/*">
                    </div>
                    @if($errors->has('logos'))
                        <div class="alert alert-danger">{{$errors->first('logos')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.logo')}}</label>
                        <input name="logo" type="file" class="form-control" id="exampleInputName1" accept="image/*">
                    </div>
                    @if($errors->has('logo'))
                        <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.video')}}</label>
                        <ul id="myTags">
                            @foreach($school_en->video_url as $videourl)
                                <li>{{$videourl}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if($errors->has('video_url'))
                        <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.photos')}}</label>
                        <input name="multiple_photos[]" multiple type="file" class="form-control" id="exampleInputName1" accept="image/*">
                    </div>

                    @if($errors->has('multiple_photos'))
                        <div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
                    @endif

                    <button type="button" onclick="submitForm(addschoolupdate_url)" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </form>
			
                <form id="form2" class="forms-sample" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.name')}}</label>
                        <input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.name')}}" value="{{$school_ar->name}}">
                    </div>

                    @if($errors->has('name'))
                        <div class="alert alert-danger">{{$errors->first('name')}}</div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.email_address')}}</label>
                        <input value="{{$school_ar->email}}" name="email" type="text" class="form-control" id="exampleInputEmail3" placeholder="{{__('SuperAdmin/backend.email_address')}}">
                    </div>
                    @if($errors->has('email'))
                        <div class="alert alert-danger">{{$errors->first('email')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleSelectGender">{{__('SuperAdmin/backend.contact_number')}}</label>
                        <input value="{{$school_ar->contact}}" name="contact" class="form-control" id="exampleSelectGender" placeholder="{{__('SuperAdmin/backend.contact_number')}}" type="text">
                    </div>
                    @if($errors->has('contact'))
                        <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.emergency_number')}}</label>
                        <input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.emergency_number')}}" value="{{$school_ar->emergency_number}}">
                    </div>
                    @if($errors->has('emergency_number'))
                        <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.branch_name')}}</label>
                        <input name="branch_name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.branch_name')}}" value="{{$school_ar->branch_name}}">
                    </div>
                    @if($errors->has('branch_name'))
                        <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.capacity')}}</label>
                        <input name="capacity" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.capacity')}}" value="{{$school_ar->capacity}}">
                    </div>
                    @if($errors->has('capacity'))
                        <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.facilities')}}</label>
                        <textarea name="facilities" class="form-control" id="exampleTextarea1" rows="4">{{$school_ar->facilities}}</textarea>
                    </div>
                    @if($errors->has('facilities'))
                        <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.class_size')}}</label>
                        <input name="class_size" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.class_size')}}" value="{{$school_ar->class_size}}">
                    </div>
                    @if($errors->has('class_size'))
                        <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.year_opened')}}</label>
                        <input name="opened" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.year_opened')}}" value="{{$school_ar->opened}}">
                    </div>
                    @if($errors->has('opened'))
                        <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.about_the_school')}}</label>
                        <textarea name="about" class="form-control" id="exampleTextarea1" rows="4">{{$school_ar->about}}</textarea>
                    </div>
                    @if($errors->has('about'))
                        <div class="alert alert-danger">{{$errors->first('about')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.address')}}</label>
                        <input name="address" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.address_map_location')}}" value="{{$school_ar->address}}">
                    </div>
                    @if($errors->has('address'))
                        <div class="alert alert-danger">{{$errors->first('address')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.enter_city')}}</label>
                        <input name="city" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.enter_city')}}" value="{{$school_ar->city}}">
                    </div>
                    @if($errors->has('city'))
                        <div class="alert alert-danger">{{$errors->first('city')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.enter_country')}}</label>
                        <input name="country" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.enter_country')}}" value="{{$school_ar->country}}">
                    </div>
                    @if($errors->has('country'))
                        <div class="alert alert-danger">{{$errors->first('address')}}</div>
                    @endif

                    <input hidden name="ar" value='1'>

                    <button type="button" onclick="submitForm(addschoolupdate_url)" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection