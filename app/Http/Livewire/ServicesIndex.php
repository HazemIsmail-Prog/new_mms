<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $pagination = 10;
    public $filter = [
        'name' => '',
        'department_id' => '',
        'type' => '',
    ];

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $departments = Department::where('is_service', true)->get();
        $services = Service::query()
            ->with(['department'])
            ->when($this->filter['name'], function ($q) {
                $q->where(function ($q) {
                    $q->where('name_en', 'like', '%' . $this->filter['name'] . '%');
                    $q->orWhere('name_ar', 'like', '%' . $this->filter['name'] . '%');
                });
            })
            ->when($this->filter['department_id'], function ($q) {
                    $q->where('department_id', $this->filter['department_id']);
            })
            ->when($this->filter['type'], function ($q) {
                    $q->where('type', $this->filter['type']);
            })
            ->paginate($this->pagination);
        return view('livewire.services-index',compact('services','departments'));
    }
}
