<?php

namespace App\Http\Livewire;

use App\Exports\OrdersExport;
use App\Models\Area;
use App\Models\Department;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class OrdersIndex extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $orders;

    public $pagination = 10;
    public $areas = [];
    public $creators = [];
    public $technicians = [];
    public $departments = [];
    public $statuses = [];
    public $filter = [];

    public function mount(Request $request)
    {
        $this->filter =
        [
            'order_number' => $request->order_number ?? '',
            'customer_id' => $request->customer_id ?? '',
            'customer_name' => '',
            'customer_phone' => '',
            'block' => '',
            'street' => '',
            'start_created_at' => '',
            'end_created_at' => '',
            'start_completed_at' => $request->start_completed_at ?? '',
            'end_completed_at' => $request->end_completed_at ?? '',
            'areas' => [],
            'creators' => [],
            'statuses' => $request->status_id ?? [],
            'technicians' => $request->technician_id ?? [],
            'departments' => [],
        ];
        request()->query->remove('order_number');
        request()->query->remove('customer_id');
        request()->query->remove('start_completed_at');
        request()->query->remove('end_completed_at');
        request()->query->remove('technician_id');
        request()->query->remove('status_id');
    }
    public function getData()
    {
        $this->orders = Order::query()
            ->filterWhenRequest($this->filter)
            ->with(['address', 'department', 'technician', 'creator', 'status', 'customer', 'phone', 'invoices.invoice_details', 'invoices.payments'])
            ->latest('created_at');
    }

    public function export()
    {
        $this->getData();
        return Excel::download(new OrdersExport('pages.orders.excel', 'Orders', $this->orders->get()), 'Orders.xlsx');  //Excel
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }


    public function render()
    {
        $this->areas = Area::all();
        $this->creators = User::whereHas('orders_creator')->get();
        $this->technicians = User::whereHas('orders_technician')->get();
        $this->departments = Department::whereHas('orders')->get();
        $this->statuses = Status::all();
        
        $this->getData();
        $orders = $this->orders->paginate($this->pagination);
        return view('livewire.orders-index', compact('orders'));
    }
}
