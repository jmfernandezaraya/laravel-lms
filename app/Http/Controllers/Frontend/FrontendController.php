<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\FrontendCalculator;
use App\Classes\SendCourseNotificationToStudent;
use App\Classes\AccommodationCalculator;

use App\Events\UserCourseBookedStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnquiryRequest;

use App\Mail\EnquiryMail;

use App\Models\Calculator;
use App\Models\UserCourseBookedDetails;

use App\Models\Frontend\AppliedForVisa;
use App\Models\Frontend\Enquiry;

use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseProgramTextBookFee;
use App\Models\SuperAdmin\CourseProgramUnderAgeFee;
use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Under_Age;
use App\Models\SuperAdmin\Choose_Study_Mode;
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
        $schools = School::all();
        $study_modes = Choose_Study_Mode::all();

        return view('frontend.index', compact('schools', 'study_modes'));
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
        $school = School::where('id', $id)->firstOrFail();
        $school_courses = $school->availableCourses()->get();
        $study_mode_ids = [];
        foreach ($school_courses as $school_course) {
            $study_mode_ids = array_merge($study_mode_ids, $school_course->study_mode);
        }
        $study_modes = Choose_Study_Mode::whereIn('unique_id', $study_mode_ids)->get();

        $school->viewed_count += 1;
        $school->save();

        return view('frontend.school.details', ['id' => $id], compact('school', 'study_modes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function paymentPost(Request $request)
    {
        Session::forget('accom_unique_id');
        Session::forget('airport_id');
        Session::forget('medical_id');

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

        try{
            $to_be_saved = $validate->validated();
            $to_be_saved['course_id'] = $request->program_id ?? 0;
            $to_be_saved['start_date'] = $request->date_selected ?? 0;
            $to_be_saved['accommodation_id'] = $request->accommodation_id ?? 0;
            $to_be_saved['study_mode_selected'] = $request->study_mode;
            $to_be_saved['age_selected'] = $request->age_selected;
            $to_be_saved['accommodation_end_date'] = Carbon::create($request->accommodation_end_date)->format('Y-m-d') ?? null;
            $to_be_saved['accommodation_start_date'] = Carbon::create($request->accommodation_start_date)->format('Y-m-d') ?? null;
            $to_be_saved['accommodation_duration'] = $request->accommodation_duration ?? null;
            $to_be_saved['insurance_duration'] = $request->insurance_duration ?? null;
            $to_be_saved['program_duration'] = $request->program_duration ?? null;
            $course_airport = CourseAirport::where('course_unique_id', $request->program_id)->where('service_provider', $request->airport_provider)->first();
            $to_be_saved['airport_id'] = $course_airport ? $course_airport->unique_id : 0;
            $to_be_saved['airport_provider'] = $request->airport_provider ?? null;
            $to_be_saved['airport_name'] = $request->airport_name ?? null;
            $to_be_saved['airport_service_name'] = $request->airport_service ?? null;
            $course_medical = CourseMedical::where('course_unique_id', $request->program_id)->where('company_name', $request->company_name)->where('deductible', $request->deductible_up_to)->first();
            $to_be_saved['medical_id'] = $course_airport ? $course_airport->unique_id : 0;
            $to_be_saved['medical_company'] = $request->company_name ?? null;
            $to_be_saved['medical_deductible'] = $request->deductible_up_to ?? null;
            $to_be_saved['medical_duration'] = $request->duration ?? null;
            $to_be_saved['courier_fee'] = $request->courier_fee ?? 0;
            $to_be_saved['room_type'] = CourseAccommodation::where('unique_id', $request->room_type)->first()['room_type'] ?? null;
            $to_be_saved['meal_type'] = CourseAccommodation::where('unique_id', $request->meal_type)->first()['meal'] ?? null;
            $to_be_saved['total_fees'] = $request->total_fees;
            $to_be_saved['other_currency'] = $request->other_currency;
            $to_be_saved['legal_guardian_name'] = $request->legal_guardian_name;
            $to_be_saved['legal_id_number'] = $request->legal_id_number;
            $to_be_saved['course_program_id'] = $request->program_unique_id;

            unset($to_be_saved['passport_copy']);
            unset($to_be_saved['financial_guarantee']);
            if ($request->deposit_price != 0) {
                $user_created = UserCourseBookedDetails::updateOrCreate($to_be_saved, $to_be_saved + $save + ['user_id' => auth()->id(), 'status' => 'received', 'other' => $request->other ?? null]);
                $calc = Calculator::where('calc_id', request()->ip())->latest()->first();
                $savefees = $calc->replicate()->setTable('user_course_booked_fees');
                $savefees->user_course_booked_details_id = $user_created->id;
                $savefees->save();
                event(new UserCourseBookedStatus($user_created));
            } else {
                $user_created = UserCourseBookedDetails::updateOrCreate($to_be_saved, $to_be_saved + ['user_id' => auth()->id(), 'paid' => 1, 'status' => 'received'] + $save + ['other' => $request->other ?? null]);
                $calc = Calculator::where('calc_id', request()->ip())->latest()->first();
                $savefees = $calc->replicate()->setTable('user_course_booked_fees');
                $savefees->user_course_booked_details_id = $user_created->id;
                $savefees->save();

                toastr()->success(__('Frontend.payment.success'));

                event(new UserCourseBookedStatus($user_created));

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

            $url = $telrManager->pay(time() . rand(00, 99), $request->paid_amount, 'Program Registration Fee', $billingParams)->redirect();
            $data['url'] = $url->getTargetUrl();
        } catch(\Exception $e) {
            debugErrorsByJsonFile(['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 'apply.json');
            $data['errors'] = 'Something Went Wrong Check Log File';
            $data['success'] = false;
            return response()->json($data);
        }

        return response()->json($data);
    }

    /*
     * request helper is passed
     *
     * @return redirect land page
     *
     * */
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

        $telr->status == 1 ? toastr()->success(__('Frontend.payment.success')) : toastr()->error(__('Frontend.payment.failed'));

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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function saveDetails(Request $request)
    {
        $course_details = (object)\Session::get('course_details') ?? $request;

        $course = isset($course_details->program_id) ? Course::where('unique_id', '' . $course_details->program_id)->first() : '';
        $course_country = $course ? $course->country : '';

        $courses = Course::with('courseProgram')->where('school_id', $course_details->school_id)->where('deleted', false)->where('display', true)->get();
        $age_ranges = [];
        foreach ($courses as $course) {
            $age_ranges[] = $course->courseProgram ? $course->courseProgram->program_age_range : [];
        }
        $age_ranges = call_user_func_array('array_merge', $age_ranges);
        $min_age = ''; $max_age = '';
        $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
        if (!empty($program_age_ranges) && count($program_age_ranges)) {
            $min_age = $program_age_ranges[0];
            $max_age = $program_age_ranges[count($program_age_ranges) - 1];
        }

        return view('frontend.course.register', compact('course_details', 'course_country', 'min_age', 'max_age'));
    }

    public function backDetails(Request $request)
    {
        \Session::put('course_register_details', $request->all());
        
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
    public function registerDetail(Request $request)
    {
        $course_details = (object)\Session::get('course_details') ?? [];

        $course = isset($course_details->program_id) ? Course::where('unique_id', '' . $course_details->program_id)->first() : '';
        $course_country = $course ? $course->country : '';

        $courses = Course::with('courseProgram')->where('school_id', $course_details->school_id)->where('deleted', false)->where('display', true)->get();
        $age_ranges = [];
        foreach ($courses as $course) {
            $age_ranges[] = $course->courseProgram ? $course->courseProgram->program_age_range : [];
        }
        $age_ranges = call_user_func_array('array_merge', $age_ranges);
        $min_age = ''; $max_age = '';
        $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
        if (!empty($program_age_ranges) && count($program_age_ranges)) {
            $min_age = $program_age_ranges[0];
            $max_age = $program_age_ranges[count($program_age_ranges) - 1];
        }

        return view('frontend.course.register', compact('course_details', 'course_country', 'min_age', 'max_age'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $rules = [
            'fname' => 'required',
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

            'mobile' => 'required',
            //'telephone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'post_code' => 'required',
            'city_contact' => 'required',
            //'province_region' => 'required',
            'country_contact' => 'required',

            'full_name_emergency' => 'required',
            'relative_emergency' => 'required',
            'mobile_emergency' => 'required',
            //'telephone_emergency' => 'required',
            'email_emergency' => 'required',            

            'comments' => 'string',
        ];
        $validate = Validator::make($request->all(), $rules);

        $data['success'] = false;
        $age_check = $request->min_age <= Carbon::parse($request->dob)->age ? true : false;
        if (!$age_check) {
            $data['errors'][] = "Age Not Eligible";
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
            if ($request->has('passport_copy')) {
                $passport_image_name = time() . rand(00, 99) . "." . $request->file('passport_copy')->getClientOriginalExtension();
                $to_be_saved['passport_copy'] = 'public/images/user_booked_details/' . $passport_image_name;
                $request->passport_copy->move(public_path('images/user_booked_details'), $passport_image_name);
            }
            if ($request->has('financial_guarantee')) {
                $finance_image = time() . rand(00, 99) . "." . $request->file('financial_guarantee')->getClientOriginalExtension();
                $to_be_saved['financial_guarantee'] = 'public/images/user_booked_details/' . $finance_image;
                $request->financial_guarantee->move(public_path('images/user_booked_details'), $finance_image);
            }
            
            $data['success'] = true;
            \Session::put('course_register_details', $to_be_saved);
            $data['url'] = route('course.reservation.detail');
        } catch(\Exception $e) {
            debugErrorsByJsonFile(['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 'apply.json');
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
    public function reservationDetail(Request $request)
    {
        $course_details = (object)(\Session::get('course_details') ?? []);
        $course_register_details = (object)(\Session::get('course_register_details') ?? []);

        if (!isset($course_details->date_selected)) {
            return redirect()->route('land_page');
        }

        $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', [$course_details->age_selected])->pluck('age')->toArray();
        $program_under_age = Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');

        $data['program_start_date'] = $data['accommodation_start_date'] = $data['medical_start_date'] = Carbon::create($course_details->date_selected)->subDay()->format('d-m-Y');
        $data['program_end_date'] = programEndDateExcludingLastWeekend(Carbon::create($course_details->date_selected), $course_details->program_duration);
        $data['accommodation_end_date'] = Carbon::create($data['accommodation_start_date'])->addWeeks($course_details->accommodation_duration)->subDay()->format('d-m-Y');
        $data['medical_end_date'] = Carbon::create($data['medical_start_date'])->addWeeks($course_details->duration)->subDay()->format('d-m-Y');
        $data['school'] = School::find($course_details->school_id);
        $data['course'] = isset($course_details->program_id) ? Course::where('unique_id', $course_details->program_id)->first() : '';
        $data['program'] = isset($course_details->program_unique_id) ? CourseProgram::where('unique_id', $course_details->program_unique_id)->first() : null;
        $data['program_text_book_fee'] = isset($course_details->program_unique_id) ? CourseProgramTextBookFee::where('course_program_id', $course_details->program_unique_id)->
            where('text_book_start_date', '<=', $course_details->program_unique_id)->where('text_book_end_date', '>=', $course_details->program_unique_id)->first() : '';
        $data['program_under_age_fee'] = isset($course_details->program_unique_id) ? CourseProgramUnderAgeFee::where('course_program_id', $course_details->program_unique_id)->
            where('under_age', 'LIKE', '%' . $program_under_age . '%')->first() : '';
        $data['accomodation'] = isset($course_details->accommodation_id) ? CourseAccommodation::whereUniqueId($course_details->accommodation_id)->first() : '';
        $data['airport'] = CourseAirport::where('course_unique_id', $request->program_id)->where('service_provider', $request->airport_provider)->first();
        $data['medical'] = CourseMedical::where('course_unique_id', $request->program_id)->where('company_name', $request->company_name)->where('deductible', $request->deductible_up_to)->first();
        
        $deposit_price = $program_registration_fee = $data['program']->program_registration_fee ?? 0;
        if ($data['program']->program_registration_fee) {
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

        $calculator = new AccommodationCalculator;
        $accommodation_fee = $calculator->getAccommodationFee();
        $accommodation_placement_fee = $calculator->getAccommodationPlacementFee();
        $accommodation_special_diet_fee = $calculator->getAccommodationSpecialDietFee();
        $accommodation_deposit_fee = $calculator->getAccommodationDeposit();
        $accommodation_summer_fee = $calculator->getAccommodationSummerFee();
        $accommodation_christmas_fee = $calculator->getAccommodationChristmasFee();
        $accommodation_under_age_fee = $calculator->getAccommodationUnderageFee();
        $accommodation_custodian_fee = $calculator->getAccommodationCustodianFee();
        $accommodation_peak_fee = $calculator->getAccommodationPeakFee();
        $accommodation_discount_fee = $calculator->resultAccommodationDiscount();
        $accommodation_total = $calculator->calculateOnlyAccommodationTotal() - $accommodation_discount_fee;

        $airport_pickup_fee = $calculator->getAirportPickupFee();
        $medical_insurance_fee = $calculator->getMedicalInsuranceFee();

        $total_discount = $program_discount_fee + $accommodation_discount_fee;
        $total_cost = $calculator->TotalCalculation();
        $sub_total = $total_cost - $total_discount;
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
                $accommodation_custodian_fee,
                $accommodation_peak_fee,
                $accommodation_discount_fee,
                $accommodation_total,
                $airport_pickup_fee,
                $medical_insurance_fee,
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
        $data['accommodation_custodian_fee'] = [
            'value' => (float)($accommodation_custodian_fee),
            'converted_value' => $calculator_values['values'][16]
        ];
        $data['accommodation_peak_fee'] = [
            'value' => (float)($accommodation_peak_fee),
            'converted_value' => $calculator_values['values'][17]
        ];
        $data['accommodation_discount_fee'] = [
            'value' => (float)($accommodation_discount_fee),
            'converted_value' => $calculator_values['values'][18]
        ];
        $data['accommodation_total'] = [
            'value' => (float)($accommodation_total),
            'converted_value' => $calculator_values['values'][19]
        ];
        $data['airport_pickup_fee'] = [
            'value' => (float)$airport_pickup_fee,
            'converted_value' => $calculator_values['values'][20]
        ];
        $data['medical_insurance_fee'] = [
            'value' => (float)$medical_insurance_fee,
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
    public function confirmReservationDetail(Request $request)
    {
        $course_details = (object)(\Session::get('course_details') ?? []);
        $course_register_details = (object)(\Session::get('course_register_details') ?? []);

        if (!isset($course_details->date_selected)) {
            return redirect()->route('land_page');
        }

        $today = Carbon::now()->format('d-m-Y');
        $school = School::find($course_details->school_id);

        return view('frontend.course.reservation-confirm', compact('today', 'school', 'course_details', 'course_register_details'));
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

        if (!isset($course_details->date_selected)) {
            return redirect()->route('land_page');
        }
    }

    /*
     * Capture Telr response here
     *
     * */

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
}