<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrdersChart extends Component
{

    public $orders = [];
    public $title = '';

    public function mount() {
        $this->title = __('messages.orders_per_month');
        $this->orders = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        $this->emit('ordersFetched');
    }
    public function render()
    {
        return view('livewire.dashboard.orders-chart');
    }
}
