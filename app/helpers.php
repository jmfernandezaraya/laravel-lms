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

/*
*
* @param start_date
* @param end_date
* @param compare_with_which date
*
*
* @return boolean (true or false)
* */
function checkBetweenDate($start, $end, $compare_with)
{
    if ($start == null || $end == null) {
        return  false;
    }
    $startDate = Carbon\Carbon::createFromFormat('Y-m-d', $start)->format('d-m-Y');
    $endDate = Carbon\Carbon::createFromFormat('Y-m-d', $end)->format('d-m-Y');

    $check = Carbon\Carbon::create($compare_with)->between($startDate, $endDate);
    return $check ? true : false;
}

function compareBetweenTwoDates($date1, $date2)
{
    $first = Carbon\Carbon::createFromFormat('Y-m-d', $date1);
    $second = Carbon\Carbon::createFromFormat('Y-m-d', $date2);

    return $first->diffInWeeks($second);
}

/**
 * @param $date
 * @param $weeks
 * @return string
 */
function getEndDate($date, $weeks)
{
    return Carbon\Carbon::create($date)->addWeeks($weeks)->format('Y-m-d');
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
 * @return mixed
 */
function getDefaultCurrency()
{
    $default_currency = (new \App\Classes\FrontendCalculator())->GetDefaultCurrency();

    return $default_currency;
}

/**
 * @return mixed
 */
function getGetDefaultCurrencyName()
{
    $default_currency_name = (new \App\Classes\FrontendCalculator())->GetDefaultCurrencyName();

    return $default_currency_name;
}

/**
 * @param $country_id
 * @param null $which
 * @return mixed
 */
function getSchoolCountryName($country_id)
{
    $country = \App\Models\Country::where('id', $country_id)->first();
    if ($country) {
        if (app()->getLocale() == 'en') {
            return $country->name;
        } else {
            return $country->name_ar;
        }
    }
    return '';
}

function getSchoolTopReviewCourseApplications($school_id, $count = 3) {
    $top_course_applications = [];
    $school_course_applications = \App\Models\CourseApplication::with('review')->where('school_id', $school_id)->get();
    foreach ($school_course_applications as $school_course_application) {
        if ($school_course_application->review) {
            $top_course_applications[] = $school_course_application;
        }
    }
    usort($top_course_applications, function($first, $second) {
        return ($first->review->quality_teaching + $first->review->school_facilities + $first->review->social_activities + $first->review->school_location + $first->review->satisfied_teaching + $first->review->level_cleanliness + $first->review->distance_accommodation_school + $first->review->satisfied_accommodation + $first->review->airport_transfer + $first->review->city_activities)
             < ($second->review->quality_teaching + $second->review->school_facilities + $second->review->social_activities + $second->review->school_location + $second->review->satisfied_teaching + $second->review->level_cleanliness + $second->review->distance_accommodation_school + $second->review->satisfied_accommodation + $second->review->airport_transfer + $second->review->city_activities);
    });

    return array_slice($top_course_applications, 0, $count);
}

function getSchoolRating($school_id) {
    $school_ratings = 0;
    $school_rating_count = 0;
    $school_course_applications = \App\Models\CourseApplication::with('review')->where('school_id', $school_id)->get();
    if ($school_course_applications) {
        foreach ($school_course_applications as $course_application) {
            if ($course_application->review) {
                $school_ratings = ($course_application->review->quality_teaching + $course_application->review->school_facilities + $course_application->review->social_activities + 
                    $course_application->review->school_location + $course_application->review->satisfied_teaching + $course_application->review->level_cleanliness + 
                    $course_application->review->distance_accommodation_school + $course_application->review->satisfied_accommodation + $course_application->review->airport_transfer + 
                    $course_application->review->city_activities) / 10;
                $school_rating_count += 1;
            }
        }
    }

    return $school_ratings;
}

function getCourseRating($course_id) {
    $course_ratings = 0;
    $course_rating_count = 0;
    $course_course_applications = \App\Models\CourseApplication::with('review')->where('course_id', $course_id)->get();
    if ($course_course_applications) {
        foreach ($course_course_applications as $course_application) {
            if ($course_application->review) {
                $course_ratings = ($course_application->review->quality_teaching + $course_application->review->school_facilities + $course_application->review->social_activities + 
                    $course_application->review->school_location + $course_application->review->satisfied_teaching + $course_application->review->level_cleanliness + 
                    $course_application->review->distance_accommodation_school + $course_application->review->satisfied_accommodation + $course_application->review->airport_transfer + 
                    $course_application->review->city_activities) / 10;
                $course_rating_count += 1;
            }
        }
    }

    return $course_ratings;
}

/**
 * @param $course_id
 * @param $values
 * @param null $which
 * @return mixed
 */
function getDiscountedValue($price, $discount)
{
    $discounted_price = $price;
    $discounts = explode(" ", $discount);
    if (count($discounts) >= 2) {
        if ($discounts[1] == '%') {
            $discounted_price = $price - $price * (float)$discounts[0] / 100;
        } else {
            $discounted_price = $price - (float)$discounts[0];
        }
    }
    return $discounted_price;
}

/**
 * @param $course_id
 * @param $value
 * @param null $which
 * @return mixed
 */
function getCurrencyConverted($course_id, $value)
{
    $currency_value = (new \App\Classes\FrontendCalculator())->CurrencyConverted($course_id, $value);

    return $currency_value;
}

/**
 * @param $course_id
 * @param $value
 * @param null $which
 * @return mixed
 */
function getCurrencyConvertedValue($course_id, $value)
{
    $currency_value = (new \App\Classes\FrontendCalculator())->CurrencyConvertedValue($course_id, $value);

    return $currency_value;
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
 * @param $program_age_range
 * @param null $which
 * @return mixed
 */
function getCourseProgramAgeRange($program_age_range)
{
    $age_ranges = is_array($program_age_range) ? $program_age_range : [];
    $min_age = ''; $max_age = '';
    $program_age_ranges = \App\Models\SuperAdmin\Choose_Program_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
    if (!empty($program_age_ranges) && count($program_age_ranges)) {
        $min_age = $program_age_ranges[0];
        $max_age = $program_age_ranges[count($program_age_ranges) - 1];
    }
    return [
        'min_age' => $min_age,
        'max_age' => $max_age,
    ];
}

/**
 * @param $program_age_range
 * @param null $which
 * @return mixed
 */
function getCourseAccommodationAgeRange($course_accommodation_age_range)
{
    $age_ranges = is_array($course_accommodation_age_range) ? $course_accommodation_age_range : [];
    $min_age = ''; $max_age = '';
    $course_accommodation_age_ranges = \App\Models\SuperAdmin\Choose_Accommodation_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
    if (!empty($course_accommodation_age_ranges) && count($course_accommodation_age_ranges)) {
        $min_age = $course_accommodation_age_ranges[0];
        $max_age = $course_accommodation_age_ranges[count($course_accommodation_age_ranges) - 1];
    }
    return [
        'min_age' => $min_age,
        'max_age' => $max_age,
    ];
}

/**
 * @param $program_age_range
 * @param null $which
 * @return mixed
 */
function getCourseCustodianAgeRange($course_custodian_age_range)
{
    $age_ranges = is_array($course_custodian_age_range) ? $course_custodian_age_range : [];
    $min_age = ''; $max_age = '';
    $course_custodian_age_ranges = \App\Models\SuperAdmin\Choose_Custodian_Under_Age::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
    if (!empty($course_custodian_age_ranges) && count($course_custodian_age_ranges)) {
        $min_age = $course_custodian_age_ranges[0];
        $max_age = $course_custodian_age_ranges[count($course_custodian_age_ranges) - 1];
    }
    return [
        'min_age' => $min_age,
        'max_age' => $max_age,
    ];
}

function getStorageImages($path, $filename)
{
    return asset("storage/app/public/" . $path . '/' . $filename);
}

function getHeaderLogo()
{
    $header_logo = [];
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (isset($content['header']['logo'])) {
            $header_logo = $content['header']['logo'];
        }
    }

    return $header_logo;
}

function getHeaderMenu()
{
    $header_menu = [];
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (isset($content['header']['menu'])) {
            $header_menu = $content['header']['menu'];
        }
    }

    return $header_menu;
}

function getFooterLogo()
{
    $footer_logo = [];
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (isset($content['footer']['logo'])) {
            $footer_logo = $content['footer']['logo'];
        }
    }

    return $footer_logo;
}

function getFooterMenu()
{
    $footer_menu = [];
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (isset($content['footer']['menu'])) {
            $footer_menu = $content['footer']['menu'];
        }
    }

    return $footer_menu;
}

function getFooterDescription()
{
    $footer_description = '';
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (app()->getLocale() == 'en') {
            if (isset($content['footer']['description'])) {
                $footer_description = $content['footer']['description'];
            }
        } else {
            if (isset($content['footer']['description_ar'])) {
                $footer_description = $content['footer']['description_ar'];
            }
        }
    }

    return $footer_description;
}

function getFooterCopyright()
{
    $footer_copyright = '';
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (app()->getLocale() == 'en') {
            if (isset($content['footer']['description'])) {
                $footer_copyright = $content['footer']['copyright'];
            }
        } else {
            if (isset($content['footer']['description_ar'])) {
                $footer_copyright = $content['footer']['copyright_ar'];
            }
        }
    }

    return $footer_copyright;
}

function getFooterCredits()
{
    $footer_credits = '';
    $header_footer = \App\Models\Setting::where('setting_key', 'header_footer')->first();
    if ($header_footer) {
        $content = unserialize($header_footer->setting_value);
        if (app()->getLocale() == 'en') {
            if (isset($content['footer']['description'])) {
                $footer_credits = $content['footer']['credits'];
            }
        } else {
            if (isset($content['footer']['description_ar'])) {
                $footer_credits = $content['footer']['credits_ar'];
            }
        }
    }

    return $footer_credits;
}

function getSiteEmail()
{
    $site_email = '';
    $site = \App\Models\Setting::where('setting_key', 'site')->first();
    if ($site) {
        $content = unserialize($site->setting_value);
        if (isset($content['email'])) {
            $site_email = $content['email'];
        }
    }

    return $site_email;
}

function getSitePhone()
{
    $site_phone = '';
    $site = \App\Models\Setting::where('setting_key', 'site')->first();
    if ($site) {
        $content = unserialize($site->setting_value);
        if (isset($content['phone'])) {
            $site_phone = $content['phone'];
        }
    }

    return $site_phone;
}

function getRegistrationCancelationConditions()
{
    $site_registration_cancelation_conditions = '';
    $site = \App\Models\Setting::where('setting_key', 'site')->first();
    if ($site) {
        $content = unserialize($site->setting_value);
        if (isset($content['registration_cancelation_conditions'])) {
            $front_page = \App\Models\FrontPage::where('id', $content['registration_cancelation_conditions'])->first();
            if (app()->getLocale() == 'en') {
                $site_registration_cancelation_conditions = $front_page->content;
            } else {
                $site_registration_cancelation_conditions = $front_page->content_ar;
            }
        }
    }

    return $site_registration_cancelation_conditions;
}

function getSiteNewsletter()
{
    $site_newsletter = [
        'title' => '',
        'description' => ''
    ];
    $site = \App\Models\Setting::where('setting_key', 'site')->first();
    if ($site) {
        $content = unserialize($site->setting_value);
        if (app()->getLocale() == 'en') {
            if (isset($content['newsletter'])) {
                $site_newsletter['title'] = $content['newsletter']['title'];
                $site_newsletter['description'] = $content['newsletter']['description'];
            }
        } else {
            if (isset($content['newsletter'])) {
                $site_newsletter['title'] = $content['newsletter']['title_ar'];
                $site_newsletter['description'] = $content['newsletter']['description_ar'];
            }
        }
    }

    return $site_newsletter;
}

function getSocials()
{
    $socials = [];
    $site = \App\Models\Setting::where('setting_key', 'site')->first();
    if ($site) {
        $content = unserialize($site->setting_value);
        if (isset($content['social'])) {
            $socials = $content['social'];
        }
    }

    return $socials;
}

function getPageUrl($id)
{
    $front_page_url = '';
    $front_page = \App\Models\FrontPage::where('id', $id)->first();
    if ($front_page) {
        $front_page_url = $front_page->slug;
        if ($front_page_url && $front_page_url[0] != '/') {
            $front_page_url = '/' . $front_page_url;
        }
    }

    return $front_page_url;
}

function getPageTitle($id)
{
    $front_page_title = '';
    $front_page = \App\Models\FrontPage::where('id', $id)->first();
    if ($front_page) {
        if (app()->getLocale() == 'en') {
            $front_page_title = $front_page->title;
        } else {
            $front_page_title = $front_page->title_ar;
        }
    }

    return $front_page_title;
}

/**
 * @param $start_date
 * @param $weeks
 * @return mixed
 */
function programEndDateExcludingLastWeekend($start_date, $weeks)
{
    return Carbon\Carbon::programEndDateExcludingLastWeekend($start_date, $weeks);
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


function checkCoursePromotion($course_id)
{
    $now = Carbon\Carbon::now()->format('Y-m-d');
    $course = \App\Models\SuperAdmin\Course::with('coursePrograms')->where('unique_id', '' . $course_id)->first();
    if ($course) {
        foreach ($course->coursePrograms as $course_program) {
            $course_program_discount = false;
            if ($course_program->discount_per_week != ' -' && $course_program->discount_per_week != ' %') {
                if (checkBetweenDate($course_program->discount_start_date, $course_program->discount_end_date, $now)) {
                    $course_program_discount = true;
                }
                if ($course_program->x_week_selected && checkBetweenDate($course_program->x_week_start_date, $course_program->x_week_end_date, $now)) {
                    $course_program_x_week_discount = true;
                }
            }
            if ($course_program_discount) {
                return true;
            }
        }
    }
    return false;
}

function checkCourseProgramPromotion($course_program_id)
{
    $now = Carbon\Carbon::now()->format('Y-m-d');
    $course_program = \App\Models\SuperAdmin\CourseProgram::where('unique_id', $course_program_id)->first();
    if ($course_program) {
        if ($course_program->discount_per_week != ' -' && $course_program->discount_per_week != ' %') {
            if (($course_program->discount_start_date <= $now && $course_program->discount_end_date >= $now) ||
                ($course_program->x_week_selected && $course_program->x_week_start_date <= $now && $course_program->x_week_end_date >= $now)) {
                return true;
            }
        }
    }
    return false;
}

function generateRandomString($length)
{    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $character_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $character_length - 1)];
    }
    return $random_string;
}

function generateOrderId()
{
    return 'linkforsa-' . generateRandomString(4) . '-' . generateRandomString(4) . '-' . generateRandomString(4) . '-' . generateRandomString(12) . '-' . generateRandomString(10);
}

function getCourseApplicationPrintData($id, $user_id, $is_admin = false)
{
    $course_application = \App\Models\CourseApplication::with('course', 'User', 'courseApplicationStatusus')->whereId($id)->firstOrFail();

    $program_age_ranges = \App\Models\SuperAdmin\Choose_Program_Age_Range::whereIn('unique_id', [$course_application->age_selected])->pluck('age')->toArray();
    $data['min_age'] = ''; $data['max_age'] = '';
    if (!empty($program_age_ranges) && count($program_age_ranges)) {
        $data['min_age'] = $program_age_ranges[0];
        $data['max_age'] = $program_age_ranges[count($program_age_ranges) - 1];
    }
    $program_under_age = \App\Models\SuperAdmin\Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');

    $data['course_application'] = $course_application;
    $data['program_start_date'] = Carbon\Carbon::create($course_application->start_date)->format('d-m-Y');
    $data['accommodation_start_date'] = $data['medical_start_date'] = Carbon\Carbon::create($course_application->start_date)->subDay()->format('d-m-Y');
    $data['program_end_date'] = Carbon\Carbon::create($course_application->end_date)->format('d-m-Y');
    $data['accommodation_end_date'] = Carbon\Carbon::create($data['accommodation_start_date'])->addWeeks($course_application->accommodation_duration)->subDay()->format('d-m-Y');
    $data['medical_end_date'] = Carbon\Carbon::create($data['medical_start_date'])->addWeeks($course_application->medical_duration ?? 0)->subDay()->format('d-m-Y');
    $data['school'] = \App\Models\SuperAdmin\School::find($course_application->school_id);
    $data['course'] = isset($course_application->course_id) ? \App\Models\SuperAdmin\Course::where('unique_id', $course_application->course_id)->first() : null;
    $data['program'] = isset($course_application->course_program_id) ? \App\Models\SuperAdmin\CourseProgram::where('unique_id', $course_application->course_program_id)->first() : null;
    $data['program_text_book_fee'] = isset($course_application->course_program_id) ? \App\Models\SuperAdmin\CourseProgramTextBookFee::where('course_program_id', $course_application->course_program_id)->
        where('text_book_start_date', '<=', $course_application->course_program_id)->where('text_book_end_date', '>=', $course_application->course_program_id)->first() : null;
    $data['program_under_age_fee'] = isset($course_application->course_program_id) ? \App\Models\SuperAdmin\CourseProgramUnderAgeFee::where('course_program_id', $course_application->course_program_id)->
        where('under_age', 'LIKE', '%' . $program_under_age . '%')->first() : null;
    $data['accommodation'] = isset($course_application->accommodation_id) ? \App\Models\SuperAdmin\CourseAccommodation::where('unique_id', '' . $course_application->accommodation_id)->first() : null;
    $age_ranges = $data['accommodation'] ? $data['accommodation']->age_range : [];
    $data['accommodation_min_age'] = ''; $data['accommodation_max_age'] = '';
    $accommodation_age_ranges = \App\Models\SuperAdmin\Choose_Accommodation_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
    if (!empty($accommodation_age_ranges) && count($accommodation_age_ranges)) {
        $data['accommodation_min_age'] = $accommodation_age_ranges[0];
        $data['accommodation_max_age'] = $accommodation_age_ranges[count($accommodation_age_ranges) - 1];
    }
    $data['airport'] = isset($course_application->airport_id) ? \App\Models\SuperAdmin\CourseAirport::where('unique_id', $course_application->airport_id)->first() : null;
    $data['airport_provider'] = $data['airport'] ? (app()->getLocale() == 'en' ? $data['airport']->service_provider : $data['airport']->service_provider_ar) : '';
    $airport_fee = isset($course_application->airport_fee_id) ? \App\Models\SuperAdmin\CourseAirportFee::where('unique_id', $course_application->airport_fee_id)->first() : null;
    $data['airport_name'] = $airport_fee ? (app()->getLocale() == 'en' ? $airport_fee->name : $airport_fee->name_ar) : '';
    $data['airport_service'] = $airport_fee ? (app()->getLocale() == 'en' ? $airport_fee->service_name : $airport_fee->service_name_ar) : '';
    $data['medical'] = isset($course_application->medical_id) ? \App\Models\SuperAdmin\CourseMedical::where('unique_id', $course_application->medical_id)->first() : null;
    $data['company_name'] = $data['medical'] ? (app()->getLocale() == 'en' ? $data['medical']->company_name : $data['medical']->company_name_ar) : '';
    $data['custodian'] = isset($course_application->custodian_id) ? \App\Models\SuperAdmin\CourseCustodian::where('unique_id', $course_application->medical_id)->first() : null;

    $default_currency = getDefaultCurrency();

    $program_total = $course_application->total_cost - $course_application->accommodation_total - $course_application->accommodation_special_diet_fee
            - $course_application->airport_pickup_fee - $course_application->medical_insurance_fee + $course_application->discount_fee + $course_application->accommodation_discount_fee;

    $calculator_values = getCurrencyConvertedValues($course_application->course_id,
        [
            $course_application->program_cost,
            $course_application->registration_fee,
            $course_application->text_book_fee,
            $course_application->summer_fees,
            $course_application->under_age_fees,
            $course_application->peak_time_fees,
            $course_application->courier_fee,
            $course_application->discount_fee,
            $program_total,
            $course_application->accommodation_fee,
            $course_application->accommodation_placement_fee,
            $course_application->accommodation_special_diet_fee,
            $course_application->accommodation_deposit_fee,
            $course_application->accommodation_summer_fee,
            $course_application->accommodation_christmas_fee,
            $course_application->accommodation_under_age_fee,
            $course_application->accommodation_peak_fee,
            $course_application->accommodation_discount_fee,
            $course_application->accommodation_total,
            $course_application->airport_pickup_fee,
            $course_application->medical_insurance_fee,
            $course_application->custodian_fee,
            $course_application->sub_total,
            $course_application->total_discount,
            $course_application->total_cost,
            $course_application->deposit_price,
            $course_application->total_balance
        ]
    );
    $data['program_cost'] = [ 'value' => (float)$course_application->program_cost, 'converted_value' => $calculator_values['values'][0] ];
    $data['program_registration_fee'] = [ 'value' => (float)$course_application->registration_fee, 'converted_value' => $calculator_values['values'][1] ];
    $data['program_text_book_fee'] = [ 'value' => (float)$course_application->text_book_fee, 'converted_value' => $calculator_values['values'][2] ];
    $data['program_summer_fees'] = [ 'value' => (float)$course_application->summer_fee, 'converted_value' => $calculator_values['values'][3] ];
    $data['program_under_age_fees'] = [ 'value' => (float)$course_application->under_age_fee, 'converted_value' => $calculator_values['values'][4] ];
    $data['program_peak_time_fees'] = [ 'value' => (float)$course_application->peak_time_fee, 'converted_value' => $calculator_values['values'][5] ];
    $data['program_express_mail_fee'] = [ 'value' => (float)$course_application->courier_fee, 'converted_value' => $calculator_values['values'][6] ];
    $data['program_discount_fee'] = [ 'value' => (float)$course_application->discount_fee, 'converted_value' => $calculator_values['values'][7] ];
    $data['program_total'] = [ 'value' => (float)($program_total), 'converted_value' => $calculator_values['values'][8] ];
    $data['accommodation_fee'] = [ 'value' => (float)($course_application->accommodation_fee), 'converted_value' => $calculator_values['values'][9] ];
    $data['accommodation_placement_fee'] = [ 'value' => (float)($course_application->accommodation_placement_fee), 'converted_value' => $calculator_values['values'][10] ];
    $data['accommodation_special_diet_fee'] = [ 'value' => (float)($course_application->accommodation_special_diet_fee), 'converted_value' => $calculator_values['values'][11] ];
    $data['accommodation_deposit_fee'] = [ 'value' => (float)($course_application->accommodation_deposit_fee), 'converted_value' => $calculator_values['values'][12] ];
    $data['accommodation_summer_fee'] = [ 'value' => (float)($course_application->accommodation_summer_fee), 'converted_value' => $calculator_values['values'][13] ];
    $data['accommodation_christmas_fee'] = [ 'value' => (float)($course_application->accommodation_christmas_fee), 'converted_value' => $calculator_values['values'][14] ];
    $data['accommodation_under_age_fee'] = [ 'value' => (float)($course_application->accommodation_under_age_fee), 'converted_value' => $calculator_values['values'][15] ];
    $data['accommodation_peak_fee'] = [ 'value' => (float)($course_application->accommodation_peak_fee), 'converted_value' => $calculator_values['values'][16] ];
    $data['accommodation_discount_fee'] = [ 'value' => (float)($course_application->accommodation_discount_fee), 'converted_value' => $calculator_values['values'][17] ];
    $data['accommodation_total'] = [ 'value' => (float)($course_application->accommodation_total), 'converted_value' => $calculator_values['values'][18] ];
    $data['airport_pickup_fee'] = [ 'value' => (float)$course_application->airport_pickup_fee, 'converted_value' => $calculator_values['values'][19] ];
    $data['medical_insurance_fee'] = [ 'value' => (float)$course_application->medical_insurance_fee, 'converted_value' => $calculator_values['values'][20] ];
    $data['custodian_fee'] = [ 'value' => (float)($course_application->custodian_fee), 'converted_value' => $calculator_values['values'][21] ];
    $data['sub_total'] = [ 'value' => (float)$course_application->sub_total, 'converted_value' => $calculator_values['values'][22] ];
    $data['total_discount'] = [ 'value' => (float)$course_application->total_discount, 'converted_value' => $calculator_values['values'][23] ];
    $data['total_cost'] = [ 'value' => (float)$course_application->total_cost, 'converted_value' => $calculator_values['values'][24] ];
    $data['deposit_price'] = [ 'value' => (float)$course_application->deposit_price, 'converted_value' => $calculator_values['values'][25] ];
    $data['total_balance'] = [ 'value' => (float)$course_application->total_balance, 'converted_value' => $calculator_values['values'][26] ];
    
    $amount_added = 0;
    $amount_refunded = 0;
    $data['transaction_refunds'] = [];
    if ($course_application->transaction) {
        $data['transaction_refunds'] = \App\Models\SuperAdmin\TransactionRefund::where('transaction_id', $course_application->transaction->order_id)->orderBy('id', 'asc')->get();
        foreach ($data['transaction_refunds'] as $transaction_refund) {
            $amount_added += $transaction_refund->amount_added;
            $amount_refunded += $transaction_refund->amount_refunded;
        }
    }
    $currency_exchange_rate = \App\Models\SuperAdmin\CurrencyExchangeRate::where('id', $data['course'] ? $data['course']->currency : 0)->first() ?? null;
    $currency_exchange_rate_value = $currency_exchange_rate ? (float)$currency_exchange_rate->exchange_rate : 1;
    $amount_paid = $course_application->paid_amount + $amount_added;
    $amount_due = $course_application->total_cost_fixed - $amount_paid + $amount_refunded;
    $data['can_edit'] = true;
    if ($course_application->status == 'application_cancelled' || $course_application->status == 'completed' || $amount_due == 0) {
        // $data['can_edit'] = false;
    }
    $data['total_cost_fixed'] = [ 'value' => (float)($course_application->total_cost_fixed / $currency_exchange_rate_value), 'converted_value' => (float)$course_application->total_cost_fixed ];
    $data['amount_paid'] = [ 'value' => (float)($amount_paid / $currency_exchange_rate_value), 'converted_value' => (float)$amount_paid ];
    $data['amount_added'] = [ 'value' => (float)($amount_added / $currency_exchange_rate_value), 'converted_value' => (float)$amount_added ];
    $data['amount_refunded'] = [ 'value' => (float)($amount_refunded / $currency_exchange_rate_value), 'converted_value' => (float)$amount_refunded ];
    $data['amount_due'] = [ 'value' => (float)($amount_due / $currency_exchange_rate_value), 'converted_value' => (float)$amount_due ];
    $data['currency'] = [ 'cost' => $calculator_values['currency'], 'converted' => $default_currency['currency'] ];
    $data['today'] = Carbon\Carbon::now()->format('d-m-Y');

    $data['student_messages'] = \App\Models\Message::with('fromUser', 'toUser')->where('type_id', $course_application->id)        
        ->where(function($query) use ($user_id, $is_admin) {
            if ($is_admin) {
                $query->where(function($sub_query) use ($user_id) {
                    $sub_query->where('type', 'to_student')->where('from_user', $user_id);
                })->orWhere(function($sub_query) use ($user_id) {
                    $sub_query->where('type', 'to_admin')->where('to_user', $user_id);
                });
            } else {
                $query->where(function($sub_query) use ($user_id) {
                    $sub_query->where('type', 'to_student')->where('to_user', $user_id);
                })->orWhere(function($sub_query) use ($user_id) {
                    $sub_query->where('type', 'to_admin')->where('from_user', $user_id);
                });
            }
        })->orderBy('created_at', 'asc')->get();
    $data['user_school'] = null;
    $data['school_messages'] = [];
    if ($course_application->course->school->userSchool != null) {
        $data['user_school'] = $course_application->course->school->userSchool;
        $user_schools = $course_application->course->school->userSchools;
        $school_user_ids = [];
        foreach ($user_schools as $user_school) {
            $school_user_ids[] = $user_school->user_id;
        }
        $school_user_ids = array_unique($school_user_ids);
        $data['school_messages'] = \App\Models\Message::with('fromUser', 'toUser')->where('type_id', $course_application->id)        
            ->where(function($query) use ($user_id, $school_user_ids) {
                $query->where(function($sub_query) use ($user_id) {
                    $sub_query->where('type', 'to_school_admin')->where('from_user', $user_id);
                })->orWhere(function($sub_query) use ($user_id, $school_user_ids) {
                    $sub_query->where('type', 'to_admin')->whereIn('from_user', $school_user_ids)->where('to_user', $user_id);
                });
            })->orderBy('created_at', 'asc')->get();
    }

    return $data;
}
?>