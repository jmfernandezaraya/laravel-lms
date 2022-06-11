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
use App\Models\Review;

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
    
    public function detailCourseApplication($id)
    {
        $data = getCourseApplicationPrintData($id);
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

    public function sendCourseApplicationMessage(Request $request)
    {
        $data['success'] = true;

        $rules = [
            'attachment.*' => 'sometimes|mimes:doc,docx,pdf',
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
            $send_files = [];
            if ($request->has("attachment")) {
                foreach ($request->file('attachment') as $request_attachment) {
                    $attach = $request_attachment->getClientOriginalName();
                    $attachments[] = $request_attachment->getClientOriginalName();
                    $send_files[] = $request_attachment->move('public/attachments', $attach);
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
    
            \Mail::send(new ContactCenterAdmin($user, \Arr::except($request->all(), 'attachment'), $send_files));

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