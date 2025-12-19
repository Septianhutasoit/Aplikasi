<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // TAMBAHKAN 'user_id' KE DALAM ARRAY INI
    protected $fillable = [
        'conversation_id',
        'user_id',          // <--- INI WAJIB DITAMBAHKAN
        'body',
        'is_admin_reply'
    ];

    // Relasi: Pesan ini milik percakapan tertentu
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
