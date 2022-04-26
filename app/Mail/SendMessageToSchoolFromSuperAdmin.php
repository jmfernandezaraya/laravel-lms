<?php

namespace App\Mail;

use \Illuminate\Http\Request;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageToSchoolFromSuperAdmin extends Mailable
{
    use Queueable, SerializesModels;

    private $request, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, $file)
    {
        $this->request  = $request;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('mail/sendSchoolMessage', ['data' => $this->request])->subject('Message From ' . config('app.name'));
        $mail = $this->file != null ? $mail->attach($this->file) : $mail;

        return $mail;
    }
}
