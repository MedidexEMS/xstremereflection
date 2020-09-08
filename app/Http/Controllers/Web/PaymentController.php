<?php

namespace Vanguard\Http\Controllers\Web;



use Illuminate\Http\Request;
use Vanguard\Invoice;

class PaymentController extends Controller
{
    public function paymentProcess($id, $type)
    {
        $invoice = Invoice::find($id);
        if($type == 1)
        {
            $amount = $invoice->deposit * 100;
        }elseif($type == 1){
            $amount = $invoice->total - $invoice->totalPaid * 100;
        }


        \Stripe\Stripe::setApiKey(env('stripeTestKey'));

        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'usd',
            'description' => 'Example Charge',
            'source' => $token
        ]);


    }
}
