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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_materi_id')->constrained('sub_materis')->onDelete('cascade');
            
            // Soal
            $table->text('pertanyaan_teks')->nullable();
            $table->string('pertanyaan_gambar')->nullable();

            // Opsi A
            $table->text('jawaban_a_teks')->nullable();
            $table->string('jawaban_a_gambar')->nullable();
            
            // Opsi B
            $table->text('jawaban_b_teks')->nullable();
            $table->string('jawaban_b_gambar')->nullable();
            
            // Opsi C
            $table->text('jawaban_c_teks')->nullable();
            $table->string('jawaban_c_gambar')->nullable();
            
            // Opsi D
            $table->text('jawaban_d_teks')->nullable();
            $table->string('jawaban_d_gambar')->nullable();

            // Kunci Jawaban
            $table->char('kunci_jawaban', 1)->default('A'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
