<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['payment_status'];

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

    public function getAmountAttribute()
    {
        $amount = 0;
        foreach($this->invoice_details as $row){
            $amount += $row->quantity * $row->price;
        }
        return $amount;
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->payments()->sum('amount');
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->payments->count() == 0) {
            return 'pending';
        } else {
            if ($this->invoice_details()->sum('price') == $this->payments()->sum('amount')) {
                return 'paid';
            } else {
                return 'partially_paid';
            }
        }
    }
}
