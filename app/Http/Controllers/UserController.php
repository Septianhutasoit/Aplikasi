<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // List semua user (admin view)
    public function index()
    {
        // Mengambil data user terbaru dengan pagination
        $users = User::latest()->paginate(10);

        // Mengirim data ke view index user
        return view('admin.users.index', compact('users'));
    }

    // Detail user
    public function show(User $user)
    {
        // PENTING: Muat relasi 'orders' agar kita bisa menghitung total belanja
        // dan melihat riwayat pesanan di halaman detail.
        $user->load('orders');

        return view('admin.users.show', compact('user'));
    }
}
