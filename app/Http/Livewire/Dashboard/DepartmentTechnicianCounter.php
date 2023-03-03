<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Department;
use App\Models\Status;
use Livewire\Component;

class DepartmentTechnicianCounter extends Component
{
    public $statuses;
    public $departments;
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
        $this->departments = Department::query()
            ->where('is_service', 1)
            ->with(['technicians' => function ($q) {
                $q->withCount(['orders_technician as completed_orders_count' => function ($q) {
                    $q->whereNotNull('completed_at');
                    $q->whereMonth('completed_at', $this->month);
                    $q->whereYear('completed_at', $this->year);
                }]);
            }])
            ->withCount(['orders as completed_orders_count' => function ($q) {
                $q->whereNotNull('completed_at');
                $q->whereMonth('completed_at', $this->month);
                $q->whereYear('completed_at', $this->year);
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
