@extends('frontend.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    <div class="breadcrumb-head">
        <a href="{{ url('/') }}" class="breadcrumb-home">
            <i class="bx bx-home"></i>&nbsp;
        </a>
        <h1>{{ $title }}</h1>
    </div>
@endsection

@section('content')
    <section class="page-content">
        <div class="container" data-aos="fade-up">
            {!! $content !!}
        </div>
    </section>
@endsection