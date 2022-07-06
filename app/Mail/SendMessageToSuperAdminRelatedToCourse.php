<?php

namespace App\Mail;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageToSuperAdminRelatedToCourse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $request, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(User $user, array $request, array $file)
    {
        $this->request = $request;
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $data = $this->request;
        $mails = $this->markdown('mail/send_message_to_super_admin_related_to_course', ['data' => $data])->to($this->request['to_email'])->subject($this->request['subject']);

        if (!empty($this->file)) {
            foreach ($this->file as $files) {
                $mails->attach(public_path('attachments/' . $files));
            }
        }

        return $mails;
    }
}