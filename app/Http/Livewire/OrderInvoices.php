<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\Order;
use Livewire\Component;

class OrderInvoices extends Component
{
    public $invoices = [];

    public $order_id;

    public $order;

    public $show_invoice_form;

    public $show_payment_form;

    protected $listeners = [
        // 'invoice_created'=>'refresh',
        // 'payment_created'=>'refresh',
        'order_updated'=>'refresh',
    ];



    public function mount()
    {
        $this->refresh();
    }

    public function show_invoice_form()
    {
        $this->show_invoice_form = true;
    }

    public function delete_invoice($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->invoice_details()->delete();
        $invoice->delete();
        $this->refresh();
    }

    public function refresh()
    {
        $this->order = Order::with('invoices')->find($this->order_id);
        $this->invoices = $this->order->invoices->load('invoice_details.service')->load('payments');
        $this->show_invoice_form = false;
        $this->show_payment_form = false;
    }

    public function render()
    {
        return view('livewire.order-invoices');
    }
}
