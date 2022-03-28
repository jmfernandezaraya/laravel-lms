@extends('superadmin.layouts.app')
@section('content')
    @section('css')
        <style>
            #formaction {
                width: 100%;
            }
        </style>
    @endsection
    <div class="col-12 grid-margin stretch-card">
        <form id ="formaction" class="forms-sample" method="post" action = "{{route('superadmin.blogs.store')}}">
            {{csrf_field()}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <center>
                                <h1 class="card-title">@lang('SuperAdmin/backend.add_blog')</h1>
                            </center>
                        </div>
                    </div>

                    @include('superadmin.include.alert')

                    <div id="show_form"></div>

                    <div id="form1">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="title_en">{{__('SuperAdmin/backend.blog_title')}} {{__('SuperAdmin/backend.in_english')}}</label>
                                <input value="{{old('title_en')}}" name="title_en" type="text" class="form-control" id="title_en" placeholder="{{__('SuperAdmin/backend.blog_title')}}" value="{{old('blog_title_en')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="description_en">{{__('SuperAdmin/backend.blog_description')}} {{__('SuperAdmin/backend.in_english')}}</label>
                                <textarea class="form-control" id="textarea_en" placeholder="{{__('SuperAdmin/backend.blog_description')}}">{{old('description_en')}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title_ar">{{__('SuperAdmin/backend.blog_title')}} {{__('SuperAdmin/backend.in_arabic')}}</label>
                            <input value="{{old('title_ar')}}" name="title_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.blog_title')}}" value="{{old('first_name')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail3">{{__('SuperAdmin/backend.blog_description')}} {{__('SuperAdmin/backend.in_arabic')}}</label>
                            <textarea  class="form-control" id="textarea_ar" placeholder="Last Name">{{old('description_ar')}}</textarea>
                            <input name="description_ar" hidden id ="desciprtion_ar">
                            <input name="description_en" hidden id ="desciprtion_en">
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                    <button type="submit" onclick="getCKEDITORdata();" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
                </div>
            </div>
        </form>
    </div>

    @section('js')
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

        <script src="{{asset('assets/js/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            var options = {
                filebrowserUploadUrl: "{{route('superadmin.blogs.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form',
            
            };
            
            function initCkeditor(editor_id = 'textarea_en') {    
                CKEDITOR.replace('textarea_en', options);
                CKEDITOR.replace('textarea_ar', options);
            }
            initCkeditor();
            function getCKEDITORdata() {
                var textarea_en = CKEDITOR.instances.textarea_en.getData();
                var textarea_ar = CKEDITOR.instances.textarea_ar.getData();
                $("#desciprtion_ar").val(textarea_ar);
                $("#desciprtion_en").val(textarea_en);
            }
            
            $(document).ready(function () {
                $('#menu ul li a').click(function (ev) {
                    $('#menu ul li').removeClass('selected');
                    $(ev.currentTarget).parent('li').addClass('selected');
                });
            });
            var addschooladminurl = "{{route('superadmin.school_admin.store')}}";
            var in_arabic = "{{__('SuperAdmin/backend.in_arabic')}}";
            var in_english = "{{__('SuperAdmin/backend.in_english')}}";
        </script>
    @endsection
@endsection