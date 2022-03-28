<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdminManageStudentRequest;
use App\Mail\SendMailToSuperAdminUserCourseApproveStatus;
use App\Mail\SendMailToUserCourseApproveStatus;
use App\Mail\SendMessageToSuperAdminRelatedToCourse;
use App\Models\SchoolAdmin\ReplyToSendSchoolMessage;
use App\Models\SuperAdmin\SendSchoolMessage;
use App\Models\SuperAdmin\UserCourseBookedDetailsApproved;
use App\Models\User;
use App\Models\UserCourseBookedDetails;

/**
 * Class ManageStudentController
 * @package App\Http\Controllers\SchoolAdmin
 */
class ManageStudentController extends Controller
{
    /**
     * ManageStudentController constructor.
     */
    public function __construct()
    {
        ini_set('upload_max_filesize', '500M');
        ini_set('max_file_uploads', '10000');
        ini_set('post_max_size', '200M');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $course_id = [];

        if (auth('branch_admin')->user()->userSchool()->count() > 0 && isset(auth('branch_admin')->user()->userSchool->school->courses)) {
            $collect = collect(auth('branch_admin')->user()->userSchool->school->courses);
            $course_id = $collect->pluck('unique_id');
        }

        $data['booked_details'] = UserCourseBookedDetails::with('userBookDetailsApproved')->whereIn('course_id', $course_id)->get();

        return view('branchadmin.manage_student_application.index', $data);
    }


    /**
     * @param $id
     * @param $value
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id, $value)
    {
        $user_course_booked_details = UserCourseBookedDetails::findOrFail($id);
        $super_admin = User::where('user_type', 'super_admin')->first();
        $user = User::find($user_course_booked_details->user_id);
        \Mail::send(new SendMailToSuperAdminUserCourseApproveStatus($super_admin, $user_course_booked_details, $value));
        \Mail::send(new SendMailToUserCourseApproveStatus($user, $user_course_booked_details, $value));

        UserCourseBookedDetailsApproved::updateOrCreate(['user_course_booked_details_id' => $id], ['status' => $value]);

        toastSuccess('Message Sent Successfully');

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewMessage($id)
    {
        $data['chatMessage'] = SendSchoolMessage::whereUserId(auth()->id())->whereId($id)->first();

        return view('branchadmin.manage_student_application.view_message', $data);
    }

    /**
     * @param SchoolAdminManageStudentRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendMessageToSuperAdmin(SchoolAdminManageStudentRequest $request)
    {
        $attachment = [];
        $sendfile = [];

        if ($request->has("attachment")) {
            foreach ($request->attachment as $attachments) {
                $attachment[] = $move = $attachments->getClientOriginalName();
                $attachments->move('public/attachments', $move);
                $sendfile[] = $move;
            }
        }

        $user = User::find(auth()->id());
        ReplyToSendSchoolMessage::updateOrCreate(['send_school_message_id' => $request->send_school_message_id, 'user_id' => auth()->id()], ['send_school_message_id' => $request->send_school_message_id,
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'attachment' => $attachment,
            'message' => $request->message
        ]);

        \Mail::send(new SendMessageToSuperAdminRelatedToCourse($user, \Arr::except($request->all(), 'attachment'), $sendfile));

        return response(['success' => __("SuperAdmin/backend.upload") . __("SuperAdmin/backend.errors.success")]);
    }
}