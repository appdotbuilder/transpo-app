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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Promotion name');
            $table->string('code')->unique()->comment('Promotion code');
            $table->text('description')->nullable()->comment('Promotion description');
            $table->enum('type', ['percentage', 'fixed_amount', 'free_delivery'])->comment('Promotion type');
            $table->decimal('discount_value', 10, 2)->comment('Discount value');
            $table->decimal('minimum_order_amount', 10, 2)->default(0)->comment('Minimum order amount');
            $table->decimal('maximum_discount_amount', 10, 2)->nullable()->comment('Maximum discount amount');
            $table->integer('usage_limit')->nullable()->comment('Total usage limit');
            $table->integer('usage_limit_per_user')->default(1)->comment('Usage limit per user');
            $table->integer('total_used')->default(0)->comment('Total times used');
            $table->json('applicable_categories')->nullable()->comment('Applicable service categories');
            $table->datetime('start_date')->comment('Promotion start date');
            $table->datetime('end_date')->comment('Promotion end date');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->timestamps();
            
            $table->index(['code', 'is_active']);
            $table->index(['start_date', 'end_date']);
            $table->index(['is_active', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};