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

    public function getPaymentStatusAttribute()
    {
        if ($this->payments->count() == 0) {
            return 'pending';
        } else {
            if ($this->remaining_amount == 0) {
                return 'paid';
            } else {
                return 'partially_paid';
            }
        }
    }

    public function getServicesAmountAttribute()
    {
        return $this->invoice_details->where('service.type','service')->sum('total');;
    }
    public function getPartsAmountAttribute()
    {
        return $this->invoice_details->where('service.type','part')->sum('total');;
    }

    public function getCashAmountAttribute()
    {
        return $this-> payments->where('method', 'cash')->sum('amount');
    }

    public function getKnetAmountAttribute()
    {
        return $this-> payments->where('method', 'knet')->sum('amount');
    }

    public function getTotalPaidAmountAttribute()
    {
        return $this-> payments->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->total_paid_amount;
    }
}
