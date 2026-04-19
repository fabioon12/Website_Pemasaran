<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class RuangMateri extends Model
{
   use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'deskripsi',
        'thumbnail',
        'status',
        'views'
    ];

    /**
     * Otomatis membuat slug saat menyimpan judul
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($materi) {
            $materi->slug = Str::slug($materi->judul);
        });
    }

    /**
     * Scope untuk filter materi yang sudah terbit
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Helper untuk cek status
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }
    public function subMateris()
    {
        return $this->hasMany(SubMateri::class, 'ruang_materi_id');
    }
    
}
