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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique()->comment('Unique transaction identifier');
            $table->enum('type', ['credit', 'debit'])->comment('Transaction type');
            $table->enum('category', ['topup', 'withdraw', 'payment', 'commission', 'refund', 'bonus'])->comment('Transaction category');
            $table->decimal('amount', 15, 2)->comment('Transaction amount');
            $table->decimal('balance_before', 15, 2)->comment('Balance before transaction');
            $table->decimal('balance_after', 15, 2)->comment('Balance after transaction');
            $table->string('reference_type')->nullable()->comment('Related model type');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('Related model ID');
            $table->text('description')->nullable()->comment('Transaction description');
            $table->json('metadata')->nullable()->comment('Additional transaction data');
            $table->timestamps();
            
            $table->index(['wallet_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('transaction_id');
            $table->index(['type', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};