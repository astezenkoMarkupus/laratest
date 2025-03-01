<?php

namespace Database\Factories;

use App\Models\OrderStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderStatuses>
 */
class OrderStatusesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
				'pending', 'processing', 'completed', 'cancelled', 'failed'
            ])
        ];
    }
}
