<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 2000),
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'payment_method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'paypal']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'transaction_id' => $this->faker->uuid,
        ];
    }
}
