<?php

namespace App\Observers;

use App\Events\OrderEvent;
use App\Events\RefreshTechnicianPageEvent;
use App\Models\Invoice;

class InvoiceObserver
{
    public function created(Invoice $invoice)
    {
        event(new OrderEvent($invoice->order->department_id,$invoice->order->id,'order_updated'));
        event(new RefreshTechnicianPageEvent($invoice->order->technician_id));
    }

    public function deleted(Invoice $invoice)
    {
        event(new OrderEvent($invoice->order->department_id, $invoice->order->id, 'order_updated'));
        event(new RefreshTechnicianPageEvent($invoice->order->technician_id));
    }
}
