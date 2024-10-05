<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidAcceptedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $writer;
    public $bid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($writer, $bid)
    {
        $this->writer = $writer;
        $this->bid = $bid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Bid Has Been Accepted')
            ->view('emails.bid_accepted')
            ->with([
                'writer' => $this->writer,
                'bid' => $this->bid,
            ]);
    }
}
