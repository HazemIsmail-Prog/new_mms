<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $search =
    [
        'name' => '',
        'phone' => '',
        'area_id' => '',
        'block' => '',
        'street' => '',
    ];
    public $areas;
    // public $customers;

    public function mount()
    {
        $this->areas = Area::all();

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::query()

            // For Search #########################################################

            ->when($this->search['name'], function ($q) {
                $q->where('name', 'like', '%' . $this->search['name'] . '%');
            })
            ->when($this->search['phone'], function ($q) {
                $q->whereHas('phones', function ($q2) {
                    $q2->where('number', 'like', '%' . $this->search['phone'] . '%');
                });
            })
            ->when($this->search['area_id'], function ($q) {
                $q->whereHas('addresses', function ($q2) {
                    $q2->where('area_id', $this->search['area_id']);
                });
            })
            ->when($this->search['block'], function ($q) {
                $q->whereHas('addresses', function ($q2) {
                    $q2->where('block', 'like', $this->search['block']);
                });
            })
            ->when($this->search['street'], function ($q) {
                $q->whereHas('addresses', function ($q2) {
                    $q2->where('street', 'like', $this->search['street']);
                });
            })

            //#####################################################################

            ->with(['phones', 'addresses'])
            ->withCount('orders')
            ->orderByDesc('id')
            ->paginate(10);
        return view('livewire.customer-index',compact('customers'))->layout('layouts.slot');
    }
}
