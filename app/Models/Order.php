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

    public function getInvoicesCountAttribute()
    {
        return $this->invoices()->count();
    }
    public function getUnreadCommentsCountAttribute()
    {
        return $this->comments()->where('is_read', false)->where('user_id', '!=', auth()->id())->count();
    }

    public function scopeFilterWhenRequest($query, $filter)
    {
        return $query
            ->when($filter['order_number'], function ($q) use ($filter) {
                $q->where('id', $filter['order_number']);
            })
            ->when($filter['customer_id'], function ($q) use ($filter) {
                $q->where('customer_id', $filter['customer_id']);
            })
            ->when($filter['customer_name'], function ($q) use ($filter) {
                $q->whereHas('customer', function ($q2) use ($filter) {
                    $q2->where('name', 'like', '%'.$filter['customer_name'].'%');
                });
            })
            ->when($filter['customer_phone'], function ($q) use ($filter) {
                $q->whereHas('phone', function ($q2) use ($filter) {
                    $q2->where('number', 'like', '%'.$filter['customer_phone'].'%');
                });
            })
            ->when($filter['areas'], function ($q) use ($filter) {
                $q->whereHas('address', function ($q2) use ($filter) {
                    $q2->whereIn('area_id', $filter['areas']);
                });
            })
            ->when($filter['block'], function ($q) use ($filter) {
                $q->whereHas('address', function ($q2) use ($filter) {
                    $q2->where('block', 'like', $filter['block']);
                });
            })
            ->when($filter['street'], function ($q) use ($filter) {
                $q->whereHas('address', function ($q2) use ($filter) {
                    $q2->where('street', 'like', $filter['street']);
                });
            })
            ->when($filter['creators'], function ($q) use ($filter) {
                $q->whereIn('created_by', $filter['creators']);
            })
            ->when($filter['statuses'], function ($q) use ($filter) {
                $q->whereIn('status_id', $filter['statuses']);
            })
            ->when($filter['technicians'], function ($q) use ($filter) {
                $q->whereIn('technician_id', $filter['technicians']);
            })
            ->when($filter['departments'], function ($q) use ($filter) {
                $q->whereIn('department_id', $filter['departments']);
            })
            ->when($filter['start_created_at'], function ($q) use ($filter) {
                $q->whereDate('created_at', '>=', $filter['start_created_at']);
            })
            ->when($filter['end_created_at'], function ($q) use ($filter) {
                $q->whereDate('created_at', '<=', $filter['end_created_at']);
            })
            ->when($filter['start_completed_at'], function ($q) use ($filter) {
                $q->whereDate('completed_at', '>=', $filter['start_completed_at']);
            })
            ->when($filter['end_completed_at'], function ($q) use ($filter) {
                $q->whereDate('completed_at', '<=', $filter['end_completed_at']);
            })
            ;
    }
}
