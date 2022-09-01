<?php
/*
* start and end date calculated between weeks
* */
namespace App\Http\Controllers\Frontend;

use App\Classes\AccommodationCalculator;

use App\Http\Controllers\Controller;

use App\Http\Middleware\SuperAdmin;

use App\Services\SuperAdminEditUserCourse;

use App\Models\Calculator;
use App\Models\CourseApplication;
use App\Models\CourseApplicationFee;
use App\Models\SuperAdmin\ChooseAccommodationAge;
use App\Models\SuperAdmin\ChooseAccommodationUnderAge;
use App\Models\SuperAdmin\ChooseClassesDay;
use App\Models\SuperAdmin\ChooseCustodianUnderAge;
use App\Models\SuperAdmin\ChooseProgramAge;
use App\Models\SuperAdmin\ChooseProgramUnderAge;
use App\Models\SuperAdmin\ChooseStartDate;
use App\Models\SuperAdmin\ChooseStudyMode;
use App\Models\SuperAdmin\ChooseStudyTime;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAccommodationUnderAge;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseAirportFee;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseMedicalFee;
use App\Models\SuperAdmin\CourseCustodian;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\School;

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
        
        $school = School::find($school_id);

        foreach ($courses as $course) {
            $start_dates[] = $course->start_date;
            $course_programs = $course->coursePrograms;
            foreach ($course_programs as $course_program) {
                $program_age_range_ids = array_merge($program_age_range_ids, $course_program->program_age_range);
            }
            $start_date_ids = array_merge($start_date_ids, $course->start_date);
            $study_mode_ids = array_merge($study_mode_ids, $course->study_mode);
        }

        $start_dates = new ChooseStartDate;
        $start_dates = $start_dates->whereIn('unique_id', $start_date_ids)->get();

        $study_modes = new ChooseStudyMode;
        $study_modes = $study_modes->whereIn('unique_id', $study_mode_ids)->get();

        $program_age_ranges = new ChooseProgramAge;
        $program_age_ranges = $program_age_ranges->whereIn('unique_id', $program_age_range_ids)->orderBy('age', 'asc')->get();  

        $data['ages'] = $program_age_ranges;

        $course_details = (object)(\Session::get('course_details') ?? []);
        if (isset($course_details->accommodation_id)) {
            $accommodation = CourseAccommodation::where('unique_id', $course_details->accommodation_id)->first();
            if ($accommodation) {
                if (app()->getLocale() == 'en') {
                    $course_details->accom_type = $accommodation->type;
                    $course_details->room_type = $accommodation->room_type;
                    $course_details->meal_type = $accommodation->meal;
                } else {
                    $course_details->accom_type = $accommodation->type_ar;
                    $course_details->room_type = $accommodation->room_type_ar;
                    $course_details->meal_type = $accommodation->meal_ar;
                }
            }
        }
        if (isset($course_details->airport_id)) {
            $airport = CourseAirport::where('unique_id', $course_details->airport_id)->first();
            if ($airport) {
                if (app()->getLocale() == 'en') {
                    $course_details->airport_provider = $airport->service_provider;
                } else {
                    $course_details->airport_provider = $airport->service_provider_ar;
                }
            }
        }
        if (isset($course_details->airport_fee_id)) {
            $airport_fee = CourseAirportFee::where('unique_id', $course_details->airport_fee_id)->first();
            if ($airport_fee) {
                if (app()->getLocale() == 'en') {
                    $course_details->airport_name = $airport_fee->name;
                    $course_details->airport_service = $airport_fee->service_name;
                } else {
                    $course_details->airport_name = $airport_fee->name_ar;
                    $course_details->airport_service = $airport_fee->service_name_ar;
                }
            }
        }
        if (isset($course_details->medical_id)) {
            $medical = CourseMedical::where('unique_id', $course_details->medical_id)->first();
            if ($medical) {
                if (app()->getLocale() == 'en') {
                    $course_details->company_name = $medical->company_name;
                } else {
                    $course_details->company_name = $medical->company_name_ar;
                }
                $course_details->deductible_up_to = $medical->deductible;
            }
        }

        return view('frontend.course.single', $data, compact('courses', 'school', 'study_modes', 'course_details'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function calculate(Request $request)
    {
        if (str_contains(url()->previous(), 'editUserCourse'))
        {
            return (new SuperAdminEditUserCourse())->calculatorCourse($request);
        }

        $select = __('Frontend.select_option');

        $data['is_true'] = false;
        $data['success'] = true;

        if ($request->type == 'requested_for_under_age') {
            $programs = Course::where('school_id', $request->school_id)->where('display', true)->where('deleted', false)
                ->where('study_mode', 'LIKE', '%' . $request->study_mode . '%')->get();
            $course_unique_ids  = [];
            foreach ($programs as $program) {
                $course_unique_ids[] = '' . $program->unique_id;
            }

            $programs = CourseProgram::with('course')->where('program_age_range', 'LIKE', '%' . $request->under_age . '%')
                 ->whereIn('course_unique_id', $course_unique_ids)->get();
            $programs = collect($programs)->unique('course_unique_id')->values()->all();
            $option = "<option value='' selected>$select</option>";
            foreach ($programs as $program) {
                $program_name = app()->getLocale() == 'en' ? $program->course->program_name : $program->course->program_name_ar;
                $option .= "<option value=$program->course_unique_id data-id=$program->unique_id>$program_name</option>";
            }

            $data['course_program'] = $option;
        } elseif ($request->type == 'select_program') {
            \Session::put('course_unique_id', $request->course_unique_id);
            $data['program_unique'] = \Session::get('program_unique_id');
            $course_programs = CourseProgram::where('course_unique_id', $request->value)->get();
            if ($course_programs->isEmpty()) {
                $course_programs = CourseProgram::where('unique_id', $request->program_unique_id)->get();
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

            $course_update = Course::where('unique_id', $request->value)->first();
            $data['program_information'] = app()->getLocale() == 'en' ? $course_update->program_information : $course_update->program_information_ar;
            $data['level_required'] = $course_update->program_level;
            $data['lessons_per_week'] = $course_update->lessons_per_week;
            $data['hours_per_week'] = $course_update->hours_per_week;
            $stuty_times = new ChooseStudyTime;
            $data['study_time'] = implode(", ", $stuty_times->whereIn('unique_id', $course_update->study_time ? $course_update->study_time : [])->pluck('name')->toArray());
            $classes_days = new ChooseClassesDay;
            $data['classes_days'] = implode(", ", $classes_days->whereIn('unique_id', $course_update->classes_day ? $course_update->classes_day : [])->pluck('name')->toArray());
            $start_dates = new ChooseStartDate;
            $data['start_date'] = implode(", ", $start_dates->whereIn('unique_id', $course_update->start_date ? $course_update->start_date : [])->pluck('name')->toArray());
        } elseif ($request->type == 'date_selected') {
            \Session::put('program_date_selected', $request->value);
            $data['program_date_selected'] = \Session::get('program_date_selected');
            \Session::put('program_unique_id', $request->program_unique_id);
            $course_update = Course::where('unique_id', $request->value)->first();
            $data['program_unique'] = \Session::get('program_unique_id');

            $course_programs = CourseProgram::where('course_unique_id', $request->course_unique_id)->get();
            if ($course_programs->isEmpty()) {
                $course_programs = CourseProgram::where('unique_id', $request->program_unique_id)->get();
            }

            $program_start_date = null;
            $program_end_date = null;
            $date_set = substr($request->value, 6, 4) . "-" . substr($request->value, 3, 2) . "-" . substr($request->value, 0, 2);
            $course_program_start_date = \Carbon\Carbon::create($date_set);
            foreach ($course_programs as $course_program) {
                $loop_program_start_date = \Carbon\Carbon::create($course_program->program_start_date);
                $loop_program_end_date = \Carbon\Carbon::create($course_program->program_end_date);
                if (!$program_start_date) $program_start_date = $loop_program_start_date;
                if (!$program_end_date) $program_end_date = $loop_program_end_date;
                if ($loop_program_start_date < $program_start_date) $program_start_date = $loop_program_start_date;
                if ($loop_program_end_date > $program_end_date) $program_end_date = $loop_program_end_date;
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
                $selected = $request->program_duration && $program_duration == $request->program_duration ? 'selected' : '';
                $program_duration_html .= "<option value=".$program_duration." ".$selected.">".$program_duration." ".($program_duration == 1 ? __('Frontend.week') : __('Frontend.weeks'))."</option>";
            }
            $data['program_duration'] = $program_duration_html;

            $course_update = Course::where('unique_id', $course_unique_id)->first();
            $data['level_required'] = $course_update->program_level;
            $data['lessons_per_week'] = $course_update->lessons_per_week;
            $data['hours_per_week'] = $course_update->hours_per_week;

            $stuty_times = new ChooseStudyTime;
            $data['study_time'] = implode(", ", $stuty_times->whereIn('unique_id', $course_update->study_time ? $course_update->study_time : [])->pluck('name')->toArray());
            $classes_days = new ChooseClassesDay;
            $data['classes_days'] = implode(", ", $classes_days->whereIn('unique_id', $course_update->classes_day ? $course_update->classes_day : [])->pluck('name')->toArray());
            $start_dates = new ChooseStartDate;
            $data['start_date'] = implode(", ", $start_dates->whereIn('unique_id', $course_update->start_date ? $course_update->start_date : [])->pluck('name')->toArray());
        } elseif ($request->type == 'duration') {
            \Session::put('program_duration', $request->value);
            $course = Course::where('unique_id', \Session::get('course_unique_id'))->first();
            $course_program = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$request->value)->where('program_duration_end', '>=', (int)$request->value)
                ->with("course", "courseUnderAges", "courseTextBookFees")->first();

            $under_age = $request->under_age == null ? [] : $request->under_age;
            $under_age = !is_array($request->under_age) ? array($request->under_age) : $under_age;
            $program_age_ranges = ChooseProgramAge::whereIn('unique_id', $under_age)->pluck('age')->toArray();
            $program_under_age = ChooseProgramUnderAge::whereIn('age', $program_age_ranges)->value('unique_id');
            $program_under_age_fee_per_week = 0;
            foreach ($course_program->courseUnderAges as $program_course_under_age) {
                if (in_array($program_under_age, is_array($program_course_under_age->under_age) ? $program_course_under_age->under_age : [])) {
                    $program_under_age_fee_per_week = $program_course_under_age->under_age_fee_per_week;
                }
            }
            insertCalculationIntoDB('under_age_fee', $program_under_age_fee_per_week * $request->value);
            $program_text_book_fee = 0;
            foreach ($course_program->courseTextBookFees as $program_course_text_book) {
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
                $data['text_book_note'] = app()->getLocale() == 'en' ? $course_program->text_book_note : $course_program->text_book_note_ar;
            }

            if ($request->courier_fee == 'true') {
                insertCalculationIntoDB('courier_fee', $course_program->courier_fee ?? 0);
            } else {
                insertCalculationIntoDB('courier_fee', 0);
            }
            $data['courier_fee'] = $course_program->courier_fee ? true : false;
            $data['courier_fee_note'] = app()->getLocale() == 'en' ? $course_program->about_courier :  $course_program->about_courier_ar;

            $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
            $course_program_start_date = \Carbon\Carbon::create($date_set);
            $course_program_end_date = \Carbon\Carbon::create($date_set)->addWeeks($request->program_duration);
            if ($course_program->christmas_start_date && $course_program->christmas_end_date) {
                $program_christmas_start_date = \Carbon\Carbon::create($course_program->christmas_start_date);
                $program_christmas_end_date = \Carbon\Carbon::create($course_program->christmas_end_date);
                if (!$course_program_start_date->gte($program_christmas_end_date) && !$course_program_end_date->lte($program_christmas_start_date)) {
                    $data['christmas_notification'] = __('Frontend.school_will_close_christmas') . ' ' . __('Frontend.from') . ' ' 
                        . $course_program->christmas_start_date . ' ' . __('Frontend.to') . ' ' . $course_program->christmas_end_date;
                }
            }

            $r_date_set = $request->date_set;
            $r_duration = $request->value;
            $program_duration_start = $course_program->program_duration_start;
            $accommodation_under_ages = ChooseAccommodationAge::whereIn('age', $program_age_ranges)->pluck('unique_id')->toArray();
            $accommodations = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
                ->get()->collect()->values()->filter(function($value) use ($accommodation_under_ages, $r_date_set, $program_duration_start, $r_duration) {
                    $under_age_flag = in_array($accommodation_under_ages[0], $value['age_range'] ?? []);
                    $date_flag = false;
                    if ($r_date_set) {
                        $program_start_date = Carbon::create($r_date_set)->format('Y-m-d');
                        $program_end_date = Carbon::create($r_date_set)->addWeeks($r_duration)->format('Y-m-d');
                        if ($value['start_date'] <= $program_start_date && $value['end_date'] >= $program_end_date) {
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
                    return $under_age_flag && $date_flag;
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
            $add_program_cost = $course_program->program_cost;
            $multiple_program_cost = (int)$request->value * $add_program_cost;
            if ($request->date_set != null) {
                $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
                $this->calculator->setSummerDateFromDbProgram($course_program->summer_fee_end_date);
                $this->calculator->setPeakDateFromDbProgram($course_program->peak_time_end_date);
                $this->calculator->setSummerStartDateProgram($course_program->summer_fee_start_date);
                $this->calculator->setPeakStartDate($course_program->peak_time_start_date);
                $this->calculator->setPeakEndDate($course_program->peak_time_end_date);
                $this->calculator->setSummerFee($course_program->summer_fee_per_week);
                $this->calculator->setFrontEndDate(getEndDate($date_set, (int)$request->value));
                $this->calculator->setProgramStartDateFromFrontend(Carbon::create($date_set)->format('Y-m-d'));
                $this->calculator->setSummerEndDateProgram($course_program->summer_fee_end_date);

                $dates_and_get_result = $this->calculator->CompareDatesAndGetResult();
                $summer_week_fee = $course_program->summer_fee_per_week * $dates_and_get_result['summer_date_program'];
                $peakfee = $course_program->peak_time_fee_per_week * $dates_and_get_result['peak_date_program'];

                insertCalculationIntoDB('summer_fee', $summer_week_fee);
                insertCalculationIntoDB('peak_time_fee', $peakfee);
            }

            // Checking whether program duration is greater than the selected program duration and setting registration fee here
            if ($course_program->program_duration == null) {
                insertCalculationIntoDB('program_registration_fee', $course_program->program_registration_fee == null ? 0 : $course_program->program_registration_fee);
            } else {
                (int)$request->value >= $course_program->program_duration ? insertCalculationIntoDB('program_registration_fee', 0) : insertCalculationIntoDB('program_registration_fee', $course_program->program_registration_fee == null ? 0 : $course_program->program_registration_fee);
            }

            // Updating program cost here
            insertCalculationIntoDB('program_cost', $multiple_program_cost);

            insertCalculationIntoDB('bank_transfer_fee', $course_program->bank_transfer_fee == null ? 0 : $course_program->bank_transfer_fee);
            $data['link_fee_vat'] = $course_program->tax_percent;
            $data['link_fee'] = $course->link_fee_enable ? true : false;
            $course_link_fee = $course->link_fee_enable ? (($course_program->link_fee == null || $course_program->tax_percent == null) ? 0 : $course_program->link_fee + $course_program->link_fee * $course_program->tax_percent / 100) : 0;
            insertCalculationIntoDB('link_fee', getCurrencyReverseConvertedValue($course->unique_id, $course_link_fee));
            insertCalculationIntoDB('link_fee_converted', $course_link_fee);
        }

        if (!$request->program_unique_id || !$request->date_set || !$request->program_duration) {
            $this->initProgram();
        }

        return response($data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    private function initProgram()
    {
        insertCalculationIntoDB('program_cost', 0);
        insertCalculationIntoDB('program_registration_fee', 0);
        insertCalculationIntoDB('text_book_fee', 0);
        insertCalculationIntoDB('summer_fee', 0);
        insertCalculationIntoDB('under_age_fee', 0);
        insertCalculationIntoDB('courier_fee', 0);
        insertCalculationIntoDB('peak_time_fee', 0);
        insertCalculationIntoDB('discount_fee', 0);
        insertCalculationIntoDB('bank_transfer_fee', 0);
        insertCalculationIntoDB('link_fee', 0);
        insertCalculationIntoDB('link_fee_converted', 0);
        insertCalculationIntoDB('total', 0);
        $this->calculator->setTotalPrice();
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
        //$this->calculator->setChristmasFee(readCalculationFromDB('christmas_fee'));
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
        //$christmas_fee = readCalculationFromDB('christmas_fee') ?? 0;
        $under_age_fee = readCalculationFromDB('under_age_fee') ?? 0;
        $peak_time_fee = readCalculationFromDB('peak_time_fee') ?? 0;
        $courier_fee = readCalculationFromDB('courier_fee') ?? 0;
        $discount_fee = readCalculationFromDB('discount_fee') ?? 0;
        $bank_transfer_fee = readCalculationFromDB('bank_transfer_fee') ?? 0;
        $link_fee = readCalculationFromDB('link_fee') ?? 0;
        $link_fee_converted = readCalculationFromDB('link_fee_converted') ?? 0;
        $total = (readCalculationFromDB('total') ?? 0) - $discount_fee;
        $sub_total = $this->calculator->SubTotalCalculation();
        $total_cost = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $program_cost,
                $registration_fee,
                $text_book_fee,
                $summer_fee,
                // $christmas_fee,
                $under_age_fee,
                $peak_time_fee,
                $courier_fee,
                $discount_fee,
                $total,
                $sub_total,
                $bank_transfer_fee,
                $total_cost,
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
        // $data['christmas_fee'] = [
        //     'value' => $christmas_fee,
        //     'converted_value' => $calculator_values['values'][4]
        // ];
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
            'value' => $total,
            'converted_value' => $calculator_values['values'][8]
        ];
        $data['sub_total'] = [
            'value' => $sub_total,
            'converted_value' => $calculator_values['values'][9]
        ];
        $data['bank_transfer_fee'] = [
            'value' => $bank_transfer_fee,
            'converted_value' => $calculator_values['values'][10]
        ];
        $data['link_fee'] = [
            'value' => $link_fee,
            'converted_value' => $link_fee_converted
        ];
        $data['total_cost'] = [
            'value' => $total_cost,
            'converted_value' => $calculator_values['values'][11]
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function discountCalculate(Request $request)
    {
        if ($request->has('reload')) {
            reloadInsertCalculationIntoDB();
        }

        $data = array();
        if ($request->has('value')) {
            $course_program = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$request->value)
                ->where('program_duration_end', '>=', (int)$request->value)->first();
            
            $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
            if ($course_program) {
                $week_selected_discount = $this->calculator->calculateDiscountWeekFree($request->value, $course_program->x_week_selected);
                $data['discount_fee'] = $week_selected_discount;

                if (checkBetweenDate($course_program->x_week_start_date, $course_program->x_week_end_date, Carbon::now()->format('Y-m-d')) || 
                    (checkBetweenDate($course_program->discount_start_date, $course_program->discount_end_date, Carbon::now()->format('Y-m-d')))) {
                    $this->calculator->setProgramStartDateFromFrontend($date_set);
                    $this->calculator->setDiscountStartDateForWeekSelect($course_program->x_week_start_date);
                    $this->calculator->setDiscountEndDateForWeekSelect($course_program->x_week_end_date);
                    $this->calculator->setHowManyWeekFree($course_program->how_many_week_free);
                    $this->calculator->setProgramDuration($request->value);
                    $this->calculator->setDiscountWeekGet($course_program->x_week_selected);
                    $this->calculator->setDiscountStartDate($course_program->discount_start_date);
                    $this->calculator->setDiscountEndDate($course_program->discount_end_date);
                    $this->calculator->setProgramCost($course_program->program_cost * $request->value);
                    $this->calculator->setProgramStartDate($course_program->program_start_date);
                    $this->calculator->setProgramEndDate($course_program->program_end_date);
                    $this->calculator->setDiscount($course_program->discount_per_week);
                    $this->calculator->setFrontEndDate(getEndDate($date_set, $request->value));
                    $this->calculator->setFixedProgramCost($course_program->program_cost);
                    $this->calculator->setDiscountEndDate($course_program->discount_end_date);
                    $this->calculator->setGetProgramWeeks($request->value);
                } else {
                    insertCalculationIntoDB('discount_fee', 0);
                }
                $data['discount'] = $this->calculator->discountedTotal();
                $data['request'] = $request->all();
                $data['program'] = $course_program;
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
        $lang = app()->getLocale();
        $accommodation_query = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if (app()->getLocale() == 'en') {
                    $query->where('type', $request->accom_type)->where('room_type', $request->room_type)->where('meal', $request->meal_type);
                } else {
                    $query->where('type_ar', $request->accom_type)->where('room_type_ar', $request->room_type)->where('meal_ar', $request->meal_type);
                }
            });
        $accommodation = $accommodation_query->where('start_week', '<=', (int)$request->duration)
            ->where('end_week', '>=', (int)$request->duration)
            ->first();

        if ($accommodation) {
            $data['special_diet'] = $accommodation->special_diet_fee;
            $data['special_diet_note'] = $accommodation->special_diet_note;
            $data['unique_id'] = $accommodation->unique_id;
    
            $date_set = substr($request->date_set, 6, 4) . "-" . substr($request->date_set, 3, 2) . "-" . substr($request->date_set, 0, 2);
            $this->calculator->setAccommodationFee($accommodation->fee_per_week * $request->duration);
            ($accommodation->program_duration && $request->program_duration >= $accommodation->program_duration) ? $this->calculator->setAccommodationPlacementFee(0) : $this->calculator->setAccommodationPlacementFee($accommodation->placement_fee ?? 0);
            $this->calculator->setAccommodationChristmasStartDate($accommodation->christmas_fee_start_date);
            $this->calculator->setAccommodationChristmasEndDate($accommodation->christmas_fee_end_date);
            $deposit = $accommodation->deposit_fee == null ? 0 : $accommodation->deposit_fee;
            $this->calculator->setAccommodationDeposit($deposit);
            $this->calculator->setAccommodationSummerEndDate($accommodation->summer_fee_end_date);
            $request->special_diet == 'true' ? $this->calculator->setAccommodationSpecialDietFee($accommodation->special_diet_fee * $request->duration) : $this->calculator->setAccommodationSpecialDietFee(0);
            $this->calculator->setAccommodationPeakStartDate($accommodation->peak_time_fee_start_date);
            $this->calculator->setAccommodationPeakEndDate($accommodation->peak_time_fee_end_date);
            $program_age_range = ChooseProgramAge::where('unique_id', $request->age)->first();
            $request_age = 0;
            if ($program_age_range) {
                $request_age = $program_age_range->age;
            }
            $under_age_fee_per_week = 0;
            $accommodation_under_age = ChooseAccommodationUnderAge::where('age', $request_age)->first();
            $course_accommodation_under_ages = CourseAccommodationUnderAge::where('accom_id', '' . $accommodation->unique_id)->get();
            if ($accommodation_under_age && $course_accommodation_under_ages) {
                foreach ($course_accommodation_under_ages as $course_accommodation_under_age) {
                    if (in_array($accommodation_under_age->unique_id, is_array($course_accommodation_under_age->under_age) ? $course_accommodation_under_age->under_age : [])) {
                        $under_age_fee_per_week += $course_accommodation_under_age->under_age_fee_per_week;
                    }
                }
            }
            $this->calculator->setAccommodationUnderageFee($under_age_fee_per_week * (int)$request->duration);
            $this->calculator->setFrontEndDate(getEndDate($date_set, (int)$request->duration));
            $this->calculator->setProgramStartDateFromFrontend(Carbon::create($date_set)->format('Y-m-d'));
            $this->calculator->setAccommodationSummerStartDate($accommodation->summer_fee_start_date);
            $this->calculator->setAccommodationSummerEndDate($accommodation->summer_fee_end_date);
            $this->calculator->setAccommodationDuration((int)$request->duration);
            $this->calculator->setAccommodationDiscountEndDate($accommodation->discount_end_date);
            $this->calculator->setAccommodationFeePerWeek($accommodation->fee_per_week);
            $this->calculator->setAccommodationXWeekSelected($accommodation->x_week_selected);
            $this->calculator->setAccommodationXWeekStartDate($accommodation->x_week_start_date);
            $this->calculator->setAccommodationXWeekEndDate($accommodation->x_week_end_date);
            $this->calculator->setAccommodationXWeekFee($accommodation->how_many_week_free);
    
            // Check for dates
            $dates_and_get_weeks_accommodation = $this->calculator->CompareDatesandGetWeeksAccommodation();
            $this->calculator->setAccommodationChristmasFee($accommodation->christmas_fee_per_week * $dates_and_get_weeks_accommodation['christmas']);
            $this->calculator->setAccommodationDiscount($accommodation->discount_per_week);
            $this->calculator->setAccommodationPeakFee($accommodation->peak_time_fee_per_week * $dates_and_get_weeks_accommodation['peak']);
            $this->calculator->setAccommodationSummerFee($accommodation->summer_fee_per_week * $dates_and_get_weeks_accommodation['summer']);
            $this->calculator->setAccommodationDiscountStartDate($accommodation->discount_start_date);
        }
        
        $accom_fee = $this->calculator->getAccommodationFee();
        $placement_fee = $this->calculator->getAccommodationPlacementFee();
        $special_diet_fee = $this->calculator->getAccommodationSpecialDietFee();
        $deposit_fee = $this->calculator->getAccommodationDeposit();
        $summer_fee = $this->calculator->getAccommodationSummerFee();
        $christmas_fee = $this->calculator->getAccommodationChristmasFee();
        $under_age_fee = $this->calculator->getAccommodationUnderageFee();
        $peak_fee = $this->calculator->getAccommodationPeakFee();
        $discount_fee = $this->calculator->resultAccommodationDiscount();
        $total_calculation = $this->calculator->calculateOnlyAccommodationTotal() - $discount_fee;
        $sub_total = $this->calculator->SubTotalCalculation();
        $total_cost = $this->calculator->TotalCalculation();

        insertCalculationIntoDB('accommodation_fee', $accom_fee);
        insertCalculationIntoDB('accommodation_placement_fee', $placement_fee);
        insertCalculationIntoDB('accommodation_special_diet_fee', $special_diet_fee);
        insertCalculationIntoDB('accommodation_deposit', $deposit_fee);
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
                $summer_fee,
                $christmas_fee,
                $under_age_fee,
                $peak_fee,
                $discount_fee,
                $total_calculation,
                $sub_total,
                $total_cost
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
        $data['summer_fee'] = [
            'value' => $summer_fee,
            'converted_value' => $calculator_values['values'][4]
        ];
        $data['christmas_fee'] = [
            'value' => $christmas_fee,
            'converted_value' => $calculator_values['values'][5]
        ];
        $data['under_age_fee'] = [
            'value' => $under_age_fee,
            'converted_value' => $calculator_values['values'][6]
        ];
        $data['peak_fee'] = [
            'value' => $peak_fee,
            'converted_value' => $calculator_values['values'][7]
        ];
        $data['discount_fee'] = [
            'value' => $discount_fee,
            'converted_value' => $calculator_values['values'][8]
        ];
        $data['total'] = [
            'value' => $total_calculation,
            'converted_value' => $calculator_values['values'][9]
        ];
        $data['sub_total'] = [
            'value' => $sub_total,
            'converted_value' => $calculator_values['values'][10]
        ];
        $data['total_cost'] = [
            'value' => $total_cost,
            'converted_value' => $calculator_values['values'][11]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        return response($data);
    }

    /**
     * @return bool
     */
    public function resetAccommodation()
    {
        insertCalculationIntoDB('accommodation_fee', 0);
        insertCalculationIntoDB('accommodation_placement_fee', 0);
        insertCalculationIntoDB('accommodation_special_diet_fee', 0);
        insertCalculationIntoDB('accommodation_deposit', 0);
        insertCalculationIntoDB('accommodation_summer_fee', 0);
        insertCalculationIntoDB('accommodation_christmas_fee', 0);
        insertCalculationIntoDB('accommodation_under_age_fee', 0);
        insertCalculationIntoDB('accommodation_discount', 0);
        insertCalculationIntoDB('accommodation_peak_time_fee', 0);
        insertCalculationIntoDB('accommodation_total', 0);

        return true;
    }

    /**
     * @return bool
     */
    public function resetOtherService()
    {
        insertCalculationIntoDB('airport_pickup_fee', 0);
        insertCalculationIntoDB('medical_insurance_fee', 0);
        insertCalculationIntoDB('custodian_fee', 0);
        return true;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getRoomTypeAndMealType(Request $request)
    {
        $course_program = CourseProgram::where('unique_id', \Session::get('program_unique_id'))->first();
        $program_age_range = ChooseProgramAge::where('unique_id', $request->age_selected)->value('age');
        $r_date_set = \Session::get('program_date_selected');
        $r_duration = \Session::get('program_duration');
        $program_duration_start = $course_program->program_duration_start;
        $accommodation_under_age = ChooseAccommodationAge::where('age', $program_age_range)->value('unique_id');
        
        $course_accommodations = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
            ->get()->collect()->values()->filter(function($value) use ($request, $accommodation_under_age, $r_date_set, $program_duration_start, $r_duration) {
                $under_age_flag = in_array($accommodation_under_age, $value['age_range'] ?? []);
                $date_flag = false;
                if ($r_date_set) {
                    if ($value['available_date'] == 'all_year_round') {
                        $program_start_date = Carbon::create($r_date_set)->format('Y-m-d');
                        $program_end_date = Carbon::create($r_date_set)->addWeeks($r_duration)->format('Y-m-d');
                        if ($value['start_date'] <= $program_start_date && $value['end_date'] >= $program_end_date) {
                            $date_flag = true;
                        }
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
                } else {
                    $date_flag = true;
                }
                $type_flag = false;
                    if ($value['type'] == $request->accom_type || $value['type_ar'] == $request->accom_type) {
                        $type_flag = true;
                    }
                return $under_age_flag && $date_flag && $type_flag;
            })->all();

        $room_types = $meal_types = [];
        foreach ($course_accommodations as $course_accommodation) {
            $room_types[] = app()->getLocale() == 'en' ? $course_accommodation->room_type : $course_accommodation->room_type_ar;
            $meal_types[] = app()->getLocale() == 'en' ? $course_accommodation->meal : $course_accommodation->meal_ar;
        }
        $room_types = array_unique($room_types);
        $meal_types = array_unique($meal_types);

        $select = __('Frontend.select_option');
        $data['room_type'] = "<option value='' selected>$select</option>";
        $data['meal_type'] = "<option value='' selected>$select</option>";

        foreach ($room_types as $room_type) {
            $data['room_type'] .= "<option value='" . $room_type . "'>" . $room_type . "</option>";
        }
        foreach ($meal_types as $meal_type) {
            $data['meal_type'] .= "<option value='" . $meal_type . "'>" . $meal_type . "</option>";
        }
        $data['session'] = \Session::all();

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getMealType(Request $request)
    {
        $course_program = CourseProgram::where('unique_id', \Session::get('program_unique_id'))->first();
        $program_age_range = ChooseProgramAge::where('unique_id', $request->age_selected)->value('age');
        $r_date_set = \Session::get('program_date_selected');
        $r_duration = \Session::get('program_duration');
        $program_duration_start = $course_program->program_duration_start;
        $accommodation_under_age = ChooseAccommodationAge::where('age', $program_age_range)->value('unique_id');
        
        $course_accommodations = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
            ->get()->collect()->values()->filter(function($value) use ($request, $accommodation_under_age, $r_date_set, $program_duration_start, $r_duration) {
                $under_age_flag = in_array($accommodation_under_age, $value['age_range'] ?? []);
                $date_flag = false;
                if ($r_date_set) {
                    if ($value['available_date'] == 'all_year_round') {
                        $program_start_date = Carbon::create($r_date_set)->format('Y-m-d');
                        $program_end_date = Carbon::create($r_date_set)->addWeeks($r_duration)->format('Y-m-d');
                        if ($value['start_date'] <= $program_start_date && $value['end_date'] >= $program_end_date) {
                            $date_flag = true;
                        }
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
                } else {
                    $date_flag = true;
                }
                $type_flag = false;
                if ($value['type'] == $request->accom_type || $value['type_ar'] == $request->accom_type) {
                    $type_flag = true;
                }
                $room_flag = false;
                if ($value['room_type'] == $request->room_type || $value['room_type_ar'] == $request->room_type) {
                    $room_flag = true;
                }
                return $under_age_flag && $date_flag && $type_flag && $room_flag;
            })->all();

        $meal_types = [];
        foreach ($course_accommodations as $course_accommodation) {
            $meal_types[] = app()->getLocale() == 'en' ? $course_accommodation->meal : $course_accommodation->meal_ar;
        }
        $meal_types = array_unique($meal_types);

        $select = __('Frontend.select_option');
        $data['meal_type'] = "<option value='' selected>$select</option>";
        foreach ($meal_types as $meal_type) {
            $data['meal_type'] .= "<option value='".$meal_type."'>".$meal_type."</option>";
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
        $lang = app()->getLocale();
        $christmas_weeks = 0;
        $course_programs = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))->get();
        if ($course_programs->isEmpty()) {
            $course_programs = CourseProgram::where('unique_id', \Session::get('program_unique_id'))->get();
        }
        $date_set = substr(\Session::get('program_date_selected'), 6, 4) . "-" . substr(\Session::get('program_date_selected'), 3, 2) . "-" . substr(\Session::get('program_date_selected'), 0, 2);
        $course_program_start_date = \Carbon\Carbon::create($date_set);
        $course_program_end_date = \Carbon\Carbon::create($date_set)->addWeeks($request->program_duration);
        foreach ($course_programs as $course_program) {
            if ($course_program->program_duration_start <= $request->program_duration && $request->program_duration <= $course_program->program_duration_end) {
                if ($course_program->christmas_start_date && $course_program->christmas_end_date) {
                    $loop_program_christmas_start_date = \Carbon\Carbon::create($course_program->christmas_start_date);
                    $loop_program_christmas_end_date = \Carbon\Carbon::create($course_program->christmas_end_date);
                    if (!$course_program_start_date->gt($loop_program_christmas_end_date) && !$course_program_end_date->lt($loop_program_christmas_start_date)) {
                        if ($course_program_start_date->lte($loop_program_christmas_start_date) && $course_program_end_date->gte($loop_program_christmas_end_date)) {
                            $christmas_weeks = $loop_program_christmas_end_date->diffInWeeks($loop_program_christmas_start_date);
                        } elseif ($course_program_start_date->lte($loop_program_christmas_start_date) && $course_program_end_date->lte($loop_program_christmas_end_date)) {
                            $christmas_weeks = $course_program_end_date->diffInWeeks($loop_program_christmas_start_date);
                        } elseif ($course_program_start_date->gte($loop_program_christmas_start_date) && $course_program_start_date->lte($loop_program_christmas_end_date)) { 
                            $christmas_weeks = $course_program_end_date->diffInWeeks($course_program_start_date);
                        } elseif ($course_program_start_date->gte($loop_program_christmas_start_date) && $course_program_start_date->gte($loop_program_christmas_end_date)) {
                            $christmas_weeks = $loop_program_christmas_end_date->diffInWeeks($course_program_start_date);
                        }
                    }
                }
            }
        }

        $accommodations = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('type', $request->accom_type)->where('room_type', $request->room_type)->where('meal', $request->meal_type);
                } else {
                    $query->where('type_ar', $request->accom_type)->where('room_type_ar', $request->room_type)->where('meal_ar', $request->meal_type);
                }
            })->get();

        $accommodation_durations = [];
        $accommodation_id = 0;
        foreach ($accommodations as $accommodation) {
            if (!$accommodation_id) $accommodation_id = $accommodation->unique_id;
            $min_duration = (int)$accommodation->start_week;
            $max_duration = (int)$accommodation->end_week + $christmas_weeks;
            for ($loop_duration = $min_duration; $loop_duration <= $max_duration; $loop_duration++) {
                if ($loop_duration <= $request->program_duration + $christmas_weeks) {
                    if ($accommodation->available_date == 'selected_dates') {
                        if ($accommodation->available_days) {
                            $accommodation_duration_date = \Carbon\Carbon::create($date_set)->addWeeks($loop_duration)->format('m/d/Y');
                            if (strpos($accommodation->available_days, $accommodation_duration_date) != false) {
                                if (!in_array($loop_duration, $accommodation_durations)) {
                                    $accommodation_durations[] = $loop_duration;
                                }
                            }
                        }
                    } else {
                        if (!in_array($loop_duration, $accommodation_durations)) {
                            $accommodation_durations[] = $loop_duration;
                        }
                    }
                }
            }
        }
        sort($accommodation_durations);

        $select = __('Admin/backend.select');
        $duration_html = "<option value='' selected>$select</option>";
        foreach ($accommodation_durations as $duration) {
            $duration_html .= "<option value=".$duration.">".$duration." ".($duration == 1 ? __('Frontend.week') : __('Frontend.weeks'))."</option>";
        }

        $data['duration'] = $duration_html;
        $data['accommodation_id'] = $accommodation_id;

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getAirportNames(Request $request)
    {
        $lang = app()->getLocale();
        $airport_unique_ids = CourseAirport::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('service_provider', $request->service_provider);
                } else {
                    $query->where('service_provider_ar', $request->service_provider);
                }
            })->pluck('unique_id');

        $select = __('Frontend.select_option');
        $data = "<option value='' selected>$select</option>";

        if ($lang == 'en') {
            $airport_fee_names = CourseAirportFee::whereIn('course_airport_unique_id', $airport_unique_ids)->get()->unique('name')->values()->all();
            foreach ($airport_fee_names as $airport_fee_name) {
                $data .= "<option value='" . $airport_fee_name->name . "'>" . $airport_fee_name->name . "</option>";
            }
        } else {
            $airport_fee_names = CourseAirportFee::whereIn('course_airport_unique_id', $airport_unique_ids)->get()->unique('name_ar')->values()->all();
            foreach ($airport_fee_names as $airport_fee_name) {
                $data .= "<option value='" . $airport_fee_name->name_ar . "'>" . $airport_fee_name->name_ar . "</option>";
            }
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getAirportServiceNames(Request $request)
    {
        $lang = app()->getLocale();
        $airport_unique_ids = CourseAirport::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('service_provider', $request->service_provider);
                } else {
                    $query->where('service_provider_ar', $request->service_provider);
                }
            })->pluck('unique_id');

        $select = __('Frontend.select_option');
        $data = "<option value='' selected>$select</option>";

        if ($lang == 'en') {
            $airport_fee_service_names = CourseAirportFee::whereIn('course_airport_unique_id', $airport_unique_ids)
                ->where('name', $request->name)->pluck('service_name');
            foreach ($airport_fee_service_names as $airport_fee_service_name) {
                $data .= "<option value='".$airport_fee_service_name."'>".$airport_fee_service_name."</option>";
            }
        } else {
            $airport_fee_service_names = CourseAirportFee::whereIn('course_airport_unique_id', $airport_unique_ids)
                ->where('name_ar', $request->name)->pluck('service_name_ar');
            foreach ($airport_fee_service_names as $airport_fee_service_name) {
                $data .= "<option value='".$airport_fee_service_name."'>".$airport_fee_service_name."</option>";
            }
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getMedicalDeductibles(Request $request)
    {
        $lang = app()->getLocale();
        $medical_deductibles = CourseMedical::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('company_name', $request->company_name);
                } else {
                    $query->where('company_name_ar', $request->company_name);
                }
            })->pluck('deductible');

        $select = __('Frontend.select_option');
        $data = "<option value='' selected>$select</option>";

        foreach ($medical_deductibles as $medical_deductible) {
            $data .= "<option value='".$medical_deductible."'>".$medical_deductible."</option>";
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function getMedicalDurations(Request $request)
    {
        $lang = app()->getLocale();
        $medical_unique_ids = CourseMedical::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('company_name', $request->company_name);
                } else {
                    $query->where('company_name_ar', $request->company_name);
                }
            })->where('deductible', $request->deductible)->pluck('unique_id');

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
        
        $select = __('Frontend.select_option');
        $data = "<option value='' selected>$select</option>";

        for ($duration = $min_week; $duration <= $max_week; $duration++) {
            $data .= "<option value=".$duration.">".$duration." ".($duration == 1 ? __('Frontend.week') : __('Frontend.weeks'))."</option>";
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function setAirportFee(Request $request)
    {
        $lang = app()->getLocale();
        $airport = CourseAirport::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('service_provider', $request->service_provider);
                } else {
                    $query->where('service_provider_ar', $request->service_provider);
                }
            })->whereHas('fees', function ($query) use($request, $lang) {
                if ($lang == 'en') {
                    $query->where('name', $request->name)->where('service_name', $request->service_name);
                } else {
                    $query->where('name_ar', $request->name)->where('service_name_ar', $request->service_name);
                }
            })->first();

        $airport_pickup_fee = 0;
        $data['week_selected_fee'] = $airport_week_selected_fee = $airport ? (int)$airport->week_selected_fee : 0;
        $data['airport_id'] = $airport->unique_id;
        $data['airport_fee_id'] = 0;
        $data['airport_note'] = $airport->note;
        if ($airport_week_selected_fee) {
            if ($airport_week_selected_fee <= $request->program_duration) {
                foreach ($airport->fees as $airport_fee) {
                    $airport_pickup_fee = $airport_fee->service_fee;
                    $data['airport_fee_id'] = $airport_fee->unique_id;
                }
            }
        }
        $this->calculator->setAirportPickupFee($airport_pickup_fee);
        $airport_pickup_fee = $this->calculator->getAirportPickupFee();
        insertCalculationIntoDB('airport_pickup_fee', $airport_pickup_fee);

        $default_currency = getDefaultCurrency();

        $data_fee = $this->calculator->getAirportPickupFee();
        $sub_total = $this->calculator->SubTotalCalculation();
        $total_cost = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $data_fee,
                $sub_total,
                $total_cost,
            ]
        );
        $data['airport_fee'] = [
            'value' => $data_fee,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['sub_total'] = [
            'value' => $sub_total,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['total_cost'] = [
            'value' => $total_cost,
            'converted_value' => $calculator_values['values'][2]
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
        $lang = app()->getLocale();
        $medical = CourseMedical::whereCourseUniqueId(\Session::get('course_unique_id'))
            ->where(function($query) use ($request, $lang) {
                if ($lang == 'en') {
                    $query->where('company_name', $request->service_provider);
                } else {
                    $query->where('company_name_ar', $request->company_name);
                }
            })->where('deductible', $request->deductible)->with('fees', function ($query) use($request) {
                return $query->where('start_date', '<=', $request->duration)->where('end_date', '>=', $request->duration);
            })->first();

        $medical_insurance_fee = 0;
        $medical_week_selected_fee = $medical ? (int)$medical->week_selected_fee : 0;
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
        $sub_total = $this->calculator->SubTotalCalculation();
        $total_cost = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $data_fee,
                $sub_total,
                $total_cost,
            ]
        );
        $data['medical_fee'] = [
            'value' => $data_fee,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['sub_total'] = [
            'value' => $sub_total,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['total_cost'] = [
            'value' => $total_cost,
            'converted_value' => $calculator_values['values'][2]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        $data['request'] = $request->all();

        return response($data);
    }

    public function setOtherServiceFee(Request $request)
    {
        $lang = app()->getLocale();
        if ($request->airport_service_provider && $request->airport_name && $request->airport_service) {
            $airport = CourseAirport::whereHas('fees', function($query) use($request, $lang) {
                $query->where(function($sub_query) use ($request, $lang) {
                    if ($lang == 'en') {
                        $sub_query->where('name', $request->airport_name);
                    } else {
                        $sub_query->where('name_ar', $request->airport_name);
                    }
                })->where(function($sub_query) use ($request, $lang) {
                    if ($lang == 'en') {
                        $sub_query->where('service_name', $request->airport_service);
                    } else {
                        $sub_query->where('service_name_ar', $request->airport_service);
                    }
                });
            })->whereCourseUniqueId(\Session::get('course_unique_id'))->first();
        }
        $airport_pickup_fee = 0;
        if (!empty($airport)) {
            $data['airport_id'] = $airport->unique_id;
            $data['airport_fee_id'] = 0;
            $data['airport_note'] = $airport->note;
            $airport_week_selected_fee = (int)$airport->week_selected_fee;
            if (($airport_week_selected_fee && $airport_week_selected_fee > $request->program_duration) || !$airport_week_selected_fee) {
                foreach ($airport->fees as $airport_fee) {
                    $data['airport_fee_id'] = $airport_fee->unique_id;
                    $airport_pickup_fee = $airport_fee->service_fee;
                }
            }
        }
        $this->calculator->setAirportPickupFee($airport_pickup_fee);
        insertCalculationIntoDB('airport_pickup_fee', $airport_pickup_fee);

        if ($request->medical_company_name && $request->medical_deductible && $request->medical_duration) {
            $medical = CourseMedical::whereHas('fees', function($query) use($request, $lang) {
                    if ($request->duration) {
                        $query->where('start_date', '<=', $request->duration)->where('end_date', '>=', $request->duration);
                    }
                })->where(function($query) use ($request, $lang) {
                    if ($lang == 'en') {
                        $query->where('company_name', $request->medical_company_name);
                    } else {
                        $query->where('company_name_ar', $request->medical_company_name);
                    }
                })->whereCourseUniqueId(\Session::get('course_unique_id'))
                ->where('deductible', $request->medical_deductible)->first();
        }
        $medical_insurance_fee = 0;
        if (!empty($medical)) {
            $data['medical_id'] = $medical->unique_id;
            $data['medical_note'] = $medical->note;
            $medical_week_selected_fee = (int)$medical->week_selected_fee;
            if (($medical_week_selected_fee && $medical_week_selected_fee > $request->program_duration) || !$medical_week_selected_fee) {
                foreach ($medical->fees as $medical_fee) {
                    if ($medical_fee->start_date <= $request->medical_duration && $medical_fee->end_date >= $request->medical_duration) {
                        $medical_insurance_fee += $medical_fee->fees_per_week * ($request->medical_duration - $medical_fee->start_date + 1);
                    }
                }
            }
        }
        $this->calculator->setMedicalInsuranceFee($medical_insurance_fee);
        insertCalculationIntoDB('medical_insurance_fee', $medical_insurance_fee);
        
        $custodian_fee = 0;
        $program_age_range = ChooseProgramAge::where('unique_id', $request->under_age)->first();
        $custodian_under_age = ChooseCustodianUnderAge::where('age', $program_age_range ? $program_age_range->age : '')->value('unique_id');
        $custodian = CourseCustodian::where('course_unique_id', \Session::get('course_unique_id'))->where('age_range', 'LIKE', '%' . $custodian_under_age . '%')->first();
        $custodian_fee_flag = false;
        if ($custodian) {
            if ($custodian->condition == 'required') {
                $custodian_fee_flag = true;
            } else {
                if ($request->custodianship == 'true') {
                    $custodian_fee_flag = true;
                }
            }
        }
        if ($custodian_fee_flag) {
            $custodian_fee = $custodian->fee;
        }
        $this->calculator->setCustodianFee($custodian_fee);
        insertCalculationIntoDB('custodian_fee', $custodian_fee);
       
        $default_currency = getDefaultCurrency();
        
        $airport_pickup_fee = $this->calculator->getAirportPickupFee();
        $medical_insurance_fee = $this->calculator->getMedicalInsuranceFee();
        $custodian_fee = $this->calculator->getCustodianFee();
        $sub_total = $this->calculator->SubTotalCalculation();
        $total_cost = $this->calculator->TotalCalculation();
        $calculator_values = getCurrencyConvertedValues($this->getCourseId(),
            [
                $airport_pickup_fee,
                $medical_insurance_fee,
                $custodian_fee,
                $airport_pickup_fee + $medical_insurance_fee + $custodian_fee,
                $sub_total,
                $total_cost,
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
        $data['custodian_fee'] = [
            'value' => $custodian_fee,
            'converted_value' => $calculator_values['values'][2]
        ];
        $data['total'] = [
            'value' => $airport_pickup_fee + $medical_insurance_fee + $custodian_fee,
            'converted_value' => $calculator_values['values'][3]
        ];
        $data['sub_total'] = [
            'value' => $sub_total,
            'converted_value' => $calculator_values['values'][4]
        ];
        $data['total_cost'] = [
            'value' => $total_cost,
            'converted_value' => $calculator_values['values'][5]
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