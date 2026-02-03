<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'product_id',
        'start_date',
        'end_date', 
        'duration', 
        'total_price', 
        'status',
        'occasion', 
        'venue',    
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi ke Product
     * Digunakan untuk mengambil data barang yang disewa
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke User
     * Digunakan untuk mengambil data customer yang melakukan booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
