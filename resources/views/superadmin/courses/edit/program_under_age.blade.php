@extends('superadmin.layouts.app')
@section('content')
    @include('superadmin.courses.scripts')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.add_under_age_fee_text_book_fee')}}</h1>
                    <change>
                        @if(app()->getLocale() == 'en')
                            {{__('SuperAdmin/backend.in_english')}}
                        @endif
                        @if(app()->getLocale() == 'ar')
                            {{__('SuperAdmin/backend.in_arabic')}}
                        @endif
                    </change>
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

                <form class="forms-sample" method="POST" action="{{route("superadmin.course.update", $course_id)}}" id="courseform">
                    {{csrf_field()}}
                    @method('PUT')
                    <div class="first-form">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{__('SuperAdmin/backend.select_program_id')}}</label>
                                <select onchange="fetchProgramUnderAge(this.value)" class="form-control" name="program_id[]" style="width:100%">
                                    @foreach ($program_under_age_fees_with_text_books as $program_under_age_fee_with_text_book)
                                        <option {{$program_under_age_fee_with_text_book_first->course_program_id == $program_under_age_fee_with_text_book->course_program_id ? 'selected' : ''}} value="{{$program_under_age_fee_with_text_book->course_program_id}}">{{$program_under_age_fee_with_text_book->course_program_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4"></div>
                            <div class="form-group col-md-4"></div>
                        </div>
                        
                        <input name="underagefeeincrement" id="underagefeeincrement" value="{{$under_age_fees ? $under_age_fees->count() - 1 : 0}}" hidden>
                        @forelse ($under_age_fees as $under_age_fee)
                            <div id="under_age_fee_clone0" class="under-age-fee-clone clone">
                                <input type="hidden" value="{{$under_age_fee->id}}" name="age_id[]">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.under_age_fee')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">{{__('SuperAdmin/backend.age_range')}}: 
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramUnderAgeModal" aria-hidden="true"></i>
                                            <i class="fa fa-trash pl-3" onclick="deleteProgramUnderAgeRange()" aria-hidden="true"></i>
                                        </label>
                                        <select name="under_age[{{$loop->iteration - 1}}][]" id="program_under_age_range_choose0" multiple="multiple" class="3col active">
                                            @foreach($program_under_ages as $program_under_age)
                                                <option {{in_array($program_under_age->unique_id, (array)$under_age_fee->under_age ?? [])  ? 'selected' : ''}} value="{{$under_age_fee->unique_id}}">{{$under_age_fee->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 mt-4">
                                        <label>{{__('SuperAdmin/backend.fees_week')}}:</label>
                                        <input value="{{$under_age_fee->underage_fee_per_week}}" class="form-control" type="number" name="under_age_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.fees_week')}}">
                                    </div>

                                    <div class="form-group col-md-2 mt-4 pt-3">
                                        <i class="fa fa-plus-circle" onclick="addProgramUnderAgeFee($(this))" aria-hidden="true"></i>
                                        <i class="fa fa-minus" aria-hidden="true" onclick="removeProgramUnderAgeFee($(this))"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="under_age_fee_clone0" class="under-age-fee-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.under_age_fee')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">{{__('SuperAdmin/backend.age_range')}}: 
                                            <i class="fa fa-plus pl-3" data-toggle="modal" data-target="#ProgramUnderAgeModal" aria-hidden="true"></i>
                                            <i class="fa fa-trash pl-3" onclick="deleteProgramUnderAgeRange()" aria-hidden="true"></i>
                                        </label>
                                        <select name="under_age[0][]" id="program_under_age_range_choose0" multiple="multiple" class="3col active">
                                            @foreach($program_under_ages as $program_under_age)
                                                <option value="{{$program_under_age->unique_id}}">{{$program_under_age->age}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 mt-4">
                                        <label>{{__('SuperAdmin/backend.fees_week')}}:</label>
                                        <input class="form-control" type="number" name="under_age_fee_per_week[]" placeholder="{{__('SuperAdmin/backend.fees_week')}}">
                                    </div>

                                    <div class="form-group col-md-2 mt-4 pt-3">
                                        <i class="fa fa-plus-circle" onclick="addProgramUnderAgeFee($(this))" aria-hidden="true"></i>
                                        <i class="fa fa-minus" aria-hidden="true" onclick="removeProgramUnderAgeFee($(this))"></i>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                        

                        <input name="textbookfeeincrement" id="textbookfeeincrement" value="{{$text_book_fees ? $text_book_fees->count() - 1 : 0}}" hidden>
                        @forelse ($text_book_fees as $text_book_fee)
                            <div id="text_book_fee_clone0" class="text-book-fee-clone clone">
                                <input type="hidden" name="textbook_id[]" value="{{$text_book_fee->id}}">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.text_book_fee')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.fee')}}:</label>
                                        <input value="{{$text_book_fee->text_book_fee}}" class="form-control" type="number" name="text_book_fee[]" placeholder="{{__('SuperAdmin/backend.fee')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input value="{{$text_book_fee->text_book_start_date}}" class="form-control" type="number" name="text_book_fee_start_date[]" placeholder="{{__('SuperAdmin/backend.start_date')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input value="{{$text_book_fee->text_book_end_date}}" class="form-control" type="number" name="text_book_fee_end_date[]" placeholder="{{__('SuperAdmin/backend.end_date')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.note')}}: </label>
                                        <textarea class="form-control" id="text_book_fee_note0" name="text_book_note[]" placeholder="{{__('SuperAdmin/backend.note')}}">{!! get_language() == 'en' ?  $text_book_fee->text_book_note_en :  $text_book_fee->text_book_note_ar !!}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addTextBookFee($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus"  type="button" onclick="removeTextBookFee($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="text_book_fee_clone0" class="text-book-fee-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label><h3>{{__('SuperAdmin/backend.text_book_fee')}}</h3></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('SuperAdmin/backend.fee')}}:</label>
                                        <input class="form-control" type="number" name="text_book_fee[]" placeholder="{{__('SuperAdmin/backend.fee')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.start_date')}}:</label>
                                        <input class="form-control" type="number" name="text_book_fee_start_date[]" placeholder="{{__('SuperAdmin/backend.start_date')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('SuperAdmin/backend.end_date')}}:</label>
                                        <input class="form-control" type="number" name="text_book_fee_end_date[]" placeholder="{{__('SuperAdmin/backend.end_date')}}">
                                    </div>
                                </div>                            

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('SuperAdmin/backend.note')}}: </label>
                                        <textarea class="form-control" id="text_book_fee_note0" name="text_book_note[]" placeholder="{{__('SuperAdmin/backend.note')}}"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addTextBookFee($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus"  type="button" onclick="removeTextBookFee($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($accomodations)
                        <a type="button" href="{{route('superadmin.course.accommodation.edit')}}" class="btn btn-primary pull-right">@lang('SuperAdmin/backend.next')</a>
                    @endif
                    <button type="button" onclick="getProgramTextBookContents(); submitCourseProgramForm($(this))" class="btn btn-primary pull-left">{{__('SuperAdmin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.courses.modals')
    <script>
        function fetchProgramUnderAge(value) {
            $.post("{{route('superadmin.course.program_under_age.fetch')}}", {_token:"{{csrf_token()}}", value:value}, function (data) {
                window.location.replace(data.url);
            });
        }
    </script>
@endsection