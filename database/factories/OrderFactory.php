<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $customer = Customer::find(rand(1, Customer::count()));
        $status_id = rand(1, 2);
        $department_id = rand(2, 4);
        $technicians = array_values(User::query()
            ->whereIn('title_id', [10, 11])
            ->whereHas('departments', function ($q) use ($department_id) {
                $q->where('department_id', $department_id);
            })
            ->pluck('id')->toArray());
        shuffle($technicians);
        $tech_id = $technicians[0];

        return [
            'customer_id' => $customer->id,
            'address_id' => $customer->addresses->first()->id,
            'phone_id' => $customer->phones->first()->id,
            'updated_by' => 1,
            'created_by' => 1,
            'status_id' => $status_id,
            'technician_id' => $status_id == 1 ? null : $tech_id,
            'index' => null,
            'department_id' => $department_id,
            'notes' => $this->faker->sentence(5),
            'completed_at' => null,
            'order_description' => $this->faker->sentence(7),
            'cancelled_at' => null,
            'estimated_start_date' => today(),
        ];

        // switch ($department_id){
            //     case 2:
            //         $tech_id = rand(8,10);
            //         break;
            //     case 3:
            //         $tech_id = rand(11,13);
            //         break;
            //     case 4:
            //         $tech_id = rand(14,16);
            //         break;
        // }
    }
}
