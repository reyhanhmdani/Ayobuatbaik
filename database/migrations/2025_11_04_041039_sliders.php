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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('gambar'); // path gambar slider
            $table->foreignId('program_id')->nullable()->constrained('program_donasi')->onDelete('set null');
            $table->string('link')->nullable(); // jika ingin link manual selain program
            $table->integer('urutan')->default(0); // untuk mengatur posisi slider
            $table->boolean('is_active')->default(true);
            $table->string('alt_text')->nullable(); // teks alternatif untuk SEO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
