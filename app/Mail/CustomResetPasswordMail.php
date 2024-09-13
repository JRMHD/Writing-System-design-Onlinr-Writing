<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $guard;
    public $email;

    public function __construct($token, $guard, $email)
    {
        $this->token = $token;
        $this->guard = $guard;
        $this->email = $email;
    }

    public function build()
    {
        // Determine the correct URL based on the guard (employer or writer)
        $resetUrl = route(
            $this->guard === 'employer' ? 'employer.password.reset' : 'writer.password.reset',
            ['token' => $this->token, 'email' => $this->email]
        );

        // Return the email view with the necessary variables
        return $this->view($this->viewForGuard())
            ->with([
                'resetUrl' => $resetUrl,
                'email' => $this->email,
                'token' => $this->token
            ]);
    }

    // Choose the correct view based on the guard (employer or writer)
    protected function viewForGuard()
    {
        return $this->guard === 'employer'
            ? 'emails.employer-password-reset'   // View for employer password reset
            : 'emails.writer-password-reset';    // View for writer password reset
    }
}
