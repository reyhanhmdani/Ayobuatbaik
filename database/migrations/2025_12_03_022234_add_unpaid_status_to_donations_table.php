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
        Schema::table('donations', function (Blueprint $table) {
            DB::statement("ALTER TABLE donations MODIFY COLUMN status ENUM('unpaid', 'pending', 'success', 'failed', 'expired') DEFAULT 'unpaid'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            DB::statement("ALTER TABLE donations MODIFY COLUMN status ENUM('unpaid', 'pending', 'success', 'failed', 'expired') DEFAULT 'unpaid'");
        });
    }
};
