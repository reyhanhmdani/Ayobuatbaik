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
        // Tabel untuk bab-bab kitab
        Schema::create("kitab_chapters", function (Blueprint $table) {
            $table->id();
            $table->integer("nomor_bab");
            $table->string("judul_bab");
            $table->text("deskripsi")->nullable();
            $table->string("slug")->unique();
            $table->integer("urutan")->default(0);
            $table->timestamps();
        });

        // Tabel untuk maqolah-maqolah
        Schema::create("kitab_maqolah", function (Blueprint $table) {
            $table->id();
            $table->foreignId("chapter_id")->constrained("kitab_chapters")->onDelete("cascade");
            $table->integer("nomor_maqolah");
            $table->string("judul")->nullable();
            $table->text("konten")->nullable();
            $table->integer("urutan")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("kitab_maqolah");
        Schema::dropIfExists("kitab_chapters");
    }
};
