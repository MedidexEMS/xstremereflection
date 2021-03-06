<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Vanguard\Customer;
use PDF;

class EstimateMailable extends Mailable
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
        $pdf = PDF::loadView('estimate.pdf.estimate')->setOption("footer-right", "Page [page] from [topage]");

        $file = $customer->lastName.'_'.$this->estimate->id.'_estimate.pdf';

        return $this->view('emails.estimate')->attachData($pdf->output(), $file);
    }
}
