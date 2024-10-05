<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $writer;
    public $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($writer, $amount)
    {
        $this->writer = $writer;
        $this->amount = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Withdrawal Request Processed')
            ->view('emails.withdrawal')
            ->with([
                'writer' => $this->writer,
                'amount' => $this->amount,
            ]);
    }
}
