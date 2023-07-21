<?php

namespace App\Http\Livewire;

use App\Events\RefreshTechnicianPageEvent;
use App\Models\Department;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class DistPanel extends Component
{
    public $orders;
    public $technicians;
    public $department_id;
    public $department;
    public $date_filter;
    public $change_order_technician = [];

    public function mount($id)
    {
        $this->department_id = $id;
        $this->department = Department::find($this->department_id);
        $this->refresh_data();
    }

    public function updated($key, $val)
    {
        $first_segmant = explode('.', $key)[0];

        if (in_array($first_segmant, ['date_filter'])) {
            $this->refresh_data();
        }

        if ($first_segmant == 'change_order_technician') {
            $order_id = explode('.', $key)[1];
            $new_tech_id = $val;
            $old_tech_id = Order::find($order_id)->technician_id;
            $this->change_technician($order_id, $new_tech_id, $old_tech_id, null);
        }
    }

    public function refresh_data()
    {
        $this->technicians = $this->department->technicians()
            ->withCount(['orders_technician as todays_completed_orders_count' => function ($q) {
                $q->whereDate('completed_at', today()->format('Y-m-d'));
                $q->where('status_id', 4);
            }])
            ->when(auth()->user()->shift_id, function ($q) {
                $q->where('shift_id', auth()->user()->shift_id);
            })
            ->whereActive(1)
            ->with('shift')
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
            // ->with(['comments'])
            ->whereNotIn('status_id', [4, 6])
            ->whereDate('estimated_start_date', '<=', today())
            ->when($this->date_filter, function ($q) {
                $q->whereDate('created_at', $this->date_filter);
            })
            ->orderBy('index')
            ->get();

        foreach ($this->orders as $order) {
            $this->change_order_technician[$order->id]['technician_id'] = $order->technician_id ?? '';
        }
    }

    public function mark_comments_as_read($order)
    {
        // dd($order);
        Order::find($order['id'])->comments()->update(['is_read'=>true]);
        $this->refresh_data();
    }

    public function change_technician($order_id, $new_tech_id, $old_tech_id, $positions)
    {
        $order = Order::find($order_id);

        if (!in_array($old_tech_id, [0, 'hold', 'cancel'])) {
            $old_technician = User::find($old_tech_id);
            $original_current_order_id_for_old_technician = $old_technician->current_order_for_technician ? $old_technician->current_order_for_technician->id : false;
        }
        if (!in_array($new_tech_id, [0, 'hold', 'cancel'])) {
            $new_technician = User::find($new_tech_id);
            $original_current_order_id_for_new_technician = $new_technician->current_order_for_technician ? $new_technician->current_order_for_technician->id : false;
        }

        switch ($new_tech_id) {
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
                $order->technician_id = $new_tech_id;
                $order->status_id = 2;
                $order->index = 1000;
        }

        $order->save();
        if ($positions) {
            foreach ($positions as $position) {
                $currentOrderId = $position[0];
                $currentOrderIndex = $position[1];
                $currentOrder = Order::find($currentOrderId);
                $currentOrder->index = $currentOrderIndex;
                $currentOrder->save();
            }
        }

        //events

        if (!in_array($new_tech_id, [0, 'hold', 'cancel'])) {
            $current_order_id_for_new_technician = $new_technician->current_order_for_technician ? $new_technician->current_order_for_technician->id : true;
            if ($current_order_id_for_new_technician != $original_current_order_id_for_new_technician) {
                event(new RefreshTechnicianPageEvent($new_tech_id));
            }
        }
        if (!in_array($old_tech_id, [0, 'hold', 'cancel'])) {
            $current_order_id_for_old_technician = $old_technician->current_order_for_technician ? $old_technician->current_order_for_technician->id : true;
            if ($current_order_id_for_old_technician != $original_current_order_id_for_old_technician) {
                if ($new_tech_id != $old_tech_id) {
                    event(new RefreshTechnicianPageEvent($old_tech_id));
                }
            }
            if (!$old_technician->current_order_for_technician) {
                event(new RefreshTechnicianPageEvent($old_tech_id));
            }
        }







        //     if ($order_id == $new_technician->current_order_for_technician->id) {
        //         event(new RefreshTechnicianPageEvent($new_tech_id));
        //     }
        // }
        // if (!in_array($old_tech_id, [0, 'hold', 'cancel'])) {
        //     if ($new_tech_id != $old_tech_id) {
        //         if (!$old_technician->current_order_for_technician) {
        //             event(new RefreshTechnicianPageEvent($old_tech_id));
        //         } else {
        //             if ($original_current_order_id_for_old_technician != $old_technician->current_order_for_technician->id) {
        //                 event(new RefreshTechnicianPageEvent($old_tech_id));
        //             }
        //         }
        //     }else{
        //         if($order->id != $original_current_order_id_for_new_technician){
        //             event(new RefreshTechnicianPageEvent($new_tech_id));
        //         }
        //     }
        // }



        $this->refresh_data();
    }

    public function render()
    {
        return view('livewire.dist-panel');
    }
}
