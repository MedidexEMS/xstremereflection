<?php

namespace Vanguard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\Events\CustomerApprovedEstimateEvent;
use Vanguard\WorkOrderTracking;

class WorkOrderTrackerListener
{

    /**
     * Handle the event.
     *
     * @param  CustomerApprovedEstimateEvent  $event
     * @return void
     */
    public function handle(CustomerApprovedEstimateEvent $event)
    {

    }
}
