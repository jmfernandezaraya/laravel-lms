@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.blog')}}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{ url('/') }}" class="breadcrumb-home">
            <i class="bx bx-home"></i>&nbsp;
        </a>
        <h1>{{__('Frontend.blog')}}<h1>
    </div>
@endsection

@section('content')
    <div class="main-online mt-2">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <h5>{{__('Frontend.search')}}</h5>
                    <input onkeyup="searchBlog($(this).val())" class="form-control" type="search" placeholder="{{__('Frontend.search')}}..." aria-label="Search">
                </div>
            </div>
            <div class="row" id="blogs">
                @forelse ($blogs as $blog)
                    <div class="col-md-4">
                        <a href="{{route('frontend.blog_detail', $blog->id)}}">
                            <div class="single-blog-post">
                                <div class="date">
                                    <span>{{ $blog->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="blog-post-content">
                                    <h3>
                                       {{ app()->getLocale() == 'en' ? $blog->title_en : $blog->title_ar }}
                                    </h3>
                                    <span class="left"><i class="icofont-rounded-double-right"></i></span>
                                    {{__('Frontend.read_more')}}
                                    <span class="right"><i class="icofont-rounded-double-right"></i></span>
                                </div>
                                <img src="{{ $blog->image }}" alt="blog">
                            </div>
                        </a>
                    </div>
                @empty
                    {{__('Frontend.blog_empty')}}
                @endforelse
            </div>
        </div>
    </div>
    <script>
        function searchBlog(value) {
            if (value != '') {
                $.get('blog/search/' + value, {}, function(data) {
                    $("#blogs").html(data.result);
                });
            } else {
                $.get('blog/search/' + value, {}, function(data) {
                    $("#blogs").html(data.default);
                });
            }
        }
    </script>
@endsection