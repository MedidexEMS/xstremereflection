<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Vanguard\Customer;

use PDF;

class AcceptedEstimateEmail extends Mailable
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
        $customer = Customer::find($this->estimate->customerId);
        view()->share('customer',$customer);
        view()->share('estimate',$this->estimate);
        $pdf = PDF::loadView('estimate.pdf.estimate');

        $file = $customer->lastName.'_'.$this->estimate->id.'_estimate_accepted.pdf';

        return $this->view('emails.estimateAccepted')->attachData($pdf->output(), $file);
    }
}
