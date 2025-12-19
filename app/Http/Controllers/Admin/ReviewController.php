<?php

namespace App\Http\Controllers\Admin; // <--- PERHATIKAN INI HARUS ADA \Admin

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return redirect()->back()->with('success', 'Ulasan berhasil dihapus');
    }
}
