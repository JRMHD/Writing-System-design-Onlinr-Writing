<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployerVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $verificationUrl = route('employer.verify', ['token' => $this->token]);

        return $this->subject('Verify Your Email Address')
            ->view('emails.employer-verification')
            ->with([
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
