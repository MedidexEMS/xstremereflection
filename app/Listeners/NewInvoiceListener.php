<?php

namespace Vanguard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\Estimate;
use Vanguard\Events\CustomerApprovedEstimateEvent;
use Vanguard\Invoice;
use Vanguard\WorkOrder;

class NewInvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerApprovedEstimateEvent  $event
     * @return void
     */
    public function handle(CustomerApprovedEstimateEvent $event)
    {
        if($event->estimate->invoieId){
            $invoice = new Invoice;

            $invoice->companyId = Auth()->user()->companyId;
            $invoice->customerId = $event->estimate->customerId;
            $invoice->estimateId = $event->estimate->id;
            $invoice->workOrderId = $event->estimate->workorder->id;
            $invoice->detailType = $event->estimate->detailType;
            $invoice->dateofService = $event->estimate->dateofService;
            $invoice->total = $event->estimate->workorder->totalCharge;
            $invoice->deposit = $event->estimate->deposit;
            $invoice->status = 1;
            $invoice->save();

            //TODO find how to get the work order id
            $workorder = WorkOrder::find($event->estimate->workorder->id);
            $workorder->invoiceId = $invoice->id;
            $workorder->save();

            $estimate = Estimate::find($event->estimate->id);
            $estimate->invoiceId = $invoice->id;
            $estimate->save();

            dump($invoice);
        }
    }
}
