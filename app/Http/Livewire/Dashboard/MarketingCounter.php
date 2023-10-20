<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Marketing;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MarketingCounter extends Component
{
    public $types;
    public $marketings;
    public $months;
    public $years;
    public $selected_month;
    public $selected_year;

    public function mount()
    {
        $this->types = ['marketing','information','service_not_available'];
        $this->months = Marketing::selectRaw('MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->pluck('month');
        $this->years = Marketing::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
        $this->selected_month = now()->format('m');
        $this->selected_year = now()->format('Y');
        $this->getCounters();
    }

    public function getCounters()
    {
        $this->marketings = Marketing::query()
            ->whereMonth('created_at', $this->selected_month)
            ->whereYear('created_at', $this->selected_year)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, type')
            ->groupBy(DB::raw('DATE(created_at)'), 'type')
            ->orderByDesc('date')
            ->get();
    }

    public function updated()
    {
        $this->getCounters();
    }
    public function render()
    {
        return view('livewire.dashboard.marketing-counter');
    }
}
