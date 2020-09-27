<?php

namespace Vanguard\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\Events\NewEstimateCreated;

class NewEstimateCreated
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
     * @param  NewEstimateCreated  $event
     * @return void
     */
    public function handle(NewEstimateCreated $event)
    {
        //
    }
}
