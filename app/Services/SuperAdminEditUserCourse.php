<?php

namespace App\Services;

use App\Classes\AccommodationCalculator;

use App\Models\Calculator;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\UserCourseBookedDetails;
use App\Models\UserCourseBookedFee;

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

        $this->userbookfeemodel = UserCourseBookedDetails::find($this->usercourseid);
    }

    /**
     * @return bool
     */
    public function create_calculator_db()
    {
        if (str_contains(url()->previous(), 'editUserCourse') && !Calculator::whereCalcId(request()->ip())->first()) {
            $booked = UserCourseBookedFee::where('user_course_booked_details_id', $this->usercourseid)->first();

            $replicate = $booked->replicate(['ip', 'user_course_booked_details_id', 'deleted_at'])->setTable('calculators');
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
            $inpu['airport_total'] = 0;
            $inpu['total'] = 0;

            return $calculator->fill($inpu)->save();
        }

        return true;
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function calculatorCourse(Request $r)
    {
        $data['is_true'] = true;
        $select = __('SuperAdmin/backend.select_option');

        $data['is_true'] = false;
        $data['success'] = false;
        $data['success'] = true;

        $url = url()->previous();
        $explode = explode('/', $url);
        $data['previous_url'] = $school_id = end($explode);

        if ($r->type == 'requested_for_under_age') {
            $programs = Course::where('school_id', $school_id)->where('study_mode', 'LIKE', '%' . $r->study_mode . '%')->get();
            $course_unique_id = [];
            foreach ($programs as $program) {
                $course_unique_id[] = $program->unique_id;
            }

            $programs = CourseProgram::where('program_age_range', 'LIKE', '%' . $r->under_age . '%')->whereIn('course_unique_id', $course_unique_id)->get();

            $programs = collect($programs)->unique('course_unique_id')->values()->all();
            $option = "<option value=''> $select</option>";
            foreach ($programs as $program) {
                $program_name = $program->course->program_name;
                $selected = $r->course_program_unique_id && $r->course_program_unique_id == $program->unique_id ? 'selected' : '';
                $option .= "<option $selected  value=$program->course_unique_id data-id= $program->unique_id>$program_name </option>";
            }

            $data['program_get'] = $option;
        } elseif ($r->type == 'select_program') {
            $k = "<option value=''> $select</option>";
            \Session::put('program_unique_id', $r->value);
            $data['program_unique'] = \Session::get('program_unique_id');
            $program_get = CourseProgram::where('course_unique_id', $r->value)->get();
            if ($program_get->isEmpty()) {
                $program_get = CourseProgram::where('unique_id', $r->program_unique_id)->get();
            }
            $end_date = CourseProgram::where('unique_id', $r->program_unique_id)->first()['program_end_date'];
            $data['end_date'] = \Carbon\Carbon::create($end_date)->format('d-m-Y');
            $program_duration_start = [];
            $program_duration_end = [];
            foreach ($program_get as $program) {
                $program_duration_start[] = $program->program_duration_start;
                $program_duration_end[] = $program->program_duration_end;

            }
            $minimum_duration = min($program_duration_start);
            $max_duration = max($program_duration_end);

            for ($i = $minimum_duration; $i <= $max_duration; $i++) {
                $selected = $r->program_duration && $i == $r->program_duration ? 'selected' : '';
                $k .= "<option value= $i $selected> $i</option>";
            }
            $data['program_duration'] = $k;

            $course_update = Course::where('unique_id', $r->value)->first();

            $data['level_required'] = $course_update->program_level;
            $data['lessons_per_week'] = $course_update->lessons_per_week;
            $data['hours_per_week'] = $course_update->hours_per_week;
            $data['study_time'] = implode(", ", $course_update->study_time);
            $data['every_day'] = implode(", ", $course_update->every_day);
        } elseif ($r->type == 'duration') {
            /*
             * Program get variable changes here
             *
             * */
            $program_get = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('program_duration_start', '<=', (int)$r->value)
                ->where('program_duration_end', '>=', (int)$r->value)
                ->with("course")->first();

            $under_age = $r->under_age == null ? [] : $r->under_age;
            $under_age = !is_array($r->under_age) ? array($r->under_age) : $under_age;
            $data['value'] = in_array($under_age, $program_get->getUnderAge()) ? insertCalculationIntoDB('under_age_fee', $program_get->getUnderAgeFees($r->under_age) * $r->value) : insertCalculationIntoDB('under_age_fee', 0);

            $accoms = CourseAccommodation::where('course_unique_id', \Session::get('course_unique_id'))
                ->where('age_range', 'LIKE', '%' . $r->under_age . '%')
                ->get()->collect()->unique('type')->values()->all();

            $select = __('SuperAdmin/backend.select');
            $option = "<option value= ''>$select</option>";
            foreach ($accoms as $accom) {
                $selected = $r->has('accom_id') && $r->accom_id == $accom->unique_id ? 'selected' : '';
                $option .= "<option  value='$accom->unique_id' $selected >$accom->type</option>";
            }

            $data['accomodations'] = $option;
            $data['airport'] = '';
            $program_gets = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))->with("course")->first();
            $get_accom = $program_gets->course->accomodation ? true : false;
            if ($get_accom) {
                $airport_data = CourseAirport::whereCourseUniqueId(getCourseUniqueId())->get();

                $airport_data = collect($airport_data)->unique('airport_name_'.get_language())->values()->all();
                $data['airport'] = "<option value=''> $select</option>";
                foreach ($airport_data as $program) {
                    $airportname = $program->name_en;

                    $selected = isset($this->userbookfeemodel->airport_id)  && $this->userbookfeemodel->airport_id >0 && $this->userbookfeemodel->airport_id  == $program->unique_id ? 'selected' : '';
                    $data['airport'] .= "<option value= $program->unique_id $selected >$airportname </option>";
                }
            } else {
                $data['is_true'] = false;
            }
            $add_program_cost = $program_get->program_cost;

            // multiplying program cost here
            $multiple_program_cost = (int)$r->value * $add_program_cost;
            // $data['value'] = $r->value;
            if ($program_get->courseTextBookFee) {
                $data['text'] = $text_book_fee = $program_get->TextBookFee($r->value) ?? 0;
            } else {
                $data['text'] = $text_book_fee = 0;
            }

            insertCalculationIntoDB('text_book_fee', $text_book_fee);

            if ($r->date_set != null) {
                $this->calculator->setSummerDateFromDbProgram($program_get->summer_fee_end_date);
                $this->calculator->setPeakDateFromDbProgram($program_get->peak_time_end_date);
                $this->calculator->setSummerStartDateProgram($program_get->summer_fee_start_date);
                $this->calculator->setPeakStartDate($program_get->peak_time_start_date);
                $this->calculator->setPeakEndDate($program_get->peak_time_end_date);
                $this->calculator->setSummerFee($program_get->summer_fee_per_week);
                $this->calculator->setFrontEndDate($this->getEndDate($r->date_set, (int)$r->value));
                $this->calculator->setProgramStartDateFromFrontend(Carbon::create($r->date_set)->format('Y-m-d'));
                $this->calculator->setSummerEndDateProgram($program_get->summer_fee_end_date);

                $summer_week_fee = $program_get->summer_fee_per_week * $this->calculator->CompareDatesAndGetResult()['summer_date_program'];
                $peakfee = $program_get->peak_time_fee_per_week * $this->calculator->CompareDatesAndGetResult()['peak_date_program'];
                $data['which'] = $this->calculator->CompareDatesAndGetResult()['which'] ?? 0;

                insertCalculationIntoDB('summer_fee', $summer_week_fee);
                insertCalculationIntoDB('peak_time_fee', $peakfee);
            }

            //checking whether program duration is greater than the selected program duration and setting registration fee here

            if ($program_get->program_duration == null) {
                insertCalculationIntoDB('program_registration_fee', $program_get->program_registration_fee == null ? 0 : $program_get->program_registration_fee);
            } else {
                (int)$r->value >= $program_get->program_duration ? insertCalculationIntoDB('program_registration_fee', 0) : insertCalculationIntoDB('program_registration_fee', $program_get->program_registration_fee == null ? 0 : $program_get->program_registration_fee);
            }

            if ($r->type == 'requested_for_under_age') {
                $data['age_checkddd'] = $r->under_age;
                $data['under_age_fee_value'] = 0;
            }
            //updating program cost here
            insertCalculationIntoDB('program_cost', $multiple_program_cost);
        } elseif ($r->type == 'courier_fee') {
            $program_get = CourseProgram::where('course_unique_id', \Session::get('course_unique_id'))->where('program_duration_start', '<=', (int)$r->program_duration)
                ->where('program_duration_end', '>=', (int)$r->program_duration)
                ->first();

            $data['error'] = \Session::get('program_unique_id');
            if ($r->under_age == null)
                $data['error'] = "Select Age First";

            $r->value == 'true' ? insertCalculationIntoDB('courier_fee', $program_get->courier_fee) : insertCalculationIntoDB('courier_fee', 0);
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

    /**
     * @param $date
     * @param $weeks
     * @return string
     */
    private function getEndDate($date, $weeks)
    {
        return Carbon::create($date)->addWeeks($weeks)->format('Y-m-d');
    }
}