<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\AccommodationCalculator;

use App\Http\Controllers\Controller;

use App\Models\Calculator;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\Choose_Study_Mode;

use Carbon\Carbon;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $calculator;

    public function __construct()
    {
        $this->creteCalculatorDb();

        $this->calculator = new AccommodationCalculator;
    }

    private function creteCalculatorDb()
    {
        if (!Calculator::whereCalcId(request()->ip())->first()) {
            $calculator = new Calculator;
            $calcid = request()->ip();
            $input['calc_id'] = $calcid;
            $input['program_cost'] = 0;
            $input['fixed_program_cost'] = 0;
            $input['program_registration_fee'] = 0;
            $input['text_book_fee'] = 0;
            $input['summer_fee'] = 0;
            $input['under_age_fee'] = 0;
            $input['peak_time_fee'] = 0;
            $input['courier_fee'] = 0;
            $input['discount_fee'] = 0;

            $input['accommodation_fee'] = 0;
            $input['accommodation_placement_fee'] = 0;
            $input['accommodation_deposit'] = 0;
            $input['accommodation_summer_fee'] = 0;
            $input['accommodation_under_age_fee'] = 0;
            $input['accommodation_christmas_fee'] = 0;
            $input['accommodation_special_diet_fee'] = 0;
            $input['accommodation_peak_time_fee'] = 0;
            $input['accommodation_discount'] = 0;
            $input['accommodation_total'] = 0;

            $input['airport_pickup_fee'] = 0;
            $input['medical_insurance_fee'] = 0;
            $input['airport_total'] = 0;

            $input['total'] = 0;

            return $calculator->fill($input)->save();
        }
        return true;
    }

    public function reloadCalculator()
    {
        $this->calculator->setProgramCost(read_json_file('program_cost'));
        $this->calculator->setProgramRegistrationFee(read_json_file('program_registration_fee'));
        $this->calculator->setTextBookFee(read_json_file('text_book_fee'));
        $this->calculator->setSummerFee(read_json_file('summer_fee'));
        $this->calculator->setUnderAgeFee(read_json_file('under_age_fee'));
        $this->calculator->setCourierFee(read_json_file('courier_fee'));
        $this->calculator->setPeakTimeFee(read_json_file('peak_time_fee'));
        $this->calculator->setDiscount(read_json_file('discount_fee'));
        $this->calculator->setTotalPrice();

        $data['program_cost'] = 'program_cost';
        $data['program_cost_value'] = read_json_file('program_cost');
        $data['registration_fee'] = 'registration_fee';
        $data['registration_fee_value'] = read_json_file('program_registration_fee');
        $data['text_book_fee'] = 'text_book_fee';
        $data['text_book_fee_value'] = read_json_file('text_book_fee') == null ? 0 : read_json_file('text_book_fee');
        $data['summer_fee'] = 'summer_fee';
        $data['summer_fee_value'] = read_json_file('summer_fee');
        $data['under_age_fee'] = 'under_age_fee';
        $data['under_age_fee_value'] = read_json_file('under_age_fee');
        $data['peak_time_fee'] = read_json_file('peak_time_fee');
        $data['discount_fee'] = 'discount_fee';
        $data['discount_fee_value'] = read_json_file('discount_fee');

        $data['express_mail'] = 'express_mail';
        $data['express_mail_value'] = read_json_file('courier_fee');
        $data['total_value'] = $this->calculator->TotalCalculation();

        return response($data);
    }

    public function index()
    {
        // Return getEndDate('03/01/2021', 2);
        Session::forget('accom_unique_id');
        Session::forget('airport_id');
        Session::forget('medical_id');
        
        $course = new Course;
        $data['course'] = $course = $course->latest()->first();
        if (!$course) {
            abort(404);
        }

        /*  We Are Making weekdays available in date picker available in frontend */
        $dates = [0, 1, 2, 3, 4, 5, 6];

        $data['enabled_days'] = implode(",", $dates);

        $schools = DB::table("schools_en")->whereUniqueId($course->school_id)->first();

        $accomodations = new CourseAccommodation;
        $accomodations->setTable('course_accommodations_en');
        $accomodations = $accomodations->whereCourseUniqueId($course->unique_id)->get();

        $airports = new Airport;
        $airports->setTable('course_airport_fees');
        $airports = $airports->whereCourseUniqueId($course->unique_id)->get();

        return view('frontend.course.single', $data, compact('airports', 'course', 'accomodations', 'schools'));
    }

    public function calculator(Request $r)
    {
        $data['success'] = false;

        if (!Session::has('program_unique_id') && $r->type == 'select_program') {
            Session::put('program_unique_id', $r->value);
        }

        $data['success'] = true;

        $program_get = CourseProgram::where('unique_id', Session::get('program_unique_id'))->first();
        $program_age = "";
        $course_age_ranges = $program_get->course->age_range;
        sort($course_age_ranges);
        foreach ($course_age_ranges as $course_age_range) {
            $program_age .= "<option value = $course_age_range>$course_age_range</option>";
        }

        if ($r->type == "select_program") {
            $data['age'] = $program_age;

            $program_duration_html = '';
            for ($program_duration_index = $program_get->program_duration_start; $program_duration_index <= $program_get->program_duration_end; $program_duration_index++) {
                $program_duration_html .= "<option value= $program_duration_index> $program_duration_index</option>";
            }
            $data['program_duration'] = $program_duration_html;
        }

        if ($r->type == 'duration') {
            $add_program_cost = $program_get->program_cost;

            // Multiplying program cost here
            $multiple_program_cost = (int)$r->value * $add_program_cost;

            $text_book_fee = $this->inBetween($r->value, $program_get->text_fee_start_week, $program_get->text_fee_end_week) ? $program_get->text_book_fee : 0;

            json_file('text_book_fee', $text_book_fee);

            if ($r->date_set != null) {
                $this->calculator->setSummerDateFromDbProgram($program_get->summer_fee_end_date);
                $this->calculator->setSummerStartDateProgram($program_get->summer_fee_start_date);
                $this->calculator->setSummerEndDateProgram($program_get->summer_fee_end_date);
                $this->calculator->setSummerFee($program_get->summer_fee_per_week);
                $this->calculator->setPeakDateFromDbProgram($program_get->peak_time_end_date);
                $this->calculator->setPeakStartDate($program_get->peak_time_start_date);
                $this->calculator->setPeakEndDate($program_get->peak_time_end_date);
                $this->calculator->setFrontEndDate(getEndDate($r->date_set, (int)$r->value));
                $this->calculator->setProgramStartDateFromFrontend(Carbon::create($r->date_set)->format('Y-m-d'));
                $summer_week_fee = $program_get->summer_fee_per_week * $this->calculator->CompareDatesAndGetResult()['summer_date_program'];
                $peakfee = $program_get->peak_time_fee_per_week * $this->calculator->CompareDatesAndGetResult()['peak_date_program'];
                $data['which'] = $this->calculator->CompareDatesAndGetResult()['which'] ?? 0;

                json_file('summer_fee', $summer_week_fee);
                json_file('peak_time_fee', $peakfee);
            }

            // Checking whether program duration is greater than the selected program duration and setting registration fee here
            (int)$r->value >= $program_get->course->program_duration ? json_file('program_registration_fee', 0) : json_file('program_registration_fee', $program_get->course->program_registration_fee);
            in_array($r->under_age, $program_get->under_age) ? json_file('under_age_fee', $program_get->under_age_fee_per_week * $r->value) : json_file('under_age_fee', 0);

            // Updating program cost here
            json_file('program_cost', $multiple_program_cost);
        } elseif ($r->type == 'courier_fee') {
            $data['error'] = null;
            if ($r->under_age == null) {
                $data['error'] = "Select Age First";
            }

            $r->value == 'true' ? json_file('courier_fee', $program_get->course->courier_fee) : json_file('courier_fee', 0);
        }

        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    // For below duration checking if fees is free or not
    public function discountCalculator(Request $r)
    {
        if ($r->has('reload')) {
            reload_json_file();
        }

        $program_getting = CourseProgram::where('unique_id', Session::get('program_unique_id'))->first();

        $week_selected_discount = $this->calculator->calculateDiscountWeekFree($r->value, $program_getting->x_week_selected);
        $data['discount_fee'] = $week_selected_discount;
        
        $date_set_format = Carbon::create($r->date_set)->format('Y-m-d');
        if ((checkBetweenDate($program_getting->discount_start_date, $program_getting->discount_end_date, Carbon::now()->format('Y-m-d'))) ) {
            $this->calculator->setProgramStartDateFromFrontend($date_set_format);
            $this->calculator->setDiscountStartDateForWeekSelect($program_getting->x_week_start_date);
            $this->calculator->setDiscountEndDateForWeekSelect($program_getting->x_week_end_date);
            $this->calculator->setProgramDuration($r->value);
            $this->calculator->setDiscountWeekGet($week_in_db);
            $this->calculator->setDiscountStartDate($program_getting->discount_start_date);
            $this->calculator->setDiscountEndDate($program_getting->discount_end_date);
            $this->calculator->setHowManyWeekFree($program_getting->how_many_week_free);
            $this->calculator->setProgramCost($program_getting->program_cost * $r->value);
            $this->calculator->setProgramStartDate($program_getting->program_start_date);
            $this->calculator->setProgramEndDate($program_getting->program_end_date);
            $discount = 0;
            $discount_per_week = $program_getting->discount_per_week;
            if ($discount_per_week) {
                $discount_per_weeks = explode(" ", $discount_per_week);
                if (count($discount_per_weeks) >= 2) {
                    if ($discount_per_weeks[1] == '%') {
                        $discount = $program_getting->program_cost * (int)$discount_per_weeks[0] / 100;
                    } else {
                        $discount = (int)$discount_per_weeks[0];
                    }
                }
            }
            $this->calculator->setDiscount($discount);
            $this->calculator->setFrontEndDate(getEndDate($r->date_set, $r->value));
            $this->calculator->setFixedProgramCost($program_getting->program_cost);
            $this->calculator->setDiscountEndDate($program_getting->discount_end_date);
            $this->calculator->setGetProgramWeeks($r->value);
        } else {
            json_file('accommodation_discount', 0);
        }
        $data['discount'] = $this->calculator->discountedTotal();
        $data['request'] = $r->all();
        $data['program '] = $program_getting;

        return response()->json($data);
    }

    public function calculateAccomodation(Request $request)
    {
        if ($request->has('special_diet')) {
            return $this->calculateSpecialDiet($request);
        }

        $accomodation = new CourseAccommodation;

        $request->session_set == true || $request->set_session == 'true' ? Session::put('accom_unique_id', $request->id) : '';

        $accomodation = $accomodation->whereUniqueId(Session::get('accom_unique_id'))->first();
        $select = __('Admin/backend.select');
        $html = "<option value  = ''>$select</option>";

        if ($request->set_session || $request->set_session == 'true') {
            for ($i = $accomodation->start_week; $i <= $request->program_duration; $i++) {
                $html .= "<option value  = $i>$i</option>";
            }
        }

        // Calling Class Accommodation Calculator for caluclation puprose
        if ($request->set_session == false || $request->set_session == 'false') {
            $multiple = $request->id;
            $this->calculator->setAccommodationFee($accomodation->fee_per_week * $multiple);
            $request->program_duration >= $accomodation->program_duration ? $this->calculator->setAccommodationPlacementFee(0) : $this->calculator->setAccommodationPlacementFee($accomodation->placement_fee);
            $this->calculator->setAccommodationChristmasStartDate($accomodation->christmas_fee_start_date);
            $this->calculator->setAccommodationChristmasEndDate($accomodation->christmas_fee_end_date);
            $this->calculator->setAccommodationDeposit($accomodation->deposit_fee);
            $this->calculator->setAccommodationPeakStartDate($accomodation->peak_time_fee_start_date);
            $this->calculator->setAccommodationPeakEndDate($accomodation->peak_time_fee_end_date);
            in_array($request->age, $accomodation->age_range) ? $this->calculator->setAccommodationUnderageFee($accomodation->under_age_fee_per_week * (int)$request->id) : 0;
            $this->calculator->setFrontEndDate(getEndDate($request->date_set, (int)$request->id));
            $this->calculator->setProgramStartDateFromFrontend(Carbon::create($request->date_set)->format('Y-m-d'));
            $this->calculator->setAccommodationSummerStartDate($accomodation->summer_fee_start_date);
            $this->calculator->setAccommodationSummerEndDate($accomodation->summer_fee_end_date);
            $this->calculator->setAccommodationDuration((int)$request->id);
            $this->calculator->setAccommodationDiscountEndDate($accomodation->discount_end_date);

            // Check for dates
            $dates_and_get_weeks_accommodation = $this->calculator->CompareDatesandGetWeeksAccommodation();
            $this->calculator->setAccommodationChristmasFee($accomodation->christmas_fee_per_week * $dates_and_get_weeks_accommodation['christmas']);
            $this->calculator->setAccommodationDiscount($accomodation->discount_per_week);
            $this->calculator->setAccommodationPeakFee($accomodation->peak_time_fee_per_week * $dates_and_get_weeks_accommodation['peak']);
            $this->calculator->setAccommodationSummerFee($accomodation->summer_fee_per_week * $dates_and_get_weeks_accommodation['summer']);
            $this->calculator->setAccommodationDiscountStartDate($accomodation->discount_start_date);

            $accom_fee = $this->calculator->getAccommodationFee();
            $data['placement_fee'] = $placement_fee = $this->calculator->getAccommodationPlacementFee();
            $data['special_diet_fee'] = $special_diet_fee = $this->calculator->getAccommodationSpecialDietFee();
            $data['deposit_fee'] = $deposit_fee = $this->calculator->getAccommodationDeposit();
            $data['accom_summer_fee'] = $accom_summer_fee = $this->calculator->getAccommodationSummerFee();
            $data['christmas_fee'] = $christmas_fee = $this->calculator->getAccommodationChristmasFee();
            $data['under_age_fee'] = $under_age_fee = $this->calculator->getAccommodationUnderageFee();
            $data['peak_fee'] = $peak_fee = $this->calculator->getAccommodationPeakFee();
            $this->calculator->calculateOnlyAccommodationTotal();

            json_file('accommodation_fee', $accom_fee);
            json_file('accommodation_placement_fee', $placement_fee);
            json_file('accommodation_special_diet_fee', $special_diet_fee);
            json_file('accommodation_deposit', $deposit_fee);
            json_file('accommodation_summer_fee', $accom_summer_fee);
            json_file('accommodation_christmas_fee', $christmas_fee);
            json_file('accommodation_under_age_fee', $under_age_fee);
            json_file('accommodation_discount', $this->calculator->resultDiscount());
            json_file('accommodation_peak_time_fee', $peak_fee);
            $data['request'] = $request->all();
            $data['discount'] = $this->calculator->resultDiscount();
            $data['accom_fee'] = read_json_file('accommodation_fee');
        }
        $data['duration_value'] = $html;

        return response($data);
    }

    private function calculateSpecialDiet($request)
    {
        $accomodation = new Accommodation;
        $accomodation->setTable('course_accommodations_' . get_language());
        $accomodation = $accomodation->whereUniqueId(Session::get('accom_unique_id'))->first();

        $request->checked == 'true' ? $this->calculator->setAccommodationSpecialDietFee($accomodation->special_diet_fee * $request->week) : $this->calculator->setAccommodationSpecialDietFee(0);
        $data['special_diet_fee'] = $this->calculator->getAccommodationSpecialDietFee();
        json_file('accommodation_special_diet_fee', $data['special_diet_fee']);

        $data['total_fee'] = $this->calculator->TotalCalculation();

        return response($data);
    }

    private function weeksBetweenTwoDates($date1, $date2)
    {
        $first = Carbon::createFromFormat('Y-m-d', $date1);
        $second = Carbon::createFromFormat('Y-m-d', $date2);
        if ($date1 > $date2) return $this->weeksBetweenTwoDates($date2, $date1);

        return floor($first->diff($second)->days / 7);
    }

    public function resetAccomodation()
    {
        json_file('accommodation_fee', 0);
        json_file('accommodation_placement_fee', 0);
        json_file('accommodation_special_diet_fee', 0);
        json_file('accommodation_deposit', 0);
        json_file('accommodation_summer_fee', 0);
        json_file('accommodation_christmas_fee', 0);
        json_file('accommodation_under_age_fee', 0);
        json_file('accommodation_discount', 0);
        json_file('accommodation_peak_time_fee', 0);
        json_file('accommodation_total', 0);

        return true;
    }

    /*
     * @params : $date, $weeks
     *
     * return How many weeks
     *
     * */
    public function resetMedical()
    {
        json_file('airport_pickup_fee', 0);
        json_file('medical_insurance_fee', 0);
        json_file('airport_total', 0);

        return true;
    }

    /* Function to check textbook fee whether the weeks lies between duration or not */
    private function inBetween($varToCheck, $low,  $high) {
        if ($varToCheck < $low) return false;
        if ($varToCheck > $high) return false;

        return true;
    }
}