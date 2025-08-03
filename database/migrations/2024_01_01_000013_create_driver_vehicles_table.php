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
        Schema::create('driver_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade');
            $table->string('brand')->comment('Vehicle brand');
            $table->string('model')->comment('Vehicle model');
            $table->string('year')->comment('Vehicle year');
            $table->string('color')->comment('Vehicle color');
            $table->string('plate_number')->unique()->comment('Vehicle plate number');
            $table->string('vehicle_image')->nullable()->comment('Vehicle image');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->timestamps();
            
            $table->index(['user_id', 'is_active']);
            $table->index('vehicle_type_id');
            $table->index('plate_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_vehicles');
    }
};