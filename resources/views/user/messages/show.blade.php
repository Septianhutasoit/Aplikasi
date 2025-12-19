@extends('layouts.app')

@push('styles')
<style>
    /* Layout Chat Room */
    .chat-container {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        height: 80vh;
        /* Tinggi tetap agar scrollable */
        overflow: hidden;
    }

    /* Header Chat */
    .chat-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        background: #fff;
        z-index: 10;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Area Pesan (Scrollable) */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Scrollbar cantik */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 10px;
    }

    /* Bubble Chat Umum */
    .message-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 75%;
        /* Agar tidak terlalu lebar seperti di screenshot */
    }

    .message-bubble {
        padding: 12px 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word;
        /* Mencegah teks keluar bubble */
    }

    /* Pesan Orang Lain (Admin) - Kiri */
    .message-left {
        align-self: flex-start;
    }

    .message-left .message-bubble {
        background-color: #ffffff;
        color: #333;
        border-radius: 15px 15px 15px 0;
        /* Sudut lancip di kiri bawah */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        border: 1px solid #edf2f7;
    }

    .message-left .sender-name {
        font-size: 0.75rem;
        color: #718096;
        margin-bottom: 4px;
        margin-left: 5px;
    }

    /* Pesan Kita (User) - Kanan */
    .message-right {
        align-self: flex-end;
    }

    .message-right .message-bubble {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        border-radius: 15px 15px 0 15px;
        /* Sudut lancip di kanan bawah */
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }

    .message-right .message-time {
        color: rgba(255, 255, 255, 0.7);
        text-align: right;
    }

    /* Waktu Pesan */
    .message-time {
        font-size: 0.7rem;
        margin-top: 4px;
        display: block;
    }

    .message-left .message-time {
        color: #a0aec0;
    }

    /* Footer Input */
    .chat-input-area {
        padding: 15px 20px;
        background: #fff;
        border-top: 1px solid #eee;
    }

    .chat-form {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f1f3f5;
        padding: 8px 8px 8px 20px;
        border-radius: 30px;
    }

    .chat-input {
        border: none;
        background: transparent;
        flex-grow: 1;
        outline: none;
        padding: 8px 0;
        resize: none;
        /* Hilangkan resize */
        height: 24px;
        /* Tinggi awal */
        max-height: 100px;
    }

    .btn-send {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }

    .btn-send:hover {
        transform: scale(1.1);
        background: #0b5ed7;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="chat-container">

        {{-- HEADER CHAT --}}
        <div class="chat-header">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('user.messages.index') }}" class="text-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h6 class="fw-bold mb-0 text-truncate" style="max-width: 200px;">
                        {{ $conversation->subject }}
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        @if($conversation->is_closed)
                        <span class="badge bg-secondary rounded-pill" style="font-size: 0.65rem;">Selesai</span>
                        @else
                        <span class="badge bg-success rounded-pill" style="font-size: 0.65rem;">• Aktif</span>
                        <small class="text-muted" style="font-size: 0.75rem;">Admin Online</small>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi (Optional) --}}
            <div class="dropdown">
                <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Laporkan Masalah</a></li>
                </ul>
            </div>
        </div>

        {{-- AREA PESAN (LOOPING) --}}
        <div class="chat-messages" id="chatBox">
            {{-- Pesan Awal Sistem --}}
            <div class="text-center my-3">
                <span class="badge bg-light text-secondary border fw-normal px-3 py-2 rounded-pill">
                    Percakapan dimulai {{ $conversation->created_at->format('d M Y') }}
                </span>
            </div>

            @foreach($conversation->messages as $message)

            {{-- LOGIKA BARU: Cek berdasarkan is_admin_reply --}}

            @if($message->is_admin_reply == false)

            {{-- INI PESAN USER (KANAN - BIRU) --}}
            <div class="message-wrapper message-right">
                <div class="message-bubble">
                    {{ $message->body }}
                </div>
                <span class="message-time text-muted">{{ $message->created_at->format('H:i') }}</span>
            </div>

            @else

            {{-- INI PESAN ADMIN (KIRI - PUTIH) --}}
            <div class="message-wrapper message-left">
                <span class="sender-name">Admin DelShoope</span>
                <div class="message-bubble">
                    {{ $message->body }}
                </div>
                <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
            </div>

            @endif

            @endforeach
        </div>

        {{-- FOOTER INPUT --}}
        <div class="chat-input-area">
            @if(!$conversation->is_closed)
            <form action="{{ route('user.messages.reply', $conversation->id) }}" method="POST">
                @csrf
                <div class="chat-form">
                    <input type="text" name="message" class="chat-input" placeholder="Ketik pesan Anda di sini..." autocomplete="off" required>
                    <button type="submit" class="btn-send">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            @else
            <div class="alert alert-secondary mb-0 text-center py-2 small rounded-pill">
                <i class="fas fa-lock me-1"></i> Percakapan ini telah ditutup.
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Script agar scroll otomatis ke bawah --}}
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatBox");
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endpush
@endsection