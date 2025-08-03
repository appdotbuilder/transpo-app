<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create basic data for transportation app
        $this->call([
            ServiceCategorySeeder::class,
            VehicleTypeSeeder::class,
        ]);

        // Create test users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Driver User',
            'email' => 'driver@example.com',
        ]);

        User::factory()->create([
            'name' => 'Merchant User',
            'email' => 'merchant@example.com',
        ]);
    }
}
