<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $url;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $url, $subject, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->url = $url;
        $this->subject = $subject;
        $this->message = $message;
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
