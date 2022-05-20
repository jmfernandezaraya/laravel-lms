@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_blog')}}
@endsection

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <form id="blogForm" class="forms-sample" method="post" action="{{route('superadmin.blogs.update', $blog->id)}}">
            {{csrf_field()}}
            @method('PUT')
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <center>
                                <h1 class="card-title">{{__('SuperAdmin/backend.edit_blog')}}</h1>
                                <div class="english">
                                    {{__('SuperAdmin/backend.in_english')}}
                                </div>
                                <div class="arabic">
                                    {{__('SuperAdmin/backend.in_arabic')}}
                                </div>
                            </center>
                        </div>
                    </div>

                    @include('superadmin.include.alert')

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
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title">{{__('SuperAdmin/backend.blog_title')}}</label>
                            <div class="english">
                                <input value="{{$blog->title_en}}" name="title_en" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.blog_title')}}">
                            </div>
                            <div class="arabic">
                                <input value="{{$blog->title_ar}}" name="title_ar" type="text" class="form-control" placeholder="{{__('SuperAdmin/backend.blog_title')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="description">{{__('SuperAdmin/backend.blog_description')}}</label>
                            <div class="english">
                                <textarea id="description_en" name="description_en" class="form-control ckeditor-input" placeholder="{{__('SuperAdmin/backend.blog_description')}}">{!! $blog->description_en !!}</textarea>
                            </div>
                            <div class="arabic">
                                <textarea id="description_ar" name="description_ar" class="form-control ckeditor-input" placeholder="{{__('SuperAdmin/backend.blog_description')}}">{!! $blog->description_ar !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                    <button type="button" onclick="submitForm($(this).parents().find('#blogForm'))" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
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
                $('#menu ul li a').click(function (ev) {
                    $('#menu ul li').removeClass('selected');
                    $(ev.currentTarget).parent('li').addClass('selected');
                });
            });
        </script>
    @endsection
@endsection