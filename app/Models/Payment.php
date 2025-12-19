<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'payment_method',   // 'qris', 'cod', 'transfer'
        'payment_gateway',  // 'midtrans', dll
        'status',           // 'pending', 'success', 'failed'
        'barcode',          // << ini tadi tidak ada
        'receipt',          // bukti transfer
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_number');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeQris($query)
    {
        return $query->where('payment_method', 'qris');
    }
}
