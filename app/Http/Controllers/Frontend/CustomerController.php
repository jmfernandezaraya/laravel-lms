<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Mail\ContactCenterAdmin;
use App\Mail\SendMailToSuperAdminUserCourseApproveStatus;
use App\Mail\SendMailToUserCourseApproveStatus;
use App\Mail\SendVerifyEmailAgain;
use App\Mail\SendMessageToSuperAdminRelatedToCourse;

use App\Classes\TransactionCalculator;

use Ghanem\Rating\Models\Rating;

use App\Models\User;
use App\Models\UserCourseBookedDetails;

use App\Models\Frontend\Review;

use App\Models\SuperAdmin\Choose_Accommodation_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Under_Age;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseProgramTextBookFee;
use App\Models\SuperAdmin\CourseProgramUnderAgeFee;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\SendMessageToStudentCourse;
use App\Models\SuperAdmin\TransactionRefund;

use App\Models\SchoolAdmin\ReplyToSendSchoolMessage;

use PDF;
use Storage;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        return view('frontend.customer.index');
    }
    
    public function loginPassword()
    {
        $user = User::find(auth()->user()->id);
        if (app()->getLocale() == 'en') {
            $first_name = $user->first_name_en;
            $last_name = $user->last_name_en;
        } else {
            $first_name = $user->first_name_ar;
            $last_name = $user->last_name_ar;
        }
        $email = $user->email;
        $contact = $user->contact;
        return view('frontend.customer.login_password', compact('first_name', 'last_name', 'email', 'contact'));
    }
    
    public function verifyEmail()
    {
        $user = User::whereId(auth()->user()->id)->first();

        \Mail::to($user->email)->send(new SendVerifyEmailAgain(auth()->user()->id));

        $data['data'] = __('Frontend.verify_email_sent');
        $data['success'] = true;
        return response()->json($data);
    }
    
    public function verifyPhone()
    {
        $data['data'] = __('Frontend.verify_phone_sent');
        $data['success'] = true;
        return response()->json($data);
    }

    public function updateLoginPassword(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'sometimes',
            'email' => 'required|email',
            'contact' => 'sometimes',
            'password' => 'sometimes',
        ];

        $validate = Validator::make($request->all(), $rules);
        
        $data['success'] = true;
        if ($validate->fails()) {
            $data['success'] = false;
            $data['errors'] = $validate->errors();
        } else {
            $data['data'] = __('Frontend.data_saved');

            $user = User::whereId(auth()->user()->id)->first();
            if (app()->getLocale() == 'en') {
                $user->first_name_en = $request->first_name;
                $user->last_name_en = $request->last_name;
            } else {
                $user->first_name_ar = $request->first_name;
                $user->last_name_ar = $request->last_name;
            }
            if (isset($request->contact) && $request->contact) {
                $user->contact = $request->contact;
            }
            if (isset($request->password) && $request->password) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();
        }

        return response()->json($data);
    }
    
    public function courseApplication()
    {
        $booked_courses = UserCourseBookedDetails::where('user_id', auth()->user()->id)->with('userBookDetailsApproved')->get();

        return view('frontend.customer.course_applications', compact('booked_courses'));
    }

    public function _getCourseApplicationData($id) {
        $course_booked_detail = UserCourseBookedDetails::with('course', 'User', 'userCourseBookedStatusus')->whereId($id)->firstOrFail();

        $program_age_ranges = Choose_Program_Age_Range::whereIn('unique_id', [$course_booked_detail->age_selected])->pluck('age')->toArray();
        $data['min_age'] = ''; $data['max_age'] = '';
        if (!empty($program_age_ranges) && count($program_age_ranges)) {
            $data['min_age'] = $program_age_ranges[0];
            $data['max_age'] = $program_age_ranges[count($program_age_ranges) - 1];
        }
        $program_under_age = Choose_Program_Under_Age::whereIn('age', $program_age_ranges)->value('unique_id');

        $data['course_booked_detail'] = $course_booked_detail;
        $data['program_start_date'] = Carbon::create($course_booked_detail->start_date)->format('d-m-Y');
        $data['accommodation_start_date'] = $data['medical_start_date'] = Carbon::create($course_booked_detail->start_date)->subDay()->format('d-m-Y');
        $data['program_end_date'] = Carbon::create($course_booked_detail->end_date)->format('d-m-Y');
        $data['accommodation_end_date'] = Carbon::create($data['accommodation_start_date'])->addWeeks($course_booked_detail->accommodation_duration)->subDay()->format('d-m-Y');
        $data['medical_end_date'] = Carbon::create($data['medical_start_date'])->addWeeks($course_booked_detail->medical_duration ?? 0)->subDay()->format('d-m-Y');
        $data['school'] = School::find($course_booked_detail->school_id);
        $data['course'] = isset($course_booked_detail->course_id) ? Course::where('unique_id', $course_booked_detail->course_id)->first() : '';
        $data['program'] = isset($course_booked_detail->course_program_id) ? CourseProgram::where('unique_id', $course_booked_detail->course_program_id)->first() : null;
        $data['program_text_book_fee'] = isset($course_booked_detail->course_program_id) ? CourseProgramTextBookFee::where('course_program_id', $course_booked_detail->course_program_id)->
            where('text_book_start_date', '<=', $course_booked_detail->course_program_id)->where('text_book_end_date', '>=', $course_booked_detail->course_program_id)->first() : '';
        $data['program_under_age_fee'] = isset($course_booked_detail->course_program_id) ? CourseProgramUnderAgeFee::where('course_program_id', $course_booked_detail->course_program_id)->
            where('under_age', 'LIKE', '%' . $program_under_age . '%')->first() : '';
        $data['accommodation'] = isset($course_booked_detail->accommodation_id) ? CourseAccommodation::where('unique_id', '' . $course_booked_detail->accommodation_id)->first() : '';
        $data['airport'] = isset($course_booked_detail->airport_id) ? CourseAirport::where('unique_id', $course_booked_detail->airport_id)->first() : null;
        $data['medical'] = isset($course_booked_detail->medical_id) ? CourseMedical::where('unique_id', $course_booked_detail->medical_id)->first() : null;

        $age_ranges = $data['accommodation'] ? $data['accommodation']->age_range : [];
        $data['accommodation_min_age'] = ''; $data['accommodation_max_age'] = '';
        $accommodation_age_ranges = Choose_Accommodation_Age_Range::whereIn('unique_id', $age_ranges)->orderBy('age', 'asc')->pluck('age')->toArray();
        if (!empty($accommodation_age_ranges) && count($accommodation_age_ranges)) {
            $accommodation_min_age = $accommodation_age_ranges[0];
            $accommodation_max_age = $accommodation_age_ranges[count($accommodation_age_ranges) - 1];
        }

        $default_currency = getDefaultCurrency();

        $program_total = $course_booked_detail->total_cost - $course_booked_detail->accommodation_total - $course_booked_detail->accommodation_special_diet_fee
                - $course_booked_detail->airport_pickup_fee - $course_booked_detail->medical_insurance_fee + $course_booked_detail->discount_fee + $course_booked_detail->accommodation_discount_fee;
        
        $amount_due = 0;
        if ($transaction = $course_booked_detail->transaction) {
            $amount_due += $transaction->amount - $course_booked_detail->total_cost;
        }
        $data['transaction_details'] = new TransactionCalculator($course_booked_detail);
        
        $amount_refunded = 0;
        $data['transaction_refund'] = [];
        if ($course_booked_detail->transaction) {
            $data['transaction_refund'] = TransactionRefund::where('transaction_id', $course_booked_detail->transaction->order_id)->get();
            foreach ($data['transaction_refund'] as $all_refund) {
                $amount_refunded += $all_refund->amount_refunded;
            }
        }
        $amount_paid = ($course_booked_detail->transaction)->amount ?? $course_booked_detail->paid_amount + $data['transaction_details']->amountAdded() ?? 0;
        $data['amount_due'] = $data['transaction_details']->amountDue($course_booked_detail->total_balance);

        $calculator_values = getCurrencyConvertedValues($course_booked_detail->course_id,
            [
                $course_booked_detail->program_cost,
                $course_booked_detail->registration_fee,
                $course_booked_detail->text_book_fee,
                $course_booked_detail->summer_fees,
                $course_booked_detail->under_age_fees,
                $course_booked_detail->peak_time_fees,
                $course_booked_detail->courier_fee,
                $course_booked_detail->discount_fee,
                $program_total,
                $course_booked_detail->accommodation_fee,
                $course_booked_detail->accommodation_placement_fee,
                $course_booked_detail->accommodation_special_diet_fee,
                $course_booked_detail->accommodation_deposit_fee,
                $course_booked_detail->accommodation_summer_fee,
                $course_booked_detail->accommodation_christmas_fee,
                $course_booked_detail->accommodation_under_age_fee,
                $course_booked_detail->accommodation_custodian_fee,
                $course_booked_detail->accommodation_peak_fee,
                $course_booked_detail->accommodation_discount_fee,
                $course_booked_detail->accommodation_total,
                $course_booked_detail->airport_pickup_fee,
                $course_booked_detail->medical_insurance_fee,
                $course_booked_detail->total_discount,
                $course_booked_detail->sub_total,
                $course_booked_detail->total_cost,
                $course_booked_detail->deposit_price,
                $course_booked_detail->total_balance,
                $amount_paid,
                $amount_refunded,
                $amount_due,
            ]
        );
        $data['program_cost'] = [ 'value' => (float)$course_booked_detail->program_cost, 'converted_value' => $calculator_values['values'][0] ];
        $data['program_registration_fee'] = [ 'value' => (float)$course_booked_detail->registration_fee, 'converted_value' => $calculator_values['values'][1] ];
        $data['program_text_book_fee'] = [ 'value' => (float)$course_booked_detail->text_book_fee, 'converted_value' => $calculator_values['values'][2] ];
        $data['program_summer_fees'] = [ 'value' => (float)$course_booked_detail->summer_fee, 'converted_value' => $calculator_values['values'][3] ];
        $data['program_under_age_fees'] = [ 'value' => (float)$course_booked_detail->under_age_fee, 'converted_value' => $calculator_values['values'][4] ];
        $data['program_peak_time_fees'] = [ 'value' => (float)$course_booked_detail->peak_time_fee, 'converted_value' => $calculator_values['values'][5] ];
        $data['program_express_mail_fee'] = [ 'value' => (float)$course_booked_detail->courier_fee, 'converted_value' => $calculator_values['values'][6] ];
        $data['program_discount_fee'] = [ 'value' => (float)$course_booked_detail->discount_fee, 'converted_value' => $calculator_values['values'][7] ];
        $data['program_total'] = [ 'value' => (float)($program_total), 'converted_value' => $calculator_values['values'][8] ];
        $data['accommodation_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_fee), 'converted_value' => $calculator_values['values'][9] ];
        $data['accommodation_placement_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_placement_fee), 'converted_value' => $calculator_values['values'][10] ];
        $data['accommodation_special_diet_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_special_diet_fee), 'converted_value' => $calculator_values['values'][11] ];
        $data['accommodation_deposit_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_deposit_fee), 'converted_value' => $calculator_values['values'][12] ];
        $data['accommodation_summer_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_summer_fee), 'converted_value' => $calculator_values['values'][13] ];
        $data['accommodation_christmas_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_christmas_fee), 'converted_value' => $calculator_values['values'][14] ];
        $data['accommodation_under_age_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_under_age_fee), 'converted_value' => $calculator_values['values'][15] ];
        $data['accommodation_custodian_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_custodian_fee), 'converted_value' => $calculator_values['values'][16] ];
        $data['accommodation_peak_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_peak_fee), 'converted_value' => $calculator_values['values'][17] ];
        $data['accommodation_discount_fee'] = [ 'value' => (float)($course_booked_detail->accommodation_discount_fee), 'converted_value' => $calculator_values['values'][18] ];
        $data['accommodation_total'] = [ 'value' => (float)($course_booked_detail->accommodation_total), 'converted_value' => $calculator_values['values'][19] ];
        $data['airport_pickup_fee'] = [ 'value' => (float)$course_booked_detail->airport_pickup_fee, 'converted_value' => $calculator_values['values'][20] ];
        $data['medical_insurance_fee'] = [ 'value' => (float)$course_booked_detail->medical_insurance_fee, 'converted_value' => $calculator_values['values'][21] ];
        $data['total_discount'] = [ 'value' => (float)$course_booked_detail->total_discount, 'converted_value' => $calculator_values['values'][22] ];
        $data['sub_total'] = [ 'value' => (float)$course_booked_detail->sub_total, 'converted_value' => $calculator_values['values'][23] ];
        $data['total_cost'] = [ 'value' => (float)$course_booked_detail->total_cost, 'converted_value' => $calculator_values['values'][24] ];
        $data['deposit_price'] = [ 'value' => (float)$course_booked_detail->deposit_price, 'converted_value' => $calculator_values['values'][25] ];
        $data['total_balance'] = [ 'value' => (float)$course_booked_detail->total_balance, 'converted_value' => $calculator_values['values'][26] ];
        $data['amount_paid'] = [ 'value' => (float)$amount_paid, 'converted_value' => $calculator_values['values'][27] ];
        $data['amount_refunded'] = [ 'value' => (float)$amount_refunded, 'converted_value' => $calculator_values['values'][28] ];
        $data['amount_due'] = [ 'value' => (float)$amount_due, 'converted_value' => $calculator_values['values'][29] ];
        $data['currency'] = [ 'cost' => $calculator_values['currency'], 'converted' => $default_currency['currency'] ];

        $data['today'] = Carbon::now()->format('d-m-Y');

        $data['student_messages'] = SendMessageToStudentCourse::where('user_id', $course_booked_detail->user_id)->get();
        $data['user_school'] = null;
        $chat_messages = [];
        if ($course_booked_detail->course->school->userSchool != null) {
            $data['user_school'] = $course_booked_detail->course->school->userSchool;
            $data['chat_messages'] = ReplyToSendSchoolMessage::where('user_id', $course_booked_detail->course->school->userSchool->user->id)->get();
        }

        return $data;
    }
    
    public function detailCourseApplication($id)
    {
        $data = $this->_getCourseApplicationData($id);
        $test = '';
        return view('frontend.customer.course_application', $data, compact('test'));
    }

    public function printCourseApplication(Request $request)
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
            $pdf_data = $this->_getCourseApplicationData($request->id);            
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

    public function sendCourseApplicationMessage(Request $request)
    {
        $data['success'] = true;

        $rules = [
            'attachment.*' => 'mimes:doc,docx,pdf',
            'subject' => 'required',
            'message' => 'required',
            'to_email' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            $data['success'] = false;
            $data['errors'] = $validate->errors();
        } else {
            $request_save = $request->only('attachment', 'subject', 'message', 'to_email');

            $attachments = [];
            if ($request->has("attachment")) {
                foreach ($request->file('attachment') as $request_attachment) {
                    $attach = $request_attachment->getClientOriginalName();
                    $attachments[] = $request_attachment->getClientOriginalName();
                    $send_file = $request_attachment->move('public/attachments', $attach);
                }
            }

            $user = User::find(auth()->user()->id);
            // ReplyToSendSchoolMessage::updateOrCreate(
            //     [
            //         'send_school_message_id' => $request->send_school_message_id,
            //         'user_id' => auth()->user()->id
            //     ],
            //     [
            //         'send_school_message_id' => $request->send_school_message_id,
            //         'user_id' => auth()->user()->id,
            //         'subject' => $request->subject,
            //         'attachment' => $attachment,
            //         'message' => $request->message
            //     ]
            // );
    
            \Mail::send(new ContactCenterAdmin($user, \Arr::except($request->all(), 'attachment'), $send_file));

            $data['message'] = __('Frontend.message_sent_thank_you');
        }
        
        return response($data);
    }

    public function reviews()
    {
        $course_booked_details = UserCourseBookedDetails::with('school', 'review')->where('user_id', auth()->user()->id)->get();

        return view('frontend.customer.reviews', compact('course_booked_details'));
    }

    public function review($id)
    {
        $review = Review::where('user_course_booked_details_id', $id)->first();

        return view('frontend.customer.review', compact('id', 'review'));
    }

    public function reviewBooking(Request $request, $id)
    {
        $course_book_review = Review::where('user_course_booked_details_id', $id)->first();

        if ($course_book_review) {
            $course_book_review->review = $request->review;
            $course_book_review->quality_teaching = $request->quality_teaching;
            $course_book_review->school_facilities = $request->school_facilities;
            $course_book_review->social_activities = $request->social_activities;
            $course_book_review->school_location = $request->school_location;
            $course_book_review->satisfied_teaching = $request->satisfied_teaching;
            $course_book_review->level_cleanliness = $request->level_cleanliness;
            $course_book_review->distance_accommodation_school = $request->distance_accommodation_school;
            $course_book_review->satisfied_accommodation = $request->satisfied_accommodation;
            $course_book_review->airport_transfer = $request->airport_transfer;
            $course_book_review->city_activities = $request->city_activities;
            $course_book_review->recommend_this_school = $request->recommend_this_school;
            $course_book_review->use_full_name = $request->use_full_name;
            $course_book_review->save();
        } else {
            $new_course_book_review = new Review;
            $new_course_book_review->author_id = auth()->user()->id;
            $new_course_book_review->user_course_booked_details_id = $id;
            $new_course_book_review->review = $request->review;
            $new_course_book_review->quality_teaching = $request->quality_teaching;
            $new_course_book_review->school_facilities = $request->school_facilities;
            $new_course_book_review->social_activities = $request->social_activities;
            $new_course_book_review->school_location = $request->school_location;
            $new_course_book_review->satisfied_teaching = $request->satisfied_teaching;
            $new_course_book_review->level_cleanliness = $request->level_cleanliness;
            $new_course_book_review->distance_accommodation_school = $request->distance_accommodation_school;
            $new_course_book_review->satisfied_accommodation = $request->satisfied_accommodation;
            $new_course_book_review->airport_transfer = $request->airport_transfer;
            $new_course_book_review->city_activities = $request->city_activities;
            $new_course_book_review->recommend_this_school = $request->recommend_this_school;
            $new_course_book_review->use_full_name = $request->use_full_name;
            $new_course_book_review->save();
        }

        return back();
    }
    
    public function payments()
    {
        return view('frontend.customer.payments');
    }
}