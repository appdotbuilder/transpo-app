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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->comment('Unique order number');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('merchant_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade');
            
            // Pickup location
            $table->string('pickup_address')->comment('Pickup address');
            $table->decimal('pickup_latitude', 10, 8)->comment('Pickup latitude');
            $table->decimal('pickup_longitude', 11, 8)->comment('Pickup longitude');
            
            // Destination location
            $table->string('destination_address')->comment('Destination address');
            $table->decimal('destination_latitude', 10, 8)->comment('Destination latitude');
            $table->decimal('destination_longitude', 11, 8)->comment('Destination longitude');
            
            // Distance and time
            $table->decimal('distance_km', 8, 2)->nullable()->comment('Distance in kilometers');
            $table->integer('estimated_duration_minutes')->nullable()->comment('Estimated duration in minutes');
            
            // Pricing
            $table->decimal('base_fare', 10, 2)->default(0)->comment('Base fare');
            $table->decimal('distance_fare', 10, 2)->default(0)->comment('Distance-based fare');
            $table->decimal('time_fare', 10, 2)->default(0)->comment('Time-based fare');
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Subtotal before discounts');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Discount amount');
            $table->decimal('total_amount', 10, 2)->default(0)->comment('Final total amount');
            $table->decimal('commission_amount', 10, 2)->default(0)->comment('Commission amount');
            
            // Status and timestamps
            $table->enum('status', ['pending', 'accepted', 'picked_up', 'in_transit', 'delivered', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable()->comment('Order notes from customer');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            
            $table->json('metadata')->nullable()->comment('Additional order data');
            $table->timestamps();
            
            $table->index(['customer_id', 'created_at']);
            $table->index(['driver_id', 'status']);
            $table->index(['merchant_id', 'created_at']);
            $table->index(['service_category_id', 'status']);
            $table->index('order_number');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};