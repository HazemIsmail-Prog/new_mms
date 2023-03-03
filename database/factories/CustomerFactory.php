<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'notes' => $this->faker->sentence(5),
            'cid' => $this->faker->numerify('############'),
            'active' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
