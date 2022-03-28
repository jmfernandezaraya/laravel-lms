@extends('superadmin.layouts.app')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <form id ="formaction" class="forms-sample" method="post" action = "{{route('superadmin.blogs.update', $blog->id)}}">
            {{csrf_field()}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <center>
                                <h1 class="card-title">@lang('SuperAdmin/backend.edit_blog')</h1>
                                <change>{{__('SuperAdmin/backend.in_english')}}</change>
                            </center>
                        </div>
                    </div>

                    @include('superadmin.include.alert')

                    <div id="menu">
                        <ul class="lang text-right current_page_itemm">
                            <li class="current_page_item selected">
                                <a class="" href="#" onclick="english_form('form2', 'show_form', 'form1', in_english); initCkeditorEn();">
                                    <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="changeLanguage('arabic', 'english')"; initCkeditorAr(); copyForms2('form1', 'form2')">
                                    <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div id="show_form"></div>

                    @csrf
                    <div id="form1">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="title_en">{{__('SuperAdmin/backend.blog_title')}}</label>
                                <input value="{{$blog->title_en}}" name="title_en" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.blog_title')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="description_en">{{__('SuperAdmin/backend.blog_description')}}</label>
                                <textarea  name="description_en" class="form-control" id="textarea_en" placeholder="{{__('SuperAdmin/backend.blog_description')}}">{!! $blog->description_en !!}</textarea>
                        </div>
                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                    </div>

                    <div id="form2" class="forms-sample">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="title_ar">{{__('SuperAdmin/backend.blog_title')}}</label>
                                <input value="{{$blog->title_ar}}" name="title_ar" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.blog_title')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="description_ar">{{__('SuperAdmin/backend.blog_description')}}</label>
                                <textarea name="description_ar" class="form-control" placeholder="Last Name">{!! $blog->description_ar !!}</textarea>
                                <input name="description_ar" hidden id ="desciprtion_ar">
                                <input name="description_en" hidden id ="desciprtion_en">
                            </div>
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                        <button type="button" onclick="getCKEDITORdata(); submitCommonForBlogForm($(this).parents().find('#formaction').attr('action'), 'PUT')" class="btn btn-primary">@lang('SuperAdmin/backend.submit') </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @section('js')
        <script src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>
        <script>
            var options = {
                filebrowserUploadUrl: "{{route('superadmin.blogs.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form',
                extraAllowedContent: '*{*}',
            };

            function previewFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
            
                    reader.onload = function (e) {
                        $('#previewImg').attr('src', e.target.result);
                    }
            
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function initCkeditor(editor_id = 'textarea_en'){
                CKEDITOR.config.extraPlugins = 'iframe';
                CKEDITOR.replace('textarea_en', options);
            }

            var arerditor = 0;
            function initCkeditorAr(editor_id = 'textarea_en') {
                CKEDITOR.config.extraPlugins = 'iframe';
                if(arerditor > 0){
                    CKEDITOR.instances.textarea_ar.destroy();
                }
                CKEDITOR.replace('textarea_ar', options);
                arerditor++;
            }
            
            function initCkeditorEn(editor_id = 'textarea_en') {
                CKEDITOR.config.extraPlugins = 'iframe';
                CKEDITOR.instances.textarea_en.destroy();
                CKEDITOR.replace('textarea_en', options);
            }
            
            $(document).ready(function () {
                $('#menu ul li a').click(function (ev) {
                    $('#menu ul li').removeClass('selected');
                    $(ev.currentTarget).parent('li').addClass('selected');
                });
            
                initCkeditor();
            });

            var addschooladminurl = "{{route('superadmin.school_admin.store')}}";
            var in_arabic = "{{__('SuperAdmin/backend.in_arabic')}}";
            var in_english = "{{__('SuperAdmin/backend.in_english')}}";

            function getCKEDITORdata() {
                var textarea_en = CKEDITOR.instances.textarea_en.getData();
                var textarea_ar = CKEDITOR.instances.textarea_ar.getData();
                $("#desciprtion_ar").val(textarea_ar);
                $("#desciprtion_en").val(textarea_en);
            }
        </script>
    @endsection
@endsection