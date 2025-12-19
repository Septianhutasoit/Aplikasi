<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Tambahkan ini jika perlu helper Str

class CartController extends Controller
{
    // 1. MENAMPILKAN KERANJANG
    public function index()
    {
        // LOGIKA BARU:
        if (Auth::check()) {
            $userId = Auth::id();
            // Ambil data keranjang beserta produknya
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();

            $cart = [];
            foreach ($cartItems as $item) {
                // --- PERBAIKAN UTAMA DISINI ---
                // Cek apakah produknya masih ada di database?
                if (!$item->product) {
                    // Jika produk sudah dihapus admin tapi masih nyangkut di keranjang user:
                    // Hapus item keranjang ini agar error hilang selamanya
                    $item->delete();
                    continue; // Lewati ke item berikutnya
                }

                // Cek apakah image array atau string (Fix error sebelumnya)
                $rawImage = $item->product->image;
                $validImage = is_array($rawImage) ? ($rawImage[0] ?? '') : $rawImage;

                $cart[$item->product_id] = [
                    "name" => $item->product->name,
                    "quantity" => $item->quantity,
                    "price" => $item->product->price,
                    "image" => $validImage
                ];
            }
        }
        // Jika User Belum Login (Guest)
        else {
            $cart = session()->get('cart', []);
        }

        return view('cart', compact('cart'));
    }

    // 2. LOGIC TAMBAH KE KERANJANG
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        // --- SKENARIO 1: USER SEDANG LOGIN (Simpan ke Database) ---
        if (Auth::check()) {
            $userId = Auth::id();

            $cartItem = Cart::where('user_id', $userId)->where('product_id', $id)->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $id,
                    'quantity' => 1
                ]);
            }
        }

        // --- SKENARIO 2: USER TAMU / GUEST (Simpan ke Session) ---
        else {
            $cart = session()->get('cart', []);

            // PERBAIKAN DISINI JUGA:
            $rawImage = $product->image;
            $validImage = is_array($rawImage) ? ($rawImage[0] ?? '') : $rawImage;

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $validImage // Simpan string, bukan array
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // 3. LOGIC HAPUS
    public function remove($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('product_id', $id)->delete();
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
    }
}
