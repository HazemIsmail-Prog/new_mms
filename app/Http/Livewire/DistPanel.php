<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Order;
use Livewire\Component;

class DistPanel extends Component
{
    public $orders;
    public $technicians;
    public $department_id;
    public $department;
    public $date_filter;

    public function mount($id)
    {
        $this->department_id = $id;
        $this->department = Department::find($this->department_id);
        $this->refresh_data();
    }

    public function updated($key)
    {
        if (in_array($key, ['date_filter'])) {
            $this->refresh_data();
        }
    }

    public function refresh_data()
    {
        $this->technicians = $this->department->technicians()
            ->withCount(['orders_technician as todays_completed_orders_count' => function ($q) {
                $q->whereDate('completed_at', today()->format('Y-m-d'));
                $q->where('status_id', 4);
            }])
            ->whereActive(1)
            ->get();

        $this->orders = $this->department->orders()
            ->withCount(
                ['phone as phone_number' => function ($q) {
                    $q->select(['number']);
                }]
            )
            ->withCount(['customer as customer_name' => function ($q) {
                $q->select(['name']);
            }])
            ->withCount(['creator as creator_name' => function ($q) {
                $q->select(['name_' . app()->getLocale()]);
            }])
            ->withCount(['status as status_color' => function ($q) {
                $q->select(['color']);
            }])
            ->with(['address'])
            ->whereNotIn('status_id', [4, 6])
            ->when($this->date_filter, function ($q) {
                $q->whereDate('created_at', $this->date_filter);
            })
            ->orderBy('index')
            ->get();
    }

    public function change_technician($order_id, $tech_id, $positions)
    {
        $order = Order::find($order_id);

        switch ($tech_id) {
            case 0: //dragged to unassgined box
                $order->technician_id = null;
                $order->status_id = 1;
                break;

            case 'hold': //dragged to on hold box
                $order->technician_id = null;
                $order->status_id = 5;
                break;

            case 'cancel': // cancel button clicked
                $order->technician_id = null;
                $order->status_id = 6;
                $order->cancelled_at = now();
                break;

            default: // dragged to technician box
                $order->technician_id = $tech_id;
                $order->status_id = 2;
        }

        $order->save();

        foreach ($positions as $position) {
            $currentOrderId = $position[0];
            $currentOrderIndex = $position[1];
            $currentOrder = Order::find($currentOrderId);
            $currentOrder->index = $currentOrderIndex;
            $currentOrder->save();
        }
        $this->refresh_data();
    }

    public function render()
    {
        return view('livewire.dist-panel');
    }
}
