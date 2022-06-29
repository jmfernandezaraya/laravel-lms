@extends('branchadmin.layouts.app')

@section('css')
@endsection

@section('content')

    <div class="col-12 grid-margin stretch-card">
        <form id ="formaction" class="forms-sample" method="post" action = "{{route('branch_admin.blogs.update', $blog->id)}}">
            {{csrf_field()}}
            <div class="card">
                <div class="card-body">
                    <center>
                        <h4 class="card-title">@lang('Admin/backend.edit_blog')</h4>
                        <change>{{__('Admin/backend.in_english')}}</change>
                    </center>

                    @include('branchadmin.include.alert')
                    <div id="menu">
                        <ul class="lang text-right current_page_itemm">
                            <li class="current_page_item selected">
                                <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                                    <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="changeLanguage('arabic', 'english')">
                                    <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div id="show_form"></div>
                    @csrf
                    <div id="form1">
                        <div class="form-group">
                            <label for="exampleInputName1">{{__('Admin/backend.blog_title')}}</label>
                            <input value="{{$blog->title_en}}" name="title_en" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.blog_title')}}" value="{{old('blog_title_en')}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail3">{{__('Admin/backend.blog_description')}}</label>
                            <textarea value="{{$blog->description_en}}" name="description_en" class="form-control" id="textarea_en" placeholder="{{__('Admin/backend.blog_description')}}"></textarea>
                        </div>

                        <img src="{{asset($blog->image)}}" id="previewImg"
                            alt="Uploaded Image Preview Holder" width="550px" height="250px"
                            style="border-radius:3px;border:5px;"/>

                        <div class="form-group">
                            <label>{{__('Admin/backend.blog_image')}}</label>
                            <input onchange="previewFile(this)" type="file" class="form-control" name="image">
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                    </div>

                    <div id="form2" class="forms-sample">
                        <div class="form-group">
                            <label for="exampleInputName1">{{__('Admin/backend.blog_title')}}</label>
                            <input value="{{$blog->title_ar}}" name="title_ar" type="text" class="form-control" id="exampleInputName1" placeholder="{{__('Admin/backend.blog_title')}}" value="{{old('first_name')}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">{{__('Admin/backend.blog_description')}}</label>
                            <textarea value="{{$blog->description_ar}}" name="description_ar" class="form-control" id="textarea_ar" placeholder="Last Name"></textarea>
                        </div>

                        <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                        <button type="button" onclick="submitCommonForBlogForm($(this).parents().find('#formaction').attr('action'))" class="btn btn-primary">@lang('Admin/backend.submit')
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
        </script>
        <script>
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
            var addschooladminurl = "{{route('branch_admin.store')}}";
            var in_arabic = "{{__('Admin/backend.in_arabic')}}";
            var in_english = "{{__('Admin/backend.in_english')}}";
        </script>
    @endsection
@endsection