@extends('admin.app')

@section('content')
<div class="p-6">

    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        💬 Percakapan & Konsultasi
        @if(($unreadCounts ?? 0) > 0)
        <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
            {{ $unreadCounts }} Baru
        </span>
        @endif
    </h2>

    <!-- CARD WRAPPER -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">

        <!-- RESPONSIVE TABLE -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr class="text-left text-gray-600 text-sm uppercase tracking-wide">
                        <th class="px-6 py-3">Pengguna</th>
                        <th class="px-6 py-3">Topik / Subjek</th>
                        <th class="px-6 py-3">Update Terakhir</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($conversations as $chat)
                    <tr class="hover:bg-indigo-50 transition-colors">

                        <!-- Nama User -->
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ $chat->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $chat->user->email }}</div>
                        </td>

                        <!-- Subjek Pesan -->
                        <td class="px-6 py-4 text-gray-700">
                            {{ $chat->subject }}
                        </td>

                        <!-- Waktu -->
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $chat->updated_at->format('d M Y H:i') }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($chat->is_closed)
                            <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">Selesai</span>
                            @else
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                            @endif
                        </td>

                        <!-- Tombol Balas -->
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.messages.show', $chat->id) }}"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700 transition">
                                💬 Buka Chat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            Belum ada percakapan dimulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection