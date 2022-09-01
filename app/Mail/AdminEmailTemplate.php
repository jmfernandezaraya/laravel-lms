<?php

namespace App\Mail;

use App\Models\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Storage;
use PDF;

class AdminEmailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $template;
    private $data;
    private $files;

    private $sender_name, $sender_email;
    public $subject, $contents;

    public function __construct($template, $data, $locale, array $files = [], $subject = '')
    {
        $this->template = $template;
        $this->data = $data;
        $this->files = $files;
        
        $this->sender_name = env('MAIL_FROM_NAME');
        $this->sender_email = env('MAIL_FROM_ADDRESS');
        $this->subject = $subject;
        $this->contents = [];
        
        $contents_html = '';
        $site_setting_value = [];
        $site_setting = Setting::where('setting_key', 'site')->first();
        if ($site_setting) {
            $site_setting_value = unserialize($site_setting->setting_value);
        }
        $email_template = \App\Models\SuperAdmin\EmailTemplate::where('template', $this->template)->first();
        if ($email_template) {
            $user_name = $user_no = $user_email = '';
            $from_name = $from_no = $from_email = '';
            $to_name = $to_no = $to_email = '';
            if (isset($this->data->user)) {
                if ($locale == 'en') {
                    $user_name = $this->data->user->first_name_en . ' ' . $this->data->user->last_name_en;
                } else {
                    $user_name = $this->data->user->first_name_ar . ' ' . $this->data->user->last_name_ar;
                }
                $user_no = $this->data->user->id;
                $user_email = $this->data->user->email;
            } else {
                if ($locale == 'en') {
                    if (isset($this->data->first_name_en) && isset($this->data->last_name_en)) {
                        $user_name = $this->data->first_name_en . ' ' . $this->data->last_name_en;
                    }
                } else {
                    if (isset($this->data->first_name_ar) && isset($this->data->last_name_ar)) {
                        $user_name = $this->data->first_name_ar . ' ' . $this->data->last_name_ar;
                    }
                }
                if (isset($this->data->user_id)) {
                    $user_no = $this->data->user_id;
                }
                if (isset($this->data->email)) {
                    $user_email = $this->data->email;
                }
            }
            if (isset($this->data->from_user)) {
                if ($locale == 'en') {
                    $from_name = $this->data->from_user->first_name_en . ' ' . $this->data->from_user->last_name_en;
                } else {
                    $from_name = $this->data->from_user->first_name_ar . ' ' . $this->data->from_user->last_name_ar;
                }
                $from_no = $this->data->from_user->id;
                $from_email = $this->data->from_user->email;
            }
            if (isset($this->data->to_user)) {
                if ($locale == 'en') {
                    $to_name = $this->data->to_user->first_name_en . ' ' . $this->data->to_user->last_name_en;
                } else {
                    $to_name = $this->data->to_user->first_name_ar . ' ' . $this->data->to_user->last_name_ar;
                }
                $to_no = $this->data->to_user->id;
                $to_email = $this->data->to_user->email;
            }

            if ($email_template->admin_sender_email) {
                $this->sender_email = $email_template->admin_sender_email;
            } else if ($site_setting_value['smtp']['default_sender_email']) {
                $this->sender_email = $site_setting_value['smtp']['default_sender_email'];
            }
            if ($locale == 'en') {
                if ($email_template->admin_sender_name) {
                    $this->sender_name = $email_template->admin_sender_name;
                } else if ($site_setting_value['smtp']['default_sender_name']) {
                    $this->sender_name = $site_setting_value['smtp']['default_sender_name'];
                }
                if ($email_template->admin_subject) {
                    $this->subject = $email_template->admin_subject;
                }
                if ($email_template->admin_content) {
                    $contents_html = $email_template->admin_content;
                }
            } else {
                if ($email_template->admin_sender_name_ar) {
                    $this->sender_name = $email_template->admin_sender_name_ar;
                } else if ($site_setting_value['smtp']['default_sender_name_ar']) {
                    $this->sender_name = $site_setting_value['smtp']['default_sender_name_ar'];
                }
                if ($email_template->admin_subject_ar) {
                    $this->subject = $email_template->admin_subject_ar;
                }
                if ($email_template->admin_content_ar) {
                    $contents_html = $email_template->admin_content_ar;
                }
            }

            foreach ($email_template->keywords as $email_template_keyword) {
                if ($email_template_keyword == 'verify_url') {
                    if (isset($this->data->user)) {
                        $contents_html = str_replace('[verify_url]', route('verify-email-user', $this->data->user->remember_token), $contents_html);
                    } else if (isset($this->data->remember_token)) {
                        $contents_html = str_replace('[verify_url]', route('verify-email-user', $this->data->remember_token), $contents_html);
                    }
                } else if ($email_template_keyword == 'user_name') {
                    $contents_html = str_replace('[user_name]', $user_name, $contents_html);
                } else if ($email_template_keyword == 'user_no') {
                    $contents_html = str_replace('[user_no]', $user_no, $contents_html);
                } else if ($email_template_keyword == 'user_email') {
                    $contents_html = str_replace('[user_email]', $user_email, $contents_html);
                } else if ($email_template_keyword == 'from_name') {
                    $contents_html = str_replace('[from_name]', $from_name, $contents_html);
                } else if ($email_template_keyword == 'from_no') {
                    $contents_html = str_replace('[from_no]', $from_no, $contents_html);
                } else if ($email_template_keyword == 'from_email') {
                    $contents_html = str_replace('[from_email]', $from_email, $contents_html);
                } else if ($email_template_keyword == 'to_name') {
                    $contents_html = str_replace('[to_name]', $to_name, $contents_html);
                } else if ($email_template_keyword == 'to_no') {
                    $contents_html = str_replace('[to_no]', $to_no, $contents_html);
                } else if ($email_template_keyword == 'to_email') {
                    $contents_html = str_replace('[to_email]', $to_email, $contents_html);
                } else {
                    if (isset($this->data->{$email_template_keyword})) {
                        $contents_html = str_replace('[' . $email_template_keyword . ']', $this->data->{$email_template_keyword}, $contents_html);                        
                        $this->sender_name = str_replace('[' . $email_template_keyword . ']', $this->data->{$email_template_keyword}, $this->sender_name);
                        $this->subject = str_replace('[' . $email_template_keyword . ']', $this->data->{$email_template_keyword}, $this->subject);
                    }
                }
            }
            
            $contents_html = str_replace('[website_link]', url('/'), $contents_html);
            $contents_html = str_replace('[app_name]', config('app.name'), $contents_html);

            $this->sender_name = str_replace('[website_link]', url('/'), $this->sender_name);
            $this->sender_name = str_replace('[app_name]', config('app.name'), $this->sender_name);
            $this->sender_name = str_replace('[user_name]', $user_name, $this->sender_name);
            $this->sender_name = str_replace('[user_no]', $user_no, $this->sender_name);
            $this->sender_name = str_replace('[user_email]', $user_email, $this->sender_name);
            $this->sender_name = str_replace('[from_name]', $from_name, $this->sender_name);
            $this->sender_name = str_replace('[from_no]', $from_no, $this->sender_name);
            $this->sender_name = str_replace('[from_email]', $from_email, $this->sender_name);
            $this->sender_name = str_replace('[to_name]', $to_name, $this->sender_name);
            $this->sender_name = str_replace('[to_no]', $to_no, $this->sender_name);
            $this->sender_name = str_replace('[to_email]', $to_email, $this->sender_name);
            
            $this->subject = str_replace('[website_link]', url('/'), $this->subject);
            $this->subject = str_replace('[app_name]', config('app.name'), $this->subject);
            $this->subject = str_replace('[user_name]', $user_name, $this->subject);
            $this->subject = str_replace('[user_no]', $user_no, $this->subject);
            $this->subject = str_replace('[user_email]', $user_email, $this->subject);
            $this->subject = str_replace('[from_name]', $from_name, $this->subject);
            $this->subject = str_replace('[from_no]', $from_no, $this->subject);
            $this->subject = str_replace('[from_email]', $from_email, $this->subject);
            $this->subject = str_replace('[to_name]', $to_name, $this->subject);
            $this->subject = str_replace('[to_no]', $to_no, $this->subject);
            $this->subject = str_replace('[to_email]', $to_email, $this->subject);
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
        if ($this->template == 'course_booked') {
            $pdf_data = (array)$this->data;
            $pdf_data['logo'] = asset('public/frontend/assets/img/logo.png');
            
            $pdf = PDF::loadView('pdf.course_booked', $pdf_data);
            Storage::disk('public')->put('pdf/course_booked_' . $this->data->id . '.pdf', $pdf->output());
        }

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
        if ($this->template == 'course_booked') {
            $mail->attachData($pdf->output(), 'Course Booked #' . $this->data->id . '.pdf');
        }

        return $mail;
    }
}