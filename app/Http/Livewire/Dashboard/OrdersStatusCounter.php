<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\OrderStatus;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrdersStatusCounter extends Component
{
    public $statuses;

    public $counters;

    public $month;

    public $year;

    public function mount()
    {
        $this->statuses = Status::all();
        $this->month = now()->format('m');
        $this->year = now()->format('Y');
        $this->getCounters();
    }

    public function getCounters()
    {
        $this->counters = OrderStatus::query()
        ->withOut(['status', 'creator', 'technician'])
            ->whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, status_id')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                ->from('order_statuses')
                ->groupBy('order_id');
            })
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
