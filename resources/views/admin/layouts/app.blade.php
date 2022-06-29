<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
            @hasSection('title')
                @yield('title')
            @else
                {{__('Admin/backend.admin')}}
            @endif
                - {{__('Admin/backend.site_name')}}
        </title>

        <!-- Ignite UI for jQuery Required Combined CSS Files -->
        <link href="https://cdn-na.infragistics.com/igniteui/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet"></link>
        <link href="https://cdn-na.infragistics.com/igniteui/latest/css/structure/infragistics.css" rel="stylesheet"></link>
        
        <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">

        <link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}"/>
        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('assets/datatables/datatables.min.css')}}">
        <link rel="stylesheet"href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">    
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{asset('assets/js/tag/css/jquery.tagit.css')}}" type="text/css">
        <link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap-multiselect.css')}}" type="text/css">
        
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

        @toastr_css
        @livewireStyles
        @yield('css')

        <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
        
        <style>
            label {
                color: black;
            }
            .active li a.active {
                color: #b66dff!important;
            }
            ul li a:hover,
            ul li .dropdown-item:hover {
                color: #b66dff!important;
            }
        </style>
    </head>

    <body>
        <div id="loader"></div>

        <div class="container-scroller">
            @auth ('superadmin')
                @include('superadmin.include.header')
            @else            
                @auth ('schooladmin')
                    @include('schooladmin.include.header')
                @endauth
            @endauth

            @toastr_js
            @toastr_render

            <div class="container-fluid page-body-wrapper">
                @auth ('superadmin')
                    @include('superadmin.include.sidebar')
                @else
                    @auth ('schooladmin')
                        @include('schooladmin.include.sidebar')
                    @endauth
                @endauth
                <div class="main-panel">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                @include('admin.include.footer')
    </body>
    <div id="loading"></div>
</html>