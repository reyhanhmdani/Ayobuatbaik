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
        Schema::table('kitab_chapters', function (Blueprint $table) {
            $table->string('judul_bab')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kitab_chapters', function (Blueprint $table) {
            $table->string('judul_bab')->nullable(false)->change();
        });
    }
};
