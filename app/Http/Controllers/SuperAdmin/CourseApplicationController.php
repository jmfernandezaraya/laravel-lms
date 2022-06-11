<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\TransactionCalculator;
use App\Events\UserCourseBookedStatus;
use App\Http\Controllers\Controller;
use App\Mail\SendMessageToSchoolFromSuperAdmin;
use App\Mail\UpdatedUserCourseBooked;
use App\Services\SuperAdminEditUserCourse;

use App\Models\Calculator;
use App\Models\UserCourseBookedDetails;
use App\Models\SchoolAdmin\ReplyToSendSchoolMessage;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\SendMessageToStudentCourse;
use App\Models\SuperAdmin\SendSchoolMessage;
use App\Models\SuperAdmin\TransactionRefund;
use App\Models\SuperAdmin\UserCourseBookedDetailsApproved;

use PDF;
use Storage;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TelrGateway\Transaction;

/**
 * Class CourseApplicationController
 * @package App\Http\Controllers\SuperAdmin
 */
class CourseApplicationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['booked_details'] = UserCourseBookedDetails::with('User', 'course', 'userBookDetailsApproved')->get();

        return view('superadmin.course_application.index', $data);
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
            } elseif ($request->type_of_submit == 'send_message_to_student') {
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
                if ($request->order_id) {
                    $txn = Transaction::where('cart_id', $request->order_id)->first();
                    $txnrefund = new TransactionRefund;
                    $request->symbol == '+' ? $txnrefund->amount_added = $request->amount : $txnrefund->amount_refunded = $request->amount;
                    $txnrefund->transaction_id = $txn->order_id;
                    $txnrefund->txn_reference = $request->reference;
                    $txnrefund->details = $request->course_details;
                    $txnrefund->save();
                }

                $success = __('SuperAdmin/backend.data_updated');
            }
        } catch (\Exception $e) {
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
        $data = getCourseApplicationPrintData($id);
        $test = '';

        return view('superadmin.course_application.edit', $data, compact('test'));
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

    public function print(Request $request)
    {
        $rules = [
            'id' => 'required',
            'section' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);
        
        $data['success'] = true;
        if ($validate->fails()) {
            $data['success'] = false;
            $data['errors'] = $validate->errors();
            return response($data);
        } else {
            $pdf_data = getCourseApplicationPrintData($request->id);
            $pdf_data['logo'] = asset('public/frontend/assets/img/logo.png');
            
            if ($request->section == 'reservation') {
                $pdf = PDF::loadView('pdf.course_application.reservation', $pdf_data);
                Storage::disk('public')->put('pdf/course_application/reservation_' . $request->id . '.pdf', $pdf->output());
                $pdf_file = storage_path('app/public/pdf/course_application/reservation_' . $request->id  . '.pdf');
            } else if ($request->section == 'registration') {
                $pdf = PDF::loadView('pdf.course_application.registration', $pdf_data);
                Storage::disk('public')->put('pdf/course_application/registration_' . $request->id . '.pdf', $pdf->output());
                $pdf_file = storage_path('app/public/pdf/course_application/registration_' . $request->id  . '.pdf');
            } else if ($request->section == 'registration_cancellation') {
                $pdf = PDF::loadView('pdf.course_application.registration_cancellation', $pdf_data);
                Storage::disk('public')->put('pdf/course_application/registration_cancellation_' . $request->id . '.pdf', $pdf->output());
                $pdf_file = storage_path('app/public/pdf/course_application/registration_cancellation_' . $request->id  . '.pdf');
            } else if ($request->section == 'payments_refunds') {
                $pdf = PDF::loadView('pdf.course_application.payments_refunds', $pdf_data);
                Storage::disk('public')->put('pdf/course_application/payments_refunds_' . $request->id . '.pdf', $pdf->output());
                $pdf_file = storage_path('app/public/pdf/course_application/payments_refunds_' . $request->id  . '.pdf');
            }
        }

        return response()->download($pdf_file);
    }

    public function listForCustomer($customer_id) {
        $data['booked_details'] = UserCourseBookedDetails::with('User', 'course', 'userBookDetailsApproved')->where('user_id', $customer_id)->get();

        return view('superadmin.course_application.index', $data);
    }
}