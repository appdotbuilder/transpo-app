<?php

namespace Database\Factories;

use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleType>
 */
class VehicleTypeFactory extends Factory
{
    protected $model = VehicleType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicles = ['motorcycle', 'car', 'mpv', 'truck', 'bicycle'];
        $vehicle = fake()->randomElement($vehicles);
        
        $capacities = [
            'motorcycle' => 1,
            'car' => 4,
            'mpv' => 7,
            'truck' => 2,
            'bicycle' => 1,
        ];

        $multipliers = [
            'motorcycle' => 1.0,
            'car' => 1.5,
            'mpv' => 2.0,
            'truck' => 2.5,
            'bicycle' => 0.8,
        ];

        return [
            'name' => ucfirst($vehicle),
            'slug' => $vehicle,
            'icon' => ['🏍️', '🚗', '🚐', '🚚', '🚴'][array_search($vehicle, $vehicles)],
            'description' => fake()->sentence(),
            'capacity' => $capacities[$vehicle],
            'price_multiplier' => $multipliers[$vehicle],
            'is_active' => true,
        ];
    }
}