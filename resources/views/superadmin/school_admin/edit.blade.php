@extends('superadmin.layouts.app')

@section('content')

@section('js')
    <script>
        $(document).ready(function () {
            $('#menu ul li a').click(function (ev) {
                $('#menu ul li').removeClass('selected');
                $(ev.currentTarget).parent('li').addClass('selected');
            });
        });

        var addschooladminurl = "{{route('superadmin.school_admins.update', $users->id)}}";
        var in_arabic = "{{__('SuperAdmin/backend.in_arabic')}}";
        var in_english = "{{__('SuperAdmin/backend.in_english')}}";
    </script>
@endsection

<div class="col-12 grid-margin stretch-card">

    <div class="card">
        <form id="form_to_be_submitted" class="forms-sample" method="post">
            {{csrf_field()}}
            <div id="form1">
                <div class="card-body">
                    <center><h1 class="card-title">{{__('SuperAdmin/backend.add_school_admin')}}</h1>
                        <change>{{__('SuperAdmin/backend.in_english')}}</change>
                    </center>
                    @include('superadmin.include.alert')
                    <div id="menu">
                        <ul class="lang text-right current_page_itemm">
                            <li class="current_page_item selected">
                                <a class="" href="#"
                                   onclick="changeLanguage('english', 'arabic')"><img class="pr-2"
                                                                                                          src="{{asset('public/frontend/assets/img/eng.png')}}"
                                                                                                          alt="logo">{{__('SuperAdmin/backend.english')}}
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"
                                   onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                                    <img class="pr-2"
                                         src="{{asset('public/frontend/assets/img/ar.png')}}"


                                         alt="logo">{{__('SuperAdmin/backend.arabic')}}</a></li>
                        </ul>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName1">{{__('SuperAdmin/backend.first_name')}}</label>
                        <input name="first_name_en" type="text" class="form-control" id="exampleInputName1"
                            value="{{$users->first_name_en}}"   placeholder="{{__('SuperAdmin/backend.first_name')}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.last_name')}}</label>
                        <input  name="last_name_en" type="text" class="form-control"
                               value="{{$users->last_name_en}}"   id="exampleInputEmail3" placeholder="{{__('SuperAdmin/backend.last_name')}}">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.email_address')}}</label>
                        <input name="email" type="email" class="form-control"
                               value="{{$users->email}}"  id="exampleInputEmail3" placeholder="{{__('SuperAdmin/backend.email_address')}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.enter_password')}}</label>
                        <input name="password" type="password" class="form-control" id="exampleInputEmail3" placeholder="{{__('SuperAdmin/backend.enter_password')}}">
                    </div>

                    <div class="form-group">
                        <label for="exampleSelectGender">{{__('SuperAdmin/backend.contact_no')}}</label>
                        <input  name="contact" class="form-control" id="exampleSelectGender"
                               value="{{$users->contact}}"   placeholder="{{__('SuperAdmin/backend.contact_no')}}" type="number">

                    </div>
@if($users->image == null || $users->image  == '')
                    <img src="//desk87.com/assets/images/preview-not-available.jpg" id="previewImg"
                         alt="Uploaded Image Preview Holder" width="550px" height="250px"
                         style="border-radius:3px;border:5px;"/>
                    @else
                        <img src="{{asset($users->image)}}" id="previewImg"
                             alt="Uploaded Image Preview Holder" width="550px" height="250px"
                             style="border-radius:3px;border:5px;"/>

    @endif

                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.profile_image_if_any')}}</label>
                        <input type="file" onchange="previewFile(this)" class="form-control" name="image">

                    </div>

                    <div class ="form-group">
                        <div class="form-check">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input  {{$users->editCoursePermission->add == 1 ? 'checked' : ''}} name="can_add_course" type="checkbox" class="form-check-input" id="exampleInputEmail3" value = '1'>
                            <label for="exampleInputEmail3">@lang('SuperAdmin/backend.can_add_course')</label>
                        </div>
                        <div class="form-check">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input {{$users->editCoursePermission->edit == 1 ? 'checked' : ''}} name="can_edit_course" type="checkbox" class="form-check-input" id="exampleInputEmail3" value = '1'>
                            <label for="exampleInputEmail3">@lang('SuperAdmin/backend.can_edit_course')</label>
                        </div>
                        <div class="form-check">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input {{$users->editCoursePermission->delete == 1 ? 'checked' : ''}} name="can_delete_course" type="checkbox" class="form-check-input" id="exampleInputEmail3" value = '1'>
                            <label for="exampleInputEmail3">@lang('SuperAdmin/backend.can_delete_course')</label>
                        </div>
                    </div>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>

                </div>
            </div>
            <div id="show_form"></div>

            <div id="form2">
                <div class="card-body">
                    <center><h1 class="card-title">{{__('SuperAdmin/backend.add_school_admin')}}</h1>
                        <change>{{__('SuperAdmin/backend.in_arabic')}}</change>
                    </center>
                    @include('superadmin.include.alert')
                    <div id="menu">
                        <ul class="lang text-right current_page_itemm">
                            <li class="current_page_item selected">
                                <a class="" href="#"
                                   onclick="changeLanguage('english', 'arabic')"><img class="pr-2"
                                                                                                          src="{{asset('public/frontend/assets/img/eng.png')}}"
                                                                                                          alt="logo">{{__('SuperAdmin/backend.english')}}
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"
                                   onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                                    <img class="pr-2"
                                         src="{{asset('public/frontend/assets/img/ar.png')}}"


                                         alt="logo">{{__('SuperAdmin/backend.arabic')}}</a></li>
                        </ul>
                    </div>
                    <div class="form-group">

                        <label for="exampleInputName1">{{__('SuperAdmin/backend.first_name')}}</label>
                        <input name="first_name_ar" type="text" class="form-control" id="exampleInputName1"
                               value="{{$users->first_name_ar}}"  placeholder="First Name">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail3">{{__('SuperAdmin/backend.last_name')}}</label>
                        <input  name="last_name_ar" type="text" class="form-control"
                               value="{{$users->last_name_ar}}"  id="exampleInputEmail3" placeholder="Last Name">
                    </div>


                    <button onclick="submitSchoolAdminForm(addschooladminurl)" type="button"
                          class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </div>


            </div>
        </form>

    </div>

    <script>
        function previewFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#previewImg').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

    </script>

@endsection
