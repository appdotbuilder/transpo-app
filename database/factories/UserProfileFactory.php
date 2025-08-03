<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'role' => fake()->randomElement(['customer', 'driver', 'merchant', 'agent', 'admin']),
            'phone' => fake()->phoneNumber(),
            'avatar' => null,
            'address' => fake()->address(),
            'latitude' => fake()->latitude(-6.4, -6.0), // Jakarta area
            'longitude' => fake()->longitude(106.6, 107.0), // Jakarta area
            'firebase_token' => null,
            'is_online' => fake()->boolean(30), // 30% chance of being online
            'is_verified' => fake()->boolean(70), // 70% chance of being verified
            'last_active' => fake()->optional()->dateTimeBetween('-1 week', 'now'),
            'metadata' => [],
        ];
    }

    /**
     * Indicate that the profile is for a driver.
     */
    public function driver(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'driver',
            'is_verified' => true,
        ]);
    }

    /**
     * Indicate that the profile is for a merchant.
     */
    public function merchant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'merchant',
            'is_verified' => true,
        ]);
    }

    /**
     * Indicate that the profile is for a customer.
     */
    public function customer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'customer',
            'is_verified' => false,
        ]);
    }
}