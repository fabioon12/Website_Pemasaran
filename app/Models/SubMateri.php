<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMateri extends Model
{
    protected $fillable = [
        'ruang_materi_id', 'judul', 'thumbnail', 
        'urutan', 'durasi', 'konten', 'video_url', 'file_pdf'
    ];

    // Boot method untuk urutan otomatis
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->urutan)) {
                // Cari angka urutan tertinggi di materi yang sama, lalu +1
                $model->urutan = self::where('ruang_materi_id', $model->ruang_materi_id)->max('urutan') + 1;
            }
        });
    }

    public function ruangMateri()
    {
        return $this->belongsTo(RuangMateri::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function usersSelesai()
    {
        return $this->belongsToMany(User::class, 'sub_materi_user');
    }
}
