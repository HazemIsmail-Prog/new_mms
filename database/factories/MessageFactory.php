<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sender = $this->faker->randomElement([1, 2, 3, 4]);
        switch ($sender) {
            case 1:
                $receiver = $this->faker->randomElement([2, 3, 4]);
                break;
            case 2:
                $receiver = $this->faker->randomElement([1, 3, 4]);
                break;
            case 3:
                $receiver = $this->faker->randomElement([1, 2, 4]);
                break;
            case 4:
                $receiver = $this->faker->randomElement([1, 2, 3]);
                break;
        }
        // $receiver = ;
        return [
            'sender_user_id' => $sender,
            'receiver_user_id' => $receiver,
            'message' => $this->faker->sentence(5),
        ];
    }
}
