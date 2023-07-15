<?php

namespace App\Http\Livewire;

use App\Exports\InvoicesExport;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;


class InvoiceIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['order_updated' => '$refresh'];


    protected $invoices;
    public $pagination = 10;
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

    public function export()
    {
        $this->getData();
        return Excel::download(new InvoicesExport('pages.invoices.excel', 'Invoices', $this->invoices->get()), 'Invoices.xlsx');  //Excel
    }

    public function getData()
    {
        $this->invoices = Invoice::query()
            ->orderByDesc('id')
            ->with(['order.customer', 'order.phone', 'invoice_details.service', 'payments', 'order.department', 'order.technician'])
            ->whereRelation('order', 'status_id', 4)


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
                $q->whereRelation('order', 'department_id', $this->search['department_id']);
            })
            ->when($this->search['technician_id'], function ($q) {
                $q->whereRelation('order', 'technician_id', $this->search['technician_id']);
            })
            ->when($this->search['customer_name'], function ($q) {
                $q->whereRelation('order.customer', 'name', 'like', '%' . $this->search['customer_name'] . '%');
            })
            ->when($this->search['phone'], function ($q) {
                $q->whereRelation('order.phone', 'number', 'like', '%' . $this->search['phone'] . '%');
            })
            ->when($this->search['payment_status'], function ($q) {
                $q->where('payment_status', $this->search['payment_status']);
            })
            //#####################################################################
        ;
    }

    public function render()
    {
        $this->getData();
        $invoices = $this->invoices->paginate($this->pagination);
        $departments = Department::query()
            ->where('is_service', true)
            ->whereHas('orders', function ($q) {
                $q->where('status_id', 4); // completed Only
            })
            ->get();
        $technicians = User::query()
            ->whereIn('title_id', [10, 11])
            ->whereHas('orders_technician', function ($q) {
                $q->where('status_id', 4); // completed Only
            })
            ->get();

        return view('livewire.invoice-index', compact('invoices', 'departments', 'technicians'));
    }
}
