<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Index untuk filtering status
            $table->index('status', 'idx_donations_status');

            // Composite index untuk query: WHERE program_donasi_id = X AND status = Y
            $table->index(['program_donasi_id', 'status'], 'idx_donations_program_status');

            // Index untuk search donor
            $table->index('donor_email', 'idx_donations_donor_email');
            $table->index('donor_phone', 'idx_donations_donor_phone');

            // Index untuk sorting
            $table->index('status_change_at', 'idx_donations_status_change_at');
        });
        Schema::table('program_donasi', function (Blueprint $table) {
            // Index untuk filtering
            $table->index('status', 'idx_program_status');
            $table->index('featured', 'idx_program_featured');

            // Composite untuk WHERE status = X AND featured = Y
            $table->index(['status', 'featured'], 'idx_program_status_featured');

            // Index untuk sorting
            $table->index('end_date', 'idx_program_end_date');
        });
    }
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropIndex('idx_donations_status');
            $table->dropIndex('idx_donations_program_status');
            $table->dropIndex('idx_donations_donor_email');
            $table->dropIndex('idx_donations_donor_phone');
            $table->dropIndex('idx_donations_status_change_at');
        });
        Schema::table('program_donasi', function (Blueprint $table) {
            $table->dropIndex('idx_program_status');
            $table->dropIndex('idx_program_featured');
            $table->dropIndex('idx_program_status_featured');
            $table->dropIndex('idx_program_end_date');
        });
    }
};
