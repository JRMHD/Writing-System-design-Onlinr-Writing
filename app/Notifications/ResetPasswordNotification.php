<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends Notification
{
    protected $token;
    protected $guard;

    public function __construct($token, $guard)
    {
        $this->token = $token;
        $this->guard = $guard;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->view($this->viewForGuard(), ['resetUrl' => $url])
            ->subject('Password Reset Request');
    }

    // Generate the correct reset URL based on the guard
    protected function resetUrl($notifiable)
    {
        // Set the correct route based on the guard
        return URL::temporarySignedRoute(
            $this->guard === 'employer' ? 'employer.password.reset' : 'writer.password.reset',
            now()->addMinutes(config('auth.passwords.' . $this->guard . '.expire')),
            [
                'token' => $this->token,
                'email' => $notifiable->email, // Make sure the email is included in the URL
            ]
        );
    }

    // Determine the view based on the guard
    protected function viewForGuard()
    {
        return $this->guard === 'employer'
            ? 'emails.employer-password-reset'  // View for employer reset
            : 'emails.writer-password-reset';   // View for writer reset
    }
}
