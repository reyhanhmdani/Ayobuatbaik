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
        Schema::create("sliders", function (Blueprint $table) {
            $table->id();
            $table->string("gambar"); // path gambar slider
            $table->integer("urutan");
            $table->string("url")->nullable(); // link manual (optional)
            $table->string("alt_text")->nullable(); // teks alternatif untuk SEO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("sliders");
    }
};
