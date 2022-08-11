<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerificationEmail extends Mailable
{
    use Queueable;use SerializesModels;

    protected $token;

    protected $option;

    protected $user;

    /**
     * Create a new message instance.
     * Crie uma nova instância de mensagem.
     *
     * @return void
     */
    public function __construct(User $user, $token, $option = null)
    {
        $this->user = $user;
        $this->token = $token;
        $this->option = $option;
    }

    /**
     * Build the message.
     * Construa a mensagem.
     *
     * @return $this
     */
    public function build()
    {
        $dominio = env('APP_URL');

        return $this->from(env('MAIL_USERNAME'))
            ->to($this->user->email, $this->user->name)
            ->subject('Email de verificação Plataforma Anísio Teixeira')
            ->view('emails.verificationEmail')
            ->with(
                [
                    'user' => $this->user,
                    'token' => $this->token,
                    'dominio' => $dominio,
                    'option' => $this->option,
                ]
            );
    }
}
