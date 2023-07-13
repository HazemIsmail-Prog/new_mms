<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'estimated_start_date' => 'date',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function latest_status()
    {
        return $this->hasOne(OrderStatus::class)->orderByDesc('id');
    }

    public function latest_arrived()
    {
        return $this->hasOne(OrderStatus::class)->where('status_id', 7)->orderByDesc('id');
    }

    public function latest_received()
    {
        return $this->hasOne(OrderStatus::class)->where('status_id', 3)->orderByDesc('id');
    }

    public function getArriveToCompleteAttribute()
    {
        if (isset($this->latest_arrived->created_at)) {
            return $this->completed_at->diff($this->latest_arrived->created_at)->format('%H:%I');
        }

        return '-';
    }

    public function getReceiveToCompleteAttribute()
    {
        return $this->completed_at->diff($this->latest_received->created_at)->format('%H:%I');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeFilterWhenRequest($query, $request)
    {
        return $query
            ->when($request->order_number, function ($q) use ($request) {
                $q->where('id', $request->order_number);
            })
            ->when($request->customer_id, function ($q) use ($request) {
                $q->where('customer_id', $request->customer_id);
            })
            ->when($request->name, function ($q) use ($request) {
                $q->whereHas('customer', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%'.$request->name.'%');
                });
            })
            ->when($request->phone, function ($q) use ($request) {
                $q->whereHas('phone', function ($q2) use ($request) {
                    $q2->where('number', 'like', '%'.$request->phone.'%');
                });
            })
            ->when($request->area_id, function ($q) use ($request) {
                $q->whereHas('address', function ($q2) use ($request) {
                    $q2->whereIn('area_id', $request->area_id);
                });
            })
            ->when($request->block, function ($q) use ($request) {
                $q->whereHas('address', function ($q2) use ($request) {
                    $q2->where('block', 'like', $request->block);
                });
            })
            ->when($request->street, function ($q) use ($request) {
                $q->whereHas('address', function ($q2) use ($request) {
                    $q2->where('street', 'like', $request->street);
                });
            })
            ->when($request->creator_id, function ($q) use ($request) {
                $q->whereIn('created_by', $request->creator_id);
            })
            ->when($request->status_id, function ($q) use ($request) {
                $q->whereIn('status_id', $request->status_id);
            })
            ->when($request->technician_id, function ($q) use ($request) {
                $q->whereIn('technician_id', $request->technician_id);
            })
            ->when($request->department_id, function ($q) use ($request) {
                $q->whereIn('department_id', $request->department_id);
            })
            ->when($request->start_created_at, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_created_at);
            })
            ->when($request->end_created_at, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_created_at);
            })
            ->when($request->start_completed_at, function ($q) use ($request) {
                $q->whereDate('completed_at', '>=', $request->start_completed_at);
            })
            ->when($request->end_completed_at, function ($q) use ($request) {
                $q->whereDate('completed_at', '<=', $request->end_completed_at);
            });
    }
}
