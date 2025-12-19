<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Relasi ke Order
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'address', // Pastikan ini ada
        'avatar',  // Pastikan ini ada
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ACCESSOR BARU: Mengambil URL Avatar
     * Cara panggil di blade: Auth::user()->avatar_url
     */
    public function getAvatarUrlAttribute()
    {
        // PERUBAHAN DI SINI:
        // Cukup cek apakah kolom 'avatar' ada isinya.
        // Kita hapus "Storage::disk('public')->exists(...)" karena sering error di Windows/Localhost.

        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Jika kolom avatar kosong (null), baru pakai inisial
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&color=7F9CF5&background=EBF4FF";
    }
}
