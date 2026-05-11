<?php

namespace Database\Factories;

use App\Models\ImageProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImageProduct>
 */
class ImageProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'url_image' => fake()->imageUrl(),
            'subtitle' => fake()->sentence(),
            'principal' => fake()->boolean()
        ];
    }
}
