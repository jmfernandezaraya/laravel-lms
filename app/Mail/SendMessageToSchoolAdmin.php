<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Storage;

class SendMessageToSchoolAdmin extends Mailable
{
    use Queueable, SerializesModels;

    private $request, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $request, $files)
    {
        $this->request = $request;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('mail.course_booked', ['data' => (object)[
            'name' => $this->request->locale ? ($this->request->user->first_name_en . ' ' . $this->request->user->last_name_en) : ($this->request->user->first_name_ar . ' ' . $this->request->user->last_name_ar),
            'subject' => $this->request->subject,
            'message' => $this->request->message,
            'website_link' => url('/')
        ]])->subject(__('Mail.message_from_website'));
        if ($this->files) {
            foreach ($this->files as $file) {
                $mail = $mail->attach($file);
            }
        }

        return $mail;
    }
}
