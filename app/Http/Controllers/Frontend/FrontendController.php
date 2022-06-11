<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\FrontendCalculator;
use App\Classes\SendCourseNotificationToStudent;
use App\Classes\AccommodationCalculator;

use App\Events\UserCourseBookedStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnquiryRequest;

use App\Mail\EnquiryMail;
use App\Mail\CourseBooked;

use App\Models\Calculator;
use App\Models\City;
use App\Models\Country;
use App\Models\FrontPage;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserCourseBookedDetails;

use App\Models\Frontend\AppliedForVisa;
use App\Models\Frontend\Enquiry;

use App\Models\SuperAdmin\Choose_Accommodation_Age_Range;
use App\Models\SuperAdmin\Choose_Custodian_Under_Age;
use App\Models\SuperAdmin\Choose_Language;
use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Type;
use App\Models\SuperAdmin\Choose_Program_Under_Age;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseCustodian;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseProgramTextBookFee;
use App\Models\SuperAdmin\CourseProgramUnderAgeFee;
use App\Models\SuperAdmin\School;

use App\Services\FrontendServices;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use function Psy\debug;

/**
 * Class FrontendController
 * @package App\Http\Controllers\Frontend
 */
class FrontendController extends Controller
{
    /**
     * @return false
     */
    public function testCourseNotification()
    {
        return (new SendCourseNotificationToStudent())->sendNotification();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $course_language_ids = [];
        $course_age_range_ids = [];
        $course_country_ids = [];
        $course_program_type_ids = [];
        $course_study_mode_ids = [];
        $course_school_ids = [];

        $now = Carbon::now()->format('Y-m-d');
        $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
        foreach ($courses as $course) {
            $course_programs = $course->coursePrograms;
            $course_has_discount_program = false;
            foreach ($course_programs as $course_program) {
                $course_age_range_ids = array_merge($course_age_range_ids, $course_program->program_age_range);
                if ($course_program->discount_per_week != ' -' && $course_program->discount_per_week != ' %' && 
                    (($course_program->discount_start_date <= $now && $course_program->discount_end_date >= $now)
                    || ($course_program->x_week_selected && $course_program->x_week_start_date <= $now && $course_program->x_week_end_date >= $now))) {
                    $course_has_discount_program = true;
                }
            }
            $course_language_ids = array_merge($course_language_ids, $course->language ?? []);
            $course_country_ids[] = $course->country_id;
            $course_program_type_ids = array_merge($course_program_type_ids, $course->program_type ?? []);
            $course_study_mode_ids = array_merge($course_study_mode_ids, $course->study_mode ?? []);
            if ($course_has_discount_program) $course_school_ids[] = $course->school_id;
        }
        $course_school_ids = array_unique($course_school_ids);
        $course_age_range_ids = array_unique($course_age_range_ids);

        $languages = Choose_Language::whereIn('unique_id', $course_language_ids)->orderBy('name', 'asc')->get();
        $schools = School::with('courses.coursePrograms')->whereIn('id', $course_school_ids)->where('is_active', true)->get();

        $setting_value = [];
        $home_page = Setting::where('setting_key', 'home_page')->first();
        if ($home_page) {
            $setting_value = unserialize($home_page->setting_value);
        }

        return view('frontend.index', compact('setting_value', 'schools', 'languages'));
    }

    /**
     * @param EnquiryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitEnquiry(EnquiryRequest $request)
    {
        \Mail::to(env('MAIL_TO_ADDRESS'))->send(new EnquiryMail($request));

        Enquiry::create($request->validated());
        $thankyou = __('Frontend.message_sent_thank_you');
        toastr()->success($thankyou);
        return back();
    }

    /*
     * @param id
     *
     * @return view school_details
     *
     * */
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function schoolDetails($id)
    {
        $school = School::with('nationalities.nationality')->where('id', $id)->firstOrFail();
        $language_ids = [];
        $study_mode_ids = [];
        $program_age_range_ids = [];
        $school_courses = $school->availableCourses()->get();
        foreach ($school_courses as $school_course) {
            $language_ids = array_merge($language_ids, $school_course->language);
            $study_mode_ids = array_merge($study_mode_ids, $school_course->study_mode);
            foreach ($school_course->coursePrograms as $school_course_program) {
                $program_age_range_ids = array_merge($program_age_range_ids, $school_course_program->program_age_range);
            }
        }
        $languages = Choose_Language::whereIn('unique_id', $language_ids)->get();
        $study_modes = Choose_Study_Mode::whereIn('unique_id', $study_mode_ids)->get();
        $age_ranges = Choose_Program_Age_Range::whereIn('unique_id', $program_age_range_ids)->get();

        $school->viewed_count += 1;
        $school->save();

        $school_top_review_course_booked_details = getSchoolTopReviewCourseBookedDetails($id);

        $school_branches = [];
        if ($school) {
            $school_branches = School::where('name_id', $school->name_id)->where('id', '<>', $id)->get();
        }

        return view('frontend.school.details', ['id' => $id], compact('school', 'school_top_review_course_booked_details', 'languages', 'study_modes', 'age_ranges', 'school_branches'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getPrograms(Request $request)
    {
        $data['data'] = FrontendServices::getPrograms($request);

        return response($data);
    }

    /**
     * @param $school_id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function likeschool($school_id)
    {
        return auth()->user()->likedSchool()->updateOrCreate(['school_id' => $school_id, 'user_id' => auth()->user()->id], ['school_id' => $school_id, 'user_id' => auth()->user()->id]);
    }

    public function backDetails(Request $request)
    {
        $course_register_details_reqeust = $request->all();
        unset($course_register_details_reqeust->_token);
        \Session::put('course_register_details', $course_register_details_reqeust);
        
        $data['data'] = '';
        $data['url'] = route('land_page');
        $data['success'] = true;

        $course_details = (object)(\Session::get('course_details') ?? []);
        if (isset($course_details->program_id)) {
            $course = Course::where('unique_id', $course_details->program_id)->first();
            if ($course) {
                $data['url'] = route('course.single', ['school_id' => $course->school_id, 'program_id' => $course->unique_id]);
            }
        }
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewRegister(Request $request)
    {
        if ($request->isMethod('post')) {
            if (\Session::has('course_details')) {
                \Session::put('course_details_old', \Session::get('course_details'));
            }
            $course_details_request = $request->all();
            unset($course_details_request->_token);
            \Session::put('course_details', $course_details_request);
        }

        $course_details = (object)\Session::get('course_details') ?? $request;

        $course = isset($course_details->program_id) ? Course::where('unique_id', '' . $course_details->program_id)->first() : '';
        $course_country = $course ? $course->country_id : '';

        $course_program = CourseProgram::where('unique_id', '' . $course_details->program_unique_id)->first();
        $age_ranges = $course_program ? $course_program->program_age_range : [];
        $program_age_range = getCourseProgramAgeRange($age_ranges);
        $min_age = $program_age_range['min_age']; $max_age = $program_age_range['max_age'];

        $course_accommodation = CourseAccommodation::where('unique_id', '' . $course_details->accommodation_id)->first();
        $age_ranges = $course_accommodation ? $course_accommodation->age_range : [];
        $course_accommodation_age_range = getCourseAccommodationAgeRange($age_ranges);
        $accommodation_min_age = $course_accommodation_age_range['min_age']; $accommodation_max_age = $course_accommodation_age_range['max_age'];
        
        $custodian_under_age = Choose_Custodian_Under_Age::whereIn('age', [$course_details->age_selected])->value('unique_id');
        $course_custodian = CourseCustodian::where('course_unique_id', '' . $course_details->program_unique_id)->where('age_range', 'LIKE', '%' . $custodian_under_age . '%')->first();
        $age_ranges = $course_custodian ? $course_custodian->age_range : [];
        $course_custodian_age_range = getCourseAccommodationAgeRange($age_ranges);
        $custodian_min_age = $course_custodian_age_range['min_age']; $custodian_max_age = $course_custodian_age_range['max_age'];        

        return view('frontend.course.register', compact('course_details', 'course_country', 'min_age', 'max_age', 'accommodation_min_age', 'accommodation_max_age', 'custodian_min_age', 'custodian_max_age'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $rules = [
            'min_age' => 'sometimes',
            'max_age' => 'sometimes',
            'accommodation_min_age' => 'sometimes',
            'accommodation_max_age' => 'sometimes',
            'custodian_min_age' => 'sometimes',
            'custodian_max_age' => 'sometimes',
            'fname' => 'required',
            'mname' => 'sometimes',
            'lname' => 'required',
            'place_of_birth' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'nationality' => 'required',
            'id_number' => 'required',
            'passport_number' => 'required',
            'passport_date_of_issue' => 'required',
            'passport_date_of_expiry' => 'required',
            'passport_copy' => 'required|mimes:jpg,bmp,png,jpeg,pdf',
            'level_of_language' => 'required',
            'study_finance' => 'required',
            'financial_guarantee' => 'required_if:study_finance,scholarship|mimes:jpg,bmp,png,jpeg,pdf',
            'bank_statement' => 'sometimes|mimes:jpg,bmp,png,jpeg,pdf',

            'mobile' => 'required',
            'telephone' => 'sometimes',
            'email' => 'required',
            'heard_where' => 'sometimes',
            'address' => 'required',
            'post_code' => 'required',
            'city_contact' => 'required',
            'province_region' => 'sometimes',
            'country_contact' => 'required',

            'full_name_emergency' => 'required',
            'relative_emergency' => 'required',
            'mobile_emergency' => 'required',
            'telephone_emergency' => 'sometimes',
            'email_emergency' => 'required',

            'comments' => 'sometimes',
        ];
        $validate = Validator::make($request->all(), $rules);

        $course_details = (object)(\Session::get('course_details') ?? []);

        $data['success'] = false;
        $dob_age = \Carbon\Carbon::parse($course_details->date_selected)->diffInYears(\Carbon\Carbon::parse($request->dob));
        if ($request->min_age > $dob_age || $request->max_age < $dob_age) {
            $data['errors'][] = "Age Not Eligible in Course";
            return response($data);
        }
        if (($request->accommodation_min_age && $request->accommodation_min_age > $dob_age) || ($request->accommodation_max_age && $request->accommodation_max_age < $dob_age)) {
            $data['errors'][] = "Age Not Eligible in Accommodation";
            return response($data);
        }
        if ($validate->fails()) {
            $data['errors'] = $validate->errors();
            return response($data);
        }

        try {
            $to_be_saved = $validate->validated();
            unset($to_be_saved['passport_copy']);
            unset($to_be_saved['financial_guarantee']);
            unset($to_be_saved['bank_statement']);
            if ($request->has('passport_copy')) {
                $passport_image_name = time() . rand(00, 99) . "." . $request->file('passport_copy')->getClientOriginalExtension();
                $to_be_saved['passport_copy'] = '/user_booked_details/' . $passport_image_name;
                $request->passport_copy->move(storage_path('app/public/user_booked_details'), $passport_image_name);
            }
            if ($request->has('financial_guarantee')) {
                $finance_image = time() . rand(00, 99) . "." . $request->file('financial_guarantee')->getClientOriginalExtension();
                $to_be_saved['financial_guarantee'] = '/user_booked_details/' . $finance_image;
                $request->financial_guarantee->move(storage_path('app/public/user_booked_details'), $finance_image);
            }
            if ($request->has('bank_statement')) {
                $bank_statement_image = time() . rand(00, 99) . "." . $request->file('bank_statement')->getClientOriginalExtension();
                $to_be_saved['bank_statement'] = '/user_booked_details/' . $bank_statement_image;
                $request->bank_statement->move(storage_path('app/public/user_booked_details'), $bank_statement_image);
            }
            
            $data['success'] = true;
            \Session::put('course_register_details', $to_be_saved);
            $data['url'] = route('course.reservation.detail');
        } catch(\Exception $e) {
            $data['errors'] = 'Something Went Wrong Check Log File';
            $data['success'] = false;
            return response()->json($data);
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function reservation(Request $request)
    {
        $reservation_request = $request->all();
        unset($reservation_request->_token);
        \Session::put('course_reservation_details', $reservation_request);
        
        $data['data'] = '';
        $data['success'] = true;
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewReservation(Request $request)
    {
        \Session::forget('course_reservation_details');

        $course_details = (object)(\Session::get('course_details') ?? []);
        $course_register_details = (object)(\Session::get('course_register_details') ?? []);

        if (!isset($course_details->date_selected)) {
            return redirect()->route('land_page');
        }

        $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', [$course_details->age_selected])->pluck('age')->toArray();
        $program_under_age = Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');
        $custodian_under_age = Choose_Custodian_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');

        $data['program_start_date'] = Carbon::create($course_details->date_selected)->format('d-m-Y');
        $data['accommodation_start_date'] = $data['medical_start_date'] = Carbon::create($course_details->date_selected)->subDay()->format('d-m-Y');
        $data['program_end_date'] = programEndDateExcludingLastWeekend(Carbon::create($course_details->date_selected), $course_details->program_duration);
        $data['accommodation_end_date'] = Carbon::create($data['accommodation_start_date'])->addWeeks($course_details->accommodation_duration)->subDay()->format('d-m-Y');
        $data['medical_end_date'] = Carbon::create($data['medical_start_date'])->addWeeks($course_details->duration ?? 0)->subDay()->format('d-m-Y');
        $data['school'] = School::find($course_details->school_id);
        $data['course'] = isset($course_details->program_id) ? Course::where('unique_id', $course_details->program_id)->first() : '';
        $data['program'] = isset($course_details->program_unique_id) ? CourseProgram::where('unique_id', $course_details->program_unique_id)->first() : null;
        $data['program_text_book_fee'] = isset($course_details->program_unique_id) ? CourseProgramTextBookFee::where('course_program_id', $course_details->program_unique_id)->
            where('text_book_start_date', '<=', $course_details->program_unique_id)->where('text_book_end_date', '>=', $course_details->program_unique_id)->first() : '';
        $data['program_under_age_fee'] = isset($course_details->program_unique_id) ? CourseProgramUnderAgeFee::where('course_program_id', $course_details->program_unique_id)->
            where('under_age', 'LIKE', '%' . $program_under_age . '%')->first() : '';
        $data['accommodation'] = isset($course_details->accommodation_id) ? CourseAccommodation::where('unique_id', '' . $course_details->accommodation_id)->first() : '';
        $data['airport'] = isset($course_details->airport_provider) ? CourseAirport::where('course_unique_id', $course_details->program_id)->where('service_provider', $course_details->airport_provider)->first() : null;
        $data['medical'] = (isset($course_details->company_name) && isset($course_details->deductible_up_to)) ? CourseMedical::where('course_unique_id', $course_details->program_id)->where('company_name', $course_details->company_name)->where('deductible', $course_details->deductible_up_to)->first() : null;
        $data['custodian'] = CourseCustodian::where('course_unique_id', $course_details->program_id)->where('age_range', 'LIKE', '%' . $custodian_under_age . '%')->first();

        $deposit_price = $program_registration_fee = 0;
        if (isset($course_register_details->financial_guarantee)) {
            $deposit_price = 0;
        } else {
            if ($data['program']->deposit) {
                $program_deposits = explode(" ", $data['program']->deposit);
                if (count($program_deposits) >= 2) {
                    if ($program_deposits[1] == '%') {
                        $deposit_price = $data['program']->program_cost * (int)$program_deposits[0] / 100;
                    } else {
                        $deposit_price = (int)$program_deposits[0];
                    }
                }
            }
        }

        $default_currency = getDefaultCurrency();

        $program_cost = readCalculationFromDB('program_cost') ?? 0;
        $program_registration_fee = readCalculationFromDB('program_registration_fee') ?? 0;
        $program_text_book_fee = readCalculationFromDB('text_book_fee') ?? 0;
        $program_summer_fee = readCalculationFromDB('summer_fee') ?? 0;
        $program_under_age_fee = readCalculationFromDB('under_age_fee') ?? 0;
        $program_peak_time_fee = readCalculationFromDB('peak_time_fee') ?? 0;
        $program_courier_fee = readCalculationFromDB('courier_fee') ?? 0;
        $program_discount_fee = readCalculationFromDB('discount_fee') ?? 0;
        $program_total = readCalculationFromDB('total') ?? 0;
        
        $accommodation_fee = readCalculationFromDB('accommodation_fee') ?? 0;
        $accommodation_placement_fee = readCalculationFromDB('accommodation_placement_fee') ?? 0;
        $accommodation_special_diet_fee = readCalculationFromDB('accommodation_special_diet_fee') ?? 0;
        $accommodation_deposit_fee = readCalculationFromDB('accommodation_deposit') ?? 0;
        $accommodation_summer_fee = readCalculationFromDB('accommodation_summer_fee') ?? 0;
        $accommodation_christmas_fee = readCalculationFromDB('accommodation_christmas_fee') ?? 0;
        $accommodation_under_age_fee = readCalculationFromDB('accommodation_under_age_fee') ?? 0;
        $accommodation_peak_fee = readCalculationFromDB('accommodation_peak_time_fee') ?? 0;
        $accommodation_discount_fee = readCalculationFromDB('accommodation_discount') ?? 0;
        $accommodation_total = (readCalculationFromDB('accommodation_total') ?? 0) - $accommodation_discount_fee;

        $airport_pickup_fee = readCalculationFromDB('airport_pickup_fee') ?? 0;
        $medical_insurance_fee = readCalculationFromDB('medical_insurance_fee') ?? 0;
        $custodian_fee = readCalculationFromDB('custodian_fee') ?? 0;

        $total_discount = $program_discount_fee + $accommodation_discount_fee;
        $total_cost = (readCalculationFromDB('total') ?? 0)
                + (readCalculationFromDB('accommodation_total') ?? 0) + (readCalculationFromDB('accommodation_special_diet_fee') ?? 0)
                + (readCalculationFromDB('airport_pickup_fee') ?? 0) + (readCalculationFromDB('medical_insurance_fee') ?? 0) + (readCalculationFromDB('custodian_fee') ?? 0)
                - (readCalculationFromDB('discount_fee') ?? 0) - (readCalculationFromDB('accommodation_discount') ?? 0);
        $sub_total = $total_cost + $total_discount;
        $total_balance = $total_cost - $deposit_price;

        $calculator_values = getCurrencyConvertedValues($course_details->program_id,
            [
                $program_cost,
                $program_registration_fee,
                $program_text_book_fee,
                $program_summer_fee,
                $program_under_age_fee,
                $program_peak_time_fee,
                $program_courier_fee,
                $program_discount_fee,
                $program_total,
                $accommodation_fee,
                $accommodation_placement_fee,
                $accommodation_special_diet_fee,
                $accommodation_deposit_fee,
                $accommodation_summer_fee,
                $accommodation_christmas_fee,
                $accommodation_under_age_fee,
                $accommodation_peak_fee,
                $accommodation_discount_fee,
                $accommodation_total,
                $airport_pickup_fee,
                $medical_insurance_fee,
                $custodian_fee,
                $total_discount,
                $sub_total,
                $total_cost,
                $deposit_price,
                $total_balance
            ]
        );
        $data['program_cost'] = [
            'value' => (float)$program_cost,
            'converted_value' => $calculator_values['values'][0]
        ];
        $data['program_registration_fee'] = [
            'value' => (float)$program_registration_fee,
            'converted_value' => $calculator_values['values'][1]
        ];
        $data['program_text_book_fee'] = [
            'value' => (float)$program_text_book_fee,
            'converted_value' => $calculator_values['values'][2]
        ];
        $data['program_summer_fees'] = [
            'value' => (float)$program_summer_fee,
            'converted_value' => $calculator_values['values'][3]
        ];
        $data['program_under_age_fees'] = [
            'value' => (float)$program_under_age_fee,
            'converted_value' => $calculator_values['values'][4]
        ];
        $data['program_peak_time_fees'] = [
            'value' => (float)$program_peak_time_fee,
            'converted_value' => $calculator_values['values'][5]
        ];
        $data['program_express_mail_fee'] = [
            'value' => (float)$program_courier_fee,
            'converted_value' => $calculator_values['values'][6]
        ];
        $data['program_discount_fee'] = [
            'value' => (float)$program_discount_fee,
            'converted_value' => $calculator_values['values'][7]
        ];
        $data['program_total'] = [
            'value' => (float)($program_total),
            'converted_value' => $calculator_values['values'][8]
        ];
        $data['accommodation_fee'] = [
            'value' => (float)($accommodation_fee),
            'converted_value' => $calculator_values['values'][9]
        ];
        $data['accommodation_placement_fee'] = [
            'value' => (float)($accommodation_placement_fee),
            'converted_value' => $calculator_values['values'][10]
        ];
        $data['accommodation_special_diet_fee'] = [
            'value' => (float)($accommodation_special_diet_fee),
            'converted_value' => $calculator_values['values'][11]
        ];
        $data['accommodation_deposit_fee'] = [
            'value' => (float)($accommodation_deposit_fee),
            'converted_value' => $calculator_values['values'][12]
        ];
        $data['accommodation_summer_fee'] = [
            'value' => (float)($accommodation_summer_fee),
            'converted_value' => $calculator_values['values'][13]
        ];
        $data['accommodation_christmas_fee'] = [
            'value' => (float)($accommodation_christmas_fee),
            'converted_value' => $calculator_values['values'][14]
        ];
        $data['accommodation_under_age_fee'] = [
            'value' => (float)($accommodation_under_age_fee),
            'converted_value' => $calculator_values['values'][15]
        ];
        $data['accommodation_peak_fee'] = [
            'value' => (float)($accommodation_peak_fee),
            'converted_value' => $calculator_values['values'][16]
        ];
        $data['accommodation_discount_fee'] = [
            'value' => (float)($accommodation_discount_fee),
            'converted_value' => $calculator_values['values'][17]
        ];
        $data['accommodation_total'] = [
            'value' => (float)($accommodation_total),
            'converted_value' => $calculator_values['values'][18]
        ];
        $data['airport_pickup_fee'] = [
            'value' => (float)$airport_pickup_fee,
            'converted_value' => $calculator_values['values'][19]
        ];
        $data['medical_insurance_fee'] = [
            'value' => (float)$medical_insurance_fee,
            'converted_value' => $calculator_values['values'][20]
        ];
        $data['custodian_fee'] = [
            'value' => (float)$custodian_fee,
            'converted_value' => $calculator_values['values'][21]
        ];
        $data['total_discount'] = [
            'value' => (float)$total_discount,
            'converted_value' => $calculator_values['values'][22]
        ];
        $data['sub_total'] = [
            'value' => (float)$sub_total,
            'converted_value' => $calculator_values['values'][23]
        ];
        $data['total_cost'] = [
            'value' => (float)$total_cost,
            'converted_value' => $calculator_values['values'][24]
        ];
        $data['deposit_price'] = [
            'value' => (float)$deposit_price,
            'converted_value' => $calculator_values['values'][25]
        ];
        $data['total_balance'] = [
            'value' => (float)$total_balance,
            'converted_value' => $calculator_values['values'][26]
        ];
        $data['currency'] = [
            'cost' => $calculator_values['currency'],
            'converted' => $default_currency['currency'],
        ];

        return view('frontend.course.reservation', $data, compact('course_details', 'course_register_details'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewConfirmReservation(Request $request)
    {
        $course_details = (object)(\Session::get('course_details') ?? []);
        $course_register_details = (object)(\Session::get('course_register_details') ?? []);
        $course_reservation_details = (object)(\Session::get('course_reservation_details') ?? []);

        if (!isset($course_details->date_selected)) {
            return redirect()->route('land_page');
        }

        $today = Carbon::now()->format('d-m-Y');
        $school = School::find($course_details->school_id);

        return view('frontend.course.reservation-confirm', compact('today', 'school', 'course_details', 'course_register_details', 'course_reservation_details'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirmReservation(Request $request)
    {
        $course_details = (object)(\Session::get('course_details') ?? []);
        $course_register_details = (object)(\Session::get('course_register_details') ?? []);
        $course_reservation_details = (object)(\Session::get('course_reservation_details') ?? []);
        
        $rules = [
            'student_guardian_full_name' => 'required',
            'registraion_terms_conditions_privacy_policy' => 'required',
            'terms' => 'required',
            'signature' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        $data['success'] = false;
        if ($validate->fails()) {
            $data['errors'] = $validate->errors();
            return response($data);
        }

        //try {
            $to_be_saved = $validate->validated();
            unset($to_be_saved['student_guardian_full_name']);
            unset($to_be_saved['registraion_terms_conditions_privacy_policy']);
            unset($to_be_saved['terms']);

            $mail_pdf_data = array();

            // course_details
            $to_be_saved['school_id'] = $mail_pdf_data['school_id'] = $course_details->school_id ?? 0;
            $to_be_saved['course_id'] = $mail_pdf_data['course_id'] = $course_details->program_id ?? 0;
            $to_be_saved['course_program_id'] = $mail_pdf_data['course_program_id'] = $course_details->program_unique_id;
            $to_be_saved['start_date'] = $mail_pdf_data['start_date'] = $course_details->date_selected ?? null;
            $to_be_saved['end_date'] = $mail_pdf_data['end_date'] = (isset($course_details->date_selected) && isset($course_details->program_duration)) ? Carbon::create($course_details->date_selected)->addWeeks($course_details->program_duration)->format('Y-m-d') : null;
            $to_be_saved['study_mode'] = $mail_pdf_data['study_mode'] = $course_details->study_mode;
            $to_be_saved['age_selected'] = $mail_pdf_data['age_selected'] = $course_details->age_selected;
            $to_be_saved['program_duration'] = $mail_pdf_data['program_duration'] = $course_details->program_duration ?? null;

            $to_be_saved['accommodation_id'] = $mail_pdf_data['accommodation_id'] = $course_details->accommodation_id ?? 0;
            
            // course_reservation_details
            $to_be_saved['accommodation_start_date'] = $mail_pdf_data['accommodation_start_date'] = isset($course_reservation_details->accommodation_start_date) ? Carbon::create($course_reservation_details->accommodation_start_date)->format('Y-m-d') : null;
            $to_be_saved['accommodation_end_date'] = $mail_pdf_data['accommodation_end_date'] = isset($course_reservation_details->accommodation_end_date) ? Carbon::create($course_reservation_details->accommodation_end_date)->format('Y-m-d') : null;

            // course_details
            $to_be_saved['accommodation_duration'] = $mail_pdf_data['accommodation_duration'] = $course_details->accommodation_duration ?? null;

            $course_airport = isset($course_details->airport_provider) ? CourseAirport::where('course_unique_id', '' . $course_details->program_id)->where('service_provider', $course_details->airport_provider)->first() : null;
            $to_be_saved['airport_id'] = $mail_pdf_data['airport_id'] = $course_airport ? $course_airport->unique_id : 0;
            $to_be_saved['airport_provider'] = $mail_pdf_data['airport_provider'] = $course_details->airport_provider ?? null;
            $to_be_saved['airport_name'] = $mail_pdf_data['airport_name'] = $course_details->airport_name ?? null;
            $to_be_saved['airport_service'] = $mail_pdf_data['airport_service'] = $course_details->airport_service ?? null;

            $course_medical = (isset($course_details->company_name) && isset($course_details->deductible_up_to)) ? CourseMedical::where('course_unique_id', '' . $course_details->program_id)->where('company_name', $course_details->company_name)->where('deductible', $course_details->deductible_up_to)->first() : null;
            $to_be_saved['medical_id'] = $mail_pdf_data['medical_id'] = $course_medical ? $course_medical->unique_id : 0;
            $to_be_saved['medical_company'] = $mail_pdf_data['medical_company'] = $course_details->company_name ?? null;
            $to_be_saved['medical_deductible'] = $mail_pdf_data['medical_deductible'] = $course_details->deductible_up_to ?? null;

            // course_reservation_details
            $to_be_saved['medical_start_date'] = $mail_pdf_data['medical_start_date'] = isset($course_reservation_details->medical_start_date) ? Carbon::create($course_reservation_details->medical_start_date)->format('Y-m-d') : null;
            $to_be_saved['medical_end_date'] = $mail_pdf_data['medical_end_date'] = isset($course_reservation_details->medical_end_date) ? Carbon::create($course_reservation_details->medical_end_date)->format('Y-m-d') : null;

            // course_details
            $to_be_saved['medical_duration'] = $mail_pdf_data['medical_duration'] = $course_details->duration ?? null;

            // course_reservation_details
            $to_be_saved['program_cost'] = $course_reservation_details->program_cost ?? 0;
            $to_be_saved['registration_fee'] = $course_reservation_details->registration_fee ?? 0;
            $to_be_saved['text_book_fee'] = $course_reservation_details->text_book_fee ?? 0;
            $to_be_saved['summer_fees'] = $course_reservation_details->summer_fees ?? 0;
            $to_be_saved['peak_time_fees'] = $course_reservation_details->peak_time_fees ?? 0;
            $to_be_saved['under_age_fees'] = $course_reservation_details->under_age_fees ?? 0;
            $to_be_saved['courier_fee'] = $course_reservation_details->courier_fee ?? 0;
            $to_be_saved['discount_fee'] = $course_reservation_details->discount_fee ?? 0;

            $to_be_saved['accommodation_fee'] = $course_reservation_details->accommodation_fee ?? 0;
            $to_be_saved['accommodation_placement_fee'] = $course_reservation_details->accommodation_placement_fee ?? 0;
            $to_be_saved['accommodation_special_diet_fee'] = $course_reservation_details->accommodation_special_diet_fee ?? 0;
            $to_be_saved['accommodation_deposit_fee'] = $course_reservation_details->accommodation_deposit_fee ?? 0;
            $to_be_saved['accommodation_summer_fee'] = $course_reservation_details->accommodation_summer_fee ?? 0;
            $to_be_saved['accommodation_peak_fee'] = $course_reservation_details->accommodation_peak_fee ?? 0;
            $to_be_saved['accommodation_christmas_fee'] = $course_reservation_details->accommodation_christmas_fee ?? 0;
            $to_be_saved['accommodation_under_age_fee'] = $course_reservation_details->accommodation_under_age_fee ?? 0;
            $to_be_saved['accommodation_discount_fee'] = $course_reservation_details->accommodation_discount_fee ?? 0;
            
            $to_be_saved['airport_pickup_fee'] = $course_reservation_details->airport_pickup_fee ?? 0;
            $to_be_saved['medical_insurance_fee'] = $course_reservation_details->medical_insurance_fee ?? 0;
            $to_be_saved['custodian_fee'] = $course_reservation_details->custodian_fee ?? 0;
            
            $to_be_saved['sub_total'] = $course_reservation_details->sub_total ?? 0;
            $to_be_saved['total_discount'] = $course_reservation_details->total_discount ?? 0;
            $to_be_saved['total_cost'] = $course_reservation_details->total_cost ?? 0;
            $to_be_saved['deposit_price'] = $course_reservation_details->deposit_price ?? 0;
            $to_be_saved['total_balance'] = $course_reservation_details->total_balance ?? 0;

            $to_be_saved['other_currency'] = $course_reservation_details->other_currency;
            
            // course_reservation_details
            $to_be_saved['fname'] = $mail_pdf_data['fname'] = $course_register_details->fname ?? '';
            $to_be_saved['mname'] = $mail_pdf_data['mname'] = $course_register_details->mname ?? '';
            $to_be_saved['lname'] = $mail_pdf_data['lname'] = $course_register_details->lname ?? '';
            $to_be_saved['place_of_birth'] = $mail_pdf_data['place_of_birth'] = $course_register_details->place_of_birth ?? '';
            $to_be_saved['gender'] = $mail_pdf_data['gender'] = $course_register_details->gender ?? '';
            $to_be_saved['dob'] = $mail_pdf_data['dob'] = $course_register_details->dob ?? '';
            $to_be_saved['nationality'] = $mail_pdf_data['nationality'] = $course_register_details->nationality ?? '';
            $to_be_saved['id_number'] = $mail_pdf_data['id_number'] = $course_register_details->id_number ?? '';
            $to_be_saved['passport_number'] = $mail_pdf_data['passport_number'] = $course_register_details->passport_number ?? '';
            $to_be_saved['passport_date_of_issue'] = $mail_pdf_data['passport_date_of_issue'] = $course_register_details->passport_date_of_issue ?? '';
            $to_be_saved['passport_date_of_expiry'] = $mail_pdf_data['passport_date_of_expiry'] = $course_register_details->passport_date_of_expiry ?? '';
            $to_be_saved['passport_copy'] = $mail_pdf_data['passport_copy'] = $course_register_details->passport_copy ?? '';
            $to_be_saved['financial_guarantee'] = $course_register_details->financial_guarantee ?? '';
            $to_be_saved['bank_statement'] = $course_register_details->bank_statement ?? '';
            $to_be_saved['level_of_language'] = $mail_pdf_data['level_of_language'] = $course_register_details->level_of_language ?? '';
            $to_be_saved['study_finance'] = $mail_pdf_data['study_finance'] = $course_register_details->study_finance ?? '';
            $to_be_saved['mobile'] = $mail_pdf_data['mobile'] = $course_register_details->mobile ?? '';
            $to_be_saved['telephone'] = $mail_pdf_data['telephone'] = $course_register_details->telephone ?? '';
            $to_be_saved['email'] = $mail_pdf_data['email'] = $course_register_details->email ?? '';
            $to_be_saved['address'] = $mail_pdf_data['address'] = $course_register_details->address ?? '';
            $to_be_saved['post_code'] = $mail_pdf_data['post_code'] = $course_register_details->post_code ?? '';
            $to_be_saved['city_contact'] = $mail_pdf_data['city_contact'] = $course_register_details->city_contact ?? '';
            $to_be_saved['province_region'] = $mail_pdf_data['province_region'] = $course_register_details->province_region ?? '';
            $to_be_saved['country_contact'] = $mail_pdf_data['country_contact'] = $course_register_details->country_contact ?? '';
            $to_be_saved['full_name_emergency'] = $mail_pdf_data['full_name_emergency'] = $course_register_details->full_name_emergency ?? '';
            $to_be_saved['relative_emergency'] = $mail_pdf_data['relative_emergency'] = $course_register_details->relative_emergency ?? '';
            $to_be_saved['mobile_emergency'] = $mail_pdf_data['mobile_emergency'] = $course_register_details->mobile_emergency ?? '';
            $to_be_saved['telephone_emergency'] = $mail_pdf_data['telephone_emergency'] = $course_register_details->telephone_emergency ?? '';
            $to_be_saved['email_emergency'] = $mail_pdf_data['email_emergency'] = $course_register_details->email_emergency ?? '';
            $to_be_saved['heard_where'] = $mail_pdf_data['heard_where'] = $course_register_details->heard_where ?? [];
            $to_be_saved['other'] = $mail_pdf_data['other'] = $course_register_details->other ?? '';
            $to_be_saved['comments'] = $mail_pdf_data['comments'] = $course_register_details->comments ?? '';

            $to_be_saved['guardian_full_name'] = $mail_pdf_data['guardian_full_name'] = $request->student_guardian_full_name;
            $to_be_saved['signature'] = $mail_pdf_data['signature'] = $request->signature;

            Session::forget('accom_unique_id');
            Session::forget('airport_id');
            Session::forget('medical_id');

            Session::forget('course_details');
            Session::forget('course_register_details');
            Session::forget('course_reservation_details');

            $mail_pdf_data['program_start_date'] = Carbon::create($course_details->date_selected)->format('d-m-Y');
            $mail_pdf_data['accommodation_start_date'] = $mail_pdf_data['medical_start_date'] = Carbon::create($course_details->date_selected)->subDay()->format('d-m-Y');
            $mail_pdf_data['program_end_date'] = programEndDateExcludingLastWeekend(Carbon::create($course_details->date_selected), $course_details->program_duration);
            $mail_pdf_data['accommodation_end_date'] = Carbon::create($mail_pdf_data['accommodation_start_date'])->addWeeks($course_details->accommodation_duration)->subDay()->format('d-m-Y');
            $mail_pdf_data['medical_end_date'] = Carbon::create($mail_pdf_data['medical_start_date'])->addWeeks($course_details->duration ?? 0)->subDay()->format('d-m-Y');
            $mail_pdf_data['school'] = School::find($course_details->school_id);
            $mail_pdf_data['course'] = isset($course_details->program_id) ? Course::where('unique_id', $course_details->program_id)->first() : '';
            $mail_pdf_data['program'] = isset($course_details->program_unique_id) ? CourseProgram::where('unique_id', $course_details->program_unique_id)->first() : null;
            $mail_pdf_data['accommodation'] = isset($course_details->accommodation_id) ? CourseAccommodation::where('unique_id', '' . $course_details->accommodation_id)->first() : '';
            $mail_pdf_data['airport'] = isset($course_details->airport_provider) ? CourseAirport::where('course_unique_id', $course_details->program_id)->where('service_provider', $course_details->airport_provider)->first() : null;
            $mail_pdf_data['medical'] = (isset($course_details->company_name) && isset($course_details->deductible_up_to)) ? CourseMedical::where('course_unique_id', $course_details->program_id)->where('company_name', $course_details->company_name)->where('deductible', $course_details->deductible_up_to)->first() : null;
            $mail_pdf_data['custodian'] = CourseCustodian::where('course_unique_id', $course_details->program_id)->where('age_range', $course_details->company_name)->first();
            $mail_pdf_data['company_name'] = $course_details->company_name;
            $mail_pdf_data['duration'] = $course_details->duration;
            $mail_pdf_data['min_age'] = $course_register_details->min_age;
            $mail_pdf_data['max_age'] = $course_register_details->max_age;
            $mail_pdf_data['accommodation_min_age'] = $course_register_details->accommodation_min_age;
            $mail_pdf_data['accommodation_max_age'] = $course_register_details->accommodation_max_age;
            $mail_pdf_data['custodian_min_age'] = $course_register_details->custodian_min_age;
            $mail_pdf_data['custodian_max_age'] = $course_register_details->custodian_max_age;
            $mail_pdf_data['financial_guarantee'] = isset($course_register_details->financial_guarantee) ? true : false;
            
            $default_currency = getDefaultCurrency();
    
            $calculator_values = getCurrencyConvertedValues($course_details->program_id,
                [
                    $to_be_saved['program_cost'],
                    $to_be_saved['registration_fee'],
                    $to_be_saved['text_book_fee'],
                    $to_be_saved['summer_fees'],
                    $to_be_saved['under_age_fees'],
                    $to_be_saved['peak_time_fees'],
                    $to_be_saved['courier_fee'],
                    $to_be_saved['discount_fee'],
                    // $to_be_saved['program_total'],
                    $to_be_saved['accommodation_fee'],
                    $to_be_saved['accommodation_placement_fee'],
                    $to_be_saved['accommodation_special_diet_fee'],
                    $to_be_saved['accommodation_deposit_fee'],
                    $to_be_saved['accommodation_summer_fee'],
                    $to_be_saved['accommodation_christmas_fee'],
                    $to_be_saved['accommodation_under_age_fee'],
                    $to_be_saved['accommodation_peak_fee'],
                    $to_be_saved['accommodation_discount_fee'],
                    //$to_be_saved['accommodation_total'],
                    $to_be_saved['airport_pickup_fee'],
                    $to_be_saved['medical_insurance_fee'],
                    $to_be_saved['custodian_fee'],
                    $to_be_saved['total_discount'],
                    $to_be_saved['sub_total'],
                    $to_be_saved['total_cost'],
                    $to_be_saved['deposit_price'],
                    $to_be_saved['total_balance']
                ]
            );
            $mail_pdf_data['program_cost'] = [
                'value' => (float)$to_be_saved['program_cost'],
                'converted_value' => $calculator_values['values'][0]
            ];
            $mail_pdf_data['program_registration_fee'] = [
                'value' => (float)$to_be_saved['registration_fee'],
                'converted_value' => $calculator_values['values'][1]
            ];
            $mail_pdf_data['program_text_book_fee'] = [
                'value' => (float)$to_be_saved['text_book_fee'],
                'converted_value' => $calculator_values['values'][2]
            ];
            $mail_pdf_data['program_summer_fees'] = [
                'value' => (float)$to_be_saved['summer_fees'],
                'converted_value' => $calculator_values['values'][3]
            ];
            $mail_pdf_data['program_under_age_fees'] = [
                'value' => (float)$to_be_saved['under_age_fees'],
                'converted_value' => $calculator_values['values'][4]
            ];
            $mail_pdf_data['program_peak_time_fees'] = [
                'value' => (float)$to_be_saved['peak_time_fees'],
                'converted_value' => $calculator_values['values'][5]
            ];
            $mail_pdf_data['program_express_mail_fee'] = [
                'value' => (float)$to_be_saved['courier_fee'],
                'converted_value' => $calculator_values['values'][6]
            ];
            $mail_pdf_data['program_discount_fee'] = [
                'value' => (float)$to_be_saved['discount_fee'],
                'converted_value' => $calculator_values['values'][7]
            ];
            // $mail_pdf_data['program_total'] = [
            //     'value' => (float)$to_be_saved['program_total'],
            //     'converted_value' => $calculator_values['values'][8]
            // ];
            $mail_pdf_data['accommodation_fee'] = [
                'value' => (float)$to_be_saved['accommodation_fee'],
                'converted_value' => $calculator_values['values'][8]
            ];
            $mail_pdf_data['accommodation_placement_fee'] = [
                'value' => (float)$to_be_saved['accommodation_placement_fee'],
                'converted_value' => $calculator_values['values'][9]
            ];
            $mail_pdf_data['accommodation_special_diet_fee'] = [
                'value' => (float)$to_be_saved['accommodation_special_diet_fee'],
                'converted_value' => $calculator_values['values'][10]
            ];
            $mail_pdf_data['accommodation_deposit_fee'] = [
                'value' => (float)$to_be_saved['accommodation_deposit_fee'],
                'converted_value' => $calculator_values['values'][11]
            ];
            $mail_pdf_data['accommodation_summer_fee'] = [
                'value' => (float)$to_be_saved['accommodation_summer_fee'],
                'converted_value' => $calculator_values['values'][12]
            ];
            $mail_pdf_data['accommodation_christmas_fee'] = [
                'value' => (float)$to_be_saved['accommodation_christmas_fee'],
                'converted_value' => $calculator_values['values'][13]
            ];
            $mail_pdf_data['accommodation_under_age_fee'] = [
                'value' => (float)$to_be_saved['accommodation_under_age_fee'],
                'converted_value' => $calculator_values['values'][14]
            ];
            $mail_pdf_data['accommodation_peak_fee'] = [
                'value' => (float)$to_be_saved['accommodation_peak_fee'],
                'converted_value' => $calculator_values['values'][15]
            ];
            $mail_pdf_data['accommodation_discount_fee'] = [
                'value' => (float)$to_be_saved['accommodation_discount_fee'],
                'converted_value' => $calculator_values['values'][16]
            ];
            // $mail_pdf_data['accommodation_total'] = [
            //     'value' => (float)$to_be_saved['accommodation_total'],
            //     'converted_value' => $calculator_values['values'][19]
            // ];
            $mail_pdf_data['airport_pickup_fee'] = [
                'value' => (float)$to_be_saved['airport_pickup_fee'],
                'converted_value' => $calculator_values['values'][17]
            ];
            $mail_pdf_data['medical_insurance_fee'] = [
                'value' => (float)$to_be_saved['medical_insurance_fee'],
                'converted_value' => $calculator_values['values'][18]
            ];
            $mail_pdf_data['custodian_fee'] = [
                'value' => (float)$to_be_saved['custodian_fee'],
                'converted_value' => $calculator_values['values'][19]
            ];
            $mail_pdf_data['total_discount'] = [
                'value' => (float)$to_be_saved['total_discount'],
                'converted_value' => $calculator_values['values'][20]
            ];
            $mail_pdf_data['sub_total'] = [
                'value' => (float)$to_be_saved['sub_total'],
                'converted_value' => $calculator_values['values'][21]
            ];
            $mail_pdf_data['total_cost'] = [
                'value' => (float)$to_be_saved['total_cost'],
                'converted_value' => $calculator_values['values'][22]
            ];
            $mail_pdf_data['deposit_price'] = [
                'value' => (float)$to_be_saved['deposit_price'],
                'converted_value' => $calculator_values['values'][23]
            ];
            $mail_pdf_data['total_balance'] = [
                'value' => (float)$to_be_saved['total_balance'],
                'converted_value' => $calculator_values['values'][24]
            ];
            $mail_pdf_data['currency'] = [
                'cost' => $calculator_values['currency'],
                'converted' => $default_currency['currency'],
            ];
            $mail_pdf_data['user'] = User::find(auth()->id());
            $mail_pdf_data['locale'] = app()->getLocale();

            if (isset($course_reservation_details->deposit_price)) {
                $user_created = UserCourseBookedDetails::updateOrCreate($to_be_saved, $to_be_saved + ['user_id' => auth()->id(), 'status' => 'received']);
                $calc = Calculator::where('calc_id', request()->ip())->latest()->first();
                $savefees = $calc->replicate()->setTable('user_course_booked_fees');
                $savefees->user_course_booked_details_id = $user_created->id;
                $savefees->save();

                event(new UserCourseBookedStatus($user_created));

                $user_created_data = (object) $mail_pdf_data;
                $user_created_data->id = $user_created->id;
                $user_created_data->registration_date = \Carbon\Carbon::now()->format('Y-m-d');
                \Mail::to(auth()->user()->email)->send(new CourseBooked($user_created_data));
            } else {
                $user_created = UserCourseBookedDetails::updateOrCreate($to_be_saved, $to_be_saved + ['user_id' => auth()->id(), 'paid' => 1, 'status' => 'received']);
                $calc = Calculator::where('calc_id', request()->ip())->latest()->first();
                $savefees = $calc->replicate()->setTable('user_course_booked_fees');
                $savefees->user_course_booked_details_id = $user_created->id;
                $savefees->save();

                toastr()->success(__('Frontend.user_course_booked'));

                event(new UserCourseBookedStatus($user_created));

                $user_created_data = (object) $mail_pdf_data;
                $user_created_data->id = $user_created->id;
                $user_created_data->registration_date = \Carbon\Carbon::now()->format('Y-m-d');
                \Mail::to(auth()->user()->email)->send(new CourseBooked($user_created_data));

                $data['url'] = route('land_page');

                $data['success'] = true;
                $data['data'] = 'Success';

                return response($data);
            }

            $telrManager = new \TelrGateway\TelrManager();

            $billingParams = [
                'first_name' => $user_created->fname,
                'sur_name' => '',
                'address_1' => $user_created->address,
                'address_2' => '',
                'city' => $request->city_contact,
                'region' => auth()->user()->state,
                'zip' => auth()->user()->zip,
                'country' => $request->country,
                'email' => $request->email,
            ];
            if ($user_created) {
                $data['data'] = 'Success';
                $data['success'] = true;
            }

            $url = $telrManager->pay(time() . rand(00, 99), $mail_pdf_data['total_balance']['converted_value'], 'Program Registration Fee', $billingParams)->redirect();
            $data['url'] = $url->getTargetUrl();
        //} catch(\Exception $e) {
        //    $data['errors'] = 'Something Went Wrong Check Log File';
        //    $data['success'] = false;
        //    return response()->json($data);
        //}

        return response()->json($data);
    }

    public function downloadFile(Request $request)
    {
        return response()->download(storage_path('app/public/' . $request->file));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function TelrResponse()
    {
        if (\Session::has('visa_form')) {
            return $this->VisaTelrResponse();
        }

        $telrManager = new \TelrGateway\TelrManager();
        $telr = $telrManager->handleTransactionResponse(request());
        $cart_id = $_GET['cart_id'];

        $telr->status == 1 ? toastr()->success(__('Frontend.user_course_booked')) : toastr()->error(__('Frontend.payment.failed'));

        auth()->user()->updateUserCourseBookedDetails()->update(['paid' => 1, 'order_id' => $cart_id]);

        return redirect()->route('land_page');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function VisaTelrResponse()
    {
        $telrManager = new \TelrGateway\TelrManager();
        $telr = $telrManager->handleTransactionResponse(request());
        $cart_id = $_GET['cart_id'];

        $save_visa = AppliedForVisa::find(\Session::get('applied_form_id'));
        $save_visa->payment_status = 1;
        $save_visa->order_id = $cart_id;
        $save_visa->paid_amount = Session::get('paid_amount');
        $save_visa->save();

        $telr->status == 1 ? toastr()->success(__('Frontend.payment.success')) : toastr()->error(__('Frontend.payment.failed'));
        Session::forget(['visa_form', 'applied_form_id', 'paid_amount']);

        return redirect(route('land_page'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function TelrResponseFailed()
    {
        $cart_id = $_GET['cart_id'];
        auth()->user()->updateUserCourseBookedDetails()->update(['paid' => 2, 'order_id' => $cart_id]);
        toastr()->error(__('Frontend.payment.failed'));

        return redirect()->route('land_page');
    }

    public function getAgeList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language) {
            $age_range_ids = [];
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language)) {
                    foreach ($course_programs as $course_program) {
                        $age_range_ids = array_merge($age_range_ids, $course_program->program_age_range);
                    }
                }
            }
            $age_range_ids = array_unique($age_range_ids);
            
            $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', $age_range_ids)->orderBy('age', 'asc')->get();
            foreach ($program_age_ranges as $program_age_range) {
                $result .= "<option value='$program_age_range->unique_id'>$program_age_range->age</option>";
            }
        }

        return $result;
    }

    public function getCountryList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language && $request->age) {
            $country_ids = [];
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_has_age_range = false;
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language)) {
                    foreach ($course_programs as $course_program) {
                        if (in_array($request->age, $course_program->program_age_range)) {
                            $course_has_age_range = true;
                        }
                    }
                }
                if ($course_has_age_range) {
                    $country_ids[] = $course->country_id;
                }
            }
            $country_ids = array_unique($country_ids);
            
            $countires = Country::whereIn('id', $country_ids)->orderBy('id', 'asc')->get();
            foreach ($countires as $county) {
                $result .= "<option value='$county->id'>" . (app()->getLocale() == 'en' ? $county->name : $county->name_ar) . "</option>";
            }
        }

        return $result;
    }

    public function getProgramTypeList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language && $request->age && $request->country) {
            $program_type_ids = [];
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_has_age_range = false;
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language) && $request->country == $course->country_id) {
                    foreach ($course_programs as $course_program) {
                        if (in_array($request->age, $course_program->program_age_range)) {
                            $course_has_age_range = true;
                        }
                    }
                }
                if ($course_has_age_range) {
                    $program_type_ids = array_merge($program_type_ids, $course->program_type);
                }
            }
            $program_type_ids = array_unique($program_type_ids);
            
            $program_types = Choose_Program_Type::whereIn('unique_id', $program_type_ids)->get();
            foreach ($program_types as $program_type) {
                $result .= "<option value='$program_type->unique_id'>$program_type->name</option>";
            }
        }

        return $result;
    }

    public function getStudyModeList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language && $request->age && $request->country && $request->program_type) {
            $study_mode_ids = [];
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_has_age_range = false;
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language) && $request->country == $course->country_id && in_array($request->program_type, $course->program_type)) {
                    foreach ($course_programs as $course_program) {
                        if (in_array($request->age, $course_program->program_age_range)) {
                            $course_has_age_range = true;
                        }
                    }
                }
                if ($course_has_age_range) {
                    $study_mode_ids = array_merge($study_mode_ids, $course->study_mode);
                }
            }
            $study_mode_ids = array_unique($study_mode_ids);
            
            $study_modes = Choose_Study_Mode::whereIn('unique_id', $study_mode_ids)->get();
            foreach ($study_modes as $study_mode) {
                $result .= "<option value='$study_mode->unique_id'>$study_mode->name</option>";
            }
        }

        return $result;
    }

    public function getCityList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language && $request->age && $request->country && $request->program_type && $request->study_mode) {
            $city_ids = [];
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_has_age_range = false;
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language) && $request->country == $course->country_id && in_array($request->program_type, $course->program_type)
                    && in_array($request->study_mode, $course->study_mode)) {
                    foreach ($course_programs as $course_program) {
                        if (in_array($request->age, $course_program->program_age_range)) {
                            $course_has_age_range = true;
                        }
                    }
                }
                if ($course_has_age_range) {
                    $city_ids[] = $course->city_id;
                }
            }
            $city_ids = array_unique($city_ids);
            
            $cities = City::whereIn('id', $city_ids)->get();
            foreach ($cities as $city) {
                $result .= "<option value='$city->id'>" . (app()->getLocale() == 'en' ? $city->name : $city->name_ar) . "</option>";
            }
        }

        return $result;
    }

    public function getProgramNameList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language && $request->age && $request->country && $request->program_type && $request->study_mode && $request->city) {
            $program_names = [];
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_has_age_range = false;
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language) && $request->country == $course->country_id && in_array($request->program_type, $course->program_type)
                    && in_array($request->study_mode, $course->study_mode) && $request->city == $course->city_id) {
                    foreach ($course_programs as $course_program) {
                        if (in_array($request->age, $course_program->program_age_range)) {
                            $course_has_age_range = true;
                        }
                    }
                }
                if ($course_has_age_range) {
                    $program_names[] = app()->getLocale() == 'en' ? $course->program_name : $course->program_name_ar;
                }
            }
            $program_names = array_unique($program_names);
            
            foreach ($program_names as $program_name) {
                $result .= "<option value='$program_name'>$program_name</option>";
            }
        }

        return $result;
    }

    public function getProgramDurationList(Request $request) {
        $result = '<option value="">' . __('Frontend.please_choose') . '</option>';
        if ($request->language && $request->age && $request->country && $request->program_type && $request->study_mode && $request->city && $request->program_name) {
            $program_duration_start = 0; $program_duration_end = 0;
            $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
            foreach ($courses as $course) {
                $course_programs = $course->coursePrograms;
                if (in_array($request->language, $course->language) && $request->country == $course->country_id && in_array($request->program_type, $course->program_type)
                    && in_array($request->study_mode, $course->study_mode) && $request->city == $course->city_id
                    && ((app()->getLocale() == 'en' && $request->program_name == $course->program_name) || (app()->getLocale() != 'en' && $request->program_name == $course->program_name_ar))) {
                    foreach ($course_programs as $course_program) {
                        if (in_array($request->age, $course_program->program_age_range)) {
                            if (!$program_duration_start) $program_duration_start = (int)$course_program->program_duration_start;
                            if ($program_duration_start > $course_program->program_duration_start) $program_duration_start = (int)$course_program->program_duration_start;
                            if (!$program_duration_end) $program_duration_end = (int)$course_program->program_duration_end;
                            if ($program_duration_end < $course_program->program_duration_end) $program_duration_end = (int)$course_program->program_duration_end;
                        }
                    }
                }
            }
            
            for ($program_duration = $program_duration_start; $program_duration <= $program_duration_end; $program_duration++) {
                $result .= "<option value='$program_duration'>$program_duration</option>";
            }
        }

        return $result;
    }

    private function searchCourseList($condition) {
        $result_courses = [];

        $courses = Course::with('coursePrograms')->where('display', true)->where('deleted', false)->get();
        foreach ($courses as $course) {
            $course_satisfied = true;
            $course_programs = $course->coursePrograms;
            if (isset($condition->language) && $condition->language) {
                if (!in_array($condition->language, $course->language)) {
                    $course_satisfied = false;
                }
            }
            if (isset($condition->age) && $condition->age) {
                $course_program_satisified = false;
                foreach ($course_programs as $course_program) {
                    if (in_array($condition->age, $course_program->program_age_range)) {
                        $course_program_satisified = true;
                    }
                }
                if (!$course_program_satisified) {
                    $course_satisfied = false;
                }
            }
            if (isset($condition->country) && $condition->country) {
                if ($condition->country != $course->country_id) {
                    $course_satisfied = false;
                }
            }
            if (isset($condition->program_type) && $condition->program_type) {
                if (!in_array($condition->program_type, $course->program_type)) {
                    $course_satisfied = false;
                }
            }
            if (isset($condition->study_mode) && $condition->study_mode) {
                if (!in_array($condition->study_mode, $course->study_mode)) {
                    $course_satisfied = false;
                }
            }
            if (isset($condition->start_date) && $condition->start_date) {
                $course_program_satisified = false;
                foreach ($course_programs as $course_program) {
                    if ($course_program->program_start_date <= $condition->start_date && $course_program->program_end_date >= $condition->start_date) {
                        $course_program_satisified = true;
                    }
                }
                if (!$course_program_satisified) {
                    $course_satisfied = false;
                }
            }
            if (isset($condition->advanced) && $condition->advanced == 'expanded') {
                if (isset($condition->city) && $condition->city) {
                    if ($condition->city != $course->city_id) {
                        $course_satisfied = false;
                    }
                }
                if (isset($condition->program_name) && $condition->program_name) {
                    if (app()->getLocale() == 'en') {
                        if ($condition->program_name == $course->program_name) {
                            $course_satisfied = false;
                        }
                    } else {
                        if ($condition->program_name == $course->program_name_ar) {
                            $course_satisfied = false;
                        }
                    }
                }
                if (isset($condition->program_duration) && $condition->program_duration) {
                    $course_program_satisified = false;
                    foreach ($course_programs as $course_program) {
                        if ($course_program->program_duration_start <= $condition->program_duration && $course_program->program_duration_end >= $condition->program_duration) {
                            $course_program_satisified = true;
                        }
                    }
                    if (!$course_program_satisified) {
                        $course_satisfied = false;
                    }
                }
            }

            if ($course_satisfied) {
                $result_course = $course;
                foreach ($course_programs as $course_program) {
                    $course_program_satisified = true;
                    if (isset($condition->age) && $condition->age) {
                        if (!in_array($condition->age, $course_program->program_age_range)) {
                            $course_program_satisified = false;
                        }
                    }
                    if (isset($condition->start_date) && $condition->start_date) {
                        if ($course_program->program_start_date <= $condition->start_date && $course_program->program_end_date >= $condition->start_date) {
                            $course_program_satisified = false;
                        }
                    }
                    if (isset($condition->program_duration) && $condition->program_duration) {
                        if ($course_program->program_duration_start <= $condition->program_duration && $course_program->program_duration_end >= $condition->program_duration) {
                            $course_program_satisified = false;
                        }
                    }
                    if ($course_program_satisified) {
                        $result_course->course_program = $course_program;
                        $result_course->age_range = getCourseProgramAgeRange($course_program->program_age_range);
                        break;
                    }
                }

                $result_courses[] = $course;
            }
        }

        return $result_courses;
    }

    public function searchCourse(Request $request) {
        $rules = [
            'language' => 'sometimes',
            'age' => 'sometimes',
            'country' => 'sometimes',
            'program_type' => 'sometimes',
            'study_mode' => 'sometimes',
            'start_date' => 'sometimes',
            'advanced' => 'sometimes',
            'city' => 'sometimes',
            'program_name' => 'sometimes',
            'program_duration' => 'sometimes',
        ];
        $validate = Validator::make($request->all(), $rules);

        $data['success'] = false;
        if ($validate->fails()) {
            $data['errors'] = $validate->errors();
            return response($data);
        }
        
        \Session::put('course_search', (object)$request->except('_token'));

        $now = Carbon::now()->format('Y-m-d');

        $data['success'] = true;
        $data['courses'] = $courses = $this->searchCourseList($request->all());
        $data['courses_html'] = view('frontend.layouts.course-list', compact('courses', 'now'))->render();
        return response()->json($data);
    }

    public function viewCourse() {
        $now = Carbon::now()->format('Y-m-d');

        $course_language_ids = [];
        $courses = Course::with('coursePrograms', 'userCourseBookedDetails.review')->where('display', true)->where('deleted', false)->get();
        foreach ($courses as $course) {
            $course_language_ids = array_merge($course_language_ids, $course->language ?? []);
        }
        $languages = Choose_Language::whereIn('unique_id', $course_language_ids)->orderBy('name', 'asc')->get();

        $course_search = (object)\Session::get('course_search');
        $courses = $this->searchCourseList($course_search);

        $school_cities = [];
        $school_names = [];
        foreach ($courses as $course) {
            if (app()->getLocale() == 'en') {
                if (!$course->school->city) {
                    if (!in_array('-', $school_cities)) {
                        array_push($school_cities, '-');
                    }
                } else {
                    if (!in_array($course->school->city->name, $school_cities)) {
                        array_push($school_cities, $course->school->city->name);
                    }
                }
                if (!$course->school->name) {
                    if (!in_array('-', $school_names)) {
                        array_push($school_names, '-');
                    }
                } else {
                    if (!in_array($course->school->name->name, $school_names)) {
                        array_push($school_names, $course->school->name->name);
                    }
                }
            } else {
                if (!$course->school->city) {
                    if (!in_array('-', $school_cities)) {
                        array_push($school_cities, '-');
                    }
                } else {
                    if (!in_array($course->school->city->name_ar, $school_cities)) {
                        array_push($school_cities, $course->school->city->name_ar);
                    }
                }
                if (!$course->school->name) {
                    if (!in_array('-', $school_names)) {
                        array_push($school_names, '-');
                    }
                } else {
                    if (!in_array($course->school->name->name_ar, $school_names)) {
                        array_push($school_names, $course->school->name->name_ar);
                    }
                }
            }
        }

        return view('frontend.course.list', compact('course_search', 'courses', 'languages', 'school_cities', 'school_names', 'now'));
    }
}