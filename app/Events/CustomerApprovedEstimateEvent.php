<?php

namespace Vanguard\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerApprovedEstimateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $file;
    public $estimate;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($file, $estimate)
    {
        $this->file = $file;
        $this->estimate = $estimate;
        $this->message = 'Estimate '. $estimate->eid .' approved by customer and work order created.';
    }

}
