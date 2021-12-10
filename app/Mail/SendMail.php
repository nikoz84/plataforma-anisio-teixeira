<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $subject;
    public $email;
    public $url;
    public $message;
    /**
     * Create a new message instance.
     * Crie uma nova instância de mensagem.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->name = $request->name;
        $this->subject = $request->subject;
        $this->email = $request->email;
        $this->url = $request->url;
        $this->message = $request->message;
    }

    /**
     * Build the message.
     * Construa a mensagem.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('plataforma-f0d1bd@inbox.mailtrap.io')
            ->view('emails')
            ->with([
                'name' => 'niko',
                'subject' => 'tete',
                'email' => "anikocom",
                'url' => "as",
                'message' => "menssagem"
            ]);
    }
}
