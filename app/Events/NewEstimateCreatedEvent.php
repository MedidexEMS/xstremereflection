<?php

namespace Vanguard\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewEstimateCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $estimate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($estimate)
    {
        $this->estimate = $estimate;
        $this->message = $estimate->eid.' has been created';
    }

}
