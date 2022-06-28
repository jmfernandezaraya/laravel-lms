<?php

namespace App\Mail;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactCenterAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $request, $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(User $user, array $request, array $files)
    {
        $this->user = $user;
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
        $data = $this->request;
        $mail = $this->markdown('mail/contact_center_admin', ['data' => $data])->to($this->request['to_email'])->subject($this->request['subject']);

        if ($this->files) {
            foreach ($this->files as $file) {
                $mail = $mail->attach($file);
            }
        }

        return $mail;
    }
}