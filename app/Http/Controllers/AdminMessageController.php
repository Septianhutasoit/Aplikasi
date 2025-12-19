<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- 1. TAMBAHKAN INI (Wajib agar Auth::id() jalan)

class AdminMessageController extends Controller
{
    public function index()
    {
        // Tampilkan semua percakapan, urut dari yang terbaru diupdate
        $conversations = Conversation::with('user')->latest('updated_at')->get();
        return view('admin.messages.index', compact('conversations'));
    }

    public function show($id)
    {
        // Load percakapan beserta pesan-pesannya
        $conversation = Conversation::with(['messages', 'user'])->findOrFail($id);

        return view('admin.messages.show', compact('conversation'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required']);

        $conversation = Conversation::findOrFail($id);

        // Simpan pesan balasan dari Admin
        $conversation->messages()->create([
            'user_id' => Auth::id(),      // <--- 2. INI PERBAIKANNYA (Wajib ada!)
            'body' => $request->message,
            'is_admin_reply' => true,     // Menandakan ini dari admin
        ]);

        // Update waktu percakapan agar naik ke atas list
        $conversation->touch();

        return back()->with('success', 'Balasan terkirim!');
    }
}
