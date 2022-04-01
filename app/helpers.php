<?php

/**
 * @return string
 */
function get_language()
{
    return app()->getLocale();
}

/**
 * @param $value
 * @return mixed
 */
function readCalculationFromDB($value)
{
    $data = \App\Models\Calculator::whereCalcId(request()->ip())->first();

    return $data->$value;
}

/**
 * @param $index
 * @param $value
 */
function insertCalculationIntoDB($index, $value)
{
    // Read File
    $calculator = \App\Models\Calculator::whereCalcId(request()->ip())->first();
    $calculator->$index = $value;
    $calculator->save();
}

/**
 * @return mixed
 */
function reloadInsertCalculationIntoDB()
{
    $calculator = \App\Models\Calculator::where('calc_id', request()->ip())->first();

    $inpu['total'] = 0;
    $inpu['program_cost'] = 0;
    $inpu['fixed_program_cost'] = 0;
    $inpu['program_registration_fee'] = 0;

    $inpu['text_book_fee'] = 0;
    $inpu['summer_fee'] = 0;
    $inpu['under_age_fee'] = 0;
    $inpu['peak_time_fee'] = 0;
    $inpu['courier_fee'] = 0;
    $inpu['discount_fee'] = 0;

    $inpu['accommodation_fee'] = 0;
    $inpu['accommodation_placement_fee'] = 0;
    $inpu['accommodation_special_diet_fee'] = 0;
    $inpu['accommodation_deposit'] = 0;
    $inpu['accommodation_custodian_fee'] = 0;
    $inpu['accommodation_summer_fee'] = 0;
    $inpu['accommodation_christmas_fee'] = 0;
    $inpu['accommodation_under_age_fee'] = 0;
    $inpu['accommodation_discount'] = 0;
    $inpu['accommodation_peak_time_fee'] = 0;
    $inpu['accommodation_total'] = 0;

    $inpu['airport_pickup_fee'] = 0;
    $inpu['medical_insurance_fee'] = 0;
    $inpu['airport_total'] = 0;
    $inpu['total'] = 0;

    return $calculator->fill($inpu)->save();
}

/**
 * @return mixed
 */
function getCourseUniqueId()
{
    return \App\Models\SuperAdmin\CourseProgram::whereCourseUniqueId(\Session::get('course_unique_id'))->first()['course_unique_id'];
}

/**
 * @param $data
 * @param string $filename
 */
function debugErrorsByJsonFile($data, $filename = 'request.json')
{
    file_put_contents('test_folder/' . $filename, json_encode($data, JSON_PRETTY_PRINT));
}

/**
 * @param $course_id
 * @param $total
 * @param null $which
 * @return mixed
 */
function getCurrencyDetails($course_id, $total, $which = null)
{
    $currency_converted = (new \App\Classes\FrontendCalculator())->CurrencyConverted($course_id, $total);
    if ($which == 'price') {
        $return = $currency_converted['price'];
    } elseif ($which == 'both') {
        $return['price'] = $currency_converted['price'];
        $return['currency'] = $currency_converted['currency'];
    } else {
        $return = $currency_converted['currency'];
    }

    return $return;
}

/**
 * @param $course_id
 * @param $values
 * @param null $which
 * @return mixed
 */
function getDefaultCurrency()
{
    $default_currency = (new \App\Classes\FrontendCalculator())->GetDefaultCurrency();

    return $default_currency;
}

/**
 * @param $course_id
 * @param $values
 * @param null $which
 * @return mixed
 */
function getCurrencyConvertedValues($course_id, $values)
{
    $currency_values = (new \App\Classes\FrontendCalculator())->CurrencyConvertedValues($course_id, $values);

    return $currency_values;
}

/**
 * @param $start_date
 * @param $weeks
 * @return mixed
 */
function programEndDateExcludingLastWeekend($start_date, $weeks)
{
    return \Carbon\Carbon::programEndDateExcludingLastWeekend($start_date, $weeks);
}

function getCourseAgeRanges($course_id)
{
    $course_programs = \App\Models\SuperAdmin\CourseProgram::where('course_unique_id', $course_id)->get();

    $age_range_ids = [];
    foreach($course_programs as $course_program) {
        $age_range_ids = array_unique(array_merge($age_range_ids, $course_program->program_age_range));
    }
    $age_ranges = \App\Models\SuperAdmin\Choose_Program_Age_Range::whereIn('unique_id', $age_range_ids)->pluck('age')->toArray();
    sort($age_ranges); 
    return $age_ranges;
}

function getCourseMinMaxAgeRange($course_id)
{
    $course_programs = \App\Models\SuperAdmin\CourseProgram::where('course_unique_id', $course_id)->get();

    $age_range_ids = [];
    foreach($course_programs as $course_program) {
        $age_range_ids = array_unique(array_merge($age_range_ids, $course_program->program_age_range));
    }
    $age_ranges = \App\Models\SuperAdmin\Choose_Program_Age_Range::whereIn('unique_id', $age_range_ids)->pluck('age')->toArray();
    sort($age_ranges); 
    return [
        'min' => min($age_ranges),
        'max' => max($age_ranges)
    ];
}

function getCourseLanguageNames($course_language_ids)
{
    $course_languages = \App\Models\SuperAdmin\Choose_Language::whereIn('unique_id', $course_language_ids ? (is_array($course_language_ids) ? $course_language_ids : [$course_language_ids]) : [])->pluck('name')->toArray();
    return $course_languages;
}

function getCourseProgramTypeNames($course_program_type_ids)
{
    $course_program_types = \App\Models\SuperAdmin\Choose_Program_Type::whereIn('unique_id', $course_program_type_ids ? (is_array($course_program_type_ids) ? $course_program_type_ids : [$course_program_type_ids]) : [])->pluck('name')->toArray();
    return $course_program_types;
}

function getCourseStudyModeNames($course_study_mode_ids)
{
    $course_study_modes = \App\Models\SuperAdmin\Choose_Study_Mode::whereIn('unique_id', $course_study_mode_ids ? (is_array($course_study_mode_ids) ? $course_study_mode_ids : [$course_study_mode_ids]) : [])->pluck('name')->toArray();
    return $course_study_modes;
}

function getCourseBranchNames($course_branch_ids)
{
    $course_branches = \App\Models\SuperAdmin\Choose_Branch::whereIn('unique_id', $course_branch_ids ? (is_array($course_branch_ids) ? $course_branch_ids : [$course_branch_ids]) : [])->pluck('name')->toArray();
    return $course_branches;
}

function getCourseStudyTimeNames($course_study_time_ids)
{
    $course_study_times = \App\Models\SuperAdmin\Choose_Study_Time::whereIn('unique_id', $course_study_time_ids ? (is_array($course_study_time_ids) ? $course_study_time_ids : [$course_study_time_ids]) : [])->pluck('name')->toArray();
    return $course_study_times;
}

function getCourseStartDateNames($course_start_date_ids)
{
    $course_start_dates = \App\Models\SuperAdmin\Choose_Start_Day::whereIn('unique_id', $course_start_date_ids ? (is_array($course_start_date_ids) ? $course_start_date_ids : [$course_start_date_ids]) : [])->pluck('name')->toArray();
    return $course_start_dates;
}

if (!function_exists('getBranchesForBranchAdmin')) {
    function getBranchesForBranchAdmin() : array {
        return auth('branch_admin')->user()->branch;
    }
}
?>