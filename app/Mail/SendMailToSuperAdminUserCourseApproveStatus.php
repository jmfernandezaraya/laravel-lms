<?php

namespace App\Mail;

use App\Models\User;
use App\Models\CourseApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendMailToSuperAdminUserCourseApproveStatus
 * @package App\Mail
 */
class SendMailToSuperAdminUserCourseApproveStatus extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user, $approve, $courseApplicationDetails;
    public function __construct(User $user, CourseApplication $courseApplicationDetails,  bool $approve)
    {
        $this->user = $user;
        $this->approve = $approve;
        $this->courseApplicationDetails = $courseApplicationDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $approved = $this->approve == 1 ? 'Approved' : "Rejected by School Admin";
        return $this->markdown('mail/sendnotificationtosuperadmincourseapprovestatus')
            ->to($this->user->email)
            ->subject("Course ". $this->courseApplicationDetails->course->program_name . " has been ". $approved);
    }
}
