<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class SendVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dominio = getenv('APP_URL');

        return $this->from(env('MAIL_USERNAME'))
            ->to($this->user->email, $this->user->name)
            ->subject('Email de verificação')
            ->view('emails.verificationEmail')
            ->with(
                [
                    'user' => $this->user,
                    'token' => $this->token,
                    'dominio' => $dominio
                ]
            );
    }
}
