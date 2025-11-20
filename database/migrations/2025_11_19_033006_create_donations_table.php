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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_code')->unique();
            $table->unsignedBigInteger('program_donasi_id');
            $table->string('donor_name');
            $table->string('donor_phone');
            $table->string('donor_email')->nullable();
            $table->string('donation_type')->nullable();
            $table->bigInteger('amount');
            $table->text('note')->nullable();
            $table->string('snap_token')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamps();

            $table->foreign('program_donasi_id')->references('id')->on('program_donasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
