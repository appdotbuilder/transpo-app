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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name')->comment('Merchant business name');
            $table->string('business_type')->comment('Type of business: restaurant, store, etc.');
            $table->text('description')->nullable()->comment('Business description');
            $table->string('logo')->nullable()->comment('Business logo image');
            $table->string('banner')->nullable()->comment('Business banner image');
            
            // Location
            $table->text('address')->comment('Business address');
            $table->decimal('latitude', 10, 8)->comment('Business latitude');
            $table->decimal('longitude', 11, 8)->comment('Business longitude');
            
            // Operating hours
            $table->json('operating_hours')->nullable()->comment('Operating hours by day');
            $table->boolean('is_open')->default(true)->comment('Current open/closed status');
            
            // Ratings and metrics
            $table->decimal('rating', 3, 2)->default(0)->comment('Average rating');
            $table->integer('total_reviews')->default(0)->comment('Total number of reviews');
            $table->integer('total_orders')->default(0)->comment('Total completed orders');
            
            // Delivery settings
            $table->decimal('delivery_radius_km', 5, 2)->default(5)->comment('Delivery radius in kilometers');
            $table->decimal('minimum_order_amount', 10, 2)->default(0)->comment('Minimum order amount');
            $table->decimal('delivery_fee', 8, 2)->default(0)->comment('Base delivery fee');
            
            // Status
            $table->boolean('is_verified')->default(false)->comment('Verification status');
            $table->boolean('is_active')->default(true)->comment('Active status');
            
            $table->json('metadata')->nullable()->comment('Additional merchant data');
            $table->timestamps();
            
            $table->index(['user_id']);
            $table->index(['is_active', 'is_verified']);
            $table->index(['latitude', 'longitude']);
            $table->index('business_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};