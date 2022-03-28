<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\FrontendCalculator;
use App\Classes\SendCourseNotificationToStudent;

use App\Events\UserCourseBookedStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnquiryRequest;

use App\Mail\EnquiryMail;

use App\Models\Calculator;
use App\Models\Frontend\AppliedForVisa;
use App\Models\Frontend\Enquiry;
use App\Models\SuperAdmin\Accommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\UserCourseBookedDetails;

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
        //return __('Frontend.message_sent_thank_you');
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

        $rules = [
            'fname' => 'required',
            'lname' => 'required',

            'dob' => 'required',
            'place_of_birth' => 'required',
            'country' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'passport_number' => 'required',

            'passport_date_of_issue' => 'required',
            'passport_date_of_expiry' => 'required',
            'passport_copy' => 'required|mimes:jpg,bmp,png,jpeg,pdf',
            'study_finance' => 'required',
            'financial_guarantee' => 'required_if:study_finance,scholarship|mimes:jpg,bmp,png,jpeg,pdf',
            'id_number' => 'required',
            'level_of_language' => 'required',
            'bank_statement' => 'required_if:country_get,1|mimes:jpg,bmp,png,jpeg,pdf',
            'mobile' => 'required',

            'email' => 'required',
            'address' => 'required',
            'post_code' => 'required',
            'city_contact' => 'required',
            'country_contact' => 'required',
            'full_name_emergency' => 'required',
            'relative_emergency' => 'required',
            'mobile_emergency' => 'required',
            'telephone_emergency' => 'required',
            'email_emergency' => 'required',
            'heard_where' => 'required',

            'comments' => 'string',
            'paid_amount' => 'required',
            'signature' => 'required',
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

        try{
            $to_be_saved = $validate->validated();
            $to_be_saved['course_id'] = $request->program_id ?? 0;
            $to_be_saved['start_date'] = $request->date_selected ?? 0;
            $to_be_saved['airport_id'] = $request->airport_id ?? 0;
            $to_be_saved['accommodation_id'] = $request->accommodation_id ?? 0;
            $to_be_saved['study_mode_selected'] = $request->study_mode;
            $to_be_saved['age_selected'] = $request->age_selected;
            $to_be_saved['accommodation_end_date'] = Carbon::create($request->accommodation_end_date)->format('Y-m-d') ?? null;
            $to_be_saved['accommodation_start_date'] = Carbon::create($request->accommodation_start_date)->format('Y-m-d') ?? null;
            $to_be_saved['accommodation_duration'] = $request->accommodation_duration ?? null;
            $to_be_saved['insurance_duration'] = $request->insurance_duration ?? null;
            $to_be_saved['program_duration'] = $request->program_duration ?? null;
            $to_be_saved['airport_name'] = CourseAirport::where('unique_id', $request->airport_id)->first()['name_en'] ?? null;
            $to_be_saved['airport_service_name'] = CourseAirport::where('unique_id', $request->airport_service)->first()['service_name_en'] ?? null;
            $to_be_saved['courier_fee'] = $request->courier_fee ?? 0;
            $to_be_saved['room_type'] = Accommodation::where('unique_id', $request->room_type)->first()['room_type'] ?? null;
            $to_be_saved['meal_type'] = Accommodation::where('unique_id', $request->meal_type)->first()['meal'] ?? null;
            $to_be_saved['total_fees'] = $request->total_fees;
            $to_be_saved['other_currency'] = $request->other_currency;
            $to_be_saved['legal_guardian_name'] = $request->legal_guardian_name;
            $to_be_saved['legal_id_number'] = $request->legal_id_number;
            $to_be_saved['course_program_id'] = $request->program_unique_id;

            unset($to_be_saved['passport_copy']);
            unset($to_be_saved['financial_guarantee']);
            unset($to_be_saved['bank_statement']);
            if ($request->has('terms_and_conditions') && $request->has('terms')) {
                if ($request->has('passport_copy')) {
                    $passport_image_name = time() . rand(00, 99) . "." . $request->file('passport_copy')->getClientOriginalExtension();
                    $save['passport_copy'] = 'public/images/user_booked_details/' . $passport_image_name;
                    $request->passport_copy->move(public_path('images/user_booked_details'), $passport_image_name);
                }

                if ($request->has('financial_guarantee')) {
                    $finance_image = time() . rand(00, 99) . "." . $request->file('financial_guarantee')->getClientOriginalExtension();

                    $save['financial_guarantee'] = 'public/images/user_booked_details/' . $finance_image;
                    $request->financial_guarantee->move(public_path('images/user_booked_details'), $finance_image);
                }

                if ($request->has('bank_statement')) {
                    $bank_image_name = time() . rand(00, 99) . "." . $request->file('bank_statement')->getClientOriginalExtension();
                    $save['bank_statement'] = 'public/images/user_booked_details/' . $bank_image_name;
                    $request->bank_statement->move(public_path('images/user_booked_details'), $bank_image_name);
                }

                if ($request->paid_amount != 0) {
                    $user_created = UserCourseBookedDetails::updateOrCreate($to_be_saved,$to_be_saved + $save + ['user_id' => auth()->id(), 'status' => 'received', 'other' => $request->other ?? null]);
                    $calc = Calculator::where('calc_id', request()->ip())->latest()->first();
                    $savefees = $calc->replicate()->setTable('user_course_booked_fees');
                    $savefees->user_course_booked_details_id = $user_created->id;
                    $savefees->save();
                    event(new UserCourseBookedStatus($user_created));
                } else {
                    $user_created = UserCourseBookedDetails::updateOrCreate($to_be_saved,$to_be_saved + ['user_id' => auth()->id(), 'paid' => 1, 'status' => 'received'] + $save + ['other' => $request->other ?? null]);
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
            } else {
                $data['errors'] = "Accept Terms and Condition First";
            }
            // $data['request'] = $request->all();

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
        if (session()->has('visa_form')) {
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

        $save_visa = AppliedForVisa::find(session()->get('applied_form_id'));
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
    public function reservationDetail(Request $request)
    {
        $requests = (object)session()->get('request') ?? $request;

        if (!isset($requests->date_selected)) {
            return redirect()->route('land_page');
        }

        $data['program_end_date'] = programEndDateExcludingLastWeekend(Carbon::create($requests->date_selected), $requests->program_duration);
        $data['accommodation_start_date'] = Carbon::create($requests->date_selected)->subDay()->format('d-m-Y');
        $data['accommodation_end_date'] = Carbon::create($data['accommodation_start_date'])->addWeeks($requests->accommodation_duration)->subDay()->format('d-m-Y');
        $data['request'] = !empty($request->all()) ? (object)$request->all() : (object)session()->get('request');
        $request = !empty($request->all()) ? (object)$request : (object)session()->get('request');
        $data['schools'] = School::find($request->school_id);
        $data['accomodation'] = isset($request->accommodation_id) ? Accommodation::whereUniqueId($request->accommodation_id)->first() : '';
        $data['course'] = isset($request->course_id) ? Course::with('medicalFee')->where('unique_id', $request->course_id)->first() : '';
        $data['airport'] = isset($request->airport_id) ? CourseAirport::whereUniqueId($request->airport_id)->first() : '';
        $data['program'] = isset($request->program_unique_id) ? CourseProgram::where('unique_id', $request->program_unique_id)->first() : null;

        if (isset($request->special_diet)) {
            $data['special_diet_fee'] = $request->special_diet == "on" ? Accommodation::whereMeal($request->meal_type)->whereUniqueId($request->accommodation_id)->whereRoomType($request->room_type)->first() : '';
        }

        $courses = Course::where('school_id', $request->school_id)->get();

        /* We Are Making weekdays available in date picker available in frontend */
        $age_range = [];
        foreach ($courses as $course) {
            $every_day[] = $course->every_day;
            $age_range[] = $course->courseProgram->program_age_range;
        }
        $age_range = call_user_func_array('array_merge', $age_range);

        $data['min_age'] = min($age_range);
        $data['max_age'] = max($age_range);

        if ($data['accomodation']) {
            $data['accom_min_age'] = is_array($data['accomodation']->age_range) ? min($data['accomodation']->age_range) : $data['accomodation']->age_range;
            $data['accom_max_age'] = is_array($data['accomodation']->age_range) ? max($data['accomodation']->age_range) : $data['accomodation']->age_range;
        } else {
            $data['accom_min_age'] = 0;
            $data['accom_max_age'] = 0;
        }

        $currency = (new FrontendCalculator())->CurrencyConverted($request->program_id, $request->total_fees);
        $data['currency_name'] = $currency['currency'];
        $data['currency_price'] = $currency['price'];

        $program_registration_fee = $data['program']->program_registration_fee ?? 0;
        if ($data['program']->program_registration_fee) {
            if ($data['program']->deposit) {
                $program_deposits = explode(" ", $data['program']->deposit);
                if (count($program_deposits) >= 2) {
                    if ($program_deposits[1] == '%') {
                        $program_registration_fee = $data['program']->program_cost * (int)$program_deposits[0] / 100;
                    } else {
                        $program_registration_fee = (int)$program_deposits[0];
                    }
                }
            }
        }
        $data['deposit_price'] = $program_registration_fee;
        $data['deposit'] = (new FrontendCalculator())->CurrencyConverted($request->program_id, $data['deposit_price']);

        $data['courier_price'] = readCalculationFromDB('courier_fee') == 0.00 ? 0 : (new FrontendCalculator())->CurrencyConverted($request->program_id, readCalculationFromDB('courier_fee'))['price'];

        return view('frontend.reservation-detail', $data, compact('request'));
    }

    /*
     * Capturin Telr response here
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