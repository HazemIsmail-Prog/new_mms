<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\Payment;
use Livewire\Component;

class PaymentForm extends Component
{
    public $invoice_id;
    public $invoice;
    public $amount;
    public $method;

    public function close_payment_form()
    {
        $this->emit('payment_created');
    }

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->invoice = Invoice::find($this->invoice_id);
        $this->amount = '';
        $this->method = '';
    }

    public function save_payment()
    {
        $this->validate([
            'amount' => 'required',
            'method' => 'required',
        ]);
        
        Payment::create([
            'invoice_id' => $this->invoice_id,
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'method' => $this->method,
        ]);

        $this->emit('order_updated');

        $this->close_payment_form();
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
}
