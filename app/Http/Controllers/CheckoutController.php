<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Models
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class CheckoutController extends Controller
{
    /**
     * LOGIC 1: BELI SEKARANG (DIRECT BUY) TANPA MIDTRANS
     */
    public function processDirectBuy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user     = Auth::user();
        $product  = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $grossAmount = $product->price * $quantity;
        $orderNumber = 'INV-' . time() . '-' . rand(100, 999);

        DB::transaction(function () use ($user, $product, $quantity, $grossAmount, $orderNumber) {

            // HEADER ORDER
            $order = Order::create([
                'user_id'        => $user->id,
                'order_number'   => $orderNumber,
                'total_price'    => $grossAmount,
                'order_status'   => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'QRIS Manual',
            ]);

            // DETAIL ORDER
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'qty'        => $quantity,
                'price'      => $product->price,
                'subtotal'   => $product->price * $quantity,
            ]);

            // PAYMENT (pending) – PAKAI order_number, BUKAN id
            Payment::create([
                'user_id'        => $user->id,
                'order_id'       => $orderNumber,   // ← kunci relasi ke orders.order_number
                'amount'         => $grossAmount,
                'payment_method' => 'qris',
                'status'         => 'pending',
            ]);

            // Kurangi stok
            $product->decrement('stock', $quantity);
        });

        $items = [
            [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $quantity,
                'subtotal' => $grossAmount,
            ],
        ];

        $total_bayar = $grossAmount;

        return view('checkout.qris', compact('items', 'total_bayar', 'product'))
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran via QRIS.');
    }

    /**
     * LOGIC 2: DIRECT BUY PREVIEW (opsional)
     */
    public function directBuy($id)
    {
        $product = Product::findOrFail($id);

        $items = [
            [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ],
        ];

        $total_bayar = $product->price;

        return view('checkout.qris', compact('items', 'total_bayar', 'product'));
    }

    /**
     * LOGIC 3: CHECKOUT DARI KERANJANG
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId   = Auth::id();
        $cartData = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartData->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $items       = [];
        $total_bayar = 0;

        foreach ($cartData as $item) {
            if ($item->product) {
                $subtotal     = $item->product->price * $item->quantity;
                $total_bayar += $subtotal;

                $items[] = [
                    'name'     => $item->product->name,
                    'price'    => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('checkout.qris', compact('items', 'total_bayar'));
    }

    /**
     * LOGIC 4: KONFIRMASI PEMBAYARAN MANUAL (KERANJANG → ORDER)
     */
    public function confirm(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login.');
        }

        $userId    = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        DB::transaction(function () use ($userId, $cartItems) {
            $totalBayar     = 0;
            $orderItemsData = [];

            foreach ($cartItems as $item) {
                if ($item->product) {
                    $subtotal         = $item->product->price * $item->quantity;
                    $totalBayar      += $subtotal;
                    $orderItemsData[] = [
                        'product_id' => $item->product_id,
                        'qty'        => $item->quantity,
                        'price'      => $item->product->price,
                        'subtotal'   => $subtotal,
                    ];
                }
            }

            $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            $order = Order::create([
                'user_id'        => $userId,
                'order_number'   => $orderNumber,
                'total_price'    => $totalBayar,
                'order_status'   => 'processing',
                'payment_status' => 'paid',
                'payment_method' => 'QRIS Manual',
            ]);

            foreach ($orderItemsData as $data) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $data['product_id'],
                    'qty'        => $data['qty'],
                    'price'      => $data['price'],
                    'subtotal'   => $data['subtotal'],
                ]);
            }

            // bersihkan keranjang
            Cart::where('user_id', $userId)->delete();

            // PAYMENT (success) – pakai order_number
            Payment::create([
                'user_id'        => $userId,
                'order_id'       => $orderNumber,   // ← pakai kode order
                'amount'         => $totalBayar,
                'payment_method' => 'qris',
                'status'         => 'success',
            ]);
        });

        return redirect()->route('user.dashboard')
            ->with('success', 'Pembayaran berhasil dikonfirmasi (simulasi).');
    }

    /**
     * LOGIC 5: COD
     */
    public function processCod(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cod_time'   => 'required',
            'cod_note'   => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mohon login terlebih dahulu.');
        }

        $product = Product::findOrFail($request->product_id);

        DB::transaction(function () use ($request, $product) {
            $userId      = Auth::id();
            $orderNumber = 'COD-' . strtoupper(Str::random(10));

            $newOrder = Order::create([
                'user_id'        => $userId,
                'order_number'   => $orderNumber,
                'total_price'    => $product->price,
                'order_status'   => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'COD',
                'cod_time'       => $request->cod_time,
                'cod_note'       => $request->cod_note,
            ]);

            OrderItem::create([
                'order_id'   => $newOrder->id,
                'product_id' => $product->id,
                'qty'        => 1,
                'price'      => $product->price,
                'subtotal'   => $product->price,
            ]);

            // PAYMENT (pending) – pakai order_number juga
            Payment::create([
                'user_id'        => $userId,
                'order_id'       => $orderNumber,
                'amount'         => $product->price,
                'payment_method' => 'cod',
                'status'         => 'pending',
            ]);
        });

        return view('checkout.cod', [
            'total_bayar' => $product->price,
            'waktu_cod'   => $request->cod_time,
            'catatan_cod' => $request->cod_note ?? 'Tidak ada catatan khusus',
        ]);
    }
}
