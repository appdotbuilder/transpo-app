<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceCategory>
 */
class ServiceCategoryFactory extends Factory
{
    protected $model = ServiceCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = ['taxi', 'send', 'rent', 'food', 'shop'];
        $service = fake()->randomElement($services);

        return [
            'name' => ucfirst($service),
            'slug' => $service,
            'icon' => ['🚗', '📦', '🚙', '🍔', '🛍️'][array_search($service, $services)],
            'description' => fake()->sentence(),
            'base_fare' => fake()->numberBetween(2000, 10000),
            'price_per_km' => fake()->numberBetween(1000, 3000),
            'price_per_minute' => fake()->numberBetween(200, 800),
            'minimum_fare' => fake()->numberBetween(5000, 15000),
            'maximum_fare' => fake()->optional()->numberBetween(25000, 100000),
            'commission_rate' => fake()->numberBetween(15, 30),
            'is_active' => true,
            'additional_config' => [],
        ];
    }
}