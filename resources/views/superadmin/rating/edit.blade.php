@extends('superadmin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_rating')}}</h1>
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
                <form id ="formaction" class="forms-sample" method="post" action="{{route('superadmin.blogs.update', $blog->id)}}">
                    {{csrf_field()}}

                    <div id="form1">
                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.blog_title')}}</label>
                            <input value="{{$blog->title_en}}" name="title_en" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.blog_title')}}" value="{{old('blog_title_en')}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail3">{{__('SuperAdmin/backend.blog_description')}}</label>
                            <textarea value="{{$blog->description_en}}" name="description_en" class="form-control" id="textarea_en" placeholder="{{__('SuperAdmin/backend.blog_description')}}"></textarea>
                        </div>

                        <img src="{{asset($blog->image)}}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;"/>

                        <div class="form-group">
                            <label>{{__('SuperAdmin/backend.blog_image')}}</label>
                            <input onchange="previewFile(this)" type="file" class="form-control" name="image">
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                    </div>

                    <div id="form2" class="forms-sample">
                        <div class="form-group">
                            <label for="exampleInputName1">{{__('SuperAdmin/backend.blog_title')}}</label>
                            <input value="{{$blog->title_ar}}" name="title_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('SuperAdmin/backend.blog_title')}}" value="{{old('first_name')}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail3">{{__('SuperAdmin/backend.blog_description')}}</label>
                            <textarea value="{{$blog->description_ar}}" name="description_ar" class="form-control" id="textarea_ar"  placeholder="Last Name"></textarea>
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                        <button type="button" onclick="submitCommonForBlogForm($(this).parents().find('#formaction').attr('action'))" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $("#textarea_en").summernote('code', {{$blog->description_en}});
            $("#textarea_ar").summernote('code', {{$blog->description_ar}});
            function previewFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#previewImg').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            $(document).ready(function () {
                $('textarea.form-control').summernote({
                        'height': 250
                    }
                );

                $('#menu ul li a').click(function (ev) {
                    $('#menu ul li').removeClass('selected');
                    $(ev.currentTarget).parent('li').addClass('selected');
                });
            });
        </script>
    @endsection
@endsection

