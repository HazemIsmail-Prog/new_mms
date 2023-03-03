<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $department_id;

    public function __construct($department_id)
    {
        $this->department_id = $department_id;
    }

    public function broadcastOn()
    {
        return new Channel('OrderCreatedChannel'.$this->department_id);
    }
}
