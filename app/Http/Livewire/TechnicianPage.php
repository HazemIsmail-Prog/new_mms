<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class TechnicianPage extends Component
{
    public $order;

    protected $listeners = ['order_updated' => 'refresh'];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->order = auth()->user()->current_order_for_technician;
    }

    public function accept_order()
    {
        $order = Order::find($this->order->id);
        if ($order->technician_id == auth()->id()) {
            $this->order->update(['status_id' => 3]);
        }
        $this->refresh();
    }

    public function arrived_order()
    {
        $order = Order::find($this->order->id);
        if ($order->technician_id == auth()->id()) {
            $this->order->update(['status_id' => 7]);
        }
        $this->refresh();
    }

    public function complete_order()
    {
        $order = Order::find($this->order->id);
        if ($order->technician_id == auth()->id()) {
            $this->order->update([
                'status_id' => 4,
                'completed_at' => now(),
                'index' => null,
            ]);
        }
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.technician-page')->layout('layouts.tech');
    }
}
