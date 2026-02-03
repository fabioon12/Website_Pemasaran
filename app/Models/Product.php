<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'author', 'description', 'year_made', 'color', 
        'occasion', 'size_label', 'measure_bust', 'measure_waist', 
        'measure_hip', 'measure_length', 'price', 'materials', 
        'stock', 'is_published', 'images', 'wear_count'
    ];

    // Mengonversi otomatis format JSON di DB menjadi Array PHP
    protected $casts = [
        'images' => 'array',
        'is_published' => 'boolean',
        'wear_count' => 'integer',
        'price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
