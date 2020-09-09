<?php

namespace Vanguard\Http\Controllers\Web;
use Vanguard\Http\Controllers\Controller;



use Illuminate\Http\Request;
use Vanguard\Invoice;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function paymentProcess($id, $type)
    {
        $invoice = Invoice::find($id);

        if($type == 1)
        {
            $amount = $invoice->deposit * 100;
        }elseif($type == 2){
            $amount = $invoice->total - $invoice->totalPaid * 100;
        }


        Stripe::setApiKey(env('stripeTestKey'));

        $token = $_POST['stripeToken'];
        $charge = Charge::create([
            'amount' => $amount,
            'currency' => 'usd',
            'description' => 'Example Charge',
            'source' => $token
        ]);

        $paid = $invoice->totalPaid + $amount;

        $invoice->totalPaid = $paid;
        $invoice->save();


        return view('invoice.summary', compact('invoice'));
    }
}
