<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Department;
use App\Models\Order;
use App\Models\Status;
use Livewire\Component;

class DepartmentTechnicianCounter extends Component
{
    public $statuses;
    public $departments;
    public $months;
    public $years;
    public $selected_month;
    public $selected_year;

    public function mount()
    {
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
        $this->departments = Department::query()
            ->where('is_service', 1)
            ->with(['technicians' => function ($q) {
                $q->withCount(['orders_technician as completed_orders_count' => function ($q) {
                    $q->whereNotNull('completed_at');
                    $q->whereMonth('created_at', $this->selected_month);
                    $q->whereYear('created_at', $this->selected_year);
                }]);
            }])
            ->withCount(['orders as completed_orders_count' => function ($q) {
                $q->whereNotNull('completed_at');
                $q->whereMonth('created_at', $this->selected_month);
                $q->whereYear('created_at', $this->selected_year);
            }])
            ->withCount(['orders as total_orders_count' => function ($q) {
                $q->whereMonth('created_at', $this->selected_month);
                $q->whereYear('created_at', $this->selected_year);
            }])
            ->get();
    }

    public function updated()
    {
        $this->getCounters();
    }

    public function render()
    {
        return view('livewire.dashboard.department-technician-counter')->layout('layouts.slot');
    }
}
