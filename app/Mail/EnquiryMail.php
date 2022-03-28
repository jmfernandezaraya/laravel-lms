<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    private $get_request;
    /**
     * Create a new message instance.
     *
     * @param $request
     *
     * @return void
     */
    public function __construct($request)
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
        return $this->markdown('mail.enquirymail', ['requests'=>$this->get_request]);
    }
}
