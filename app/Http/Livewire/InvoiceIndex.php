<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['order_updated' => '$refresh'];


    public $search =
    [
        'invoice_number' => '',
        'order_number' => '',
        'customer_name' => '',
        'phone' => '',
        'payment_status' => '',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $invoices = Invoice::query()
            ->with(['order.customer', 'order.phone', 'invoice_details', 'payments'])

            // For Search #########################################################
            ->when($this->search['invoice_number'], function ($q) {
                $q->where('id', $this->search['invoice_number']);
            })
            ->when($this->search['order_number'], function ($q) {
                $q->where('order_id', $this->search['order_number']);
            })
            ->when($this->search['customer_name'], function ($q) {
                $q->whereRelation('order.customer','name', 'like', '%' . $this->search['customer_name'] . '%');
            })
            ->when($this->search['phone'], function ($q) {
                $q->whereRelation('order.phone', 'number', 'like', '%' . $this->search['phone'] . '%');
            })
            ->when($this->search['payment_status'], function ($q) {
                $q->where('payment_status',$this->search['payment_status']);
            })
            //#####################################################################

            ->paginate(10);

        return view('livewire.invoice-index', compact('invoices'))->layout('layouts.slot');
    }
}
