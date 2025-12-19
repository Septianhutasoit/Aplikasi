<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    protected $casts = [
        'image' => 'array', // banyak gambar disimpan dalam JSON
    ];

    // supaya bisa dipanggil: $product->sold_count
    protected $appends = [
        'sold_count',
    ];

    /* =======================
     *  RELATIONSHIPS
     * ======================= */

    // 1 Produk milik 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 1 Produk punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 1 Produk punya banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* =======================
     *  ACCESSORS
     * ======================= */

    // Total terjual (jumlah qty dari order_items
    // yang order-nya sudah "paid")
    public function getSoldCountAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->sum('qty');  // pastikan kolom di order_items = 'qty'
    }
}
