@extends('admin.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Detail Pembayaran</h2>
            <p class="text-gray-500 text-sm mt-1">ID Pembayaran: #{{ $payment->id }}</p>
        </div>
        <a href="{{ route('admin.payments.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KOLOM KIRI: Informasi Utama -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card Informasi Detail -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 text-lg">Informasi Transaksi</h3>
                    <span class="text-sm text-gray-500">{{ $payment->created_at->format('d M Y, H:i') }}</span>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                    <!-- User Info -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pelanggan</label>
                        <div class="flex items-center">
                            <div class="bg-blue-100 text-blue-600 rounded-full w-10 h-10 flex items-center justify-center font-bold mr-3">
                                {{ substr($payment->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-gray-900 font-medium">{{ $payment->user->name }}</p>
                                <p class="text-gray-500 text-sm">{{ $payment->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order ID -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Order ID</label>
                        <p class="text-gray-900 font-mono text-lg font-medium">#{{ $payment->order_id ?? 'N/A' }}</p>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Metode Pembayaran</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ strtoupper($payment->payment_method) }}
                        </span>
                    </div>

                    <!-- Jumlah Uang (Highlight) -->
                    <div class="col-span-2 mt-4 p-4 bg-indigo-50 rounded-lg border border-indigo-100 flex justify-between items-center">
                        <div>
                            <label class="block text-xs font-semibold text-indigo-500 uppercase tracking-wider">Total Pembayaran</label>
                            <p class="text-2xl font-extrabold text-indigo-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card Bukti Transfer (Jika Ada) -->
            @if($payment->receipt)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-700 text-lg">Bukti Transfer</h3>
                </div>
                <div class="p-6 flex justify-center bg-gray-50">
                    <img src="{{ asset('storage/'.$payment->receipt) }}"
                        alt="Bukti Transfer"
                        class="max-w-full h-auto max-h-96 rounded-lg shadow-md border border-gray-200 transition-transform hover:scale-105 duration-300 cursor-zoom-in">
                </div>
            </div>
            @endif
        </div>

        <!-- KOLOM KANAN: Status & Aksi -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Card Update Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Status & Aksi</h3>

                <!-- Display Status Badge -->
                <div class="mb-6 text-center">
                    @php
                    $statusColor = match($payment->status) {
                    'success' => 'bg-green-100 text-green-800 border-green-200',
                    'failed' => 'bg-red-100 text-red-800 border-red-200',
                    default => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    };
                    $statusIcon = match($payment->status) {
                    'success' => '<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>',
                    'failed' => '<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>',
                    default => '<svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>',
                    };
                    @endphp
                    <div class="inline-flex items-center px-4 py-2 rounded-full border {{ $statusColor }} font-bold uppercase tracking-wide text-sm">
                        {!! $statusIcon !!}
                        {{ $payment->status }}
                    </div>
                </div>

                <!-- Form Update -->
                <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <label class="block text-sm font-medium text-gray-700 mb-2">Perbarui Status</label>
                    <div class="relative">
                        <select name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border bg-white">
                            <option value="pending" {{ $payment->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="success" {{ $payment->status=='success'?'selected':'' }}>Success</option>
                            <option value="failed" {{ $payment->status=='failed'?'selected':'' }}>Failed</option>
                        </select>
                    </div>

                    <button type="submit" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Card QR Code (Khusus QRIS/COD) -->
            @php
            $method = strtolower($payment->payment_method ?? '');
            // pilih data QR: barcode kalau ada, kalau tidak pakai reference, kalau tidak pakai order_id
            $qrData = $payment->barcode ?? $payment->reference ?? $payment->order_id;
            @endphp

            @if(in_array($method, ['qris', 'cod']))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <h3 class="font-bold text-gray-700 mb-4">Kode Pembayaran</h3>

                @if($qrData)
                <div class="bg-white p-2 inline-block rounded-lg border border-gray-200">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrData) }}"
                        alt="QR Code" class="mx-auto">
                </div>

                <div class="mt-3 bg-gray-100 py-2 px-4 rounded font-mono text-sm text-gray-600 select-all">
                    {{ $qrData }}
                </div>
                <p class="text-xs text-gray-400 mt-2">Scan untuk verifikasi</p>
                @else
                <p class="text-xs text-red-500 mt-2">
                    Data QR tidak tersedia (barcode/reference/order_id kosong).
                </p>
                @endif
            </div>
            @endif


        </div>
    </div>
</div>
@endsection