<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class OrderStatusForm extends Component
{

    public $order_id;
    public $statuses;
    public $users;
    public $rows;

    public function mount()
    {
        $this->statuses = Status::all();
        $this->users = User::all();
        $this->refresh_data();
    }

    public function updatedOrderId()
    {
        $this->refresh_data();
    }

    public function refresh_data()
    {
        $this->rows = [];
        $order_satuses = OrderStatus::where('order_id', $this->order_id)->get();
        foreach ($order_satuses as $row) {
            $this->rows[] = [
                'id' => $row->id,
                'status_id' => $row->status_id,
                'user_id' => $row->user_id,
                'technician_id' => $row->technician_id,
                'date' => $row->created_at->format('Y-m-d'),
                'time' => $row->created_at->format('H:i'),
            ];
        }
    }

    public function add_row()
    {
        $this->rows[] = [
            'id' => null,
            'status_id' => null,
            'user_id' => null,
            'technician_id' => null,
            'date' => null,
            'time' => null,
        ];
    }

    public function delete_row($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function save()
    {
        $order = Order::find($this->order_id);
        $data = [];
        foreach ($this->rows as $row) {

            $data[] = [
                'id' => $row['id'],
                'status_id' => $row['status_id'],
                'user_id' => $row['user_id'],
                'technician_id' => $row['technician_id'] == '' ? null : $row['technician_id'] ,
                'created_at' => $row['date'] . " " . $row['time'],
            ];
        }
        DB::beginTransaction();
        try {
            $order->statuses()->delete();
            $order->statuses()->createMany($data);
            $order->updated_by = auth()->id();
            $order->technician_id = $order->latest_status->technician_id;
            $order->status_id = $order->latest_status->status_id;
            $order->completed_at = $order->latest_status->status_id == 4 ? $order->latest_status->created_at : null;
            $order->cancelled_at = $order->latest_status->status_id == 6 ? $order->latest_status->created_at : null;
            $order->updated_at = now();
            $order->saveQuietly();
            DB::commit();
            $this->refresh_data();
            dd('Done');
        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['error' => __('messages.something went wrong ' . '(' . $e->getMessage() . ')')]);
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.order-status-form');
    }
}
