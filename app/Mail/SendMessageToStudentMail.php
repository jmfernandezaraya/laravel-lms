<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageToStudentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $get_request;
    public function __construct(Request $request)
    {
        $this->get_request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.sendmessagetostudentmail', ['message'=> $this->get_request->message, 'subject' => $this->get_request->subject])->attach(storage_path('app/public/sent_attachments/'.$this->get_request->save_file));
    }
}
