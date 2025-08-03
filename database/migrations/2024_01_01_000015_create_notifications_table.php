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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->comment('Notification title');
            $table->text('message')->comment('Notification message');
            $table->enum('type', ['order', 'payment', 'system', 'promotion', 'document'])->comment('Notification type');
            $table->string('reference_type')->nullable()->comment('Related model type');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('Related model ID');
            $table->boolean('is_read')->default(false)->comment('Read status');
            $table->timestamp('read_at')->nullable()->comment('Read timestamp');
            $table->json('data')->nullable()->comment('Additional notification data');
            $table->timestamps();
            
            $table->index(['user_id', 'is_read', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};