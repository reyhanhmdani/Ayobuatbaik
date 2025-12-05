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
        Schema::table("program_donasi", function (Blueprint $table) {
            // Add fulltext index untuk search title dan short_description
            $table->fullText(["title", "short_description"], "ft_program_search");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("program_donasi", function (Blueprint $table) {
            $table->dropIndex("ft_program_search");
        });
    }
};
