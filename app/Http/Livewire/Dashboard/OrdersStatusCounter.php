<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrdersStatusCounter extends Component
{
    public $statuses;
    public $orders;
    public $months;
    public $years;
    public $selected_month;
    public $selected_year;

    public function mount()
    {
        $this->statuses = Status::orderBy('index')->get();
        $this->months = Order::selectRaw('MONTH(created_at) as month')
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->pluck('month');
        $this->years = Order::selectRaw('YEAR(created_at) as year')
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->pluck('year');
        $this->selected_month = now()->format('m');
        $this->selected_year = now()->format('Y');
        $this->getCounters();
    }

    public function getCounters()
    {
        $this->orders = Order::query()
        ->whereMonth('created_at',$this->selected_month)
        ->whereYear('created_at',$this->selected_year)
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count, status_id')
        ->groupBy(DB::raw('DATE(created_at)'), 'status_id')
        ->orderByDesc('date')
        ->get();
    }

    public function updated()
    {
        $this->getCounters();
    }

    public function render()
    {
        return view('livewire.dashboard.orders-status-counter')->layout('layouts.slot');
    }
}
