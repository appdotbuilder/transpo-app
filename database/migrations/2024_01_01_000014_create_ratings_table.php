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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('merchant_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('rating_type', ['driver', 'merchant'])->comment('Type of rating');
            $table->integer('rating')->comment('Rating from 1 to 5');
            $table->text('review')->nullable()->comment('Review text');
            $table->json('rating_criteria')->nullable()->comment('Specific rating criteria scores');
            $table->timestamps();
            
            $table->index(['order_id', 'rating_type']);
            $table->index(['driver_id', 'rating']);
            $table->index(['merchant_id', 'rating']);
            $table->index(['customer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};