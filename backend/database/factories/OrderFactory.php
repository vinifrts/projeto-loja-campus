<?php

namespace Database\Factories;

use App\Models\Coupon;
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
            'user_id' => User::factory(),
            'coupon_id' => fake()->boolean(30) ? Coupon::factory() : null,
            'subtotal' => fake()->randomFloat(2, 50, 1000),
            'discount' => fake()->randomFloat(2, 0, 100),
            'freight'  => fake()->randomFloat(2, 10, 50),
            'total' => fake()->randomFloat(2, 50, 1000),
            'type_delivery' => fake()->randomElement([
                'retirada',
                'delivery'
            ]),
            'status_order' => fake()->randomElement([
                'pendente',
                'pago',
                'enviado',
                'entregue',
                'cancelado'
            ])
        ];
    }
}
