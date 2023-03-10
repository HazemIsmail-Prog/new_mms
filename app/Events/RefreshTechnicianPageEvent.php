<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefreshTechnicianPageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $technician_id;

    public function __construct($technician_id)
    {
        $this->technician_id = $technician_id;
    }

    public function broadcastOn()
    {
        return new Channel('RefreshTechnicianPageChannel' . $this->technician_id);
    }
}
