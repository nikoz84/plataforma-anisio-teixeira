<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('plataforma-f0d1bd@inbox.mailtrap.io')
                ->view('emails.test')
                ->with([
                    'name' => $this->name,
                    'email'=> $this->email,
                    'url'=> $this->url,
                    'subject'=> $this->subject,
                    'message'=> $this->message,
                ]);
    }
}
