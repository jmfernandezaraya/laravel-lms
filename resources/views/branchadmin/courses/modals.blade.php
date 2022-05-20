{{--All Modal Starts Here--}}

{{--Choose Program Type Modal--}}
<div class="modal fade" id="ProgramTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.name_in_english')</label>
                    <input type="name" class="form-control" id="program_type_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.name_in_arabic')</label>
                    <input type="name" class="form-control" id="program_type_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addProgramType($('#program_type_english').val(), $('#program_type_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>


{{--Choose Study Mode Modal--}}
<div class="modal fade" id="StudyTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.name_in_english')</label>
                    <input type="name" class="form-control" id="study_mode_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.name_in_arabic')</label>

                    <input type="name" class="form-control" id="study_mode_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addStudyTime($('#study_mode_english').val(), $('#study_mode_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

{{--Choose STartDay Mode Modal--}}
<div class="modal fade" id="StarDayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.name_in_english')</label>
                    <input type="name" class="form-control" id="start_day_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.name_in_arabic')</label>

                    <input type="name" class="form-control" id="start_day_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addStartDay($('#start_day_english').val(), $('#start_day_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Program Age Range Modal--}}
<div class="modal fade" id="ProgramAgeRangeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_english')</label>
                    <input type="number" class="form-control" id="program_age_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_arabic')</label>
                    <input type="number" class="form-control" id="program_age_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addProgramAgeRange($('#program_age_english').val(), $('#program_age_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Program Under Age Range Modal--}}
<div class="modal fade" id="ProgramUnderAgeModal" tabindex="-1" role="dialog" aria-labelledby="ProgramUnderAgeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProgramUnderAgeModalLabel">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_english')</label>
                    <input type="number" class="form-control" id="program_under_age_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_arabic')</label>
                    <input type="number" class="form-control" id="program_under_age_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addProgramUnderAgeRange($('#program_under_age_english').val(), $('#program_under_age_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Accommodation Age Range Modal--}}
<div class="modal fade" id="accomodationAgeRangeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_english')</label>
                    <input type="number" class="form-control" id="accom_age_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_arabic')</label>
                    <input type="number" class="form-control" id="accom_age_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="AddAccomAgeRange($('#accom_age_english').val(), $('#accom_age_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Accommodation Custodian Age Range Modal--}}
<div class="modal fade" id="custodianAgeRAngeAcoommodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_english')</label>
                    <input type="number" class="form-control" id="english_value" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_arabic')</label>

                    <input type="number" class="form-control" id="arabic_value" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="AddAccomCustodianAgeRange($(this).parent().parent().find('input[id=english_value]').val(), $(this).parent().parent().find('input[id=arabic_value]').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
                {{--onclick="AddAccomCustodianAgeRange($('#accom_age_english').val(), $('#accom_age_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>--}}
            </div>
        </div>
    </div>
</div>

{{--Choose Accommodation Under Age Range Modal--}}
<div class="modal fade" id="accomUnderAgeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel9">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_english')</label>
                    <input type="number" class="form-control" id="english_value" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_english')">
                    <br>
                    <label for="exampleInputname">@lang('SuperAdmin/backend.age_in_arabic')</label>
                    <input type="number" class="form-control" id="arabic_value" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.age_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="AddAccomUnderAgeRange($(this).parent().parent().find('input[id=english_value]').val(), $(this).parent().parent().find('input[id=arabic_value]').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
                {{--onclick="AddAccomCustodianAgeRange($('#accom_age_english').val(), $('#accom_age_arabic').val())" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>--}}
            </div>
        </div>
    </div>
</div>

<!-- Modal For Adding Language Starts-->
<div class="modal fade" id="LanguageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname"> @lang('SuperAdmin/backend.name_in_english') </label>
                    <input type="name" class="form-control" id="language_in_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_english')">
                </div>
                <div class="form-group">
                    <label for="exampleInputname"> @lang('SuperAdmin/backend.name_in_arabic') </label>
                    <input type="name" class="form-control" id="language_in_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button onclick="addLanguage($('#language_in_english').val(), $('#language_in_arabic').val())" type="button" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal For Adding Language Ends-->
<div class="modal fade" id="LanguageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">@lang('SuperAdmin/backend.add') </h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputname"> @lang('SuperAdmin/backend.name_in_english') </label>
                    <input type="name" class="form-control" id="language_in_english" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_english')">
                </div>
                <div class="form-group">
                    <label for="exampleInputname"> @lang('SuperAdmin/backend.name_in_arabic') </label>
                    <input type="name" class="form-control" id="language_in_arabic" aria-describedby="emailHelp" placeholder="@lang('SuperAdmin/backend.name_in_arabic')">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button onclick="addLanguage($('#language_in_english').val(), $('#language_in_arabic').val())" type="button" class="btn btn-primary">@lang('SuperAdmin/backend.submit')</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="apply_from_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('SuperAdmin/backend.apply_from_modal')</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_apply" method="post" action="{{route('superadmin.add_applying_from')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_english')</label>
                        <input type="text" name="apply_from_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_arabic')</label>
                        <input type="text" name="apply_from_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick  ="addApplyFrom($(this))">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="application_center_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="application_form" action = "{{route('superadmin.add_application_center')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_english')</label>
                        <input type="text" name="application_center_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_arabic')</label>
                        <input type="text" name="application_center_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addApplicationCenter($(this))">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal3 -->
<div class="modal fade" id="nationality_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id = 'add_nationailty_form' method="post" action = "{{route('superadmin.add_nationality')}}">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Modal title</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>@lang('SuperAdmin/backend.in_english')</label>
                    <input type="text" name="nationality_en" class="form-control">
                </div>
                <div class="form-group">
                    <label>@lang('SuperAdmin/backend.in_arabic')</label>
                    <input type="text" name="nationality_ar" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addNationality($(this))" >Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal4 -->
<div class="modal fade" id="to_travel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Modal title</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_travel"  action = "{{route('superadmin.add_travel')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_english')</label>
                        <input type="text" name="travel_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_arabic')</label>
                        <input type="text" name="travel_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addTravel($(this))">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal5 -->
<div class="modal fade" id="type_of_visa_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel5">Modal title</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="type_of_visa_form" action="{{route('superadmin.add_type_of_visa')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_english')</label>
                        <input type="text" name="visa_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>@lang('SuperAdmin/backend.in_arabic')</label>
                        <input type="text" name="visa_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="addTypeOfVisa($(this))" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modal5-end-->

{{-- Visa Create modal --}}
<div class="modal fade" id="formsaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('superadmin.visa.store')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('SuperAdmin/backend.save_form_name')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="">{{__('SuperAdmin/backend.save_form_name')}}</label>
                        <input type="text" class="form-control" name="form_name">
                    </div>
                    <div class="form-group">
                        <label class="">@lang('SuperAdmin/backend.visa_form.select_visa_form_id')</label>
                        <select name="visa_id" class="form-control" id="visa_form_id_modal">
                            <option value="">@lang('SuperAdmin/backend.select_option')</option>
                            @foreach(\App\Models\SuperAdmin\VisaForm::all() as $applyform)
                                <option value="{{$applyform->id}}">{{$applyform->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-info">Close</button>
                    <input type="hidden" id="getvalue" name="formvalue">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--All Modal Ends Here--}}



