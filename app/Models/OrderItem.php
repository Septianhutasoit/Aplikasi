<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'subtotal',      // pakai ini kalau benar-benar ada di tabel
        // 'product_name', // cuma aktifkan kalau ada kolomnya di DB
    ];

    protected $casts = [
        'price'    => 'integer',
        'subtotal' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

