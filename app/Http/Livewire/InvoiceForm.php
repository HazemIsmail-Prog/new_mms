<?php

namespace App\Http\Livewire;

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
    public $search = '';
    public $grand_total = 0;
    public $showWarning = false;
    public $services_count = 0;
    public $parts_count = 0;
    public $discount = 0;

    public function mount()
    {
        $this->order = Order::find($this->order_id);
        $this->refresh();
        $this->selected_services = [];
    }

    public function close_invoice_form()
    {
        $this->reset('selected_services');
        $this->emitTo('order-invoices', 'order_updated');
    }

    public function updatedSearch()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->services = Service::query()
            ->where('active', 1)
            ->where('department_id', $this->order->department_id)
            ->where(function ($q) {
                $q->when($this->search, function ($q) {
                    $q->where('name_en', 'like', '%' . $this->search . '%');
                    $q->orWhere('name_ar', 'like', '%' . $this->search . '%');
                });
            })
            ->get();
    }

    public function rules()
    {
        return [
            'selected_services' => 'required',
            'selected_services.*.service_id' => 'required',
            'selected_services.*.quantity' => 'required',
            'selected_services.*.price' => 'required',
            'search' => 'prohibited',
            'showWarning' => 'boolean|not_in:1',
        ];
    }

    public function messages()
    {
        return [
            'search.prohibited' => __('messages.clear_search_to_continue'),
        ];
    }



    public function updatedSelectedServices($val, $key)
    {
        $index = explode('.', $key)[0];
        $field = explode('.', $key)[1];

        $this->selected_services[$index]['service_total'] = 0;
        if ($field == 'service_id' && !$val == '') {
            $service = $this->services->where('id', $val)->first();
            $this->selected_services[$index]['service_type'] = $service->type;
            $this->selected_services[$index]['name'] = $service->name;
            $this->selected_services[$index]['min_price'] = $service->min_price;
            $this->selected_services[$index]['max_price'] = $service->max_price;
        }

        if ($field == 'service_id' && !$val) {
            unset($this->selected_services[$index]);
        }
        if (!$val == '') {
            $this->selected_services[$index]['service_total'] = @$this->selected_services[$index]['quantity'] * @$this->selected_services[$index]['price'];
        }


        $this->grand_total = 0;
        foreach ($this->selected_services as $row) {
            $this->grand_total += $row['service_total'];
        }
    }

    public function unset($index)
    {
        unset($this->selected_services[$index]);
    }

    public function check_before_submit()
    {
        $this->services_count = 0;
        $this->parts_count = 0;
        foreach ($this->selected_services as $service) {
            if ($service['service_type'] == 'service') {
                $this->services_count++;
            }
            if ($service['service_type'] == 'part') {
                $this->parts_count++;
            }
        }
        // dd($this->services_count, $this->parts_count);

        if ($this->services_count == 0 || $this->parts_count == 0) {
            $this->showWarning = true;
        } else {
            $this->showWarning = false;
        }
        $this->validate();
    }

    public function confirm_save()
    {
        $this->showWarning = false;
        $this->validate();
        $this->create_invoice();
    }

    public function form_submit()
    {
        $this->showWarning = false;
        $this->validate();
        $this->check_before_submit();
        $this->create_invoice();
    }

    public function create_invoice()
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'order_id' => $this->order_id,
                'user_id' => auth()->id(),
                'payment_status' => $this->grand_total > 0 ? 'pending' : 'free',
                'discount' => $this->discount,
            ]);
            foreach ($this->selected_services as $row) {
                $invoice->invoice_details()->create([
                    'service_id' => $row['service_id'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                ]);
            }
            DB::commit();
            $this->reset('selected_services');
            $this->emit('order_updated');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }
}
