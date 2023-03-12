<?php

namespace App\Observers;

use App\Events\OrderEvent;
use App\Events\RefreshTechnicianPageEvent;
use App\Models\Payment;

class PaymentObserver
{
    public function created(Payment $payment)
    {
        $invoice = $payment->invoice;
        $invoice->update([
            'payment_status' => $invoice->payment_status
        ]);
        event(new OrderEvent($payment->invoice->order->department_id,$payment->invoice->order->id,'order_updated'));
        event(new RefreshTechnicianPageEvent($payment->invoice->order->technician_id));
    }

    public function deleted(Payment $payment)
    {
        $invoice = $payment->invoice;
        $invoice->update([
            'payment_status' => $invoice->payment_status
        ]);
        event(new OrderEvent($payment->invoice->order->department_id, $payment->invoice->order->id, 'order_updated'));
        event(new RefreshTechnicianPageEvent($payment->invoice->order->technician_id));
    }
}
