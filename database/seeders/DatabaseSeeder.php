<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         \App\Models\Customer::factory(20)->create()->each(function ($customer) {
            $orders = \App\Models\Order::factory(rand(1, 5))->create([
                'customer_id' => $customer->id
            ]);

            foreach ($orders as $order) {
                \App\Models\OrderItem::factory(rand(1, 5))->create([
                    'order_id' => $order->id
                ]);

                if ($order->status === 'completed') {
                    \App\Models\Payment::factory()->create([
                        'order_id' => $order->id,
                        'status' => 'completed',
                        'amount' => $order->total_amount
                    ]);
                }
            }
        });
    }
}
