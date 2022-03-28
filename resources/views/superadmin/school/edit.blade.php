@extends('superadmin.layouts.app')
@section('content')
@section('js')
    <script src="{{asset('assets/js/tag/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('assets/js/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script>
        function initCkeditor(editor_id = 'facilities_textarea') {


            CKEDITOR.replace('facilities_textarea');
            CKEDITOR.replace('about_textarea');

            CKEDITOR.instances.facilities_textarea.destroy();


            CKEDITOR.instances.about_textarea.destroy();


            CKEDITOR.replace('facilities_textarea');
            CKEDITOR.replace('about_textarea');


        }

        function initArEditor() {
            CKEDITOR.replace('facilities_ar_textarea');
            CKEDITOR.replace('about_ar_textarea');

            CKEDITOR.instances.facilities_ar_textarea.destroy();


            CKEDITOR.instances.about_ar_textarea.destroy();


            CKEDITOR.replace('facilities_ar_textarea');
            CKEDITOR.replace('about_ar_textarea');
            var about = CKEDITOR.instances.about_textarea.getData();
            var facilities = CKEDITOR.instances.facilities_textarea.getData();
            $("#about_input").val(about);
            $("#facilities_input").val(facilities);
        }

        function getCKEDITORdata() {

            var textarea_en = CKEDITOR.instances.facilities_ar_textarea.getData();
            var textarea_ar = CKEDITOR.instances.about_ar_textarea.getData();
            $("#facilities_ar_input").val(textarea_ar);
            $("#about_ar_input").val(textarea_en);


        }


        $(document).ready(function () {

            initCkeditor();
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

                fieldName: "branch_name_ar[]"
            });

        });
        var addschoolurl = "{{route('superadmin.schools.store')}}";
        var in_arabic = "{{__('SuperAdmin/backend.in_arabic')}}";
        var in_english = "{{__('SuperAdmin/backend.in_english')}}";
    </script>



@endsection
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <center>
                <h1 class="card-title">{{__('SuperAdmin/backend.update_school')}}</h1>
                <change>{{__('SuperAdmin/backend.in_english')}}</change>
            </center>


            @include('superadmin.include.alert')
            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#"
                           onclick="english_form('form2', 'show_form', 'form1', in_english); initCkeditor()"><img
                              class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"
                           onclick="changeLanguage('arabic', 'english')"; initArEditor(); ">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}"


                                 alt="logo">{{__('SuperAdmin/backend.arabic')}}</a></li>
                </ul>
            </div>
            <form id="form2store" class="forms-sample" enctype="multipart/form-data"
                  action="{{route('superadmin.school.update', $schools->id)}}" method="post">
                {{csrf_field()}}
                <div id="show_form"></div>

                <div id="form1">

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_name')}}</label>
                        <input name="name" type="text" value="{{$schools->name}}" class="form-control"
                               id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.school_name')}}">
                    </div>

                    @if($errors->has('name'))
                        <div class="alert alert-danger">{{$errors->first('name')}}</div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.school_email_address')}}</label>
                        <input value="{{$schools->email}}" name="email" type="text" class="form-control"
                               id="exampleInputEmail3" placeholder="{{__('SuperAdmin/backend.school_email_address')}}">
                    </div>
                    @if($errors->has('email'))
                        <div class="alert alert-danger">{{$errors->first('email')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleSelectGender">{{__('SuperAdmin/backend.school_contact_number')}}</label>
                        <input value="{{$schools->contact}}" name="contact" class="form-control"
                               id="exampleSelectGender" placeholder="{{__('SuperAdmin/backend.school_contact_number')}}" type="text">

                    </div>
                    @if($errors->has('contact'))
                        <div class="alert alert-danger">{{$errors->first('contact')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_emergency_number')}}</label>
                        <input name="emergency_number" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.school_emergency_number')}}"
                               value="{{$schools->emergency_number}}">
                    </div>
                    @if($errors->has('emergency_number'))
                        <div class="alert alert-danger">{{$errors->first('emergency_number')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_branch_name')}}</label>
                    </div>

                    <ul id="myTags1">
                        @foreach((array)$schools->branch_name as $branch)
                            <li>{{$branch}}</li>
                        @endforeach
                    </ul>

                    @if($errors->has('branch_name'))
                        <div class="alert alert-danger">{{$errors->first('branch_name')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_capacity')}}</label>
                        <input name="school_capacity" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.school_capacity')}}"
                               value="{{$schools->school_capacity}}">
                    </div>
                    @if($errors->has('school_capacity'))
                        <div class="alert alert-danger">{{$errors->first('school_capacity')}}</div>
                    @endif


                    <div class="form-group">

                        <label for="exampleInputName1">{{__('SuperAdmin/backend.facilities')}}</label>
                        <textarea name="facilities" class="form-control" id="facilities_textarea"
                                  rows="4">{!! $schools->facilities !!}</textarea>

                    </div>
                    @if($errors->has('facilities'))
                        <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.class_size')}}</label>
                        <input name="class_size" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.class_size')}}" value="{{$schools->class_size}}">
                    </div>
                    @if($errors->has('class_size'))
                        <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.year_opened')}}</label>
                        <input name="opened" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.year_opened')}}" value="{{$schools->opened}}">
                    </div>
                    @if($errors->has('opened'))
                        <div class="alert alert-danger">{{$errors->first('opened')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.about_the_school')}}</label>
                        <textarea name="about" class="form-control" id="about_textarea"
                                  rows="4">	{!! $schools->about !!}</textarea>

                    </div>
                    @if($errors->has('about'))
                        <div class="alert alert-danger">{{$errors->first('about')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.address')}}</label>
                        <input name="address" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.address_map_location')}}"
                               value="{{$schools->address}}">
                    </div>
                    @if($errors->has('address'))
                        <div class="alert alert-danger">{{$errors->first('address')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.city')}}</label>
                        <input name="city" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.city')}}" value="{{$schools->city}}">
                    </div>
                    @if($errors->has('city'))
                        <div class="alert alert-danger">{{$errors->first('city')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.country')}}</label>
                        <input name="country" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.country')}}" value="{{$schools->country}}">
                    </div>
                    @if($errors->has('country'))
                        <div class="alert alert-danger">{{$errors->first('address')}}</div>
                    @endif


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.accreditations_logos')}}</label>
                        <input name="logos[]" multiple type="file" onchange="$('#logos_id').hide()" class="form-control" id="exampleInputName1"
                               accept="image/*">
                    </div>
                    @if($errors->has('logos'))
                        <div class="alert alert-danger">{{$errors->first('logos')}}</div>
                    @endif
                    <br>
                    @if(!empty($schools->logos))
                    @foreach($schools->logos as $logos)

                        <img id="logos_id" height="200px" width="200px" src="{{$schools->getStorageImages('school_images', $logos)}}"
                           class="img-fluid img-thumbnail" alt="...">

                        &nbsp;&nbsp;
                    @endforeach
                    @endif
                    <br><br>
                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_logo')}}</label>
                        <input name="logo" type="file" onchange="$('#logo_id').hide()" class="form-control" id="exampleInputName1" accept="image/*">
                    </div>
                    @if($errors->has('logo'))
                        <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                    @endif
                    @if(!is_null($schools->logo))

                    <img height="200px" id="logo_id" width="200px" src="{{$schools->logo}}" class="img-fluid img-thumbnail"
                         alt="...">

                    @endif
                    <br><br>
                    <div class="form-group">

                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_video')}}</label>
                        <ul id="myTags">
                            @foreach((array)$schools->school_video as $videos)
                                <li>{{$videos}}</li>
                            @endforeach
                        </ul>

                    </div>
                    @if($errors->has('video_url'))
                        <div class="alert alert-danger">{{$errors->first('video_url')}}</div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.school_photos')}}</label>
                        <input name="multiple_photos[]" multiple type="file" class="form-control" id="exampleInputName1"
                               accept="image/*">
                    </div>

                    @if($errors->has('multiple_photos'))
                        <div class="alert alert-danger">{{$errors->first('multiple_photos')}}</div>
                @endif
                <!-- onclick="submitForm('forms-sample', addschoolurl) -->

                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>


                    <div id="form2" class="forms-sample">

                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.school_name')}}</label>
                            <input name="name_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.school_name')}}" value="{{$schools->name_ar}}">
                        </div>
                        <input hidden name="facilities_ar" id="facilities_ar_input">
                        <input hidden name="facilities" id="facilities_input">
                        <input hidden name="about_ar" id="about_ar_input">
                        <input hidden name="about" id="about_input">
                        @if($errors->has('name'))
                            <div class="alert alert-danger">{{$errors->first('name')}}</div>
                        @endif

                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.school_branch_name')}}</label>

                        </div>
                        <ul id="myTags2">
                            @foreach((array)$schools->branch_name_ar as $branch)

                                <li>{{$branch}}</li>
                            @endforeach


                        </ul>


                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.facilities')}}</label>
                            <textarea name="" class="form-control" id="facilities_ar_textarea"
                                      rows="4">{!! $schools->facilities_ar !!}</textarea>

                        </div>
                        @if($errors->has('facilities'))
                            <div class="alert alert-danger">{{$errors->first('facilities')}}</div>
                        @endif


                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.class_size')}}</label>
                            <input name="class_size_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.class_size')}}"
                                   value="{{$schools->class_size_ar}}">
                        </div>
                        @if($errors->has('class_size'))
                            <div class="alert alert-danger">{{$errors->first('class_size')}}</div>
                        @endif

                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.about_the_school')}}</label>
                            <textarea name="" class="form-control" id="about_ar_textarea"
                                      rows="4">{!!  $schools->about_ar !!}</textarea>

                        </div>
                        @if($errors->has('about'))
                            <div class="alert alert-danger">{{$errors->first('about')}}</div>
                        @endif


                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.enter_city')}}</label>
                            <input name="city_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.enter_city')}}" value="{{$schools->city_ar}}">
                        </div>
                        @if($errors->has('city'))
                            <div class="alert alert-danger">{{$errors->first('city')}}</div>
                        @endif


                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.enter_country')}}</label>
                            <input name="country_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.enter_country')}}"
                                   value="{{$schools->country_ar}}">
                        </div>
                        @if($errors->has('country'))
                            <div class="alert alert-danger">{{$errors->first('country')}}</div>
                    @endif


                    <!-- onclick="submitForm('forms-sample', addschoolurl) -->
                        <button type="button"
                                onclick="getCKEDITORdata();  submitForm($(this).parents().find('#form2store'))" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>


@endsection
