<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, User::all()->count()),
            'order_statuses_id' => fake()->numberBetween(1, 5),
            'total'   => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
