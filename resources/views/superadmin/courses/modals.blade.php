{{--All Modal Starts Here--}}

{{--Choose Adding Language Modal--}}
<div class="modal fade" id="LanguageModal" tabindex="-1" role="dialog" aria-labelledby="LanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="LanguageModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="language_in_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="language_in_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="language_in_arabic">{{__('SuperAdmin/backend.name_in_arabic')}}</label>
                    <input type="name" class="form-control" id="language_in_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button onclick="addLanguage($('#language_in_english').val(), $('#language_in_arabic').val())" type="button" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Study Mode modal--}}
<div class="modal fade" id="StudyModeModal" tabindex="-1" role="dialog" aria-labelledby="StudyModeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="StudyModeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="study_mode_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="study_mode_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="study_mode_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="study_mode_arabic">{{__('SuperAdmin/backend.name_in_arabic')}}</label>
                    <input type="name" class="form-control" id="study_mode_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button onclick="addStudyMode($('#study_mode_english').val(), $('#study_mode_arabic').val())" type="button" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Program Type Modal--}}
<div class="modal fade" id="ProgramTypeModal" tabindex="-1" role="dialog" aria-labelledby="ProgramTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProgramTypeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="program_type_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="program_type_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="program_type_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="program_type_arabic">{{__('SuperAdmin/backend.name_in_arabic')}}</label>
                    <input type="name" class="form-control" id="program_type_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addProgramType($('#program_type_english').val(), $('#program_type_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Adding Branch Modal--}}
<div class="modal fade" id="BranchModal" tabindex="-1" role="dialog" aria-labelledby="BranchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="BranchModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="language_choose" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="language_in_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="language_in_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="language_in_arabic">{{__('SuperAdmin/backend.name_in_arabic')}}</label>
                    <input type="name" class="form-control" id="language_in_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button onclick="addBranch($('#language_in_english').val(), $('#language_in_arabic').val())" type="button" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Study Time Modal--}}
<div class="modal fade" id="StudyTimeModal" tabindex="-1" role="dialog" aria-labelledby="StudyTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="StudyTimeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="study_time_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="study_time_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="study_time_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="study_time_arabic">{{__('SuperAdmin/backend.name_in_arabic')</label>
                    <input type="name" class="form-control" id="study_time_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addStudyTime($('#study_time_english').val(), $('#study_time_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Classes Day Modal--}}
<div class="modal fade" id="ClassesDayModal" tabindex="-1" role="dialog" aria-labelledby="ClassesDayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ClassesDayModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="classes_day_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="classes_day_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="classes_day_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="classes_day_arabic">{{__('SuperAdmin/backend.name_in_arabic')}}</label>
                    <input type="name" class="form-control" id="classes_day_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addClassesDay($('#classes_day_english').val(), $('#classes_day_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Start Date Mode Modal--}}
<div class="modal fade" id="StartDateModal" tabindex="-1" role="dialog" aria-labelledby="StartDateModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="StartDateModalTitle">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="start_date_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="start_date_english">{{__('SuperAdmin/backend.name_in_english')}}</label>
                    <input type="name" class="form-control" id="start_date_english" placeholder="{{__('SuperAdmin/backend.name_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="start_date_arabic">{{__('SuperAdmin/backend.name_in_arabic')}}</label>
                    <input type="name" class="form-control" id="start_date_arabic" placeholder="{{__('SuperAdmin/backend.name_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addStartDate($('#start_date_english').val(), $('#start_date_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Program Age Range Modal--}}
<div class="modal fade" id="ProgramAgeRangeModal" tabindex="-1" role="dialog" aria-labelledby="ProgramAgeRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProgramAgeRangeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="program_age_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="program_age_english">{{__('SuperAdmin/backend.age_in_english')}}</label>
                    <input type="number" class="form-control" id="program_age_english" placeholder="{{__('SuperAdmin/backend.age_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="program_age_arabic">{{__('SuperAdmin/backend.age_in_arabic')}}</label>
                    <input type="number" class="form-control" id="program_age_arabic" placeholder="{{__('SuperAdmin/backend.age_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addProgramAgeRange($('#program_age_english').val(), $('#program_age_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Program Under Age Range Modal--}}
<div class="modal fade" id="ProgramUnderAgeModal" tabindex="-1" role="dialog" aria-labelledby="ProgramUnderAgeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProgramUnderAgeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="program_under_age_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="program_under_age_english">{{__('SuperAdmin/backend.age_in_english')}}</label>
                    <input type="number" class="form-control" id="program_under_age_english" placeholder="{{__('SuperAdmin/backend.age_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="program_under_age_arabic">{{__('SuperAdmin/backend.age_in_arabic')</label>
                    <input type="number" class="form-control" id="program_under_age_arabic" placeholder="{{__('SuperAdmin/backend.age_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addProgramUnderAgeRange($('#program_under_age_english').val(), $('#program_under_age_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Accommodation Age Range Modal--}}
<div class="modal fade" id="AccommodationAgeRangeModal" tabindex="-1" role="dialog" aria-labelledby="AccommodationAgeRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccommodationAgeRangeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="accom_age_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="accom_age_english">{{__('SuperAdmin/backend.age_in_english')}}</label>
                    <input type="number" class="form-control" id="accom_age_english" placeholder="{{__('SuperAdmin/backend.age_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="accom_age_arabic">{{__('SuperAdmin/backend.age_in_arabic')}}</label>
                    <input type="number" class="form-control" id="accom_age_arabic" placeholder="{{__('SuperAdmin/backend.age_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addAccommAgeRange($('#accom_age_english').val(), $('#accom_age_arabic').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Accommodation Custodian Age Range Modal--}}
<div class="modal fade" id="CustodianAgeRangeAcoomModal" tabindex="-1" role="dialog" aria-labelledby="CustodianAgeRangeAcoomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CustodianAgeRangeAcoomModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="custodian_age_range_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="custodian_age_range_english">{{__('SuperAdmin/backend.age_in_english')}}</label>
                    <input type="number" class="form-control" id="custodian_age_range_english" placeholder="{{__('SuperAdmin/backend.age_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="custodian_age_range_arabic">{{__('SuperAdmin/backend.age_in_arabic')}}</label>
                    <input type="number" class="form-control" id="custodian_age_range_arabic" placeholder="{{__('SuperAdmin/backend.age_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addAccommCustodianAgeRange($(this).parent().parent().find('input[id=custodian_age_range_english]').val(), $(this).parent().parent().find('input[id=custodian_age_range_arabic]').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Accommodation Under Age Range Modal--}}
<div class="modal fade" id="AccomUnderAgeModal" tabindex="-1" role="dialog" aria-labelledby="AccomUnderAgeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccomUnderAgeModalLabel">{{__('SuperAdmin/backend.add')}}</h5>
                <button type="button" id="accom_under_age_close" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="accom_under_age_english">{{__('SuperAdmin/backend.age_in_english')}}</label>
                    <input type="number" class="form-control" id="accom_under_age_english" placeholder="{{__('SuperAdmin/backend.age_in_english')}}">
                </div>
                <div class="form-group">
                    <label for="accom_under_age_arabic">{{__('SuperAdmin/backend.age_in_arabic')}}</label>
                    <input type="number" class="form-control" id="accom_under_age_arabic" placeholder="{{__('SuperAdmin/backend.age_in_arabic')}}">
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" onclick="addAccommUnderAgeRange($(this).parent().parent().find('input[id=accom_under_age_english]').val(), $(this).parent().parent().find('input[id=accom_under_age_arabic]').val())" class="btn btn-primary">{{__('SuperAdmin/backend.submit')}}</button>
            </div>
        </div>
    </div>
</div>

{{--Choose Apply From Modal--}}
<div class="modal fade" id="ApplyFromModal" tabindex="-1" role="dialog" aria-labelledby="ApplyFromModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ApplyFromModalLabel">{{__('SuperAdmin/backend.apply_from_modal')}}</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_apply" method = "post" action  = "{{route('superadmin.add_applying_from')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_english')}}</label>
                        <input type="text" name="apply_from_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_arabic')}}</label>
                        <input type="text" name="apply_from_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('SuperAdmin/backend.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="addApplyFrom($(this))">{{__('SuperAdmin/backend.save_changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="application_center_modal" tabindex="-1" role="dialog" aria-labelledby="ApplicationFromModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ApplicationFromModalLabel">{{__('SuperAdmin/backend.application_center')}}</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method = "post" id="application_form" action="{{route('superadmin.add_application_center')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_english')}}</label>
                        <input type="text" name="application_center_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_arabic')}}</label>
                        <input type="text" name="application_center_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('SuperAdmin/backend.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="addApplicationCenter($(this))">{{__('SuperAdmin/backend.save_changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="nationality_modal" tabindex="-1" role="dialog" aria-labelledby="NationalityFromModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id = 'add_nationailty_form' method="post" action="{{route('superadmin.add_nationality')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="NationalityFromModalLabel">{{__('SuperAdmin/backend.nationality')}}</h5>
                    <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_english')}}</label>
                        <input type="text" name="nationality_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_arabic')}}</label>
                        <input type="text" name="nationality_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('SuperAdmin/backend.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="addNationality($(this))">{{__('SuperAdmin/backend.save_changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="to_travel_modal" tabindex="-1" role="dialog" aria-labelledby="ToTravelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ToTravelModalLabel">{{__('SuperAdmin/backend.to_travel')}}</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_travel" action="{{route('superadmin.add_travel')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_english')}}</label>
                        <input type="text" name="travel_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_arabic')}}</label>
                        <input type="text" name="travel_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('SuperAdmin/backend.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="addTravel($(this))">{{__('SuperAdmin/backend.save_changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="type_of_visa_modal" tabindex="-1" role="dialog" aria-labelledby="TypeVisaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TypeVisaModalLabel">{{__('SuperAdmin/backend.type_of_visa')}}</h5>
                <button type="button" id="close_this" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="type_of_visa_form" action="{{route('superadmin.add_type_of_visa')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_english')}}</label>
                        <input type="text" name="visa_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__('SuperAdmin/backend.in_arabic')}}</label>
                        <input type="text" name="visa_ar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('SuperAdmin/backend.close')}}</button>
                    <button type="button" onclick="addTypeOfVisa($(this))" class="btn btn-primary">{{__('SuperAdmin/backend.save_changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Visa Create modal --}}
<div class="modal fade" id="formsaveModal" tabindex="-1" role="dialog" aria-labelledby="VisaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('superadmin.visa.store')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="VisaModalLabel">{{__('SuperAdmin/backend.save_form_name')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{__('SuperAdmin/backend.close')}}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="">{{__('SuperAdmin/backend.save_form_name')}}</label>
                        <input type="text" class="form-control" name="form_name">
                    </div>
                    <div class="form-group">
                        <label class="">{{__('SuperAdmin/backend.visa_form.select_visa_form_id')}}</label>
                        <select name="visa_id" class="form-control" id="visa_form_id_modal">
                            <option value="">{{__('SuperAdmin/backend.select_option')}}</option>
                            @foreach(\App\Models\SuperAdmin\VisaForm::all() as $applyform)
                                <option value="{{$applyform->id}}">{{$applyform->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-info">{{__('SuperAdmin/backend.close')}}</button>
                    <input type="hidden" id="getvalue" name="formvalue">
                    <button type="submit" class="btn btn-success">{{__('SuperAdmin/backend.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--All Modal Ends Here--}}