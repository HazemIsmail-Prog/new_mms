<?php

namespace App\Http\Livewire;

use App\Events\RefreshTechnicianPageEvent;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class OrderForm extends Component
{
    public $customer;
    public $phone_id;
    public $address_id;
    public $department_id;
    public $departments;
    public $technicians = [];
    public $technician_id = '';
    public $estimated_start_date;
    public $order_description;
    public $orderNotes;
    public $dup_orders_count;
    public $order;
    public $order_id;
    // public $disable_save_button = false;

    public function mount($customer_id, $order_id = null)
    {
        $this->customer = Customer::find($customer_id);
        $this->order = Order::find($order_id);

        if (!$this->order_id) {
            //create
            $this->departments = Department::where('is_service', 1)->get();
            $this->phone_id = $this->customer->phones->count() == 1 ? $this->customer->phones()->first()->id : null;
            $this->address_id = $this->customer->addresses->count() == 1 ? $this->customer->addresses()->first()->id : null;
            $this->estimated_start_date = today()->format('Y-m-d');
        } else {
            //edit
            $this->departments = $this->order->technician ? Department::whereId($this->order->department_id)->get() : Department::where('is_service', 1)->get();
            $this->updated('department_id', $this->order->department_id);
            $this->department_id = $this->order->department_id;
            $this->technician_id = $this->order->technician_id;
            $this->customer = $this->order->customer;
            $this->phone_id = $this->order->phone->id;
            $this->address_id = $this->order->address->id;
            $this->department_id = $this->order->department_id;
            $this->estimated_start_date = $this->order->estimated_start_date->format('Y-m-d');
            $this->order_description = $this->order->order_description;
            $this->orderNotes = $this->order->notes;
        }
    }

    public function rules()
    {
        return [
            'department_id' => ['required'],
            'estimated_start_date' => ['required'],
            'phone_id' => ['required'],
            'address_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => __('messages.service_type_required'),
            'estimated_start_date.required' => __('messages.estimated_start_date_required'),
            'address_id.required' => __('messages.address_required'),
            'phone_id.required' => __('messages.phone_required'),
        ];
    }

    public function updated($key, $val)
    {
        if ($key == 'department_id') {
            $this->technician_id = '';
            if ($val) {
                $this->technicians = Department::find($val)->technicians;
            }
        }

        if (in_array($key, ['department_id', 'estimated_start_date', 'address_id'])) {
            $this->dup_orders_count = Order::query()
                ->where([
                    'address_id' => $this->address_id,
                    'department_id' => $this->department_id,
                    // 'estimated_start_date' => $this->estimated_start_date,
                ])
                ->whereNotIn('status_id',[4,6])
                ->when($this->order, function ($q) {
                    $q->where('id', '!=', $this->order->id);
                })
                ->count();
        }
    }

    public function saveOrder()
    {
        $this->validate();
        // $this->disable_save_button = true;
        if (!$this->order_id) {
            //create
            $data = [
                'customer_id' => $this->customer->id,
                'phone_id' => $this->phone_id,
                'address_id' => $this->address_id,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'department_id' => $this->department_id,
                'estimated_start_date' => $this->estimated_start_date,
                'notes' => $this->orderNotes,
                'technician_id' => null,
                'status_id' => 1,
                'order_description' => $this->order_description,
            ];
            $this->order = Order::create($data);

            $this->department_id = null; // this line to avoid order duplication with the user click on save many times

            if ($this->technician_id) {
                $this->order->update([
                    'technician_id' => $this->technician_id,
                    'status_id' => 2,
                    'index' => 1000,
                ]);
                $technician = User::find($this->technician_id);
                if ($technician->current_order_for_technician->id == $this->order->id) {
                    event(new RefreshTechnicianPageEvent($this->technician_id));
                }
            }
            session()->flash('success', __('messages.added_successfully'));
            return redirect()->route('customers.index');
        } else {
            //edit
            $data = [
                'customer_id' => $this->customer->id,
                'phone_id' => $this->phone_id,
                'address_id' => $this->address_id,
                'updated_by' => auth()->id(),
                'department_id' => $this->department_id,
                'estimated_start_date' => $this->estimated_start_date,
                'notes' => $this->orderNotes,
                'order_description' => $this->order_description,
            ];
            $this->order->update($data);
            session()->flash('success', __('messages.updated_successfully'));
            return redirect()->route('orders.index');
        }
    }

    public function render()
    {
        return view('livewire.order-form');
    }
}
