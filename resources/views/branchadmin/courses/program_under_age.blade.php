@extends('branchadmin.layouts.app')
@section('content')
@section('css')
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
@include('superadmin.courses.scripts')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div style="text-align: center;">
                <h4 class="card-title">@lang('SuperAdmin/backend.add_under_age_fee_text_book_fee')</h4>
                <change>{{__('SuperAdmin/backend.in_english')}}</change>
            </div>

            @include('superadmin.include.alert')
            <div id="menu">
                <ul class="lang text-right current_page_itemm">
                    <li class="current_page_item selected">
                        <a class="" href="#" onclick="changeLanguage('english', 'arabic')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="changeLanguage('arabic', 'english')"; fillForm('form1', 'form2')">
                            <img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}
                        </a>
                    </li>
                </ul>
            </div>

            <div id="show_form"></div>

            <form class="forms-sample" method="POST" action="{{route(" superadmin.course.store ")}}" id="courseform">
                {{csrf_field()}}
                <div class="first-form">
                    <label>@lang('SuperAdmin/backend.select_program_id')</label>
                    <br>
                    <select class="3col active" name="program_id[]" style="width:100%" multiple="multiple">
                        @if(\Session::has('program_id'))
                            @foreach (\App\Models\SuperAdmin\CourseProgram::whereIn('unique_id', \Session::get('program_unique_id'))->get() as $programs)
                                <option value="{{$programs->unique_id}}">{{$programs->unique_id}}</option>
                            @endforeach
                        @endif
                    </select>
                    <br>

                    <div class="clonoe0">
                        <div class="" id="clone_under_age0">
                            <div class="row">
                                <input name="clone_under_age_increment[]" id="clone_under_age_increment" value='1' hidden>
                                <div class="col-md-4">
                                    <label for="">{{__('SuperAdmin/backend.under_age_fee_per_week')}}:<i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramUnderAgeModal" aria-hidden="true"></i><i class="fa fa-trash pl-3" onclick="deleteProgramUnderAgeRange()" aria-hidden="true"></i></label>
                                    <select name="program_under_age[age][0][]" id="program_under_age_range_choose0" multiple="multiple" class="3col active">
                                        @foreach(\App\Models\SuperAdmin\Choose_Program_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all() as $option)
                                            <option value="{{$option->age}}">{{$option->age}}</option>
                                        @endforeach
                                    </select>
                                    <input hidden name="under_age_program_increment" value=1 id="under_age_program_increment">
                                </div>

                                <div class="col-md-4 pt-3">
                                    <label>@lang('SuperAdmin/backend.fees_week'):</label>
                                    <div id="put_fees_here0">
                                        <input class="form-control" type="text" name="fees_under_age[]" placeholder="Fees/Week" id="fees_under_age0">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-4 pt-3">
                                    <i class="fa fa-plus-circle" onclick="addProgramUnderAge($(this))" data-id='0' aria-hidden="true" id="program_under_age_add"></i>
                                    <i class="fa fa-minus" aria-hidden="true" onclick="removeProgramUnderAge($(this))" id="program_under_age_remove0"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="clone_program_text_book_fee0">
                        <div class="col-md-4">
                            <label>@lang('SuperAdmin/backend.text_book_fee'):</label>
                            <input class="form-control" type="text" name="text_book_fee[]" placeholder="Text book fee">
                        </div>
                        <div class="col-md-3">
                            <input id="textbookfeeincrement" value=1 hidden name="textbookfeeincrement[]">
                            <label>@lang('SuperAdmin/backend.text_book_start_date'):</label>
                            <input class="form-control" type="text" name="text_book_fee_start_date[]" placeholder="{{__('SuperAdmin/backend.weeks')}}">
                        </div>
                        <div class="col-md-3">
                            <label>@lang('SuperAdmin/backend.text_book_end_date'):</label>
                            <input class="form-control" type="text" name="text_book_fee_end_date[]" placeholder="{{__('SuperAdmin/backend.weeks')}}">
                            <!--program summer fee end-->
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            <i class="fa fa-minus" aria-hidden="true" onclick="removeTextBookFee($(this))"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Text-book-note : </label>
                            <textarea class="form-control" id="text_book_note" placeholder="Text book note"></textarea>
                        </div>
                    </div>
                    <br><br>
                    <input hidden value="" name="text_book_note" id="text_book_note_value">
                    <input hidden name="program_increment" value=1 id="increment_program">
                </div>
                <br>
                <br>

                <script>
                    course_url_store = "{{route('superadmin.course.store')}}";
                </script>
                <a type="button" href="{{route('add_accommodation_page')}}" class="btn btn-primary pull-right">@lang('SuperAdmin/backend.next')
                </a>
                <button type="button" onclick="getContent('text_book_note', 'text_book_note_value'); submitCourseProgramForm($(this))" class="btn btn-primary pull-left">Submit</button>
            </form>
        </div>
    </div>
</div>

@include('superadmin.courses.modals')
@endsection