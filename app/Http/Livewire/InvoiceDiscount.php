<?php

namespace App\Http\Livewire;

use App\Events\OrderEvent;
use App\Events\RefreshTechnicianPageEvent;
use App\Models\Invoice;
use Livewire\Component;

class InvoiceDiscount extends Component
{
    public $invoice;
    public $discount;
    public function mount($invoice_id) {
        $this->invoice = Invoice::find($invoice_id);
        $this->discount = $this->invoice->discount;
    }

    public function save() {
        $this->invoice->update([
            'discount' => $this->discount
        ]);
        event(new OrderEvent($this->invoice->order->department_id, $this->invoice->order->id, 'order_updated'));
        event(new RefreshTechnicianPageEvent($this->invoice->order->technician_id));
    }
    public function render()
    {
        return view('livewire.invoice-discount');
    }
}
