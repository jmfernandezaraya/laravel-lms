@extends('branchadmin.layouts.app')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <form id="BranchAdminForm" class="forms-sample" method="post">
                {{csrf_field()}}
                <div id="form1">
                    <div class="card-body">
                        <center>
                            <h4 class="card-title">{{__('Admin/backend.add_school_admin')}}</h4>
                            <change>{{__('Admin/backend.in_english')}}</change>
                        </center>

                        @include('branchcommon.include.alert')

                        <div id="menu">
                            <ul class="lang text-right current_page_itemm">
                                <li class="current_page_item selected">
                                    <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                                        <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                                        <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="first_name">{{__('Admin/backend.first_name')}}</label>
                            <input name="first_name_en" type="text" class="form-control" id="first_name" value="{{$users->first_name_en}}" placeholder="{{__('Admin/backend.first_name')}}">
                        </div>

                        <div class="form-group">
                            <label for="last_name">{{__('Admin/backend.last_name')}}</label>
                            <input name="last_name_en" type="text" class="form-control" value="{{$users->last_name_en}}" id="last_name" placeholder="{{__('Admin/backend.last_name')}}">
                        </div>

                        <div class="form-group">
                            <label for="email">{{__('Admin/backend.email_address')}}</label>
                            <input name="email" type="email" class="form-control" value="{{$users->email}}" id="email" placeholder="{{__('Admin/backend.email_address')}}">
                        </div>

                        <div class="form-group">
                            <label for="password">{{__('Admin/backend.enter_password')}}</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="{{__('Admin/backend.enter_password')}}">
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{__('Admin/backend.telephone')}}</label>
                            <input name="telephone" class="form-control" id="telephone" value="{{$users->telephone}}" placeholder="{{__('Admin/backend.telephone')}}" type="number">
                        </div>

                        @if($users->image == null || $users->image  == '')
                            <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;"/>
                        @else
                            <img src="{{asset($users->image)}}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;"/>
                        @endif

                        <div class="form-group">
                            <label>{{__('Admin/backend.profile_image_if_any')}}</label>
                            <input type="file" onchange="previewFile(this)" class="form-control" name="image">
                        </div>
                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                    </div>
                </div>

                <div id="show_form"></div>

                <div id="form2">
                    <div class="card-body">
                        <center><h4 class="card-title">{{__('Admin/backend.add_school_admin')}}</h4>
                            <change>{{__('Admin/backend.in_arabic')}}</change>
                        </center>

                        @include('branchcommon.include.alert')

                        <div id="menu">
                            <ul class="lang text-right current_page_itemm">
                                <li class="current_page_item selected">
                                    <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                                        <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                                        <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="first_name_ar">{{__('Admin/backend.first_name')}}</label>
                            <input name="first_name_ar" type="text" class="form-control" id="first_name_ar" value="{{$users->first_name_ar}}" placeholder="First Name">
                        </div>

                        <div class="form-group">
                            <label for="last_name_ar">{{__('Admin/backend.last_name')}}</label>
                            <input name="last_name_ar" type="text" class="form-control" value="{{$users->last_name_ar}}" id="last_name_ar" placeholder="Last Name">
                        </div>

                        <button onclick="submitForm($(this).parents().find('#BranchAdminForm'))" type="button" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                    </div>
                </div>
            </form>
        </div>
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