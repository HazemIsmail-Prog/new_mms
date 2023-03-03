<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class TechnicianTiming extends Component
{
    public $orders;

    public $technicians;

    public $technician;

    public $month;

    public $year;

    public function mount()
    {
        $this->month = now()->format('m');
        $this->year = now()->format('Y');
        $this->technicians = User::where('title_id', 11)->get();
        $this->getOrders();
    }

    public function getOrders()
    {
        $this->orders = Order::query()
            ->with('latest_arrived')
            ->with('latest_received')
            ->whereNotNull('completed_at')
            ->whereMonth('completed_at', $this->month)
            ->whereYear('completed_at', $this->year)
            ->where('technician_id', $this->technician)
            ->get();
    }

    public function updated()
    {
        $this->getOrders();
    }

    public function render()
    {
        return view('livewire.dashboard.technician-timing')->layout('layouts.slot');
    }
}
