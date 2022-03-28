<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserCourseBookedDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendMailToUserCourseApproveStatus
 * @package App\Mail
 */
class SendMailToUserCourseApproveStatus extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user, $approve, $userCourseBookedDetails;
    public function __construct(User $user, UserCourseBookedDetails $userCourseBookedDetails,  bool $approve)
    {
        $this->user = $user;
        $this->approve = $approve;
        $this->userCourseBookedDetails = $userCourseBookedDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $approved = $this->approve == 1 ? 'Approved' : "Rejected";
        return $this->markdown('mail/sendnotificationtousercourseapprovestatus')
            ->to($this->user->email)
            ->subject("Your Course ". $this->userCourseBookedDetails->course->program_name . " ahas been ". $approved);
    }
}
