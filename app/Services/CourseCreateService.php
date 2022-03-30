<?php

namespace App\Services;

use App\Http\Controllers\Controller;

use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAccommodationUnderAge;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseAirportFee;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseMedicalFee;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseProgramTextBook;
use App\Models\SuperAdmin\CourseProgramUnderAgeFee;

use Illuminate\Http\Request;

/**
 * Class CourseCreateService
 * @package App\Services
 */
class CourseCreateService
{
    /*
     * Function for creating db for first form
     *
     * @params Request $r
     *
     * */
    /**
     * @var
     */
    private $get_error;

    /**
     * @return mixed
     */
    public function getGetError()
    {
        return $this->get_error;
    }

    /**
     * @param Request $r
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function createCourseAndProgram(Request $r)
    {
        extract($r->all());

        $rules = [
            'school_id' => 'required',
            'currency' => 'required',
            'program_level' => 'required',
            'lessons_per_week' => 'required',
            'hours_per_week' => 'required',
            'program_information' => 'required'
        ];

        /*
         * Validation Rules Starts here
         *
         */
        $validation = \Validator::make($r->all(), $rules, [
            'language.*.required' => 'Language required',
            'study_time.*.required' => 'Study Time required',
            'study_mode.*.required' => 'Study Mode required',
            'start_date.*.required' => 'Start Date required',
            'classes_day.*.required' => 'Classes Day required',
            'program_type.*.required' => 'Program Type required',
            'courier_fee.*.required' => 'Program Courier fee required',
            'program_cost.*.required' => 'Program Cost required',
            'program_start_date.*.required' => 'Program Start Date required',
            'program_end_date.*.required' => 'Program End Date required',
        ]);

        if ($validation->fails()) {
            return $this->get_error = $validation->errors();
        }

        $course_id = (new Controller())->my_unique_id();
        $exist_course = Course::where('unique_id', $course_id)->get();
        while (count($exist_course)) {
            (new Controller())->my_unique_id(1);
            $course_id = (new Controller())->my_unique_id();
            $exist_course = Course::where('unique_id', $course_id)->get();
        }
        $course = [];
        $course['unique_id'] = $course_id;
        $course['language'] = $r->language;
        $course['program_type'] = $r->program_type;
        $course['study_mode'] = $r->study_mode;
        $course['school_id'] = $r->school_id;
        $course['city'] = $r->city;
        $course['country'] = $r->country;
        $course['branch'] = $r->branch ?? [];
        $course['currency'] = $r->currency;
        $course['program_name'] = $r->program_name;
        $course['program_level'] = $r->program_level;
        $course['lessons_per_week'] = $r->lessons_per_week;
        $course['hours_per_week'] = $r->hours_per_week;
        $course['study_time'] = $r->study_time;
        $course['classes_day'] = $r->classes_day;
        $course['start_date'] = $r->start_date;
        $course['program_information'] = $r->program_information;
        $course['program_information_ar'] = $r->program_information_ar;
        Course::create($course);

        \Session::put('course_id', $course_id);
        \Session::forget('program_ids');

        if (isset($program_increment)) {
            for ($count = 0; $count <= (int)$program_increment; $count++) {
                if (isset($program_id[$count])) {
                    \Session::push('program_ids', $program_id[$count]);
                }
    
                if (isset($count)) {
                    $course_program_table = new CourseProgram;
                    $course_program_table->course_unique_id = $course_id;
                    $course_program_table->unique_id = $program_id[$count];
                    $course_program_table->program_name = null;
                    $course_program_table->program_registration_fee = $r->program_registration_fee[$count];
                    $course_program_table->program_duration = $r->program_duration[$count] ?? null;
                    $course_program_table->program_age_range = isset($r->age_range[$count]) ? $r->age_range[$count] : null;
                    $course_program_table->courier_fee = $r->courier_fee[$count];
                    $course_program_table->about_courier = $r->about_courier[$count] ?? null;
                    $course_program_table->about_courier_ar = $r->about_courier_ar[$count] ?? null;
    
                    $course_program_table->program_cost = $r->program_cost[$count];
                    $course_program_table->program_duration_start = $r->program_duration_start[$count] ?? null;
                    $course_program_table->program_duration_end = $r->program_duration_end[$count] ?? null;
                    $course_program_table->program_start_date = $r->program_start_date[$count] ?? null;
                    $course_program_table->program_end_date = $r->program_end_date[$count] ?? null;
    
                    $course_program_table->available_date = $r->available_date[$count] ?? null;
                    $course_program_table->select_day_week = $r->select_day_week[$count] ?? null;
                    $course_program_table->available_days = $r->available_days[$count] ?? null;
    
                    $course_program_table->deposit = $r->deposit[$count] . " " . $r->deposit_symbol[$count] ?? null;
                    $course_program_table->discount_per_week = $r->discount_per_week[$count] . " " . $r->discount_symbol[$count] ?? null;
                    $course_program_table->discount_start_date = $r->discount_start_date[$count] ?? null;
                    $course_program_table->discount_end_date = $r->discount_end_date[$count] ?? null;
    
                    $course_program_table->christmas_start_date = $r->christmas_start_date[$count] ?? null;
                    $course_program_table->christmas_end_date = $r->christmas_end_date[$count] ?? null;
    
                    $course_program_table->x_week_selected = $r->x_week_selected[$count] ?? null;
                    $course_program_table->x_week_start_date = $r->x_week_start_date[$count] ?? null;
                    $course_program_table->x_week_end_date = $r->x_week_end_date[$count] ?? null;
    
                    $course_program_table->how_many_week_free = $r->how_many_week_free[$count] ?? null;
    
                    $course_program_table->summer_fee_per_week = $r->summer_fee_per_week[$count];
                    $course_program_table->summer_fee_start_date = $r->summer_fee_start_date[$count];
                    $course_program_table->summer_fee_end_date = $r->summer_fee_end_date[$count];
    
                    $course_program_table->peak_time_fee_per_week = $r->peak_time_fee_per_week[$count];
                    $course_program_table->peak_time_start_date = $r->peak_time_start_date[$count];
                    $course_program_table->peak_time_end_date = $r->peak_time_end_date[$count];
                    $course_program_table->save();
                }
            }
        }
        (new Controller())->my_unique_id(1);
        return true;
    }

    public function cloneCourse($id)
    {
        $course = Course::where('unique_id', $id)->first();
        $course_id = (new Controller())->my_unique_id();
        $exist_course = Course::where('unique_id', $course_id)->get();
        while (count($exist_course)) {
            (new Controller())->my_unique_id(1);
            $course_id = (new Controller())->my_unique_id();
            $exist_course = Course::where('unique_id', $course_id)->get();
        }
        $new_course = [];
        $new_course['unique_id'] = $course_id;
        $new_course['language'] = $course->language;
        $new_course['program_type'] = $course->program_type;
        $new_course['study_mode'] = $course->study_mode;
        $new_course['school_id'] = $course->school_id;
        $new_course['city'] = $course->city;
        $new_course['country'] = $course->country;
        $new_course['branch'] = $course->branch ?? [];
        $new_course['currency'] = $course->currency;
        $new_course['program_name'] = $course->program_name;
        $new_course['program_level'] = $course->program_level;
        $new_course['lessons_per_week'] = $course->lessons_per_week;
        $new_course['hours_per_week'] = $course->hours_per_week;
        $new_course['study_time'] = $course->study_time ?? [];
        $new_course['classes_day'] = $course->classes_day ?? [];
        $new_course['start_date'] = $course->start_date ?? [];
        $new_course['program_information'] = $course->program_information;
        $new_course['program_information_ar'] = $course->program_information_ar;
        Course::create($new_course);

        \Session::put('course_id', $course_id);
        
        $course_programs = $course->coursePrograms()->get();
        for ($count = 0; $count < count($course_programs); $count++) {
            $course_program = $course_programs[$count];
            $new_course_program = [];
            $course_program_id = (new Controller())->my_unique_id();
            $exist_course_program = CourseProgram::where('unique_id', $course_program_id)->get();
            while (count($exist_course_program)) {
                (new Controller())->my_unique_id(1);
                $course_program_id = (new Controller())->my_unique_id();
                $exist_course_program = CourseProgram::where('unique_id', $course_program_id)->get();
            }

            $course_program_table = new CourseProgram;
            $course_program_table->course_unique_id = $course_id;
            $course_program_table->unique_id = $course_program_id;
            $course_program_table->program_name = null;
            $course_program_table->program_registration_fee = $course_program->program_registration_fee;
            $course_program_table->program_duration = $course_program->program_duration ?? null;
            $course_program_table->program_age_range = isset($course_program->program_age_range) ? $course_program->program_age_range : null;
            $course_program_table->program_cost = $course_program->program_cost;
            $course_program_table->program_duration_start = $course_program->program_duration_start ?? null;
            $course_program_table->program_duration_end = $course_program->program_duration_end ?? null;
            $course_program_table->program_start_date = $course_program->program_start_date ?? null;
            $course_program_table->program_end_date = $course_program->program_end_date ?? null;

            $course_program_table->available_date = $course_program->available_date[$count] ?? null;
            $course_program_table->select_day_week = $course_program->select_day_week[$count] ?? null;
            $course_program_table->available_days = $course_program->available_days[$count] ?? null;

            $course_program_table->courier_fee = $course_program->courier_fee;
            $course_program_table->about_courier = $course_program->about_courier;
            $course_program_table->about_courier_ar = $course_program->about_courier_ar;

            $course_program_table->deposit = $course_program->deposit . " " . $course_program->deposit_symbol ?? null;

            $course_program_table->discount_per_week = $course_program->discount_per_week . " " . $course_program->discount_per_week_symbol ?? null;
            $course_program_table->discount_start_date = $course_program->discount_start_date ?? null;
            $course_program_table->discount_end_date = $course_program->discount_end_date ?? null;

            $course_program_table->christmas_start_date = $course_program->christmas_start_date ?? null;
            $course_program_table->christmas_end_date = $course_program->christmas_end_date ?? null;

            $course_program_table->x_week_selected = $course_program->x_week_selected ?? null;
            $course_program_table->x_week_start_date = $course_program->x_week_start_date ?? null;
            $course_program_table->x_week_end_date = $course_program->x_week_end_date ?? null;

            $course_program_table->how_many_week_free = $course_program->how_many_week_free ?? null;

            $course_program_table->summer_fee_per_week = $course_program->program_summer_fee_per_week;
            $course_program_table->summer_fee_start_date = $course_program->program_summer_fee_start_date;
            $course_program_table->summer_fee_end_date = $course_program->program_summer_fee_end_date;

            $course_program_table->peak_time_fee_per_week = $course_program->program_peak_time_fee_per_week;
            $course_program_table->peak_time_start_date = $course_program->program_peak_time_start_date;
            $course_program_table->peak_time_end_date = $course_program->program_peak_time_end_date;
            $course_program_table->save();

            $course_underages = $course_program->courseUnderAges()->get();
            for ($underage_count = 0; $underage_count < count($course_underages); $underage_count++) {
                $course_underage = $course_underages[$underage_count];
                $new_course_underage = [];
                $new_course_underage->course_program_id = $course_program_id;
                $new_course_underage->under_age = $course_underage->under_age;
                $new_course_underage->underage_fee_per_week = $course_underage->underage_fee_per_week;

                CourseProgramUnderAgeFee::create($new_course_underage);
            }

            $course_textbookfees = $course_program->courseTextBookFees()->get();
            for ($textbookfee_count = 0; $textbookfee_count < count($course_textbookfees); $textbookfee_count++) {
                $course_textbookfee = $course_textbookfees[$textbookfee_count];
                $new_course_textbookfee = [];
                $new_course_textbookfee->text_book_fee = $course_textbookfee->text_book_fee;
                $new_course_textbookfee->text_book_start_date = $course_textbookfee->text_book_start_date;
                $new_course_textbookfee->text_book_end_date = $course_textbookfee->text_book_end_date;
                $new_course_textbookfee->text_book_note = $course_textbookfee->text_book_note;
                $new_course_textbookfee->text_book_note_ar = $course_textbookfee->text_book_note_ar;

                CourseProgramTextBook::create($new_course_textbookfee);
            }
        }

        $course_accommodations = $course->accomodations()->get();
        for ($count = 0; $count < count($course_accommodations); $count++) {
            $course_accomodation = $course_accommodations[$count];
            $new_course_accomodation = [];
            $accommodation_id = (new Controller())->my_unique_id();
            $exist_accomodation = CourseAccommodation::where('unique_id', $accommodation_id)->get();
            while (count($exist_accomodation)) {
                (new Controller())->my_unique_id(1);
                $accommodation_id = (new Controller())->my_unique_id();
                $exist_accomodation = CourseAccommodation::where('unique_id', $accommodation_id)->get();
            }

            $course_accommodations_table = new CourseAccommodation;
            $course_accommodations_table->unique_id = $accommodation_id;
            $course_accommodations_table->course_unique_id = $course_id;
            $course_accommodations_table->room_type = $course_accomodation->room_type ?? null;
            $course_accommodations_table->meal = $course_accomodation->meal ?? null;
            $course_accommodations_table->age_range = isset($course_accomodation->age_range) ? $course_accomodation->age_range : null;
            
            $course_accommodations_table->deposit_fee = isset($course_accomodation->deposit_fee) ? $course_accomodation->deposit_fee : null;
            $course_accommodations_table->custodian_fee = $course_accomodation->custodian_fee ?? null;
            $course_accommodations_table->custodian_age_range = isset($course_accomodation->age_range_for_custodian) ? $course_accomodation->age_range_for_custodian : null;
            $course_accommodations_table->custodian_condition = $course_accomodation->custodian_condition ?? null;
            $course_accommodations_table->special_diet_fee = $course_accomodation->special_diet_fee ?? null;
            $course_accommodations_table->special_diet_note = $course_accomodation->special_diet_note;
            $course_accommodations_table->special_diet_note_ar = $course_accomodation->special_diet_note_ar;
            
            $course_accommodations_table->type = $course_accomodation->type ?? null;
            $course_accommodations_table->placement_fee = $course_accomodation->placement_fee ?? null;
            $course_accommodations_table->program_duration = $course_accomodation->program_duration ?? null;
            $course_accommodations_table->fee_per_week = $course_accomodation->fee_per_week ?? null;
            $course_accommodations_table->start_week = $course_accomodation->start_week ?? null;
            $course_accommodations_table->end_week = $course_accomodation->end_week ?? null;
            $course_accommodations_table->available_date = $course_accomodation->available_date ?? null;
            $course_accommodations_table->available_days = $course_accomodation->available_days ?? null;
            $course_accommodations_table->start_date = $course_accomodation->start_date ?? null;
            $course_accommodations_table->end_date = $course_accomodation->end_date ?? null;
            
            $course_accommodations_table->discount_per_week = $course_accomodation->discount_per_week . " " . $course_accomodation->discount_per_week_symbol ?? null;
            $course_accommodations_table->discount_per_week_symbol = $course_accomodation->discount_per_week_symbol ?? null;
            $course_accommodations_table->discount_start_date = $course_accomodation->discount_start_date ?? null;
            $course_accommodations_table->discount_end_date = $course_accomodation->discount_end_date ?? null;

            $course_accommodations_table->summer_fee_per_week = isset($course_accomodation->summer_fee_per_week) ? $course_accomodation->summer_fee_per_week : null;
            $course_accommodations_table->summer_fee_start_date = isset($course_accomodation->summer_fee_start_date) ? $course_accomodation->summer_fee_start_date : null;
            $course_accommodations_table->summer_fee_end_date = isset($course_accomodation->summer_fee_end_date) ? $course_accomodation->summer_fee_end_date : null;
            
            $course_accommodations_table->peak_time_fee_per_week = isset($course_accomodation->peak_time_fee_per_week) ? $course_accomodation->peak_time_fee_per_week : null;
            $course_accommodations_table->peak_time_fee_start_date = isset($course_accomodation->peak_time_fee_start_date) ? $course_accomodation->peak_time_fee_start_date : null;
            $course_accommodations_table->peak_time_fee_end_date = $course_accomodation->peak_time_fee_end_date ?? null;
            
            $course_accommodations_table->christmas_fee_per_week = $course_accomodation->christmas_fee_per_week ?? null;
            $course_accommodations_table->christmas_fee_start_date = $course_accomodation->christmas_fee_start_date ?? null;
            $course_accommodations_table->christmas_fee_end_date = $course_accomodation->christmas_fee_end_date ?? null;
            $course_accommodations_table->save();
        }

        $course_airports = $course->airports()->get();
        for ($count = 0; $count < count($course_airports); $count++) {
            $course_airport = $course_airports[$count];
            $new_course_airport = [];
            $new_course_airport['course_unique_id'] = $course_id;
            $new_course_airport['service_provider'] = $course_airport->service_provider ?? null;
            $new_course_airport['week_selected_fee'] = (double)$course_airport->week_selected_fee ?? null;
            $new_course_airport['note'] = $course_airport->note ?? null;

            $created_course_airport = CourseAirport::create($new_course_airport);

            $course_airport_fees = $course_airport->fees()->get();
            for ($count_fee = 0; $count_fee < count($course_airport_fees); $count_fee++) {
                $course_airport_fee = $course_airport_fees[$count_fee];
                $new_course_airport_fee = [];
                $new_course_airport_fee['course_airport_unique_id'] = $created_course_airport->unique_id;
                $new_course_airport_fee['name'] = $course_airport_fee->name ?? null;
                $new_course_airport_fee['service_name'] = $course_airport_fee->service_name ?? null;
                $new_course_airport_fee['service_fee'] = $course_airport_fee->service_fee ?? null;

                CourseAirportFee::create($new_course_airport_fee);
            }
        }

        $course_medicals = $course->medicals()->get();
        for ($count = 0; $count < count($course_medicals); $count++) {
            $course_medical = $course_medicals[$count];
            $new_course_medical = [];
            $new_course_medical['course_unique_id'] = $course_id;
            $new_course_medical['company_name'] = $course_medical->company_name ?? null;
            $new_course_medical['deductible'] = $course_medical->deductible ?? null;
            $new_course_medical['week_selected_fee'] = $course_medical->week_selected_fee ?? null;
            $new_course_medical['note'] = $course_medical->note ?? null;

            $created_course_medical = CourseMedical::create($new_course_medical);

            $course_medical_fees = $course_medical->fees()->get();
            for ($count_fee = 0; $count_fee < count($course_medical_fees); $count_fee++) {
                $course_medical_fee = $course_medical_fees[$count_fee];
                $new_course_medical_fee = [];
                $new_course_medical_fee['course_medical_unique_id'] = $created_course_medical->unique_id;
                $new_course_medical_fee['fees_per_week'] = $course_medical_fee->fees_per_week ?? null;
                $new_course_medical_fee['start_date'] = $course_medical_fee->start_date ?? null;
                $new_course_medical_fee['end_date'] = $course_medical_fee->end_date ?? null;

                CourseMedicalFee::create($new_course_medical_fee);
            }
        }

        return true;
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function createProgramUnderAgeAndTextBook(Request $request)
    {
        $rules = [
            'program_id.*' => 'required',
            'text_book_fee_start_date.*' => 'required',
            'text_book_fee_end_date.*' => 'required',
            'text_book_note.*' => 'required',
        ];

        /*
         * Validation Rules Starts here
         * */
        $validation = \Validator::make($request->all(), $rules, [
            'program_id.*.required' => "Program ID is required",
            'text_book_fee_start_date.*.required' => "Text Book Fee Start Date is required",
            'text_book_fee_end_date.*.required' => "Text Book Fee End Date is required",
            'text_book_note.*.required' => "Text Book Note is required",
        ]);

        if ($validation->fails()) {
            return $this->get_error = $validation->errors();
        }

        \DB::transaction(function () use ($request) {
            extract($request->all());

            for ($i = 0; $i < count($underagefeeincrement); $i++) {
                $new_course_program_under_age_fee = new CourseProgramUnderAgeFee();
                $new_course_program_under_age_fee->course_program_id = $program_id[0];
                $new_course_program_under_age_fee->under_age = isset($under_age[$i]) ? $under_age[$i] : null;
                $new_course_program_under_age_fee->underage_fee_per_week = $underage_fee_per_week[$i] ?? null;
                $new_course_program_under_age_fee->save();
            }

            for ($textbook = 0; $textbook < count($textbookfeeincrement); $textbook++) {
                $new_course_program_text_book = new CourseProgramTextBook();
                $new_course_program_text_book->program_id = $program_id[0];
                $new_course_program_text_book->text_book_fee = $text_book_fee[$textbook];
                $new_course_program_text_book->text_book_start_date = $text_book_fee_start_date[$textbook];
                $new_course_program_text_book->text_book_end_date = $text_book_fee_end_date[$textbook];
                $new_course_program_text_book->text_book_note = $text_book_note[$textbook] ?? null;
                $new_course_program_text_book->text_book_note_ar = $text_book_note_ar[$textbook] ?? null;
                $new_course_program_text_book->save();
            }
        });

        return true;
    }


    /**
     * @param Request $request
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function createAccommodation(Request $request)
    {
        \Session::forget('accom_ids');

        $rules = ['accommodation_id.*' => 'required', 'type.*' => 'required',
            'room_type.*' => 'required', 'meal.*' => 'required',
            'age_range.*' => 'required',
            'age_range_for_custodian.*' => 'required',
        ];

        /*
         * Validation Rules Starts here
         * */
        $validation = \Validator::make($request->all(), $rules, [
            'accommodation_id.*.required' => 'Accommodation ID is required',
            'type.*.required' => 'Accommodation Type is required',
            'room_type.*.required' => 'Room Type is required',
            'meal.*.required' => 'Meal required',
            'age_range.required' => 'Age Range Duration required',
            'placement_fee.*.required' => 'Accommodation Placement Fee required',
            'program_duration.*.required' => "Accommodation Program Duration required",
            'deposit_fee.*.required' => "Deposit Fee is required",

            'custodian_fee.*.required' => "Custodian Fee is required",

            'age_range_for_custodian.required' => "Age Range for Custodian is required",

            'fee_per_week.*.required' => 'Accommodation fee is required',
            'end_week.*.required' => 'Accommodation End Week is required',

            'start_week.required' => 'Accommodation Start Week required',
            'start_date.*.required' => 'Accommodation Start Date required',
            'end_date.*.required' => "Accommodation End Date required",
        ]);

        if ($validation->fails()) {
            return $this->get_error = $validation->errors();
        }

        extract($request->all());

        for ($accom = 0; $accom < count($accommodation_id); $accom++) {
            if (isset($accom)) {
                $course_accommodations_table = new CourseAccommodation;
                $course_accommodations_table->unique_id = $accommodation_id[$accom] ?? null;
                $course_accommodations_table->course_unique_id = '' . \Session::get('course_id');
                $course_accommodations_table->room_type = $room_type[$accom] ?? null;
                $course_accommodations_table->meal = $meal[$accom] ?? null;
                $course_accommodations_table->age_range = isset($age_range[$accom]) ? $age_range[$accom] : null;
                $course_accommodations_table->type = $type[$accom] ?? null;
                $course_accommodations_table->placement_fee = $placement_fee[$accom] ?? null;
                $course_accommodations_table->program_duration = $program_duration[$accom] ?? null;
                $course_accommodations_table->deposit_fee = isset($deposit_fee[$accom]) ? $deposit_fee[$accom] : null;

                $course_accommodations_table->custodian_fee = $custodian_fee[$accom] ?? null;
                $course_accommodations_table->custodian_age_range = isset($age_range_for_custodian[$accom]) ? $age_range_for_custodian[$accom] : null;
                $course_accommodations_table->custodian_condition = $custodian_condition[$accom] ?? null;

                $course_accommodations_table->special_diet_fee = $special_diet_fee[$accom] ?? null;
                $course_accommodations_table->special_diet_note = $special_diet_note[$accom] ?? null;
                $course_accommodations_table->special_diet_note_ar = $special_diet_note_ar[$accom] ?? null;
                
                $course_accommodations_table->fee_per_week = $fee_per_week[$accom] ?? null;
                $course_accommodations_table->start_week = $start_week[$accom] ?? null;
                $course_accommodations_table->end_week = $end_week[$accom] ?? null;
                $course_accommodations_table->available_date = $available_date[$accom] ?? null;
                $course_accommodations_table->available_days = $available_days[$accom] ?? null;
                $course_accommodations_table->start_date = $start_date[$accom] ?? null;
                $course_accommodations_table->end_date = $end_date[$accom] ?? null;
                
                $course_accommodations_table->discount_per_week = (isset($discount_per_week[$accom]) ? $discount_per_week[$accom] : 0) . " " . (isset($discount_per_week_symbol[$accom]) ? $discount_per_week_symbol[$accom] : ' ');
                $course_accommodations_table->discount_per_week_symbol = $discount_per_week_symbol[$accom] ?? null;
                $course_accommodations_table->discount_start_date = $discount_start_date[$accom] ?? null;
                $course_accommodations_table->discount_end_date = $discount_end_date[$accom] ?? null;
                
                $course_accommodations_table->summer_fee_per_week = isset($summer_fee_per_week[$accom]) ? $summer_fee_per_week[$accom] : null;
                $course_accommodations_table->summer_fee_start_date = isset($summer_fee_start_date[$accom]) ? $summer_fee_start_date[$accom] : null;
                $course_accommodations_table->summer_fee_end_date = isset($summer_fee_end_date[$accom]) ? $summer_fee_end_date[$accom] : null;
                
                $course_accommodations_table->peak_time_fee_per_week = isset($peak_time_fee_per_week[$accom]) ? $peak_time_fee_per_week[$accom] : null;
                $course_accommodations_table->peak_time_fee_start_date = isset($peak_time_fee_start_date[$accom]) ? $peak_time_fee_start_date[$accom] : null;
                $course_accommodations_table->peak_time_fee_end_date = $peak_time_fee_end_date[$accom] ?? null;
                
                $course_accommodations_table->christmas_fee_per_week = $christmas_fee_per_week[$accom] ?? null;
                $course_accommodations_table->christmas_fee_start_date = $christmas_fee_start_date[$accom] ?? null;
                $course_accommodations_table->christmas_fee_end_date = $christmas_fee_end_date[$accom] ?? null;
                $course_accommodations_table->save();

                \Session::push('accom_ids', $accommodation_id[$accom]);
            }
        }

        return true;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createAccommodationUnderAge(Request $request)
    {
        return \DB::transaction(function () use ($request) {
            $rules = [
                'accom_id' => 'required',
            ];

            /*
             * Validation Rules Starts here
             * */
            $validation = \Validator::make($request->all(), $rules, [
                'accom_id.required' => "Accommodation ID is required",
            ]);

            if ($validation->fails()) {
                return $this->get_error = $validation->errors();
            }

            extract($request->all());

            for ($i = 0; $i < (int)$accomunderageincrement; $i++) {
                $new_course_accommodation_under_age = new CourseAccommodationUnderAge();
                $new_course_accommodation_under_age->accom_id = $accom_id;
                $new_course_accommodation_under_age->under_age = isset($under_age[$i]) ? $under_age[$i] : null;
                $new_course_accommodation_under_age->under_age_fees = isset($under_age_fee_per_week[$i]) ? $under_age_fee_per_week[$i] : null;
                $new_course_accommodation_under_age->save();
            }

            return true;
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createAirportMedicalFee(Request $request)
    {
        return \DB::transaction(function () use ($request) {
            $rules = [
                'airport_service_provider.*' => 'required',
                'airport_week_selected_fee.*' => 'required',
                'airport_note.*' => 'required',
                'medical_company_name.*' => 'required',
                'medical_deductible.*' => 'required',
                'medical_week_selected_fee.*' => 'required',
                'medical_note.*' => 'required',
            ];

            /*
             * Validation Rules Starts here
             * */
            $validation = \Validator::make($request->all(), $rules, [
                'airport_service_provider.*.required' => "Airport Service Provider required",
                'airport_week_selected_fee.*.required' => "Airport Week Selected Fee required",
                'airport_note.*.required' => "Airport Note required",
                'medical_company_name.*.required' => "Medical Company Name required",
                'medical_deductible.*.required' => "Medical Deductible required",
                'medical_week_selected_fee.*.required' => "Medical Week Selected Fee required",
                'medical_note.*.required' => "Medical Note required",
            ]);

            if ($validation->fails()) {
                return $this->get_error = $validation->errors();
            }

            for ($i = 0; $i <= $request->airportincrement; $i++) {
                $airport_save = new CourseAirport();
                $airport_save->course_unique_id = '' . \Session::get('course_id');
                $airport_save->service_provider = $request->airport_service_provider[$i] ?? null;
                $airport_save->week_selected_fee = $request->airport_week_selected_fee[$i] ?? null;
                $airport_save->note = $request->airport_note[$i] ?? null;
                $airport_save->note_ar = $request->airport_note_ar[$i] ?? null;
                $airport_save->save();
                
                for ($j = 0; $j <= $request->airportfeeincrement[$i]; $j++) {
                    if ($request->airport_name[$i][$j] && $request->airport_service_name[$i][$j]) {
                        $airport_fee_save = new CourseAirportFee();
                        $airport_fee_save->course_airport_unique_id = $airport_save->unique_id;
                        $airport_fee_save->name = $request->airport_name[$i][$j] ?? null;
                        $airport_fee_save->service_name = $request->airport_service_name[$i][$j] ?? null;
                        $airport_fee_save->service_fee = (double)$request->airport_service_fee[$i][$j] ?? null;
                        $airport_fee_save->save();
                    }
                }
            }

            for ($k = 0; $k <= $request->medicalincrement; $k++) {
                $medical_save = new CourseMedical();
                $medical_save->course_unique_id = '' . \Session::get('course_id');
                $medical_save->company_name = $request->medical_company_name[$k] ?? null;
                $medical_save->deductible = $request->medical_deductible[$k] ?? null;
                $medical_save->week_selected_fee = $request->medical_week_selected_fee[$k] ?? null;
                $medical_save->note = $request->medical_note[$k] ?? null;
                $medical_save->note_ar = $request->medical_note_ar[$k] ?? null;
                $medical_save->save();
                
                for ($l = 0; $l <= $request->medicalfeeincrement[$k]; $l++) {
                    if ($request->medical_fees_per_week[$k][$l]) {
                        $medical_fee_save = new CourseMedicalFee();
                        $medical_fee_save->course_medical_unique_id = $medical_save->unique_id;
                        $medical_fee_save->fees_per_week = (double)$request->medical_fees_per_week[$k][$l] ?? null;
                        $medical_fee_save->start_date =$request->medical_start_date[$k][$l] ?? null;
                        $medical_fee_save->end_date = $request->medical_end_date[$k][$l] ?? null;
                        $medical_fee_save->save();
                    }
                }
            }

            return true;
        });
    }

    /**
     * @param Request $r
     * @param $id
     * @return mixed
     */
    public function updateCourseAndProgram(Request $r, $id)
    {
        return \DB::transaction(function () use ($r, $id) {
            extract($r->all());

            $rules = [
                'language' => ['required', ],
                'study_mode' => ['required',],
                'program_type' => ['required',],
                'school_id' => ['required',],
                'currency' => ['required',],
                'program_level' => ['required',],
                'lessons_per_week' => ['required',],
                'hours_per_week' => ['required',],
                'study_time' => ['required',],
                'program_information' => ['required',],
                'program_cost.*' => 'required',
                'program_start_date.*' => 'required',
                'program_end_date.*' => 'required',
            ];

            /*
             * Validation Rules Starts here
             * */
            $validation = \Validator::make($r->all(), $rules, [
                'program_start_date.*.required' => 'Program Start Date required',
                'program_end_date.*.required' => 'Program End Date required',
            ]);

            if ($validation->fails()) {
                return $this->get_error = $validation->errors();
            }

            $course = Course::where('unique_id', $id)->first();

            $course->language = $r->language;
            $course->program_type = $r->program_type ?? [];
            $course->study_mode = $r->study_mode;
            $course->school_id = $r->school_id;
            $course->city = $r->city;
            $course->country = $r->country;
            $course->branch = $r->branch ?? [];
            $course->currency = $r->currency;

            $course->program_name = $r->program_name;
            $course->program_level = $r->program_level;
            $course->lessons_per_week = $r->lessons_per_week;
            $course->hours_per_week = $r->hours_per_week;
            $course->study_time = $r->study_time ?? [];
            $course->classes_day = $r->classes_day ?? [];
            $course->start_date = $r->start_date ?? [];
            $course->program_information = $r->program_information;
            $course->program_information_ar = $r->program_information_ar;

            $course->save();

            $course_id = $course->unique_id;
            \Session::put('course_id', $course_id);
            
            \Session::forget('program_ids');

            if (isset($program_increment)) {
                for ($count = 0; $count <= (int)$program_increment; $count++) {
                    $course_program = CourseProgram::where('unique_id', $r->program_id[$count])->first();
                    if(!$course_program)
                    {
                        $course_program = new CourseProgram;
                        $course_program->unique_id = $r->program_id[$count];    
                    }
                    $course_program->course_unique_id = $course_id;
                    if (isset($program_id[$count])) {
                        \Session::push('program_ids', $program_id[$count]);
                    }
    
                    if (isset($count)) {
                        $course_program->program_name = null;
                        $course_program->program_registration_fee = $r->program_registration_fee[$count];
                        $course_program->program_duration = $r->program_duration[$count] ?? null;
                        $course_program->program_age_range = isset($r->age_range[$count]) ? $r->age_range[$count] : null;
                        $course_program->courier_fee = $r->courier_fee[$count];
                        $course_program->about_courier = $r->about_courier[$count] ?? null;
                        $course_program->about_courier_ar = $r->about_courier_ar[$count] ?? null;
                        $course_program->program_cost = $r->program_cost[$count];
    
                        $course_program->program_duration_start = $r->program_duration_start[$count] ?? null;
                        $course_program->program_duration_end = $r->program_duration_end[$count] ?? null;
                        $course_program->program_start_date = $r->program_start_date[$count] ?? null;
                        $course_program->program_end_date = $r->program_end_date[$count] ?? null;
                        $course_program->available_date = $r->available_date[$count] ?? null;
                        $course_program->select_day_week = $r->select_day_week[$count] ?? null;
                        $course_program->available_days = $r->available_days[$count] ?? null;
                        $course_program->deposit = $r->deposit[$count] . " " . $r->deposit_symbol[$count] ?? null;
                        $course_program->discount_per_week = $r->discount_per_week[$count] . " " . $r->discount_per_week_symbol[$count] ?? null;
                        $course_program->discount_start_date = $r->discount_start_date[$count] ?? null;
                        $course_program->discount_end_date = $r->discount_end_date[$count] ?? null;
                        $course_program->christmas_start_date = $r->christmas_start_date[$count] ?? null;
                        $course_program->christmas_end_date = $r->christmas_end_date[$count] ?? null;
                        $course_program->x_week_selected = $r->x_week_selected[$count] ?? null;
                        $course_program->x_week_start_date = $r->x_week_start_date[$count] ?? null;
                        $course_program->x_week_end_date = $r->x_week_end_date[$count] ?? null;
                        $course_program->how_many_week_free = $r->how_many_week_free[$count] ?? null;
    
                        $course_program->summer_fee_per_week = $r->summer_fee_per_week[$count];
                        $course_program->summer_fee_start_date = $r->summer_fee_start_date[$count];
                        $course_program->summer_fee_end_date = $r->summer_fee_end_date[$count];
                        $course_program->peak_time_fee_per_week = $r->peak_time_fee_per_week[$count];
    
                        $course_program->peak_time_start_date = $r->peak_time_start_date[$count];
                        $course_program->peak_time_end_date = $r->peak_time_end_date[$count];
    
                        $course_program->save();
                    }
                }
            }
            
            return true;
        });
    }

    /**
     * @param Request $request
     * @param null $id
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function updateProgramUnderAgeAndTextBook(Request $request, $id = null)
    {
        $rules = [
            'program_id.*' => 'required',
            'text_book_fee_start_date.*' => 'required',
            'text_book_fee_end_date.*' => 'required',
            'text_book_note.*' => 'required',
        ];

        /*
         * Validation Rules Starts here
         * */
        $validation = \Validator::make($request->all(), $rules, [
            'program_id.*.required' => "Program ID is required",
            'text_book_fee_start_date.*.required' => "Text Book Fee Start Date is required",
            'text_book_fee_end_date.*.required' => "Text Book Fee End Date is required",
            'text_book_note.*.required' => "Text Book Note is required",
        ]);

        if ($validation->fails()) {
            return $this->get_error = $validation->errors();
        }

        $array_of_course_program_under_age = [];
        extract($request->all());

        if ($request->has('empty_age_range')) {
            for ($i = 0; $i < count($underagefeeincrement); $i++) {
                $program_under_age_fee = CourseProgramUnderAgeFee::where('course_program_id', $request->age_id[$i])->first();
                $program_under_age_fee->course_program_id = $program_id[0];
                $program_under_age_fee->under_age = $under_age[$i] ?? null;
                $program_under_age_fee->underage_fee_per_week = $underage_fee_per_week[$i] ?? null;
                $program_under_age_fee->save();
                $array_of_course_program_under_age[] = $program_under_age_fee->id;
            }
        } else {
            for ($i = 0; $i < count($underagefeeincrement); $i++) {
                if (isset($request->age_id[$i])) {
                    try {
                        $program_under_age_fee = CourseProgramUnderAgeFee::find($request->age_id[$i]);
                        $program_under_age_fee->under_age = $under_age[$i] ?? null;
                        $program_under_age_fee->underage_fee_per_week = $underage_fee_per_week[$i] ?? null;
                        $program_under_age_fee->save();
                    } catch(\ErrorException $errorException) {
                        if(str_contains($errorException->getMessage(), 'Undefined offset')) {
                            $program_under_age_fee = [];
                            $program_under_age_fee['course_program_id'] = $program_id[0];
                            $program_under_age_fee['under_age'] = $under_age[$i] ?? null;
                            $program_under_age_fee['underage_fee_per_week'] = $underage_fee_per_week[$i] ?? null;
                            CourseProgramUnderAgeFee::create($program_under_age_fee);
                        }
                        continue;
                    }
                } else {
                    $program_under_age_fee = [];
                    $program_under_age_fee['course_program_id'] = $program_id[0];
                    $program_under_age_fee['under_age'] = $under_age[$i] ?? null;
                    $program_under_age_fee['underage_fee_per_week'] = $underage_fee_per_week[$i] ?? null;
                    CourseProgramUnderAgeFee::create($program_under_age_fee);
                }
            }
        }

        $array_of_course_text_book = [];
        for ($textbook = 0; $textbook < count($textbookfeeincrement); $textbook++) {
            try {
                $program_text_book = CourseProgramTextBook::find($request->textbook_id[$textbook]);
                $program_text_book->program_id = $program_id[0];
                $program_text_book->text_book_fee = $text_book_fee[$textbook];
                $program_text_book->text_book_start_date = $text_book_fee_start_date[$textbook];
                $program_text_book->text_book_end_date = $text_book_fee_end_date[$textbook];
                $program_text_book->text_book_not = $text_book_note[$textbook];
                $program_text_book->text_book_note_ar = $text_book_note_ar[$textbook];
                $program_text_book->save();
            } catch(\ErrorException $errorException) {
                if(str_contains($errorException->getMessage(), 'Undefined offset')) {
                    $program_text_book = new CourseProgramTextBook();
                    $program_text_book->program_id = $program_id[0];
                    $program_text_book->text_book_fee = $text_book_fee[$textbook];
                    $program_text_book->text_book_start_date = $text_book_fee_start_date[$textbook];
                    $program_text_book->text_book_end_date = $text_book_fee_end_date[$textbook];
                    $program_text_book->text_book_note = $text_book_note[$textbook];
                    $program_text_book->text_book_note_ar = $text_book_note_ar[$textbook];
                    $program_text_book->save();
                }
            }
        }

        return true;
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function updateAccommodation(Request $request)
    {
        \Session::forget('accom_ids');

        $rules = ['accommodation_id.*' => 'required', 'type.*' => 'required',];

        /*
         * Validation Rules Starts here
         * */
        $validation = \Validator::make($request->all(), $rules, [
            'accommodation_id.*.required' => 'Accommodation ID is required',
            'type.*.required' => 'Accommodation Type is required',
            'room_type.*.required' => 'Room Type is required',
            'meal.*.required' => 'Meal required',
            'age_range.required' => 'Age Range Duration required',
            'placement_fee.*.required' => 'Accommodation Placement Fee required',
            'program_duration.*.required' => "Accommodation Program Duration required",
            'deposit_fee.*.required' => "Deposit Fee is required",

            'custodian_fee.*.required' => "Custodian Fee is required",

            'age_range_for_custodian.required' => "Age Range For Custodian is required",

            'fee_per_week.*.required' => 'Accommodation Fee is required',
            'end_week.*.required' => 'Accommodation End Week is required',

            'start_week.required' => 'Accommodation Start Week required',
            'start_date.*.required' => 'Accommodation Start Date required',
            'end_date.*.required' => "Accommodation End Date required",
        ]);

        if ($validation->fails()) {
            return $this->get_error = $validation->errors();
        }

        extract($request->all());

        for ($accom = 0; $accom < count($accommodation_id); $accom++) {
            if (isset($accommodation_id[$accom])) {
                $course_accomodation = CourseAccommodation::where('unique_id', $accommodation_id[$accom])->first();
                $course_accomodation['course_unique_id'] = '' . \Session::get('course_id');
                $course_accomodation['room_type'] = $room_type[$accom] ?? null;
                $course_accomodation['meal'] = $meal[$accom] ?? null;
                $course_accomodation['age_range'] = isset($age_range[$accom]) ? $age_range[$accom] : null;
                $course_accomodation['type'] = $type[$accom] ?? null;
                $course_accomodation['placement_fee'] = $placement_fee[$accom] ?? null;
                $course_accomodation['program_duration'] = $program_duration[$accom] ?? null;
                $course_accomodation['deposit_fee'] = isset($deposit_fee[$accom]) ? $deposit_fee[$accom] : null;

                $course_accomodation['custodian_fee'] = $custodian_fee[$accom] ?? null;
                $course_accomodation['custodian_age_range'] = isset($age_range_for_custodian[$accom]) ? $age_range_for_custodian[$accom] : null;
                $course_accomodation['custodian_condition'] = $custodian_condition[$accom] ?? null;
                
                $course_accomodation['special_diet_fee'] = $special_diet_fee[$accom] ?? null;
                $course_accomodation['special_diet_note'] = $special_diet_note[$accom] ?? null;
                $course_accomodation['special_diet_note_ar'] = $special_diet_note_ar[$accom] ?? null;
                
                $course_accomodation['fee_per_week'] = $fee_per_week[$accom] ?? null;
                $course_accomodation['start_week'] = $start_week[$accom] ?? null;
                $course_accomodation['end_week'] = $end_week[$accom] ?? null;
                $course_accomodation['available_date'] = $available_date[$accom] ?? null;
                $course_accomodation['available_days'] = $available_days[$accom] ?? null;
                $course_accomodation['start_date'] = $start_date[$accom] ?? null;
                $course_accomodation['end_date'] = $end_date[$accom] ?? null;
                
                $course_accomodation['discount_per_week'] = $discount_per_week[$accom] . " " . $discount_per_week_symbol[$accom] ?? null;
                $course_accomodation['discount_per_week_symbol'] = $discount_per_week_symbol[$accom] ?? null;
                $course_accomodation['discount_start_date'] = $discount_start_date[$accom] ?? null;
                $course_accomodation['discount_end_date'] = $discount_end_date[$accom] ?? null;
                
                $course_accomodation['summer_fee_per_week'] = isset($summer_fee_per_week[$accom]) ? $summer_fee_per_week[$accom] : null;
                $course_accomodation['summer_fee_start_date'] = isset($summer_fee_start_date[$accom]) ? $summer_fee_start_date[$accom] : null;
                $course_accomodation['summer_fee_end_date'] = isset($summer_fee_end_date[$accom]) ? $summer_fee_end_date[$accom] : null;
                
                $course_accomodation['peak_time_fee_per_week'] = isset($peak_time_fee_per_week[$accom]) ? $peak_time_fee_per_week[$accom] : null;
                $course_accomodation['peak_time_fee_start_date'] = isset($peak_time_fee_start_date[$accom]) ? $peak_time_fee_start_date[$accom] : null;
                $course_accomodation['peak_time_fee_end_date'] = $peak_time_fee_end_date[$accom] ?? null;
                
                $course_accomodation['christmas_fee_per_week'] = $christmas_fee_per_week[$accom] ?? null;
                $course_accomodation['christmas_fee_start_date'] = $christmas_fee_start_date[$accom] ?? null;
                $course_accomodation['christmas_fee_end_date'] = $christmas_fee_end_date[$accom] ?? null;
                $course_accomodation->save();
                
                $save_accomodations[] = $course_accomodation;

                \Session::push('accom_ids', $course_accomodation['unique_id']);
            }
        }

        return true;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateAccommodationUnderAge(Request $request)
    {
        return \DB::transaction(function () use ($request) {
            $rules = [
                'accom_id' => 'required',
            ];

            /*
             * Validation Rules Starts here
             * */
            $validation = \Validator::make($request->all(), $rules, [
                'accom_id.required' => "Accommodation ID is required",
            ]);

            if ($validation->fails()) {
                return $this->get_error = $validation->errors();
            }

            extract($request->all());

            for ($i = 0; $i <= (int)$accomunderageincrement; $i++) {
                if (isset($accom_under_age_id[$i])) {
                    try {
                        $accommodation_under_age = CourseAccommodationUnderAge::find($accom_under_age_id[$i]);
                        $accommodation_under_age->accom_id = $accom_id;
                        $accommodation_under_age->under_age = isset($under_age[$i]) ? $under_age[$i] : null;
                        $accommodation_under_age->under_age_fees = isset($under_age_fee_per_week[$i]) ? $under_age_fee_per_week[$i] : null;
                        $accommodation_under_age->save();
                    } catch(\ErrorException $errorException) {
                        if (str_contains($errorException->getMessage(), 'Undefined offset')) {
                            $accommodation_under_age = [];
                            $accommodation_under_age['accom_id'] = $accom_id;
                            $accommodation_under_age['under_age'] = isset($under_age[$i]) ? $under_age[$i] : null;
                            $accommodation_under_age['under_age_fees'] = isset($under_age_fee_per_week[$i]) ? $under_age_fee_per_week[$i] : null;
                            CourseAccommodationUnderAge::create($accommodation_under_age);
                        }
                        continue;
                    }
                } else {
                    $accommodation_under_age = [];
                    $accommodation_under_age['accom_id'] = $accom_id;
                    $accommodation_under_age['under_age'] = isset($under_age[$i]) ? $under_age[$i] : null;
                    $accommodation_under_age['under_age_fees'] = isset($under_age_fee_per_week[$i]) ? $under_age_fee_per_week[$i] : null;
                    CourseAccommodationUnderAge::create($accommodation_under_age);
                }
            }

            return true;
        });
    }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function updateAirportMedicalFee(Request $request, $id=null)
    {
        return \DB::transaction(function () use ($request, $id) {
            $rules = [
                'airport_service_provider.*' => 'required',
                'airport_week_selected_fee.*' => 'required',
                'airport_note.*' => 'required',
                'medical_company_name.*' => 'required',
                'medical_deductible.*' => 'required',
                'medical_week_selected_fee.*' => 'required',
                'medical_note.*' => 'required',
            ];

            /*
             * Validation Rules Starts here
             * */
            $validation = \Validator::make($request->all(), $rules, [
                'airport_service_provider.*.required' => "Airport Service Provider required",
                'airport_week_selected_fee.*.required' => "Airport Week Selected Fee required",
                'airport_note.*.required' => "Airport Note required",
                'medical_company_name.*.required' => "Medical Company Name required",
                'medical_deductible.*.required' => "Medical Deductible required",
                'medical_week_selected_fee.*.required' => "Medical Week Selected Fee required",
                'medical_note.*.required' => "Medical Note required",
            ]);

            if ($validation->fails()) {
                return $this->get_error = $validation->errors();
            }

            for ($i = 0; $i <= $request->airportincrement; $i++) {
                if (isset($request->airport_id[$i])) {
                    $airport_save = CourseAirport::where('unique_id', $request->airport_id[$i])->first();
                    if ($airport_save) {
                        $airport_save->course_unique_id = $id;
                        $airport_save->service_provider = $request->airport_service_provider[$i] ?? null;
                        $airport_save->week_selected_fee = $request->airport_week_selected_fee[$i] ?? null;
                        $airport_save->note = $request->airport_note[$i] ?? null;
                        $airport_save->note_ar = $request->airport_note_ar[$i] ?? null;
                        $airport_save->save();
                        $airport_save_id = $airport_save->unique_id;
                    } else {
                        $airport_save = new CourseAirport();
                        $airport_save->course_unique_id = $id;
                        $airport_save->service_provider = $request->airport_service_provider[$i] ?? null;
                        $airport_save->week_selected_fee = $request->airport_week_selected_fee[$i] ?? null;
                        $airport_save->note = $request->airport_note[$i] ?? null;
                        $airport_save->note_ar = $request->airport_note_ar[$i] ?? null;
                        $airport_save->save();
                        $airport_save_id = $airport_save->unique_id;
                    }
                } else {
                    $airport_save = new CourseAirport();
                    $airport_save->course_unique_id = $id;
                    $airport_save->service_provider = $request->airport_service_provider[$i] ?? null;
                    $airport_save->week_selected_fee = $request->airport_week_selected_fee[$i] ?? null;
                    $airport_save->note = $request->airport_note[$i] ?? null;
                    $airport_save->note_ar = $request->airport_note_ar[$i] ?? null;
                    $airport_save->save();
                    $airport_save_id = $airport_save->unique_id;
                }

                $airport_fees = $airport_save->fees()->get();
                foreach ($airport_fees as $airport_fee) {
                    if (!in_array($airport_fee->unique_id, $request->airport_fee_id)) {
                        $airport_fee->delete();
                    }
                }

                for ($j = 0; $j <= $request->airportfeeincrement[$i]; $j++) {
                    if ($request->airport_name[$i][$j] && $request->airport_service_name[$i][$j]) {
                        if (isset($request->airport_fee_id[$j])) {
                            $airport_fee_save = CourseAirportFee::where('unique_id', $request->airport_fee_id[$j])->first();
                            if ($airport_fee_save) {
                                $airport_fee_save->course_airport_unique_id = $airport_save_id;
                                $airport_fee_save->name = $request->airport_name[$i][$j] ?? null;
                                $airport_fee_save->service_name = $request->airport_service_name[$i][$j] ?? null;
                                $airport_fee_save->service_fee = (double)$request->airport_service_fee[$i][$j] ?? null;
                                $airport_fee_save->save();
                            } else {
                                $airport_fee_save = new CourseAirportFee();
                                $airport_fee_save->course_airport_unique_id = $airport_save_id;
                                $airport_fee_save->name = $request->airport_name[$i][$j] ?? null;
                                $airport_fee_save->service_name = $request->airport_service_name[$i][$j] ?? null;
                                $airport_fee_save->service_fee = (double)$request->airport_service_fee[$i][$j] ?? null;
                                $airport_fee_save->save();
                            }
                        } else {
                            $airport_fee_save = new CourseAirportFee();
                            $airport_fee_save->course_airport_unique_id = $airport_save_id;
                            $airport_fee_save->name = $request->airport_name[$i][$j] ?? null;
                            $airport_fee_save->service_name = $request->airport_service_name[$i][$j] ?? null;
                            $airport_fee_save->service_fee = (double)$request->airport_service_fee[$i][$j] ?? null;
                            $airport_fee_save->save();
                        }
                    }
                }
            }

            for ($k = 0; $k <= $request->medicalincrement; $k++) {
                if (isset($request->medical_id[$k])) {
                    $medical_save = CourseMedical::where('unique_id', $request->medical_id[$k])->first();
                    if ($medical_save) {
                        $medical_save->course_unique_id = $id;
                        $medical_save->company_name = $request->medical_company_name[$k] ?? null;
                        $medical_save->deductible = $request->medical_deductible[$k] ?? null;
                        $medical_save->week_selected_fee = $request->medical_week_selected_fee[$k] ?? null;
                        $medical_save->note = $request->medical_note[$k] ?? null;
                        $medical_save->note_ar = $request->medical_note_ar[$k] ?? null;
                        $medical_save->save();
                        $medical_save_id = $medical_save->unique_id;
                    } else {
                        $medical_save = new CourseMedical();
                        $medical_save->course_unique_id = $id;
                        $medical_save->company_name = $request->medical_company_name[$k] ?? null;
                        $medical_save->deductible = $request->medical_deductible[$k] ?? null;
                        $medical_save->week_selected_fee = $request->medical_week_selected_fee[$k] ?? null;
                        $medical_save->note = $request->medical_note[$k] ?? null;
                        $medical_save->note_ar = $request->medical_note_ar[$k] ?? null;
                        $medical_save->save();
                        $medical_save_id = $medical_save->unique_id;
                    }
                } else {
                    $medical_save = new CourseMedical();
                    $medical_save->course_unique_id = $id;
                    $medical_save->company_name = $request->medical_company_name[$k] ?? null;
                    $medical_save->deductible = $request->medical_deductible[$k] ?? null;
                    $medical_save->week_selected_fee = $request->medical_week_selected_fee[$k] ?? null;
                    $medical_save->note = $request->medical_note[$k] ?? null;
                    $medical_save->note_ar = $request->medical_note_ar[$k] ?? null;
                    $medical_save->save();
                    $medical_save_id = $medical_save->unique_id;
                }

                $medical_fees = $medical_save->fees()->get();
                foreach ($medical_fees as $medical_fee) {
                    if (!in_array($medical_fee->unique_id, $request->medical_fee_id)) {
                        $medical_fee->delete();
                    }
                }

                for ($l = 0; $l <= $request->medicalfeeincrement[$k]; $l++) {
                    if ($request->medical_fees_per_week[$k][$l]) {
                        if (isset($request->medical_fee_id[$l])) {
                            $medical_fee_save = CourseMedicalFee::where('unique_id', $request->medical_fee_id[$l])->first();
                            if ($medical_fee_save) {
                                $medical_fee_save->course_medical_unique_id = $medical_save_id;
                                $medical_fee_save->fees_per_week = (double)$request->medical_fees_per_week[$k][$l] ?? null;
                                $medical_fee_save->start_date = $request->medical_start_date[$k][$l] ?? null;
                                $medical_fee_save->end_date = $request->medical_end_date[$k][$l] ?? null;
                                $medical_fee_save->save();
                            } else {
                                $medical_fee_save = new CourseMedicalFee();
                                $medical_fee_save->course_medical_unique_id = $medical_save_id;
                                $medical_fee_save->fees_per_week = (double)$request->medical_fees_per_week[$k][$l] ?? null;
                                $medical_fee_save->start_date = $request->medical_start_date[$k][$l] ?? null;
                                $medical_fee_save->end_date = $request->medical_end_date[$k][$l] ?? null;
                                $medical_fee_save->save();
                            }
                        } else {
                            $medical_fee_save = new CourseMedicalFee();
                            $medical_fee_save->course_medical_unique_id = $medical_save_id;
                            $medical_fee_save->fees_per_week = (double)$request->medical_fees_per_week[$k][$l] ?? null;
                            $medical_fee_save->start_date = $request->medical_start_date[$k][$l] ?? null;
                            $medical_fee_save->end_date = $request->medical_end_date[$k][$l] ?? null;
                            $medical_fee_save->save();
                        }
                    }                    
                }
            }

            return true;
        });
    }
}