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
        Schema::create('ruang_materis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique(); // Untuk URL ramah SEO
            $table->string('kategori'); // Inputan teks bebas sesuai permintaan
            $table->longText('deskripsi')->nullable(); // Menampung output HTML dari Trix Editor
            $table->string('thumbnail')->nullable(); // Menyimpan path gambar
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedBigInteger('views')->default(0); // Counter pengunjung
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang_materis');
    }
};
