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
            Schema::create('penggalang_dana', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->enum('tipe', ['individu', 'yayasan', 'komunitas'])->default('individu');
                $table->string('kontak')->nullable(); // opsional: no HP / email
                $table->string('foto')->nullable(); // opsional: foto profil
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggalang_dana');
    }
};
