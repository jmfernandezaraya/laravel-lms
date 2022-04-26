<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\TransactionCalculator;
use App\Events\UserCourseBookedStatus;
use App\Http\Controllers\Controller;
use App\Mail\SendMessageToSchoolFromSuperAdmin;
use App\Mail\UpdatedUserCourseBooked;
use App\Services\SuperAdminEditUserCourse;

use App\Models\Calculator;
use App\Models\SchoolAdmin\ReplyToSendSchoolMessage;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\SendMessageToStudentCourse;
use App\Models\SuperAdmin\SendSchoolMessage;
use App\Models\SuperAdmin\TransactionRefund;
use App\Models\SuperAdmin\UserCourseBookedDetailsApproved;
use App\Models\UserCourseBookedDetails;


use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use TelrGateway\Transaction;

/**
 * Class ManageStudentController
 * @package App\Http\Controllers\SuperAdmin
 */
class ManageStudentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['booked_details'] = UserCourseBookedDetails::with('userBookDetailsApproved')->get();

        return view('superadmin.manage_student_application.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            $sendfile = '';
            if ($request->type_of_submit == 'send_message_to_school') {
                $rules = [
                    'attachment' => 'mimes:doc,docx,pdf,jpg,bmp,png',
                    'subject' => 'required',
                    'message' => 'required',
                    'to_email' => 'required',
                    'user_id' => 'required'
                ];
                $requestsave = $this->validate($request, $rules);

                if ($request->has("attachment")) {
                    $requestsave['attachment'] = $request->file('attachment')->getClientOriginalName();

                    $sendfile = $request->file('attachment')->move('public/attachments', $requestsave['attachment']);
                }

                unset($requestsave['to_email']);
                SendSchoolMessage::create($requestsave);

                \Mail::to($request->to_email)->send(new SendMessageToSchoolFromSuperAdmin($request, $sendfile));
                $success = __('Frontend.message_sent_thank_you');
            } elseif ($request->type_of_submit == 'update_reservation') {
                $event = UserCourseBookedDetails::whereId($request->id)->first();
                $event->status = $request->status;
                $event->save();

                event(new UserCourseBookedStatus($event));

                $success = __('SuperAdmin/backend.data_updated');
            }

            elseif ($request->type_of_submit == 'send_message_to_student') {
                $rules = [
                    'attachment.*' => 'mimes:doc,docx,pdf',
                    'subject' => 'required',
                    'message' => 'required',
                    'to_email' => 'required',
                    'user_id' => 'required'
                ];
                $this->validate($request, $rules);

                $requestsave = $request->only('attachment', 'subject', 'message', 'to_email', 'user_id');

                $attachmentarray = [];
                if ($request->has("attachment")) {
                    foreach ($request->file('attachment') as $attachments) {
                        $attach = $attachments->getClientOriginalName();
                        $attachmentarray[] = $attachments->getClientOriginalName();
                        $sendfile = $attachments->move('public/attachments', $attach);
                    }
                }
                $requestsave['attachment'] = $attachmentarray;
                unset($requestsave['to_email']);
                SendMessageToStudentCourse::create($requestsave);

                \Mail::to($request->to_email)->send(new SendMessageToSchoolFromSuperAdmin($request, $sendfile));

                $success = __('Frontend.message_sent_thank_you');
            } else {
                if ($request->amount == '-') {
                    $course = UserCourseBookedDetails::whereId($request->id)->first();
                    $course->status = 'refunded';
                    $course->save();
                    event(new UserCourseBookedStatus($course));
                }
                $txn = Transaction::where('cart_id', $request->order_id)->first();
                $txnrefund = new TransactionRefund;
                $request->symbol == '+' ? $txnrefund->amount_added = $request->amount : $txnrefund->amount_refunded = $request->amount;
                $txnrefund->transaction_id = $txn->order_id;
                $txnrefund->txn_reference = $request->reference;
                $txnrefund->details = $request->course_details;
                $txnrefund->save();

                $success = __('SuperAdmin/backend.data_updated');
            }
        }
        catch (\Exception $e) {
            $success = 'error';
            $data['message'] = $e->getMessage();

        }
        $data['success'] = $success;
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bookeddetails = UserCourseBookedDetails::with('course')->whereId($id)->firstOrFail();

        $userSchool = [];

        if ($bookeddetails->course->school->userSchool != null) {
            $userSchool = $bookeddetails->course->school->userSchool->user;
        }
        $chatMessage = [];
        if (!empty($userSchool)) {
            $chatMessage = ReplyToSendSchoolMessage::where('user_id', $userSchool->id)->get();
        }
        $studentMessage = SendMessageToStudentCourse::where('user_id', $bookeddetails->User->id)->get();
        $nation_option = ["Saudi Arabian", "Emirati", "Bahraini", "Kuwaiti", "Omani", "Qatari",
            "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Anguillan",
            "Argentine", "Armenian", "Australian", "Austrian", "Azerbaijani", "Bahamian",
            "Bangladeshi", "Barbadian", "Belarusian", "Belgian", "Belizean", "Beninese",
            "Bermudian", "Bhutanese", "Bolivian", "Botswanan", "Brazilian", "British",
            "British Virgin Islander", "Bruneian", "Bulgarian", "Burkinan", "Burmese",
            "Burundian", "Cambodian", "Cameroonian", "Canadian", "Cape Verdean",
            "Cayman Islander", "Central African", "Chadian", "Chilean", "Chinese",
            "Citizen of Antigua and Barbuda", "Citizen of Bosnia and Herzegovina",
            "Citizen of Guinea-Bissau", "Citizen of Kiribati", "Citizen of Seychelles",
            "Citizen of the Dominican Republic", "Citizen of Vanuatu", "Colombian", "Comoran",
            "Congolese (Congo)", "Congolese (DRC)", "Cook Islander", "Costa Rican", "Croatian",
            "Cuban", "Cymraes", "Cymro", "Cypriot", "Czech", "Danish", "Djiboutian", "Dominican",
            "Dutch", "East Timorese", "Ecuadorean", "Egyptian", "English", "Equatorial Guinean",
            "Eritrean", "Estonian", "Ethiopian", "Faroese", "Fijian", "Filipino", "Finnish",
            "French", "Gabonese", "Gambian", "Georgian", "German", "Ghanaian", "Gibraltarian",
            "Greek", "Greenlandic", "Grenadian", "Guamanian", "Guatemalan", "Guinean",
            "Guyanese", "Haitian", "Honduran", "Hong Konger", "Hungarian", "Icelandic",
            "Indian", "Indonesian", "Iranian", "Iraqi", "Irish", "Italian", "Ivorian",
            "Jamaican", "Japanese", "Jordanian", "Kazakh", "Kenyan", "Kittitian", "Kosovan",
            "Kyrgyz", "Lao", "Latvian", "Lebanese", "Liberian", "Libyan", "Liechtenstein citizen",
            "Lithuanian", "Luxembourger", "Macanese", "Macedonian", "Malagasy", "Malawian",
            "Malaysian", "Maldivian", "Malian", "Maltese", "Marshallese", "Martiniquais",
            "Mauritanian", "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monegasque",
            "Mongolian", "Montenegrin", "Montserratian", "Moroccan", "Mosotho", "Mozambican",
            "Namibian", "Nauruan", "Nepalese", "New Zealander", "Nicaraguan", "Nigerian",
            "Nigerien", "Niuean", "North Korean", "Northern Irish", "Norwegian", "Pakistani",
            "Palauan", "Palestinian", "Panamanian", "Papua New Guinean", "Paraguayan",
            "Peruvian", "Pitcairn Islander", "Polish", "Portuguese", "Prydeinig", "Puerto Rican",
            "Romanian", "Russian", "Rwandan", "Salvadorean", "Sammarinese", "Samoan",
            "Sao Tomean", "Scottish", "Senegalese", "Serbian", "Sierra Leonean", "Singaporean",
            "Slovak", "Slovenian", "Solomon Islander", "Somali", "South African", "South Korean",
            "South Sudanese", "Spanish", "Sri Lankan", "St Helenian", "St Lucian", "Stateless",
            "Sudanese", "Surinamese", "Swazi", "Swedish", "Swiss", "Syrian", "Taiwanese", "Tajik",
            "Tanzanian", "Thai", "Togolese", "Tongan", "Trinidadian", "Tristanian", "Tunisian",
            "Turkish", "Turkmen", "Turks and Caicos Islander", "Tuvaluan", "Ugandan", "Ukrainian",
            "Uruguayan", "Uzbek", "Vatican citizen", "Venezuelan", "Vietnamese", "Vincentian",
            "Wallisian", "Welsh", "Yemeni", "Zambian", "Zimbabwean"];

        sort($nation_option);
        $totalrefund = 0;
        $transaction_refund = [];

        if ($bookeddetails->transaction) {
            $transaction_refund = TransactionRefund::where('transaction_id', $bookeddetails->transaction->order_id)->get();
            foreach ($transaction_refund as $allrefund) {
                $totalrefund += $allrefund->amount_refunded;
            }
        }

        $amountdue = 0;
        if ($transaction = $bookeddetails->transaction) {
            $amountdue += $transaction->amount - $bookeddetails->totalfees;
        }
        $transaction_details = new TransactionCalculator($bookeddetails);

        return view('superadmin.manage_student_application.edit', compact('transaction_details', 'totalrefund', 'studentMessage', 'bookeddetails', 'nation_option', 'chatMessage', 'userSchool', 'transaction_refund', 'amountdue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userbooked = UserCourseBookedDetails::find($id);

        $userbooked->userBookDetailsApproveds()->updateOrCreate(['user_course_id' => $id], [
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'country' => $request->country,
            'gender' => $request->gender,
            'address' => $request->address,
            'post_code' => $request->post_code,
            'city_contact' => $request->city_contact,
            'country_contact' => $request->country_contact,
            'full_name_emergency' => $request->full_name_emergency,
            'relative_emergency' => $request->relative_emergency,
            'mobile_emergency' => $request->mobile_emergency,
            'telephone_emergency' => $request->telephone_emergency,
            'email_emergency' => $request->email_emergency,
            'heard_where' => $request->heard_where,
            'comments' => $request->comments,
        ]);

        return redirect()->route('superadmin.manage_application.index')->with(['success' => "Updated Successfully"]);
    }

    /**
     * @param $course_id
     * @param UserCourseBookedDetails $user_course_booked_id
     * @param $school_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editCourse($course_id, UserCourseBookedDetails $user_course_booked_id, $school_id)
    {
        \Session::put('program_unique_id', $user_course_booked_id->course_id);
        \Session::put('airport_id', $user_course_booked_id->airport_id);

        $data['course'] = $courses = Course::where('school_id', $school_id)->get();
        $data['course_update'] = Course::where('unique_id', $course_id)->firstOrFail();

        /*  
         * We Are Making weekdays available in date picker available in frontend
        */
        $every_day = [];
        $age_range = [];
        foreach ($courses as $course) {
            $every_day[] = $course->every_day;
            $age_range[] = isset($course->courseProgram->program_age_range) ? (array)$course->courseProgram->program_age_range : [];
        }

        $every_day = call_user_func_array('array_merge', $every_day);

        $every_day_search = $every_day;
        $dates = [0, 1, 2, 3, 4, 5, 6];
        if (in_array('sunday', array_map('strtolower', $every_day_search))) {
            $date1 = array_search(0, $dates);
            unset($dates[$date1]);
        }
        if (in_array('monday', array_map('strtolower', $every_day_search))) {
            $date2 = array_search(1, $dates);
            unset($dates[$date2]);
        }
        if (in_array('tuesday', array_map('strtolower', $every_day_search))) {
            $date3 = array_search(2, $dates);
            unset($dates[$date3]);
        }
        if (in_array('wednesday', array_map('strtolower', $every_day_search))) {
            $date4 = array_search(3, $dates);
            unset($dates[$date4]);
        }
        if (in_array('thursday', array_map('strtolower', $every_day_search))) {
            $date5 = array_search(4, $dates);
            unset($dates[$date5]);
        }
        if (in_array('friday', array_map('strtolower', $every_day_search))) {
            $date6 = array_search(5, $dates);
            unset($dates[$date6]);
        }
        if (in_array('saturday', array_map('strtolower', $every_day_search))) {
            $date6 = array_search(6, $dates);
            unset($dates[$date6]);
        }

        $data['enabled_days'] = implode(",", $dates);

        $schools = School::find($school_id);

        $ages = (call_user_func_array('array_merge', $age_range));
        sort($ages);
        $data['ages'] = array_unique($ages);

        return view('superadmin.single-course', $data, compact('user_course_booked_id', 'courses', 'schools'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateBookedUserCourse(Request $request)
    {
        $calculator = Calculator::where('calc_id', request()->ip())->latest()->first();

        $enddate = programEndDateExcludingLastWeekend(Carbon::create($request->date_selected), $request->program_duration);
        $accom_start_date = Carbon::create($request->date_selected)->subDay()->format('Y-m-d');
        $accom_end_date = Carbon::create($enddate)->addDay()->format('Y-m-d');

        $usercoursebook = UserCourseBookedDetails::find($request->id);
        $usercoursebook->course_program_id = $request->program_unique_id;
        $usercoursebook->start_date = $request->date_selected;
        $usercoursebook->age_selected = $request->age_selected;
        $usercoursebook->study_mode = $request->study_mode;
        $usercoursebook->accommodation_id = $request->accommodation_id ?? null;
        $usercoursebook->accommodation_start_date =  $usercoursebook->accomodation_id != null ? $accom_start_date : null;
        $usercoursebook->accommodation_end_date = $usercoursebook->accomodation_id != null ? $accom_end_date : null;
        $usercoursebook->airport_id = $request->airport_id ?? null;
        $usercoursebook->medical_duration = $request->medical_duration;
        $usercoursebook->accommodation_duration = $request->accommodation_duration ?? null;
        $usercoursebook->airport_service_name = CourseAirport::where('unique_id', $request->airport_service)->first()['service_name_en'] ?? null;
        $usercoursebook->airport_name = CourseAirport::where('unique_id', $request->airport_id)->first()['name_en'] ?? null;
        $usercoursebook->other_currency = $request->other_currency_to_save_to_db;
        $usercoursebook->courier_fee = $calculator->courier_fee;
        $usercoursebook->total_fees = $request->total_fees_to_save_to_db;
        $usercoursebook->save();

        $replicates = $calculator->replicate(['calc_id'])->toArray();
        $usercoursebook->userCourseFee->update($replicates);

        toastSuccess('Updated Successfully');

        \Mail::send(new UpdatedUserCourseBooked($usercoursebook->email));

        return redirect(route('superadmin.manage_application.index'));
    }
}