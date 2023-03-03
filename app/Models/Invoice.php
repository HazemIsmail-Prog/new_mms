<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $appends = ['payment_status'];

    public function invoice_details()
    {
        return $this->hasMany(InvoiceDetails::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->doesNtHave('payments')) {
            return 'Pending';
        } else {
            if ($this->invoice_details()->sum('price') == $this->payments()->sum('amount')) {
                return 'Paid';
            } else {
                return 'Partialy Paid';
            }
        }
    }
}
