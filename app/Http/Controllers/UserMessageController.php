<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMessageController extends Controller
{
    // Tampilkan list pesan milik user sendiri saja
    public function index()
    {
        $conversations = Conversation::where('user_id', Auth::id())
            ->latest('updated_at')
            ->get();

        return view('user.messages.index', compact('conversations'));
    }

    // Tampilkan form buat pesan baru
    public function create()
    {
        return view('user.messages.create');
    }

    // Simpan pesan baru (Buat Topik + Pesan Pertama)
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 1. Buat Conversation (Topik)
        $conversation = Conversation::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
        ]);

        // 2. Buat Message Pertama
        $conversation->messages()->create([
            'user_id' => Auth::id(),   // <--- PERBAIKAN 1: WAJIB ADA ID PENGIRIM
            'body' => $request->message,
            'is_admin_reply' => false, // Dari User
        ]);

        return redirect()->route('user.messages.index')->with('success', 'Pesan terkirim! Mohon tunggu balasan admin.');
    }

    // Lihat detail chat user
    public function show($id)
    {
        // Pastikan user hanya bisa lihat chat miliknya sendiri
        $conversation = Conversation::where('user_id', Auth::id())
            ->with('messages')
            ->findOrFail($id);

        return view('user.messages.show', compact('conversation'));
    }

    // User membalas chat
    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required']);

        $conversation = Conversation::where('user_id', Auth::id())->findOrFail($id);

        $conversation->messages()->create([
            'user_id' => Auth::id(),    // <--- PERBAIKAN 2: WAJIB ADA ID PENGIRIM
            'body' => $request->message,
            'is_admin_reply' => false,
        ]);

        $conversation->touch();

        return back()->with('success', 'Pesan terkirim!');
    }

    public function destroy($id)
    {
        // 1. Cari percakapan, pastikan milik user yang login (Security)
        $conversation = Conversation::where('user_id', Auth::id())->findOrFail($id);

        // 2. Hapus semua pesan di dalamnya dulu
        $conversation->messages()->delete();

        // 3. Hapus percakapannya
        $conversation->delete();

        // 4. Redirect kembali
        return redirect()->route('user.messages.index')->with('success', 'Percakapan berhasil dihapus.');
    }
}
                                                                