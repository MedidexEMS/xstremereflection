<?php

namespace Vanguard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\Events\CustomerApprovedEstimateEvent;

class EstimateApprovedListener
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
        //
    }
}
