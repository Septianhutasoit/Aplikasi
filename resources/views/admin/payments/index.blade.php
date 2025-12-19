@extends('admin.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 flex items-center justify-between">
    <span>💰Daftar Pembayaran</span>

    {{-- Link ke laporan penjualan --}}
    <a href="{{ route('admin.reports.index', ['filter' => 'today']) }}"
        class="bg-green-600 text-white px-3 py-1 rounded text-sm shadow-sm hover:bg-green-700">
        📊 Lihat Laporan Penjualan
    </a>
</h2>

{{-- Filter --}}
<form method="GET" class="flex gap-4 mb-4">
    <select name="status" class="border rounded px-2 py-1">
        <option value="">-- Semua Status --</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
        <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
        <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
    </select>

    <select name="payment_method" class="border rounded px-2 py-1">
        <option value="">-- Semua Metode --</option>
        <option value="qris" {{ request('payment_method')=='qris'?'selected':'' }}>QRIS</option>
        <option value="cod" {{ request('payment_method')=='cod'?'selected':'' }}>COD</option>
        <option value="transfer" {{ request('payment_method')=='transfer'?'selected':'' }}>Transfer</option>
    </select>

    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded">Filter</button>
</form>

<table class="min-w-full border rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">User</th>
            <th class="px-4 py-2 border">Order ID</th>
            <th class="px-4 py-2 border">Jumlah</th>
            <th class="px-4 py-2 border">Metode</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td class="px-4 py-2 border">{{ $payment->id }}</td>
            <td class="px-4 py-2 border">{{ $payment->user->name }}</td>
            <td class="px-4 py-2 border">{{ $payment->order_id ?? '-' }}</td>
            <td class="px-4 py-2 border">Rp {{ number_format($payment->amount,0,',','.') }}</td>
            <td class="px-4 py-2 border">{{ strtoupper($payment->payment_method) }}</td>
            <td class="px-4 py-2 border">
                @if($payment->status == 'pending')
                <span class="bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded">Pending</span>
                @elseif($payment->status == 'success')
                <span class="bg-green-200 text-green-800 px-2 py-0.5 rounded">Success</span>
                @else
                <span class="bg-red-200 text-red-800 px-2 py-0.5 rounded">Failed</span>
                @endif
            </td>
            <td class="px-4 py-2 border flex gap-2">
                <a href="{{ route('admin.payments.show', $payment->id) }}"
                    class="bg-blue-600 text-white px-2 py-1 rounded">
                    Detail
                </a>

                <form action="{{ route('admin.payments.destroy', $payment->id) }}"
                    method="POST"
                    onsubmit="return confirm('Hapus pembayaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $payments->links() }}
</div>
@endsection