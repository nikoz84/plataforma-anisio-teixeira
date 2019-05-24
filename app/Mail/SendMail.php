<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = (Object)$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('plataforma-f0d1bd@inbox.mailtrap.io')
            ->view('emails')
            ->with([
                'name' => $this->data->name,
                'email' => $this->data->email,
                'url' => $this->data->url,
                'subject' => $this->data->subject,
                'message' => $this->data->message,
            ]);
    }
}
