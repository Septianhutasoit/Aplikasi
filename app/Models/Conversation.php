<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject', 'is_closed'];

    // Relasi: Satu percakapan punya banyak pesan
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relasi: Satu percakapan dimiliki satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
