<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['order_updated' => '$refresh'];


    protected $invoices;
    public $search =
    [
        'invoice_number' => '',
        'order_number' => '',
        'invoice_date' => '',
        'department_id' => '',
        'technician_id' => '',
        'customer_name' => '',
        'phone' => '',
        'payment_status' => '',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getData()
    {
        $this->invoices = Invoice::query()
            ->with(['order.customer', 'order.phone', 'invoice_details.service', 'payments'])

            // For Search #########################################################
            ->when($this->search['invoice_number'], function ($q) {
                $q->where('id', $this->search['invoice_number']);
            })
            ->when($this->search['order_number'], function ($q) {
                $q->where('order_id', $this->search['order_number']);
            })
            ->when($this->search['invoice_date'], function ($q) {
                $q->whereDate('created_at', $this->search['invoice_date']);
            })
            ->when($this->search['department_id'], function ($q) {
                $q->whereRelation('order','department_id', $this->search['department_id']);
            })
            ->when($this->search['technician_id'], function ($q) {
                $q->whereRelation('order','technician_id', $this->search['technician_id']);
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
;
    }

    public function render()
    {
        $this->getData();
        $invoices = $this->invoices->paginate(1);
        $departments = Department::where('is_service',true)->get();
        $technicians = User::whereIn('title_id',[10,11])->get();

        return view('livewire.invoice-index', compact('invoices','departments','technicians'));
    }
}
