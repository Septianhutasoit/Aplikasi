<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CONTROLLERS ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController; // Admin Dashboard
use App\Http\Controllers\User\HomeController; // User Dashboard
use App\Http\Controllers\ReviewController;    // User Review
use App\Http\Controllers\KategoriController;  // Kategori Produk
use App\Http\Controllers\AdminOrderController; // Admin Order
use App\Http\Controllers\Admin\ReviewController as AdminReviewController; // Admin Review
use App\Http\Controllers\AdminMessageController; // Controller Pesan Admin
use App\Http\Controllers\UserMessageController;  // Controller Pesan User;

// Route

// ============================================
// 1. PUBLIC PAGE (Guest)
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->middleware('guest')->name('admin.login');

Route::get('/softwaredeveloper', function () {
    return view('footer fitur.softwaredeveloper');   // pastikan nama file view-nya sama
})->name('softwaredeveloper');

Route::get('/tentang-kami', function () {
    return view('footer fitur.tentang'); // Sesuaikan dengan nama folder view Anda
})->name('tentang');
require __DIR__ . '/auth.php';

// ============================================
// 2. USER ROUTES (Login Required)
// ============================================
Route::middleware(['auth'])->group(function () {

    // --- PROFILE USER ---
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- FITUR PESAN (USER KE ADMIN) ---
    Route::get('/my-messages', [UserMessageController::class, 'index'])->name('user.messages.index');
    Route::get('/my-messages/create', [UserMessageController::class, 'create'])->name('user.messages.create');
    Route::post('/my-messages', [UserMessageController::class, 'store'])->name('user.messages.store');
    Route::get('/my-messages/{id}', [UserMessageController::class, 'show'])->name('user.messages.show');
    Route::post('/my-messages/{id}/reply', [UserMessageController::class, 'reply'])->name('user.messages.reply');
    Route::delete('/my-messages/{id}', [UserMessageController::class, 'destroy'])->name('user.messages.destroy');

    // --- PRODUK & REVIEW ---
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // --- DASHBOARD USER (VERIFIED) ---
    Route::middleware(['verified'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
        Route::get('/kategori/{slug}', [KategoriController::class, 'index'])->name('kategori.show');
    });

    // --- KERANJANG (CART) ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // --- CHECKOUT & PEMBAYARAN ---

    // 1. BELI LANGSUNG (QRIS) dari halaman produk
    //    -> ini yang dipakai view: route('checkout.process_direct')
    Route::post('/checkout/direct', [CheckoutController::class, 'processDirectBuy'])
        ->name('checkout.process_direct');

    // 2. CHECKOUT REGULER dari keranjang
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])
        ->name('checkout.confirm');

    // 3. COD
    Route::post('/checkout/cod', [CheckoutController::class, 'processCod'])
        ->name('checkout.cod');
});

// ============================================
// 3. ADMIN ROUTES (Role: Admin)
// ============================================
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource Controllers
        Route::resource('users', UserController::class)->only(['index', 'show']);
        Route::resource('products', ProductController::class);

        // --- MANAJEMEN PESANAN ---
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');

        // --- MANAJEMEN PEMBAYARAN ---
        Route::resource('payments', PaymentController::class)->only(['index', 'show', 'destroy', 'store']);
        Route::patch('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
        Route::get('payments/scan/{barcode}', [PaymentController::class, 'scanBarcode'])->name('payments.scanBarcode');

        // --- MANAJEMEN PESAN (ADMIN) ---
        Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{id}', [AdminMessageController::class, 'show'])->name('messages.show');
        Route::post('messages/{id}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');

        // --- LAPORAN ---
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        // --- MANAJEMEN REVIEW ---
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    });
