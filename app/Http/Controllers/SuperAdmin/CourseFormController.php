<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\SuperAdmin\Choose_Accommodation_Age_Range;
use App\Models\SuperAdmin\Choose_Accommodation_Under_Age;
use App\Models\SuperAdmin\Choose_Custodian_Under_Age;
use App\Models\SuperAdmin\Choose_Language;
use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Type;
use App\Models\SuperAdmin\Choose_Program_Under_Age;
use App\Models\SuperAdmin\Choose_Start_Day;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\SuperAdmin\Choose_Study_Time;
use App\Models\SuperAdmin\Choose_Classes_Day;
use App\Models\SuperAdmin\Course;

use Illuminate\Http\Request;

class CourseFormController extends Controller
{
    public function addLanguage(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $LanguageEnTable = new Choose_Language;
            $LanguageEnTable->setTable('choose_languages_en');
            $LanguageEnTable->unique_id = $unique_id;
            $LanguageEnTable->name = $request->english_name;
            $LanguageEnTable->save();

            $LanguageArTable = new Choose_Language;
            $LanguageArTable->setTable('choose_languages_ar');
            $LanguageArTable->unique_id = $unique_id;
            $LanguageArTable->name = $request->arabic_name;
            $LanguageArTable->save();

            $get_data['id'] = get_language() == 'en' ? $LanguageEnTable->unique_id : $LanguageArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $LanguageEnTable->name : $LanguageArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteLanguage(Request $request)
    {
        $language_ids = $request->ids;
        $course_language_ids = [];
        $courses = Course::where('deleted', false)->get();
        foreach ($courses as $course) {
            $course_language_ids = array_unique(array_merge($course_language_ids, $course->language));
        }
        $language_ids = array_diff($language_ids, $course_language_ids);
        \DB::transaction(function () use ($language_ids) {
            $locale = get_language();
            Choose_Language::whereIn('unique_id', $language_ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Language::whereIn('unique_id', $language_ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $lang = Choose_Language::all();
        foreach ($lang as $langs):
            $data['result'] .= "<option value=$langs->unique_id>$langs->name</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');;
        return response($data);
    }

    public function addStudyMode(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $StudyModeEnTable = new Choose_Study_Mode;
            $StudyModeEnTable->setTable('choose_study_modes_en');
            $StudyModeEnTable->unique_id = $unique_id;
            $StudyModeEnTable->name = $request->english_val;
            $StudyModeEnTable->save();

            $StudyModeArTable = new Choose_Study_Mode;
            $StudyModeArTable->setTable('choose_study_modes_ar');
            $StudyModeArTable->unique_id = $unique_id;
            $StudyModeArTable->name = $request->arabic_val;
            $StudyModeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $StudyModeEnTable->unique_id : $StudyModeArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $StudyModeEnTable->name : $StudyModeArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteStudyMode(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Study_Mode::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Study_Mode::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $study_modes = Choose_Study_Mode::all();
        foreach ($study_modes as $study_mode) :
            $data['result'] .= "<option value=$study_mode->unique_id>$study_mode->name</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addProgramType(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $ProgramTypeEnTable = new Choose_Program_Type;
            $ProgramTypeEnTable->setTable('choose_program_types_en');
            $ProgramTypeEnTable->unique_id = $unique_id;
            $ProgramTypeEnTable->name = $request->english_val;
            $ProgramTypeEnTable->save();

            $ProgramTypeArTable = new Choose_Program_Type;
            $ProgramTypeArTable->setTable('choose_program_types_ar');
            $ProgramTypeArTable->unique_id = $unique_id;
            $ProgramTypeArTable->name = $request->arabic_val;
            $ProgramTypeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $ProgramTypeEnTable->unique_id : $ProgramTypeArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $ProgramTypeEnTable->name : $ProgramTypeArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteProgramType(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Program_Type::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Program_Type::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Program_Type::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->name</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addBranch(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $BranchEnTable = new Choose_Branch;
            $BranchEnTable->setTable('choose_branches_en');
            $BranchEnTable->unique_id = $unique_id;
            $BranchEnTable->name = $request->english_val;
            $BranchEnTable->save();

            $BranchArTable = new Choose_Branch;
            $BranchArTable->setTable('choose_branches_ar');
            $BranchArTable->unique_id = $unique_id;
            $BranchArTable->name = $request->arabic_val;
            $BranchArTable->save();

            $get_data['id'] = get_language() == 'en' ? $BranchEnTable->unique_id : $BranchArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $BranchEnTable->name : $BranchArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteBranch(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Branch::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Branch::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Branch::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->name</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addStudyTime(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $StudyTimeEnTable = new Choose_Study_Time();
            $StudyTimeEnTable->setTable('choose_study_times_en');
            $StudyTimeEnTable->unique_id = $unique_id;
            $StudyTimeEnTable->name = $request->english_val;
            $StudyTimeEnTable->save();

            $StudyTimeArTable = new Choose_Study_Time();
            $StudyTimeArTable->setTable('choose_study_times_ar');
            $StudyTimeArTable->unique_id = $unique_id;
            $StudyTimeArTable->name = $request->arabic_val;
            $StudyTimeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $StudyTimeEnTable->unique_id : $StudyTimeArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $StudyTimeEnTable->name : $StudyTimeArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteStudyTime(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Study_Time::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Study_Time::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Study_Time::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->name</option>";

        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addClassesDay(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $ClassesDayEnTable = new Choose_Classes_Day;
            $ClassesDayEnTable->setTable('choose_classes_days_en');
            $ClassesDayEnTable->unique_id = $unique_id;
            $ClassesDayEnTable->name = $request->english_val;
            $ClassesDayEnTable->save();

            $ClassesDayArTable = new Choose_Classes_Day;
            $ClassesDayArTable->setTable('choose_classes_days_ar');
            $ClassesDayArTable->unique_id = $unique_id;
            $ClassesDayArTable->name = $request->arabic_val;
            $ClassesDayArTable->save();

            $get_data['id'] = get_language() == 'en' ? $ClassesDayEnTable->unique_id : $ClassesDayArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $ClassesDayEnTable->name : $ClassesDayArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteClassesDay(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Classes_Day::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Classes_Day::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Classes_Day::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->name</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addStartDay(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $StartDayEnTable = new Choose_Start_Day;
            $StartDayEnTable->setTable('choose_start_days_en');
            $StartDayEnTable->unique_id = $unique_id;
            $StartDayEnTable->name = $request->english_val;
            $StartDayEnTable->save();

            $StartDayArTable = new Choose_Start_Day;
            $StartDayArTable->setTable('choose_start_days_ar');
            $StartDayArTable->unique_id = $unique_id;
            $StartDayArTable->name = $request->arabic_val;
            $StartDayArTable->save();

            $get_data['id'] = get_language() == 'en' ? $StartDayEnTable->unique_id : $StartDayArTable->unique_id;
            $get_data['name'] = get_language() == 'en' ? $StartDayEnTable->name : $StartDayArTable->name;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['name'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteStartDay(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Start_Day::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Start_Day::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Start_Day::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->name</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addProgramAgeRange(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $ProgramAgeRangeEnTable = new Choose_Program_Age_Range;
            $ProgramAgeRangeEnTable->setTable('choose_program_age_ranges_en');
            $ProgramAgeRangeEnTable->unique_id = $unique_id;
            $ProgramAgeRangeEnTable->age = $request->english_val;
            $ProgramAgeRangeEnTable->save();

            $ProgramAgeRangeArTable = new Choose_Program_Age_Range;
            $ProgramAgeRangeArTable->setTable('choose_program_age_ranges_ar');
            $ProgramAgeRangeArTable->unique_id = $unique_id;
            $ProgramAgeRangeArTable->age = $request->arabic_val;
            $ProgramAgeRangeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $ProgramAgeRangeEnTable->unique_id : $ProgramAgeRangeArTable->unique_id;
            $get_data['age'] = get_language() == 'en' ? $ProgramAgeRangeEnTable->age : $ProgramAgeRangeArTable->age;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['age'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteProgramAgeRange(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Program_Age_Range::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Program_Age_Range::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Program_Age_Range::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->age</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addProgramUnderAge(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $ProgramUnderAgeEnTable = new Choose_Program_Under_Age;
            $ProgramUnderAgeEnTable->setTable('choose_program_under_ages_en');
            $ProgramUnderAgeEnTable->unique_id = $unique_id;
            $ProgramUnderAgeEnTable->age = $request->english_val;
            $ProgramUnderAgeEnTable->save();

            $ProgramUnderAgeArTable = new Choose_Program_Under_Age;
            $ProgramUnderAgeArTable->setTable('choose_program_under_ages_ar');
            $ProgramUnderAgeArTable->unique_id = $unique_id;
            $ProgramUnderAgeArTable->age = $request->arabic_val;
            $ProgramUnderAgeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $ProgramUnderAgeEnTable->unique_id : $ProgramUnderAgeArTable->unique_id;
            $get_data['age'] = get_language() == 'en' ? $ProgramUnderAgeEnTable->age : $ProgramUnderAgeArTable->age;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['age'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteProgramUnderAge(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Program_Under_Age::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Program_Under_Age::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Program_Under_Age::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->age</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addAccommodationAgeRange(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $AccommodationAgeRangeEnTable = new Choose_Accommodation_Age_Range;
            $AccommodationAgeRangeEnTable->setTable('choose_accommodation_age_ranges_en');
            $AccommodationAgeRangeEnTable->unique_id = $unique_id;
            $AccommodationAgeRangeEnTable->age = $request->english_val;
            $AccommodationAgeRangeEnTable->save();

            $AccommodationAgeRangeArTable = new Choose_Accommodation_Age_Range;
            $AccommodationAgeRangeArTable->setTable('choose_accommodation_age_ranges_ar');
            $AccommodationAgeRangeArTable->unique_id = $unique_id;
            $AccommodationAgeRangeArTable->age = $request->arabic_val;
            $AccommodationAgeRangeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $AccommodationAgeRangeEnTable->unique_id : $AccommodationAgeRangeArTable->unique_id;
            $get_data['age'] = get_language() == 'en' ? $AccommodationAgeRangeEnTable->age : $AccommodationAgeRangeArTable->age;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['age'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteAccommodationAgeRange(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Accommodation_Age_Range::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Accommodation_Age_Range::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Accommodation_Age_Range::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->age</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addCustodianAgeRange(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $CustodianAgeRangeEnTable = new Choose_Custodian_Under_Age;
            $CustodianAgeRangeEnTable->setTable('choose_custodian_under_ages_en');
            $CustodianAgeRangeEnTable->unique_id = $unique_id;
            $CustodianAgeRangeEnTable->age = $request->english_val;
            $CustodianAgeRangeEnTable->save();

            $CustodianAgeRangeArTable = new Choose_Custodian_Under_Age;
            $CustodianAgeRangeArTable->setTable('choose_custodian_under_ages_ar');
            $CustodianAgeRangeArTable->unique_id = $unique_id;
            $CustodianAgeRangeArTable->age = $request->arabic_val;
            $CustodianAgeRangeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $CustodianAgeRangeEnTable->unique_id : $CustodianAgeRangeArTable->unique_id;
            $get_data['age'] = get_language() == 'en' ? $CustodianAgeRangeEnTable->age : $CustodianAgeRangeArTable->age;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['age'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteCustodianAgeRange(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Custodian_Under_Age::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Custodian_Under_Age::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Custodian_Under_Age::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->age</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }

    public function addAccommodationUnderAge(Request $request)
    {
        $unique_id = $this->my_unique_id();

        $get_id = \DB::transaction(function () use ($unique_id, $request) {
            $AccommodationUnderAgeEnTable = new Choose_Accommodation_Under_Age;
            $AccommodationUnderAgeEnTable->setTable('choose_accommodation_under_ages_en');
            $AccommodationUnderAgeEnTable->unique_id = $unique_id;
            $AccommodationUnderAgeEnTable->age = $request->english_val;
            $AccommodationUnderAgeEnTable->save();

            $AccommodationUnderAgeArTable = new Choose_Accommodation_Under_Age;
            $AccommodationUnderAgeArTable->setTable('choose_accommodation_under_ages_ar');
            $AccommodationUnderAgeArTable->unique_id = $unique_id;
            $AccommodationUnderAgeArTable->age = $request->arabic_val;
            $AccommodationUnderAgeArTable->save();

            $get_data['id'] = get_language() == 'en' ? $AccommodationUnderAgeEnTable->unique_id : $AccommodationUnderAgeArTable->unique_id;
            $get_data['age'] = get_language() == 'en' ? $AccommodationUnderAgeEnTable->age : $AccommodationUnderAgeArTable->age;
            return $get_data;
        });
        $this->my_unique_id(1);

        $data['data'] = __('SuperAdmin/backend.data_saved_successfully');

        $id = $get_id['id'];
        $opiton_name = $get_id['age'];
        $data['result'] = "<option value=$id>$opiton_name</option>";

        return response($data);
    }

    public function deleteAccommodationUnderAge(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $locale = get_language();
            Choose_Accommodation_Under_Age::whereIn('unique_id', $request->ids)->delete();
            $switch_locale = $locale == 'en' ? 'ar' : 'en';
            app()->setLocale($switch_locale);
            Choose_Accommodation_Under_Age::whereIn('unique_id', $request->ids)->delete();
            app()->setLocale($locale);
        });

        $data['result'] = '';
        $get_options = Choose_Accommodation_Under_Age::all();
        foreach ($get_options as $get_option) :
            $data['result'] .= "<option value=$get_option->unique_id>$get_option->age</option>";
        endforeach;

        $data['data'] = __('SuperAdmin/backend.data_removed_successfully');
        return response($data);
    }
}