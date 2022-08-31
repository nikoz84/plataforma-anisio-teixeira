<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class Newslatter extends Mailable
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
        //
    }

    /**
     * Build the message.
     * Construa a mensagem.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'name' => 'Fabiano',
            'email' => 'nikogmail.com',
            'subject' => 'denuncia',
            'url' => 'patdes',
            'message' => 'Mensagem importante',
        ];
        //return $this->markdown('emails.newslatter');
        return $this->view('emails')->with($data);
    }
}
