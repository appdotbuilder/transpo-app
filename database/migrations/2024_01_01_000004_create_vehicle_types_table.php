<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Vehicle type name: Car, Motorcycle, Truck, etc.');
            $table->string('slug')->unique()->comment('URL-friendly vehicle type identifier');
            $table->string('icon')->nullable()->comment('Icon for the vehicle type');
            $table->text('description')->nullable()->comment('Vehicle type description');
            $table->integer('capacity')->default(1)->comment('Maximum passenger/item capacity');
            $table->decimal('price_multiplier', 5, 2)->default(1.0)->comment('Price multiplier for this vehicle type');
            $table->boolean('is_active')->default(true)->comment('Whether this vehicle type is active');
            $table->timestamps();
            
            $table->index(['is_active', 'created_at']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};