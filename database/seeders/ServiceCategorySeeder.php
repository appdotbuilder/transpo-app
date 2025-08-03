<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Taxi',
                'slug' => 'taxi',
                'icon' => '🚗',
                'description' => 'Professional taxi service with comfortable rides and experienced drivers',
                'base_fare' => 5000,
                'price_per_km' => 2500,
                'price_per_minute' => 500,
                'minimum_fare' => 10000,
                'maximum_fare' => null,
                'commission_rate' => 20,
                'is_active' => true,
                'additional_config' => [
                    'surge_pricing' => true,
                    'booking_fee' => 2000,
                    'cancellation_fee' => 5000
                ]
            ],
            [
                'name' => 'Send',
                'slug' => 'send',
                'icon' => '📦',
                'description' => 'Fast and reliable package delivery service across the city',
                'base_fare' => 3000,
                'price_per_km' => 2000,
                'price_per_minute' => 300,
                'minimum_fare' => 8000,
                'maximum_fare' => 50000,
                'commission_rate' => 15,
                'is_active' => true,
                'additional_config' => [
                    'weight_limit_kg' => 20,
                    'fragile_handling_fee' => 5000,
                    'express_multiplier' => 1.5
                ]
            ],
            [
                'name' => 'Rent',
                'slug' => 'rent',
                'icon' => '🚙',
                'description' => 'Hourly or daily vehicle rental service with flexible options',
                'base_fare' => 15000,
                'price_per_km' => 1500,
                'price_per_minute' => 1000,
                'minimum_fare' => 50000,
                'maximum_fare' => null,
                'commission_rate' => 25,
                'is_active' => true,
                'additional_config' => [
                    'hourly_rate' => 25000,
                    'daily_rate' => 200000,
                    'fuel_policy' => 'return_same_level',
                    'deposit_required' => true
                ]
            ],
            [
                'name' => 'Food',
                'slug' => 'food',
                'icon' => '🍔',
                'description' => 'Food delivery from your favorite restaurants and cafes',
                'base_fare' => 2500,
                'price_per_km' => 1500,
                'price_per_minute' => 200,
                'minimum_fare' => 5000,
                'maximum_fare' => 25000,
                'commission_rate' => 30,
                'is_active' => true,
                'additional_config' => [
                    'merchant_commission' => 20,
                    'delivery_fee_cap' => 15000,
                    'free_delivery_threshold' => 50000,
                    'peak_hour_multiplier' => 1.2
                ]
            ],
            [
                'name' => 'Shop',
                'slug' => 'shop',
                'icon' => '🛍️',
                'description' => 'Shopping and grocery delivery from local stores and markets',
                'base_fare' => 3000,
                'price_per_km' => 1800,
                'price_per_minute' => 250,
                'minimum_fare' => 7000,
                'maximum_fare' => 30000,
                'commission_rate' => 25,
                'is_active' => true,
                'additional_config' => [
                    'merchant_commission' => 15,
                    'shopping_fee' => 5000,
                    'heavy_items_fee' => 10000,
                    'personal_shopper' => true
                ]
            ]
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}