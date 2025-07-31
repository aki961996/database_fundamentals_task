<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        return [
               'customer_id' => \App\Models\Customer::factory(),
            'order_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total_amount' => $this->faker->randomFloat(2, 50, 5000),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'notes' => $this->faker->sentence,
        ];
    }
}
