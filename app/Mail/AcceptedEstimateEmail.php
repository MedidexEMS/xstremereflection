<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Vanguard\Customer;

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
    public function build($estimate)
    {
        $customer = Customer::find($estimate->customerId);
        view()->share('customer',$customer);
        view()->share('estimate',$estimate);
        $pdf = PDF::loadView('estimate.pdf.estimate', compact('estimate', 'customer'));

        $file = $customer->lastName.'_'.$this->estimate->id.'_estimate';

        return $this->view('emails.estimateAccepted')->attachData($pdf->output(), $file);
    }
}
