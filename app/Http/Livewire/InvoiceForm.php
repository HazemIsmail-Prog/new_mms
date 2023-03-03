<?php

namespace App\Http\Livewire;

use App\Events\OrderUpdatedPerOrderEvent;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InvoiceForm extends Component
{
    public $order_id;

    public $order;

    public $selected_services = [];

    public $services;

    public $grand_total = 0;

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->order = Order::find($this->order_id);
        $this->services = Service::where('department_id', $this->order->department_id)->get();
        $this->selected_services = [];
    }

    public function rules()
    {
        return [
            'selected_services' => 'required',
            'selected_services.*.service_id' => 'required',
            'selected_services.*.quantity' => 'required',
            'selected_services.*.price' => 'required',
        ];
    }

    public function updatedSelectedServices($val, $key)
    {
        $index = explode('.', $key)[0];
        $field = explode('.', $key)[1];

        $this->selected_services[$index]['service_total'] = 0;
        if (! $val == '') {
            $this->selected_services[$index]['service_total'] = @$this->selected_services[$index]['quantity'] * @$this->selected_services[$index]['price'];
        }

        if ($field == 'service_id' && ! $val) {
            unset($this->selected_services[$index]);
        }

        $this->grand_total = 0;
        foreach ($this->selected_services as $row) {
            $this->grand_total += $row['service_total'];
        }
    }

    public function create_invoice()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'order_id' => $this->order_id,
                'user_id' => auth()->id(),
            ]);

            foreach ($this->selected_services as $row) {
                $invoice->invoice_details()->create([
                    'service_id' => $row['service_id'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                ]);
            }

            DB::commit();
            $this->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        // event(new OrderUpdatedPerOrderEvent($this->order_id));
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }
}
