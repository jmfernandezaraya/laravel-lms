@extends('branchadmin.layouts.app')

@section('content')
    @section('css')
        <style>
            #form2 {
                display: none;
            }

            #menu ul li.selected {
                background: #daf2f7;
                color: #000 !important;
                padding: 10px 10px;
                font-weight: 600;
            }

            #menu a:hover {
                text-decoration: underline;
                background: #daf2f7;
                color: #FFFFFF;
                padding: 10px 10px;
            }

            #menu a:active {
                background: #daf2f7;
                color: black;
                padding: 10px 10px;
            }

            ul.lang li a {
                font-weight: 600;
            }
        </style>
    @endsection

    @section('js')
        @php $schoolupdateurl = route('superadmin.school.update', $school_ar->unique_id); @endphp
        <script>
            $(document).ready(function () {
                $('#menu ul li a').click(function (ev) {
                    $('#menu ul li').removeClass('selected');
                    $(ev.currentTarget).parent('li').addClass('selected');
                });
                $("#myTags").tagit({
                    fieldName: "video_url[]"
                });
                $("#myTags1").tagit({
                    fieldName: "branch_name[]"
                });
                $("#myTags2").tagit({
                    fieldName: "branch_name[]"
                });
            });
            var addschoolurl = "{{route('school.store')}}";
            var addschoolupdate_url = "{{$schoolupdateurl}}";
            var in_arabic = "{{__('Admin/backend.in_arabic')}}";
            var in_english = "{{__('Admin/backend.in_english')}}";
        </script>
    @endsection

    @php
        if(env('APP_ENV') == 'local'):
            echo '<pre>';
            echo '</pre>';
        endif;
    @endphp
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h4 class="card-title">{{__('Admin/backend.add_school')}}</h4>
                <change>{{__('Admin/backend.in_english')}}</change>
            </div>

            @include('branchcommon.include.alert')
            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                           <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="changeLanguage('arabic', 'english')"">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                        </a>
                    </li>
                </ul>
            </div>

            <div id="show_form"></div>

            <form id="form1" class="forms-sample" enctype="multipart/form-data" action="{{route('superadmin.school.store')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.name')}}</label>
                    <input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.name')}}" value="{{$school_en->name}}">
                </div>

                @if($errors->has('name'))
                    <div class="alert alert-danger">{{$errors->first('name')}}</div>
                @endif
                <div class="form-group">
                    <label for="exampleInputEmail3">{{__('Admin/backend.email_address')}}</label>
                    <input value="{{$school_en->email}}" name="email" type="text" class="form-control"
                           id="exampleInputEmail3" placeholder="{{__('Admin/backend.email_address')}}">
                </div>
                @if($errors->has('email'))
                    <div class="alert alert-danger">{{$errors->first('email')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleSelectGender">{{__('Admin/backend.contact_number')}}</label>
                    <input value="{{$school_en->contact}}" name="contact" class="form-control" id="exampleSelectGender" placeholder="{{__('Admin/backend.contact_number')}}" type="text">
                </div>

                @if($errors->has('contact'))
                    <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.emergency_number')}}</label>
                    <input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.emergency_number')}}"
                           value="{{$school_en->emergency_number}}">
                </div>

                @if($errors->has('emergency_number'))
                    <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.branch_name')}}</label>
                    <ul id="myTags1">
                        @foreach($school_en->branch_name as $branch)
                            <li>
                                {{$branch}}
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($errors->has('branch_name'))
                    <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.capacity')}}</label>
                    <input name="capacity" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.capacity')}}"
                            value="{{$school_en->capacity}}">
                </div>

                @if($errors->has('capacity'))
                    <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.facilities')}}</label>
                    <textarea name="facilities" class="form-control" id="exampleTextarea1"
                                rows="4">{{$school_en->facilities}}</textarea>
                </div>

                @if($errors->has('facilities'))
                    <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.class_size')}}</label>
                    <input name="class_size" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.class_size')}}" value="{{$school_en->class_size}}">
                </div>

                @if($errors->has('class_size'))
                    <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.year_opened')}}</label>
                    <input name="opened" type="text" class="form-control"
                            placeholder="{{__('Admin/backend.year_opened')}}" value="{{$school_en->opened}}">
                </div>

                @if($errors->has('opened'))
                    <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.about_the_school')}}</label>
                    <textarea name="about" class="form-control" id="exampleTextarea1" rows="4">{{$school_en->about}}</textarea>
                </div>
                
                @if($errors->has('about'))
                    <div class="alert alert-danger">{{$errors->first('about')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.address')}}</label>
                    <input name="address" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.address_map_location')}}"
                            value="{{$school_en->address}}">
                </div>

                @if($errors->has('address'))
                    <div class="alert alert-danger">{{$errors->first('address')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.enter_city')}}</label>
                    <input name="city" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.enter_city')}}" value="{{$school_en->city}}">
                </div>

                @if($errors->has('city'))
                    <div class="alert alert-danger">{{$errors->first('city')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.enter_country')}}</label>
                    <input name="country" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.enter_country')}}" value="{{$school_en->country}}">
                </div>

                @if($errors->has('country'))
                    <div class="alert alert-danger">{{$errors->first('country')}}</div>
                @endif

                <input hidden name="en" value='1'>
                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.accreditations_logos')}}</label>
                    <input name="logos[]" multiple type="file" class="form-control" id="exampleInputName1"
                            accept="image/*">
                </div>

                @if($errors->has('logos'))
                    <div class="alert alert-danger">{{$errors->first('logos')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.logo')}}</label>
                    <input name="logo" type="file" class="form-control" id="exampleInputName1" accept="image/*">
                </div>

                @if($errors->has('logo'))
                    <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.video')}}</label>
                    <ul id="myTags">
                        @foreach($school_en->video_url as $videourl)
                            <li>
                                {{$videourl}}
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($errors->has('video_url'))
                    <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.photos')}}</label>
                    <input name="multiple_photos[]" multiple type="file" class="form-control" id="exampleInputName1" accept="image/*">
                </div>

                @if($errors->has('multiple_photos'))
                    <div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
                @endif
                <!-- onclick="submitForm('forms-sample', addschoolurl) -->
                <button type="button" onclick="submitForm($(this).parents().find('#form1'))"
                      class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}
                </button>
                <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
            </form>

            <form id="form2" class="forms-sample" enctype="multipart/form-data" method="post" action = "{{route('branch_admin.school.store')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.name')}}</label>
                    <input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.name')}}" value="{{$school_ar->name}}">
                </div>

                @if($errors->has('name'))
                    <div class="alert alert-danger">{{$errors->first('name')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputEmail3">{{__('Admin/backend.email_address')}}</label>
                    <input value="{{$school_ar->email}}" name="email" type="text" class="form-control" id="exampleInputEmail3" placeholder="{{__('Admin/backend.email_address')}}">
                </div>

                @if($errors->has('email'))
                    <div class="alert alert-danger">{{$errors->first('email')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleSelectGender">{{__('Admin/backend.contact_number')}}</label>
                    <input value="{{$school_ar->contact}}" name="contact" class="form-control" id="exampleSelectGender" placeholder="{{__('Admin/backend.contact_number')}}" type="text">

                </div>

                @if($errors->has('contact'))
                    <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.emergency_number')}}</label>
                    <input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.emergency_number')}}" value="{{$school_ar->emergency_number}}">
                </div>

                @if($errors->has('emergency_number'))
                    <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.branch_name')}}</label>
                    <ul id="myTags2">
                        @foreach($school_ar->branch_name as $branch)
                            <li>
                                {{$branch}}
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($errors->has('branch_name'))
                    <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.capacity')}}</label>
                    <input name="capacity" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.capacity')}}"
                            value="{{$school_ar->capacity}}">
                </div>

                @if($errors->has('capacity'))
                    <div class="alert alert-danger">{{$errors->first('capacity')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.facilities')}}</label>
                    <textarea name="facilities" class="form-control" id="exampleTextarea1" rows="4">{{$school_ar->facilities}}</textarea>
                </div>

                @if($errors->has('facilities'))
                    <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.class_size')}}</label>
                    <input name="class_size" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.class_size')}}" value="{{$school_ar->class_size}}">
                </div>

                @if($errors->has('class_size'))
                    <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.year_opened')}}</label>
                    <input name="opened" type="text" class="form-control"
                            placeholder="{{__('Admin/backend.year_opened')}}" value="{{$school_ar->opened}}">
                </div>

                @if($errors->has('opened'))
                    <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.about_the_school')}}</label>
                    <textarea name="about" class="form-control" id="exampleTextarea1"
                                rows="4">{{$school_ar->about}}</textarea>

                </div>

                @if($errors->has('about'))
                    <div class="alert alert-danger">{{$errors->first('about')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.address')}}</label>
                    <input name="address" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.address_map_location')}}"
                            value="{{$school_ar->address}}">
                </div>

                @if($errors->has('address'))
                    <div class="alert alert-danger">{{$errors->first('address')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.enter_city')}}</label>
                    <input name="city" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.enter_city')}}" value="{{$school_ar->city}}">
                </div>

                @if($errors->has('city'))
                    <div class="alert alert-danger">{{$errors->first('city')}}</div>
                @endif

                <div class="form-group">
                    <label for="exampleInputName1">{{__('Admin/backend.enter_country')}}</label>
                    <input name="country" type="text" class="form-control" id="exampleInputName1"
                            placeholder="{{__('Admin/backend.enter_country')}}" value="{{$school_ar->country}}">
                </div>

                @if($errors->has('country'))
                    <div class="alert alert-danger">{{$errors->first('address')}}</div>
                @endif

                <input hidden name="ar" value='1'>

                <!-- onclick="submitForm('forms-sample', addschoolurl) -->
                <button type="button" onclick="submitForm($(this).parents().find('#form1'))" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
            </form>
        </div>
    </div>
@endsection
