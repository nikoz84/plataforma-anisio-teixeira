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

    public function enviaEmail()
    {
        $emails = $this->listaEmails->
        $name = $this->name;
        $email = $this->email;
        $url = $this->url;
        $subject = $this->subject;
        $message = $this->message;

        $data = array('description' => $description, 'subject' => $subject);

        $send = Mail::send('email.email-multiple', $data);
    }
}
