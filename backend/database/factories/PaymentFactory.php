<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
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
            'order_id' => Order::factory(),
            'type_payment' => fake()->randomElement([
                'pix',
                'cartao',
                'boleto'
            ]),
            'value' => fake()->randomFloat(2, 20, 1000),
            'status_payment' => fake()->randomElement([
                'pendente',
                'aprovado',
                'recusado'
            ]),
            'data_payment' => now()
        ];
    }
}
