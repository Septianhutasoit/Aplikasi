<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // TAMBAHKAN KODE INI
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    // --- Relasi Tambahan (Penting agar Admin bisa lihat siapa pengirimnya) ---

    // Relasi ke User (Pengirim ulasan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Product (Produk yang diulas)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
