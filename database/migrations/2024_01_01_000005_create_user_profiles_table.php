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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['customer', 'driver', 'merchant', 'agent', 'admin', 'super_admin'])->comment('User role in the system');
            $table->string('phone')->nullable()->comment('Phone number for OTP verification');
            $table->string('avatar')->nullable()->comment('User profile picture');
            $table->text('address')->nullable()->comment('User address');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Current latitude');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Current longitude');
            $table->string('firebase_token')->nullable()->comment('Firebase token for push notifications');
            $table->boolean('is_online')->default(false)->comment('Online status for drivers');
            $table->boolean('is_verified')->default(false)->comment('Account verification status');
            $table->timestamp('last_active')->nullable()->comment('Last activity timestamp');
            $table->json('metadata')->nullable()->comment('Additional profile data as JSON');
            $table->timestamps();
            
            $table->index(['role', 'is_verified']);
            $table->index(['role', 'is_online']);
            $table->index('phone');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};