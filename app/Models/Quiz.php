<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'sub_materi_id', 
        'pertanyaan_teks', 'pertanyaan_gambar',
        'jawaban_a_teks', 'jawaban_a_gambar',
        'jawaban_b_teks', 'jawaban_b_gambar',
        'jawaban_c_teks', 'jawaban_c_gambar',
        'jawaban_d_teks', 'jawaban_d_gambar',
        'kunci_jawaban'
    ];

    public function subMateri()
    {
        return $this->belongsTo(SubMateri::class);
    }
}
