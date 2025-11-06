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
        Schema::create('program_donasi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('penggalang_id')->constrained('penggalang_dana')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_donasi')->onDelete('cascade');
            $table->bigInteger('target_amount');
            $table->bigInteger('collected_amount')->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('gambar')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->text('short_description')->nullable();
            $table->boolean('verified')->default(false);    
            $table->enum('status', ['draft', 'active', 'closed', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_donasi');
    }
};
