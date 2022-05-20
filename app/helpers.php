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
    return Carbon\CarbonCarbon\Carbon::programEndDateExcludingLastWeekend($start_date, $weeks);
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

function toFixedNumber($num, $decimals = 2, $decimal_separator = '.', $thousands_separator = ',')
{
    return number_format((float)$num, $decimals, $decimal_separator, $thousands_separator);
}

if (!function_exists('getBranchesForBranchAdmin')) {
    function getBranchesForBranchAdmin() : array {
        return auth('branch_admin')->user()->branch;
    }
}

function getCourseApplicationPrintData($id)
{
    $course_booked_detail = \App\Models\UserCourseBookedDetails::with('course', 'User', 'userCourseBookedStatusus')->whereId($id)->firstOrFail();

    $program_age_ranges = \App\Models\SuperAdmin\Choose_Program_Age_Range::whereIn('unique_id', [$course_booked_detail->age_selected])->pluck('age')->toArray();
    $data['min_age'] = ''; $data['max_age'] = '';
    if (!empty($program_age_ranges) && count($program_age_ranges)) {
        $data['min_age'] = $program_age_ranges[0];
        $data['max_age'] = $program_age_ranges[count($program_age_ranges) - 1];
    }
    $program_under_age = \App\Models\SuperAdmin\Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');

    $data['course_booked_detail'] = $course_booked_detail;
    $data['program_start_date'] = Carbon\Carbon::create($course_booked_detail->start_date)->format('d-m-Y');
    $data['accommodation_start_date'] = $data['medical_start_date'] = Carbon\Carbon::create($course_booked_detail->start_date)->subDay()->format('d-m-Y');
    $data['program_end_date'] = Carbon\Carbon::create($course_booked_detail->end_date)->format('d-m-Y');
    $data['accommodation_end_date'] = Carbon\Carbon::create($data['accommodation_start_date'])->addWeeks($course_booked_detail->accommodation_duration)->subDay()->format('d-m-Y');
    $data['medical_end_date'] = Carbon\Carbon::create($data['medical_start_date'])->addWeeks($course_booked_detail->medical_duration ?? 0)->subDay()->format('d-m-Y');
    $data['school'] = \App\Models\SuperAdmin\School::find($course_booked_detail->school_id);
    $data['course'] = isset($course_booked_detail->course_id) ? \App\Models\SuperAdmin\Course::where('unique_id', $course_booked_detail->course_id)->first() : '';
    $data['program'] = isset($course_booked_detail->course_program_id) ? \App\Models\SuperAdmin\CourseProgram::where('unique_id', $course_booked_detail->course_program_id)->first() : null;
    $data['program_text_book_fee'] = isset($course_booked_detail->course_program_id) ? \App\Models\SuperAdmin\CourseProgramTextBookFee::where('course_program_id', $course_booked_detail->course_program_id)->
        where('text_book_start_date', '<=', $course_booked_detail->course_program_id)->where('text_book_end_date', '>=', $course_booked_detail->course_program_id)->first() : '';
    $data['program_under_age_fee'] = isset($course_booked_detail->course_program_id) ? \App\Models\SuperAdmin\CourseProgramUnderAgeFee::where('course_program_id', $course_booked_detail->course_program_id)->
        where('under_age', 'LIKE', '%' . $program_under_age . '%')->first() : '';
    $data['accommodation'] = isset($course_booked_detail->accommodation_id) ? \App\Models\SuperAdmin\CourseAccommodation::where('unique_id', '' . $course_booked_detail->accommodation_id)->first() : '';
    $data['airport'] = isset($course_booked_detail->airport_id) ? \App\Models\SuperAdmin\CourseAirport::where('unique_id', $course_booked_detail->airport_id)->first() : null;
    $data['medical'] = isset($course_booked_detail->medical_id) ? \App\Models\SuperAdmin\CourseMedical::where('unique_id', $course_booked_detail->medical_id)->first() : null;

    $age_ranges = $data['accommodation'] ? $data['accommodation']->age_range : [];
    $data['accommodation_min_age'] = ''; $data['accommodation_max_age'] = '';
    $accommodation_age_ranges = \App\Models\SuperAdmin\Choose_Accommodation_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
    if (!empty($accommodation_age_ranges) && count($accommodation_age_ranges)) {
        $accommodation_min_age = $accommodation_age_ranges[0];
        $accommodation_max_age = $accommodation_age_ranges[count($accommodation_age_ranges) - 1];
    }

    $default_currency = getDefaultCurrency();

    $program_total = $course_booked_detail->total_cost - $course_booked_detail->accommodation_total - $course_booked_detail->accommodation_special_diet_fee
            - $course_booked_detail->airport_pickup_fee - $course_booked_detail->medical_insurance_fee + $course_booked_detail->discount_fee + $course_booked_detail->accommodation_discount_fee;
    
    $amount_due = 0;
    if ($transaction = $course_booked_detail->transaction) {
        $amount_due += $transaction->amount - $course_booked_detail->total_cost;
    }
    $data['transaction_details'] = new \App\Classes\TransactionCalculator($course_booked_detail);
    
    $amount_refunded = 0;
    $data['transaction_refund'] = [];
    if ($course_booked_detail->transaction) {
        $data['transaction_refund'] = \App\Models\SuperAdmin\TransactionRefund::where('transaction_id', $course_booked_detail->transaction->order_id)->get();
        foreach ($data['transaction_refund'] as $all_refund) {
            $amount_refunded += $all_refund->amount_refunded;
        }
    }
    $amount_paid = ($course_booked_detail->transaction)->amount ?? $course_booked_detail->paid_amount + $data['transaction_details']->amountAdded() ?? 0;
    //$data['amount_due'] = $data['transaction_details']->amountDue($course_booked_detail->total_balance);
    $data['amount_due'] = $course_booked_detail->total_cost - $amount_paid + $amount_refunded;

    $calculator_values = getCurrencyConvertedValues($course_booked_detail->course_id,
        [
            $course_booked_detail->program_cost,
            $course_booked_detail->registration_fee,
            $course_booked_detail->text_book_fee,
            $course_booked_detail->summer_fees,
            $course_booked_detail->under_age_fees,
            $course_booked_detail->peak_time_fees,
            $course_booked_detail->courier_fee,
            $course_booked_detail->discount_fee,
            $program_total,
            $course_booked_detail->accommodation_fee,
            $course_booked_detail->accommodation_placement_fee,
            $course_booked_detail->accommodation_special_diet_fee,
            $course_booked_detail->accommodation_deposit_fee,
            $course_booked_detail->accommodation_summer_fee,
            $course_booked_detail->accommodation_christmas_fee,
            $course_booked_detail->accommodation_under_age_fee,
            $course_booked_detail->accommodation_custodian_fee,
            $course_booked_detail->accommodation_peak_fee,
            $course_booked_detail->accommodation_discount_fee,
            $course_booked_detail->accommodation_total,
            $course_booked_detail->airport_pickup_fee,
            $course_booked_detail->medical_insurance_fee,
            $course_booked_detail->total_discount,
            $course_booked_detail->sub_total,
            $course_booked_detail->total_cost,
            $course_booked_detail->deposit_price,
            $course_booked_detail->total_balance,
            $amount_paid,
            $amount_refunded,
            $amount_due,
        ]
    );
    $data['program_cost'] = [ 'value' => (float)$course_booked_detail->program_cost, 'converted_value' => $calculator_values['values'][0] ];
    $data['program_registration_fee'] = [ 'value' => (float)$course_booked_detail->registration_fee, 'converted_value' => $calculator_values['values'][1] ];
    $data['program_text_book_fee'] = [ 'value' => (float)$course_booked_detail->text_book_fee, 'converted_value' => $calculator_values['values'][2] ];
    $data['program_summer_fees'] = [ 'value' => (float)$course_booked_detail->summer_fee, 'converted_value' => $calculator_values['values'][3] ];
    $data['program_under_age_fees'] = [ 'value' => (float)$course_booked_detail->under_age_fee, 'converted_value' => $calculator_values['values'][4] ];
    $data['program_peak_time_fees'] = [ 'value' => (float)$course_booked_detail->peak_time_fee, 'converted_value' => $calculator_values['values'][5] ];
    $data['program_express_mail_fee'] = [ 'value' => (float)$course_booked_detail->courier_fee, 'converted_value' => $calculator_values['values'][6] ];
    $data['program_discount_fee'] = [ 'value' => (float)$course_booked_detail->discount_fee, 'converted_value' => $calculator_values['values'][7] ];
    $data['program_total'] = [ 'value' => (float)($program_total), 'converted_value' => $calculator_values['values'][8] ];
    $data['accommodation_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_fee), 'converted_value' => $calculator_values['values'][9] ];
    $data['accommodation_placement_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_placement_fee), 'converted_value' => $calculator_values['values'][10] ];
    $data['accommodation_special_diet_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_special_diet_fee), 'converted_value' => $calculator_values['values'][11] ];
    $data['accommodation_deposit_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_deposit_fee), 'converted_value' => $calculator_values['values'][12] ];
    $data['accommodation_summer_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_summer_fee), 'converted_value' => $calculator_values['values'][13] ];
    $data['accommodation_christmas_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_christmas_fee), 'converted_value' => $calculator_values['values'][14] ];
    $data['accommodation_under_age_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_under_age_fee), 'converted_value' => $calculator_values['values'][15] ];
    $data['accommodation_custodian_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_custodian_fee), 'converted_value' => $calculator_values['values'][16] ];
    $data['accommodation_peak_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_peak_fee), 'converted_value' => $calculator_values['values'][17] ];
    $data['accommodation_discount_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_discount_fee), 'converted_value' => $calculator_values['values'][18] ];
    $data['accommodation_total'] = [ 'value' => (float)($course_booked_detail->accommodation_total), 'converted_value' => $calculator_values['values'][19] ];
    $data['airport_pickup_fee'] = [ 'value' => (float)$course_booked_detail->airport_pickup_fee, 'converted_value' => $calculator_values['values'][20] ];
    $data['medical_insurance_fee'] = [ 'value' => (float)$course_booked_detail->medical_insurance_fee, 'converted_value' => $calculator_values['values'][21] ];
    $data['total_discount'] = [ 'value' => (float)$course_booked_detail->total_discount, 'converted_value' => $calculator_values['values'][22] ];
    $data['sub_total'] = [ 'value' => (float)$course_booked_detail->sub_total, 'converted_value' => $calculator_values['values'][23] ];
    $data['total_cost'] = [ 'value' => (float)$course_booked_detail->total_cost, 'converted_value' => $calculator_values['values'][24] ];
    $data['deposit_price'] = [ 'value' => (float)$course_booked_detail->deposit_price, 'converted_value' => $calculator_values['values'][25] ];
    $data['total_balance'] = [ 'value' => (float)$course_booked_detail->total_balance, 'converted_value' => $calculator_values['values'][26] ];
    $data['amount_paid'] = [ 'value' => (float)$amount_paid, 'converted_value' => $calculator_values['values'][27] ];
    $data['amount_refunded'] = [ 'value' => (float)$amount_refunded, 'converted_value' => $calculator_values['values'][28] ];
    $data['amount_due'] = [ 'value' => (float)$amount_due, 'converted_value' => $calculator_values['values'][29] ];
    $data['currency'] = [ 'cost' => $calculator_values['currency'], 'converted' => $default_currency['currency'] ];

    $data['today'] = Carbon\Carbon::now()->format('d-m-Y');

    $data['student_messages'] = \App\Models\SuperAdmin\SendMessageToStudentCourse::where('user_id', $course_booked_detail->user_id)->get();
    $data['user_school'] = null;
    $data['chat_messages'] = [];
    if ($course_booked_detail->course->school->userSchool != null) {
        $data['user_school'] = $course_booked_detail->course->school->userSchool;
        $data['chat_messages'] = \App\Models\SchoolAdmin\ReplyToSendSchoolMessage::where('user_id', $course_booked_detail->course->school->userSchool->user->id)->get();
    }

    return $data;
}
?>