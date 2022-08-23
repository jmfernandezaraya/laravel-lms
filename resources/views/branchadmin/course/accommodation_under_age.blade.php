@extends('branchadmin.layouts.app')
@section('content')
@section('css')
<style>
    .pl-3:hover {
        cursor: pointer;
    }
    
    .multiselect-container {
        overflow: auto;
        max-height: 200px;
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

@include('admin.course.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h1>@lang('Admin/backend.add_accommodation_under_age') </h1>
                <change>{{__('Admin/backend.in_english')}}</change>
            </div>

            @include('common.include.alert')
            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}
                        </a>
                    </li>
                </ul>
            </div>

            <div id="show_form"></div>

            <form class="forms-sample" method="POST" action="{{route(" admin.course.store ")}}" id="courseform">
                {{csrf_field()}}
                <div class="first-form">
                    <div class="form-group">
                        <label>@lang('Admin/backend.accommodation_id') </label>
                        <br>
                        <select class="3col active" name="accom_id[]" style="width:100%" multiple="multiple">
                            @if(\Session::has('accom_ids'))
                                @foreach (\App\Models\SuperAdmin\Accommodation::whereIn('unique_id', \Session::get('accom_ids'))->get() as $programs)
                                    <option value="{{$programs->unique_id}}">{{$programs->unique_id}}</option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        <div class='accomoe0'>
                            <div class="row" id="accom_under_age_clone0">
                                <div class="col-md-4 mt-3">
                                    <label for="under_age_fee">{{__('Admin/backend.under_age_fee_per_week')}}:
                                        <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#AccomUnderAgeModal" aria-hidden="true"></i><i onclick="DeleteAccomUnderAgeRange()" class="fa fa-trash pl-3" aria-hidden="true"></i>
                                    </label>
                                    <select name="under_age[age][0][]" id="under_age_choose0" multiple="multiple" class="3col active">
                                        @foreach(\App\Models\SuperAdmin\ChooseAccommodationUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all() as $option)
                                            <option value="{{$option->age}}">{{$option->age}}</option>
                                        @endforeach
                                    </select>
                                    <input id="accom_increment" name="accom_increment" hidden value='1'>
                                </div>
                                <div class="col-md-4 mt-4 pt-3">
                                    <label>@lang('Admin/backend.add_week'):</label>
                                    <input class="form-control" type="text" name="under_age_fee_per_week[]" placeholder="@lang('Admin/backend.add_week')">
                                </div>
                                <div class="col-md-4 mt-4 pt-3">
                                    <i class="fa fa-plus-circle" aria-hidden="true" id="accom_plus_button" data-id="0" onclick="addAccommodationFormUnderAge($(this))"></i>
                                    <i class="fa fa-minus" onclick="deleteAccommodationFormUnderAge($(this))" aria-hidden="true"></i>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="button" onclick="submitAccommodationUnderAgeForm($(this))" name="####">{{__('Admin/backend.submit')}}</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('other_service')}}" class="btn btn-primary pull-right" type="button" name="####">{{__('Admin/backend.next')}}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.course.modals')
@endsection