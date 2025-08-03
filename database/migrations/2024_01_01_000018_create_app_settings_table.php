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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Setting key');
            $table->text('value')->nullable()->comment('Setting value');
            $table->string('type')->default('string')->comment('Setting type: string, number, boolean, json');
            $table->text('description')->nullable()->comment('Setting description');
            $table->string('group')->default('general')->comment('Setting group');
            $table->boolean('is_public')->default(false)->comment('Whether setting is publicly accessible');
            $table->timestamps();
            
            $table->index(['key']);
            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};