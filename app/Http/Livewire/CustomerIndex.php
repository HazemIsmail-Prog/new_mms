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

    public $pagination = 10;
    public $search =
    [
        'name' => '',
        'phone' => '',
        'area_id' => '',
        'block' => '',
        'street' => '',
        'start_date' => null,
        'end_date' => null,
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
                $q->whereRelation('phones', 'number', 'like', '%' . $this->search['phone'] . '%');
            })
            ->when($this->search['area_id'], function ($q) {
                $q->whereRelation('addresses', 'area_id', '=', $this->search['area_id']);
            })
            ->when($this->search['block'], function ($q) {
                $q->whereRelation('addresses', 'block', '=', $this->search['block']);
            })
            ->when($this->search['street'], function ($q) {
                $q->whereRelation('addresses', 'street', '=', $this->search['street']);
            })
            ->when($this->search['start_date'], function ($q) {
                $q->whereDate('created_at', '>=', $this->search['start_date']);
            })
            ->when($this->search['end_date'], function ($q) {
                $q->whereDate('created_at', '<=', $this->search['end_date']);
            })

            //#####################################################################

            ->with(['phones', 'addresses', 'invoices.invoice_details', 'invoices.payments'])
            ->withCount('orders')
            ->orderByDesc('id')
            ->paginate($this->pagination);

        return view('livewire.customer-index', compact('customers'));
    }
}
