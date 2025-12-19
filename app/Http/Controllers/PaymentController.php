<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order; // Pastikan model Order di-import
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // 1. List pembayaran
    public function index(Request $request)
    {
        $query = Payment::with('user');

        if ($request->status) $query->where('status', $request->status);
        if ($request->payment_method) $query->where('payment_method', $request->payment_method);

        $payments = $query->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    // 2. Detail pembayaran
    public function show($id)
    {
        $payment = Payment::with('user')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    // 3. Update status pembayaran (SINKRONISASI KE ORDER)
    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,success,failed'
        ]);

        // A. Update Status di Tabel Payments
        $payment->status = $request->status;
        $payment->save();

        // B. LOGIKA SINKRONISASI KE TABEL ORDERS
        // Cari order berdasarkan order_number yang disimpan di kolom order_id payment
        $order = Order::where('order_number', $payment->order_id)->first();

        if ($order) {
            if ($request->status == 'success') {
                // Jika Admin set 'Success' (Uang diterima)
                // Maka Order otomatis jadi 'Paid' dan 'Diproses'
                $order->update([
                    'payment_status' => 'paid',
                    'order_status'   => 'diproses'
                ]);
            } elseif ($request->status == 'failed') {
                // Jika Admin set 'Failed' (Ditolak)
                // Maka Order otomatis dibatalkan
                $order->update([
                    'order_status' => 'dibatalkan'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran & pesanan berhasil diperbarui.');
    }

    // 4. Hapus pembayaran
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success', 'Data pembayaran dihapus.');
    }

    // 5. Scan barcode QRIS / COD
    public function scanBarcode($barcode)
    {
        $payment = Payment::where('barcode', $barcode)->firstOrFail();
        return response()->json($payment);
    }

    // 6. Buat pembayaran baru (Manual)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'nullable|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:qris,cod,transfer',
        ]);

        $payment = Payment::create([
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'paid_at'        => now(),       // kalau sudah dibayar
        ]);

        // Generate barcode jika metode QRIS atau COD
        if (in_array($request->payment_method, ['qris', 'cod'])) {
            $payment->barcode = Str::uuid();
            $payment->save();
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dibuat.');
    }
}
