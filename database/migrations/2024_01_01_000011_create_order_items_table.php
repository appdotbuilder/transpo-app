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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->comment('Item quantity');
            $table->decimal('unit_price', 10, 2)->comment('Unit price at time of order');
            $table->decimal('total_price', 10, 2)->comment('Total price for this item');
            $table->json('selected_variants')->nullable()->comment('Selected product variants');
            $table->text('special_instructions')->nullable()->comment('Special instructions for this item');
            $table->timestamps();
            
            $table->index(['order_id']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};