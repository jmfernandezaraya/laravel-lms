@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_under_age_fee_text_book_fee')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_under_age_fee_text_book_fee')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                <div id="menu">
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ auth('superadmin')->check() ? route('superadmin.course.store') : route('schooladmin.course.store') }}" id="courseform" data-mode="create">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>{{__('Admin/backend.select_program_id')}}</label>
                            <select class="3col active" name="program_id[]" multiple="multiple">
                                @foreach ($course_programs as $course_program)
                                    <option value="{{$course_program->unique_id}}">{{$course_program->unique_id}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4"></div>
                        <div class="form-group col-md-4"></div>
                    </div>

                    <input name="underagefeeincrement" id="underagefeeincrement" value="0" hidden>
                    <div id="under_age_fee_clone0" class="under-age-fee-clone clone">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label><h3>{{__('Admin/backend.under_age_fee')}}</h3></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 under_age">
                                <label for="">{{__('Admin/backend.age_range')}}:</label>
                                <select name="under_age[0][]" id="program_under_age_range_choose0" multiple="multiple" class="3col active">
                                    @foreach($choose_program_under_ages as $choose_program_under_age)
                                        <option value="{{$choose_program_under_age->unique_id}}">{{$choose_program_under_age->age}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>{{__('Admin/backend.fees_week')}}:</label>
                                <input class="form-control" type="number" name="under_age_fee_per_week[]" placeholder="{{__('Admin/backend.fees_week')}}">
                            </div>

                            <div class="form-group col-md-2 mt-3 pt-1">
                                <i class="fa fa-plus-circle" onclick="addProgramUnderAgeFee($(this))" aria-hidden="true"></i>
                                <i class="fa fa-minus" aria-hidden="true" onclick="removeProgramUnderAgeFee($(this))"></i>
                            </div>
                        </div>
                    </div>

                    <input name="textbookfeeincrement" id="textbookfeeincrement" value="0" hidden>
                    <div id="text_book_fee_clone0" class="text-book-fee-clone clone">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label><h3>{{__('Admin/backend.text_book_fee')}}</h3></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.fee')}}:</label>
                                <input class="form-control" type="number" name="text_book_fee[]" placeholder="{{__('Admin/backend.fee')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.start_date')}}:</label>
                                <input class="form-control" type="number" name="text_book_fee_start_date[]" placeholder="{{__('Admin/backend.start_date')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.end_date')}}:</label>
                                <input class="form-control" type="number" name="text_book_fee_end_date[]" placeholder="{{__('Admin/backend.end_date')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('Admin/backend.fee_type')}}:</label>
                                <select class="form-control" name="text_book_fee_type[]">
                                    <option value="fixed_cost" selected>{{__('Admin/backend.fixed_cost')}}</option>
                                    <option value="cost_per_week">{{__('Admin/backend.per_week')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary fa fa-plus" type="button" onclick="addTextBookFee($(this))"></button>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-danger fa fa-minus" type="button" onclick="removeTextBookFee($(this))"></button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>{{__('Admin/backend.note')}}:</label>
                            <div class="english">
                                <textarea class="form-control ckeditor-input" name="text_book_note" placeholder="{{__('Admin/backend.note')}}" id="text_book_note"></textarea>
                            </div>
                            <div class="arabic">
                                <textarea class="form-control ckeditor-input" name="text_book_note_ar" placeholder="{{__('Admin/backend.note')}}" id="text_book_note_ar"></textarea>
                            </div>
                        </div>
                    </div>

                    @if($has_accommodation)
                        @if($course_id)
                            <a type="button" href="{{ auth('superadmin')->check() ? route('superadmin.course.accommodation.edit') : route('schooladmin.course.accommodation.edit') }}" class="btn btn-primary pull-right">{{__('Admin/backend.next')}}</a>
                        @else
                            <a type="button" href="{{ auth('superadmin')->check() ? route('superadmin.course.accommodation') : route('schooladmin.course.accommodation') }}" class="btn btn-primary pull-right">{{__('Admin/backend.next')}}</a>
                        @endif
                    @endif
                    <button type="button" onclick="submitCourseProgramForm($(this))" class="btn btn-primary pull-left">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>

    @include('admin.include.modals')

    @section('js')
        <script>
            var uploadFileOption = "{{ auth('superadmin')->check() ? route('superadmin.course.upload', ['_token' => csrf_token() ]) : route('schooladmin.course.upload', ['_token' => csrf_token() ]) }}";
        </script>
    @endsection
@endsection