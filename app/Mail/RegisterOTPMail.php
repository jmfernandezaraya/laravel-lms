<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\SuperAdmin\EmailTemplate;

class RegisterOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $token;

    private $sender_name, $sender_email, $subject;
    
    public function __construct($token, $locale)
    {
        $this->token = $token;

        $this->sender_name = env('MAIL_FROM_NAME');
        $this->sender_email = env('MAIL_FROM_ADDRESS');
        $this->subject = __('Frontend.verify_email');

        $email_template = EmailTemplate::where('template', 'verify_email')->first();
        if ($email_template) {
            if ($email_template->sender_email) {
                $this->sender_email = $email_template->sender_email;
            }
            if ($locale == 'en') {
                if ($email_template->sender_name) {
                    $this->sender_name = $email_template->sender_name;
                }
                if ($email_template->subject) {
                    $this->subject = $email_template->subject;
                }
            } else {
                if ($email_template->sender_name_ar) {
                    $this->sender_name = $email_template->sender_name_ar;
                }
                if ($email_template->subject_ar) {
                    $this->subject = $email_template->subject_ar;
                }
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contents = [
            'type' => 'button',
            'url' => route('verify-email-user', $this->token),
            'message' => __('Frontend.verify_email'),
        ];
        $mail = $this->markdown('mail.template', ['contents' => $contents]);
        if ($this->sender_email) {
            if ($this->sender_name) {
                $mail = $mail->from($this->sender_email, $this->sender_name);
            } else {
                $mail = $mail->from($this->sender_email);
            }
        }
        if ($this->subject) {
            $mail = $mail->subject($this->subject);
        }
        return $mail;
    }
}