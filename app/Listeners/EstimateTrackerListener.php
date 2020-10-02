<?php

namespace Vanguard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\EstimateTracking;
use Vanguard\Events\NewEstimateCreatedEvent;

class EstimateTrackerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function handle($event)
    {
        $tracking = new EstimateTracking;
        $tracking->estimateId = $event->estimate->id;
        $tracking->note = $event->message;
        $tracking->save();
    }
}
