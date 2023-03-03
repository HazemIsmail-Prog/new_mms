<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $number = $this->faker->randomElement([
            $this->faker->numerify('9#######'),
            $this->faker->numerify('6#######'),
            $this->faker->numerify('5#######'),
        ]);

        return [
            'type' => 'mobile',
            'number' => $number,
        ];
    }
}
