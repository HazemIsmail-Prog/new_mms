<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\Payment;
use Livewire\Component;

class InvoicePayments extends Component
{
    public $invoice_id;

    public $invoice;

    public $show_payment_form;

    protected $listeners = [
        'payment_created' => 'refresh',
        'order_updated' => 'refresh',
    ];


    public function mount()
    {
        $this->refresh();
    }

    public function delete_payment($payment_id)
    {
        $payment = Payment::find($payment_id);
        $payment->delete();
        $this->emit('payment_created');

    }

    public function refresh()
    {
        $this->invoice = Invoice::find($this->invoice_id)->load('payments.user');
        $this->show_payment_form = false;
    }
    public function render()
    {
        return view('livewire.invoice-payments');
    }
}
