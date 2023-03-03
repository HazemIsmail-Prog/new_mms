<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class TechnicianPage extends Component
{

    public $order;

    public function render()
    {
        return view('livewire.technician-page')->layout('layouts.tech');
    }
    
    public function refresh_data()
    {
        $this->order = Order::query()
        ->where('technician_id', auth()->id())
        ->whereIn('status_id',[2,3,7])
        ->orderBy('index')
        ->first();
        $this->render();
    }

    public function accept_order()
    {
        $this->order->update(['status_id' => 3]);
        $this->refresh_data();
    }

    public function arrived_order()
    {
        $this->order->update(['status_id' => 7]);
        $this->refresh_data();
    }

    public function complete_order()
    {
        $this->order->update([
            'status_id' => 4,
            'completed_at' => now(),
            'index' => null,
        ]);
        $this->refresh_data();
    }
}
