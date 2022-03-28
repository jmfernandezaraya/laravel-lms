<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerifyEmailAgain extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public function __construct($id)
    {
        return  $this->user = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = route('verify-email-user-again', $this->user);
        return $this->from(env('MAIL_FROM_ADDRESS'))
                ->subject(__('Frontend.verify_email'))
                ->markdown('mail.verify_email', ['url'=> $url]);
    }
}
