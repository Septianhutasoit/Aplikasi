@extends('admin.app')

@section('content')
<div class="p-6 h-screen flex flex-col">

    <!-- HEADER CHAT -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Topik: {{ $conversation->subject }}
            </h2>
            <p class="text-sm text-gray-500">Chat dengan: {{ $conversation->user->name }}</p>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="text-gray-500 hover:text-gray-700">
            &larr; Kembali
        </a>
    </div>

    <!-- AREA CHAT (SCROLLABLE) -->
    <div class="flex-1 bg-white border border-gray-200 rounded-xl shadow-sm overflow-y-auto p-6 space-y-4" id="chatBox">

        @foreach($conversation->messages as $msg)
        @if($msg->is_admin_reply)
        <!-- Bubble Chat Admin (Kanan) -->
        <div class="flex justify-end">
            <div class="max-w-lg">
                <div class="bg-indigo-600 text-white px-4 py-2 rounded-t-lg rounded-bl-lg shadow-md">
                    <p class="text-sm">{{ $msg->body }}</p>
                </div>
                <span class="text-xs text-gray-400 mt-1 block text-right">
                    Admin • {{ $msg->created_at->format('H:i') }}
                </span>
            </div>
        </div>
        @else
        <!-- Bubble Chat User (Kiri) -->
        <div class="flex justify-start">
            <div class="max-w-lg">
                <div class="bg-gray-100 text-gray-800 px-4 py-2 rounded-t-lg rounded-br-lg shadow-sm border border-gray-200">
                    <p class="text-sm">{{ $msg->body }}</p>
                </div>
                <span class="text-xs text-gray-400 mt-1 block">
                    {{ $conversation->user->name }} • {{ $msg->created_at->format('H:i') }}
                </span>
            </div>
        </div>
        @endif
        @endforeach

    </div>

    <!-- FORM BALAS PESAN -->
    <div class="mt-4 bg-white p-4 rounded-xl shadow-lg border border-gray-200">
        <form action="{{ route('admin.messages.reply', $conversation->id) }}" method="POST" class="flex gap-3">
            @csrf

            <input type="text" name="message" required
                class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2"
                placeholder="Tulis balasan Anda disini...">

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium shadow-md transition-colors flex items-center gap-2">
                <span>Kirim</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>

</div>

<!-- Auto Scroll ke bawah -->
<script>
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection