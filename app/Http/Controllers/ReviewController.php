<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // HAPUS parameter $product_id di sini
    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi product_id karena dikirim via hidden input
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            // Ambil dari request, bukan variabel parameter
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
