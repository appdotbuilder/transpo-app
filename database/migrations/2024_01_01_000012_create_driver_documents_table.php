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
        Schema::create('driver_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('document_type', ['ktp', 'sim', 'stnk', 'skck'])->comment('Document type');
            $table->string('document_number')->comment('Document number');
            $table->string('document_image')->comment('Document image file path');
            $table->date('expiry_date')->nullable()->comment('Document expiry date');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable()->comment('Reason for rejection');
            $table->timestamp('verified_at')->nullable()->comment('Verification timestamp');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['user_id', 'document_type']);
            $table->index(['verification_status']);
            $table->unique(['user_id', 'document_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_documents');
    }
};