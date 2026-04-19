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
        Schema::create('sub_materis', function (Blueprint $table) {
        $table->id();
        // Relasi ke materi utama
        $table->foreignId('ruang_materi_id')->constrained('ruang_materis')->onDelete('cascade');
        
        $table->string('judul');
        $table->string('thumbnail')->nullable();
        $table->integer('urutan')->nullable(); // Bisa kosong untuk otomatis
        $table->integer('durasi')->nullable(); // Dalam menit
        
        // Slot Konten (Nullable karena tipe konten bisa bergantian)
        $table->longText('konten')->nullable(); // Untuk Trix
        $table->string('video_url')->nullable(); // Untuk YouTube
        $table->string('file_pdf')->nullable(); // Path ke file PDF
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_materis');
    }
};
