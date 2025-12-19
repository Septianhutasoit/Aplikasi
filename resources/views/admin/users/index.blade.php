@extends('admin.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Daftar Pengguna</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola data pelanggan dan administrator sistem.</p>
        </div>

        <!-- Statistik Kecil (Opsional) -->
        <div class="flex items-center gap-2 bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="text-indigo-800 font-semibold text-sm">{{ $users->total() }} User Terdaftar</span>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">

                        <!-- Nomor -->
                        <td class="px-6 py-4 text-center text-gray-400 font-mono text-sm">
                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                        </td>

                        <!-- Kolom User (Avatar + Nama) -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <!-- Logic Avatar: Ungu jika Admin, Biru jika User -->
                                @php
                                $isAdmin = $user->role === 'admin' || $user->email === 'admin@mail.com';
                                $bgColor = $isAdmin ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600';
                                @endphp

                                <div class="flex-shrink-0 h-10 w-10 rounded-full {{ $bgColor }} flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>

                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                                        {{ $user->name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        Bergabung: {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->email }}
                        </td>

                        <!-- Role Badge -->
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin' || $user->email === 'admin@gmail.com')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200 shadow-sm">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Admin
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                User
                            </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="inline-flex items-center px-3 py-1.5 border border-indigo-200 text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-md text-xs font-medium transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-lg font-medium text-gray-600">Belum ada data user</p>
                                <p class="text-sm text-gray-400">Data pengguna akan muncul di sini setelah register.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection