<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdminManageStudentRequest;

use App\Mail\SendMailToSuperAdminUserCourseApproveStatus;
use App\Mail\SendMailToUserCourseApproveStatus;
use App\Mail\SendMessageToSuperAdminRelatedToCourse;

use App\Models\User;
use App\Models\CourseApplication;
use App\Models\SchoolAdmin\ReplyToSchoolAdminMessage;
use App\Models\SuperAdmin\ToSchoolAdminMessage;
use App\Models\SuperAdmin\CourseApplicationApprove;

/**
 * Class CourseApplicationController
 * @package App\Http\Controllers\SchoolAdmin
 */
class CourseApplicationController extends Controller
{
    /**
     * CourseApplicationController constructor.
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

        if (auth('schooladmin')->user()->userSchool()->count() > 0 && isset(auth('schooladmin')->user()->userSchool->school->courses)) {
            $collect = collect(auth('schooladmin')->user()->userSchool->school->courses);
            $course_id = $collect->pluck('unique_id');
        }

        $data['booked_details'] = CourseApplication::with('courseApplicationApprove')->whereIn('course_id', $course_id)->get();

        return view('schooladmin.course_application.index', $data);
    }

    /**
     * @param $id
     * @param $value
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id, $value)
    {
        $course_applications = CourseApplication::findOrFail($id);
        $super_admin = User::where('user_type', 'super_admin')->first();
        $user = User::find($course_applications->user_id);
        \Mail::send(new SendMailToSuperAdminUserCourseApproveStatus($super_admin, $course_applications, $value));
        \Mail::send(new SendMailToUserCourseApproveStatus($user, $course_applications, $value));

        CourseApplicationApprove::updateOrCreate(['course_application_id' => $id], ['status' => $value]);

        toastSuccess('Message Sent Successfully');

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewMessage($id)
    {
        $data['chatMessage'] = ToSchoolAdminMessage::whereUserId(auth()->id())->whereId($id)->first();

        return view('schooladmin.course_application.view_message', $data);
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
        ReplyToSchoolAdminMessage::updateOrCreate(['to_school_admin_message_id' => $request->to_school_admin_message_id, 'user_id' => auth()->id()], ['to_school_admin_message_id' => $request->to_school_admin_message_id,
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'attachment' => $attachment,
            'message' => $request->message
        ]);

        \Mail::send(new SendMessageToSuperAdminRelatedToCourse($user, \Arr::except($request->all(), 'attachment'), $sendfile));

        return response(['success' => __("SuperAdmin/backend.upload") . __("SuperAdmin/backend.errors.success")]);
    }
}