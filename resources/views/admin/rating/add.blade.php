@extends('admin.layouts.app')

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_rating')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('admin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="formaction" class="forms-sample" method="post" action="{{route('blogs.store')}}">
                    {{csrf_field()}}
                    
                    <div id="form1">
                        <div class="form-group">
                            <label for="exampleInputName1">{{__('Admin/backend.blog_title')}}</label>
                            <input value="{{old('title_en')}}" name="title_en" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.blog_title')}}" value="{{old('blog_title_en')}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail3">{{__('Admin/backend.blog_description')}}</label>
                            <textarea value="{{old('description_en')}}" name="description_en" class="form-control" id="textarea_en" placeholder="{{__('Admin/backend.blog_description')}}"></textarea>
                        </div>

                        <img src="{{ asset('/assets/images/no-image.jpg') }}" id="previewImg" alt="Uploaded Image Preview Holder" width="550px" height="250px" style="border-radius:3px;border:5px;"/>

                        <div class="form-group">
                            <label>{{__('Admin/backend.blog_image')}}</label>
                            <input onchange="previewFile(this)" type="file" class="form-control" name="image">
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                    </div>

                    <div id="form2" class="forms-sample">
                        <div class="form-group">
                            <label for="exampleInputName1">{{__('Admin/backend.blog_title')}}</label>
                            <input value="{{old('title_ar')}}" name="title_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.blog_title')}}" value="{{old('first_name')}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail3">{{__('Admin/backend.blog_description')}}</label>
                            <textarea value="{{old('description_ar')}}" name="description_ar" class="form-control" id="textarea_ar" placeholder="Last Name"></textarea>
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                        <button type="button" onclick="submitCommonForBlogForm($(this).parents().find('#formaction').attr('action'))"
                            class="btn btn-primary">@lang('Admin/backend.submit')
                        </button>
                    </div>
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

