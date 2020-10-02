<?php

namespace Vanguard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\Estimate;
use Vanguard\Events\CustomerApprovedEstimateEvent;
use Vanguard\WorkOrder;
use Vanguard\WorkOrderTracking;

class CreateNewWorkOrderListener
{

    /**
     * Handle the event.
     *
     * @param  CustomerApprovedEstimateEvent  $event
     * @return void
     */
    public function handle(CustomerApprovedEstimateEvent $event)
    {
        // Create New Work Order
        $workorder = new WorkOrder;
        $workorder->companyId = $event->estimate->companyId;
        $workorder->estimateId = $event->estimate->id;
        $workorder->totalCharge = $event->estimate->total;
        $workorder->status = 1;
        $workorder->save();

        $estimate = Estimate::find($event->estimate->id);
        $estimate->workOrderId = $workorder->id;
        $estimate->save();

        $wtracking = new WorkOrderTracking;
        $wtracking->workOrderId = $workorder->id;
        $wtracking->note = 'Estimate '. $event->estimate->eid .' approved by customer and work order created.';
        $wtracking->save();
    }
}
