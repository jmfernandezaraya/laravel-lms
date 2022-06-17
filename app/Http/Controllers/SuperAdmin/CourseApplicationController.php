<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Classes\TransactionCalculator;
use App\Events\CourseApplicationStatus;
use App\Http\Controllers\Controller;

use App\Mail\SendMessageToSchoolAdmin;
use App\Mail\SendMessageToStudent;
use App\Mail\UpdatedCourseApplication;
use App\Services\SuperAdminEditUserCourse;

use App\Models\Calculator;
use App\Models\CourseApplication;
use App\Models\Message;

use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Start_Day;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseAirportFee;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseApplicationApprove;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\TransactionRefund;

use PDF;
use Storage;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
        $data['booked_details'] = CourseApplication::with('User', 'course', 'courseApplicationApprove')->get();

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
            $sendfiles = [];
            if ($request->type_of_submit == 'send_message_to_school') {
                $rules = [
                    'attachment[]' => 'mimes:doc,docx,pdf,jpg,bmp,png',
                    'subject' => 'required',
                    'message' => 'required',
                    'type' => 'required',
                    'type_id' => 'required',
                ];
                $validation = \Validator::make($request->all(), $rules, [
                    'attachment.*.required' => "Attachment needs to be doc,docx,pdf,jpg,bmp,png",
                    'subject.required' => "Subject required",
                    'message.required' => "Message required",
                    'type.required' => "Type required",
                    'type_id.required' => "Type ID required"
                ]);
                if ($validation->fails()) {
                    $success = 'error';
                    $data['message'] = $validation->errors();
                } else {
                    $requestsave = $request->only('subject', 'message', 'type', 'type_id');
                    $requestsave['attachments'] = [];
                    if ($request->has("attachment")) {
                        foreach ($request->file('attachment') as $attachment) {
                            $attachment_file = $attachment->getClientOriginalName();
                            $attachment_file_name = pathinfo($attachment_file, PATHINFO_FILENAME);
                            $attachment_file_ext = pathinfo($attachment_file, PATHINFO_EXTENSION);
                            $attachment_file = $attachment_file_name . '_' . time() . '.' . $attachment_file_ext;
                            $requestsave['attachments'][] = '/public/attachments/' . $attachment_file;
                            $sendfiles[] = $attachment->move('public/attachments', $attachment_file);
                        }
                    }

                    $course_application = CourseApplication::with('course.school.userSchools')->whereId($request->type_id)->first();
                    if ($course_application->course->school->userSchools) {
                        foreach ($course_application->course->school->userSchools as $user_school) {
                            $requestsave['from_user'] = auth()->user()->id;
                            $requestsave['to_user'] = $user_school->user_id;
                            Message::create($requestsave);
            
                            $mail_pdf_data = array();
                            $mail_pdf_data['subject'] = $requestsave['subject'];
                            $mail_pdf_data['message'] = $requestsave['message'];
                            $mail_pdf_data['user'] = \App\Models\User::find($requestsave['to_user']);
                            $mail_pdf_data['locale'] = app()->getLocale();
    
                            \Mail::to($request->to_email)->send(new SendMessageToSchoolAdmin((object)$mail_pdf_data, $sendfiles));
                        }
                    }
                    $success = __('SuperAdmin/backend.message_sent_thank_you');
                }
            } elseif ($request->type_of_submit == 'update_reservation') {
                $event = CourseApplication::whereId($request->id)->first();
                $event->status = $request->status;
                $event->save();

                event(new CourseApplicationStatus($event));

                $success = __('SuperAdmin/backend.data_updated');
            } elseif ($request->type_of_submit == 'send_message_to_student') {
                $rules = [
                    'attachment[]' => 'mimes:doc,docx,pdf,jpg,bmp,png',
                    'subject' => 'required',
                    'message' => 'required',
                    'type' => 'required',
                    'type_id' => 'required',
                ];
                $validation = \Validator::make($request->all(), $rules, [
                    'attachment.*.required' => "Attachment needs to be doc,docx,pdf,jpg,bmp,png",
                    'subject.required' => "Subject required",
                    'message.required' => "Message required",
                    'type.required' => "Type required",
                    'type_id.required' => "Type ID required"
                ]);
                if ($validation->fails()) {
                    $success = 'error';
                    $data['message'] = $validation->errors();
                } else {
                    $requestsave = $request->only('subject', 'message', 'type', 'type_id');
                    $requestsave['attachments'] = [];
                    if ($request->has("attachment")) {
                        foreach ($request->file('attachment') as $attachment) {
                            $attachment_file = $attachment->getClientOriginalName();
                            $attachment_file_name = pathinfo($attachment_file, PATHINFO_FILENAME);
                            $attachment_file_ext = pathinfo($attachment_file, PATHINFO_EXTENSION);
                            $attachment_file = $attachment_file_name . '_' . time() . '.' . $attachment_file_ext;
                            $requestsave['attachments'][] = '/public/attachments/' . $attachment_file;
                            $sendfiles[] = $attachment->move('public/attachments', $attachment_file);
                        }
                    }

                    $course_application = CourseApplication::whereId($request->type_id)->first();
                    $requestsave['from_user'] = auth()->user()->id;
                    $requestsave['to_user'] = $course_application->user_id;
                    Message::create($requestsave);
    
                    $mail_pdf_data = array();
                    $mail_pdf_data['subject'] = $requestsave['subject'];
                    $mail_pdf_data['message'] = $requestsave['message'];
                    $mail_pdf_data['user'] = \App\Models\User::find($requestsave['to_user']);
                    $mail_pdf_data['locale'] = app()->getLocale();

                    \Mail::to($request->to_email)->send(new SendMessageToStudent((object)$mail_pdf_data, $sendfiles));
    
                    $success = __('SuperAdmin/backend.message_sent_thank_you');
                }
            } else {
                if ($request->amount == '-') {
                    $course_application = CourseApplication::whereId($request->id)->first();
                    $course_application->status = 'refunded';
                    $course_application->save();
                    event(new CourseApplicationStatus($course_application));
                }
                $transaction_order_id = $request->order_id;
                if (!$transaction_order_id) {
                    $course_application = CourseApplication::whereId($request->id)->first();
                    $course_application->order_id = $transaction_order_id = generateOrderId();
                    $course_application->save();

                    $transaction = new Transaction();
                    $transaction->cart_id = $course_application->order_id;
                    $transaction->order_id = time() . rand(00, 99);
                    $transaction->store_id = 999999;
                    $transaction->test_mode = 0;
                    $transaction->amount = $course_application->total_cost;
                    $transaction->description = __('SuperAdmin/backend.program_registration_free');
                    $transaction->success_url = '';
                    $transaction->canceled_url = '';
                    $transaction->declined_url = '';
                    $transaction->billing_fname = $course_application->fname;
                    $transaction->billing_sname = ($course_application->mname ? $course_application->mname . ' ' : '') . $course_application->lname;
                    $transaction->billing_address_1 = $course_application->address;
                    $transaction->billing_address_2 = '';
                    $transaction->billing_city = $course_application->city_contact;
                    $transaction->billing_region = $course_application->province_region;
                    $transaction->billing_zip = $course_application->post_code;
                    $transaction->billing_country = $course_application->country_contact;
                    $transaction->billing_email = $course_application->email;
                    $transaction->lang_code = app()->getLocale();
                    $transaction->approved = 1;
                    $transaction->response = json_encode([]);
                    $transaction->status = 1;
                    $transaction->save();
                }
                if ($transaction_order_id) {
                    $transation = Transaction::where('cart_id', $transaction_order_id)->first();
                    $txnrefund = new TransactionRefund;
                    $request->symbol == '+' ? $txnrefund->amount_added = $request->amount : $txnrefund->amount_refunded = $request->amount;
                    $txnrefund->transaction_id = $transation->order_id;
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
        $course_application = CourseApplication::find($id);

        $course_application->courseApplicationApproves()->updateOrCreate(['user_course_id' => $id], [
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
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editCourse($id)
    {
        $course_application = CourseApplication::find($id);

        $data = array();
        $data['course'] = $courses = Course::with('coursePrograms')->where('school_id', $course_application->school_id)->where('display', true)->where('deleted', false)->get();
        $data['course_update'] = Course::where('unique_id', $course_application->course_id)->where('display', true)->where('deleted', false)->first();

        /*  We Are Making weekdays available in date picker available in frontend */
        $start_date_ids = [];
        $study_mode_ids = [];
        $program_age_range_ids = [];
        
        $school = School::find($course_application->school_id);

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

        $accommodation = CourseAccommodation::where('unique_id', $course_application->accommodation_id)->first();
        if ($accommodation) {
            if (app()->getLocale() == 'en') {
                $course_application->accom_type = $accommodation->type;
                $course_application->room_type = $accommodation->room_type;
                $course_application->meal_type = $accommodation->meal;
            } else {
                $course_application->accom_type = $accommodation->type_ar;
                $course_application->room_type = $accommodation->room_type_ar;
                $course_application->meal_type = $accommodation->meal_ar;
            }
        }
        $airport = CourseAirport::where('unique_id', $course_application->airport_id)->first();
        if ($airport) {
            if (app()->getLocale() == 'en') {
                $course_application->airport_provider = $airport->service_provider;
            } else {
                $course_application->airport_provider = $airport->service_provider_ar;
            }
        }
        $airport_fee = CourseAirportFee::where('unique_id', $course_application->ariport_fee_id)->first();
        if ($airport_fee) {
            if (app()->getLocale() == 'en') {
                $course_application->airport_name = $airport_fee->name;
                $course_application->airport_service = $airport_fee->service_name;
            } else {
                $course_application->airport_name = $airport_fee->name_ar;
                $course_application->airport_service = $airport_fee->service_name_ar;
            }
        }
        $medical = CourseMedical::where('unique_id', $course_application->medical_id)->first();
        if ($medical) {
            if (app()->getLocale() == 'en') {
                $course_application->company_name = $medical->company_name;
            } else {
                $course_application->company_name = $medical->company_name_ar;
            }
            $course_application->deductible_up_to = $medical->deductible;
        }

        return view('superadmin.course.single', $data, compact('courses', 'school', 'study_modes', 'course_application'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateCourse(Request $request)
    {
        $course_application = CourseApplication::find($request->id);
        $course = Course::where('unique_id', $request->program_id)->first();
        $course_program = CourseProgram::with('courseUnderAges', 'courseTextBookFees')->where('unique_id', $request->program_unique_id)->first();

        $course_application->course_id = $request->program_id;
        $course_application->course_program_id = $request->program_unique_id;
        $course_application->start_date = $request->date_selected;
        $course_application->end_date = (isset($request->date_selected) && isset($request->program_duration)) ? Carbon::create($request->date_selected)->addWeeks($request->program_duration)->format('Y-m-d') : null;;
        $course_application->study_mode = $request->study_mode;
        $course_application->age_selected = $request->age_selected;
        $course_application->program_duration = $request->program_duration ?? null;        
        $accommodation_query = CourseAccommodation::where('course_unique_id', $request->program_id);
        if (app()->getLocale() == 'en') {
            $accommodation_query->whereType($request->accom_type);
        } else {
            $accommodation_query->whereTypeAr($request->accom_type);
        }
        if (app()->getLocale() == 'en') {
            $accommodation_query->whereRoomType($request->room_type);
        } else {
            $accommodation_query->whereRoomTypeAr($request->room_type);
        }
        if (app()->getLocale() == 'en') {
            $accommodation_query->whereMeal($request->meal_type);
        } else {
            $accommodation_query->whereMealAr($request->meal_type);
        }
        $accommodation = $accommodation_query->where('start_week', '<=', (int)$request->accommodation_duration)
            ->where('end_week', '>=', (int)$request->accommodation_duration)
            ->first();
        $course_application->accommodation_id = $accommodation ? $accommodation->unique_id : 0;
        $course_application->accommodation_start_date = $course_application->medical_start_date = $accommodation ? Carbon::create($request->date_selected)->subDay()->format('d-m-Y') : null;
        $course_application->accommodation_end_date = $accommodation ? Carbon::create($course_application->accommodation_start_date)->addWeeks($request->accommodation_duration)->subDay()->format('d-m-Y') : null;
        $course_application->accommodation_duration = $accommodation ? $accommodation->accommodation_duration : null;
        $airport = CourseAirport::whereHas('fees', function($query) use($request) {
            $query->where(function($sub_query) use ($request) {
                $sub_query->where('name', $request->airport_name)->orWhere('name_ar', $request->airport_name);
            })->where(function($sub_query) use ($request) {
                $sub_query->where('service_name', $request->airport_service)->orWhere('service_name_ar', $request->airport_service);
            });
        })->whereCourseUniqueId($request->program_id)->first();
        $course_application->airport_id = $airport ? $airport->unique_id : null;
        $course_application->airport_provider = $airport ? (app()->getLocale() == 'en' ? $airport->service_provider : $airport->service_provider_ar) : null;
        $airport_fee = $airport ? CourseAirportFee::where(function($query) use ($request) {
            $query->where('name', $request->airport_name)->orWhere('name_ar', $request->airport_name);
        })->where(function($query) use ($request) {
            $query->where('service_name', $request->airport_service)->orWhere('service_name_ar', $request->airport_service);
        })->where('course_airport_unique_id', $airport->unique_id)->first() : null;
        $course_application->airport_fee_id = $airport_fee ? $airport_fee->unique_id : null;
        $course_application->airport_name = $airport_fee ? (app()->getLocale() == 'en' ? $airport_fee->name : $airport_fee->name_ar) : null;
        $course_application->airport_service = $airport_fee ? (app()->getLocale() == 'en' ? $airport_fee->service_name : $airport_fee->service_name_ar) : null;
        $medical = CourseMedical::whereHas('fees', function($query) use($request) {
            $query->where('start_date', '<=', $request->duration)->where('end_date', '>=', $request->duration);
        })->where(function($sub_query) use ($request) {
            $sub_query->where('company_name', $request->company_name)->orWhere('company_name_ar', $request->company_name);
        })->whereCourseUniqueId($request->program_id)
        ->where('deductible', $request->deductible_up_to)->first();
        $course_application->medical_id = $medical ? $medical->unique_id : null;
        $course_application->medical_company = $medical ? (app()->getLocale() == 'en' ? $medical->company_name : $medical->company_name_ar) : null;
        $course_application->medical_deductible = $medical ? $medical->deductible : null;
        $course_application->medical_end_date = Carbon::create($course_application->medical_start_date)->addWeeks($request->duration ?? 0)->subDay()->format('d-m-Y');
        $course_application->medical_duration = $request->duration ?? null;

        $under_age = $request->age_selected == null ? [] : $request->age_selected;
        $under_age = !is_array($request->age_selected) ? array($request->age_selected) : $under_age;
        $program_age_range = Choose_Program_Age_Range::where('unique_id', $request->age_selected)->first();
        $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', $under_age)->pluck('age')->toArray();
        $program_under_age = Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');
        $program_under_age_fee_per_week = 0;
        if ($request->date_selected != null) {
            $date_set = substr($request->date_selected, 6, 4) . "-" . substr($request->date_selected, 3, 2) . "-" . substr($request->date_selected, 0, 2);
            $start_date = Carbon::create($date_set)->format('Y-m-d');
        }
        if ($course_program) {
            foreach ($course_program->courseUnderAges as $program_course_under_age) {
                if (in_array($program_under_age, is_array($program_course_under_age->under_age) ? $program_course_under_age->under_age : [])) {
                    $program_under_age_fee_per_week = $program_course_under_age->under_age_fee_per_week;
                }
            }
            insertCalculationIntoDB('under_age_fee', $program_under_age_fee_per_week * $request->program_duration);
            $program_text_book_fee = 0;
            foreach ($course_program->courseTextBookFees as $program_course_text_book) {
                if ($program_course_text_book->text_book_start_date <= $request->program_duration && $program_course_text_book->text_book_end_date >= $request->program_duration) {
                    if ($program_course_text_book->text_book_fee_type == 'fixed_cost') {
                        $program_text_book_fee = $program_course_text_book->text_book_fee;
                    } else {
                        $program_text_book_fee = $program_course_text_book->text_book_fee * $request->program_duration;
                    }
                }
            }
            $course_application->text_book_fee = $program_text_book_fee;
            if ($request->courier_fee == 'true') {
                $course_application->courier_fee = $course_program->courier_fee ?? 0;
            } else {
                $course_application->courier_fee = 0;
            }
            $course_application->program_cost = (int)$request->program_duration * $course_program->program_cost;
            $dates_and_get_result['summer_date_program'] = $dates_and_get_result['peak_date_program'] = 0;
            if ($request->date_selected != null) {
                $front_end_date = getEndDate($date_set, (int)$request->program_duration);

                // Taking this from summer start date from db
                $dates_and_get_result['front_end_date_check'] = $front_end_date;
                $dates_and_get_result['front_end_date_exact'] = $front_end_date;
                $dates_and_get_result['summer_date_check'] = $course_program->summer_start_date_program;
                $dates_and_get_result['summer_date_program'] = 0;
                if (!($start_date > $course_program->summer_fee_end_date) && !($front_end_date < $course_program->summer_start_date_program)) {
                    if ($front_end_date >= $course_program->summer_fee_end_date && $start_date <= $course_program->summer_start_date_program ) {
                        $dates_and_get_result['summer_date_program'] = compareBetweenTwoDates($course_program->summer_start_date_program, $course_program->summer_fee_end_date);
                    } elseif (($front_end_date < $course_program->summer_fee_end_date && $course_program->summer_start_date_program > $start_date)) {
                        $dates_and_get_result['summer_date_program'] = $front_end_date < $course_program->summer_fee_end_date ?
                            compareBetweenTwoDates($front_end_date, $course_program->summer_start_date_program) :
                            compareBetweenTwoDates($front_end_date, $course_program->summer_fee_end_date);
                    } elseif ($front_end_date <= $course_program->summer_fee_end_date && $front_end_date >= $course_program->summer_start_date_program) {
                        $dates_and_get_result['summer_date_program'] = compareBetweenTwoDates($start_date, $front_end_date);
                    } elseif ($front_end_date >= $course_program->summer_fee_end_date && $start_date >= $course_program->summer_start_date_program) {
                        $dates_and_get_result['summer_date_program'] = compareBetweenTwoDates($start_date, $course_program->summer_fee_end_date);
                    }
                }
                $dates_and_get_result['peak_date_program'] = 0;
                if (!($start_date > $this->peak_end_date) && !($front_end_date < $this->peak_start_date)) {
                    if ($front_end_date >= $this->peak_end_date && $start_date <= $this->peak_start_date) {
                        $dates_and_get_result['peak_date_program'] = compareBetweenTwoDates($this->peak_start_date, $this->peak_end_date);
                    } elseif (($front_end_date < $this->peak_end_date && $this->peak_start_date > $start_date)) {
                        $dates_and_get_result['peak_date_program'] = $front_end_date < $this->peak_end_date ?
                            compareBetweenTwoDates($front_end_date, $this->peak_start_date) :
                            compareBetweenTwoDates($front_end_date, $this->peak_end_date);
                    } elseif ($front_end_date <= $this->peak_end_date && $front_end_date >= $this->peak_start_date) {
                        $dates_and_get_result['peak_date_program'] = compareBetweenTwoDates($start_date, $front_end_date);
                    } elseif ($front_end_date >= $this->peak_end_date && $start_date >= $this->peak_start_date) {
                        $dates_and_get_result['peak_date_program'] = compareBetweenTwoDates($start_date, $this->peak_end_date);
                    }
                }
                
                $course_application->summer_fees = $course_program->summer_fee_per_week * $dates_and_get_result['summer_date_program'];
                $course_application->peak_time_fees = $course_program->peak_time_fee_per_week * $dates_and_get_result['peak_date_program'];
            }
            if ($course_program->program_duration == null) {
                $course_application->registration_fee = $course_program->program_registration_fee == null ? 0 : $course_program->program_registration_fee;
            } else {
                if ((int)$request->program_duration >= $course_program->program_duration) {
                    $course_application->registration_fee = 0;
                } else {
                    $course_application->registration_fee = $course_program->program_registration_fee == null ? 0 : $course_program->program_registration_fee;
                }
            }
            if (checkBetweenDate($course_program->x_week_start_date, $course_program->x_week_end_date, Carbon::now()->format('Y-m-d'))) {
                // Calculating by program cost * week  - free_week
                if (!(int)$course_program->x_week_selected) {
                    $divide = 0;
                } else {
                    $divide = (int)((int)$request->program_duration / (int)$course_program->x_week_selected);
                }            
                $course_application->discount_fee = $program_total_cost = $course_program->program_cost * $divide * $course_program->how_many_week_free;
                if (checkBetweenDate($course_program->discount_start_date, $course_program->discount_end_date, Carbon::now()->format('Y-m-d'))) {
                    $explode_first = explode(" ", $course_program->discount_per_week);
                    $number = $explode_first[0];
                    $cal_symbol = $explode_first[1];
                    $totals = $program_total_cost;
                    if ($cal_symbol == '%') {
                        $total_discount = ((float)$totals / 100) * $number;
                    } else {
                        $total_discount = ($course_program->discount_per_week * $request->program_duration);
                    }

                    $discount = $course_application->discount_fee;
                    $discounted_total = $course_program->program_cost - $total_discount;

                    $course_application->discount_fee = $discount + $total_discount;
                }
            } elseif (checkBetweenDate($course_program->program_start_date, $course_program->program_end_date, Carbon::now()->format('Y-m-d'))) {
                $explode_first = explode(" ", $course_program->discount_per_week);
                $number = $explode_first[0];
                $cal_symbol = $explode_first[1];
                $totals = $course_program->program_cost;
                if ($cal_symbol == '%') {
                    $total_discount = ((float)$totals / 100) * $number;
                } else {
                    $total_discount = (float)$course_program->discount_per_week * (float)$request->program_duration;
                }

                $course_application->discount_fee = $total_discount;
            }
        }
        
        if ($accommodation) {
            $course_application->accommodation_fee = $accommodation->fee_per_week * $request->duration;
            if ($accommodation->program_duration && $request->program_duration >= $accommodation->program_duration) {
                $course_application->accommodation_placement_fee = 0;
            } else {
                $course_application->accommodation_placement_fee = $accommodation->placement_fee ?? 0;
            }
            $course_application->accommodation_deposit_fee = $accommodation->deposit_fee == null ? 0 : $accommodation->deposit_fee;
            if ($request->special_diet == 'true') {
                $course_application->accommodation_deposit_fee = $accommodation->special_diet_fee * $request->duration;
            } else {
                $course_application->accommodation_deposit_fee = 0;
            }
            $request_age = 0;
            if ($program_age_range) {
                $request_age = $program_age_range->age;
            }
            $under_age_fee_per_week = 0;
            $accommodation_under_age = Choose_Accommodation_Under_Age::where('age', $request_age)->first();
            $course_accommodation_under_ages = CourseAccommodationUnderAge::where('accom_id', '' . $accommodation->unique_id)->get();
            if ($accommodation_under_age && $course_accommodation_under_ages) {
                foreach ($course_accommodation_under_ages as $course_accommodation_under_age) {
                    if (in_array($accommodation_under_age->unique_id, is_array($course_accommodation_under_age->under_age) ? $course_accommodation_under_age->under_age : [])) {
                        $under_age_fee_per_week += $course_accommodation_under_age->under_age_fee_per_week;
                    }
                }
            }
            
            $accommodation_front_end_date = getEndDate($date_set, (int)$request->duration);
            $dates_and_get_weeks_accommodation['summer'] = 0 ;
            if (!($start_date > $accommodation->summer_fee_end_date) && !($accommodation_front_end_date < $accommodation->summer_fee_start_date)) {
                if ($start_date <= $accommodation->summer_fee_start_date && $accommodation_front_end_date >= $accommodation->summer_fee_end_date) {
                    $dates_and_get_weeks_accommodation['summer'] = compareBetweenTwoDates($accommodation->summer_fee_start_date, $accommodation->summer_fee_end_date);
                } elseif ($start_date <= $accommodation->summer_fee_start_date && $accommodation_front_end_date <= $accommodation->summer_fee_end_date) {
                    $dates_and_get_weeks_accommodation['summer'] = compareBetweenTwoDates($accommodation->summer_fee_start_date, $accommodation_front_end_date);
                } elseif ($start_date >= $accommodation->summer_fee_start_date && $accommodation_front_end_date <= $accommodation->summer_fee_end_date) { 
                    $dates_and_get_weeks_accommodation['summer'] = compareBetweenTwoDates($start_date, $accommodation_front_end_date);
                } elseif ($start_date >= $accommodation->summer_fee_start_date && $accommodation_front_end_date >= $accommodation->summer_fee_end_date) {
                    $dates_and_get_weeks_accommodation['summer'] = compareBetweenTwoDates($start_date, $accommodation->summer_fee_end_date);
                }
            }
            $dates_and_get_weeks_accommodation['peak'] = 0;
            if (!($start_date > $accommodation->peak_time_fee_end_date) && !($accommodation_front_end_date < $accommodation->peak_time_fee_start_date)) {
                if ($start_date <= $accommodation->peak_time_fee_start_date && $accommodation_front_end_date >= $accommodation->peak_time_fee_end_date) {
                    $dates_and_get_weeks_accommodation['peak'] = compareBetweenTwoDates($accommodation->peak_time_fee_start_date, $accommodation->peak_time_fee_end_date);
                } elseif ($start_date <= $accommodation->peak_time_fee_start_date && $accommodation_front_end_date <= $accommodation->peak_time_fee_end_date) {
                    $dates_and_get_weeks_accommodation['peak'] = compareBetweenTwoDates($accommodation->peak_time_fee_start_date, $accommodation_front_end_date);
                } elseif ($start_date >= $accommodation->peak_time_fee_start_date && $accommodation_front_end_date <= $accommodation->peak_time_fee_end_date) { 
                    $dates_and_get_weeks_accommodation['peak'] = compareBetweenTwoDates($start_date, $accommodation_front_end_date);
                } elseif ($start_date >= $accommodation->peak_time_fee_start_date && $accommodation_front_end_date >= $accommodation->peak_time_fee_end_date) {
                    $dates_and_get_weeks_accommodation['peak'] = compareBetweenTwoDates($start_date, $accommodation->peak_time_fee_end_date);
                }
            }
            $dates_and_get_weeks_accommodation['christmas'] = 0;
            if (!($start_date > $accommodation->christmas_fee_end_date) && !($accommodation_front_end_date < $accommodation->christmas_fee_start_date)) {
                if ($start_date <= $accommodation->christmas_fee_start_date && $accommodation_front_end_date >= $accommodation->christmas_fee_end_date) {
                    $dates_and_get_weeks_accommodation['christmas'] = compareBetweenTwoDates($accommodation->christmas_fee_start_date, $accommodation->christmas_fee_end_date);
                } elseif ($start_date <= $accommodation->christmas_fee_start_date && $accommodation_front_end_date <= $accommodation->christmas_fee_end_date) {
                    $dates_and_get_weeks_accommodation['christmas'] = compareBetweenTwoDates($accommodation->christmas_fee_start_date, $accommodation_front_end_date);
                } elseif ($start_date >= $accommodation->christmas_fee_start_date && $accommodation_front_end_date <= $accommodation->christmas_fee_end_date) {
                    $dates_and_get_weeks_accommodation['christmas'] = compareBetweenTwoDates($start_date, $accommodation_front_end_date);
                } elseif ($start_date >= $accommodation->christmas_fee_start_date && $accommodation_front_end_date >= $accommodation->christmas_fee_end_date) {
                    $dates_and_get_weeks_accommodation['christmas'] = compareBetweenTwoDates($start_date, $accommodation->christmas_fee_end_date);
                }
            }
            $course_application->accommodation_under_age_fee = $under_age_fee_per_week * (int)$request->duration;
            $course_application->accommodation_christmas_fee = $accommodation->christmas_fee_per_week * $dates_and_get_weeks_accommodation['christmas'];
            $accommodation_discount_total = 0;
            if (checkBetweenDate($accommodation->x_week_start_date, $accommodation->x_week_end_date, Carbon::now()->format('Y-m-d'))) {
                if ($accommodation->x_week_selected) {
                    $accommodation_discount_total = $accommodation->fee_per_week * (int)((int)$request->duration / (int)$accommodation->x_week_selected) * $accommodation->how_many_week_free;
                } else {
                    $accommodation_discount_total = 0;
                }
            } else if (checkBetweenDate($accommodation->discount_start_date, $accommodation->discount_end_date, Carbon::now()->format('Y-m-d'))) {
                $get_symbol = explode(" ", $accommodation->discount_per_week);
    
                // We are calculating discount based on % or - here
                $accommodation_discount_total = $get_symbol[1] == '%' ? (($accommodation->fee_per_week * $request->duration / 100) * $get_symbol[0]) : ((float)$accommodation->discount_per_week * (float)$request->duration);
            }
            $course_application->accommodation_discount_fee = $accommodation_discount_total;
            $course_application->accommodation_peak_fee = $accommodation->peak_time_fee_per_week * $dates_and_get_weeks_accommodation['peak'];
            $course_application->accommodation_summer_fee = $accommodation->summer_fee_per_week * $dates_and_get_weeks_accommodation['summer'];
            $course_application->accommodation_special_diet_fee = 0;
        }

        $airport_pickup_fee = 0;
        if (!empty($airport)) {
            $airport_week_selected_fee = (int)$airport->week_selected_fee;
            if (($airport_week_selected_fee && $airport_week_selected_fee > $request->program_duration) || !$airport_week_selected_fee) {
                foreach ($airport->fees as $airport_fee) {
                    $airport_pickup_fee = $airport_fee->service_fee;
                }
            }
        }
        $course_application->airport_pickup_fee = $airport_pickup_fee;
        $medical_insurance_fee = 0;
        if (!empty($medical)) {
            $medical_week_selected_fee = (int)$medical->week_selected_fee;
            if (($medical_week_selected_fee && $medical_week_selected_fee > $request->program_duration) || !$medical_week_selected_fee) {
                foreach ($medical->fees as $medical_fee) {
                    if ($medical_fee->start_date <= $request->medical_duration && $medical_fee->end_date >= $request->medical_duration) {
                        $medical_insurance_fee += $medical_fee->fees_per_week * ($request->medical_duration - $medical_fee->start_date + 1);
                    }
                }
            }
        }
        $course_application->medical_insurance_fee = $medical_insurance_fee;
        $program_age_range = Choose_Program_Age_Range::where('unique_id', $request->age_selected)->first();
        $custodian_under_age = Choose_Custodian_Under_Age::where('age', $program_age_range ? $program_age_range->age : '')->value('unique_id');
        $custodian = CourseCustodian::where('course_unique_id', $request->program_id)->where('age_range', 'LIKE', '%' . $custodian_under_age . '%')->first();
        $custodian_fee_flag = false;
        $course_application->custodian_fee = 0;
        if ($custodian) {
            if ($custodian->condition == 'required') {
                $custodian_fee_flag = true;
            } else {
                if ($request->custodianship == 'true') {
                    $custodian_fee_flag = true;
                }
            }
            if ($custodian_fee_flag) {
                $course_application->custodian_fee = $custodian->fee;
            }
        }
        $course_application->total_discount = $course_application->discount_fee + $course_application->accommodation_discount_fee;
        $course_application->total_cost =
            ($course_application->program_cost ?? 0) + ($course_application->registration_fee ?? 0) + ($course_application->text_book_fee ?? 0)
            + ($course_application->summer_fees ?? 0) + ($course_application->peak_time_fees ?? 0) + ($course_application->under_age_fees ?? 0)
            + ($course_application->courier_fee ?? 0)
            + ($course_application->accommodation_fee ?? 0) + ($course_application->accommodation_placement_fee ?? 0) + ($course_application->accommodation_special_diet_fee ?? 0)
            + ($course_application->accommodation_deposit_fee ?? 0) + ($course_application->accommodation_summer_fee ?? 0) + ($course_application->accommodation_peak_fee ?? 0)
            + ($course_application->accommodation_christmas_fee ?? 0) + ($course_application->accommodation_under_age_fee ?? 0)
            + ($course_application->accommodation_special_diet_fee ?? 0)
            + ($course_application->airport_pickup_fee ?? 0) + ($course_application->medical_insurance_fee ?? 0) + ($course_application->custodian_fee ?? 0)
            - ($course_application->discount_fee ?? 0) - ($course_application->accommodation_discount ?? 0);
        $course_application->sub_total = $course_application->total_cost + $course_application->total_discount;
        $course_application->save();

        toastSuccess('Updated Successfully');

        \Mail::send(new UpdatedCourseApplication($course_application->email));

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
        $data['booked_details'] = CourseApplication::with('User', 'course', 'courseApplicationApprove')->where('user_id', $customer_id)->get();

        return view('superadmin.course_application.index', $data);
    }
}