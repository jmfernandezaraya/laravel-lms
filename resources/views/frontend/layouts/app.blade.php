<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{__('Frontend.site_name')}} - @yield('title')</title>

        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{asset('public/frontend/assets/img/favicon.png')}}" rel="icon">

        <link href="{{asset('public/frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link rel="stylesheet" ref="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">

        <!-- Vendor CSS Files -->
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/icofont/icofont.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/boxicons/css/boxicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/remixicon/remixicon.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/animate/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/assets/vendor/aos/aos.css')}}">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        
        <!-- Template Main CSS File -->
        <link rel="stylesheet" href="{{asset('public/frontend/assets/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

        @yield('css')
    </head>

    <body>
        <div id="loader"></div>

        @include('frontend.layouts.header')

        {{-- @yield('after_header') --}}

        <main id="main" class="mt-5 pt-5">
            <div class="container">
                @yield('content')
        @include('frontend.layouts.footer')
    </body>
    <div id="loading"></div>
</html>