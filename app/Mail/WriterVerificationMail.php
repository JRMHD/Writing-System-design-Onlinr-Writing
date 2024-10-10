<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WriterVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        $verificationUrl = route('writer.verify', ['token' => $this->token]);

        return $this->subject('Verify Your Email Address')
            ->view('emails.writer-verification')
            ->with([
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
