<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'image' => fake()->imageUrl(),
            'destination_link' => fake()->url(),
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30)
        ];
    }
}
