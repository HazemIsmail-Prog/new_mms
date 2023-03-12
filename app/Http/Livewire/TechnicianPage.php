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
        $this->order = Order::query()
            ->where('technician_id', auth()->id())
            ->whereIn('status_id', [2, 3, 7])
            ->orderBy('index')
            ->first();
    }

    public function accept_order()
    {
        $this->order->update(['status_id' => 3]);
        $this->refresh();
    }

    public function arrived_order()
    {
        $this->order->update(['status_id' => 7]);
        $this->refresh();
    }

    public function complete_order()
    {
        $this->order->update([
            'status_id' => 4,
            'completed_at' => now(),
            'index' => null,
        ]);
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.technician-page')->layout('layouts.tech');
    }
}
