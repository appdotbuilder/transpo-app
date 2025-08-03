<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = [
            [
                'name' => 'Motorcycle',
                'slug' => 'motorcycle',
                'icon' => '🏍️',
                'description' => 'Fast and efficient for small items and single passenger',
                'capacity' => 1,
                'price_multiplier' => 1.0,
                'is_active' => true,
            ],
            [
                'name' => 'Car',
                'slug' => 'car',
                'icon' => '🚗',
                'description' => 'Comfortable ride for up to 4 passengers with air conditioning',
                'capacity' => 4,
                'price_multiplier' => 1.5,
                'is_active' => true,
            ],
            [
                'name' => 'MPV',
                'slug' => 'mpv',
                'icon' => '🚐',
                'description' => '7-seater vehicle perfect for groups and families',
                'capacity' => 7,
                'price_multiplier' => 2.0,
                'is_active' => true,
            ],
            [
                'name' => 'Truck',
                'slug' => 'truck',
                'icon' => '🚚',
                'description' => 'Large cargo capacity for heavy items and bulk deliveries',
                'capacity' => 2,
                'price_multiplier' => 2.5,
                'is_active' => true,
            ],
            [
                'name' => 'Bicycle',
                'slug' => 'bicycle',
                'icon' => '🚴',
                'description' => 'Eco-friendly option for short distances and light packages',
                'capacity' => 1,
                'price_multiplier' => 0.8,
                'is_active' => true,
            ]
        ];

        foreach ($vehicleTypes as $vehicleType) {
            VehicleType::create($vehicleType);
        }
    }
}