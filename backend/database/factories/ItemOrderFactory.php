<?php

namespace Database\Factories;

use App\Models\ItemOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemOrder>
 */
class ItemOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'  => Order::factory(),
            'product_id' => Product::factory(),
            'amount' => fake()->numberBetween(1, 5),
            'unit_price' => fake()->randomFloat(2, 20, 500),
            'subtotal_item' => fake()->randomFloat(2, 20, 1000)
        ];
    }
}
