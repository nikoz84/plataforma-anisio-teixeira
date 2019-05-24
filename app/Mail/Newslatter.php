<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Markdown;

class Newslatter extends Mailable
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
        $data = [
            'name' => 'Fabiano',
            'email' => 'niko@gmail.com',
            'subject' => 'denuncia',
            'url' => 'http://pat.des',
            'message' => 'Mensagem importante'
        ];
        //return $this->markdown('emails.newslatter');
        return $this->view('emails')->with($data);
    }
}
