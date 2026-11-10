<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal kecuali ID
    protected $guarded = ['id']; 

    /**
     * Relasi ke tabel order_details (1 produk bisa ada di banyak detail pesanan)
     * Ini fungsi penting agar fitur "Paling Sering Dibeli" bisa berjalan!
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Relasi ke tabel categories (opsional untuk kebutuhan lain)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}