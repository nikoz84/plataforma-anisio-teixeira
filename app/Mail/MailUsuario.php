<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailUsuario extends Mailable
{
    use Queueable;use SerializesModels;

    /**
     * Create a new message instance.
     * Crie uma nova instância de mensagem.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     * Construa a mensagem.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('emails.emailUsuario');
    }
}
