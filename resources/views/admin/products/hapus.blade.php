@extends('admin.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Data Karyawan</h2>
        <a href="{{ route('admin.employees.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah Karyawan
        </a>
    </div>

    @if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-left border-collapse">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-sm font-semibold">Nama</th>
                    <th class="px-6 py-3 text-sm font-semibold">Jabatan</th>
                    <th class="px-6 py-3 text-sm font-semibold">Tanggal Bergabung</th>
                    <th class="px-6 py-3 text-sm font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $index => $employee)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium">{{ $employee->name }}</td>
                    <td class="px-6 py-4">{{ $employee->position }}</td>
                    <td class="px-6 py-4">{{ $employee->joined_date }}</td>
                    <td class="px-6 py-4 flex justify-center space-x-2">
                        <a href="{{ route('admin.employees.edit', $employee->id) }}"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md shadow transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data karyawan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection