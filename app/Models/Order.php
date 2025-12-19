<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',

        'total_price',
        'total',

        'order_status',
        'payment_status',
        'status',

        'payment_method',   // boleh tetap, tapi nanti kita prioritaskan data dari payments

        'customer',
        'product',
        'quantity',
        'date',
    ];

    protected $casts = [
        'date'        => 'datetime',
        'total_price' => 'integer',
        'total'       => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // RELASI PENTING: order_number (orders) -> order_id (payments)
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_number');
    }

    public function scopeCompleted($query)
    {
        return $query->where('order_status', 'completed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
}
