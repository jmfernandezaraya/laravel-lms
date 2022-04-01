<?php
/*
*
*  General English 10th week
*
* start and end date calculated between weeks
* */

namespace App\Http\Controllers\Frontend;

use App\Classes\AccommodationCalculator;

use App\Http\Controllers\Controller;

use App\Http\Middleware\SuperAdmin;

use App\Services\SuperAdminEditUserCourse;

use App\Models\Calculator;
use App\Models\SuperAdmin\Choose_Accommodation_Age_Range;
use App\Models\SuperAdmin\Choose_Classes_Day;
use App\Models\SuperAdmin\Choose_Custodian_Under_Age;
use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Under_Age;
use App\Models\SuperAdmin\Choose_Start_Day;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\SuperAdmin\Choose_Study_Time;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseAirportFee;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseMedicalFee;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\School;

use App\Models\UserCourseBookedDetails;
use App\Models\UserCourseBookedFee;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Symfony\Component\ErrorHandler\Error\OutOfMemoryError;

/**
 * Class CourseControllerFrontend
 * @package App\Http\Controllers\Frontend
 */
class CourseControllerFrontend extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $calculator;

    /**
     * CourseControllerFrontend constructor.
     */
    public function __construct()
    {
        (new SuperAdminEditUserCourse())->create_calculator_db();

        $this->calculator = new AccommodationCalculator;
    }

    /**
     * @param $program_id
     * @param $school_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($program_id, $school_id)
    {
        $data['course'] = $courses = Course::with('coursePrograms')->where('school_id', $school_id)->where('display', true)->where('deleted', false)->get();
        $data['course_update'] = Course::where('unique_id', $program_id)->where('display', true)->where('deleted', false)->firstOrFail();

        /*  We Are Making weekdays available in date picker available in frontend */
        $start_date_ids = [];
        $study_mode_ids = [];
        $program_age_range_ids = [];
        
        $schools = School::find($school_id);

        foreach ($courses as $course) {
            $start_dates[] = $course->start_date;
            $course_programs = $course->coursePrograms;
            foreach ($course_programs as $course_program) {
                $program_age_range_ids = array_merge($program_age_range_ids, $course_program->program_age_range);
            }
            $start_date_ids = array_merge($start_date_ids, $course->start_date);
            $study_mode_ids = array_merge($study_mode_ids, $course->study_mode);
        }

        $start_dates = new Choose_Start_Day;
        $start_dates = $start_dates->whereIn('unique_id', $start_date_ids)->get();

        $study_modes = new Choose_Study_Mode;
        $study_modes = $study_modes->whereIn('unique_id', $study_mode_ids)->get();

        $program_age_ranges = new Choose_Program_Age_Range;
        $program_age_ranges = $program_age_ranges->whereIn('unique_id', $program_age_range_ids)->orderBy('age', 'asc')->get();  

        $data['ages'] = $program_age_ranges;

        return view('frontend.course.single', $data, compact('courses', 'schools', 'study_modes'));
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function calculate(Request $r)
    {
        if (str_contains(url()->previous(), 'editUserCourse'))
        {
            return (new SuperAdminEditUserCourse())->calculatorCourse($r);
        }

        $data['is_true'] = true;
        $select = __('SuperAdmin/backend.select_option');

        $data['is_true'] = false;
        $data['success'] = false;
        $data['success'] = true;

        $url = url()->previous();
        $explode = explode('/', $url);
        $data['previous_url'] = $school_id = end($explode);

        if ($r->type == 'requested_for_under_age') {
            $programs = Course::where('school_id', $school_id)->where('deleted', false)
                ->where('study_mode', 'LIKE', '%' . $r->study_mode . '%')->get();
            $course_unique_ids  = [];
            foreach ($programs as $program) {
                $course_unique_ids[] = '' . $program->unique_id;
            }

            $programs = CourseProgram::with('course')->where('program_age_range', 'LIKE', '%' . $r->under_age . '%')
                 ->whereIn('course_unique_id', $course_unique_ids)->get();
            $programs = collect($programs)->unique('course_unique_id')->values()->all();
            $option = "<option value=''>$select</option>";
            foreach ($programs as $program) {
                $program_name = $program->course->program_name;
                $option .= "<option value=$program->course_unique_id data-id=$program->unique_id>$program_name</option>";
            }

            $data['program_get'] = $option;
        } elseif ($r->type == 'select_program') {
            \Session::put('course_unique_id', $r->course_unique_id);
            $data['program_unique'] = \Session::get('program_unique_id');
            $course_programs = CourseProgram::where('course_unique_id', $r->value)->get();
            if ($course_programs->isEmpty()) {
                $course_programs = CourseProgram::where('unique_id', $r->program_unique_id)->get();
            }
            $program_start_date = null;
            $program_end_date = null;
            foreach ($course_programs as $course_program) {
                $course_program_start_date = \Carbon\Carbon::create($course_program->program_start_date);
                $course_program_end_date = \Carbon\Carbon::create($course_program->program_end_date);
                if (!$program_start_date) $program_start_date = $course_program_start_date;
                if (!$program_end_date) $program_end_date = $course_program_end_date;
                if ($course_program_start_date < $program_start_date) $program_start_date = $course_program_start_date;
            }
            $data['availale_days'] = [];
            $today_date = \Carbon\Carbon::now();
            while(true) {
                $available_day = true;
                foreach ($course_programs as $course_program) {
                    if ($course_program->available_date == 'start_day_every') {
                        if ($program_start_date->format('l') != $course_program->select_day_week) {
                            $available_day = false;
                        }
                    } else if ($course_program->available_date == 'selected_dates') {
                        if (!in_array($program_start_date->format('m/d/Y'), explode(",", $course_program->available_days))) {
                            $available_day = false;
                        }
                    } else {
                        $available_day = true;
                    }
                }
                if ($program_start_date < $today_date) $available_day = false;
                if ($available_day) {
                    $data['availale_days'][] = $program_start_date->format('Ymd');
                }
                if ($program_start_date >= $program_end_date) break;
                $program_start_date->addDay();
            }
            sort($data['availale_days']);

            $course_update = Course::where('unique_id', $r->value)->first();
            $data['level_required'] = $course_update->program_level;
            $data['lessons_per_week'] = $course_update->lessons_per_week;
            $data['hours_per_week'] = $course_update->hours_per_week;
            $stuty_times = new Choose_Study_Time;
            $data['study_time'] = implode(", ", $stuty_times->whereIn('unique_id', $course_update->study_time ? $course_update->study_time : [])->pluck('name')->toArray());
            $classes_days = new Choose_Classes_Day;
            $data['classes_days'] = implode(", ", $classes_days->whereIn('unique_id', $course_update->classes_day ? $course_update->classes_day : [])->pluck('name')->toArray());
            $start_dates = new Choose_Start_Day;
            $data['start_date'] = implode(", ", $start_dates->whereIn('unique_id', $course_update->start_date ? $course_update->start_date : [])->pluck('name')->toArray());
        } elseif ($r->type == 'date_selected') {
            \Session::put('program_date_selected', $r->value);
            $data['program_date_selected'] = \Session::get('program_date_selected');
            \Session::put('program_unique_id', $r->program_unique_id);
            $course_update = Course::where('unique_id', $r->value)->first();
            $data['program_unique'] = \Session::get('program_unique_id');

            $course_programs = CourseProgram::where('course_unique_id', $r->course_unique_id)->get();
            if ($course_programs->isEmpty()) {
                $course_programs = CourseProgram::where('unique_id', $r->program_unique_id)->get();
            }

            $program_start_date = null;
            $program_end_date = null;
            $date_set = substr($r->value, 6, 4) . "-" . substr($r->value, 3, 2) . "-" . substr($r->value, 0, 2);
            $course_program_start_date = \Carbon\Carbon::create($date_set);
            foreach ($course_programs as $course_program) {
                $loop_program_start_date = \Carbon\Carbon::create($course_program->program_start_date);
                $loop_program_end_date = \Carbon\Carbon::create($course_program->program_end_date);
                if (!$program_start_date) $program_start_date = $loop_program_start_date;
                if (!$program_end_date) $program_end_date = $loop_program_end_date;
                if ($loop_program_start_date < $program_start_date) $program_start_date = $loop_program_start_date;
                if ($loop_program_end_date > $program_end_date) $program_end_date = $loop_program_end_date;
                if ($course_program->christmas_start_date && $course_program->christmas_end_date) {
                    $loop_program_christmas_start_date = \Carbon\Carbon::create($course_program->christmas_start_date);
                    $loop_program_christmas_end_date = \Carbon\Carbon::create($course_program->christmas_end_date);
                    if ($course_program_start_date->gte($loop_program_christmas_start_date) && $course_program_start_date->lte($loop_program_christmas_start_date)) {
                        $data['christmas_notification'] = __('Frontend.school_will_close_christmas') . ' ' . __('Frontend.from') . ' ' 
                            . $course_program->christmas_start_date . ' ' . __('Frontend.to') . ' ' . $course_program->christmas_start_date;
                    }
                }
            }
            $availale_days = [];
            $today_date = \Carbon\Carbon::now();
            while(true) {
                $available_day = false;
                if ($program_start_date >= $today_date) {
                    foreach ($course_programs as $course_program) {
                        if ($course_program->available_date == 'start_day_every') {
                            if ($program_start_date->format('l') == $course_program->select_day_week) {
                                $available_day = true;
                            }
                        } else if ($course_program->available_date == 'selected_dates') {
                            if (in_array($program_start_date->format('m/d/Y'), explode(",", $course_program->available_days))) {
                                $available_day = true;
                            }
                        }
                    }
                    if ($available_day) {
                        $availale_days[] = $program_start_date->format('Ymd');
                    }
                }
                if ($program_start_date >= $program_end_date) break;
                $program_start_date->addDay();
            }
            sort($availale_days);
            $diff_weeks = 0;
            if (count($availale_days)) {
                $available_start_date = \Carbon\Carbon::create(substr($availale_days[0], 6, 2) . '-' . substr($availale_days[0], 4, 2) . '-' . substr($availale_days[0], 0, 4));
                $diff_weeks = $course_program_start_date->diffInWeeks($available_start_date);
            }
            $program_durations = [];
            $course_unique_id = 0;
            foreach ($course_programs as $course_program) {
                $course_unique_id = $course_program->course_unique_id;
                $program_duration_flag = false;
                $program_duration_start = $course_program->program_duration_start;
                $program_duration_end = $course_program->program_duration_end;
                if (!$program_duration_start) $program_duration_start = $program_duration_end;
                if (!$program_duration_end) $program_duration_end = $program_duration_start;
                $program_duration_start = (int)$program_duration_start;
                $program_duration_end = (int)$program_duration_end;
                if ($course_program->available_date == 'selected_dates') {
                    $program_duration_end -= $diff_weeks;
                }
                if ($course_program->available_date == 'selected_dates') {
                    if (in_array($course_program_start_date->format('m/d/Y'), explode(",", $course_program->available_days))) {
                        $program_duration_flag = true;
                    }
                } else {
                    $program_duration_flag = true;
                }
                if ($program_duration_flag && $program_duration_start && $program_duration_start) {
                    for ($program_duration = $program_duration_start; $program_duration <= $program_duration_end; $program_duration++) {
                        if (!in_array($program_duration, $program_durations)) {
                            $program_durations[] = $program_duration;
                        }
                    }
                }
            }
            sort($program_durations);
            $program_duration_html = '';
            foreach ($program_durations as $program_duration) {
                $selected = $r->program_duration && $program_duration == $r->program_duration ? 'selected' : '';
                $program_duration_html .= "<option value= $program_duration $selected>$program_duration</option>";
            }
            $data['program_duration'] = $program_duration_html;

            $course_update = Course::where('unique_id', $course_unique_id)->first();
            $data['level_required'] = $course_update->program_level;
            $data['lessons_per_week'] = $course_update->lessons_per_week;
            $data['hours_per_week'] = $course_update->hours_per_week;

            $stuty_times = new Choose_Study_Time;
            $data['study_time'] = implode(", ", $stuty_times->whereIn('unique_id', $course_update->study_time ? $course_update->study_time : [])->pluck('name')->toArray());
            $classes_days = new Choose_Classes_Day;
            $data['classes_days'] = implode(", ", $classes_days->whereIn('unique_id', $course_update->classes_day ? $course_update->classes_day : [])->pluck('name')->toArray());
            $start_dates = new Choose_Start_Day;
            $data['start_date'] = implode(", ", $start_dates->whereIn('unique_id', $course_update->start_date ? $course_update->start_date : [])->pluck('name')->toArray());
        } elseif ($r->type == 'duration') {
            $program_get = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$r->value)->where('program_duration_end', '>=', (int)$r->value)
                ->with("course","courseUnderAges","courseTextBookFees")->first();

            $under_age = $r->under_age == null ? [] : $r->under_age;
            $under_age = !is_array($r->under_age) ? array($r->under_age) : $under_age;
            $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', $under_age)->pluck('age')->toArray();
            $program_under_age = Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');
            $program_under_age_fee_per_week = 0;
            foreach ($program_get->courseUnderAges as $program_course_under_age) {
                if (in_array($program_under_age, $program_course_under_age->under_age)) {
                    $program_under_age_fee_per_week = $program_course_under_age->under_age_fee_per_week;
                }
            }
            insertCalculationIntoDB('under_age_fee', $program_under_age_fee_per_week * $r->value);
            $program_text_book_fee = 0;
            foreach ($program_get->courseTextBookFees as $program_course_text_book) {
                if ($program_course_text_book->text_book_start_date <= $r->value && $program_course_text_book->text_book_end_date >= $r->value) {
                    $program_text_book_fee = $program_course_text_book->text_book_fee;
                }
            }
            insertCalculationIntoDB('text_book_fee', $program_text_book_fee);

            if ($r->courier_fee == 'true') {
                insertCalculationIntoDB('courier_fee', $program_get->courier_fee ?? 0);
            } else {
                insertCalculationIntoDB('courier_fee', 0);
            }
            $data['courier_fee'] = $program_get->courier_fee ? true : false;
            $data['courier_fee_note'] = $program_get->about_courier;

            $data['acoommodation_debug'] = '';

            $r_date_set = $r->date_set;
            $accommodation_under_ages = Choose_Accommodation_Age_Range::whereIn('age', $program_age_ranges)->pluck('unique_id')->toArray();
            $accommodations = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
                ->get()->collect()->values()->filter(function($value) use ($accommodation_under_ages, $r_date_set, $data) {
                    $under_age_flag = in_array($accommodation_under_ages[0], $value['age_range'] ?? []);
                    $date_flag = false;
                    if ($r_date_set) {
                        $date_set1 = substr($r_date_set, 6, 4) . "-" . substr($r_date_set, 3, 2) . "-" . substr($r_date_set, 0, 2);
                        $date_set2 = substr($r_date_set, 3, 2) . "/" . substr($r_date_set, 0, 2) . "/" . substr($r_date_set, 6, 4);
                        if ($value['available_date'] == 'all_year_round') {
                            if ($value['start_date'] <= $date_set1 && $value['end_date'] >= $date_set1) {
                                $date_flag = true;
                            }
                        } else if ($value['available_date'] == 'selected_dates') {
                            if ($value['available_days']) {
                                if (strpos($value['available_days'], $date_set2) != false) {
                                    $date_flag = true;
                                }
                            }
                        }
                    } else {
                        $date_flag = true;
                    }
                    return $under_age_flag && $date_flag;
                })->unique('type')->all();
            $select = __('SuperAdmin/backend.select');
            $accommodation_options = "<option value= ''>$select</option>";
            foreach ($accommodations as $accommodation) {
                $accommodation_options .= "<option value='$accommodation->unique_id'>$accommodation->type</option>";
            }
            $data['accommodations'] = $accommodation_options;
            $data['accommodations_visible'] = count($accommodations) ? true : false;

            $data['airports'] = "<option value=''>$select</option>";
            $data['airports_visible'] = false;
            $course_airports = CourseAirport::where('course_unique_id', \Session::get('course_unique_id'))->with("fees")->get();
            if ($course_airports) {
                $airports_data = collect($course_airports)->unique('service_provider')->values()->all();
                if (count($airports_data)) $data['airports_visible'] = true;
                foreach ($airports_data as $airport_data) {
                    $data['airports'] .= "<option value=$airport_data->service_provider>$airport_data->service_provider</option>";
                }
            }

            $data['medicals'] = "<option value=''>$select</option>";
            $data['medicals_visible'] = false;
            $course_medicals = CourseMedical::where('course_unique_id', \Session::get('course_unique_id'))->with("fees")->get();
            if ($course_medicals) {
                $medicals_data = collect($course_medicals)->unique('company_name')->values()->all();
                if (count($medicals_data)) $data['medicals_visible'] = true;
                foreach ($medicals_data as $medical_data) {
                    $data['medicals'] .= "<option value=$medical_data->company_name>$medical_data->company_name</option>";
                }
            }

            // multiplying program cost here
            $add_program_cost = $program_get->program_cost;
            $multiple_program_cost = (int)$r->value * $add_program_cost;
            if ($r->date_set != null) {
                $date_set = substr($r->date_set, 6, 4) . "-" . substr($r->date_set, 3, 2) . "-" . substr($r->date_set, 0, 2);
                $this->calculator->setSummerDateFromDbProgram($program_get->summer_fee_end_date);
                $this->calculator->setPeakDateFromDbProgram($program_get->peak_time_end_date);
                $this->calculator->setSummerStartDateProgram($program_get->summer_fee_start_date);
                $this->calculator->setPeakStartDate($program_get->peak_time_start_date);
                $this->calculator->setPeakEndDate($program_get->peak_time_end_date);
                $this->calculator->setSummerFee($program_get->summer_fee_per_week);
                $this->calculator->setFrontEndDate($this->getEndDate($date_set, (int)$r->value));
                $this->calculator->setProgramStartDateFromFrontend(Carbon::create($date_set)->format('Y-m-d'));
                $this->calculator->setSummerEndDateProgram($program_get->summer_fee_end_date);

                $summer_week_fee = $program_get->summer_fee_per_week * $this->calculator->CompareDatesAndGetResult()['summer_date_program'];
                $peakfee = $program_get->peak_time_fee_per_week * $this->calculator->CompareDatesAndGetResult()['peak_date_program'];

                insertCalculationIntoDB('summer_fee', $summer_week_fee);
                insertCalculationIntoDB('peak_time_fee', $peakfee);
            }

            //checking whether program duration is greater than the selected program duration and setting registration fee here
            if ($program_get->program_duration == null) {
                insertCalculationIntoDB('program_registration_fee', $program_get->program_registration_fee == null ? 0 : $program_get->program_registration_fee);
            } else {
                (int)$r->value >= $program_get->program_duration ? insertCalculationIntoDB('program_registration_fee', 0) : insertCalculationIntoDB('program_registration_fee', $program_get->program_registration_fee == null ? 0 : $program_get->program_registration_fee);
            }

            //updating program cost here
            insertCalculationIntoDB('program_cost', $multiple_program_cost);
        }

        return response($data);
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function resetProgram()
    {
        $this->calculator->setProgramCost(readCalculationFromDB('program_cost'));
        $this->calculator->setProgramRegistrationFee(readCalculationFromDB('program_registration_fee'));
        $this->calculator->setTextBookFee(readCalculationFromDB('text_book_fee'));
        $this->calculator->setSummerFee(readCalculationFromDB('summer_fee'));
        $this->calculator->setUnderAgeFee(readCalculationFromDB('under_age_fee'));
        $this->calculator->setCourierFee(readCalculationFromDB('courier_fee'));
        $this->calculator->setPeakTimeFee(readCalculationFromDB('peak_time_fee'));
        $this->calculator->setDiscount(readCalculationFromDB('discount_fee'));
        $this->calculator->setTotalPrice();

        $default_currency = getDefaultCurrency();

        $program_cost = readCalculationFromDB('program_cost') ?? 0;
        $registration_fee = readCalculationFromDB('program_registration_fee') ?? 0;
        $text_book_fee = readCalculationFromDB('text_book_fee') ?? 0;
        $summer_fee = readCalculationFromDB('summer_fee') ?? 0;
        $under_age_fee = readCalculationFromDB('under_age_fee') ?? 0;
        $peak_time_fee = readCalculationFromDB('peak_time_fee') ?? 0;
        $courier_fee = readCalculationFromDB('courier_fee') ?? 0;
        $discount_fee = readCalculationFromDB('discount_fee') ?? 0;
        $total = readCalculationFromDB('total') ?? 0;
        $overall_total = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $program_cost,
                $registration_fee,
                $text_book_fee,
                $summer_fee,
                $under_age_fee,
                $peak_time_fee,
                $courier_fee,
                $discount_fee,
                $total - $discount_fee,
                $overall_total,
            ]
        );
        $data['program_cost'] = [
            'value' => $program_cost,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['registration_fee'] = [
            'value' => $registration_fee,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['text_book_fee'] = [
            'value' => $text_book_fee,
            'converted_value' => $calculator_values['values'][2]
        ];
        $data['summer_fees'] = [
            'value' => $summer_fee,
            'converted_value' => $calculator_values['values'][3]
        ];
        $data['under_age_fees'] = [
            'value' => $under_age_fee,
            'converted_value' => $calculator_values['values'][4]
        ];
        $data['peak_time_fees'] = [
            'value' => $peak_time_fee,
            'converted_value' => $calculator_values['values'][5]
        ];
        $data['express_mail_fee'] = [
            'value' => $courier_fee,
            'converted_value' => $calculator_values['values'][6]
        ];
        $data['discount_fee'] = [
            'value' => $discount_fee,
            'converted_value' => $calculator_values['values'][7]
        ];
        $data['total'] = [
            'value' => $total - $discount_fee,
            'converted_value' => $calculator_values['values'][8]
        ];
        $data['overall_total'] = [
            'value' => $overall_total,
            'converted_value' => $calculator_values['values'][9]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        return response($data);
    }

    /**
     * @param $varToCheck
     * @param $low
     * @param $high
     * @return bool
     */
    private function inBetween($varToCheck, $low, $high)
    {
        if ($varToCheck < $low) return false;
        if ($varToCheck > $high) return false;
        return true;
    }

    /**
     * @param $date
     * @param $weeks
     * @return string
     */
    private function getEndDate($date, $weeks)
    {
        return Carbon::create($date)->addWeeks($weeks)->format('Y-m-d');
    }

    /**
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function discountCalculate(Request $r)
    {
        if ($r->has('reload')) {
            reloadInsertCalculationIntoDB();
        }

        $data = array();
        if ($r->has('value')) {
            $program_getting = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$r->value)
                ->where('program_duration_end', '>=', (int)$r->value)->first();
            
            $date_set = substr($r->date_set, 6, 4) . "-" . substr($r->date_set, 3, 2) . "-" . substr($r->date_set, 0, 2);
            if ($program_getting) {
                $week_selected_discount = $this->calculator->calculateDiscountWeekFree($r->value, $program_getting->x_week_selected);
                $data['discount_fee'] = $week_selected_discount;

                if ($this->calculator->checkBetweenDate($program_getting->x_week_start_date, $program_getting->x_week_end_date, $date_set) || 
                    ($this->calculator->checkBetweenDate($program_getting->discount_start_date, $program_getting->discount_end_date, Carbon::now()->format('Y-m-d')))) {
                    $data['week_selected'] = $r->value;

                    $this->calculator->setProgramStartDateFromFrontend($date_set);
                    $this->calculator->setDiscountStartDateForWeekSelect($program_getting->x_week_start_date);
                    $this->calculator->setDiscountEndDateForWeekSelect($program_getting->x_week_end_date);
                    $this->calculator->setProgramDuration($r->value);
                    $data['week_in_db'] = $week_in_db = $program_getting->x_week_selected;
                    $this->calculator->setDiscountWeekGet($week_in_db);
                    $this->calculator->setDiscountStartDate($program_getting->discount_start_date);
                    $this->calculator->setDiscountEndDate($program_getting->discount_end_date);
                    $this->calculator->setHowManyWeekFree($program_getting->how_many_week_free);
                    $this->calculator->setProgramCost($program_getting->program_cost * $r->value);
                    $this->calculator->setProgramStartDate($program_getting->program_start_date);
                    $this->calculator->setProgramEndDate($program_getting->program_end_date);
                    $this->calculator->setDiscount($program_getting->discount_per_week);
                    $this->calculator->setFrontEndDate($this->getEndDate($date_set, $r->value));
                    $this->calculator->setFixedProgramCost($program_getting->program_cost);
                    $this->calculator->setDiscountEndDate($program_getting->discount_end_date);
                    $this->calculator->setGetProgramWeeks($r->value);
                } else {
                    insertCalculationIntoDB('accommodation_discount', 0);
                }
                $data['discount'] = $this->calculator->discountedTotal();
                $data['request'] = $r->all();
                $data['program'] = $program_getting;
            }
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function calculateAccommodation(Request $request)
    {
        $accommodation = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
            ->whereType($request->accom_type)
            ->whereRoomType($request->room_type)
            ->whereMeal($request->meal_type)
            ->where('start_week', '<=', (int)$request->duration)
            ->where('end_week', '>=', (int)$request->duration)
            ->first();

        $data['special_diet'] = $accommodation->special_diet_fee;
        $data['special_diet_note'] = $accommodation->special_diet_note;
        
        $data['custodianship'] = $accommodation->custodian_condition == 'optional' ? true : false;
        $data['unique_id'] = $accommodation->unique_id;

        $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
        $this->calculator->setAccommodationFee($accommodation->fee_per_week * $request->duration);
        $request->program_duration >= $accommodation->program_duration ? $this->calculator->setAccommodationPlacementFee(0) : $this->calculator->setAccommodationPlacementFee($accommodation->placement_fee);
        $this->calculator->setChristmasStartDate($accommodation->christmas_fee_start_date);
        $this->calculator->setChristmasEndDate($accommodation->christmas_fee_end_date);
        $deposit = $accommodation->deposit_fee == null ? 0 : $accommodation->deposit_fee;
        $this->calculator->setAccommodationDeposit($deposit);
        $this->calculator->setSummerDateFromDbAccommodation($accommodation->summer_fee_end_date);
        $request->special_diet == 'true' ? $this->calculator->setAccommodationSpecialDietFee($accommodation->special_diet_fee * $request->duration) : $this->calculator->setAccommodationSpecialDietFee(0);
        $this->calculator->setPeakStartDateAccommodation($accommodation->peak_time_fee_start_date);
        $this->calculator->setPeakDateFromDbAccommodation($accommodation->peak_time_fee_end_date);
        in_array($request->age, $accommodation->getUnderAge()) ? $this->calculator->setAccommodationUnderageFee($accommodation->getUnderAgeFees($request->age) * (int)$request->duration) : 0;
        $custodian_age = $accommodation->custodian_age_range == null ? [] : $accommodation->custodian_age_range;
        $program_age_range = Choose_Program_Age_Range::where('unique_id', $request->age)->first();
        $request_age = 0;
        if ($program_age_range) {
            $request_age = $program_age_range->age;
        }
        $data['request_age'] = $request_age;
        $custodian_under_age = Choose_Custodian_Under_Age::where('age', $request_age)->first();
        $data['custodian_under_age_age_id'] = $custodian_under_age->unique_id;
        $custodian_fee_flag = false;
        if (in_array($custodian_under_age->unique_id, $custodian_age)) {
            if ($accommodation->custodian_condition == 'required') {
                $custodian_fee_flag = true;
            } else {
                if ($request->custodianship == 'true') {
                    $custodian_fee_flag = true;
                }
            }
        }
        $custodian_fee_flag ? $this->calculator->setAccommodationCustodianFee($accommodation->custodian_fee) : $this->calculator->setAccommodationCustodianFee(0);
        $this->calculator->setFrontEndDate($this->getEndDate($date_set, (int)$request->duration));
        $this->calculator->setProgramStartDateFromFrontend(Carbon::create($date_set)->format('Y-m-d'));
        $this->calculator->setSummerStartDateAccommodation($accommodation->summer_fee_start_date);
        $this->calculator->setSummerDateFromDbAccommodation($accommodation->summer_fee_end_date);
        $this->calculator->setAccomDuration((int)$request->duration);
        $this->calculator->setAccommodationDiscountEndDate($accommodation->discount_end_date);

        // Check for dates
        $this->calculator->setAccommodationChristmasFee($accommodation->christmas_fee_per_week * $this->calculator->CompareDatesandGetWeeksAccommodation()['christmas']);
        $this->calculator->setAccommodationDiscount($accommodation->discount_per_week);
        $this->calculator->setAccommodationPeakFee($accommodation->peak_time_fee_per_week * $this->calculator->CompareDatesandGetWeeksAccommodation()['peak']);
        $this->calculator->setAccommodationSummerFee($accommodation->summer_fee_per_week * $this->calculator->CompareDatesandGetWeeksAccommodation()['summer']);
        $this->calculator->setAccommodationDiscountStartDate($accommodation->discount_start_date);
        
        $accom_fee = $this->calculator->getAccommodationFee();
        $placement_fee = $this->calculator->getAccommodationPlacementFee();
        $special_diet_fee = $this->calculator->getAccommodationSpecialDietFee();
        $deposit_fee = $this->calculator->getAccommodationDeposit();
        $summer_fee = $this->calculator->getAccommodationSummerFee();
        $christmas_fee = $this->calculator->getAccommodationChristmasFee();
        $under_age_fee = $this->calculator->getAccommodationUnderageFee();
        $custodian_fee = $this->calculator->getAccommodationCustodianFee();
        $peak_fee = $this->calculator->getAccommodationPeakFee();
        $discount_fee = $this->calculator->resultAccommodationDiscount();
        $total_calculation = $this->calculator->calculateOnlyAccommodationTotal() - $discount_fee;
        $overall_total = $this->calculator->TotalCalculation();

        insertCalculationIntoDB('accommodation_fee', $accom_fee);
        insertCalculationIntoDB('accommodation_placement_fee', $placement_fee);
        insertCalculationIntoDB('accommodation_special_diet_fee', $special_diet_fee);
        insertCalculationIntoDB('accommodation_deposit', $deposit_fee);
        insertCalculationIntoDB('accommodation_custodian_fee', $custodian_fee);
        insertCalculationIntoDB('accommodation_summer_fee', $summer_fee);
        insertCalculationIntoDB('accommodation_christmas_fee', $christmas_fee);
        insertCalculationIntoDB('accommodation_under_age_fee', $under_age_fee);
        insertCalculationIntoDB('accommodation_peak_time_fee', $peak_fee);
        insertCalculationIntoDB('accommodation_discount', $discount_fee);

        $default_currency = getDefaultCurrency();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $accom_fee,
                $placement_fee,
                $special_diet_fee,
                $deposit_fee,
                $custodian_fee,
                $summer_fee,
                $christmas_fee,
                $under_age_fee,
                $peak_fee,
                $discount_fee,
                $total_calculation,
                $overall_total
            ]
        );
        $data['accom_fee'] = [
            'value' => $accom_fee,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['placement_fee'] = [
            'value' => $placement_fee,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['special_diet_fee'] = [
            'value' => $special_diet_fee,
            'converted_value' => $calculator_values['values'][2]
        ];
        $data['deposit_fee'] = [
            'value' => $deposit_fee,
            'converted_value' => $calculator_values['values'][3]
        ];
        $data['custodian_fee'] = [
            'value' => $custodian_fee,
            'converted_value' => $calculator_values['values'][4]
        ];
        $data['summer_fee'] = [
            'value' => $summer_fee,
            'converted_value' => $calculator_values['values'][5]
        ];
        $data['christmas_fee'] = [
            'value' => $christmas_fee,
            'converted_value' => $calculator_values['values'][6]
        ];
        $data['under_age_fee'] = [
            'value' => $under_age_fee,
            'converted_value' => $calculator_values['values'][7]
        ];
        $data['peak_fee'] = [
            'value' => $peak_fee,
            'converted_value' => $calculator_values['values'][8]
        ];
        $data['discount_fee'] = [
            'value' => $discount_fee,
            'converted_value' => $calculator_values['values'][9]
        ];
        $data['total'] = [
            'value' => $total_calculation,
            'converted_value' => $calculator_values['values'][10]
        ];
        $data['overall_total'] = [
            'value' => $overall_total,
            'converted_value' => $calculator_values['values'][11]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        return response($data);
    }

    /*
    * @params : $date, $weeks
    *
    * return How many weeks
    *
    * */

    /**
     * @return bool
     */
    public function resetAccommodation()
    {
        insertCalculationIntoDB('accommodation_fee', 0);
        insertCalculationIntoDB('accommodation_placement_fee', 0);
        insertCalculationIntoDB('accommodation_special_diet_fee', 0);
        insertCalculationIntoDB('accommodation_deposit', 0);
        insertCalculationIntoDB('accommodation_custodian_fee', 0);
        insertCalculationIntoDB('accommodation_summer_fee', 0);
        insertCalculationIntoDB('accommodation_christmas_fee', 0);
        insertCalculationIntoDB('accommodation_under_age_fee', 0);
        insertCalculationIntoDB('accommodation_discount', 0);
        insertCalculationIntoDB('accommodation_peak_time_fee', 0);
        insertCalculationIntoDB('accommodation_total', 0);

        return true;
    }

    /*
    * Return room type and meal type on change of accommodation type
    *
    * @param Request $request
    *
    * return room type and meal type
    *
    * */
    /**
     * @return bool
     */
    public function resetAirportMedical()
    {
        insertCalculationIntoDB('airport_pickup_fee', 0);
        insertCalculationIntoDB('medical_insurance_fee', 0);
        insertCalculationIntoDB('airport_total', 0);
        return true;
    }

    /* Return room type and meal type
     *
     * @param Request $request
     *
     * @return room type and meal type
     * */

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getRoomTypeAndMealType(Request $request)
    {
        $program_age_range = Choose_Program_Age_Range::where('unique_id', $request->age_selected)->value('age');
        $accommodation_under_age = Choose_Accommodation_Age_Range::where('age', $program_age_range)->value('unique_id');
        
        $rooms = $meals = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
            ->whereType($request->accom_type)
            ->get()->collect()->values()->filter(function($value) use ($accommodation_under_age) {
                return in_array($accommodation_under_age, $value['age_range'] ?? []);
            })->all();

        $rooms = collect($rooms)->unique('room_type')->values()->all();
        $meals = collect($meals)->unique('meal')->values()->all();

        $select = __('SuperAdmin/backend.select_option');
        $data['room_type'] = "<option value=''>$select</option>";
        $data['meal_type'] = "<option value=''>$select</option>";

        foreach ($rooms as $room) {
            $data['room_type'] .= "<option value='$room->unique_id'>$room->room_type</option>";
        }

        foreach ($meals as $meal) {
            $data['meal_type'] .= "<option value='$meal->unique_id'>$meal->meal</option>";
        }
        $data['session'] = \Session::all();

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getAccommodationDuration(Request $request)
    {
        $christmas_weeks = 0;
        $course_programs = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))->get();
        if ($course_programs->isEmpty()) {
            $course_programs = CourseProgram::where('unique_id', \Session::get('program_unique_id'))->get();
        }
        $date_set = substr(\Session::get('program_date_selected'), 6, 4) . "-" . substr(\Session::get('program_date_selected'), 3, 2) . "-" . substr(\Session::get('program_date_selected'), 0, 2);
        $course_program_start_date = \Carbon\Carbon::create($date_set);
        foreach ($course_programs as $course_program) {
            if ($course_program->christmas_start_date && $course_program->christmas_end_date) {
                $loop_program_christmas_start_date = \Carbon\Carbon::create($course_program->christmas_start_date);
                $loop_program_christmas_end_date = \Carbon\Carbon::create($course_program->christmas_end_date);
                if ($course_program_start_date->gte($loop_program_christmas_start_date) && $course_program_start_date->lte($loop_program_christmas_end_date)) {
                    $christmas_weeks = $course_program_start_date->diffInWeeks($loop_program_christmas_end_date);
                }
            }
        }

        $accommodations = CourseAccommodation::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->whereType($request->accom_type)
            ->whereRoomType($request->room_type)
            ->whereMeal($request->meal_type)
            ->get();

        $min_durations = [];
        $max_durations = [];
        $min1 = $max1 = 0;
        foreach ($accommodations as $accommodation) {
            $min1 = (int)$accommodation->start_week;
            $max1 = (int)$accommodation->end_week + $christmas_weeks;
            $min_durations[] = (int)$accommodation->start_week;
            $max_durations[] = (int)$accommodation->end_week + $christmas_weeks;
        }

        $accommodation_durations = array_merge($min_durations, $max_durations);

        $min_duration = count($accommodation_durations) ? min($accommodation_durations) : 0;
        $max_duration = count($accommodation_durations) ? max($accommodation_durations) : 0;

        $select = __('SuperAdmin/backend.select');
        $duration_html = "<option value=''>$select</option>";
        /*
        * if the start and week are same the below condition is applied
        * */
        if ($min1 != $max1) {
            if ($min_duration && $max_duration) {
                for ($i = $min_duration; $i <= $request->program_duration + $christmas_weeks && $i <= $max_duration; $i++) {
                    $duration_html .= "<option value=$i>$i</option>";
                }
            }
        } else {
            sort($accommodation_durations);
            $accommodation_durations = array_unique($accommodation_durations);
            foreach ($accommodation_durations as $duration) {
                $duration_html .= "<option value=$duration>$duration</option>";
            }
        }

        $data['duration'] = $duration_html;

        return response($data);
    }

    /* Function for returning airport service
     *
     * @param Request $request
     *
     * @return airport names
     * */

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getAirportNames(Request $request)
    {
        $airport_unique_ids = CourseAirport::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where('service_provider', $request->service_provider)->pluck('unique_id');

        $select = __('SuperAdmin/backend.select_option');
        $data = "<option value=''>$select</option>";

        $airport_fee_names = CourseAirportFee::whereIn('course_airport_unique_id', $airport_unique_ids)->get()->unique('name')->values()->all();
        foreach ($airport_fee_names as $airport_fee_name) {
            $data .= "<option value='$airport_fee_name->name'>$airport_fee_name->name</option>";
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getAirportServiceNames(Request $request)
    {
        $airport_unique_ids = CourseAirport::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where('service_provider', $request->service_provider)->pluck('unique_id');

        $select = __('SuperAdmin/backend.select_option');
        $data = "<option value=''>$select</option>";

        $airport_fee_service_names = CourseAirportFee::whereIn('course_airport_unique_id', $airport_unique_ids)
            ->where('name', $request->name)->pluck('service_name');
        foreach ($airport_fee_service_names as $airport_fee_service_name) {
            $data .= "<option value='$airport_fee_service_name'>$airport_fee_service_name</option>";
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getMedicalDeductibles(Request $request)
    {
        $medical_deductibles = CourseMedical::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where('company_name', $request->company_name)->pluck('deductible');

        $select = __('SuperAdmin/backend.select_option');
        $data = "<option value=''>$select</option>";

        foreach ($medical_deductibles as $medical_deductible) {
            $data .= "<option value='$medical_deductible'>$medical_deductible</option>";
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getMedicalDurations(Request $request)
    {
        $medical_unique_ids = CourseMedical::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where('company_name', $request->company_name)
            ->where('deductible', $request->deductible)->pluck('unique_id');

        $medical_fees = CourseMedicalFee::whereIn('course_medical_unique_id', $medical_unique_ids)->get();

        $min_week = 0; $max_week = 0;
        foreach ($medical_fees as $medical_fee) {
            if (!$min_week) $min_week = $medical_fee->start_date;
            if (!$max_week) $max_week = $medical_fee->end_date;
            if ($medical_fee->start_date < $min_week) $min_week = $medical_fee->start_date;
            if ($medical_fee->end_date > $max_week) $max_week = $medical_fee->end_date;
        }
        if ($max_week > $request->program_duration) $max_week = $request->program_duration;
        if (!$min_week) $min_week = 1;
        
        $select = __('SuperAdmin/backend.select_option');
        $data = "<option value=''>$select</option>";

        for ($duration = $min_week; $duration <= $max_week; $duration++) {
            $data .= "<option value='$duration'>$duration</option>";
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function setAirportPickupFee(Request $request)
    {
        $airport = CourseAirport::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where('service_provider', $request->service_provider)->with('fees', function ($query) use($request) {
                return $query->where('name', $request->name)->where('service_name', $request->service_name);
            })->first();

        $airport_pickup_fee = 0;
        $data['week_selected_fee'] = $airport_week_selected_fee = (int)$airport->week_selected_fee;
        $data['airport_note'] = $airport->note;
        if ($airport_week_selected_fee) {
            if ($airport_week_selected_fee <= $request->program_duration) {
                foreach ($airport->fees as $airport_fee) {
                    $airport_pickup_fee = $airport_fee->service_fee;
                }
            }
        }

        $this->calculator->setAirportPickupFee($airport_pickup_fee);
        $airport_pickup_fee = $this->calculator->getAirportPickupFee();

        insertCalculationIntoDB('airport_pickup_fee', $airport_pickup_fee);

        $default_currency = getDefaultCurrency();

        $data_fee = $this->calculator->getAirportPickupFee();
        $overall_total = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $data_fee,
                $overall_total,
            ]
        );
        $data['airport_fee'] = [
            'value' => $data_fee,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['overall_total'] = [
            'value' => $overall_total,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        $data['request'] = $request->all();

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function setMedicalInsuranceFee(Request $request)
    {
        $medical = CourseMedical::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where('company_name', $request->company_name)
            ->where('deductible', $request->deductible)->with('fees', function ($query) use($request) {
                return $query->where('start_date', '<=', $request->duration)->where('end_date', '>=', $request->duration);
            })->first();

        $medical_insurance_fee = 0;
        $medical_week_selected_fee = (int)$medical->week_selected_fee;
        if ($medical_week_selected_fee) {
            if ($medical_week_selected_fee <= $request->program_duration) {
                foreach ($medical->fees as $medical_fee) {
                    $medical_insurance_fee += $medical_fee->fees_per_week;
                }
            }
        }

        $this->calculator->setMedicalInsuranceFee($medical_insurance_fee);
        $medical_insurance_fee = $this->calculator->getMedicalInsuranceFee();

        insertCalculationIntoDB('medical_insurance_fee', $medical_insurance_fee);

        $default_currency = getDefaultCurrency();
        
        $data_fee = $this->calculator->getMedicalInsuranceFee();
        $overall_total = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $data_fee,
                $overall_total,
            ]
        );
        $data['medical_fee'] = [
            'value' => $data_fee,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['overall_total'] = [
            'value' => $overall_total,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        $data['request'] = $request->all();

        return response($data);
    }

    public function setAirportMedicalFee(Request $request)
    {
        if ($request->airport_service_provider && $request->airport_name && $request->airport_service) {
            $airport = CourseAirport::whereHas('fees', function($query) use($request) {
                    $query->where('name', $request->airport_name)->where('service_name', $request->airport_service);
                })->whereCourseUniqueId(\Session::get('course_unique_id'))
                ->where('service_provider', $request->airport_service_provider)->first();
            }

        $airport_pickup_fee = 0;
        if (!empty($airport)) {
            $data['airport_note'] = $airport->note;
            $airport_week_selected_fee = (int)$airport->week_selected_fee;
            if ($airport_week_selected_fee) {
                if ($airport_week_selected_fee > $request->program_duration) {
                    foreach ($airport->fees as $airport_fee) {
                        if ($airport_fee->name == $request->airport_name && $airport_fee->service_name == $request->airport_service) {
                            $airport_pickup_fee = $airport_fee->service_fee;
                        }
                    }
                }
            }
        }

        $this->calculator->setAirportPickupFee($airport_pickup_fee);
        insertCalculationIntoDB('airport_pickup_fee', $airport_pickup_fee);

        if ($request->medical_company_name && $request->medical_deductible && $request->medical_duration) {
            $medical = CourseMedical::whereHas('fees', function($query) use($request) {
                    $query->where('start_date', '<=', $request->medical_duration)->where('end_date', '>=', $request->medical_duration);
                })->whereCourseUniqueId(\Session::get('course_unique_id'))
                ->where('company_name', $request->medical_company_name)->where('deductible', $request->medical_deductible)->first();
        }

        $medical_insurance_fee = 0;
        if (!empty($medical)) {
            $data['medical_note'] = $medical->note;
            $medical_week_selected_fee = (int)$medical->week_selected_fee;
            if ($medical_week_selected_fee) {
                if ($medical_week_selected_fee > $request->program_duration) {
                    foreach ($medical->fees as $medical_fee) {
                        if ($medical_fee->start_date <= $request->medical_duration && $medical_fee->end_date >= $request->medical_duration) {
                            $medical_insurance_fee += $medical_fee->fees_per_week * ($request->medical_duration - $medical_fee->start_date + 1);
                        }
                    }
                }
            }
        }

        $this->calculator->setMedicalInsuranceFee($medical_insurance_fee);
        insertCalculationIntoDB('medical_insurance_fee', $medical_insurance_fee);

        $default_currency = getDefaultCurrency();
        
        $airport_pickup_fee = $this->calculator->getAirportPickupFee();
        $medical_insurance_fee = $this->calculator->getMedicalInsuranceFee();
        $overall_total = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $airport_pickup_fee,
                $medical_insurance_fee,
                $airport_pickup_fee + $medical_insurance_fee,
                $overall_total,
            ]
        );
        $data['airport_fee'] = [
            'value' => $airport_pickup_fee,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['medical_fee'] = [
            'value' => $medical_insurance_fee,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['total'] = [
            'value' => $airport_pickup_fee + $medical_insurance_fee,
            'converted_value' => $calculator_values['values'][2]
        ];
        $data['overall_total'] = [
            'value' => $overall_total,
            'converted_value' => $calculator_values['values'][3]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        $data['request'] = $request->all();

        return response($data);
    }

    /**
     * @param $start_date
     * @param $end_date
     * @param $compare_with
     * @param $course_unique_id
     * @param $value
     * @return bool
     */
    private function displayAccommodationOrNot($start_date, $end_date, $compare_with, $course_unique_id, $value)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $start_date)->format('d-m-Y');
        $endDate = Carbon::createFromFormat('Y-m-d', $end_date)->format('d-m-Y');
        $check = Carbon::create($compare_with)->between($startDate, $endDate);

        $accoms = CourseAccommodation::where('course_unique_id', $course_unique_id)
            ->where('end_week', '<=', (int)$value)
            ->count();

        return $check && $accoms > 0 ? true : false;
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