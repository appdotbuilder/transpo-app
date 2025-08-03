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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Category name: taxi, send, rent, food, shop');
            $table->string('slug')->unique()->comment('URL-friendly category identifier');
            $table->string('icon')->nullable()->comment('Icon for the category');
            $table->text('description')->nullable()->comment('Category description');
            $table->decimal('base_fare', 10, 2)->default(0)->comment('Base fare for this category');
            $table->decimal('price_per_km', 10, 2)->default(0)->comment('Price per kilometer');
            $table->decimal('price_per_minute', 10, 2)->default(0)->comment('Price per minute');
            $table->decimal('minimum_fare', 10, 2)->default(0)->comment('Minimum fare for this category');
            $table->decimal('maximum_fare', 10, 2)->nullable()->comment('Maximum fare for this category');
            $table->decimal('commission_rate', 5, 2)->default(0)->comment('Commission rate percentage');
            $table->boolean('is_active')->default(true)->comment('Whether this category is active');
            $table->json('additional_config')->nullable()->comment('Additional configuration as JSON');
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
        Schema::dropIfExists('service_categories');
    }
};