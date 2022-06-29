@extends('admin.layouts.app')
@section('content')
    @section('css')
        <link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap-multiselect.css')}}" type="text/css">

        <style>
            .pl-3:hover {
                cursor: pointer;
            }
            
            .fa {
                cursor: pointer;
            }
            
            .tox .tox-notification--warn,
            .tox .tox-notification--warning {
                display: none !important;
            }
            
            #ms-list-1,
            #ms-list-2,
            #ms-list-3,
            #ms-list-4,
            #ms-list-5,
            #ms-list-6,
            #ms-list-7,
            #ms-list-8,
            #ms-list-9,
            #ms-list-11,
            #ms-list-10 {
                padding: 10px 8px;
                border: 1px solid #ebedf2;
            }
            
            .ms-options-wrap > .ms-options {
                left: 21px;
                width: 87%;
            }
            
            button {
                border: none !important;
            }
            
            i.fa.fa-plus-circle {
                background: linear-gradient(to right, #da8cff, #9a55ff) !important;
                padding: 15px 15px;
                color: #fff;
                border-radius: 10px;
                font-size: 15px;
            }
            
            i.fa.fa-minus {
                background: linear-gradient(to right, #da8cff, #9a55ff) !important;
                padding: 15px 15px;
                color: #fff;
                border-radius: 10px;
                font-size: 15px;
            }
            
            i.fa.fa-plus {
                background: linear-gradient(to right, #da8cff, #9a55ff) !important;
                padding: 10px 15px 10px 0px;
                color: #fff;
                border-radius: 10px;
                font-size: 15px;
                margin-left: 5px;
            }
            
            i.fa.fa-trash {
                background: linear-gradient(to right, #da8cff, #9a55ff) !important;
                padding: 10px 15px 10px 0px;
                color: #fff;
                border-radius: 10px;
                font-size: 15px;
                margin-left: 5px;
            }
            
            ul.multiselect-container.dropdown-menu.show {
                width: 100%;
            }
            
            .multiselect-native-select .btn-group {
                width: 100%;
            }
            
            button.multiselect.dropdown-toggle.btn.btn-default {
                outline: 1px solid #ebedf2;
                color: #c9c8c8;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 15px;
            }
            
            span.multiselect-selected-text {
                font-size: 12px;
                font-family: sans-serif;
            }
        </style>
    @endsection

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">@lang('Admin/backend.add_course') </h1>
                    <change>{{__('Admin/backend.in_english')}}</change>
                </div>

                @include('admin.include.alert')
                <div id="menu">
                    <ul class="lang text-right current_page_itemm">
                        <li class="current_page_item selected">
                            <a class="" href="#" onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li>
                            <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                                <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('admin.include.modals')
@endsection