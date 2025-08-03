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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('Product name');
            $table->text('description')->nullable()->comment('Product description');
            $table->string('image')->nullable()->comment('Product image');
            $table->string('category')->comment('Product category');
            $table->decimal('price', 10, 2)->comment('Regular price');
            $table->decimal('promo_price', 10, 2)->nullable()->comment('Promotional price');
            $table->boolean('is_promo_active')->default(false)->comment('Whether promo is active');
            $table->boolean('is_available')->default(true)->comment('Product availability');
            $table->integer('stock_quantity')->nullable()->comment('Stock quantity if applicable');
            $table->json('variants')->nullable()->comment('Product variants (size, extras, etc.)');
            $table->integer('preparation_time_minutes')->default(15)->comment('Preparation time in minutes');
            $table->timestamps();
            
            $table->index(['merchant_id', 'is_available']);
            $table->index(['merchant_id', 'category']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};