@extends('frontend.layouts.app')

@section('title')
    {!! app()->getLocale() == 'en' ? $blog->title_en : $blog->title_ar !!}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{ url('/') }}" class="breadcrumb-home">
            <i class="bx bx-home"></i>&nbsp;
        </a>
        <h1>{!! app()->getLocale() == 'en' ? $blog->title_en : $blog->title_ar !!}<h1>
    </div>
@endsection

@section('content')
<!-- ======= Blog Details Section ======= -->
<section id="blog-details" class="blog-details">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12">
                <h3>{!! app()->getLocale() == 'en' ? $blog->title_en : $blog->title_ar !!}</h3>
                <p>{!! app()->getLocale() == 'en' ? $blog->description_en : $blog->description_ar !!}</p>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Details Section -->
@endsection