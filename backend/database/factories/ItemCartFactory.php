<?php

namespace Database\Factories;

use App\Models\ItemCart;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemCart>
 */
class ItemCartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => ShoppingCart::factory(),
            'product_id' => Product::factory(),
            'amount' => fake()->numberBetween(1, 5),
            'unit_price' => fake()->randomFloat(2, 20, 500)
        ];
    }
}
