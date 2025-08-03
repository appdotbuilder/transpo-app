<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pickupLat = fake()->latitude(-6.4, -6.0); // Jakarta area
        $pickupLng = fake()->longitude(106.6, 107.0);
        $destLat = fake()->latitude(-6.4, -6.0);
        $destLng = fake()->longitude(106.6, 107.0);
        
        // Calculate approximate distance
        $distance = fake()->randomFloat(2, 1, 25);
        
        $baseFare = fake()->numberBetween(3000, 8000);
        $distanceFare = $distance * fake()->numberBetween(1500, 2500);
        $subtotal = $baseFare + $distanceFare;
        $discount = fake()->numberBetween(0, $subtotal * 0.2);
        $total = $subtotal - $discount;
        
        $status = fake()->randomElement(['pending', 'accepted', 'picked_up', 'in_transit', 'delivered', 'completed', 'cancelled']);

        return [
            'order_number' => 'TRX-' . strtoupper(uniqid()),
            'customer_id' => User::factory(),
            'driver_id' => fake()->optional(0.7)->randomElement(User::factory()->create()),
            'merchant_id' => fake()->optional(0.3)->randomElement(User::factory()->create()),
            'service_category_id' => ServiceCategory::factory(),
            'vehicle_type_id' => VehicleType::factory(),
            'pickup_address' => fake()->address(),
            'pickup_latitude' => $pickupLat,
            'pickup_longitude' => $pickupLng,
            'destination_address' => fake()->address(),
            'destination_latitude' => $destLat,
            'destination_longitude' => $destLng,
            'distance_km' => $distance,
            'estimated_duration_minutes' => fake()->numberBetween(15, 90),
            'base_fare' => $baseFare,
            'distance_fare' => $distanceFare,
            'time_fare' => fake()->numberBetween(0, 5000),
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'total_amount' => $total,
            'commission_amount' => $total * 0.2,
            'status' => $status,
            'notes' => fake()->optional()->sentence(),
            'accepted_at' => $status !== 'pending' ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'picked_up_at' => in_array($status, ['picked_up', 'in_transit', 'delivered', 'completed']) ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'delivered_at' => in_array($status, ['delivered', 'completed']) ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'cancelled_at' => $status === 'cancelled' ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'cancellation_reason' => $status === 'cancelled' ? fake()->sentence() : null,
            'metadata' => [],
        ];
    }
}