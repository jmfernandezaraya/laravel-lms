<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\UserCourseBookedDetails;

use Storage;
use PDF;

class CourseBooked extends Mailable
{
    use Queueable, SerializesModels;

    private $request, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $request, $file = null)
    {
        $this->request = $request;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf_data = (array)$this->request;
        $pdf_data['logo'] = asset('public/frontend/assets/img/logo.png');
        
        $pdf = PDF::loadView('pdf.course_booked', $pdf_data);
        Storage::disk('public')->put('pdf/course_booked_' . $this->request->id . '.pdf', $pdf->output());

        $mail = $this->markdown('mail/course_booked', ['data' => (object)[
            'customer_name' => $this->request->user->first_name_en . ' ' . $this->request->user->last_name_en,
            'customer_no' => $this->request->user->id,
            'website_link' => url('/')
        ]])->subject(__('Mail.course_booked.subject'));
        $mail = $this->file != null ? $mail->attach($this->file) : $mail;
        $mail->attachData($pdf->output(), 'Course Booked #' . $this->request->id . '.pdf');

        return $mail;
    }
}