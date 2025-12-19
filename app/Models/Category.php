<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Nama Kategori (Cth: Baju)
        'slug',        // Link URL (Cth: baju)
        'image',       // Banner Kategori
        'description', // Penjelasan singkat
    ];

    // Relasi: 1 Kategori punya banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
