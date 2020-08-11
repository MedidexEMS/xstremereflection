<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RescheduleReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $estimate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($estimate)
    {
        $this->estimate = $estimate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reschedule')->subject("Reschedule Request");
    }
}
