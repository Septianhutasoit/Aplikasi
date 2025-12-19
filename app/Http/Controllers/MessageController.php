<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMessageController extends Controller
{
    // Menampilkan daftar chat milik User yang sedang login
    public function index()
    {
        $conversations = Conversation::where('user_id', Auth::id()) // Hanya ambil punya user ini
            ->with('messages')
            ->latest('updated_at')
            ->get();

        return view('user.messages.index', compact('conversations')); // Pastikan nama folder view benar
    }

    // Menampilkan detail chat
    public function show($id)
    {
        // Pastikan User hanya bisa lihat chat miliknya sendiri
        $conversation = Conversation::where('user_id', Auth::id())
            ->with(['messages', 'user'])
            ->findOrFail($id);

        return view('user.messages.show', compact('conversation'));
    }

    // Mengirim Balasan (REPLY)
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string' // Sesuai dengan name="message" di blade
        ]);

        $conversation = Conversation::where('user_id', Auth::id())->findOrFail($id);

        // --- BAGIAN PENTING ---
        Message::create([
            'conversation_id' => $conversation->id,
            'user_id'         => Auth::id(), // Simpan ID User yang login
            'body'            => $request->message,
            'is_admin_reply'  => false, // <--- Set FALSE agar dikenali sebagai User
        ]);
        // ----------------------

        $conversation->touch(); // Update waktu agar naik ke atas

        return back()->with('success', 'Pesan terkirim!');
    }
}
