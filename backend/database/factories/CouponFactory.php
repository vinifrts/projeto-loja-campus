<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->bothify('DESC###')),
            'description' => fake()->sentence(),
            'type_discount' => fake()->randomElement([ 'percentual', 'fixo' ]),
            'discount_value' => fake()->randomFloat(2, 5, 50),
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'active' => true
        ];
    }
}
