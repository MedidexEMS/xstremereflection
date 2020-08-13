<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompletedWorkOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $wo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($wo)
    {
        $this->wo = $wo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.completion');
    }
}
