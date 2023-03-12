<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $department_id;
    public $order_id;
    public $action;

    public function __construct($department_id, $order_id, $action)
    {
        $this->department_id = $department_id;
        $this->order_id = $order_id;
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('OrderChannel');
    }

    public function broadcastWith()
    {
        $this->department_id;
        $this->order_id;
        $this->action;
    }
}
