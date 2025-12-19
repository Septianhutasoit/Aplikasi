@extends('layouts.app')

@push('styles')
<style>
    :root {
        --primary-color: #0d6efd;
        --bg-color: #f4f6f9;
        --card-hover: #f8faff;
    }

    body {
        background-color: var(--bg-color);
    }

    /* Card Utama */
    .message-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        background: #fff;
    }

    /* Header */
    .message-header {
        background: #fff;
        padding: 25px 30px;
        border-bottom: 1px solid #edf2f7;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        color: #fff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* List Item Wrapper (Ganti dari a ke div) */
    .chat-item {
        padding: 20px 30px;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease-in-out;
        display: flex;
        /* Flexbox untuk memisahkan link dan tombol hapus */
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .chat-item:last-child {
        border-bottom: none;
    }

    .chat-item:hover {
        background-color: var(--card-hover);
        transform: translateX(5px);
    }

    /* Area Link Utama (Supaya bisa diklik) */
    .chat-link-area {
        flex-grow: 1;
        text-decoration: none !important;
        color: inherit;
        display: flex;
        align-items: start;
        gap: 15px;
    }

    /* Avatar Initials */
    .chat-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #495057;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
    }

    .chat-subject {
        font-size: 1rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }

    .chat-preview {
        font-size: 0.9rem;
        color: #718096;
        line-height: 1.4;
    }

    .chat-meta {
        font-size: 0.75rem;
        color: #a0aec0;
        white-space: nowrap;
    }

    /* Badge Status */
    .status-badge {
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-closed {
        background-color: #f3f4f6;
        color: #6b7280;
    }

    /* Tombol Hapus */
    .btn-delete {
        background: none;
        border: none;
        color: #dc3545;
        /* Merah */
        opacity: 0.5;
        transition: 0.2s;
        padding: 5px;
    }

    .btn-delete:hover {
        opacity: 1;
        background-color: #ffeef0;
        border-radius: 50%;
    }

    @media (max-width: 768px) {

        .message-header,
        .chat-item {
            padding: 15px 20px;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show col-lg-10 mx-auto" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="message-card">
                {{-- HEADER --}}
                <div class="message-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box shadow-sm">
                            <i class="fas fa-inbox text-primary"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Pusat Pesan</h4>
                            <p class="text-muted mb-0 small">Riwayat percakapan dengan Admin</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('user.messages.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fas fa-plus me-2"></i> Buat Pesan
                        </a>
                    </div>
                </div>

                {{-- BODY LIST --}}
                <div class="list-group list-group-flush">
                    @forelse($conversations as $chat)

                    {{-- WRAPPER UTAMA (DIV) --}}
                    <div class="chat-item">

                        {{-- LINK AREA (Untuk Klik Detail) --}}
                        <a href="{{ route('user.messages.show', $chat->id) }}" class="chat-link-area">
                            {{-- Icon/Avatar --}}
                            <div class="chat-avatar">
                                <i class="fas fa-user"></i>
                            </div>

                            {{-- Konten Text --}}
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="chat-subject text-truncate mb-0" style="max-width: 70%;">
                                        {{ $chat->subject }}
                                    </h6>
                                    {{-- Waktu (Desktop) --}}
                                    <div class="chat-meta d-none d-sm-block">
                                        {{ $chat->updated_at->diffForHumans() }}
                                    </div>
                                </div>

                                <p class="chat-preview text-truncate mb-2">
                                    {{ $chat->messages->last()->body ?? 'Belum ada pesan...' }}
                                </p>

                                <div class="d-flex align-items-center gap-2">
                                    @if(!$chat->is_closed)
                                    <span class="status-badge status-active">
                                        <i class="fas fa-circle fa-xs me-1"></i> Aktif
                                    </span>
                                    @else
                                    <span class="status-badge status-closed">
                                        <i class="fas fa-check-circle fa-xs me-1"></i> Selesai
                                    </span>
                                    @endif

                                    {{-- Waktu (Mobile) --}}
                                    <span class="chat-meta d-block d-sm-none">
                                        • {{ $chat->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        {{-- END LINK AREA --}}

                        {{-- ACTION AREA (Tombol Hapus & Panah) --}}
                        <div class="d-flex flex-column align-items-end gap-2">

                            {{-- Form Hapus --}}
                            <form action="{{ route('user.messages.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus percakapan ini? Pesan tidak bisa dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus Percakapan">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            {{-- Panah (Desktop) --}}
                            <a href="{{ route('user.messages.show', $chat->id) }}" class="text-muted d-none d-md-block text-decoration-none small">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- END WRAPPER --}}

                    @empty
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" width="120" alt="Empty" class="mb-3 opacity-50">
                        <h5 class="fw-bold text-muted">Belum ada percakapan</h5>
                        <p class="text-muted small">Mulai percakapan baru untuk bertanya kepada admin.</p>
                        <a href="{{ route('user.messages.create') }}" class="btn btn-outline-primary rounded-pill btn-sm mt-2">
                            Mulai Chat
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 text-center">
                <a href="{{ route('user.dashboard') }}" class="text-decoration-none text-muted small fw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
@endsection