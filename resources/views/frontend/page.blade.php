@extends('frontend.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    <h1>{{ $title }}</h1>
@endsection

@section('content')
    <section class="page-content">
        <div class="container" data-aos="fade-up">
            {!! $content !!}
        </div>
    </section>
@endsection