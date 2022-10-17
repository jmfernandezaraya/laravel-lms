<?php

namespace App\Services;

use App\Classes\AccommodationCalculator;

use App\Models\Calculator;
use App\Models\CourseAccommodation;
use App\Models\CourseAirport;
use App\Models\Course;
use App\Models\CourseProgram;
use App\Models\CourseApplication;
use App\Models\CourseApplicationFee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SuperAdminEditUserCourse
 * @package App\Services
 */
class SuperAdminEditUserCourse
{
    private $calculator, $usercourseid, $userbookfeemodel;

    /**
     * CourseControllerFrontend constructor.
     */
    public function __construct()
    {
        $this->usercourseid = request()->user_course_id;
        $this->create_calculator_db();

        $this->calculator = new AccommodationCalculator;

        $this->userbookfeemodel = CourseApplication::find($this->usercourseid);
    }

    /**
     * @return bool
     */
    public function create_calculator_db()
    {
        if (str_contains(url()->previous(), 'editUserCourse') && !Calculator::whereCalcId(request()->ip())->first()) {
            $booked = CourseApplicationFee::where('course_application_id', $this->usercourseid)->first();

            $replicate = $booked->replicate(['ip', 'course_application_id', 'deleted_at'])->setTable('calculators');
            $replicate->calc_id = request()->ip();
            return $replicate->save();
        }

        if (!Calculator::whereCalcId(request()->ip())->first()) {
            $calculator = new  \App\Models\Calculator;
            $calcid = request()->ip();
            $inpu['total'] = 0;
            $inpu['calc_id'] = $calcid;
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
            $inpu['custodian_fee'] = 0;
            $inpu['total'] = 0;

            return $calculator->fill($inpu)->save();
        }

        return true;
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function calculatorCourse(Request $request)
    {
        $data['is_true'] = true;
        $select = __('Admin/backend.select_option');

        $data['is_true'] = false;
        $data['success'] = false;
        $data['success'] = true;

        $url = url()->previous();
        $explode = explode('/', $url);
        $data['previous_url'] = $school_id = end($explode);

        if ($request->type == 'requested_for_under_age') {
            $programs = Course::where('school_id', $school_id)->where('study_mode', 'LIKE', '%' . $request->study_mode . '%')->get();
            $course_unique_id = [];
            foreach ($programs as $program) {
                $course_unique_id[] = $program->unique_id;
            }

            $programs = CourseProgram::where('program_age_range', 'LIKE', '%' . $request->under_age . '%')->whereIn('course_unique_id', $course_unique_id)->get();

            $programs = collect($programs)->unique('course_unique_id')->values()->all();
            $option = "<option value=''> $select</option>";
            foreach ($programs as $program) {
                $program_name = $program->course->program_name;
                $selected = $request->course_program_unique_id && $request->course_program_unique_id == $program->unique_id ? 'selected' : '';
                $option .= "<option $selected  value=$program->course_unique_id data-id= $program->unique_id>$program_name </option>";
            }
            $data['course_program'] = $option;
        } elseif ($request->type == 'select_program') {
            $k = "<option value=''> $select</option>";
            \Session::put('program_unique_id', $request->value);
            $data['program_unique'] = \Session::get('program_unique_id');
            $course_program = CourseProgram::where('course_unique_id', $request->value)->get();
            if ($course_program->isEmpty()) {
                $course_program = CourseProgram::where('unique_id', $request->program_unique_id)->get();
            }
            $end_date = CourseProgram::where('unique_id', $request->program_unique_id)->first()['program_end_date'];
            $data['end_date'] = \Carbon\Carbon::create($end_date)->format('d-m-Y');
            $program_duration_start = [];
            $program_duration_end = [];
            foreach ($course_program as $program) {
                $program_duration_start[] = $program->program_duration_start;
                $program_duration_end[] = $program->program_duration_end;
            }
            $minimum_duration = min($program_duration_start);
            $max_duration = max($program_duration_end);

            for ($i = $minimum_duration; $i <= $max_duration; $i++) {
                $selected = $request->program_duration && $i == $request->program_duration ? 'selected' : '';
                $k .= "<option value= $i $selected> $i</option>";
            }
            $data['program_duration'] = $k;

            $course_update = Course::where('unique_id', $request->value)->first();

            $data['level_required'] = $course_update->program_level;
            $data['lessons_per_week'] = $course_update->lessons_per_week;
            $data['hours_per_week'] = $course_update->hours_per_week;
            $data['study_time'] = implode(", ", $course_update->study_time);
            $data['every_day'] = implode(", ", $course_update->every_day);
        } elseif ($request->type == 'duration') {
            $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
            $course_program_start_date = \Carbon\Carbon::create($date_set);
            $course_program_end_date = \Carbon\Carbon::create($date_set)->addWeeks($request->program_duration);
            $program_start_date = $course_program_start_date->format('Y-m-d');
            $program_end_date = $course_program_end_date->format('Y-m-d');
            $course = Course::where('unique_id', \Session::get('course_unique_id'))->first();
            $course_programs = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$request->value)->where('program_duration_end', '>=', (int)$request->value)
                ->with("course", "courseUnderAges", "courseTextBookFees")->get();
            if (count($course_programs)) {
                $course_first_program = $course_programs[0];
                $under_age = $request->under_age == null ? [] : $request->under_age;
                $under_age = !is_array($request->under_age) ? array($request->under_age) : $under_age;
                $program_age_ranges = ChooseProgramAge::whereIn('unique_id', $under_age)->pluck('age')->toArray();
                $program_under_age = ChooseProgramUnderAge::whereIn('age', $program_age_ranges)->value('unique_id');
                $program_under_age_fee_per_week = 0;
                foreach ($course_first_program->courseUnderAges as $program_course_under_age) {
                    if (in_array($program_under_age, is_array($program_course_under_age->under_age) ? $program_course_under_age->under_age : [])) {
                        $program_under_age_fee_per_week = $program_course_under_age->under_age_fee_per_week;
                    }
                }
                insertCalculationIntoDB('under_age_fee', $program_under_age_fee_per_week * $request->value);
                $program_text_book_fee = 0;
                foreach ($course_first_program->courseTextBookFees as $program_course_text_book) {
                    if ($program_course_text_book->text_book_start_date <= $request->value && $program_course_text_book->text_book_end_date >= $request->value) {
                        if ($program_course_text_book->text_book_fee_type == 'fixed_cost') {
                            $program_text_book_fee = $program_course_text_book->text_book_fee;
                        } else {
                            $program_text_book_fee = $program_course_text_book->text_book_fee * $request->value;
                        }
                    }
                }
                insertCalculationIntoDB('text_book_fee', $program_text_book_fee);
                if ($program_text_book_fee) {
                    $data['text_book_note'] = app()->getLocale() == 'en' ? $course_first_program->text_book_note : $course_first_program->text_book_note_ar;
                }

                if ($request->courier_fee == 'true') {
                    insertCalculationIntoDB('courier_fee', $course_first_program->courier_fee ?? 0);
                } else {
                    insertCalculationIntoDB('courier_fee', 0);
                }
                $data['courier_fee'] = $course_first_program->courier_fee ? true : false;
                $data['courier_fee_note'] = app()->getLocale() == 'en' ? $course_first_program->about_courier :  $course_first_program->about_courier_ar;

                if ($course_first_program->christmas_start_date && $course_first_program->christmas_end_date) {
                    $program_christmas_start_date = \Carbon\Carbon::create($course_first_program->christmas_start_date);
                    $program_christmas_end_date = \Carbon\Carbon::create($course_first_program->christmas_end_date);
                    if (!$course_program_start_date->gte($program_christmas_end_date) && !$course_program_end_date->lte($program_christmas_start_date)) {
                        $data['christmas_notification'] = __('Frontend.school_will_close_christmas') . ' ' . __('Frontend.from') . ' ' 
                            . $course_first_program->christmas_start_date . ' ' . __('Frontend.to') . ' ' . $course_first_program->christmas_end_date;
                    }
                }
                $r_date_set = $request->date_set;
                $r_duration = $request->value;
                $program_duration_start = $course_first_program->program_duration_start;
                $accommodation_under_ages = ChooseAccommodationAge::whereIn('age', $program_age_ranges)->pluck('unique_id')->toArray();
                $accommodations = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
                    ->get()->collect()->values()->filter(function($value) use ($accommodation_under_ages, $r_date_set, $program_start_date, $program_end_date, $r_duration) {
                        $under_age_flag = in_array($accommodation_under_ages[0], $value['age_range'] ?? []);
                        $week_flag = $value['start_week'] <= (int)$r_duration && $value['end_week'] >= (int)$r_duration;
                        $date_flag = false;
                        if ($r_date_set) {
                            if ($value['start_date'] <= $program_start_date || $value['end_date'] >= $program_end_date) {
                                if ($value['available_date'] == 'all_year_round') {
                                    $date_flag = true;
                                } else if ($value['available_date'] == 'selected_dates') {
                                    if ($value['available_days']) {
                                        for ($accmmodation_duration = $program_duration_start; $accmmodation_duration <= $r_duration; $accmmodation_duration++) {
                                            $accmmodation_duration_date = Carbon::create($r_date_set)->addWeeks($accmmodation_duration)->format('m/d/Y');
                                            if (strpos($value['available_days'], $accmmodation_duration_date) != false) {
                                                $date_flag = true;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $date_flag = true;
                        }
                        return $under_age_flag && $week_flag && $date_flag;
                    })->unique('type')->all();
                $select = __('Admin/backend.select');
                $accommodation_options = "<option value='' selected>$select</option>";
                foreach ($accommodations as $accommodation) {
                    $accommodation_type = app()->getLocale() == 'en' ? $accommodation->type : $accommodation->type_ar;
                    $accommodation_options .= "<option value='" . $accommodation_type . "'>" . $accommodation_type . "</option>";
                }
                $data['accommodations'] = $accommodation_options;
                $data['accommodations_visible'] = count($accommodations) ? true : false;
                
                $data['empty_option'] = "<option value='' selected>$select</option>";

                $data['airports'] = "<option value='' selected>$select</option>";
                $data['airports_visible'] = false;
                $course_airports = CourseAirport::where('course_unique_id', \Session::get('course_unique_id'))->with("fees")->get();
                if ($course_airports) {
                    if (app()->getLocale() == 'en') $airports_data = collect($course_airports)->unique('service_provider')->values()->all();
                    else $airports_data = collect($course_airports)->unique('service_provider_ar')->values()->all();
                    if (count($airports_data)) $data['airports_visible'] = true;
                    foreach ($airports_data as $airport_data) {
                        $airport_service_provider = app()->getLocale() == 'en' ? $airport_data->service_provider : $airport_data->service_provider_ar;
                        $data['airports'] .= "<option value='" . $airport_service_provider . "'>" . $airport_service_provider . "</option>";
                    }
                }

                $data['medicals'] = "<option value='' selected>$select</option>";
                $data['medicals_visible'] = false;
                $course_medicals = CourseMedical::where('course_unique_id', \Session::get('course_unique_id'))->with("fees")->get();
                if ($course_medicals) {
                    if (app()->getLocale() == 'en') $medicals_data = collect($course_medicals)->unique('company_name')->values()->all();
                    else $medicals_data = collect($course_medicals)->unique('company_name_ar')->values()->all();
                    if (count($medicals_data)) $data['medicals_visible'] = true;
                    foreach ($medicals_data as $medical_data) {
                        $medical_company_name = app()->getLocale() == 'en' ? $medical_data->company_name : $medical_data->company_name_ar;
                        $data['medicals'] .= "<option value='" . $medical_company_name . "'>" . $medical_company_name . "</option>";
                    }
                }

                $data['custodians_visible'] = false;
                $custodian_under_age = ChooseCustodianUnderAge::whereIn('age', $program_age_ranges)->value('unique_id');
                $course_custodian = CourseCustodian::where('course_unique_id', \Session::get('course_unique_id'))->where('age_range', 'LIKE', '%' . $custodian_under_age . '%')->first();
                if ($course_custodian) {
                    $data['custodians_visible'] = true;
                }

                // multiplying program cost here
                $multiple_program_cost = 0;
                for ($duration_index = 1; $duration_index <= (int)$request->value; $duration_index++) {
                    foreach ($course_programs as $course_program) {
                        if (checkBetweenDate($course_program->program_start_date, $course_program->program_end_date, Carbon::create($date_set)->addWeeks($duration_index)->format('Y-m-d'))) {
                            $multiple_program_cost += $course_program->program_cost;
                            break;
                        }
                    }
                }
                if ($request->date_set != null) {
                    $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
                    $this->calculator->setSummerDateFromDbProgram($course_first_program->summer_fee_end_date);
                    $this->calculator->setPeakDateFromDbProgram($course_first_program->peak_time_end_date);
                    $this->calculator->setSummerStartDateProgram($course_first_program->summer_fee_start_date);
                    $this->calculator->setPeakStartDate($course_first_program->peak_time_start_date);
                    $this->calculator->setPeakEndDate($course_first_program->peak_time_end_date);
                    $this->calculator->setSummerFee($course_first_program->summer_fee_per_week);
                    $this->calculator->setFrontEndDate(getEndDate($date_set, (int)$request->value));
                    $this->calculator->setProgramStartDateFromFrontend(Carbon::create($date_set)->format('Y-m-d'));
                    $this->calculator->setSummerEndDateProgram($course_first_program->summer_fee_end_date);

                    $dates_and_get_result = $this->calculator->CompareDatesAndGetResult();
                    $summer_week_fee = $course_first_program->summer_fee_per_week * $dates_and_get_result['summer_date_program'];
                    $peakfee = $course_first_program->peak_time_fee_per_week * $dates_and_get_result['peak_date_program'];

                    insertCalculationIntoDB('summer_fee', $summer_week_fee);
                    insertCalculationIntoDB('peak_time_fee', $peakfee);
                }

                // Checking whether program duration is greater than the selected program duration and setting registration fee here
                if ($course_first_program->program_duration == null) {
                    insertCalculationIntoDB('program_registration_fee', $course_first_program->program_registration_fee == null ? 0 : $course_first_program->program_registration_fee);
                } else {
                    (int)$request->value >= $course_first_program->program_duration ? insertCalculationIntoDB('program_registration_fee', 0) : insertCalculationIntoDB('program_registration_fee', $course_first_program->program_registration_fee == null ? 0 : $course_first_program->program_registration_fee);
                }

                // Updating program cost here
                insertCalculationIntoDB('program_cost', $multiple_program_cost);

                insertCalculationIntoDB('bank_charge_fee', $course_first_program->bank_charge_fee == null ? 0 : $course_first_program->bank_charge_fee);
                $data['vat_fee'] = $course_first_program->tax_percent;
                $data['link_fee'] = $course->link_fee_enable ? true : false;
                $course_link_fee = $course->link_fee_enable ? (($course_first_program->link_fee == null || $course_first_program->tax_percent == null) ? 0 : $course_first_program->link_fee + $course_first_program->link_fee * $course_first_program->tax_percent / 100) : 0;
                insertCalculationIntoDB('link_fee', getCurrencyReverseConvertedValue($course->unique_id, $course_link_fee));
                insertCalculationIntoDB('link_fee_converted', $course_link_fee);
                
                $today_date = \Carbon\Carbon::now();
                $data['coupon_exist'] = Coupon::where('course_unique_ids', 'LIKE', '%' . \Session::get('course_unique_id') . '%')
                    ->get()->collect()->values()->filter(function($value) use ($request, $today_date) {
                        if ($value['start_date']) {
                            if ($value['end_date']) {
                                if ($value['start_date'] <= $today_date && $value['end_date'] >= $today_date) {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        } else {
                            if ($value['end_date']) {
                                if ($value['end_date'] >= $today_date) {
                                    return true;
                                }
                            } 
                        }
                        return false;
                    })->count();
            } else {
                insertCalculationIntoDB('under_age_fee', 0);
                insertCalculationIntoDB('text_book_fee', 0);
                insertCalculationIntoDB('courier_fee', 0);
                $data['courier_fee'] = false;
                $data['courier_fee_note'] = '';
                $data['accommodations'] = "<option value='' selected>$select</option>";
                $data['accommodations_visible'] = false;
                $data['airports'] = "<option value='' selected>$select</option>";
                $data['airports_visible'] = false;
                $data['medicals_visible'] = false;
                $data['medicals'] = "<option value='' selected>$select</option>";
                $data['custodians_visible'] = false;
                insertCalculationIntoDB('summer_fee', 0);
                insertCalculationIntoDB('peak_time_fee', 0);
                insertCalculationIntoDB('program_registration_fee', 0);
                insertCalculationIntoDB('program_cost', 0);
                insertCalculationIntoDB('bank_charge_fee', 0);
                $data['vat_fee'] = 0;
                $data['link_fee'] = false;
                insertCalculationIntoDB('link_fee', 0);
                insertCalculationIntoDB('link_fee_converted', 0);
                $data['coupon_exist'] = 0;
            }
        } elseif ($request->type == 'courier_fee') {
            $course_program = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$request->program_duration)
                ->where('program_duration_end', '>=', (int)$request->program_duration)
                ->where('program_duration_start', '<=', (int)$request->program_duration)
                ->where('program_duration_end', '>=', (int)$request->program_duration)
                ->first();

            $data['error'] = \Session::get('program_unique_id');
            if ($request->under_age == null)
                $data['error'] = "Select Age First";

            $request->value == 'true' ? insertCalculationIntoDB('courier_fee', $course_program->courier_fee) : insertCalculationIntoDB('courier_fee', 0);
        }

        return response($data);
    }

    /**
     * @return false|mixed|string
     */
    private function getCourseId()
    {
        $ee = explode('/', url()->previous());

        end($ee);
        $course_id = session()->has('course_unique_id') ? session()->get('course_unique_id') : prev($ee);

        return $course_id;
    }
}