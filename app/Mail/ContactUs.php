<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $request;

    private $sender_name, $sender_email;
    public $subject, $contents;

    public function __construct($request, $locale)
    {
        $this->request = $request;
        
        $this->sender_name = env('MAIL_FROM_NAME');
        $this->sender_email = $this->request->email;
        $this->subject = __('Frontend.contact_us');
        $this->contents = [];
        
        $contents_html = '';
        $email_template = EmailTemplate::where('template', 'contact_us')->first();
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
                if ($email_template->content) {
                    $contents_html = $email_template->content;
                }
            } else {
                if ($email_template->sender_name_ar) {
                    $this->sender_name = $email_template->sender_name_ar;
                }
                if ($email_template->subject_ar) {
                    $this->subject = $email_template->subject_ar;
                }
                if ($email_template->content_ar) {
                    $contents_html = $email_template->content_ar;
                }
            }

            $user_name = '';
            if ($locale == 'en') {
                $user_name = $this->request->user->first_name_en . ' ' . $this->request->user->last_name_en;
            } else {
                $user_name = $this->request->user->first_name_ar . ' ' . $this->request->user->last_name_ar;
            }
            foreach ($email_template->keywords as $email_template_keyword) {
                if (isset($this->request->{$email_template_keyword})) {
                    $contents_html = str_replace('[' . $email_template_keyword . ']', $this->request->{$email_template_keyword}, $contents_html);
                }
            }
            $contents_html = str_replace('[website_link]', url('/'), $contents_html);
            $contents_html = str_replace('[app_name]', config('app.name'), $contents_html);
        }

        $this->contents = [];
        $contents = explode("\n\n", $contents_html);
        foreach ($contents as $content) {
            $this->contents[] = [
                'type' => 'message',
                'message' => $content,
            ];
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('mail.template', ['contents' => $this->contents]);
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
        if ($this->files) {
            foreach ($this->files as $file) {
                $mail = $mail->attach($file);
            }
        }

        return $mail;
    }
}
